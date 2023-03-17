<?php //connecting to the DB
$db = new PDO("mysql:host=localhost;dbname=batch19_project;charset=utf8", 'root', '');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


if ($audValid && $issValid && $expValid) { // if thes are valid
    session_start();
    // header("Location: ./view/indexView.php");
    $userEmail = $decodedToken->email; // $userEmail is the email taken from the credential & 
    $sqlEmail = $db->prepare('SELECT id, email, first_name, last_name FROM users WHERE email = ?'); // query prepare the DB to see if the user exists - asking data from the users table 
    $sqlEmail->execute([$userEmail]); // ^ asking for the id, email... info ^
    $user = $sqlEmail->fetch(PDO::FETCH_OBJ);

    if ($user) { // if $user exits 
        // echo "user exists";
        // echo "<pre>";
        print_r($user); // TODO: Save their id and names in session variables and redirect them
        $_SESSION['id'] = $user->id;
        $_SESSION['first_name'] = $user->first_name;
        $_SESSION['last_name'] = $user->last_name;
        header('location: index.php?action=userProfile');
        exit;
    } else {
        // if user doesn't exist, prepare an INSERT query // TODO: If they are NOT in the DB, insert them [firstname, lastname, email, profile photo];
        $insertUser = 'INSERT INTO users (first_name, last_name, email, profile_picture, login_type) VALUES (:inFirst_name, :inLast_name, :inEmail, :inProfile_picture, 0)';
        $req = $db->prepare($insertUser);
        // your value is the decodedToken from the JSon and -> selecting the specific title from there
        $req->bindParam('inFirst_name',  $decodedToken->given_name,  PDO::PARAM_STR);
        $req->bindParam('inLast_name',  $decodedToken->family_name,  PDO::PARAM_STR);
        $req->bindParam('inEmail',  $decodedToken->email,  PDO::PARAM_STR);
        $req->bindParam('inProfile_picture',  $decodedToken->picture,  PDO::PARAM_STR); // (token, value ,type)               
        $req->execute();
        echo 'user has been added successfully';
    }
    header('location: index.php?action=userProfile'); // TODO: redirect
} else {
    $msg = "invalid login";
    echo "aud:" . $audValid;
    echo '<br>';
    echo "iss:" . $issValid;
    echo '<br>';
    echo "exp:" . $expValid;
    header('location:index.php?error=' . urlencode($msg));
    exit();
}

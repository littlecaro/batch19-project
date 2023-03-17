<!-- CONTROLLER - connects database (model) and view -->
<?php

require "./model/UserManager.php";

function showIndex()
{
    require("./view/indexView.php");
}

function checkUserSignInGoogle($decodedToken)
{
    // print_r($decodedToken); //verifying Google ID tokens using terneries
    $audValid = $decodedToken->aud === "51328436247-5obpti781ob31s4h56bsbatespmjpoe2.apps.googleusercontent.com" ? true : false;
    $issValid = $decodedToken->iss === "https://accounts.google.com" ? true : false;
    $expValid = $decodedToken->exp > time() ? true : false;
    if ($audValid && $issValid && $expValid) { // if they are valid

        session_start();
        $userEmail = $decodedToken->email; // $userEmail is the email taken from the credential json file 
        $userManager = new UserManager();

        $user = $userManager->getUserByEmail($userEmail);

        if ($user) { // if $user exits // echo "user exists"; // echo "<pre>";
            // Save their id and names in session variables and redirect them
            $_SESSION['id'] = $user->id;
            $_SESSION['first_name'] = $user->first_name;
            $_SESSION['last_name'] = $user->last_name;
            header('location: index.php?action=userProfile');
            exit;
        } else {
            // if user doesn't exist, prepare an INSERT query // If they are NOT in the DB, insert them [firstname, lastname, email, profile photo];
            $firstName = $decodedToken->given_name;
            $lastName = $decodedToken->family_name;
            $email = $decodedToken->email;
            $picture = $decodedToken->picture;
            $result = $userManager->insertUserGoogle($firstName, $lastName, $email, $picture);
            if (!$result) {
                throw new Exception("Cannot add user.");
            }
            echo 'user has been added successfully';
        }
        header('location: index.php?action=userProfile'); // redirect
        exit;
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
}

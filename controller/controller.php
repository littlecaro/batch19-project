<?php
require_once ("./model/UserManager.php");

require_once "./model/UserManager.php";

require_once "./model/model.php";

// function showIndex()
// {
//     require("./view/indexView.php");
// }

function showIndex()
{
    $chats = loadChats(); // TODO: move this to signed in view
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

function userSignUp($firstName, $lastName, $email, $pwd, $pwd2){
    //validate data
    $firstNameValid = preg_match("/^[a-z._]+$/", $firstName);
    $lastNameValid = preg_match("/^[a-z._]+$/", $lastName);
    $pwdValid = preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4,16}$/", $pwd);
    $pwd2Valid  = $pwd === $pwd2;
    $emailValid = preg_match("/^[a-z0-9_.@]{3,20}$/i", $_POST['email']);
    
    if ($firstNameValid AND $lastNameValid AND $emailValid AND $pwdValid AND $pwd2Valid){
        //if data good, insert into database w model function
        $userManager = new UserManager();
        $users = $userManager->insertUser($firstName, $lastName, $email, $pwd);
        require "./view/signUpView.php";
    } else{
        $msg = "Please fill in all inputs.";
        require "./view/signUpView.php";
    }
}

function userSignIn($email, $pwd){
    //check if user exists
    $userManager = new UserManager();
    $user = $userManager->signInUser($email, $pwd);
    
    if (!$user){
        throw new Exception("Invalid Information");
    }else{
        //if data good, allow sign in
        header("index.php"); //TODO: change header location
    }
}
function showUserSignUp(){
    require "./view/signUpView.php";
}

function showUserSignIn(){
    require "./view/signInView.php";
}

function showChats()
{
    $chats = loadChats();
    require("./view/messageView.php");
}

function showMessages($conversationId)
{
    $messages = getMessages($conversationId);
    if ($messages) {
        foreach ($messages as $message) {
            require "view\components\messageCard.php";
        }
    }
    // Set the response headers
    // header('Content-Type: application/json');

    // // Return the response data as JSON
    // echo json_encode($messages);
}
function addMessage($conversationId, $senderId, $message)
{
    // echo "controller start";
    submitMessage($conversationId, $senderId, $message);
}
function searchMessages($term)
{
    $chats = searchMessagesGet($term);
    if (!empty($chats)) {
        foreach ($chats as $chat) {
            include('./view/components/chatCard.php');
        }
    }
}

<!-- CONTROLLER - connects database (model) and view -->
<?php
require ("./model/UserManager.php");

function showIndex(){
    require("./view/indexView.php");
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
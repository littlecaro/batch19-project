<?php
// ROUTER

require("./controller/controller.php");

try{
    $action = $_REQUEST['action'] ?? null;
    
    switch ($action){
        case "userSignUpView":
            //call a contrl
            showUserSignUp();
            break;
        case "userSignInView":
            showUserSignIn();
            break;
        case "userSignUp":
            //make sure data exists

            $firstName = !empty($_POST['firstName']) ? $_POST['firstName'] : null;
            $lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : null;
            $email = !empty($_POST['email']) ? $_POST['email'] : null;
            $pwd = !empty($_POST['pwd']) ? $_POST['pwd'] : null;
            $pwd2 = !empty($_POST['pwdconf']) ? $_POST['pwdconf'] : null;

            if ($firstName AND $lastName AND $email AND $pwd AND $pwd2){
                //call a controller function
                userSignUp($firstName, $lastName, $email, $pwd, $pwd2);
            }
            break;

        case "userSignIn":
            //make sure data is set
            $email = isset($_POST['email']);
            $pwd = isset($_POST['pwd']);

            if ($email AND $pwd){
                //call a controller function
                userSignIn($email, $pwd);
            }
            break;

        default:
            showIndex();
            break;
    }
} catch (Exception $e){
    $errorMsg = $e->getMessage();
    require ("./view/errorView.php");
}
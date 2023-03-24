<?php


require_once('./model/CalendarManager.php');

require_once("./model/UserManager.php");
require_once("./model/CompanyManager.php");


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

        $userEmail = $decodedToken->email; // $userEmail is the email taken from the credential json file 
        $userManager = new UserManager();

        $user = $userManager->getUserByEmail($userEmail);

        if (!$user) {
            // if user doesn't exist, prepare an INSERT query // If they are NOT in the DB, insert them [firstname, lastname, email, profile photo];
            $firstName = $decodedToken->given_name;
            $lastName = $decodedToken->family_name;
            $email = $decodedToken->email;
            $picture = $decodedToken->picture;
            $result = $userManager->insertUserGoogle($firstName, $lastName, $email, $picture);
            $user = $userManager->getUserByEmail($userEmail);

            // add user into users, prof_exp, education & skills 
            if (!$result) {
                throw new Exception("Cannot add user.");
            }
        }
        // Save their id and names in session variables and redirect them
        $_SESSION['id'] = $user->id;
        $_SESSION['first_name'] = $user->first_name;
        $_SESSION['last_name'] = $user->last_name;
        $_SESSION['email'] = $userEmail;

        header("Location: index.php?action=userProfileView");
        exit;
    } else {
        // $msg = "invalid login";
        // echo "aud:" . $audValid;
        // echo '<br>';
        // echo "iss:" . $issValid;
        // echo '<br>';
        // echo "exp:" . $expValid;
        // header('location:index.php?error=' . urlencode($msg));
        // exit();
        throw new Exception("invalid login");
    }
}

function userSignUp($firstName, $lastName, $email, $pwd, $pwd2)
{
    //validate data
    $firstNameValid = preg_match("/^[a-z._]+$/", $firstName);
    $lastNameValid = preg_match("/^[a-z._]+$/", $lastName);
    $pwdValid = preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4,16}$/", $pwd);
    $pwd2Valid  = $pwd === $pwd2;
    $emailValid = preg_match("/^[a-z0-9_.@]{3,20}$/i", $_POST['email']);

    if ($firstNameValid and $lastNameValid and $emailValid and $pwdValid and $pwd2Valid) {
        //if data good, insert into database w model function
        $userManager = new UserManager();
        $users = $userManager->insertUser($firstName, $lastName, $email, $pwd);
        require "./view/signUpView.php";
    } else {
        $msg = "Please fill in all inputs.";
        require "./view/signUpView.php";
    }
}

function userSignIn($email, $pwd)
{
    //check if user exists
    $userManager = new UserManager();

    $user = $userManager->getUserByEmail($email);

    //verify the password and then start a session
    if ($user and password_verify($pwd, $user->password)) {
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $user->id;
        $_SESSION['first_name'] = $user->first_name;
        $_SESSION['last_name'] = $user->last_name;
        header("Location: index.php?action=userProfile");
        exit;
    } else {
        throw new Exception("Invalid Information");
    }

    $user = $userManager->signInUser($email, $pwd);

    if (!$user) {
        throw new Exception("Invalid Information");
    } else {
        //if data good, allow sign in

        header("index.php"); //TODO: change header location
        exit;
    }
}

function showUserSignUp()
{
    require "./view/signUpView.php";
}

function showUserSignIn()
{
    require "./view/signInView.php";
}


// function userProfile()
// {
//     require "./view/userProfileView.php";
// }

// function userProfilePage1()
// {
//     $userProfileManager = new UserProfileManager();
//     $user = $userProfileManager->showUserProfileView();
//     require "./view/userProfilePage1.php";
// }

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

function addCalendar($data)
{
    for ($i = 0; $i < count($data); $i++) {
        $date = strip_tags($data[$i]['date']);
        $time = strip_tags($data[$i]['time']);

        $CalendarManager = new CalendarManager();
        $result = $CalendarManager->insertCalendar($date, $time);
        if (!$result) {
            throw new Exception("Unable to add entries");
        }
        header("location: index.php?action=loadCalendar");
    }
}

function deleteCalendarEntry($entry)
{
    for ($i = 0; $i < count($entry); $i++) {
        $date = strip_tags($entry[$i]['date']);
        $time = strip_tags($entry[$i]['time']);

        $CalendarManager = new CalendarManager();
        $result = $CalendarManager->updateDeletion($date, $time);
        if (!$result) {
            throw new Exception("Unable to delete entry");
        }
        header("location: index.php?action=loadCalendar");
    }
}

function showCalendar($user_id)
{
    $CalendarManager = new CalendarManager();
    $result = $CalendarManager->loadCalendar($user_id);
    require('./view/calendarView.php');
}

function showUserProfileView()
{
    $userManager = new UserManager();
    $user = $userManager->getUserProfile($_SESSION['id']);
    $experience = $userManager->getUserExperience($_SESSION['id']);
    // $education = $userManager->getUserEducation($_SESSION['id']);
    $skills = $userManager->getUserSkills($_SESSION['id']);
    // $experience = $userManager->getUserExperience($_SESSION['id']);
    require("./view/userProfileView.php");
}

function createJobForm()
{
    $userManager = new UserManager();
    $cities = $userManager->getCitiesList();
    require("./view/addNewJobView.php");
}

function addNewJob($jobTitle, $jobStory, $salaryMin, $salaryMax, $cities, $deadline)
{
    $salaryMin = trim($salaryMin, "₩M");
    $salaryMax = trim($salaryMax, "₩M");

    $cities = explode("|", $cities)[1]; // seoul|142 => ["seoul", "142"]
    $cities = (int)$cities;

    $companyManager = new CompanyManager();
    $result = $companyManager->insertNewJob($jobTitle, $jobStory, $salaryMin, $salaryMax, $cities, $deadline);
    if ($result) {
        // TODO: finish this bish!
        echo "Success! New job created. Get your tax money";
    } else {
        echo "FAIL!!! U DUN MESSED UP";
    }
}

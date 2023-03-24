<?php


require_once('./model/calendarManager.php');

require_once("./model/UserManager.php");


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
            $_SESSION['email'] = $userEmail;

            // header('location: index.php?action=userProfile');
            require "./view/userProfile.php";
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
        // header('location: index.php?action=userProfile'); // redirect
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
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $user->id;
        $_SESSION['first_name'] = $user->first_name;
        $_SESSION['last_name'] = $user->last_name;
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
//     require "./view/userProfile.php";
// }

function userProfilePage1()
{
    $userProfileManager = new UserProfileManager();
    $user = $userProfileManager->showUserProfile();
    require "./view/userProfilePage1.php";
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
        } //TODO:Limit messages
    }
}

function addCalendar($data)
{
    for ($i = 0; $i < count($data); $i++) {
        $date = strip_tags($data[$i]['date']);
        $hour = strip_tags($data[$i]['hour']);

        $calendarManager = new CalendarManager();
        $result = $calendarManager->insertCalendar($date, $hour);
        if (!$result) {
            throw new Exception("Unable to add entries");
        }
        header("location: index.php?action=loadCalendar");
    }
}

function showCalendar($user_id)
{
    $calendarManager = new CalendarManager();
    $result = $calendarManager->loadCalendar($user_id);
    require('./view/calendarView.php');
}
function showTalents($filter = false)
{ //TODO:improve flow of loop
    ob_start();
    if (!$filter) {
    }
    $allTalents = getAllTalents();
    // print_r($allTalents);
    if (!empty($allTalents)) {
        foreach ($allTalents as $talentID => $key) {
            $yearsExperience = getTalentYearsExperience($key->id);
            $skills = getTalentSkills($key->id);
            $talentInfo = getTalentInfo($key->id);
            $desiredPositions = getTalentDesiredPosition($key->id);
            $highestDegree = getTalentHighestDegree($key->id);
            $talentLanguages = getTalentLanguages($key->id);
            if ($filter) {
                // ob_start();
                $rating = talentRating($key->id, $yearsExperience[0]->years_experience1, $skills, $desiredPositions, $highestDegree, $talentLanguages);

                include('./view/components/talentCard.php'); //TODO:Limit talent cards
                $talentCard = ob_get_contents();
                $id = $key->id;
                $CandidateRatingData[$key->id] = $talentCard;
                $scale[$key->id] = $rating;
                ob_clean();
                // echo $talentCard;
                // echo $key->id;
            } else {
                include('./view/components/talentCard.php');
            }
        }
    }
    if (!$filter) {
        $talentCards = ob_get_clean();
        require('./view/filterView.php');
    } else {
        ob_end_clean();
        // print_r($scale);
        arsort($scale);
        // print_r($scale);
        // print_r($CandidateRatingData);
        foreach ($scale as $key => $value) {
            // echo $key;
            echo $CandidateRatingData[$key];
        }

        // ob_end_clean();
        // echo "test";
        parseTalentFilter();
    }
}
function loadTalentCards()
{
    require("./view/filterView.php");
}
function parseTalentFilter()
{
    $filteredYearsMin = (int)$_GET["yearsMin"] ?? null;
    // echo $filteredYearsMin . "bteeee";
    $filteredYearsMax = (int)$_GET["yearsMax"] ?? null;
    $filteredSkills = explode(",", $_GET["skills"]) ?? null;
    $filteredDesiredPositions = explode(",", $_GET["desiredp"]) ?? null;
    $filteredHighestDegrees = explode(",", $_GET["degrees"]) ?? null;
    $filteredLanguages = explode(",", $_GET["languages"]) ?? null;
    $arr = array(
        'filteredYearsMin' => $filteredYearsMin,
        'filteredYearsMax' => $filteredYearsMax,
        'filteredSkills' => $filteredSkills,
        'filteredDesiredPositions' => $filteredDesiredPositions,
        'filteredHighestDegrees' => $filteredHighestDegrees,
        'filteredLanguages' => $filteredLanguages,

    );
    $arr = json_encode($arr);
    saveTalentFilter($arr);
}
function talentRating($id, $yearsExperience, $skills, $desiredPositions, $highestDegree, $language)
{   //TODO:Case for any tags
    //TODO:add filter for city]
    $score  = 1;
    $filteredYearsMin = (int)$_GET["yearsMin"] ?? null;
    // echo $filteredYearsMin . "bteeee";
    $filteredYearsMax = (int)$_GET["yearsMax"] ?? null;
    $filteredSkills = explode(",", $_GET["skills"]) ?? null;
    $filteredDesiredPositions = explode(",", $_GET["desiredp"]) ?? null;
    $filteredHighestDegrees = explode(",", $_GET["degrees"]) ?? null;
    $filteredLanguages = explode(",", $_GET["languages"]) ?? null;
    // echo $filteredYearsMax;
    if (is_numeric($filteredYearsMax) and is_numeric($filteredYearsMin)) {
        // echo "starting";
        if ($yearsExperience > $filteredYearsMin && $yearsExperience < $filteredYearsMax) {
            $score = $score * 1;
            // echo "test";
        } else if ($yearsExperience < $filteredYearsMin) {
            // echo "test2";

            $score = $score * (1 / (1 + ($filteredYearsMin - $yearsExperience) / 10));
        } else if ($yearsExperience > $filteredYearsMax) {
            // echo "test3" . $yearsExperience;
            // echo $yearsExperience - $filteredYearsMax;
            $score = $score * (1 / (1 + ($yearsExperience - $filteredYearsMax) / 10));
        }
    }
    if (!empty($filteredSkills)) {
        $ratings = array();
        foreach ($filteredSkills as $key => $value) {
            foreach ($skills as $twoKey => $twoValue) {
                $sim = similar_text($value, $twoValue->skills_fixed, $perc);
                // echo $twoValue->skills_fixed;
                // echo $perc;
                if ($perc > 50) {
                    array_push($ratings, $perc / 100);
                }
            }
        }
        $tmp = array_filter($ratings);
        // print_r($tmp);
        // echo $tmp;
        if (empty($tmp)) {
            $score = $score - 0.2;
        } else {
            $tmp = array_product($ratings);
            $score = $score * $tmp + 0.2;
        }
    }
    if (!empty($filteredDesiredPositions)) {
        $ratings = array();
        foreach ($filteredDesiredPositions as $key => $value) {
            foreach ($desiredPositions as $twoKey => $twoValue) {
                $sim = similar_text($value, $twoValue->desired_position, $perc);
                // echo $perc;
                if ($perc > 50) {
                    array_push($ratings, $perc / 100);
                }
            }
        }
        $tmp = array_filter($ratings);;
        // print_r($tmp);
        if (empty($tmp)) {
            $score = $score - 0.2;
        } else {
            // echo $score;
            $tmp = array_product($ratings);
            // echo $tmp;
            $score = $score * $tmp + 0.2;
        }
    }
    if (!empty($filteredHighestDegrees)) {
        $ratings = array();
        foreach ($filteredHighestDegrees as $key => $value) {
            foreach ($highestDegree as $twoKey => $twoValue) {
                $sim = similar_text($value, $twoValue->highestDegree, $perc);
                if ($perc > 50) {
                    array_push($ratings, $perc / 100);
                }
            }
        }
        $tmp = array_filter($ratings);;
        // print_r($tmp);
        if (empty($tmp)) {
            $score = $score - 0.2;
        } else {
            $tmp = array_product($ratings);
            $score = $score * $tmp + 0.2;
        }
    }
    if (!empty($filteredLanguages)) {
        $ratings = array();
        foreach ($filteredLanguages as $key => $value) {
            foreach ($language as $twoKey => $twoValue) {
                $sim = similar_text($value, $twoValue->language, $perc);
                if ($perc > 50) {
                    array_push($ratings, $perc / 100);
                }
            }
        }
        $tmp = array_filter($ratings);
        if (empty($tmp)) {
            $score = $score - 0.2;
        } else {
            $tmp = array_product($ratings);
            $score = $score * $tmp + 0.2;
        }
    }


    return $score;
}

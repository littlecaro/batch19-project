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
        $user = $userManager->insertUser($firstName, $lastName, $email, $pwd);
        if ($user) {
            //create a session for when the user is logged in
            $_SESSION['id'] = $user->user_id;
            $_SESSION['first_name'] = $user->first_name;
            $_SESSION['last_name'] = $user->last_name;
            print_r($_SESSION);
        } else {
            echo "Something went wrong.";
        }
        require "./view/signUpView.php";
    } else {
        $msg = "Please fill in all inputs.";
        require "./view/signUpView.php";
    }
}

// ======================================
// BLACKLIST
// grab the input email address
// split the email on the @ symbol
// const domain = email.split('@')[1];
// loop through the blacklist
// check if anything after the @
// matches an entry in the blacklist
// ======================================

function companySignUp($firstName, $lastName, $email, $pwd, $pwd2, $companyName, $companyTitle)
{
    $firstNameValid = preg_match("/^[a-z]+$/i", $firstName);
    $lastNameValid = preg_match("/^[a-z]+$/i", $lastName);
    $pwdValid = preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4,16}$/", $pwd);
    $pwd2Valid  = $pwd === $pwd2;

    require_once("./controller/blacklist.php");

    //split @ sign
    $domain = explode('@', $email)[1];
    //set emailValid as true and in loop set it as false
    $emailValid = true;

    foreach ($blacklist as $spamEmail) {
        if (str_starts_with($domain, $spamEmail)) {
            $emailValid = false;
            break;
        }
    }
    if ($firstNameValid and $lastNameValid and $emailValid and $pwdValid and $pwd2Valid and $companyName and $companyTitle) {
        //if data good, insert into database w model function
        $userManager = new UserManager();
        $user = $userManager->insertCompanyUser($firstName, $lastName, $email, $pwd, $companyName, $companyTitle);
        if ($user) {
            //create a session for when the company is logged in
            $_SESSION['id'] = $user->user_id;
            $_SESSION['first_name'] = $user->first_name;
            $_SESSION['last_name'] = $user->last_name;
            $_SESSION['company_id'] = $user->company_id;
            print_r($_SESSION);
        } else {
            echo "Something went wrong.";
        }
        // require "./view/signUpView.php";
    } else {
        $msg = "Please fill in all inputs.";
        echo "something was invalid.";
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
        $_SESSION['company_id'] = $user->company_id;
        $companyManager = new CompanyManager();
        $companyInfo = $companyManager->fetchCompanyInfo();
        echo $user->company_id;
        $_SESSION['company_id'] = $companyInfo->id;
        $_SESSION["profile_pic"] = $companyInfo->logo_img;
        $_SESSION["company_name"] = $companyInfo->name;
        $_SESSION["company_title"] = $user->user_bio;
        $_SESSION["date_created"] = $companyInfo->date_created;
        if ($_SESSION["company_id"] != null) {
            header("Location: index.php?action=companyDashboard");
        } else {
            header("Location: index.php?action=userProfileView");
        }
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
        } //TODO:Limit messages
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

// function showCalendar($user_id)
// {
//     $calendarManager = new CalendarManager();
//     $entries = $calendarManager->loadCalendar($user_id);
//     $receives = $calendarManager->loadInterviews($user_id);
//     require("./view/userProfileView.php");
// }

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

function showTalents($filter, $saveData)
{ //TODO:improve flow of loop
    // echo $filter;
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
            $talentLocation = getTalentLocation($key->id);
            // print_r($talentLocation);
            if ($filter) {
                // ob_start();
                $rating = talentRating($key->id, $yearsExperience[0]->years_experience1, $skills, $desiredPositions, $highestDegree, $talentLanguages, $talentLocation[0], $saveData);

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
        // ob_end_clean();
        // print_r($scale);
        arsort($scale);
        // print_r($scale);
        // print_r($CandidateRatingData);
        foreach ($scale as $key => $value) {
            // echo $key;
            echo $CandidateRatingData[$key];
        }
        // print_r($saveData);
        $talentCards = ob_get_clean();
        $saveData =  json_encode($saveData);
        require('./view/filterView.php');


        // echo "test";
        if (empty($saveData)) {
            // parseTalentFilter();
        }
    }
}

function loadTalentCards()
{
    require("./view/filterView.php");
}
function parseTalentFilter()
{
    if (!empty($savedData)) {
    } else {

        $filteredYearsMin = (int)$_GET["yearsMin"] ?? null;
        // echo $filteredYearsMin . "bteeee";
        $filteredYearsMax = (int)$_GET["yearsMax"] ?? null;
        $filteredSkills = explode(",", $_GET["skills"]) ?? null;
        $filteredDesiredPositions = explode(",", $_GET["desiredp"]) ?? null;
        $filteredHighestDegrees = explode(",", $_GET["highestDegree"]) ?? null;
        $filteredLanguages = explode(",", $_GET["languages"]) ?? null;
        $filteredTalentlocation = $_GET["locations"] ?? null;
        $jobId = $_GET["jobId"] ?? null;
    }
    $arr = array(
        'filteredYearsMin' => $filteredYearsMin,
        'filteredYearsMax' => $filteredYearsMax,
        'filteredSkills' => $filteredSkills,
        'filteredDesiredPositions' => $filteredDesiredPositions,
        'filteredLocation' => $filteredTalentlocation,
        'filteredHighestDegrees' => $filteredHighestDegrees,
        'filteredLanguages' => $filteredLanguages,

    );
    $arr = json_encode($arr);
    saveTalentFilter($arr, $jobId);
}
function updateSavedTalentSearch($data, $jobId)
{
    $user_id = 1;
    $filteredYearsMin = (int)$_GET["yearsMin"] ?? null;
    // echo $filteredYearsMin . "bteeee";
    $filteredYearsMax = (int)$_GET["yearsMax"] ?? null;
    $filteredSkills = explode(",", $_GET["skills"]) ?? null;
    $filteredDesiredPositions = explode(",", $_GET["desiredp"]) ?? null;
    $filteredHighestDegrees = explode(",", $_GET["highestDegree"]) ?? null;
    $filteredLanguages = explode(",", $_GET["languages"]) ?? null;
    $filteredTalentlocation = $_GET["locations"] ?? null;


    $arr = array(
        'filteredYearsMin' => $filteredYearsMin,
        'filteredYearsMax' => $filteredYearsMax,
        'filteredSkills' => $filteredSkills,
        'filteredDesiredPositions' => $filteredDesiredPositions,
        'filteredLocation' => $filteredTalentlocation,
        'filteredHighestDegrees' => $filteredHighestDegrees,
        'filteredLanguages' => $filteredLanguages,

    );
    print_r($arr);
    echo "<br>";
    echo "array";
    $arr = json_encode($arr);
    updateTalentFilter($arr, $user_id, $jobId);
}
function talentRating($id, $yearsExperience, $skills, $desiredPositions, $highestDegree, $language, $location, $saveData)
{   //TODO:Case for any tags
    //TODO:add filter for city
    $score  = 1;
    if (empty($saveData)) {
        $filteredYearsMin = (int)$_GET["yearsMin"] ?? null;
        // echo $filteredYearsMin . "bteeee";
        $filteredYearsMax = (int)$_GET["yearsMax"] ?? null;
        $filteredSkills = explode(",", $_GET["skills"]) ?? null;
        $filteredTalentlocation = $_GET["talentlocation"] ?? null;
        $filteredDesiredPositions = explode(",", $_GET["desiredp"]) ?? null;
        $filteredHighestDegrees = explode(",", $_GET["highestDegree"]) ?? null;
        $filteredLanguages = explode(",", $_GET["languages"]) ?? null;
    } else {
        // print_r($saveData);
        $filteredYearsMin = $saveData->filteredYearsMin;
        $filteredTalentlocation = $saveData->filteredLocation;
        $filteredYearsMax = $saveData->filteredYearsMax;
        $filteredSkills = $saveData->filteredSkills;
        $filteredDesiredPositions = $saveData->filteredDesiredPositions;
        $filteredHighestDegrees = $saveData->filteredHighestDegrees;
        $filteredLanguages = $saveData->filteredLanguages;
    }
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
    } //TODO: Location cannot be easily implemented without checking country
    // if (!empty($filteredTalentlocation)) {
    //     $ratings = array();
    //     $sim = similar_text($filteredTalentlocation, $location->location, $perc);
    //     // echo $twoValue->skills_fixed;
    //     // echo $perc;
    //     if ($perc > 50) {
    //         array_push($ratings, $perc / 100);
    //     }


    //     $tmp = array_filter($ratings);
    //     // print_r($tmp);
    //     // echo $tmp;
    //     if (empty($tmp)) {
    //         $score = $score - 0.2;
    //     } else {
    //         $tmp = array_product($ratings);
    //         $score = $score * $tmp + 0.2;
    //     }
    // }
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

    if ($score < 0) {
        $score = 0;
    }
    return $score;
}

function showUserProfileView()
{
    $userManager = new UserManager();
    $user = $userManager->getUserProfile($_SESSION['id']);
    $experience = $userManager->getUserExperience($_SESSION['id']);
    $education = $userManager->getUserEducation($_SESSION['id']);
    $skills = $userManager->getUserSkills($_SESSION['id']);
    $cityName = $userManager->getCityName($user->city_id);
    // $educationLevel = $userManager->getEducationLevel($education->degree_level);
    $allSkills = $userManager->getSkillsList();
    $allLanguages = $userManager->getLanguagesList();
    $allCities = $userManager->getCitiesList();
    $calendarManager = new CalendarManager();
    $entries = $calendarManager->loadCalendar($_SESSION['id']);
    $receives = $calendarManager->loadInterviews($_SESSION['id']);
    // $experience = $userManager->getUserExperience($_SESSION['id']);
    require("./view/userProfileView.php");
}


function updateUserPersonal($id, $phoneNb, $city, $salary, $visa)
{
    $userManager = new UserManager();
    $wasPersonalUpdated = $userManager->updateUserPersonal($id, $phoneNb, $city, $salary, $visa);
    // echo $wasEducationUpdated;
    if ($wasPersonalUpdated) {
        echo "Successfully Updated";
    } else {
        echo "Something went wrong.";
    }
}

function updateUserEducation($userId, $degree, $degreeLevel)
{

    $userManager = new UserManager();
    $wasEducationUpdated = $userManager->updateUserEducation($userId, $degree, $degreeLevel);
    // echo $wasEducationUpdated;
    if ($wasEducationUpdated === 1) {
        echo "Successfully Updated";
    } else {
        echo "Something went wrong.";
    }
}

function updateUserExperience($jobTitle, $yearsExperience, $companyName, $userId)
{

    $userManager = new UserManager();
    $wasExperienceUpdated = $userManager->updateUserExperience($jobTitle, $yearsExperience, $companyName, $userId);
    echo $wasExperienceUpdated;
    // if ($wasExperienceUpdated === 1) {
    //     echo "Successfully Updated";
    // } else {
    //     echo "Something went wrong.";
    // }
}
function updateUserSkills($skillsString, $userId)
{
    $userManager = new UserManager();
    $skillsArray = explode('&', $skillsString);
    // echo $skillsArray;
    foreach ($skillsArray as $skill_item) {
        $skill_id = explode('|', $skill_item)[1];
        $wasSkillsUpdated = $userManager->updateUserSkills($skill_id, $userId);
    }
    echo $wasSkillsUpdated;
}
function updateUserLanguages($languagesString, $userId)
{
    $userManager = new UserManager();
    $languagesArray = explode('&', $languagesString);
    foreach ($languagesArray as $language_item) {
        $language_id = explode('|', $language_item)[1];
        $wasLanguagesUpdated = $userManager->updateUserLanguages($language_id, $userId);
    }
    echo $wasLanguagesUpdated;
}
function createJobForm()
{
    $userManager = new UserManager();
    $cities = $userManager->getCitiesList();
    $companyManager = new CompanyManager();
    $companyInfo = $companyManager->fetchCompanyBasicInfo();
    require("./view/addNewJobView.php");
}

function addNewJob($jobTitle, $jobStory, $salaryMin, $salaryMax, $cities, $deadline)
{
    $salaryMin = trim($salaryMin, "₩M");
    $salaryMax = trim($salaryMax, "₩M");

    $cities = explode("|", $cities)[1]; // seoul|142 => ["seoul", "142"]
    $cities = (int)$cities;

    $companyManager = new CompanyManager();
    $companyInfo = $companyManager->fetchCompanyBasicInfo();
    $result = $companyManager->insertNewJob($jobTitle, $jobStory, $salaryMin, $salaryMax, $cities, $deadline);
    if ($result) {
        // TODO: finish this bish!
        header("Location: ./index.php?action=jobListings");
    } else {
        echo "Adding job failed, please contact the administrator";
    }
}

function getCompanyInfo()
{
    $companyManager = new CompanyManager();
    $companyInfo = $companyManager->fetchCompanyInfo();
    // print_r($companyInfo);

    require("./view/companyDashboard.php");
}

function uploadImage($file)
{
    $hash = hash_file("md5", $file["tmp_name"]);
    echo $hash;
    $first = substr($hash, 0, 2); // 09
    $second = substr($hash, 2, 2); // 0f

    mkdir("./public/images/uploaded/$first/$second", 0777, true);

    // allow read & write permissions for everyone
    chmod("./public/images/uploaded/$first", 0777);
    chmod("./public/images/uploaded/$first/$second", 0777);

    $type = explode(".", $file['name'])[1];
    $filename = substr($hash, 4) . "." . $type;
    $newPath = "./public/images/uploaded/$first/$second/$filename";
    move_uploaded_file($file["tmp_name"], $newPath);

    chmod($newPath, 0777);

    return $newPath;
}

function updateCompanyInfo($bizName, $bizAddress, $email, $phone, $webSite, $logo, $oldLogo)
{
    $companyManager = new CompanyManager();
    $companyInfo = $companyManager->fetchCompanyInfo();
    if ($logo) {
        $logo = uploadImage($logo);
    } else {
        $logo = $oldLogo;
    }
    $result = $companyManager->changeCompanyInfo($bizName, $bizAddress, $email, $phone, $webSite, $logo);

    if ($result[0] and $result[1]) {

        header("location:index.php?action=companyDashboard");
    } else {
        throw new Exception("Update failed.");
    }
}

function getEmployeeInfo()
{
    $companyManager = new CompanyManager();
    $companyInfo = $companyManager->fetchCompanyBasicInfo();
    $employeeInfo = $companyManager->fetchEmployeeInfo();
    // print_r($companyInfo);

    require("./view/employeeInfoView.php");
}

function updateEmployeeInfo($firstName, $lastName, $jobTitle)
{
    $companyManager = new CompanyManager();
    $companyInfo = $companyManager->fetchCompanyBasicInfo();
    $result = $companyManager->changeEmployeeInfo($firstName, $lastName, $jobTitle);
    if ($result) {
        header("location:index.php?action=employeeInfo");
    } else {
        throw new Exception("Update failed.");
    }
}

function fetchJobPostings()
{

    $companyManager = new CompanyManager();
    $companyInfo = $companyManager->fetchCompanyBasicInfo();
    $listings = getJobPostings($_SESSION["id"]);

    require("./view/jobListingsView.php");
}
function showJobCard($jobId)
{
    $jobCard = getJobCard($jobId, $_SESSION["id"]);
    require("./view/jobListingsView.php");
    return $jobCard;
}
function updateJobListing($description, $minSalary, $maxSalary, $deadline, $id)
{

    updateJobPost($description, $minSalary, $maxSalary, $deadline, $id);
    $listings = getJobPostings($_SESSION["id"]);
    if (!empty($listings) && empty($jobId)) {
        foreach ($listings as $listing) {
            require "./view/components/jobPostingCard.php";
        }
    }
    $companyManager = new CompanyManager();
    $companyInfo = $companyManager->fetchCompanyBasicInfo();
}

function updateJobStatus($id, $status)
{

    setJobStatus($id, $status);
}

function uploadUserProfileImage($file)
{
    // md5 is considered insecure so generally we don't use it except for files
    $hash = hash_file("md5", $file["tmp_name"]);
    echo $hash;
    $first = substr($hash, 0, 2);
    $second = substr($hash, 2, 2);

    mkdir("./public/images/uploaded/$first/$second", 0777, true);

    // allow read & write permissions for everyone
    chmod("./public/images/uploaded/$first", 0777);
    chmod("./public/images/uploaded/$first/$second", 0777);

    $type = explode(".", $file['name'])[1];
    $filename = substr($hash, 4) . "." . $type;
    $newPath = "./public/images/uploaded/$first/$second/$filename";
    move_uploaded_file($file["tmp_name"], $newPath);

    chmod($newPath, 0777);

    return $newPath;
}
function uploadResume($resume)
{
    $hash = hash_file("md5", $resume["tmp_name"]);
    echo $hash;
    $first = substr($hash, 0, 2);
    $second = substr($hash, 2, 2);

    mkdir("./public/images/resume/$first/$second", 0777, true);
    chmod("./public/images/resume/$first", 0777);
    chmod("./public/images/resume/$first/$second", 0777);

    $type = explode(".", $resume['name'])[1];
    $filename = substr($hash, 4) . "." . $type;
    $newResumeLivingPlace = "./public/images/uploaded/$first/$second/$filename";
    move_uploaded_file($resume['tmp_name'], $newResumeLivingPlace);
    chmod($newResumeLivingPlace, 0777);

    $userManager = new UserManager();
    $newResumeLivingPlace = $userManager->uploadUserResume($resume);
    header("Location:index.php?action=userProfile");
}
function savedSearchExists($jobId)
{

    $savedSearchExists = talentFilterExists($jobId);
    // print_r($savedSearchExists);
    if (!empty($savedSearchExists)) {
        $searchdata = json_decode($savedSearchExists[0]->search_data);
        return $searchdata;
    } else {
        return false;
    }
}

function showTalentProfileView($id, $jobID) {
    $userManager = new UserManager();
    $user = $userManager->getUserProfile($id);
    $education = $userManager->getUserEducation($id);
    $profExps = showJobs($id);
    $skills = showSkills($id);
    $languages = showLanguages($id);
    $calendarManager = new CalendarManager();
    $entries = $calendarManager->loadCalendar($id);
    require("./view/talentProfileView.php");
}

function bookInterview($uaID, $id, $jobID) {
    $compID = getCompanyID($id);
    $CalendarManager = new CalendarManager();
    $result = $CalendarManager->insertMeeting($uaID, $compID, $jobID);
    if (!$result) {
        throw new Exception("Unable to schedule interview");
    }
    header("location: index.php?action=bookedMeetings");
}

function showBookedMeetings() {
    $companyManager = new CompanyManager();
    $bookedMeetings = $companyManager->fetchBookedMeetings();
    if (!$bookedMeetings) {
        throw new Exception("Unable to fetch booked meetings");
    } else {
        require("./view/bookedMeetingsView.php");
    }
}

function deleteReservation($rID) {
    if (is_array($rID)) {
        $rIDs = $rID;
        for ($i = 0; $i < count($rIDs); $i++) {
            $rID = strip_tags($rIDs[$i]['rID']);
    
            $companyManager = new CompanyManager();
            $result = $companyManager->cancelMeeting($rID);
        }
        if (!$result) {
            throw new Exception("Unable to delete entry");
        } else {
            // header("location: index.php?action=bookedMeetings");
        }
    } else {
        $companyManager = new CompanyManager();
        $result = $companyManager->cancelMeeting($rID);
        if (!$result) {
        throw new Exception("Unable to delete entry");
        } else {
        header("location: index.php?action=bookedMeetings");
        }
    }
}

function calDateToStr($str) {
    $d = strtotime($str);
    return date("l, M jS", $d);
}
<?php
// ROUTER

require("./controller/controller.php");

try {
    $action = $_REQUEST['action'] ?? null;

    session_start();

    switch ($action) {
        case "userProfileView":
            showUserProfileView();
            break;
        case "userPhotoUpload":
            echo "<pre>";
            print_r($_FILES);
            $file = $_FILES['profilePhoto'];
            uploadUserProfileImage($file);
            break;
        case "userResumeUpload":
            echo "<pre>";
            print_r($_FILES);
            $resume = $_FILES['resume'];
            uploadResume($resume);
            break;
        case "userSignInGoogle":
            $token = $_POST['credential']; //post credentials 
            $decodedToken = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1])))); // decoding the json web token (JWT) into the array info

            checkUserSignInGoogle($decodedToken);
            // require('./view/testView.php');
            break;
        case "userSignUpView":
            //call a contrl
            showUserSignUp();
            break;
        case "userSignInView":
            showUserSignIn();
            break;
        case "userSignUp":
            //make sure data exists
            $firstName = !empty($_POST['fName']) ? $_POST['fName'] : null;
            $lastName = !empty($_POST['lName']) ? $_POST['lName'] : null;
            $email = !empty($_POST['email']) ? $_POST['email'] : null;
            $pwd = !empty($_POST['pwd']) ? $_POST['pwd'] : null;
            $pwd2 = !empty($_POST['pwdconf']) ? $_POST['pwdconf'] : null;
            if ($firstName and $lastName and $email and $pwd and $pwd2) {
                //call a controller function
                userSignUp($firstName, $lastName, $email, $pwd, $pwd2);
            }
            break;
        case "companySignUp":
            $firstName = !empty($_POST['fName']) ? $_POST['fName'] : null;
            $lastName = !empty($_POST['lName']) ? $_POST['lName'] : null;
            $email = !empty($_POST['email']) ? $_POST['email'] : null;
            $pwd = !empty($_POST['pwd']) ? $_POST['pwd'] : null;
            $pwd2 = !empty($_POST['pwdconf']) ? $_POST['pwdconf'] : null;
            $companyName = !empty($_POST['companyname']) ? $_POST['companyname'] : null;
            $companyTitle = !empty($_POST['companytitle']) ? $_POST['companytitle'] : null;

            if ($firstName and $lastName and $email and $pwd and $pwd2 and $companyName and $companyTitle) {
                //call a controller function
                companySignUp($firstName, $lastName, $email, $pwd, $pwd2, $companyName, $companyTitle);
            } else if ($firstName and $lastName and $email and $pwd and $pwd2) {
                userSignUp($firstName, $lastName, $email, $pwd, $pwd2);
            }
            break;

        case "userSignIn":
            //make sure data is set
            $email = $_POST['email'] ?? null;
            $pwd = $_POST['pwd'] ?? null;
            if ($email and $pwd) {
                //call a controller function
                userSignIn($email, $pwd);
            }
            break;
        case "userProfile":
            // $phone_number = !empty($_POST['phone_number']) ? $_POST['phone_number'] : null;
            // $city = !empty($_POST['city']) ? $_POST['city'] : null;
            // $desired_salary = !empty($_POST['desired_salary']) ? $_POST['desired_salary'] : null;
            // $visa_sponsorship = !empty($_POST['visa_sponsorship']) ? $_POST['visa_sponsorship'] : null;
        
        case "getChatMessages":
            $conversationId = $_POST['conversationId'] ?? null;
            if (!empty($conversationId)) {
                showMessages($conversationId);
            }
            break;
        case "submitMessage":

            $conversationId = $_POST['conversationId'] ?? null;
            $senderId = $_POST['senderId'];
            $message = $_POST['message'];
            // echo $message, $senderId, $conversationId;
            if (!empty($senderId)  and !empty($message)) {
                // echo "<br>";
                // echo "getting controller";
                addMessage($conversationId, $senderId, $message);
            }
            break;
        case "messenger":
            showChats();

            break;
        case "search":
            // print_r($_GET);
            $term = $_GET['term'] ?? null;

            searchMessages($term);
            break;
        case "getChatMessages":
            $conversationId = $_POST['conversationId'] ?? null;
            if (!empty($conversationId)) {
                showMessages($conversationId);
            }
            break;
        case "submitMessage":

            $conversationId = $_POST['conversationId'] ?? null;
            $senderId = $_POST['senderId'];
            $message = $_POST['message'];
            // echo $message, $senderId, $conversationId;
            if (!empty($senderId)  and !empty($message)) {
                // echo "<br>";
                // echo "getting controller";
                addMessage($conversationId, $senderId, $message);
            }
            break;
        case "messenger":
            showChats();

            break;
        case "search":
            // print_r($_GET);
            $term = $_GET['term'] ?? null;
            searchMessages($term);
            break;
        case "updateCalendar":
            $data = $_REQUEST['data'] ?? "";
            if ($data) {
                $data = json_decode($data, true);
                addCalendar($data);
            } else {
                throw new Exception("No calender inputs submitted");
            }
            break;
            // case "loadCalendar":
            //     $user_id = $_SESSION['user_id'] ?? 1; //TODO: REMOVE 1
            //     showCalendar($user_id);
            //     break;
        case "deleteCalendarEntry":
            $entry = $_REQUEST['entry'] ?? "";
            if ($entry) {
                $entry = json_decode($entry, true);
                deleteCalendarEntry($entry);
            } else {
                throw new Exception("No calender inputs submitted");
            }
            break;
        case "talentSearch":
            $jobId = $_GET['jobId'] ?? null;
            // echo $jobId . "<br>";
            $saveData = savedSearchExists($jobId) ?? null;
            if (!empty($saveData)) {
                // echo "showing filters    ";
                showTalents(true, $saveData);
            } else {

                showTalents(false, null);
            }

            break;

        case "talentSearchSave":
            // echo "save";
            $jobId = $_GET['jobId'] ?? null;
            // echo $jobId . "<br>";
            $saveData = savedSearchExists($jobId) ?? null;
            if (!empty($saveData)) {
                // echo "savedata not empty";
                updateSavedTalentSearch($saveData, $jobId);
                showTalents(true, null);
            } else {
                parseTalentFilter($jobId);
                showTalents(true, null);
            }
        // case "getUserSkills":
        //     require("./view/userProfileSkills.php");
        //     break;
        // case "getUserLanguages":
        //     require("./view/userProfileSkills.php");
        //     break;
        // case "getUserCities":
        //     require("./view/userProfileSkills.php");
        //     break;
        // case "userProfileView":
        //     $user_id = $_SESSION['user_id'] ?? 1; //TODO: REMOVE 1
        //     showCalendar($user_id);
        //     break;
        case "companyDashboard":
            getCompanyInfo();
            break;
        case "createJobForm":
            createJobForm();
            break;
        case "employeeInfo":
            getEmployeeInfo();
            break;
        case "jobListings":
            $user_id = $_SESSION['user_id'] ?? NULL;
            if (!empty($_GET['ListingId'])) {
                $jobId = $_GET['ListingId'] ?? null;
                $jobCard = showJobCard($jobId);
            } else {
                fetchJobPostings();
            }

            break;
        case "savedProfiles":
            $companyManager = new CompanyManager();
            $companyInfo = $companyManager->fetchCompanyInfo();

            require("./view/savedProfilesView.php");
            break;
        case "updateUserPersonal":

            $id = $_POST['id'];
            $phoneNb = $_POST['phoneNb'] ?? null;
            $city = $_POST['city'] ?? null;
            $salary = $_POST['salary'] ?? null;
            $visa = $_POST['visa'] ?? null;
            updateUserPersonal($id, $phoneNb, $city, $salary, $visa);
            // echo $id, $phoneNb, $city, $salary, $visa;
            // $id, $phone_number, $city_id, $desired_salary, $visa_sponsorship
            break;
        case "updateUserEducation":
            $userId = $_POST['userId'];
            $degree = $_POST['degree'] ?? null;
            $degreeLevel = $_POST['degreeLevel'] ?? null;
            updateUserEducation($userId, $degree, $degreeLevel);
            break;
        case "updateUserExperience":
            $userId = $_POST['userId'];
            $jobTitle = $_POST['jobTitle'] ?? null;
            $yearsExperience = $_POST['yearsExperience'] ?? null;
            $companyName = $_POST['companyName'] ?? null;
            updateUserExperience($jobTitle, $yearsExperience, $companyName, $userId);
            break;
        case "userProfileSkillsSubmit":
            $userId = $_SESSION['id'] ?? null; //TODO: change this userID
            $skillsString = $_POST['skills'] ?? null;
            $languagesString = $_POST['languages'] ?? null;
            if ($skillsString != null) {
                updateUserSkills($skillsString, $userId);
            }
            if ($languagesString != null) {
                updateUserLanguages($languagesString, $userId);
            }
            header("location: index.php?action=userProfileView");
            break;

        case "addNewJob":
            $jobTitle = $_POST['jobTitle'] ?? null;
            $jobStory = $_POST['jobStory'] ?? null;
            $salaryMin = $_POST['salaryMin'] ?? null;
            $salaryMax = $_POST['salaryMax'] ?? null;
            $cities = $_POST['cities'] ?? null;
            $deadline = $_POST['deadline'] ?? null;
            if ($jobTitle and $jobStory and $salaryMin and $salaryMax and $cities and $deadline) {
                addNewJob($jobTitle, $jobStory, $salaryMin, $salaryMax, $cities, $deadline);
            } else {
                throw new Exception("missing data");
            }
            break;
        case "updateCompanyInfo":
            $bizName = $_POST['bizName'] ?? null;
            $bizAddress = $_POST['bizAddress'] ?? null;
            $email = $_POST['email'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $webSite = $_POST['webSite'] ?? null;
            $oldLogo = $_POST['oldLogo'] ?? null;
            $logo = !empty($_FILES['logoUpload']['name']) ? $_FILES['logoUpload'] : null;
            // echo "<pre>";
            // print_r($_FILES);
            // echo "logo; $logo";
            if ($bizName and $bizAddress and $email and $phone and $webSite) {
                updateCompanyInfo($bizName, $bizAddress, $email, $phone, $webSite, $logo, $oldLogo);
            } else {
                throw new Exception("missing data");
            }
            break;
        case "updateEmployeeInfo":
            $firstName = $_POST['firstName'] ?? null;
            $lastName = $_POST['lastName'] ?? null;
            $jobTitle = $_POST['jobTitle'] ?? null;
            if ($firstName and $lastName and $jobTitle) {
                updateEmployeeInfo($firstName, $lastName, $jobTitle);
            } else {
                throw new Exception("missing data");
            }
        case "postJobChanges":
            $description = $_POST['description'] ?? null;
            $minSalary = $_POST['minSalary'] ?? null;
            $maxSalary = $_POST['maxSalary'] ?? null;
            $deadline = $_POST['deadline'] ?? null;
            $id = $_POST["id"] ?? null;
            $id = (int)$id;
            updateJobListing($description, $minSalary, $maxSalary, $deadline, $id);
            break;
        case "updatePosition":
            $id = $_POST['id'] ?? null;
            $id = (int)$id;
            $status = $_POST['status'] ?? null;
            updateJobStatus($id, $status);
            break;
        case "signOut";
            session_destroy();
            header("location:index.php");
            break;
        case "talentProfile":
            $id = $_POST["talentID"] ?? null;
            $jobID = $_POST['jobID'] ?? null;
            showTalentProfileView($id, $jobID);
            break;
        case "bookInterview":
            $uaID = $_POST['uaID'] ?? null;
            $id = $_SESSION["id"] ?? null;
            $jobID = $_POST['jobID'] ?? null;
            bookInterview($uaID, $id, $jobID);
            break;
        case "bookedMeetings":
            $companyManager = new CompanyManager();
            $bookedMeetings = $companyManager->fetchBookedMeetings();
            require("./view/bookedMeetingsView.php");
            break;
        case "cancelMeeting":
            $rID = $_REQUEST['reserveID'] ?? null;
            $companyManager = new CompanyManager();
            $bookedMeetings = $companyManager->cancelMeeting($rID);
            header("location: index.php?action=bookedMeetings");
            break;
        default:
            showIndex();
            break;
    }
} catch (Exception $e) {
    $errorMsg = $e->getMessage();
    require("./view/errorView.php");
}

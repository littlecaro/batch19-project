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
            $file = $_FILES['imageUpload'];
            uploadImage($file);
            break;
        case "userResumeUpload":
            // echo "<pre>";
            // print_r($_FILES);
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
                userSignIn($_POST['email'], $_POST['pwd']);
            }
            break;
        case "getChatMessages":
            $conversationId = $_POST['conversationId'] ?? null;
            if (!empty($conversationId)) {
                showMessages($conversationId);
            }
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

            $senderId = $_SESSION["id"] ?? null;
            // echo $_SESSION["id"];
            $message = $_POST['message'];
            // echo $message, $senderId, $conversationId;
            if (!empty($senderId)  and !empty($message)) {
                // echo "<br>";
                // echo "getting controller";
                addMessage($conversationId, $senderId, $message, null);
            }
            break;
        case "countUnreadMessages":
            $messageNum = countUnreadMessages();
            break;
        case "partyMessageUnread":
            $conversationId = $_POST['conversationId'] ?? null;
            $isUnread = partyMessageUnread($conversationId);
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
        case "companyDashboard":
            getCompanyInfo();
            break;
        case "readMessage":
            if (!empty($_POST['conversationId'])) {
                (int)$conversationId = $_POST['conversationId'];
                readMessage($conversationId);
            }
            break;
        case "createJobForm":
            createJobForm();
            break;
        case "employeeInfo":
            getEmployeeInfo();
            break;
        case "jobListings":
            $user_id = $_SESSION['id'] ?? NULL;
            if (!empty($_REQUEST['ListingId'])) {
                $jobId = $_REQUEST['ListingId'] ?? null;
                $jobCard = showJobCard($jobId);
            } else {
                fetchJobPostings();
            }
            break;
        case "savedProfiles":
            $companyManager = new CompanyManager();
            $companyInfo = $companyManager->fetchCompanyInfo($_SESSION['company_id']);
            $userManager = new UserManager();
            if (isset($_SESSION['id'])) {
                $user = $userManager->getUserProfile($_SESSION['id']);
                $userId = $_SESSION['id'];
                $chats = loadChats($userId); // TODO: move this to signed in view
            }
            if (isset($user->profile_picture)) {
                $profileImg = $user->profile_picture;
            }

            require("./view/savedProfilesView.php");
            break;
        case "updateUserPersonal":
            $id = $_POST['id'];
            $phoneNb = $_POST['phoneNb'] ?? null;
            $city = $_POST['city'] ?? null;
            $salary = $_POST['salary'] ?? null;
            $visa = $_POST['visa'] ?? null;
            $oldImage = $_POST['oldImage'] ?? null;
            $profilePic = !empty($_FILES['profilePic']['name']) ? $_FILES['profilePic'] : null;
            
            updateUserPersonal($id, $phoneNb, $city, $salary, $visa, $profilePic, $oldImage);
            break;
        case "updateUserEducation":
            $userId = $_POST['userId'];
            $degree = $_POST['degree'] ?? null;
            $degreeLevel = $_POST['degreeLevel'] ?? null;
            updateUserEducation($userId, $degree, $degreeLevel);
            break;

        case "updateUserExperience": //DONE
            // print_r($_POST);
            $userId = $_POST['userId'];
            $jobTitle = $_POST['jobTitle'] ?? null;
            $yearsExperience = $_POST['yearsExperience'] ?? null;
            $companyName = $_POST['companyName'] ?? null;
            $id = $_POST['jobID'];
            updateUserExperience($jobTitle, $yearsExperience, $companyName, $userId, $id);
            break;
        case "addNewUserExperience":
            $userId = $_POST['userId'];
            $jobTitle = $_POST['jobTitle'] ?? null;
            $yearsExperience = $_POST['yearsExperience'] ?? null;
            $companyName = $_POST['companyName'] ?? null;
            addNewUserExperience($companyName, $jobTitle, $yearsExperience, $userId);
            break;

        case "deleteUserExperience":
            $id = $_POST['jobID'];
            echo $id;
            deleteUserExperience($id);
            break;
        case "userProfileSkillsSubmit":
            $userId = $_SESSION['id'] ?? null;
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

            updateCompanyInfo($bizName, $bizAddress, $email, $phone, $webSite, $logo, $oldLogo);
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
            showBookedMeetings();
            break;
        case "cancelMeeting":
            $rID = strip_tags($_REQUEST['reserveID']) ?? null;
            if ($rID[0] == '[') {
                $rID = json_decode($rID, true);
                deleteReservation($rID);
                break;
            } else {
                deleteReservation($rID);
                break;
            }
        case "cancelRoleMeetings":
            $rJob = strip_tags($_REQUEST['reserveJob']) ?? null;
            deleteRoleMeetings($rJob);
            break;
        case "getCounterpartInfo":
            $conversationId = strip_tags($_POST['conversationId']) ?? null;
            $counterpart = getCounterpartInfo($conversationId);
            break;
        default:
            showIndex();
            break;
    }
} catch (Exception $e) {
    $errorMsg = $e->getMessage();
    require("./view/errorView.php");
}

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
            }
            break;

        case "userSignIn":
            //make sure data is set
            $email = isset($_POST['email']);
            $pwd = isset($_POST['pwd']);

            if ($email and $pwd) {
                //call a controller function
                userSignIn($email, $pwd);
            }
            break;
            // case "userProfile":
            //     // $phone_number = !empty($_POST['phone_number']) ? $_POST['phone_number'] : null;
            //     // $city = !empty($_POST['city']) ? $_POST['city'] : null;
            //     // $desired_salary = !empty($_POST['desired_salary']) ? $_POST['desired_salary'] : null;
            //     // $visa_sponsorship = !empty($_POST['visa_sponsorship']) ? $_POST['visa_sponsorship'] : null;

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
            if (!empty($_GET['filter'])) {
                showTalents(true);
            } else {
                showTalents();
            }
            break;
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
            if (!empty($_GET['ListingId'])) {
                $jobId = $_GET['ListingId'] ?? null;
                $jobCard = showJobCard($jobId);
            } else {
                fetchJobPostings();
            }

            break;
        case "savedProfiles":
            require("./view/savedProfilesView.php");
            break;
        case "bookedMeetings":
            require("./view/bookedMeetingsView.php");
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

        case "updateUserExperience": //DONE
            $userId = $_POST['userId'];
            $jobTitle = $_POST['jobTitle'] ?? null;
            $yearsExperience = $_POST['yearsExperience'] ?? null;
            $companyName = $_POST['companyName'] ?? null;
            updateUserExperience($jobTitle, $yearsExperience, $companyName, $userId);
            break;

        case "addNewUserExperience":
            $userId = $_POST['userId'];
            $jobTitle = $_POST['jobTitle'] ?? null;
            $yearsExperience = $_POST['yearsExperience'] ?? null;
            $companyName = $_POST['companyName'] ?? null;
            addNewUserExperience($companyName, $jobTitle, $yearsExperience, $userId);
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
            $logo = $_FILES['logoUpload'] ?? null;
            if ($bizName and $bizAddress and $email and $phone and $webSite) {
                updateCompanyInfo($bizName, $bizAddress, $email, $phone, $webSite, $logo);
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
        default:
            showIndex();
            break;
    }
} catch (Exception $e) {
    $errorMsg = $e->getMessage();
    require("./view/errorView.php");
}

<?php
// ROUTER

require("./controller/controller.php");

try {
    $action = $_REQUEST['action'] ?? null;

    session_start();

    switch ($action) {
        case "userProfile":
            showUserProfile();
            // require('./view/userProfileView.php');
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
            $firstName = !empty($_POST['firstName']) ? $_POST['firstName'] : null;
            $lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : null;
            $email = !empty($_POST['email']) ? $_POST['email'] : null;
            $pwd = !empty($_POST['pwd']) ? $_POST['pwd'] : null;
            $pwd2 = !empty($_POST['pwdconf']) ? $_POST['pwdconf'] : null;

            if ($firstName and $lastName and $email and $pwd and $pwd2) {
                //call a controller function
                userSignUp($firstName, $lastName, $email, $pwd, $pwd2);
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

            //     userProfile();
            //     require('./view/userProfileView.php');

            //     break;

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
        case "loadCalendar":
            $user_id = $_SESSION['user_id'] ?? 1;
            showCalendar($user_id);
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
            if (!empty($_GET['filter'])) {
                showTalents(true);
            } else {
                showTalents();
            }
            break;
        case "userProfileView":
            require("./view/userProfileView.php");
            break;
        case "companyDashboard":
            require("./view/companyDashboard.php");
            break;
        case "createJobForm":
            createJobForm();
            break;
        case "employeeInfo":
            require("./view/employeeInfoView.php");
            break;
        case "jobListings":
            require("./view/jobListingsView.php");
            break;
        case "savedProfiles":
            require("./view/savedProfilesView.php");
            break;
        case "bookedMeetings":
            require("./view/bookedMeetingsView.php");
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
        default:
            showIndex();
            break;
    }
} catch (Exception $e) {
    $errorMsg = $e->getMessage();
    require("./view/errorView.php");
}
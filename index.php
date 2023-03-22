<?php
// ROUTER

require("./controller/controller.php");

try {
    $action = $_REQUEST['action'] ?? null;

    switch ($action) {
        case "userProfile":
            require('./view/userProfile.php');
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
            //     require('./view/userProfile.php');

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
                $data = json_decode($data,true);
                addCalendar($data);
            } else {
                throw new Exception ("No calender inputs submitted");
            }
            break;
        case "loadCalendar":
            $user_id = $_SESSION['user_id'] ?? 1;
            showCalendar($user_id);
            break;
        case "deleteEntry":
            $entry = $_REQUEST['entry'] ?? "";
            if ($entry) {
                // echo $entry;
                $entry = json_decode($entry,true);
                // print_r($entry);
                deleteEntry($entry);
            } else {
                throw new Exception ("No calender inputs submitted");
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

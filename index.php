<?php
// ROUTER

require("./controller/controller.php");

try {
    $action = $_REQUEST['action'] ?? null;
    switch ($action) {
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
        default:
            showIndex();
            break;
    }
} catch (Exception $e) {
    $errorMsg = $e->getMessage();
    require("./view/errorView.php");
}

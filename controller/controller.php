<?php
//TODO: When do we show the messenger box? How do we handle knowning who is logged in?
require_once './model/model.php';

// require_once '/controller/api.php';
function showChats()
{
    $chats = loadChats();
    require("./view/messageView.php");
}
function showIndex()
{
    $chats = loadChats();
    require("./view/indexView.php");
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

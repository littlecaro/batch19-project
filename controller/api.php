<?php
//TODO:does it receive requests outside of the website
// Check if the request is a POST request
require_once '../model/model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the IP address of the requesting client
    $remote_ip = $_SERVER['REMOTE_ADDR'];

    // Check if the IP address is the localhost
    if ($remote_ip !== '127.0.0.1' && $remote_ip !== '::1') {
        // If the IP address is not the localhost, return an error message
        http_response_code(403);
        die('Access denied');
    }

    $data = json_decode(
        file_get_contents('php://input'),
        true
    );

    $conversation_id = $data["conversation_id"];
    $messages = getMessages($conversation_id);

    // print_r($data);
    // $conversationId = $_POST["conversation_id"];
    // If the IP address is the localhost, continue with your API logic
    // $data = getMessages($conversationId);

    // Do some processing with the request data

    // Set the response headers
    header('Content-Type: application/json');

    // Return the response data as JSON
    echo json_encode($messages);
}

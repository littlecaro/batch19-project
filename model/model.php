<?php
//TODO: Check all functions for safety
function dbConnect()
{
    try {
        return new PDO('mysql:host=localhost;dbname=batch19_project;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Error : ' . $e->getMessage());
    }
}

function loadChats()
{
    $userId = 1;
    // $str = 'SELECT m.message,m.sender_id, m.recipient_id,u.profile_picture,u.first_name,u.last_name,m.conversation_id FROM messages m INNER JOIN users u on m.sender_id=:userId OR m.recipient_id=:userId';
    $str = 'SELECT u.id AS contactId, u.first_name AS contactFirstName, u.last_name AS contactLastName, u.profile_picture AS contactProfilePicture, m.id, m.message, m.sender_id, m.recipient_id, m.conversation_id, day, month
FROM users u
INNER JOIN (
SELECT m1.id, m1.message, m1.sender_id, m1.recipient_id, m1.conversation_id, DAY(m2.datetime) as day, MONTHNAME(m2.datetime) as month
    FROM messages m1
  JOIN (SELECT id, MAX(id) AS maxId, conversation_id, datetime FROM messages GROUP BY conversation_id) m2
    ON m1.id = m2.maxId
    WHERE m1.sender_id = :userId OR m1.recipient_id = :userId
) AS m
ON u.id != :userId AND (u.id = m.sender_id OR u.id = m.recipient_id);';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->execute();
    $chats = $query->fetchAll(PDO::FETCH_OBJ);
    return $chats;
}
function getMessages($conversationId)
{

    $str = 'SELECT u.profile_picture,u.first_name,u.last_name,m.conversation_id, m.id, m.sender_id, m.message, DATE_FORMAT(m.datetime, "%M %d %h:%i" ) as datetime FROM messages m INNER JOIN users u ON m.sender_id=u.id WHERE m.conversation_id = :ConversationId ';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(':ConversationId', $conversationId, PDO::PARAM_INT);
    $query->execute();
    $messages = $query->fetchAll(PDO::FETCH_OBJ);
    return $messages;
}
function submitMessage($conversationId, $senderId, $message)
{
    $userId = 1;
    if (is_null($conversationId)) {
        $conversationId = rand(1000, 9999);
    }
    $str = 'SELECT m.recipient_id FROM messages m INNER JOIN users u ON m.sender_id=u.id WHERE m.conversation_id = :ConversationId AND m.recipient_id!=:userId ';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(':ConversationId', $conversationId, PDO::PARAM_INT);
    $query->bindParam(':userId', $userId, PDO::PARAM_STR);
    $query->execute();
    $response = $query->fetch(PDO::FETCH_OBJ);
    $recipientId = $response->recipient_id;
    print_r($response);
    $str = 'INSERT INTO messages (id,sender_id, recipient_id, message,conversation_id) VALUES (NULL, :InsenderId,:Inrecipient_id, :Inmessage, :InConversationId )';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(':InsenderId', $senderId, PDO::PARAM_INT);
    $query->bindParam(':Inrecipient_id', $recipientId, PDO::PARAM_INT);
    $query->bindParam(':Inmessage', $message, PDO::PARAM_STR);
    $query->bindParam(':InConversationId', $conversationId, PDO::PARAM_INT);

    $query->execute();
}
function searchMessagesGet($term)
{
    $newTerm = "%" . $term . "%";
    // echo $term;
    $userId = 1;
    $str = 'SELECT m.id AS messageId, m.message, m.sender_id, DAY(m.datetime) AS day, MONTHNAME(m.datetime) as month, m.conversation_id, c.id AS contactId, c.first_name AS contactFirstName, c.last_name AS contactLastName, c.profile_picture AS contactProfilePicture FROM messages m LEFT JOIN users c ON c.id != :userId AND (c.id = m.sender_id OR c.id = m.recipient_id) WHERE (m.sender_id = :userId OR m.recipient_id = :userId) AND m.message LIKE :Inmessage GROUP BY m.conversation_id ORDER BY m.datetime DESC;';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->bindParam(':Inmessage', $newTerm, PDO::PARAM_STR);
    $query->execute();
    $chats = $query->fetchAll(PDO::FETCH_OBJ);
    // print_r($query);
    // print_r($chats);
    return $chats;
}




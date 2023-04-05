<?php

if (empty($_SESSION['id'])) {
    header('location: http://localhost/sites/batch19-project/index.php');
exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/c8900437f0.js" crossorigin="anonymous"></script>
    <!-- fontawesome script link -->
    <link rel="stylesheet" href="./public/css/styleUserProfile.css" />
    <!-- We need to choose better font-family: googlefonts?! -->
    <script src="./public/js/scriptUserProfile.js"></script>
    <title>WaygukIn</title>
</head>

<body style="overflow:hidden">
    <div class="messengerMain">
        <div class="messengerLeft">
            <div class="messengerActions">
                <h3>Messaging</h3>
                <div class="search"><input type="text" name="messageSearch" id="messageSearch" placeholder="Search messages">
                </div>
            </div>
            <div class="messeangerContacts">
                <?php

                if (!empty($chats)) {
                    foreach ($chats as $chat) {
                        include('./view/components/chatCard.php');
                    }
                }
                ?>
            </div>
        </div>
        <div class="messengerCenter">
            <?php
            if (!empty($conversationId) and !empty($senderId) and !empty($message)) {
                include "./view/components/messageCard.php";
            }
            ?>
        </div>
        <div class="messengerRight">
        </div>
    </div>

    <script src="./public/javascript/chatFunc.js"></script>
    <script src="./public/javascript/messenger.js"></script>
    <script src="./public/javascript/messageSearch.js"></script>
    <link rel="stylesheet" href="./public/css/chatStyle.css">
    <link rel="stylesheet" href="./public/css/messenger.css">
    <script>
        const userId = <?= $_SESSION["id"] ?>
    </script>


</html>
<?php
$title = "TODO:CHANGE ME";
ob_start();
?>

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
<?php
$content = ob_get_clean();
require('./view/template.php');
?>
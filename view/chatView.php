<div class="chatboxFooter">

    <div class="chatboxContainer">
        <div class="chatboxHead">
            <div class="messagingProfileIco"><img src="<?= htmlspecialchars($profileImg ?? "") ?>" alt=""></div>
            <span class="chatboxTitle">Messages</span>
            <div class="chatboxActions">
                <i class="unreadNum"></i>
                <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                <i class="fa-solid fa-chevron-up"></i>
            </div>
        </div>
        <div class="expandableWrapper">
            <div class="messageSearch"></div>
            <?php
            if (!empty($chats)) {
                foreach ($chats as $chat) {
                    include('./view/components/chatCard.php');
                }
            }
            ?>

        </div>
    </div>
</div>
<link rel="stylesheet" href="./public/css/chatStyle.css">
<link rel="stylesheet" href="./public/css/messenger.css">
<script>
    const unreadMessages = <?php
                            $counter = 0;
                            foreach ($chats as $chat) {
                                if ($chat->is_read == 0) {
                                    $counter++;
                                }
                            }
                            echo $counter > 0 ? $counter : 0;
                            ?>
</script>
<script src="./public/javascript/chatFunc.js"></script>
<script src="./public/javascript/chatbox.js"></script>
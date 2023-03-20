<div class="chatboxFooter">

    <div class="chatboxContainer">
        <div class="chatboxHead">
            <div class="messagingProfileIco"><img src="./TestProfileImg/dustyProfile.png" alt=""></div>
            <span class="chatboxTitle">Messages</span>
            <div class="chatboxActions">
                <i class="fa-solid fa-ellipsis"></i>
                <i class="fa-solid fa-pen-to-square"></i>
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
<script src="./public/javascript/chatFunc.js"></script>
<script src="./public/javascript/chatbox.js"></script>
<div class="chatboxHead">
    <div class="messagingProfileIco"><img src="./TestProfileImg/dustyProfile.png" alt=""></div>
    <span class="chatboxTitle">Messages</span>
    <div class="chatboxActions">
        <i class="fa-solid fa-ellipsis"></i>
        <i class="fa-solid fa-pen-to-square"></i>
        <i class="fa-solid fa-ex"></i>
    </div>
</div>
<div class="messageContainer">
    <?php
    if (!empty($messages)) {
        foreach ($messages as $message) {
            include('./view/components/messageCard.php');
        }
    }
    ?>

</div>
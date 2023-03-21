<div class="messageDiv">
    <div class="messageProfileImg"><img src="<?= $message->profile_picture ?>" alt=""></div>
    <div class="chatboxMessageProfile">
        <p class="chatPreviewName"><strong><?= $message->first_name, " ", $message->last_name ?></strong> </p>
        <p class="messageText"><?= $message->message ?></p>
    </div>
    <div class="chatPreviewDate">
        <p><?= $message->datetime ?></p>
    </div>
</div>
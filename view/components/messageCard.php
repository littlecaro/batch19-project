<div class="messageDiv">
    <div class="messageProfileImg"><img src="<?= htmlspecialchars($message->profile_picture) ?>" alt=""></div>
    <div class="chatboxMessageProfile">
        <p class="chatPreviewName"><strong><?= htmlspecialchars($message->first_name), " ", htmlspecialchars($message->last_name) ?></strong> </p>
        <p class="messageText"><?= htmlspecialchars($message->message) ?></p>
        <div class="chatPreviewDate">
            <p><?= $message->datetime ?></p>
        </div>
    </div>
</div>
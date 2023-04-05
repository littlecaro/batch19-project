<li class="messageCard" data-thread="<?= $chat->conversation_id ?>">
    <div class="chatboxPreviewImg"><img src="<?= $chat->contactProfilePicture ?>" alt=""></div>
    <div class="chatboxPreviewProfile">
        <p class="chatPreviewName"><strong><?= $chat->contactFirstName, " ", $chat->contactLastName ?></strong> </p>
        <p class="chatPreviewText"><?= $chat->message ?></p>
    </div>
    <div class="chatPreviewDate">
        <i style="display: none;" class='fa-solid fa-circle-check'></i>
        <p><?= $chat->day, " ", $chat->month ?></p>
    </div>
</li>
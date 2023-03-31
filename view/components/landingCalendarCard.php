<div class="landingCalCard">
    <?php
        if (!isset($prevDate) OR $prevDate != strtotime($entry->date)) {
        ?>
            <div class="landingCalDate">
                <p><?= calDateToStr($entry->date) ?></p>
            </div>
            <?php
        }
        $prevDate = strtotime($entry->date);
    ?>
    <div class="landingCalTime">
        <p><?= substr($entry->time_start, 0, 5) ?></p>
    </div>
</div>
    <?php
        if ($i == 0 OR $prevDate != strtotime($entries[$i]->date)) {
        ?>
        <div class="landingCalCard">
            <div class="landingCalDate">
                <p><?= calDateToStr($entries[$i]->date) ?></p>
            </div>
            <div class="landingCalTime">
                <p><?= substr($entries[$i]->time_start, 0, 5) ?></p>
            </div>
            <?php
            $prevDate = strtotime($entries[$i]->date);
        } else {
            ?>
            <div class="landingCalTime timeMid">
                <p><?= substr($entries[$i]->time_start, 0, 5) ?></p>
            </div>
            <?php
        }
        // if next day if different close the div for this card
        if (!empty($entries[$i+1]->date) AND $entries[$i+1]->date != $entries[$i]->date) {
            ?>
            </div> 
            <?php
        // or if it's the last entry.
        } else if (empty($entries[$i+1]->date)) {
            ?>
            </div> 
            <?php
        }

    ?>
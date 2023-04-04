<?php
// TODO: Currently can just book one interview with a user. 
// Do we need to book multiple? 
// HTML structure in place to show more than one.
        if ($i == 0 OR $prevDate != strtotime($interviews[$i]->date)) {
        ?>
        <div class="landingCalCard landingInt">
            <div class="landingCalDate">
                <p><?= calDateToStr($interviews[$i]->date) ?></p>
            </div>
            <div class="landingCalTime">
                <p><?= $interviews[$i]->title ?>,</p>
                <p><?= $interviews[$i]->name ?>,</p>
                <p><?= substr($interviews[$i]->time_start, 0, 5) ?></p>
            </div>
            <?php
            $prevDate = strtotime($interviews[$i]->date);
        } else {
            ?>
            <div class="landingCalTime timeMid">
                <p><?= $interviews[$i]->title ?>,</p>
                <p><?= $interviews[$i]->name ?>,</p>
                <p><?= substr($interviews[$i]->time_start, 0, 5) ?></p>
            </div>
            <?php
        }
        // if next day if different close the div for this card
        if (!empty($interviews[$i+1]->date) AND $interviews[$i+1]->date != $interviews[$i]->date) {
            ?>
            </div> 
            <?php
        // or if it's the last entry.
        } else if (empty($interviews[$i+1]->date)) {
            ?>
            </div> 
            <?php
        }

    ?>
    <?php
        if ($i == 0 OR $prevDate != strtotime($entries[$i]->date)) {
        ?>
        <div class="landingCalCard">
            <div class="landingCalDate">
                <p><?= calDateToStr($entries[$i]->date) ?></p>
            </div>
            <div class="landingCalTime">
            <form action="http://localhost/sites/batch19-project/index.php?action=bookInterview" method="POST">
                        <input type="hidden" name="uaID" value="<?= $entries[$i]->id?>">
                        <input type="hidden" name="jobID" value="<?= $jobID?>">
                        <button><p><?= substr($entries[$i]->time_start, 0, 5) ?></p></button>
            </form>
                
            </div>
            <?php
            $prevDate = strtotime($entries[$i]->date);
        } else {
            ?>
            <div class="landingCalTime timeMid">
                <form action="http://localhost/sites/batch19-project/index.php?action=bookInterview" method="POST">
                            <input type="hidden" name="uaID" value="<?= $entries[$i]->id?>">
                            <input type="hidden" name="jobID" value="<?= $jobID?>">
                            <button><p><?= substr($entries[$i]->time_start, 0, 5) ?></p></button>
                </form>
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
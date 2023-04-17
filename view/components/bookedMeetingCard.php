<?php
    if ($i == 0 OR $prevDate != strtotime($bookedMeetings[$i]->date)) {
    ?>
    <div class="bookedMeetingCard">
        <div class="bookedDate">
            <p><?= calDateToStr($bookedMeetings[$i]->date)?></p>
        </div>
        <div class="meetingSubCard">
        <form action="index.php?action=talentProfile" method="POST">
        <input type="hidden" name="talentID" value="<?=$bookedMeetings[$i]->userID?>">
                <button><p><?= htmlspecialchars($bookedMeetings[$i]->first_name) . " " . (!empty($bookedMeetings[$i]->last_name) ? htmlspecialchars($bookedMeetings[$i]->last_name) : null)?> </p></button>
        </form>
                <p>-</p>
        <form action="index.php?action=jobListings&ListingId=<?= $bookedMeetings[$i]->jobID?>" method="POST">
            <button>
                <p class="bookedJob"><?= htmlspecialchars($bookedMeetings[$i]->title) ?></p>
            </button>
        </form>
                <p>-</p>
                <p><?= substr($bookedMeetings[$i]->time_start, 0, 5)?></p>
                <p>-</p>

            <form action="index.php?action=cancelMeeting" method="POST">
                <input type="hidden" name="reserveID" value="<?=$bookedMeetings[$i]->id?>">
                <button>X</button>
            </form>
            <input type="checkbox" name="cancel" value="<?=$bookedMeetings[$i]->id?>">
        </div>
    <?php
        $prevDate = strtotime($bookedMeetings[$i]->date);
    } else {
        ?>
        <div class="meetingSubCard">
            <form action="index.php?action=talentProfile" method="POST">
            <input type="hidden" name="talentID" value="<?=$bookedMeetings[$i]->userID?>">
                    <button><p><?= htmlspecialchars($bookedMeetings[$i]->first_name) . " " . htmlspecialchars($bookedMeetings[$i]->last_name)?> </p></button>
            </form>
            <p>-</p>
            <form action="index.php?action=jobListings&ListingId=<?= $bookedMeetings[$i]->jobID?>" method="POST">
                <button>
                    <p class="bookedJob"><?= htmlspecialchars($bookedMeetings[$i]->title)?></p>
                </button>
            </form>
            <p>-</p>
            <p><?= substr($bookedMeetings[$i]->time_start, 0, 5)?></p>
        
            <form action="index.php?action=cancelMeeting" method="POST">
                <input type="hidden" name="reserveID" value="<?=$bookedMeetings[$i]->id?>">
                <button>X</button>
            </form>
            <input type="checkbox" name="cancel" value="<?=$bookedMeetings[$i]->id?>">
        </div>
    <?php
    }
    // if next day if different close the div for this card
    if (!empty($bookedMeetings[$i+1]->date) AND $bookedMeetings[$i+1]->date != $bookedMeetings[$i]->date) {
        ?>
        </div> 
        <?php
    // or if it's the last entry.
    } else if (empty($bookedMeetings[$i+1]->date)) {
        ?>
        </div> 
        <?php
    }
    ?>
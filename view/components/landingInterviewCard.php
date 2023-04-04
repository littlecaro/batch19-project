<?php
// print_r($entries);
if ($i == 0 OR $prevDate != strtotime($receives[$i]->date)) {
?>
<div class="landingCalCard landingInt">
    <div class="landingCalDate">
        <p><?= calDateToStr($receives[$i]->date) ?></p>
    </div>
    <div class="landingCalTime">
        <p><?= $receives[$i]->title ?>,</p>
        <p><?= $receives[$i]->name ?>,</p>
        <p><?= substr($receives[$i]->time_start, 0, 5) ?></p>
    </div>
    <?php
    $prevDate = strtotime($receives[$i]->date);
} else {
    ?>
    <div class="landingCalTime timeMid">
        <p><?= $receives[$i]->title ?>,</p>
        <p><?= $receives[$i]->name ?>,</p>
        <p><?= substr($receives[$i]->time_start, 0, 5) ?></p>
    </div>
    <?php
}
// if next day if different close the div for this card
if (!empty($receives[$i+1]->date) AND $receives[$i+1]->date != $receives[$i]->date) {
    ?>
    </div> 
    <?php
// or if it's the last entry.
} else if (empty($receives[$i+1]->date)) {
    ?>
    </div> 
    <?php
}

?>
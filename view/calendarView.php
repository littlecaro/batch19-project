<?php
    $title = "Calendar";
    ob_start();
?>
<link rel="stylesheet" href="./public/css/calendar.css">
<script defer src="./public/js/calendar.js"></script>

<div class="cal-container">
    <div class="cal">
        <div>
            <button class="prev"><-</button>
            <button class="next">-></button>
        </div>
    
        <table class="calendar"></table>
    </div>
    <div class="bottom">
        <div id="confirmChoices">
            <h1>Confirm your selection: </h1>
            <div id="dynaUpdate"></div>
        </div>
        <div id="confirmedContainer">
            <!-- <h1>Confirmed availability: </h1> -->
        </div>
        <div id="confirmedInterviews">
            <h1>Confirmed interviews: </h1>
        </div>
    </div>
</div>
    <script>
        const entries = <?php echo json_encode($result); ?>;
    </script>

<?php 
$content = ob_get_clean();
require('./view/userProfileTemplate.php');
?>
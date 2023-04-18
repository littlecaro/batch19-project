<?php

if (empty($_SESSION['id'])) {
    header('location: http://localhost/sites/batch19-project/index.php');
exit;
}

?>
<link rel="stylesheet" href="./public/css/calendar.css">
<script defer src="./public/js/calendar.js"></script>

<div class="cal-container">
    <div class="cal">
        <div>
            <button class="prev changeWeek"><-</button>
            <button class="next changeWeek">-></button>
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
<dialog id="favDialog">
  <form method="dialog">
    <p>Please submit your current entries before selecting a different week</p>
    <div>
      <button>Ok</button>
    </div>
  </form>
</dialog>
<script>
    const entries = <?php echo json_encode($entries); ?>;
    const receives = <?php echo json_encode($receives); ?>;
</script>

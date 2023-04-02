<?php
$title = "company dashboard";
ob_start();
?>

<!-- main -->
<div class="bizProfile">
    <div class="main">
        <h3>Booked Meetings</h3><br>
        <?php 
        for($i = 0; $i < count($bookedMeetings); $i++) {
            require('./view/components/bookedMeetingCard.php');
        }
        ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
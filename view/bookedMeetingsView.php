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
        <button onclick="cancelAllBookedMeetings()">Cancel all selected interviews</button>
        <p>Or cancel by role</p>
    </div>
</div>
<script>
    function cancelAllBookedMeetings() {
        const checkedBoxes = document.querySelectorAll("input[name=cancel]:checked");
        reserveID = [];
        for (let checkedBox of checkedBoxes) {
            reserveID.push({
            rID: `${checkedBox.defaultValue}`,
            });
        }
        reserveID = JSON.stringify(reserveID);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", `./index.php?action=cancelMeeting&reserveID=${reserveID}`);

        xhr.addEventListener("load", function () {
            location.reload();
            // console.log(xhr.responseText);
        });

        xhr.send(null);
    }

    
</script>
<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
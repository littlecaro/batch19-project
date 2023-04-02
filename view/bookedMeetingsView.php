<?php
$title = "company dashboard";
ob_start();
?>

<!-- main -->
<div class="bizProfile">
    <div class="main">
        <h3>Booked Meetings</h3><br>
        <?php 
        if ($bookedMeetings) {
        for($i = 0; $i < count($bookedMeetings); $i++) {
            require('./view/components/bookedMeetingCard.php');
        }
        ?>
        <button onclick="cancelAllBookedMeetings()">Cancel all selected interviews</button>
        <label for="roles">Or cancel by role</label>
        <select name="roles" id="roles">
        </select>
        <button id="cancelRolesBtn">Cancel all meetings for selected role</button>
    <?php
    }
    ?>
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

    const jobs = document.querySelectorAll('.bookedJob');
    const jobsArr = Array.from(jobs);
    jobsArr.sort(sorter);
    function sorter(a, b) {
      return a.textContent.localeCompare(b.textContent);
    }
    for(let i = 0; i < jobsArr.length; i++) {
        if (i === 0 || jobsArr[i-1].textContent !== jobsArr[i].textContent) {
            let option = document.createElement('option');
            option.setAttribute('value',jobsArr[i].textContent);
            option.textContent = jobsArr[i].textContent;
            roles.appendChild(option);
        }
    }

    // query selector instead of direct target incase no meetings are loaded.
    const cancelRolesBtn = document.querySelector('#cancelRolesBtn');
    if (cancelRolesBtn) {
        cancelRolesBtn.addEventListener('click', () => {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", `./index.php?action=cancelRoleMeetings&reserveJob=${roles.value}`);

            xhr.addEventListener("load", function () {
                location.reload();
                // console.log(xhr.responseText);
            });

            xhr.send(null);
        });
    }
</script>
<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
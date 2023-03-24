<?php
$title = "company dashboard";
ob_start();
?>

<!-- main -->
<div class="userProfile">
    <div class="main">
        <h3>Job Listings</h3><br>
        <a href="./index.php?action=createJobForm">
            <button class="button">ADD A JOB</button>
        </a>
    </div>
</div>
<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
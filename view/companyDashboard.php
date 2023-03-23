<?php
$title = "company dashboard";
ob_start();
?>

<!-- main -->

<div class="main">
    <h3>Company Information</h3><br>
    <h4>Company Name: </h4>
    <h4>Company Adddress: </h4>
    <a href="./index.php?action=addNewJob" style="text-align:right">
        <button class="button">ADD A JOB</button>
    </a>
</div>

<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
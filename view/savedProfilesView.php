<?php
$title = "company dashboard";
ob_start();
?>

<!-- main -->

<div class="main">
    <h3>Saved Profiles</h3><br>
    <h4>asd</h4>
    <a href="./index.php?action=addNewJob">
        <button class="button">ADD A JOB</button>
    </a>
</div>

<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
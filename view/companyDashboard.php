<?php
$title = "company dashboard";
ob_start();
?>

<!-- main -->

<div class="main">
    <h3>Company Information</h3><br>
    <h4>Company Name: </h4>
    <h4>Company Adddress: </h4>
</div>

<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
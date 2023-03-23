<?php
$title = "company dashboard";
ob_start();
?>

<!-- main -->

<div class="main">
    <h3>Saved Profiles</h3><br>

</div>

<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
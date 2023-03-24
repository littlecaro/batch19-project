<?php
$title = "company dashboard";
ob_start();
?>

<!-- main -->
<div class="userProfile">
    <div class="main">
        <h3>Employee Info</h3><br>
    </div>
</div>
<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
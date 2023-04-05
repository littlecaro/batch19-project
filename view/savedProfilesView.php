<?php
if (empty($_SESSION['id'] AND getCompanyID($_SESSION['id']))) {
    header('location: http://localhost/sites/batch19-project/index.php');
exit;
}
$title = "company dashboard";
ob_start();
?>

<!-- main -->
<div class="bizProfile">
    <div class="main">
        <h3>Saved Profiles</h3><br>
    </div>
</div>

<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
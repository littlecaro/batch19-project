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
        <h3>Employee Info</h3><br>
        <form action="index.php?action=updateEmployeeInfo" method="POST">
            <table id="table">
                <tr>
                    <th>First name</th>
                    <td>
                        <input type="text" name="firstName" id="firstName" value="<?= $employeeInfo->first_name ?>">
                        <span class="required" id="demo1"></span>
                    </td>
                </tr>
                <tr>
                    <th>Last name</th>
                    <td>
                        <input type="text" name="lastName" id="lastName" value="<?= $employeeInfo->last_name ?>">
                        <span class="required" id="demo2"></span>
                    </td>
                </tr>
                <tr>
                    <th>Job Title</th>
                    <td>
                        <input type="text" name="jobTitle" id="jobTitle" placeholder="Enter your job title" value="<?= $employeeInfo->user_bio ?>">
                        <span class="required" id="demo4"></span>
                    </td>
                </tr>
            </table>
            <br>
            <button class="button" id="save">SAVE</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
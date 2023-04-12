<?php
// if (empty($_SESSION['id']) or empty($_SESSION['company_id'])) {
//     throw new Exception("Not authorized");
//     exit;
// }
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
        <h3>Company Info</h3><br>
        <form action="index.php?action=updateCompanyInfo" method="POST" enctype="multipart/form-data">
            <table id="table">
                <tr>
                    <th>Name</th>
                    <td>
                        <input type="text" name="bizName" id="bizName" placeholder="Enter a company name" value="<?= htmlspecialchars($companyInfo->name)?>">
                    </td>
                </tr>
                <tr>
                    <th id="jobdescription">Address</th>
                    <td>
                        <textarea id="bizAddress" name="bizAddress" rows="6" cols="33" placeholder="Enter address" value="<?= htmlspecialchars($companyInfo->company_address ?? "") ?>"><?= htmlspecialchars($companyInfo->company_address ?? "") ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>
                        <input type="text" name="email" id="email" placeholder="Enter an email" value="<?= !empty($companyInfo->email) ? htmlspecialchars($companyInfo->email) : "" ?>">
                    </td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td>
                        <input type="text" name="phone" id="phone" placeholder="Enter a phone number" value="<?= htmlspecialchars($companyInfo->phone_number ?? "") ?>">
                    </td>
                </tr>
                <tr>
                    <th>Web site</th>
                    <td>
                        <input type="text" name="webSite" id="webSite" placeholder="Enter a web site address" value="<?= htmlspecialchars($companyInfo->website_address ?? "") ?>">
                    </td>
                </tr>
                <th>Company logo upload<br><br><br><br><br></th>
                <td>
                    <button type="button" id="photoUploadClick" onclick="logoUpload.click()"><img id="imgPreview" src="<?= htmlspecialchars($companyInfo->logo_img) ?? "./public/images/default.svg" ?>" width="100px" height="100px"></button><br><br>
                    <input type="file" name="logoUpload" id="logoUpload" accept="image/*">
                </td>
                </tr>
                <input type="hidden" name="oldLogo" value="<?= htmlspecialchars($companyInfo->logo_img)?? "./public/images/default.svg" ?>">
            </table>
            <br>
            <button class="button" id="save">SAVE</button>
        </form>
    </div>
</div>
<script>
    logoUpload.onchange = () => {
        const file = logoUpload.files[0];
        console.log(file);
        if (file) {
            imgPreview.src = URL.createObjectURL(file);
        }
    };
</script>

<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
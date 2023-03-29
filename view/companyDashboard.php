<?php
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
                        <input type="text" name="bizName" id="bizName" placeholder="Enter a company name" value="<?= $companyInfo->name ?>">
                        <span class="required" id="demo1"></span>
                    </td>
                </tr>
                <tr>
                    <th id="jobdescription">Address</th>
                    <td>
                        <textarea id="bizAddress" name="bizAddress" rows="6" cols="33" placeholder="Enter address" value="<?= $companyInfo->company_address ?>"><?= $companyInfo->company_address ?></textarea>
                        <span class="required" id="demo2"></span>
                    </td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>
                        <input type="text" name="email" id="email" placeholder="Enter an email" value="<?= $companyInfo->email ?>">
                        <span class="required" id="demo1"></span>
                    </td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td>
                        <input type="text" name="phone" id="phone" placeholder="Enter a phone number" value="<?= $companyInfo->phone_number ?>">
                        <span class="required" id="demo1"></span>
                    </td>
                </tr>
                <tr>
                    <th>Web site</th>
                    <td>
                        <input type="text" name="webSite" id="webSite" placeholder="Enter a web site address" value="<?= $companyInfo->website_address ?>">
                        <span class="required" id="demo1"></span>
                    </td>
                </tr>
                <th id="jobdescription">Company logo upload</th>
                <td>
                    <button type="button" onclick="logoUpload.click()"><img id="imgPreview" src="<?= $companyInfo->logo_img ?? "./public/images/default.svg" ?>" width="200px"></button><br><br>
                    <input type="file" name="logoUpload" id="logoUpload">
                    <span class="required" id="demo1"></span>
                </td>
                </tr>
                <input type="hidden" name="oldLogo" value="<?= $companyInfo->logo_img ?? "./public/images/default.svg" ?>">
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
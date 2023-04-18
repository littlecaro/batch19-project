<?php
if (empty($_SESSION['id'] AND getCompanyID($_SESSION['id']))) {
    header('location: http://localhost/sites/batch19-project/index.php');
exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./public/css/styleBizProfile.css" />
    <link rel="shortcut icon" href="./public/images/favicon_io/favicon.ico" type="image/x-icon">
    <script src="https://kit.fontawesome.com/c8900437f0.js" crossorigin="anonymous"></script>
    <!-- We need to choose better font-family: googlefonts?! -->
    <!-- <script defer src="./public/js/scriptUserProfile.js"></script> -->
    <title><?= $title ?></title>


<body>
    <?php require("./view/components/companyHeader.php"); ?>
    <?php require("./view/components/companySidebar.php"); ?>
    <?= $content; ?>
    <?php include "./view/chatView.php"; ?>
</body>
<script>
    const userId = <?= $_SESSION["id"] ?>
</script>
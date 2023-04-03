<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./public/css/styleBizProfile.css" />
    <!-- We need to choose better font-family: googlefonts?! -->
    <script defer src="./public/js/scriptUserProfile.js"></script>
    <title><?= $title ?></title>

<body>
    <?php require("./view/components/companyHeader.php"); ?>
    <?php require("./view/components/companySidebar.php"); ?>
    <?php require("./view/components/footer.php"); ?>
    <?= $content; ?>
</body>
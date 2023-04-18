<?php

if (empty($_SESSION['id'])) {
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
    <script src="https://kit.fontawesome.com/c8900437f0.js" crossorigin="anonymous"></script>
    <!-- fontawesome script link -->
    <link rel="stylesheet" href="./public/css/styleUserProfile.css" />
    <link rel="shortcut icon" href="./public/images/favicon_io/favicon.ico" type="image/x-icon">
    <!-- We need to choose better font-family: googlefonts?! -->
    <script src="./public/js/scriptUserProfile.js"></script>
    <title>WaygukIn</title>
</head>

<body>
    <?php require("./view/components/userHeader.php"); ?>
    <?= $content; ?>

    <script>
        const userId = <?= $_SESSION["id"] ?>
    </script>
    <?php
    include "./view/chatView.php"; // TODO: move this to logged in view
    ?>
</body>

</html>
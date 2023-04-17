<?php
$_SESSION["userId"] = 1; ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/9d1def913c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./public/css/styleMain.css" />
    <link rel="shortcut icon" href="./public/images/favicon_io/favicon.ico" type="image/x-icon">
    <title><?= $title; ?></title>
</head>

<body>
    <?php require("./view/components/header.php"); ?>
    <?= $content; ?>
    <?php require("./view/components/footer.php"); ?>
</body>

</html>
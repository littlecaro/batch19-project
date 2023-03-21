<?php session_start();
$_SESSION["userId"] = 1; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/9d1def913c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./public/css/styleMain.css" />
    <link rel="stylesheet" href="./public/css/messenger.css">
    <script>
        const userId = <?= $_SESSION["userId"] ?>
    </script>
    <title><?= $title; ?></title>
</head>

<body>
    <?= $content; ?>
</body>

</html>

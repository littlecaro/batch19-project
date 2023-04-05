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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./public/css/styleUserProfileSkills.css">
    <title>Skills</title>
</head>

<body>
    <?= $content; ?>
</body>

</html>
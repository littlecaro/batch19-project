<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./public/css/styleUserProfileSkills.css">
    <script>
        // Pass the data from PHP to JavaScript
        const skills = <?= json_encode($skills); ?>;
        const languages = <?= json_encode($languages); ?>;
        const cities = <?= json_encode($cities); ?>;
    </script>
    <title>Skills</title>
</head>

<body>
    <?= $content; ?>
</body>

</html>
<?php

if (empty($_SESSION['id'])) {
    header('location: http://localhost/sites/batch19-project/index.php');
exit;
}

?>
<link rel="stylesheet" href="./public/css/styleUserProfileSkills.css">
<div id="<?= $containerId ?>Container" class="multi-selector">
    <div class="input-container">
        <input type="text">
        <div class="autocomplete-results"></div>
    </div>
    <div class="selected-items-container"></div>
    <input class="hidden" type="hidden" name="<?= $containerId ?>">
    <input type="hidden">
</div>
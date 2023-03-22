<?php
$title = "Talent Search";
ob_start();
?>
<div class="talentMain">
    <div class="talentHeader">
        <button id="editSearch">Edit Search</button>
    </div>
    <div class="talentSide">

    </div>
    <div class="talentCenter">
        <div class="talentSearchMain">
            <?= $talentCards; ?>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require('./view/template.php');
?>
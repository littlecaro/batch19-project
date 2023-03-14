<?php
    $title = "Error!";
    ob_start();
?>
<h1>ERROR!</h1>
<h2><?= $errorMsg ?></h2>

<?php
    $content = ob_get_clean();
    require("./view/template.php");
?>
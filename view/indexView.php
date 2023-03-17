<?php
$title = "TODO:CHANGE ME";
ob_start();
?>

<h1>Hello World!</h1>

<?php
include "./view/chatView.php";
$content = ob_get_clean();
require('./view/template.php');
?>
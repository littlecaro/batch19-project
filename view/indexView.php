<!-- View - responsible for display of the page. the frontend -->
<?php
    $title = "TODO:change";
    ob_start();
?>

<h1>Hello World!</h1>

<?php 
$content = ob_get_clean();
require('./view/template.php');
?>
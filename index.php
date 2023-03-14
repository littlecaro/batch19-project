<?php
// ROUTER

require("./controller/controller.php");

try{
    $action = $_REQUEST['action'] ?? null;
    
    switch ($action){
        
        default:
        showIndex();
        break;
    }
} catch (Exception $e){
    $errorMsg = $e->getMessage();
    require ("./view/errorView.php");
}
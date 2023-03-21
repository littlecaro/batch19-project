<?php
// ROUTER

require("./controller/controller.php");

try{
    $action = $_REQUEST['action'] ?? null;
    
    switch ($action){
        case "updateCalendar":
            $data = $_REQUEST['data'] ?? "";
            if ($data) {
                $data = json_decode($data,true);
                addCalendar($data);
            } else {
                throw new Exception ("No calender inputs submitted");
            }
            break;
        case "loadCalendar":
            $user_id = $_SESSION['user_id'] ?? 1;
            showCalendar($user_id);
            break;
        default:
            showIndex();
            break;
    }
} catch (Exception $e){
    $errorMsg = $e->getMessage();
    require ("./view/errorView.php");
}
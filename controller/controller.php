<?php

require_once('./model/calendarManager.php');

function showIndex(){
    require("./view/indexView.php");
}

function addCalendar($data) {
    for ($i = 0; $i < count($data); $i++) {
        $date = strip_tags($data[$i]['date']);
        $hour = strip_tags($data[$i]['hour']);

        $calendarManager = new CalendarManager();
        $result = $calendarManager->insertCalendar($date, $hour);
        if (!$result) {
            throw new Exception("Unable to add entries");
        }
        header("location: index.php?action=loadCalendar");
    }
}

function showCalendar($user_id) {
        $calendarManager = new CalendarManager();
        $result = $calendarManager->loadCalendar($user_id);
        require('./view/calendarView.php');
}
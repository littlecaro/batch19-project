<?php

class Manager{
    protected function dbConnect() {
        $HOST = "localhost";
        $DATABASE = "wcoding";
        $USERNAME = "root";
        $PASSWORD = "";
        $db = new PDO("mysql:host=$HOST;dbname=$DATABASE;charset=utf8", $USERNAME, $PASSWORD);
        $db->setAttribute((PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }
}
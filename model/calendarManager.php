<?php
require_once('./model/Manager.php');

class CalendarManager extends Manager
{
    public function loadCalendar($user_id)
    {
        $db = $this->dbConnect();

        $user_id = strip_tags($user_id);

        $req = $db->prepare('SELECT * FROM user_availability WHERE user_id = :user_id ORDER BY date ASC');

        $req->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $req->execute();

        $entries = $req->fetchAll(PDO::FETCH_OBJ);

        return $entries;
    }

    public function insertCalendar($date, $hour)
    {
        $db = $this->dbConnect();

        $user_id = $_SESSION['user_id'] ?? 1;

        $query = 'INSERT INTO user_availability (user_id, date, time_start, is_active) VALUES (:user_id,:date_str,:time_str,1)';

        $query = $db->prepare($query);
        $query->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $query->bindParam('date_str', $date, PDO::PARAM_STR);
        $query->bindParam('time_str', $hour, PDO::PARAM_STR);

        return $query->execute();
    }
}

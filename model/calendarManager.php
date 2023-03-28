<?php
require_once('./model/Manager.php');

class CalendarManager extends Manager
{
    public function loadCalendar($user_id)
    {
        $db = $this->dbConnect();

        $user_id = strip_tags($user_id);

        $req = $db->prepare(
                            'SELECT ua.date, ua.time_start 
                            FROM user_availability ua
                            WHERE NOT EXISTS
                                (SELECT user_availability_id FROM reservations r WHERE r.user_availability_id = ua.id )
                                AND ua.user_id = :user_id
                                ORDER BY ua.date, ua.time_start');

        $req->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $req->execute();

        $entries = $req->fetchAll(PDO::FETCH_OBJ);

        return $entries;
    }

    public function loadInterviews($user_id)
    {
        $db = $this->dbConnect();

        $user_id = strip_tags($user_id);

        $req = $db->prepare(
            'SELECT j.title, c.name, ua.date, ua.time_start, r.id
            FROM reservations r
                INNER JOIN user_availability ua
                ON r.user_availability_id = ua.id
                INNER JOIN jobs j
                ON r.job_id = j.id
                INNER JOIN companies c
                ON r.company_id = c.id
                WHERE ua.user_id = :user_id
                ORDER BY ua.date, ua.time_start');

        $req->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $req->execute();

        $receives = $req->fetchAll(PDO::FETCH_OBJ);

        return $receives;
    }

    public function insertCalendar($date, $time) 
    {
        $db = $this->dbConnect();

        $user_id = $_SESSION['user_id'] ?? 1;

        $query = '  INSERT INTO user_availability (user_id, date, time_start, is_active) 
                    VALUES (:user_id,:date_str,:time_str,1)';

        $query = $db->prepare($query);
        $query->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $query->bindParam('date_str', $date, PDO::PARAM_STR);
        $query->bindParam('time_str', $time, PDO::PARAM_STR);

        return $query->execute();
    }

    public function updateDeletion($date, $time) 
    {
        $db = $this->dbConnect();
        
        $user_id = $_SESSION['user_id'] ?? 1;

        $query = '  DELETE FROM user_availability 
                    WHERE user_id = :user_id 
                    AND date = :date_php 
                    AND time_start = :time_php 
                    AND is_active = 1';

        $query = $db->prepare($query);
        $query->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $query->bindParam('date_php', strip_tags($date), PDO::PARAM_STR);
        $query->bindParam('time_php', strip_tags($time), PDO::PARAM_STR);

        return $query->execute();
    }
}

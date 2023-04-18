<?php
require_once('./model/Manager.php');

class CalendarManager extends Manager
{
    public function loadCalendar($user_id)
    {
        $db = $this->dbConnect();

        $user_id = strip_tags($user_id);

        $req = $db->prepare(
            'SELECT ua.date, ua.time_start, ua.id
                            FROM user_availability ua
                            WHERE NOT EXISTS
                                (SELECT user_availability_id FROM reservations r WHERE r.user_availability_id = ua.id )
                                AND ua.user_id = :user_id
                                ORDER BY ua.date, ua.time_start'
        );

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
                AND r.is_active = 1
                ORDER BY ua.date, ua.time_start'
        );

        $req->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $req->execute();

        $receives = $req->fetchAll(PDO::FETCH_OBJ);

        return $receives;
    }

    public function loadPastInterviews($user_id)
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
                AND r.is_active = 0
                ORDER BY ua.date, ua.time_start'
        );

        $req->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $req->execute();

        $receives = $req->fetchAll(PDO::FETCH_OBJ);

        return $receives;
    }

    public function insertCalendar($date, $time)
    {
        $db = $this->dbConnect();

        // $user_id = $_SESSION['user_id'] ?? 1;

        $query = '  INSERT INTO user_availability (user_id, date, time_start, is_active) 
                    VALUES (:user_id,:date_str,:time_str,1)';

        $query = $db->prepare($query);
        $query->bindParam('user_id', $_SESSION['id'], PDO::PARAM_INT);
        $query->bindParam('date_str', $date, PDO::PARAM_STR);
        $query->bindParam('time_str', $time, PDO::PARAM_STR);

        return $query->execute();
    }

    public function updateDeletion($date, $time, $id = null)
    {
        $db = $this->dbConnect();

        $id ?? $_SESSION['id'];

        $query = '  DELETE FROM user_availability 
                    WHERE user_id = :user_id 
                    AND date = :date_php 
                    AND time_start = :time_php 
                    AND is_active = 1';

        $query = $db->prepare($query);
        $query->bindParam('user_id', $id, PDO::PARAM_INT);
        $query->bindParam('date_php', $date, PDO::PARAM_STR);
        $query->bindParam('time_php', $time, PDO::PARAM_STR);

        return $query->execute();
    }

    public function insertMeeting($uaID, $compID, $jobID)
    {
        $db = $this->dbConnect();

        $query = '  INSERT INTO reservations (user_availability_id, company_id, job_id) 
                    VALUES (:uaID, :compID, :jobID)';

        $query = $db->prepare($query);
        $query->bindParam('uaID', $uaID, PDO::PARAM_INT);
        $query->bindParam('compID', $compID, PDO::PARAM_INT);
        $query->bindParam('jobID', $jobID, PDO::PARAM_INT);

        return $query->execute();
    }

    public function getMeetingDetails($uaID)
    {
        $db = $this->dbConnect();

        $sql = 'SELECT
    user_availability.date as dateStart,
    user_availability.time_start as timeStart,
    companies.name as companyName,
    jobs.title as jobTitle,
    users1.first_name as firstName,
    users1.last_name as lastName,
    users1.id as userId,
    users.id As companyUserId
From
    reservations Inner Join
    companies On reservations.company_id = companies.id Inner Join
    users On users.company_id = companies.id Inner Join
    user_availability On reservations.user_availability_id = user_availability.id Inner Join
    jobs On reservations.job_id = jobs.id Inner Join
    users users1 On user_availability.user_id = users1.id WHERE user_availability.id = :uaId';

        $query = $db->prepare($sql);
        $query->bindParam('uaId', $uaID, PDO::PARAM_INT);
        $query->execute();
        $result =  $query->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function loadTalentInterviews($id)
    {
        $compID = getCompanyID($_SESSION['id']);

        $db = $this->dbConnect();

        $user_id = strip_tags($id);

        $req = $db->prepare(
            'SELECT j.title, c.name, ua.date, ua.time_start, r.id
                            FROM reservations r
                                INNER JOIN user_availability ua
                                ON r.user_availability_id = ua.id
                                INNER JOIN jobs j
                                ON r.job_id = j.id
                                INNER JOIN companies c
                                ON r.company_id = c.id
                                WHERE c.id = :comp_id
                                AND ua.user_id = :user_id
                                AND r.is_active = 1
                                ORDER BY ua.date, ua.time_start'
        );

        $req->bindParam('user_id', $id, PDO::PARAM_INT);
        $req->bindParam('comp_id', $compID, PDO::PARAM_INT);
        $req->execute();

        $interviews = $req->fetchAll(PDO::FETCH_OBJ);

        return $interviews;
    }

    public function loadPastTalentInterviews($id)
    {
        $compID = getCompanyID($_SESSION['id']);

        $db = $this->dbConnect();

        $user_id = strip_tags($id);

        $req = $db->prepare(
            'SELECT j.title, c.name, ua.date, ua.time_start, r.id
                            FROM reservations r
                                INNER JOIN user_availability ua
                                ON r.user_availability_id = ua.id
                                INNER JOIN jobs j
                                ON r.job_id = j.id
                                INNER JOIN companies c
                                ON r.company_id = c.id
                                WHERE c.id = :comp_id
                                AND ua.user_id = :user_id
                                AND r.is_active = 0
                                ORDER BY ua.date, ua.time_start'
        );

        $req->bindParam('user_id', $id, PDO::PARAM_INT);
        $req->bindParam('comp_id', $compID, PDO::PARAM_INT);
        $req->execute();

        $interviews = $req->fetchAll(PDO::FETCH_OBJ);

        return $interviews;
    }

    public function updateMeeting($id) {
        $db = $this->dbConnect();

        $query = '  UPDATE reservations 
                    SET is_active = 0 
                    WHERE id = :id';

        $query = $db->prepare($query);
        $query->bindParam('id', $id, PDO::PARAM_INT);

        return $query->execute();
    }
}

<?php
require_once "Manager.php";
class CompanyManager extends Manager
{
    public function insertNewJob($jobTitle, $jobStory, $salaryMin, $salaryMax, $cities, $deadline)
    {
        $db = $this->dbConnect();
        $query = "INSERT INTO jobs 
        (title, company_id, job_description, city_id, salary_min, salary_max, deadline) 
        VALUES(:title, :companyId, :description, :cityId, :salaryMin, :salaryMax, :deadline)";


        $req = $db->prepare($query);
        $req->bindParam("title", $jobTitle, PDO::PARAM_STR);
        $req->bindParam("companyId", $_SESSION['company_id'], PDO::PARAM_INT); // TODO: get companyId from $_SESSION
        $req->bindParam("description", $jobStory, PDO::PARAM_STR);
        $req->bindParam("cityId", $cities, PDO::PARAM_INT);
        $req->bindParam("salaryMin", $salaryMin, PDO::PARAM_INT);
        $req->bindParam("salaryMax", $salaryMax, PDO::PARAM_INT);
        $req->bindParam("deadline", $deadline, PDO::PARAM_STR);

        $result = $req->execute();
        return $result;
    }

    public function fetchCompanyInfo($compID)
    {
        $db = $this->dbConnect();
        $select = "SELECT *, DATE(date_created) AS date_created FROM companies WHERE id = :companyId";
        $req = $db->prepare($select);
        $req->bindParam("companyId", $compID, PDO::PARAM_INT); // TODO: get companyId from $_SESSION

        $req->execute();
        $companyInfo = $req->fetch(PDO::FETCH_OBJ);
        return $companyInfo;
    }

    public function changeCompanyInfo($bizName, $bizAddress, $email, $phone, $webSite, $logo)

    {
        $db = $this->dbConnect();
        $query = "UPDATE companies SET name = :bizName, company_address = :bizAddress, email = :email, phone_number = :phone, website_address = :webSite, logo_img = :logo WHERE ID = :companyId";
        $req = $db->prepare($query);
        $req->bindParam("companyId", $_SESSION['company_id'], PDO::PARAM_INT);
        $req->bindParam("bizName", $bizName, PDO::PARAM_STR);
        $req->bindParam("bizAddress", $bizAddress, PDO::PARAM_STR);
        $req->bindParam("email", $email, PDO::PARAM_STR);
        $req->bindParam("phone", $phone, PDO::PARAM_INT);
        $req->bindParam("webSite", $webSite, PDO::PARAM_STR);
        $req->bindParam("logo", $logo, PDO::PARAM_STR);

        $result = $req->execute();
        $req->closeCursor();
        // return $result;

        // Create an SQL query to update the users table
        // Set profile_photo to your $logo variable
        // WHERE the user_id matches the logged in user's id ($_SESSION['id'])

        $query = "UPDATE users SET email = :email, profile_picture = :logo, phone_number = :phone  WHERE id = :userID";
        $req = $db->prepare($query);
        $req->bindParam("userID", $_SESSION['id'], PDO::PARAM_INT);
        $req->bindParam("email", $email, PDO::PARAM_STR);
        $req->bindParam("logo", $logo, PDO::PARAM_STR);
        $req->bindParam("phone", $phone, PDO::PARAM_INT);

        $result2 = $req->execute();
        return [$result, $result2];
    }

    public function fetchEmployeeInfo()
    {
        $db = $this->dbConnect();
        $select = "SELECT first_name, last_name, user_bio FROM users WHERE id = :userID";
        $req = $db->prepare($select);
        $req->bindParam("userID", $_SESSION['id'], PDO::PARAM_INT);

        $req->execute();
        $employeeInfo = $req->fetch(PDO::FETCH_OBJ);
        return $employeeInfo;
    }

    public function changeEmployeeInfo($firstName, $lastName, $jobTitle)
    {
        $db = $this->dbConnect();
        $query = "UPDATE users SET first_name = :firstName, last_name = :lastName, user_bio = :jobTitle WHERE id = :userID";
        $req = $db->prepare($query);
        $req->bindParam("userID", $_SESSION['id'], PDO::PARAM_INT);
        $req->bindParam("firstName", $firstName, PDO::PARAM_STR);
        $req->bindParam("lastName", $lastName, PDO::PARAM_STR);
        $req->bindParam("jobTitle", $jobTitle, PDO::PARAM_STR);

        $result = $req->execute();
        return $result;
    }

    public function fetchCompanyBasicInfo()
    {
        $db = $this->dbConnect();
        $select = "SELECT logo_img, name, DATE(date_created) AS date_created FROM companies WHERE id = :companyId";
        $req = $db->prepare($select);
        $req->bindParam("companyId", $_SESSION['company_id'], PDO::PARAM_INT); // TODO: get companyId from $_SESSION

        $req->execute();
        $companyInfo = $req->fetch(PDO::FETCH_OBJ);
        return $companyInfo;
    }

    public function fetchBookedMeetings()
    {
        $compID = getCompanyID($_SESSION['id']);
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT u.first_name, u.last_name, j.title, ua.date, ua.time_start, r.id, u.id AS userID, j.id AS jobID
                            FROM reservations r
                                INNER JOIN user_availability ua
                                ON r.user_availability_id = ua.id
                                INNER JOIN jobs j
                                ON r.job_id = j.id
                                INNER JOIN users u
                                ON u.id = ua.user_id
                                WHERE r.company_id = :compID
                                AND r.is_active = 1
                                ORDER BY ua.date, ua.time_start');
        $req->bindParam("compID", $compID, PDO::PARAM_INT); // TODO: get companyId from $_SESSION

        $req->execute();
        $bookedMeetings = $req->fetchAll(PDO::FETCH_OBJ);
        return $bookedMeetings;
    }

    public function cancelMeeting($rID)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM reservations 
                                WHERE id = :rID');
        $req->bindParam("rID", $rID, PDO::PARAM_INT);

        return $req->execute();
    }

    public function cancelRoleMeetings($rJob, $compID) {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE r 
                                FROM reservations r
                                INNER JOIN jobs j
                                ON j.title = :rJob
                                WHERE r.company_id = :compID
                                AND  r.job_id = j.id');
        $req->bindParam("rJob", $rJob, PDO::PARAM_STR);
        $req->bindParam("compID", $compID, PDO::PARAM_INT);

        return $req->execute();
    }
}

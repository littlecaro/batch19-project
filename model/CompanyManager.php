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

        $COMPANY_ID = 1; // TODO: REMOVE THIS!!
        $req = $db->prepare($query);
        $req->bindParam("title", $jobTitle, PDO::PARAM_STR);
        $req->bindParam("companyId", $COMPANY_ID, PDO::PARAM_INT); // TODO: get companyId from $_SESSION
        $req->bindParam("description", $jobStory, PDO::PARAM_STR);
        $req->bindParam("cityId", $cities, PDO::PARAM_INT);
        $req->bindParam("salaryMin", $salaryMin, PDO::PARAM_INT);
        $req->bindParam("salaryMax", $salaryMax, PDO::PARAM_INT);
        $req->bindParam("deadline", $deadline, PDO::PARAM_STR);

        $result = $req->execute();
        return $result;
    }

    public function fetchCompanyInfo()
    {
        $COMPANY_ID = 1; // TODO: REMOVE THIS!!
        $db = $this->dbConnect();
        $select = "SELECT *, DATE(date_created) AS date_created FROM companies WHERE id = :companyId";
        $req = $db->prepare($select);
        $req->bindParam("companyId", $COMPANY_ID, PDO::PARAM_INT); // TODO: get companyId from $_SESSION

        $req->execute();
        $companyInfo = $req->fetch(PDO::FETCH_OBJ);
        return $companyInfo;
    }

    public function changeCompanyInfo($bizName, $bizAddress, $email, $phone, $webSite, $logo)

    {
        $COMPANY_ID = 1;  // TODO: REMOVE THIS!!
        $db = $this->dbConnect();
        $query = "UPDATE companies SET name = :bizName, company_address = :bizAddress, email = :email, phone_number = :phone, website_address = :webSite, logo_img = :logo WHERE ID = :companyId";
        $req = $db->prepare($query);
        $req->bindParam("companyId", $COMPANY_ID, PDO::PARAM_INT);
        $req->bindParam("bizName", $bizName, PDO::PARAM_STR);
        $req->bindParam("bizAddress", $bizAddress, PDO::PARAM_STR);
        $req->bindParam("email", $email, PDO::PARAM_STR);
        $req->bindParam("phone", $phone, PDO::PARAM_INT);
        $req->bindParam("webSite", $webSite, PDO::PARAM_STR);
        $req->bindParam("logo", $logo, PDO::PARAM_STR);

        $result = $req->execute();
        return $result;
    }

    public function fetchEmployeeInfo()
    {
        $USER_ID = 1; // TODO: REMOVE THIS!!
        $db = $this->dbConnect();
        $select = "SELECT first_name, last_name, user_bio FROM users WHERE id = :userID";
        $req = $db->prepare($select);
        $req->bindParam("userID", $USER_ID, PDO::PARAM_INT); // TODO: get companyId from $_SESSION

        $req->execute();
        $employeeInfo = $req->fetch(PDO::FETCH_OBJ);
        return $employeeInfo;
    }

    public function changeEmployeeInfo($firstName, $lastName, $jobTitle)
    {
        $userID = 1;
        $db = $this->dbConnect();
        $query = "UPDATE users SET first_name = :firstName, last_name = :lastName, user_bio = :jobTitle WHERE id = :userID";
        $req = $db->prepare($query);
        $req->bindParam("userID", $userID, PDO::PARAM_INT);
        $req->bindParam("firstName", $firstName, PDO::PARAM_STR);
        $req->bindParam("lastName", $lastName, PDO::PARAM_STR);
        $req->bindParam("jobTitle", $jobTitle, PDO::PARAM_STR);

        $result = $req->execute();
        return $result;
    }

    public function fetchCompanyBasicInfo()
    {
        $COMPANY_ID = 1; // TODO: REMOVE THIS!!
        $db = $this->dbConnect();
        $select = "SELECT logo_img, name, DATE(date_created) AS date_created FROM companies WHERE id = :companyId";
        $req = $db->prepare($select);
        $req->bindParam("companyId", $COMPANY_ID, PDO::PARAM_INT); // TODO: get companyId from $_SESSION

        $req->execute();
        $companyInfo = $req->fetch(PDO::FETCH_OBJ);
        return $companyInfo;
    }
}

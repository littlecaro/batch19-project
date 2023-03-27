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
}

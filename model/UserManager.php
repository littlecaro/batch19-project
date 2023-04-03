<?php
require_once "Manager.php";
class UserManager extends Manager
{

    public function getUserByEmail($userEmail)
    {
        $db = $this->dbConnect();
        $sqlEmail = $db->prepare('SELECT * FROM users WHERE email = ?'); // query prepare the DB to see if the user exists - asking data from the users table 
        $sqlEmail->execute([$userEmail]); // ^ asking for the id, email... info ^
        $user = $sqlEmail->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    public function insertUserGoogle($firstName, $lastName, $email, $picture)
    {
        $db = $this->dbConnect();
        // if user doesn't exist, prepare an INSERT query // If they are NOT in the DB, insert them [firstname, lastname, email, profile photo];
        $insertUser = 'INSERT INTO users (first_name, last_name, email, profile_picture, login_type) 
        VALUES (:inFirst_name, :inLast_name, :inEmail, :inProfile_picture, 0); 
        SET @last_id_in_table1 = LAST_INSERT_ID(); 
        INSERT INTO education (user_id) VALUES (@last_id_in_table1);  --// inserting id for education
        INSERT INTO professional_experience (user_id) VALUES (@last_id_in_table1); -- // inserting id for professional
        INSERT INTO user_skill_map (user_id) VALUES (@last_id_table1);';


        $req = $db->prepare($insertUser);
        // your value is the decodedToken from the JSon and -> selecting the specific title from there
        $req->bindParam('inFirst_name',  $firstName,  PDO::PARAM_STR);
        $req->bindParam('inLast_name',  $lastName,  PDO::PARAM_STR);
        $req->bindParam('inEmail',  $email,  PDO::PARAM_STR);
        $req->bindParam('inProfile_picture',  $picture,  PDO::PARAM_STR); // (token, value ,type)               
        return $req->execute();
    }

    public function insertUser($firstName, $lastName, $email, $pwd)
    {
        $db = $this->dbConnect();
        //hash pw

        $pwdHash = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

        //insert into db
        $preparedinsertSql = "INSERT INTO users (first_name, last_name, password, email, login_type)
        VALUES (:firstName, :lastName, :pwdHash, :email, 0)";
        // 0 is for email login
        $req = $db->prepare($preparedinsertSql);
        $req->bindParam('firstName', $firstName, PDO::PARAM_STR);
        $req->bindParam('lastName', $lastName, PDO::PARAM_STR);
        $req->bindParam('pwdHash', $pwdHash, PDO::PARAM_STR);
        $req->bindParam('email', $email, PDO::PARAM_STR);
        $wasAdded = $req->execute();
        $req->closeCursor();
        //if a user was added, we'll fetch this info and run one more query
        //this query is to get the info for the session
        if ($wasAdded) {
            $req = $db->query("SELECT LAST_INSERT_ID() AS user_id, first_name, last_name FROM users WHERE id = LAST_INSERT_ID()");
            return $req->fetch(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }
    public function insertCompanyUser($firstName, $lastName, $email, $pwd, $companyName, $companyTitle)
    {
        $db = $this->dbConnect();
        //hash pw
        $pwdHash = password_hash($pwd, PASSWORD_DEFAULT);
        //inserting first into companies table
        //then set the most recent insert id as the id for users table, then insert there too
        $preparedinsertSql = "INSERT INTO companies (name) VALUES (:companyname);
        SET @last_id_in_table1 = LAST_INSERT_ID();
        INSERT INTO users (first_name,last_name,password,email,user_bio,company_id,login_type) VALUES (:first_name, :last_name, :pwdHash, :email, :companytitle, @last_id_in_table1, 0)";
        $req = $db->prepare($preparedinsertSql);

        $req->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $req->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $req->bindParam(':pwdHash', $pwdHash, PDO::PARAM_STR);
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':companyname', $companyName, PDO::PARAM_STR);
        $req->bindParam(':companytitle', $companyTitle, PDO::PARAM_STR);

        $wasAdded = $req->execute();
        $req->closeCursor();
        //if a company was added, we'll fetch this info and run one more query
        //this query is to get the info for the session
        if ($wasAdded) {
            $req = $db->query("SELECT LAST_INSERT_ID() AS user_id, company_id, first_name, last_name FROM users WHERE id = LAST_INSERT_ID()");
            return $req->fetch(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }

    public function getUserProfile($userId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT *, DATE(date_created) AS date_created FROM users WHERE id = ? ");
        $req->execute([$userId]);
        $user = $req->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    public function getUserExperience($userId)
    {
        $db = $this->dbConnect();
        //TODO: get experience WHERE user id matches;
        $req = $db->prepare("SELECT * FROM professional_experience WHERE user_id = ?");
        $req->execute([$userId]);
        $experience = $req->fetch(PDO::FETCH_OBJ);
        return $experience;
    }
    public function getUserSkills($userId)
    {
        $db = $this->dbConnect();
        //TODO: get user skills WHERE user id matches;
        $userSkills = "SELECT user_id, skill_id FROM user_skill_map WHERE user_id =?";
        $req = $db->prepare($userSkills);
        $req->execute([$userId]);
        $skill = $req->fetchALL(PDO::FETCH_OBJ);
        return $skill;
    }

    public function getSkillsList()
    {
        $db = $this->dbConnect();
        $response = $db->query('SELECT id, skills_fixed as item FROM skills');
        $skills = $response->fetchAll(PDO::FETCH_ASSOC);
        return $skills;
    }

    public function getLanguagesList()
    {
        $db = $this->dbConnect();
        $response = $db->query('SELECT id, language as item FROM languages');
        $languages = $response->fetchAll(PDO::FETCH_ASSOC);
        return $languages;
    }

    public function getCitiesList()
    {
        $db = $this->dbConnect();
        $res = $db->query('SELECT id, CONCAT(name, " - ", country_code) AS item FROM cities');
        $cities = $res->fetchAll(PDO::FETCH_ASSOC);
        return $cities;
    }

    public function getUserEducation($userId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM education WHERE user_id = ?");
        $req->execute([$userId]);
        $education = $req->fetch(PDO::FETCH_OBJ);
        return $education;
    }


    public function getCityName($cityId)
    {
        $db = $this->dbConnect();
        $cityName = ("SELECT name FROM cities WHERE id = :inCityId");
        $req = $db->prepare($cityName);
        $req->bindParam(':inCityId', $cityId, PDO::PARAM_INT);
        $req->execute();
        $name = $req->fetchALL(PDO::FETCH_OBJ);
        return $name;
    }

    public function uploadUserPhoto($newpath)
    {
        $db = $this->dbConnect();
        $preparedinsertSql = "INSERT INTO users (profile_picture)
        VALUES (:profilepicture)";
        $req = $db->prepare($preparedinsertSql);
        $req->bindParam('profile_picture', $newpath, PDO::PARAM_STR);
        return $newpath;
    }

    public function updateUserPersonal($id, $phoneNb, $city, $salary, $visa, $profilePic)
    {
        $db = $this->dbConnect();
        // this is to check and get the city id from the cities table. cities -> city_id(matching the city name) -> pass id inside users.
        $getCityId = "SELECT id FROM cities where name = :inCity AND country_code = 'KR' "; //query
        $req = $db->prepare($getCityId);
        $req->bindParam(':inCity', $city, PDO::PARAM_STR);
        $cityId = $req->execute();
        $cityId = $req->fetchAll(PDO::FETCH_OBJ);
        $cityId = $cityId[0]->id ?? NULL; // the city id in table cities
        $updateUserP = "UPDATE users SET phone_number = :inPhoneNb, city_id = :inCity, visa_sponsorship = :inVisa, desired_salary = :inSalary, profile_picture = :inProfilePic WHERE id = :id";
        $req = $db->prepare($updateUserP);
        $req->bindParam('id', $id, PDO::PARAM_INT);
        $req->bindParam('inPhoneNb', $phoneNb, PDO::PARAM_INT);
        $req->bindParam('inCity', $cityId, PDO::PARAM_STR);
        $req->bindParam('inSalary', $salary, PDO::PARAM_INT);
        $req->bindParam('inVisa', $visa, PDO::PARAM_INT);
        $req->bindParam("inProfilePic", $profilePic, PDO::PARAM_STR);
        $result1 = $req->execute();

        $query = "UPDATE users SET profile_picture = :inProfilePic WHERE id = :userID";
        $req = $db->prepare($query);
        $req->bindParam("userID", $USER_ID, PDO::PARAM_INT);
        $req->bindParam("inProfilePic", $profilePic, PDO::PARAM_STR);

        $result2 = $req->execute();
        return [$result1, $result2];
    }

    // public function getEducationLevel($educationId)
    // {
    //     $db = $this->dbConnect();
    //     $educationLevel = ("SELECT degree_level FROM education WHERE user_id = :inEducationId");
    //     $req = $db->prepare($educationLevel);
    //     $req->bindParam(':inEducationId', $educationId, PDO::PARAM_INT);
    //     $req->execute();
    //     $name = $req->fetchALL(PDO::FETCH_OBJ);
    //     return $name;
    // }

    public function updateUserEducation($userId, $degree, $degreeLevel)
    {
        $db = $this->dbConnect();
        $updateUserEd = "UPDATE education SET degree = :inDegree, degree_level = :inDegreeLevel WHERE user_id = :userId";
        $req = $db->prepare($updateUserEd);
        $req->bindParam('userId', $userId, PDO::PARAM_INT);
        $req->bindParam('inDegree', $degree, PDO::PARAM_STR);
        $req->bindParam('inDegreeLevel', $degreeLevel, PDO::PARAM_INT);
        $req->execute();
        return $req->rowCount();
    }

    public function updateUserExperience($jobTitle, $yearsExperience, $companyName, $userId)
    {
        $db = $this->dbConnect();
        $updateUserExp = "UPDATE professional_experience SET job_title = :inJobTitle, years_experience = :inYearsExperience, company_name = :inCompanyName WHERE user_id = :inUserID";
        $req = $db->prepare($updateUserExp);
        $req->bindParam('inJobTitle', $jobTitle, PDO::PARAM_STR);
        $req->bindParam('inYearsExperience', $yearsExperience, PDO::PARAM_INT);
        $req->bindParam('inCompanyName', $companyName, PDO::PARAM_STR);
        $req->bindParam('inUserID', $userId, PDO::PARAM_INT);
        $req->execute();
        return $req->rowCount();
    }

    public function updateUserSkills($skill_id, $userId)
    {
        $db = $this->dbConnect();
        $updateUserSkills = "INSERT IGNORE INTO user_skill_map (user_id, skill_id) VALUES (:user_id, :skill_id)";
        $req = $db->prepare($updateUserSkills);
        $req->bindParam('skill_id',  $skill_id,  PDO::PARAM_INT);
        $req->bindParam('user_id',  $userId,  PDO::PARAM_INT);
        $req->execute();
        return $req->rowCount();
    }

    public function updateUserLanguages($language_id, $userId)
    {
        $db = $this->dbConnect();
        $updateUserLanguages = "INSERT IGNORE INTO user_language_map (user_id, language_id) VALUES (:user_id, :language_id)";
        $req = $db->prepare($updateUserLanguages);
        $req->bindParam('user_id',  $userId,  PDO::PARAM_INT);
        $req->bindParam('language_id',  $language_id,  PDO::PARAM_INT);
        $req->execute();
        return $req->rowCount();
    }
    // public function updateUserSkills($, $yearsExperience, $companyName, $userId)
    // {
    //     $db = $this->dbConnect();
    //     $updateUserExp = "UPDATE professional_experience SET job_title = :inJobTitle, years_experience = :inYearsExperience, company_name = :inCompanyName WHERE user_id = :inUserID";
    //     $req = $db->prepare($updateUserExp);
    //     $req->bindParam('inJobTitle', $jobTitle, PDO::PARAM_STR);
    //     $req->bindParam('inYearsExperience', $yearsExperience, PDO::PARAM_INT);
    //     $req->bindParam('inCompanyName', $companyName, PDO::PARAM_STR);
    //     $req->bindParam('inUserID', $userId, PDO::PARAM_INT);
    //     $req->execute();
    //     return $req->rowCount();
    // }




    public function signInUser($email, $pwd)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT email, password FROM users WHERE email = ?");
        $req->execute(array($_POST['email']));
        $user = $req->fetch(PDO::FETCH_OBJ);

        //verify the password and then start a session
        if ($user and password_verify($_POST['pwd'], $user->password)) {
            $_SESSION['email'] = $_POST['email'];
            exit;
        }
    }


    // public function signInUser($email, $pwd)
    // {
    //     $db = $this->dbConnect();

    //     $req = $db->prepare("SELECT email, password FROM users WHERE email = ?");
    //     $req->execute(array($_POST['email']));
    //     $user = $req->fetch(PDO::FETCH_OBJ);

    //     return $user;
    // }

    public function uploadUserResume($resume)
    {
        $db = $this->dbConnect();
        $preparedinsertSql = "INSERT INTO users (resume_file_url)
        VALUES (:resume)";
        $req = $db->prepare($preparedinsertSql);
        $req->bindParam('resume_file_url', $resume, PDO::PARAM_STR);
    }
}

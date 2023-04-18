<?php
require_once "Manager.php";
class UserManager extends Manager
{

    public function getUserByEmail($email)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM users WHERE email = ?"); // query prepare the DB to see if the user exists - asking data from the users table 
        $req->execute([$email]); // ^ asking for the id, email... info ^
        $user = $req->fetch(PDO::FETCH_OBJ);
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
        INSERT INTO professional_experience (user_id) VALUES (@last_id_in_table1);'; // inserting id for professional

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

        $defaultProfilePic = "./public/images/uploaded/tom.jpg";

        $pwdHash = password_hash($pwd, PASSWORD_DEFAULT);

        //insert into db
        $preparedinsertSql = "INSERT INTO users (first_name, last_name, password, email, login_type, profile_picture)
        VALUES (:firstName, :lastName, :pwdHash, :email, 0, :inProfile_picture);
        SET @last_id_in_table1 = LAST_INSERT_ID(); 
        INSERT INTO education (user_id) VALUES (@last_id_in_table1);"; // inserting id for education // 0 is for email login

        $req = $db->prepare($preparedinsertSql);
        $req->bindParam('firstName', $firstName, PDO::PARAM_STR);
        $req->bindParam('lastName', $lastName, PDO::PARAM_STR);
        $req->bindParam('pwdHash', $pwdHash, PDO::PARAM_STR);
        $req->bindParam('email', $email, PDO::PARAM_STR);
        $req->bindParam('inProfile_picture', $defaultProfilePic, PDO::PARAM_STR);
        return $req->execute();
    }

    public function getUserEducation($userId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM education WHERE user_id = ?");
        $req->execute([$userId]);
        $education = $req->fetch(PDO::FETCH_OBJ);
        return //htmlspecialchars
            $education;
    }

    public function getUserExperience($userId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM professional_experience WHERE user_id = ? ");
        $req->execute([$userId]);
        $experience = $req->fetchAll(PDO::FETCH_OBJ);
        return //htmlspecialchars
            $experience;
    }

    public function addNewUserExperience($companyName, $jobTitle, $yearsExperience, $userId)
    {
        $db = $this->dbConnect();
        $insertExperience = 'INSERT INTO professional_experience (job_title, company_name, years_experience, user_id) 
        VALUES (:inJob_title, :inCompany_name, :inYears_experience, :inUser_id);';

        $req = $db->prepare($insertExperience);
        $req->bindParam('inCompany_name',  $companyName,  PDO::PARAM_STR);
        $req->bindParam('inJob_title',  $jobTitle,  PDO::PARAM_STR);
        $req->bindParam('inYears_experience',  $yearsExperience,  PDO::PARAM_INT);
        $req->bindParam('inUser_id',  $userId,  PDO::PARAM_INT);
        return $req->execute();
    }

    public function updateUserExperience($jobTitle, $yearsExperience, $companyName, $userId, $id)
    {

        $db = $this->dbConnect();
        $updateUserExp = "UPDATE professional_experience SET job_title = :inJobTitle, years_experience = :inYearsExperience, company_name = :inCompanyName WHERE user_id = :inUserID AND id = :inID";
        $req = $db->prepare($updateUserExp);
        $req->bindParam('inJobTitle', $jobTitle, PDO::PARAM_STR);
        $req->bindParam('inYearsExperience', $yearsExperience, PDO::PARAM_INT);
        $req->bindParam('inCompanyName', $companyName, PDO::PARAM_STR);
        $req->bindParam('inUserID', $userId, PDO::PARAM_INT);
        $req->bindParam('inID', $id, PDO::PARAM_INT);
        $req->execute();
        return $req->rowCount();
    }

    public function deleteUserExperience($id)
    {
        $db = $this->dbConnect();

        $query = "DELETE FROM professional_experience WHERE id = :inID";
        echo $query; // 1st step
        $query = $db->prepare($query);
        $query->bindParam('inID', $id, PDO::PARAM_INT);

        return $query->execute();
    }

    public function insertCompanyUser($firstName, $lastName, $email, $pwd, $companyName, $companyTitle)
    {
        $db = $this->dbConnect();
        //hash pw

        $defaultProfilePic = "./public/images/uploaded/defaultComp.jpg";

        $pwdHash = password_hash($pwd, PASSWORD_DEFAULT);
        //inserting first into companies table
        //then set the most recent insert id as the id for users table, then insert there too
        $preparedinsertSql = "INSERT INTO companies (name, email, logo_img) VALUES (:companyname, :email, :inProfile_picture);
        SET @last_id_in_table1 = LAST_INSERT_ID();
        INSERT INTO users (first_name,last_name,password,email,user_bio,company_id,login_type, profile_picture) VALUES (:first_name, :last_name, :pwdHash, :email, :companytitle, @last_id_in_table1, 0, :inProfile_picture)";
        $req = $db->prepare($preparedinsertSql);

        $req->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $req->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $req->bindParam(':pwdHash', $pwdHash, PDO::PARAM_STR);
        $req->bindParam(':email', $email, PDO::PARAM_STR);
        $req->bindParam(':companyname', $companyName, PDO::PARAM_STR);
        $req->bindParam(':companytitle', $companyTitle, PDO::PARAM_STR);
        $req->bindParam(':inProfile_picture', $defaultProfilePic, PDO::PARAM_STR);

        return $req->execute();
    }

    public function getUserProfile($userId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT *, DATE(date_created) AS date_created FROM users WHERE id = ? ");
        $req->execute([$userId]);
        $user = $req->fetch(PDO::FETCH_OBJ);
        return //htmlspecialchars
            $user;
    }

    public function getUserSkills($userId)
    {
        $db = $this->dbConnect();
        
        $userSkills = "SELECT user_id, skill_id FROM user_skill_map WHERE user_id =?";
        $req = $db->prepare($userSkills);
        $req->execute([$userId]);
        $skill = $req->fetchAll(PDO::FETCH_OBJ);
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
        $res = $db->query('SELECT id, CONCAT(name, " - ", country_code) AS item FROM cities_kr');
        $cities = $res->fetchAll(PDO::FETCH_ASSOC);
        return $cities;
    }

    public function getCityName($cityId)
    {
        $db = $this->dbConnect();
        $cityName = ("SELECT name FROM cities_kr WHERE id = :inCityId");
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
        $getCityId = "SELECT id FROM cities_kr WHERE name = :inCity AND country_code = 'KR' "; //query
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
        $result = $req->execute();
        return $result;

        // $query = "UPDATE users SET profile_picture = :inProfilePic WHERE id = :userID";
        // $req = $db->prepare($query);
        // $req->bindParam("userID", $USER_ID, PDO::PARAM_INT);
        // $req->bindParam("inProfilePic", $profilePic, PDO::PARAM_STR);

        // $result2 = $req->execute();
        // return [$result1, $result2];
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

    // public function updateUserExperience($jobTitle, $yearsExperience, $companyName, $userId)
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

        //do an if statement to check if user is company or single user and header to their profile page
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
        $preparedinsertSql = "UPDATE users 
                                SET resume_file_url = :Inresume
                                WHERE users.id = :userID";
        $req = $db->prepare($preparedinsertSql);
        $req->bindParam('Inresume', $resume, PDO::PARAM_STR);
        $req->bindParam('userID', $_SESSION['id'], PDO::PARAM_INT);
        $wasAdded = $req->execute();

        if ($wasAdded) {
            $req = $db->prepare("SELECT resume_file_url FROM users WHERE id = :Inid");
            $req->bindParam('Inid', $_SESSION['id'], PDO::PARAM_INT);
            $req->execute();
            $cvresume = $req->fetch(PDO::FETCH_ASSOC);
            return $cvresume;
        } else {
            return false;
        }
    }
    public function countUnreadMessages($user_id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT COUNT(*) as count FROM `messages` WHERE is_read = 0 and recipient_id = :user_id");
        $req->bindParam('user_id', $user_id, PDO::PARAM_INT);
        $req->execute();
        $count = $req->fetchAll(PDO::FETCH_OBJ);
        return $count[0]->count;
    }
    public function partyMessageUnread($conversationId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT COUNT(*) as count FROM `messages` WHERE is_read = 0 and conversation_id = :conversationId");
        $req->bindParam('conversationId', $conversationId, PDO::PARAM_INT);
        $req->execute();
        $count = $req->fetchAll(PDO::FETCH_OBJ);
        $count = $count[0]->count;
        if ($count == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function getMessengerCounterPartInfo($conversationId, $userId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT DISTINCT sender_id, recipient_id FROM messages WHERE conversation_id=:conversationId");
        $req->bindParam('conversationId', $conversationId, PDO::PARAM_INT);
        $req->execute();
        $res = $req->fetchAll(PDO::FETCH_OBJ);
        $recipientId = $res[0]->recipient_id;
        $senderId = $res[0]->sender_id;
        $req = $db->prepare("SELECT
    users.first_name,
    users.last_name,
    users.user_bio,
    users.email,
    users.phone_number,
    users.profile_picture,
    companies.name,
    companies.company_address,
    companies.email As email1,
    companies.logo_img,
    companies.website_address,
    companies.phone_number As phone_number1
From
    users Inner Join
    companies On users.company_id = companies.id WHERE users.id!=:userId AND (users.id=:recipientId OR users.id=:senderId)");
        $req->bindParam('userId', $userId, PDO::PARAM_INT);
        $req->bindParam('recipientId', $recipientId, PDO::PARAM_INT);
        $req->bindParam('senderId', $senderId, PDO::PARAM_INT);
        $req->execute();
        $counterpart = $req->fetchAll(PDO::FETCH_OBJ);

        return $counterpart;
    }
}

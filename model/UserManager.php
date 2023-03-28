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
        SET @last_id_in_table1 = LAST_INSERT_ID(); -- // inserting id for professional
        INSERT INTO professional_experience (user_id) VALUES (@last_id_in_table1);  -- // inserting id for education
        INSERT INTO education (user_id) VALUES (@last_id_in_table1);';

        $req = $db->prepare($insertUser);
        // your value is the decodedToken from the JSon and -> selecting the specific title from there
        $req->bindParam('inFirst_name',  $firstName,  PDO::PARAM_STR);
        $req->bindParam('inLast_name',  $lastName,  PDO::PARAM_STR);
        $req->bindParam('inEmail',  $email,  PDO::PARAM_STR);
        $req->bindParam('inProfile_picture',  $picture,  PDO::PARAM_STR); // (token, value ,type)               
        return $req->execute();
    }
    // --  bahti - userSkills
    // INSERT INTO user_skill_map (user_id) VALUES (@last_id_in_table1);;
    // INSERT INTO user_language_map (user_id) VALUES (@last_id_in_table1);';

    // public function insertUserExperience()
    // {
    //     $db = $this->dbConnect();
    //     // if user doesn't exist, prepare an INSERT query // If they are NOT in the DB, insert them [firstname, lastname, email, profile photo];
    //     $insertUserExp = 'INSERT INTO professional_experience (user_id, job_title, years_experience, company_name ) VALUES (:inUser_id, :inJob_title, :inYears_experience, :inCompany_name, 0)';
    //     $req = $db->prepare($insertUserExp);
    //     // your value is the decodedToken from the JSon and -> selecting the specific title from there
    //     $req->bindParam('inUser_id',  $firstName,  PDO::PARAM_STR);

    //     return $req->execute();
    // }

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
        $req->execute();
    }

    public function getUserProfile($userId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM users WHERE id = ? ");
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
}

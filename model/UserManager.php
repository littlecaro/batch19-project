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
        INSERT INTO professional_experience (user_id) VALUES (@last_id_in_table1);  -- // inserting id for professional
        INSERT INTO education (user_id) VALUES (@last_id_in_table1);';  // inserting id for education

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
        $req->execute();
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


    //first company insert
    //then user insert using company_id
    //insert as user_bio $companyTitle


    // public function getUserExperience($jobTitle, $yearsExperience, $companyName)
    // {
    // }

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

    public function getUserEducation($userId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM education WHERE user_id = ?");
        $req->execute([$userId]);
        $education = $req->fetch(PDO::FETCH_OBJ);
        return $education;
    }

    public function getUserSkills($userId)
    {
        $db = $this->dbConnect();
        //TODO: get experience WHERE user id matches;
        $userSkills = ("SELECT user_id, skill_id FROM user_skill_map WHERE user_id =?");
        $req = $db->prepare($userSkills);
        $req->execute([$userId]);
        $skill = $req->fetchALL(PDO::FETCH_OBJ);
        return $skill;
    }

    public function updateUserPersonal($id, $phoneNb, $city, $salary, $visa)
    {
        $db = $this->dbConnect();
        // this is to check and get the city id from the cities table. cities -> city_id(matching the city name) -> pass id inside users.
        $getCityId = "SELECT id FROM cities where name = :inCity AND country_code = 'KR' "; //query
        $req = $db->prepare($getCityId);
        $req->bindParam(':inCity', $city, PDO::PARAM_STR);
        $cityId = $req->execute();
        $cityId = $req->fetchAll(PDO::FETCH_OBJ);
        $cityId = $cityId[0]->id; // the city id in table cities

        $updateUserP = "UPDATE users SET phone_number = :inPhoneNb, city_id = :inCity, visa_sponsorship = :inVisa, desired_salary = :inSalary WHERE id = :id";
        $req = $db->prepare($updateUserP);
        $req->bindParam('id', $id, PDO::PARAM_INT);
        $req->bindParam('inPhoneNb', $phoneNb, PDO::PARAM_INT);
        $req->bindParam(':inCity', $cityId, PDO::PARAM_STR);
        $req->bindParam('inSalary', $salary, PDO::PARAM_INT);
        $req->bindParam('inVisa', $visa, PDO::PARAM_INT);
        $result2 = $req->execute();
        return $result2;
    }

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

    public function getCitiesList()
    {
        $db = $this->dbConnect();
        $res = $db->query('SELECT id, CONCAT(name, " - ", country_code) AS item FROM cities');
        $cities = $res->fetchAll(PDO::FETCH_ASSOC);

        return $cities;
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

<?php
require_once "Manager.php";
class UserManager extends Manager
{

    public function getUserByEmail($userEmail)
    {
        $db = $this->dbConnect();
        $sqlEmail = $db->prepare('SELECT id, email, first_name, last_name FROM users WHERE email = ?'); // query prepare the DB to see if the user exists - asking data from the users table 
        $sqlEmail->execute([$userEmail]); // ^ asking for the id, email... info ^
        $user = $sqlEmail->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    public function insertUserGoogle($firstName, $lastName, $email, $picture)
    {
        $db = $this->dbConnect();
        // if user doesn't exist, prepare an INSERT query // TODO: If they are NOT in the DB, insert them [firstname, lastname, email, profile photo];
        $insertUser = 'INSERT INTO users (first_name, last_name, email, profile_picture, login_type) VALUES (:inFirst_name, :inLast_name, :inEmail, :inProfile_picture, 0)';
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

    public function signInUser($email, $pwd)
    {
        $db = $this->dbConnect();

        $req = $db->prepare("SELECT email, password FROM users WHERE email = ?");
        $req->execute(array($_POST['email']));
        $user = $req->fetch(PDO::FETCH_OBJ);

        //verify the password and then start a session
        if ($user and password_verify($_POST['pwd'], $user->password)) {
            session_start();
            $_SESSION['email'] = $_POST['email'];
            exit;
        }
    }
}

<?php
require "Manager.php";
class UserManager extends Manager
{
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

    public function signInUser($email, $pwd){
        $db = $this->dbConnect();

        $req = $db->prepare("SELECT email, password FROM users WHERE email = ?");
        $req->execute(array($_POST['email']));
        $user = $req->fetch(PDO::FETCH_OBJ);
        
        //verify the password and then start a session
        if ($user AND password_verify($_POST['pwd'], $user->password)){
            session_start();
            $_SESSION['email'] = $_POST['email'];
            exit;
        }
    }
}

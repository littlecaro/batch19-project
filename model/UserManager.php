<?php
require "Manager.php";
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
}

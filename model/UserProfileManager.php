<?php
require_once "Manager.php";
session_start();
class UserProfileManager extends Manager
{

    public function showUserProfile()
    {
        $db = $this->dbConnect();
        $req = $db->prepare("SELECT * FROM users WHERE id = :id ");
        $req->bindParam('id', $_SESSION['id'], PDO::PARAM_INT);
        $req->execute();
        $user = $req->fetch(PDO::FETCH_OBJ);
        return $user;
    }


    // public function updateUserProfile()
    // {

    //     if (!empty($user)) {
    //         // update in database
    //         $newPhone = "";
    //         $updatePhone = 'UPDATE users SET phone_number = ?';
    //         $req = $db->prepare($updatePhone);
    //         $numRowsInserted = $req->execute([$newPhone]);
    //     }
    // else {
    //     // insert into the database
    //     // $insertUser = 'INSERT INTO users (phone_number) VALUES (:phone_number)';
    //     // $req = $db->prepare($insertUser);
    //     // $req->bindParam('phone_number',  $phone_number,  PDO::PARAM_INT);
    //     // return $req->execute();
    // }
}

// Public function userProfile()
// $req->bindParam('city_id', $city_id, PDO::PARAM_INT);
// $req->bindParam('desired_salary', $desired_salary, PDO::PARAM_INT);
// $req->bindParam('visa_sponsorship', $visa_sponsorship, PDO::PARAM_BOOL);
<pre>
<?php
print_r($_REQUEST);
$arr = $_REQUEST;

$user_id = 10; // TODO:change user_id later
foreach ($arr as $key => $value) {
    // echo $key;
    if ($key === "skills") {
        // echo "skills array";
        $skillsArray = explode('&', $value);
        foreach ($skillsArray as $skill_item) {
            $skill_id = explode('|', $skill_item)[1];
            // echo $skill_id;

            $query = "INSERT IGNORE INTO user_skill_map (user_id, skill_id) VALUES (:user_id, :skill_id)";
            $req = $db->prepare($query);
            $req->bindParam('user_id',  $user_id,  PDO::PARAM_INT);
            $req->bindParam('skill_id',  $skill_id,  PDO::PARAM_INT);
            $req->execute();
            $rowCount = $req->rowCount();
            // echo $rowCount;
            if ($rowCount > 0) {
                echo $rowCount . ' row(s) added successfully.' . PHP_EOL;
            }
        }
    } elseif ($key === "languages") {
        $languagesArray = explode('&', $value);
        foreach ($languagesArray as $language_item) {
            $language_id = explode('|', $language_item)[1];

            $query = "INSERT IGNORE INTO user_language_map (user_id, language_id) VALUES (:user_id, :language_id)";
            $req = $db->prepare($query);
            $req->bindParam('user_id',  $user_id,  PDO::PARAM_INT);
            $req->bindParam('language_id',  $language_id,  PDO::PARAM_INT);
            $req->execute();
            $rowCount = $req->rowCount();
            if ($rowCount > 0) {
                echo $rowCount . ' row(s) added successfully.' . PHP_EOL;
            }
        }
    }
}

?>
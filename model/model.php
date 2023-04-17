<?php
//TODO: Check all functions for safety

use JetBrains\PhpStorm\Deprecated;

function dbConnect()
{
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        return new PDO('mysql:host=localhost;dbname=batch19_project;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Error : ' . $e->getMessage());
    }
}

function loadChats($userId)
{
    // $str = 'SELECT m.message,m.sender_id, m.recipient_id,u.profile_picture,u.first_name,u.last_name,m.conversation_id FROM messages m INNER JOIN users u on m.sender_id=:userId OR m.recipient_id=:userId';
    $str = 'SELECT u.id AS contactId, u.first_name AS contactFirstName, u.last_name AS contactLastName, u.profile_picture AS contactProfilePicture, m.id, m.message,m.is_read, m.sender_id, m.recipient_id, m.conversation_id, day, month
FROM users u
INNER JOIN (
SELECT m1.id, m1.message, m1.sender_id, m1.recipient_id, m1.is_read, m1.conversation_id, DAY(m2.datetime) as day, MONTHNAME(m2.datetime) as month
    FROM messages m1
  JOIN (SELECT id, MAX(id) AS maxId, conversation_id, datetime FROM messages GROUP BY conversation_id) m2
    ON m1.id = m2.maxId
    WHERE m1.sender_id = :userId OR m1.recipient_id = :userId
) AS m
ON u.id != :userId AND (u.id = m.sender_id OR u.id = m.recipient_id);';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->execute();
    $chats = $query->fetchAll(PDO::FETCH_OBJ);
    return $chats;
}
function getMessages($conversationId)
{

    $str = 'SELECT u.profile_picture,u.first_name,u.last_name,m.conversation_id, m.id, m.sender_id, m.message, DATE_FORMAT(m.datetime, "%M %d %h:%i" ) as datetime FROM messages m INNER JOIN users u ON m.sender_id=u.id WHERE m.conversation_id = :ConversationId ';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(':ConversationId', $conversationId, PDO::PARAM_INT);
    $query->execute();
    $messages = $query->fetchAll(PDO::FETCH_OBJ);
    return $messages;
}
function submitMessage(?string $conversationId, $senderId, $message, $recipientId = null)
{

    if (is_null($conversationId)) {
        $conversationId = rand(1000, 9999);
    } else {
        $str = 'SELECT m.recipient_id, m.sender_id FROM messages m INNER JOIN users u ON m.sender_id=u.id WHERE m.conversation_id = :ConversationId AND (m.recipient_id!=:userId OR m.sender_id!=:userId)';
        $db = dbConnect();
        $query = $db->prepare($str);
        $query->bindParam(':ConversationId', $conversationId, PDO::PARAM_INT);
        $query->bindParam(':userId', $senderId, PDO::PARAM_INT);
        $query->execute();
        $response = $query->fetch(PDO::FETCH_OBJ);
        $recipientId = $response->recipient_id == $senderId ? $response->sender_id : $response->recipient_id;
        // $recipientId = $response->recipient_id;
    }
    // $recipientId = $response->recipient_id; //TODO: Base recipient id on input rather than convo id
    // print_r($response);
    $str = 'INSERT INTO messages (id,sender_id, recipient_id, message,conversation_id) VALUES (NULL, :InsenderId,:Inrecipient_id, :Inmessage, :InConversationId )';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(':InsenderId', $senderId, PDO::PARAM_INT);
    $query->bindParam(':Inrecipient_id', $recipientId, PDO::PARAM_INT);
    $query->bindParam(':Inmessage', $message, PDO::PARAM_STR);
    $query->bindParam(':InConversationId', $conversationId, PDO::PARAM_INT);

    $query->execute();
}
function searchMessagesGet($term)
{
    $newTerm = "%" . $term . "%";
    // echo $term;
    $userId = 1;
    $str = 'SELECT m.id AS messageId, m.message, m.sender_id, DAY(m.datetime) AS day, MONTHNAME(m.datetime) as month, m.conversation_id, c.id AS contactId, c.first_name AS contactFirstName, c.last_name AS contactLastName, c.profile_picture AS contactProfilePicture FROM messages m LEFT JOIN users c ON c.id != :userId AND (c.id = m.sender_id OR c.id = m.recipient_id) WHERE (m.sender_id = :userId OR m.recipient_id = :userId) AND m.message LIKE :Inmessage GROUP BY m.conversation_id ORDER BY m.datetime DESC;';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->bindParam(':Inmessage', $newTerm, PDO::PARAM_STR);
    $query->execute();
    $chats = $query->fetchAll(PDO::FETCH_OBJ);
    // print_r($query);
    // print_r($chats);
    return $chats;
}
function getJobPostings($user_id)
{

    $userCompanyQuery = "SELECT
    users.company_id,
    users.id
FROM
    users INNER JOIN
    companies ON users.company_id = companies.id WHERE users.id = :userId";
    $db = dbConnect();
    $query = $db->prepare($userCompanyQuery);
    $query->bindParam(':userId', $user_id, PDO::PARAM_INT);
    $query->execute();
    $rec = $query->fetchAll(PDO::FETCH_OBJ);
    $companyId = $rec[0]->company_id;
    $str = 'SELECT
    cities_kr.name AS city_name,
    cities_kr.country_code AS country_code,
    jobs.id as jobId,
    jobs.company_id,
    jobs.title,
    jobs.job_description,
    jobs.salary_min,
    jobs.salary_max,
    jobs.deadline,
    jobs.date_created,
    jobs.is_active,
    companies.name,
    companies.logo_img,
    companies.website_address
FROM
    jobs INNER JOIN
    cities_kr ON jobs.city_id = cities_kr.id INNER JOIN
    companies ON jobs.company_id = companies.id
    WHERE companies.id = :companiesId';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(':companiesId', $companyId, PDO::PARAM_INT);
    $query->execute();
    $listings = $query->fetchAll(PDO::FETCH_OBJ);
    return $listings;
}

function getJobCard($jobId, $userId)
{
    // $userId = 4;
    $userCompanyQuery = "SELECT
    users.company_id,
    users.id
FROM
    users INNER JOIN
    companies ON users.company_id = companies.id WHERE users.id = :userId";
    $db = dbConnect();
    $query = $db->prepare($userCompanyQuery);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->execute();
    $rec = $query->fetchAll(PDO::FETCH_OBJ);
    $companyId = $rec[0]->company_id;
    $str = 'SELECT
    cities_kr.name AS city_name,
    cities_kr.country_code AS country_code,
    jobs.id as jobId,
    jobs.company_id,
    jobs.title,
    jobs.job_description,
    jobs.salary_min,
    jobs.salary_max,
    jobs.deadline,
    jobs.date_created,
    jobs.is_active,
    companies.name,
    companies.logo_img,
    companies.website_address
FROM
    jobs INNER JOIN
    cities_kr ON jobs.city_id = cities_kr.id INNER JOIN
    companies ON jobs.company_id = companies.id
    WHERE companies.id = :companiesId AND jobs.id = :jobId';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(':companiesId', $companyId, PDO::PARAM_INT);
    $query->bindParam(':jobId', $jobId, PDO::PARAM_INT);
    $query->execute();
    $jobCard = $query->fetchAll(PDO::FETCH_OBJ);
    return $jobCard[0];
}
function updateJobPost($description, $minSalary, $maxSalary, $deadline, $id)
{
    $user_id = 4;
    $userCompanyQuery = "SELECT
    users.company_id,
    users.id
FROM
    users INNER JOIN
    companies ON users.company_id = companies.id WHERE users.id = :userId";
    $db = dbConnect();
    $query = $db->prepare($userCompanyQuery);
    $query->bindParam(':userId', $user_id, PDO::PARAM_INT);
    $query->execute();
    $rec = $query->fetchAll(PDO::FETCH_OBJ);
    $companyId = $rec[0]->company_id;
    $str = "UPDATE jobs SET job_description = :inDescription, salary_min = :inMinSalary, salary_max = :inMaxSalary, deadline= :inDeadline WHERE id = :inId AND company_id= :inCompanyId";
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindValue('inDescription', $description, PDO::PARAM_STR);
    $query->bindValue('inMinSalary', $minSalary, PDO::PARAM_INT);
    $query->bindValue('inMaxSalary', $maxSalary, PDO::PARAM_INT);
    $query->bindValue("inDeadline", $deadline, PDO::PARAM_STR);
    $query->bindValue('inId', $id, PDO::PARAM_INT);
    $query->bindValue('inCompanyId', $companyId, PDO::PARAM_INT);
    $query->execute();
}

function setJobStatus($id, $status)
{
    // echo $id . "is Id";
    // echo $status . "is status";
    $user_id = 4;
    $userCompanyQuery = "SELECT
    users.company_id,
    users.id
FROM
    users INNER JOIN
    companies ON users.company_id = companies.id WHERE users.id = :userId";
    $db = dbConnect();
    $query = $db->prepare($userCompanyQuery);
    $query->bindParam(':userId', $user_id, PDO::PARAM_INT);
    $query->execute();
    $rec = $query->fetchAll(PDO::FETCH_OBJ);
    $companyId = $rec[0]->company_id;
    $userCompanyQuery = "UPDATE jobs SET is_active = :inStatus WHERE id = :inId AND company_id= :inCompanyId";
    $query = $db->prepare($userCompanyQuery);
    $query->bindValue('inStatus', $status, PDO::PARAM_BOOL);
    $query->bindValue('inId', $id, PDO::PARAM_INT);
    $query->bindValue('inCompanyId', $companyId, PDO::PARAM_INT);
    $query->execute();
}

function getAllTalents($userId)
{
    // echo "allTalents";
    $str = 'SELECT DISTINCT
    users.id
FROM
    users WHERE users.id!=:userId AND company_id IS NULL';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->execute();
    $allTalents = $query->fetchAll(PDO::FETCH_OBJ);
    // print_r($allTalents);
    return $allTalents;
}

function getTalentSkills($userId)
{
    $str = 'SELECT
    user_skill_map.skill_id,
    skills.skills_fixed
FROM
    users INNER JOIN
    user_skill_map ON user_skill_map.user_id = users.id INNER JOIN
    skills ON user_skill_map.skill_id = skills.id
    WHERE users.id = :userId';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(":userId", $userId, PDO::PARAM_INT);
    $query->execute();
    $userSkills = $query->fetchAll(PDO::FETCH_OBJ);
    return $userSkills;
}
function getTalentInfo($userId)
{
    $str = 'SELECT
    users.id,
    users.first_name,
    users.last_name,
    users.profile_picture
FROM
    users
    WHERE users.id = :userId';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(":userId", $userId, PDO::PARAM_INT);
    $query->execute();
    $talentInfo = $query->fetchAll(PDO::FETCH_OBJ);
    return $talentInfo;
}
function getTalentDesiredPosition($userId)
{
    $str = 'SELECT
    desired_position.desired_position,
    users.id
FROM
    desired_position INNER JOIN
    users ON desired_position.user_id = users.id
    WHERE users.id = :userId';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(":userId", $userId, PDO::PARAM_INT);
    $query->execute();
    $desiredPosition = $query->fetchAll(PDO::FETCH_OBJ);
    return $desiredPosition;
}
function getTalentLocation($userId)
{
    $str = 'SELECT
    cities.name as location
From
    cities INNER JOIN
    users ON users.city_id = cities.id
    WHERE users.id = :userId';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(":userId", $userId, PDO::PARAM_INT);
    $query->execute();
    $talentlocation = $query->fetchAll(PDO::FETCH_OBJ);
    return $talentlocation;
}
function getTalentYearsExperience($userId)
{
    $str = 'SELECT
    users.id,
    Sum(professional_experience.years_experience) AS years_experience1
FROM
    users INNER JOIN
    professional_experience ON professional_experience.user_id = users.id
    WHERE users.id = :userId';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(":userId", $userId, PDO::PARAM_INT);
    $query->execute();
    $yearsExperience = $query->fetchAll(PDO::FETCH_OBJ);
    return $yearsExperience;
}

function getTalentHighestDegree($userId)
{
    $str = 'SELECT
    education.institution,
    education.degree,
    MAX(education.degree_level) AS highestDegree,
    users.id
FROM
    education INNER JOIN
    users ON education.user_id = users.id
    WHERE users.id = :userId
    ';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(":userId", $userId, PDO::PARAM_INT);
    $query->execute();
    $talentHighestDegree = $query->fetchAll(PDO::FETCH_OBJ);
    return $talentHighestDegree;
}
function getTalentLanguages($userId)
{
    $str = 'SELECT
    users.id As id1,
    languages1.`language`
FROM
    users INNER JOIN
    user_language_map ON user_language_map.user_id = users.id INNER JOIN
    languages languages1 ON user_language_map.language_id = languages1.id
    WHERE users.id = :userId';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(":userId", $userId, PDO::PARAM_INT);
    $query->execute();
    $talentLanguages = $query->fetchAll(PDO::FETCH_OBJ);
    return $talentLanguages;
}
function talentFilterExists($jobId)
{
    $userId = 1;
    // echo $jobId;
    $db = dbConnect();
    $str = 'SELECT * FROM saved_searches WHERE job_id = :jobId AND user_id = :userId';
    $query = $db->prepare($str);
    $query->bindParam(":userId", $userId, PDO::PARAM_INT);
    $query->bindParam(":jobId", $jobId, PDO::PARAM_INT);
    $query->execute();
    $savedSearches = $query->fetchAll(PDO::FETCH_OBJ);
    // print_r($savedSearches);
    return $savedSearches;
}
function saveTalentFilter($searchData, $jobId)
{
    $userId = 1;
    $str = 'INSERT INTO saved_searches (id,user_id,search_data, job_id) VALUES (NULL,:userId, :searchData,:jobId)';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(":userId", $userId, PDO::PARAM_INT);
    $query->bindParam(":searchData", $searchData, PDO::PARAM_STR);
    $query->bindParam(":jobId", $jobId, PDO::PARAM_INT);
    $query->execute();
}
function updateTalentFilter($searchData, $user_id, $jobId)
{
    $userId = 1;
    echo "<br>";
    echo $searchData;
    echo "<br>";
    echo 'jobId:' . $jobId;
    $str = "UPDATE saved_searches SET search_data = :searchData where (job_id = :jobId AND user_id = :userId)";

    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(":searchData", $searchData, PDO::PARAM_STR);
    $query->bindParam(":jobId", $jobId, PDO::PARAM_INT);
    $query->bindParam(":userId", $userId, PDO::PARAM_INT);
    $query->execute();
}

function getCompanyID($userID)
{
    $userCompanyQuery = "SELECT users.company_id, users.id
                            FROM users 
                            INNER JOIN companies 
                            ON users.company_id = companies.id 
                            WHERE users.id = :userId";
    $db = dbConnect();
    $query = $db->prepare($userCompanyQuery);
    $query->bindParam(':userId', $userID, PDO::PARAM_INT);
    $query->execute();
    $rec = $query->fetch(PDO::FETCH_OBJ);
    return $rec->company_id;
}

function showSkills($id = null)
{
    if ($id == null) {
        $id = $_SESSION['id'];
    }
    $skillQuer = 'SELECT user_skill_map.skill_id, skills.skills_fixed
                FROM users 
                    INNER JOIN user_skill_map 
                    ON user_skill_map.user_id = users.id 
                    INNER JOIN skills 
                    ON user_skill_map.skill_id = skills.id
                    WHERE users.id = :userId';
    $db = dbConnect();
    $query = $db->prepare($skillQuer);
    $query->bindParam(":userId", $id, PDO::PARAM_INT);
    $query->execute();
    $userSkills = $query->fetchAll(PDO::FETCH_OBJ);
    return $userSkills;
}

function showLanguages($id = null)
{
    if ($id == null) {
        $id = $_SESSION['id'];
    }
    $langQuer = 'SELECT user_language_map.language_id, languages.language
                FROM users 
                    INNER JOIN user_language_map 
                    ON user_language_map.user_id = users.id 
                    INNER JOIN languages 
                    ON user_language_map.language_id = languages.id
                    WHERE users.id = :userId';
    $db = dbConnect();
    $query = $db->prepare($langQuer);
    $query->bindParam(":userId", $id, PDO::PARAM_INT);
    $query->execute();
    $userLangs = $query->fetchAll(PDO::FETCH_OBJ);
    return $userLangs;
}

function showJobs($id = null)
{
    if ($id == null) {
        $id = $_SESSION['id'];
    }
    $expQuer = 'SELECT pe.job_title, pe.company_name, pe.years_experience, pe.job_description, pe.city_id
                FROM users 
                    INNER JOIN professional_experience pe 
                    ON pe.user_id = users.id 
                    WHERE users.id = :userId';
    $db = dbConnect();
    $query = $db->prepare($expQuer);
    $query->bindParam(":userId", $id, PDO::PARAM_INT);
    $query->execute();
    $userExp = $query->fetchAll(PDO::FETCH_OBJ);
    return $userExp;
}
function messageRead($conversationId)
{
    $expQuer = 'UPDATE messages SET is_read = 1 WHERE conversation_id = :conversationId';
    $db = dbConnect();
    echo $conversationId;
    $query = $db->prepare($expQuer);
    $query->bindParam(":conversationId", $conversationId, PDO::PARAM_INT);
    $query->execute();
}

function fetchConversationId($companyId, $userId)
{
    $str = 'SELECT DISTINCT conversation_id FROM messages WHERE (sender_id = :companyId AND recipient_id = :userId) OR (recipient_id = :companyId AND sender_id= :userId);';
    $db = dbConnect();
    $query = $db->prepare($str);
    $query->bindParam(":userId", $userId, PDO::PARAM_INT);
    $query->bindParam(":companyId", $companyId, PDO::PARAM_INT);
    $query->execute();
    $rec = $query->fetch(PDO::FETCH_OBJ);
    return $rec->conversation_id;
}

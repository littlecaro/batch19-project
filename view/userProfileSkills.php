<?php
// Connect to the db with a try and catch
try {
  $db = new PDO('mysql:host=localhost;dbname=batch19_project;charset=utf8', 'root', '');
} catch (Exception $e) {
  die('Error: ' . $e->getMessage());
}
// Create the sql query 
// Create a variable for the response and send the query to the db
$response = $db->query('SELECT id, skills_fixed as item FROM skills');
// Create a variable to fetch all the response from the db
$skills = $response->fetchAll(PDO::FETCH_ASSOC);

$response = $db->query('SELECT id, language as item FROM languages');
$languages = $response->fetchAll(PDO::FETCH_ASSOC);

$response = $db->query('SELECT id, CONCAT(name, " - ", country_code) AS item FROM cities');
$cities = $response->fetchAll(PDO::FETCH_ASSOC);
?>

<!--  -->
<form autocomplete="off" action="index.php?action=userProfileSkillsSubmit.php" method="POST">

  <h2>Skills:</h2>
  <?php
  $userProfileSkills = "skills";
  require("./view/userProfileSkillsMultiSelector.php");
  ?>
  <h2>Languages:</h2>
  <?php
  $userProfileSkills = "languages";
  require("./view/userProfileSkillsMultiSelector.php");
  ?>
  <h2>Preferred Locations:</h2>
  <?php
  $userProfileSkills = "cities";
  require("./view/userProfileSkillsMultiSelector.php");
  ?>

  <input type="submit" value="submit">
</form>

<script src="./public/js/userProfileSkillsMultiSelector.js"></script>
<script>
  createMultiSelector(skills, 'skills', 10);
  createMultiSelector(languages, 'languages', 5);
  createMultiSelector(cities, 'cities', 1);
</script>
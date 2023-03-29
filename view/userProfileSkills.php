<?php
$title = "profile skills";
ob_start();
?>

<!-- autocomplete="off" -->
<form action="index.php?action=userProfileSkillsSubmit.php" method="POST">

  <h2> Skills:</h2>
  <?php
  $containerId = "skills";
  require("./view/userProfileSkillsMultiSelector.php");
  ?>
  <h2>Languages:</h2>
  <?php
  $containerId = "languages";
  require("./view/userProfileSkillsMultiSelector.php");
  ?>
  <h2>Preferred Locations:</h2>
  <?php
  $containerId = "cities";
  require("./view/userProfileSkillsMultiSelector.php");
  ?>

  <input type="submit" value="Save">
</form>

<script src="./public/js/userProfileSkillsMultiSelector.js"></script>
<script>
  // Pass the data from PHP to JavaScript
  const skills = <?= json_encode($skills); ?>;
  const languages = <?= json_encode($languages); ?>;
  const cities = <?= json_encode($cities); ?>;
  createMultiSelector(skills, 'skills', 10);
  createMultiSelector(languages, 'languages', 5);
  createMultiSelector(cities, 'cities', 2);
</script>

<?php
$content = ob_get_clean();
require('./view/userProfileSkillsTemplate.php');
?>
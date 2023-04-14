<?php
if (empty($_SESSION['id'] AND getCompanyID($_SESSION['id']))) {
    header('location: http://localhost/sites/batch19-project/index.php');
exit;
}
$title = "Talent Search";
ob_start();
// $saveData = json_decode($saveData, true);
?>



<div class="editSearch hidden">
    <div class="editSearchMain">
        <h3>Filter Candidates</h3>
        <div class="SearchFormInputsWrapper">
            <div class="editSearchLeft">
                <p>Seniority:</p>
                <p>Desired positions:</p>
                <p>Languages:</p>
                <p>Locations:</p>
                <p>Skills:</p>
                <p>highestDegree:</p>
            </div>
            <form action="">
                <?php
                include "./view/components/slider.php";
                ?>
                <div id="simple-tag" class="simple-tags" data-simple-tags="<?php
                                                                            if (!empty($saveData)) {

                                                                                foreach ($saveData["filteredDesiredPositions"] as $key => $dp) {
                                                                                    echo $dp;
                                                                                    if ($dp !== end($saveData["filteredDesiredPositions"])) {
                                                                                        echo ",";
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                echo "any";
                                                                            }
                                                                            ?>">
                </div>
                <div id="simple-tag" class="simple-tags" data-simple-tags="<?php
                                                                            if (!empty($saveData)) {
                                                                                foreach ($saveData["filteredLanguages"] as $key => $language) {

                                                                                    echo $language;
                                                                                    if ($language !== end($saveData["filteredLanguages"])) {
                                                                                        echo ",";
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                echo "any";
                                                                            }

                                                                            ?>">
                </div>
                <div id="simple-tag" class="simple-tags" data-simple-tags="anywhere">
                </div>
                <div id="simple-tag" class="simple-tags" data-simple-tags="<?php
                                                                            if (!empty($saveData)) {
                                                                                foreach ($saveData["filteredSkills"] as $key => $skill) {
                                                                                    echo $skill;
                                                                                    if ($skill !== end($saveData["filteredSkills"])) {
                                                                                        echo ",";
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                echo "any";
                                                                            }
                                                                            ?>">
                </div>
                <div id="simple-tag" class="simple-tags" data-simple-tags="<?php
                                                                            if (!empty($saveData)) {
                                                                                foreach ($saveData["filteredSkills"] as $key => $skill) {
                                                                                    echo $skill;
                                                                                    if ($skill !== end($saveData["filteredSkills"])) {
                                                                                        echo ",";
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                echo "any";
                                                                            }

                                                                            ?>">
                </div>
                <label class="toggle">
                    <input class="toggle-checkbox" type="checkbox" checked>
                    <div class="toggle-switch"></div>
                    <span class="toggle-label">I want to save this search</span>
                </label>
            </form>
        </div>
        <div class="saveSearchWrapper">
            <button class="saveSearch" id="saveBtn">Save</button>
            <button class="saveSearch" id="cancelBtn">Cancel</button>
        </div>
    </div>
</div>
<div class="userProfile">
    <div class="main">
        <h3 class="talentSearchTitle">Talent Search</h3>
        <div class="searchTags">

        </div>
        <div class="talentSearchMain">
            <?= $talentCards; ?>
        </div>
        <div class="talentSearchBtns">
            <button id="editSearch">Edit Search</button>
            <button id="cancelSearch">Reset Search</button>
        </div>
    </div>
</div>
<script>
    const saveData = <?php echo json_encode(($saveData)) ?>;
    const jobId = <?= $_GET["jobId"] ?>;
</script>
<script src="./public/javascript/scriptTags.js"></script>
<script src="./public/javascript/talentSearch.js"></script>

<link href="./public/css/styleTags.css" rel="stylesheet">
<link href="./public/css/talentSearchStyle.css" rel="stylesheet">

<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
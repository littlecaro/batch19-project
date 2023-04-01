<?php
$title = "company dashboard";
ob_start();
?>

<!-- main -->
<div class="bizProfile">
    <div id="landingContainer" class="main">
        <h3>Talent Profile</h3><br>
        <a href="http://localhost/sites/batch19-project/index.php?action=talentSearch&jobId=<?= $jobID ?>">Back to searches</a>        
        <div class="landingPersonal">
            <?php include("./view/components/landingPersonalCard.php") ?>
        </div>
        <div class="landingEducation">
            <?php if(!empty($education)){
                        include("./view/components/landingEducationCard.php");
                    } else {
                        echo "Not set";
                    } ?>
        </div>
        <div class="landingExperience">
            <?php if(!empty($experience)){
                        include("./view/components/landingExperienceCard.php");
                    } else {
                        echo "Not set";
                    } ?>
        </div>
        <div class="landingSkills">
                    <?php if(!empty($skill)){
                        // include("./view/components/landingExperienceCard.php");
                    } else {
                        echo "Not set";
                    } ?>
            <p><b>Skills:</b> </p>
            <p><b>Languages:</b> </p>
        </div>
        <div class="landingAvail">
            <?php
            
            function calDateToStr($str) {
                $d = strtotime($str);
                return date("l, M jS", $d);
            }
            if (!empty($entries)) {
                foreach ($entries as $entry) {
                    include("./view/components/landingCalendarCard.php");
                    ?>
                    <form action="http://localhost/sites/batch19-project/index.php?action=bookInterview" method="POST">
                        <input type="hidden" name="uaID" value="<?= $entry->id?>">
                        <input type="hidden" name="jobID" value="<?= $jobID?>">
                        <button>Book interview</button>
                    </form>
                    <?php
                } 
            } else {
                echo "This user has no availability left. Click here to message and request.";
            }
            ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
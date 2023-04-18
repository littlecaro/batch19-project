<?php
if (empty($_SESSION['id'] AND getCompanyID($_SESSION['id']))) {
    header('location: http://localhost/sites/batch19-project/index.php');
exit;
}
$title = "company dashboard";
ob_start();
?>

<!-- main -->
<div class="bizProfile">
    <div class="landingContainer" class="main">
        <div id="talentHead">
        <h3>Talent Profile</h3><br>
        <?php 
                if (!empty($talent->resume_file_url)) {
                    ?>
                        <a href="<?= htmlspecialchars($talent->resume_file_url) ?>" target="_blank" rel="noopener noreferrer">Click here to open <?= htmlspecialchars($talent->first_name) ?>'s resume</a> 
                    <?php } ?>
        <div class="talentBack">
        <?php if ($jobID != null) {
            ?>
                    <a href="index.php?action=talentSearch&jobId=<?= $jobID ?>"><i class='fa-regular fa-hand-point-left'></i>Back to searches</a>
            </div>
            <?php
        } else {
            ?>
                <a href="index.php?action=bookedMeetings"><i class='fa-regular fa-hand-point-left'></i>Back to meetings</a>
            </div>
            <?php
        }
        ?>
        </div>
        <h1><i class="fa-solid fa-house"></i>Personal info</h1>
        <div class="landingPersonal">
            <?php include("./view/components/landingTalentPersCard.php") ?>
        </div>

        <h1><i class="fa-solid fa-graduation-cap"></i>Highest Education</h1>
        <div class="landingEducation">
            <?php if(!empty($education->degree)){
                        include("./view/components/landingEducationCard.php");
                    } else {
                        echo "<b>User has not inserted any education.</b>";
                    } ?>
        </div>

        <h1><i class="fa-solid fa-briefcase"></i>Experience</h1>
        <div class="landingExperience">
            <?php   
                    if(!empty($profExps)){
                        foreach($profExps as $profExp)
                            include("./view/components/landingExperienceCard.php");
                    } else {
                        echo "<b>User has not inserted any job experience.</b>";
                    } ?>
        </div>

        <h1><i class="fa-solid fa-code"></i>Skills</h1>
        <div class="landingSkills">
                    <?php 
                        if(!empty($skills)){
                            ?>
                            <div class="technicalSkills"><p><b>Technical:</b></p>
                            <?php
                            foreach($skills as $skill) {
                                include("./view/components/landingSkillCard.php");
                            }
                            ?>
                            </div>
                            <?php
                        } else {
                            echo "<b>User has not inserted any technical skills.</b><br>";
                        }
                            
                        if(!empty($languages)){
                            ?>
                            <div class="languageSkills"><p><b>Languages:</b> </p>
                            <?php
                            foreach($languages as $language) {
                                include("./view/components/landingLanguageCard.php");
                            }
                            ?>
                            </div>
                            <?php
                        } else {
                            echo "<b><br>User has not inserted any languages.</b>";
                        }
                        ?>
        </div>
            <?php
                $interviews = $calendarManager->loadPastTalentInterviews($id);
                if (!empty($interviews)) {
            ?>
            
            <h1><i class="fa-solid fa-handshake-simple"></i>Past Interviews with <?= htmlspecialchars($talent->first_name) ?></h1>
                <div class="landingAvail">
                    <?php
                    for ($i = 0; $i < count($interviews); $i++) {
                        include("./view/components/landingTalentBookedMeetings.php");
                    } 
                    ?>
                </div>
            <?php }
            ?>
        

            <?php
                $interviews = $calendarManager->loadTalentInterviews($id);
                if (!empty($interviews)) {
                ?>
                <h1><i class="fa-solid fa-handshake-simple"></i>
                Scheduled Interviews with <?= htmlspecialchars($talent->first_name) ?? 'user'?></h1>
                <div class="landingAvail">
                <?php
                for ($i = 0; $i < count($interviews); $i++) {
                    include("./view/components/landingTalentBookedMeetings.php");
                } 
            } else {
                ?>
                <h1><i class="fa-regular fa-calendar-days"></i>Availability - click time to book an interview</h1>
                <div class="landingAvail">
                    <?php
                    if (!empty($entries)) {
                        for ($i = 0; $i < count($entries); $i++) {
                            include("./view/components/landingTalentCalCard.php");
                            ?>
                            <?php
                        } 
                    } else {
                        echo "<b>This user has no current availability. Click here to message and request.</b>";
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
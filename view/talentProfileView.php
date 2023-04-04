<?php
$title = "company dashboard";
ob_start();
?>

<!-- main -->
<div class="bizProfile">
    <div class="landingContainer" class="main">
        <div id="talentHead">
        <h3>Talent Profile</h3><br>
        <?php 
                if (!empty($user->resume_file_url)) {
                    ?>
                        <a href="<?=$user->resume_file_url?>">Click here to open <?=$user->first_name?>'s resume</a> 
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
            <?php include("./view/components/landingPersonalCard.php") ?>
        </div>

        <h1><i class="fa-solid fa-graduation-cap"></i>Highest Education</h1>
        <div class="landingEducation">
            <?php if(!empty($education)){
                        include("./view/components/landingEducationCard.php");
                    } else {
                        echo "<b>This user has not inserted any education.</b>";
                    } ?>
        </div>

        <h1><i class="fa-solid fa-briefcase"></i>Experience</h1>
        <div class="landingExperience">
            <?php   
                    if(!empty($profExps)){
                        foreach($profExps as $profExp)
                            include("./view/components/landingExperienceCard.php");
                    } else {
                        echo "<b>This user has not inserted any job experience.</b>";
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
                            echo "<b>This user has not inserted any technical skills.</b><br>";
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
                            echo "<b><br>This user has not inserted any languages.</b>";
                        }
                        ?>
        </div>

            <?php

            if (!empty($interviews)) {
                ?>
                <h1><i class="fa-solid fa-handshake-simple"></i>
                You already have an interview scheduled with <?= $user->first_name ?? 'user'?></h1>
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
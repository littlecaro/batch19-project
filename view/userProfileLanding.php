<?php

if (empty($_SESSION['id'])) {
    header('location: http://localhost/sites/batch19-project/index.php');
exit;
}

?>
<div class="landingContainer">
    <h1><i class="fa-solid fa-house"></i>Personal info</h1>
    <button class="landingBtn" onclick="myFunction('personal')">
        <div class="landingPersonal">
            <?php include("./view/components/landingPersonalCard.php") ?>
        </div>
    </button>

    <h1><i class="fa-solid fa-graduation-cap"></i>Highest Education</h1>
    <button class="landingBtn" onclick="myFunction('education')">
        <div class="landingEducation">
            <?php if(!empty($education) AND !empty($education->degree)){
                        include("./view/components/landingEducationCard.php");
                    } else {
                        echo "Please click to fill in your first entry.";
                    } ?>
        </div>
    </button>

    <h1><i class="fa-solid fa-briefcase"></i>Experience</h1>
    <button class="landingBtn" onclick="myFunction('experience')">
        <div class="landingExperience">
            <?php 
                    $profExps = showJobs();
                    if(!empty($profExps)){
                        foreach($profExps as $profExp)
                            include("./view/components/landingExperienceCard.php");
                    } else {
                        echo "Please click to fill in your first entry.";
                    } ?>
        </div>
    </button>
    <h1><i class="fa-solid fa-code"></i>Skills</h1>
    <button class="landingBtn" onclick="myFunction('skills')">
        <div class="landingSkills">
                    <?php 
                        $skills = showSkills();
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
                            echo "No technical skills uploaded.<br>";
                        }
                            
                        $languages = showLanguages();
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
                            echo "<br>No languages uploaded.";
                        }
                        ?>
        </div>
    </button>

    <h1><i class="fa-regular fa-calendar-days"></i>Availability</h1>
    <button class="landingBtn" onclick="showCalendarPage()">
        <div class="landingAvail">
            <?php
            $entries = $calendarManager->loadCalendar($_SESSION['id']);

            if (!empty($entries)) {
                for ($i = 0; $i < count($entries); $i++) {
                    include("./view/components/landingCalendarCard.php");
                } 
            } else {
                echo "Please click to fill in your first entry.";
            }
            ?>
        </div>
    </button>
    
    <?php
            $receives = $calendarManager->loadPastInterviews($_SESSION['id']);
            if (!empty($receives)) {
    ?>
    <div id="pastInterviews">
    <h1><i class="fa-solid fa-handshake-simple"></i>Past Interviews</h1>
    <button class="landingBtn">
        <div class="landingAvail">
            <?php
            for ($i = 0; $i < count($receives); $i++) {
                include("./view/components/landingInterviewCard.php");
            } 
            ?>
        </div>
    </button>
    <?php }
    ?>
    </div>

    <h1><i class="fa-solid fa-handshake-simple"></i>Scheduled Interviews</h1>
    <button class="landingBtn" onclick="showCalendarPage()">
        <div class="landingAvail">
            <?php
            $receives = $calendarManager->loadInterviews($_SESSION['id']);

            if (!empty($receives)) {
                for ($i = 0; $i < count($receives); $i++) {
                    include("./view/components/landingInterviewCard.php");
                } 
            } else {
                echo "No interviews scheduled.";
            }
            ?>
        </div>
    </button>
</div>

<script>
    landing.firstElementChild.appendChild(pastInterviews);
</script>
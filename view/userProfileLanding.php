<div id="landingContainer">
    <h1><i class="fa-solid fa-house"></i>Personal info</h1>
    <button class="landingBtn" onclick="myFunction('personal')">
    <!-- TODO: Split up the two div buttons, one will link to profile pic upload. -->
        <div class="landingPersonal">
            <?php include("./view/components/landingPersonalCard.php") ?>
        </div>
    </button>

    <h1><i class="fa-solid fa-graduation-cap"></i>Highest Education (just one?)</h1>
    <button class="landingBtn" onclick="myFunction('education')">
        <div class="landingEducation">
            <?php include("./view/components/landingEducationCard.php") ?>
        </div>
    </button>

    <h1><i class="fa-solid fa-briefcase"></i>Experience</h1>
    <button class="landingBtn" onclick="myFunction('experience')">
        <div class="landingExperience">
            <?php include("./view/components/landingExperienceCard.php") ?>
        </div>
    </button>
    <h1><i class="fa-solid fa-code"></i>Skills</h1>
    <button class="landingBtn" onclick="myFunction('skills')">
        <div class="landingSkills">
            <p><b>Skills:</b> </p>
            <p><b>Languages:</b> </p>
        </div>
    </button>

    <h1><i class="fa-regular fa-calendar-days"></i>Availability</h1>
    <button class="landingBtn" onclick="showCalendarPage()">
        <div class="landingAvail">
            <?php
            $entries = $calendarManager->loadCalendar($_SESSION['id']);
            
            function calDateToStr($str) {
                $d = strtotime($str);
                return date("l, M jS", $d);
            }

            foreach ($entries as $entry) {
                include("./view/components/landingCalendarCard.php");
            } 
            ?>
        </div>
    </button>
</div>
<?php
$title = "userProfile";
ob_start();
?>
<!-- TODO: UNCOMMENT THIS ONE DOWN BELOW FOR GETTING GOOGLE ACCOUNT INFORMATIONS -->
<!-- <pre> -->
<!-- <?php print_r($user); ?> -->
<!-- </pre> -->
<!-- part of website icon: we can choose from navibar or can create our own -->
<!--sidebar  -->
<div class="sidebar">
    <div class="profile">
        <!-- We need here a profile picture -->
        <img class="profile-img" src="<?= $companyInfo->logo_img ?? "./public/images/default.svg" ?>" alt="Elon Musk's photo looking head to left"><br>
        <div class="profile-name">
            <h4><?= $companyInfo->name ?? "NEW COMPANY" ?></h4>
            <p>Member since <?= $companyInfo->date_created ?></p>
        </div>
    </div>
    <div class="menus">
        <button onclick="myFunction('personal')"><i class="fa-solid fa-house"></i>Personal</button>

        <button onclick="myFunction('resume')"><i class="fa-solid fa-magnifying-glass"></i>Resume/CV</button>

        <button onclick="myFunction('education')"><i class="fa-solid fa-chart-simple"></i>Education</button>

        <button onclick="myFunction('experience')"><i class="fa-solid fa-chart-simple"></i>Experience</button>

        <button onclick="myFunction('skills')"><i class="fa-solid fa-bookmark"></i></i>Skills</button>

        <button onclick="showCalendarPage()"><i class="fa-solid fa-message"></i>Availability</button>
    </div>
</div>

<!-- main -->
<div class="main">
    <section id="personal">

        <?php include('./view/userProfilePersonal.php') ?>

    </section>

    <section id="resume" class="hidden">
        <p>Upload so resume</p>
        <input type="submit" value="Save">
    </section>

    <section id="education" class="hidden">
        <p>Your education level</p>

        <?php include('./view/userProfileEducation.php') ?>

    </section>

    <section id="experience" class="hidden">
        <p>Your experiences</p>

        <?php include('./view/userProfileExperience.php') ?>

    </section>

    <section id="skills" class="hidden">
        <p>Your Skills</p>

        <?php include('./view/userProfileSkills.php') ?>

    </section>

    <section id="avail" class="hidden">
        <!-- <p>Your Availability</p>
        <div class="avail"> -->
        <?php include('./view/calendarView.php') ?>
        <!-- </div> -->
    </section>

</div>
<?php
$content = ob_get_clean();
require('./view/userProfileTemplate.php');
?>
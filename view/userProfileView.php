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
    <button class="profile" onclick="myFunction('landing')">
        <!-- We need here a profile picture -->
        <img class="profile-img" src="<?= $user->profile_picture ?? "./public/images/default.svg" ?>" alt="Elon Musk's photo looking head to left"><br>
        <div class="profile-name">
            <h4><?= $user->first_name . " " . $user->last_name  ?? "Your name" ?></h4>
            <p>Member since <?= $user->date_created ?? "YYYY-MM-DD" ?></p>
        </div>
    </button>
    <div class="menus">
        <button onclick="myFunction('personal')"><i class="fa-solid fa-house"></i>Personal</button>
        <!-- profile photo upload here -->
        <!-- TODO: MOVE THE PROFILE PHOTO UPLOAD TO THE LANDING USER PROFILE VIEW PAGE -->
        <!-- <form action="index.php?action=userPhotoUpload" method="post" enctype="multipart/form-data">
      <button id="photoUploadClick" type="button" onclick="profilePhoto.click()">
        <img id="imgPreview" src="./public/images/default.svg" alt="" width="100" height="100" />
      </button>
      <p>
        <label for="profilePhoto">Click photo to update</label>
        <input type="file" name="profilePhoto" id="profilePhoto" accept="image/*" />
      </p>
      <p>
        <input id="submitUploadPhoto" type="submit" value="UPLOAD" />
      </p>
    </form> -->
        <!-- <div class="profile-name">
            <h4>Elon Musk</h4>
            <p>Space</p>
        </div> -->
        <button onclick="myFunction('education')"><i class="fa-solid fa-chart-simple"></i>Education</button>

        <button onclick="myFunction('experience')"><i class="fa-solid fa-chart-simple"></i>Experience</button>

        <button onclick="myFunction('skills')"><i class="fa-solid fa-bookmark"></i></i>Skills</button>

        <button onclick="showCalendarPage()"><i class="fa-solid fa-message"></i>Availability</button>
    </div>
</div>


<!-- main -->
<div class="main">
    <section id="landing">
        <?php include('./view/userProfileLanding.php') ?>
    </section>

    <section id="personal" class="hidden">
        <?php include('./view/userProfilePersonal.php') ?>
    </section>

    <section id="education" class="hidden">
        <?php include('./view/userProfileEducation.php') ?>
    </section>

    <section id="experience" class="hidden">
        <?php include('./view/userProfileExperience.php') ?>
    </section>

    <section id="skills" class="hidden">
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
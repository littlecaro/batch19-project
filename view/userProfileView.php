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
    <h1 class="logo"><a href="./index.php"> WaygukIn</a></h1>

    <!-- <button class="profile" onclick="myFunction('landing')">
            <img class="profile-img" src="./public/images/ElonMusk.webp" alt="Elon Musk's photo looking head to left">
            <div class="profile-name">
                <h4>Elon Musk</h4>
                <p>Space</p>
            </div>
    </button> -->
    
    <!-- profile photo upload here -->
    <div class="profile">
        <form
      action="index.php?action=userPhotoUpload"
      method="post"
      enctype="multipart/form-data"
    >
      <button id="photoUploadClick" type="button" onclick="profilePhoto.click()">
        <img
          id="imgPreview"
          src="./public/images/default.svg"
          alt=""
          width="200"
          height="200"
        />
      </button>
      <p>
        <label for="profilePhoto">Click photo to update</label>
        <input
          type="file"
          name="profilePhoto"
          id="profilePhoto"
          accept="image/*"
        />
      </p>
      <p>
        <input id="submitUploadPhoto" type="submit" value="UPLOAD" />
      </p>
    </form>
        <!-- <div class="profile-name">
            <h4>Elon Musk</h4>
            <p>Space</p>
        </div> -->
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
    <section id="landing">

        <?php include('./view/userProfileLanding.php') ?>

    </section>


    <section id="personal" class="hidden">

        <?php include('./view/userProfilePersonal.php') ?>

    </section>
    <section id="resume" class="hidden">
      <div id="resume">
        <form
        action="index.php?action=userResumeUpload"
        method="post"
        enctype="multipart/form-data"
        >
        <p>
              <h2>Resume/CV</h2>
              <input
                type="file"
                name="resume"
                id="resume"
                accept=".pdf"
              />
            </p>
            <p>
              <input id="submitResume" type="submit" value="Save" />
            </p>
          </form>
        </div>
    </section>

    <section id="resume" class="hidden">
      <div id="resume">
        <form
        action="index.php?action=userResumeUpload"
        method="post"
        enctype="multipart/form-data"
        >
        <p>
              <h2>Resume/CV</h2>
              <input
                type="file"
                name="resume"
                id="resume"
                accept=".pdf"
              />
            </p>
            <p>
              <input id="submitResume" type="submit" value="UPLOAD" />
            </p>
          </form>
        </div>
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
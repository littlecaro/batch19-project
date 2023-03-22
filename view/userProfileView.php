<?php
$title = "userProfile";
ob_start();
?>
<!-- part of website icon: we can choose from navibar or can create our own -->
<!--sidebar  -->
<div class="sidebar">
    <h1 class="logo"><a href="./index.html"> WaygukIn</a></h1>
    <div class="profile">
        <!-- We need here a profile picture -->
        <img class="profile-img" src="./ElonMusk.webp" alt="Elon Musk's photo looking head to left">
        <div class="profile-name">
            <h4>Elon Musk</h4>
            <p>Space</p>
        </div>
    </div>
    <div class="menus">
        <button onclick="myFunction('personal')"><i class="fa-solid fa-house"></i>Personal</button>

        <button onclick="myFunction('resume')"><i class="fa-solid fa-magnifying-glass"></i>Resume/CV</button>

        <button onclick="myFunction('education')"><i class="fa-solid fa-chart-simple"></i>Education & Experience</button>

        <button onclick="myFunction('skills')"><i class="fa-solid fa-bookmark"></i></i>Skills</button>

        <button onclick="myFunction('avail')"><i class="fa-solid fa-message"></i>Availability</button>
    </div>
</div>

<!-- main -->
<div class="main">
    <section id="personal">
        <p class="firstname">Bagtyyar</p>
        <p class="lastname">Annayev</p>
    </section>

    <section id="resume" class="hidden">
        <p>Upload so resume</p>
    </section>

    <section id="education" class="hidden">
        <p>Your education level</p>
    </section>

    <section id="skills" class="hidden">
        <p>Your Skills</p>
    </section>

    <section id="avail" class="hidden">
        <p>Your Availability</p>
    </section>

</div>

<?php
$content = ob_get_clean();
require('./view/userProfileTemplate.php');
?>
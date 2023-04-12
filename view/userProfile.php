<?php

if (empty($_SESSION['id'])) {
    header('location: http://localhost/sites/batch19-project/index.php');
exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/style.css">
    <!-- <script defer src="../public/js/userProfile.js"></script> -->
    <title>User Profile</title>
</head>


<body>
    <button>
        <a href="./view/userProfilePage1.php">Personal</a>
    </button><br /><br />
    <button>
        <a href="./view/userProfilePage2.php">Resume/CV</a>
    </button><br /><br />
    <button>
        <a href="./view/userProfilePage3.php">Education & Experience</a>
    </button><br /><br />
    <button>
        <a href="./view/userProfilePage4.php">Skills</a>
    </button><br /><br />
    <button>
        <a href="./view/userProfilePage5.php">Availability</a>
    </button><br /><br />

    <pre>
        <?php print_r($user); ?>
    </pre>

    <div id="personal">
        <form action="index.php?action=userProfilePersonal" method="POST">
            <h2>Personal</h2>
            <label for="phonenb">Phone Number:</label>
            <input type="text" name="phoneNb" value="<?= htmlspecialchars($user->phone_number ?? ""); ?>" />
            <br />
            <p>
                <span class="tooltip">Please select a city: </span>
                <!-- change all placeholders to $user->... -->
                <select name="city" id="city">
                    <option value="city">Select your city of residence</option>
                    <option value="Andong">Andong</option>
                    <option value="Ansan">Ansan</option>
                    <option value="Anyang">Anyang</option>
                    <option value="Boryeong">Boryeong</option>
                    <option value="Bucheon">Bucheon</option>
                    <option value="Busan">Busan</option>
                    <option value="Cheonan">Cheonan</option>
                    <option value="Cheongju">Cheongju</option>
                    <option value="Chungju">Chungju</option>
                    <option value="Daejeon">Daejeon</option>
                    <option value="Dangjin">Dangjin</option>
                    <option value="Gangneung">Gangneung</option>
                    <option value="Gimcheon">Gimcheon</option>
                    <option value="Gimhae">Gimhae</option>
                    <option value="Gimpo">Gimpo</option>
                    <option value="Gongju">Gongju</option>
                    <option value="Goyang">Goyang</option>
                    <option value="Cheonan">Cheonan</option>
                    <option value="Gunsan">Gunsan</option>
                    <option value="Guri">Guri</option>
                    <option value="Gwangju">Gwangju</option>
                    <option value="Gwangmyeong">Gwangmyeong</option>
                    <option value="Gwangyang">Gwangyang</option>
                    <option value="Gyeongju">Gyeongju</option>
                    <option value="Hanam">Hanam</option>
                    <option value="Hwaseong">Hwaseong</option>
                    <option value="Icheon">Icheon</option>
                    <option value="Iksan">Iksan</option>
                    <option value="Incheon">Incheon</option>
                    <option value="Jecheon">Jecheon</option>
                    <option value="Jeju">Jeju</option>
                    <option value="Jeongeup">Jeongeup</option>
                    <option value="Jeonju">Jeonju</option>
                    <option value="Jinju">Jinju</option>
                    <option value="Mokpo">Mokpo</option>
                    <option value="Naju">Naju</option>
                    <option value="Namyangju">Namyangju</option>
                    <option value="Gyeongju">Gyeongju</option>
                    <option value="Osan">Osan</option>
                    <option value="Paju">Paju</option>
                    <option value="Pocheon">Pocheon</option>
                    <option value="Pochang">Pochang</option>
                    <option value="Pyeongtaek">Pyeongtaek</option>
                    <option value="Samcheok">Samcheok</option>
                    <option value="Sejong">Sejong</option>
                    <option value="Seogwipo">Seogwipo</option>
                    <option value="Seongnam">Seongnam</option>
                    <option value="Soesan">Soesan</option>
                    <option value="Seoul">Seoul</option>
                    <option value="Suncheon">Suncheon</option>
                    <option value="Suwon">Suwon</option>
                    <option value="Uijeongbu">Uijeongbu</option>
                    <option value="Ulsan">Ulsan</option>
                    <option value="Wonju">Wonju</option>
                    <option value="Yangju">Yangju</option>
                    <option value="Yeosu">Yeosu</option>
                    <option value="Yongin">Yongin</option>
                </select>
            </p>
            <label for="salary">Expected salary (KRW):</label>
            <input type="text" name="salary" value="<?= htmlspecialchars($user->desired_salary ?? ""); ?>" /><br />
            <p>
                Do you need visa sponsorhip?
                <label for="yes">Yes</label>
                <input type="radio" name="visa" id="yes" value="<?= $user->visa_sponsorship; ?>" checked />
                <label for="no">No</label>
                <input type="radio" name="visa" id="no" value="<?= $user->visa_sponsorship; ?>" />
            </p>
        </form>
    </div>


    <div id="resume"></div>

    <div id="education">
        <form action="index.php?action=userProfileEducation&Experience" method="POST">

            <h2>Education Level</h2>
            <label for="degree">Level of Education</label>
            <select name="degree" id="degree">
                <option value="educationLevel">Select your education level</option>
                <option value="highschool">High School</option>
                <option value="associates">Associates Degree</option>
                <option value="undergraduate">Undergraduate</option>
                <option value="graduate">Graduate</option>
                <option value="phD">PhD</option>
            </select><br /><br />
            <label for="major">Subject of study</label>
            <input type="text" name="major" id="major" value="<?php $education->degree; ?>"><br /><br />

            <h2>Experience</h2>
            <!-- labels -->
            <label for="jobTitle">Job Title</label>
            <input type="text" name="jobTitle" id="jobTitle" value="<?php if (isset($experience->job_title) ? $experience->job_title : "");  ?>"><br /><br />
            <label for="yearsExperience">Years Experience</label>
            <input type="number" name="yearsExperience" id="yearsExperience" min="1" max="40" value="<?php if (isset($experience->years_experience) ? $experience->years_experience : "");  ?>"><br /><br />
            <label for="company">Company Name</label>
            <input type="text" name="company" id="company" value="<?php if (isset($experience->company_name) ? $experience->company_name : ""); ?>" /><br /><br />

        </form>
    </div>

    <div id="skills">
        <form action="index.php?action=userProfileSkills" method="POST">
            <h2>Skills</h2>
            <label for="programming">Programming Languages & Proficiency</label>
            <input type="text" name="skillset" id="skillset" placeholder="Programming Language Proficiencies">
            <select name="yearsProgramming" id="yearsProgramming">
                <option value="year">Select years experience</option>
                <option value="year1">1 year</option>
                <option value="year2">2 years</option>
                <option value="year3">3 years</option>
                <option value="year4">4 years</option>
                <option value="year5">5 years</option>
                <option value="year6">6 years</option>
                <option value="year7">7 years</option>
                <option value="year8">8 years</option>
                <option value="year9">9 years</option>
                <option value="year10">10+ years</option>
            </select><br /><br />
            <label for="lang">Spoken and/or Written Language Proficiency</label>
            <input type="text" name="lang" id="lang" placeholder="Language">
            <select name="degree" id="degree">
                <option value="proficiency">Select proficiency</option>
                <option value="beginner">Beginner</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
                <option value="native">Native</option>
            </select><br /><br />
        </form>
    </div>
    <div id="avail"></div>

</body>

</html>
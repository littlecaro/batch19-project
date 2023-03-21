<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="main">
        <p><?= isset($_GET['error']) ? $_GET['error'] : "" ?></p>
        <form action="index.php?action=userProfilePage1" method="POST">
            <h2>Experience</h2>
            <!-- labels -->
            <label for="jobTitle">Job Title</label>
            <input type="text" name="jobTitle" id="jobTitle" placeholder="Job Title"><br /><br />
            <label for="yearsExperience">Years Experience</label>
            <input type="number" name="yearsExperience" id="yearsExperience" min="1" max="40"><br /><br />
            <label for="company">Company Name</label>
            <input type="text" name="company" id="company" placeholder="Company Name" /><br /><br />

            <h2>Education Level</h2>
            <label for="degree">Level of Education</label>
            <select name="degree" id="degree">
                <option value="highschool">High School</option>
                <option value="associates">Associates Degree</option>
                <option value="undergraduate">Undergraduate</option>
                <option value="graduate">Graduate</option>
                <option value="phD">PhD</option>
            </select><br /><br />
            <label for="major">Subject of study</label>
            <input type="text" name="major" id="major" placeholder="BSc Computer Science..."><br /><br />

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
</body>

</html>
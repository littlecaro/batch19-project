<form id="experienceForm"> <!-- Submitted with AJAX -->

    <h2>Experience</h2>
    <!-- labels -->
    <label for=" jobTitle">Job Title</label>
    <input type="text" name="jobTitle" id="jobTitle" value="<?= $experience->job_title; ?>"><br /><br />

    <label for="yearsExperience">Years Experience</label>
    <input type="number" name="yearsExperience" id="yearsExperience" min="1" max="40" value="<?= $experience->years_experience; ?>"><br /><br />

    <label for="company">Company Name</label>
    <input type="text" name="companyName" id="companyName" value="<?= $experience->company_name; ?>" /><br /><br />

    <input id="userIdExperience" type="hidden" name="userId" value="<?= $_SESSION['id']; ?>">

    <input type="submit" value="Save">

    <p id="experienceUpdateStatus"></p>

    <script defer src="./public/js/updateUserExperience.js"></script>

</form>
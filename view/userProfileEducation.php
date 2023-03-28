<form id="educationForm"> <!-- Submitted with AJAX -->

    <h2>Education Level</h2>
    <label for="degree">Level of Education</label>
    <select name="degree" id="degree">
        <option value="0">High School</option>
        <option value="2">Associates Degree</option>
        <option value="3">Undergraduate</option>
        <option value="4">Graduate</option>
        <option value="5">PhD</option>
    </select><br /><br />
    <label for="major">Subject of study</label>
    <input type="text" name="major" id="major" value="<?= $education->degree; ?>"><br /><br />

    <input id="userIdEducation" type="hidden" name="userId" value="<?= $_SESSION['id']; ?>">
    <input type="submit" value="Save">
    <p id="educationUpdateStatus"></p>
</form>
<script src="./public/js/updateUserEducation.js"></script>
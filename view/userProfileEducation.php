<form id="educationForm"> <!-- Submitted with AJAX -->
    <script>
        const educationLevel = `<?php if (!empty($educationLevel)) {
                                    echo  $educationLevel[0]->name;
                                } ?>`
    </script>
    <h2>Education Level</h2>
    <label for="degree">Level of Education</label>
    <select name="degree" id="degree">
        <option value="">Select your Education Level</option>
        <option value="0" <?= $education->degree_level === 0 ? "selected" : "" ?>>High School</option>
        <option value="2" <?= $education->degree_level === 2 ? "selected" : "" ?>>Associates Degree</option>
        <option value="3" <?= $education->degree_level === 3 ? "selected" : "" ?>>Undergraduate</option>
        <option value="4" <?= $education->degree_level === 4 ? "selected" : "" ?>>Graduate</option>
        <option value="5" <?= $education->degree_level === 5 ? "selected" : "" ?>>PhD</option>
    </select><br /><br />
    <label for="major">Subject of study</label>
    <input type="text" name="major" id="major" value="<?= htmlspecialchars($education->degree ?? ""); ?>"><br /><br />

    <input id="userIdEducation" type="hidden" name="userId" value="<?= $_SESSION['id']; ?>">
    <input type="submit" value="Save">
    <p id="educationUpdateStatus"></p>
</form>
<script src="./public/js/updateUserEducation.js"></script>
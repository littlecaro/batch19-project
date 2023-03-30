<h2>Experience</h2>
<style>
    dialog {
        padding: 0;
    }

    dialog::backdrop {
        background: black;
        opacity: 0.5;
    }

    #experienceForm {
        padding: 30px;
    }

    .userExperienceCard {
        border: 1px solid black;
        height: 250px;
        width: 250px;
        margin: 10px;
    }
</style>
<!-- labels -->
<?php

foreach ($experiences as $experience) {
    include('./view/components/userProfileExperiencePostingCard.php');
}

?>
<button id="newExpBtn">ADD NEW EXPERIENCE</button>


<p id="experienceUpdateStatus"></p>

<dialog>

    <div>

        <form id="experienceForm"> <!-- Submitted with AJAX (NOT anymore???) -->

            <input type="text" name="jobTitle" id="jobTitle" value="<?= $experience->job_title; ?>"><br /><br />

            <label for="yearsExperience">Years Experience</label>
            <input type="number" name="yearsExperience" id="yearsExperience" min="1" max="40" value="<?= $experience->years_experience; ?>"><br /><br />

            <label for="company">Company Name</label>
            <input type="text" name="companyName" id="companyName" value="<?= $experience->company_name; ?>" /><br /><br />

            <input id="userIdExperience" type="hidden" name="userId" value="<?= $_SESSION['id']; ?>">

            <input type="submit" value="Save">
            <button type="button" class="addNewExpBtn">
                Save
            </button>

            <button type="button" class="closeNewExpBtn">
                No
            </button>
        </form>

    </div>
</dialog>
<script defer src="./public/js/updateUserExperience.js"></script>
<script>
    const modal = document.querySelector("dialog")

    document.querySelector("#newExpBtn").addEventListener("click", () => {
        modal.showModal();
    });

    const closeBtns = document.getElementsByClassName("closeNewExpBtn");

    for (btn of closeBtns) {
        btn.addEventListener("click", () => {
            modal.close();
        })
    }

    modal.addEventListener("click", function(e) {
        if (event.target === modal) {
            modal.close();
        }
    })
</script>
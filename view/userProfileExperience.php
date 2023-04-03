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


    .userExperienceInfo {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        outline: 1px solid black;
        margin: 20px;
        padding: 30px;
        width: 250px;
    }

    #userExperienceCard {
        display: flex;
    }

    .userExperienceInfo p {
        padding: 0px;
    }

    #addExperienceForm {
        padding: 20px;
    }

    .updateExperienceForm {
        padding: 20px;
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

<dialog id="addExperience">
    <div>

        <form id="addExperienceForm"> <!-- Submitted with AJAX (NOT anymore???) -->

            <label for="company">Company Name</label>
            <input type="text" name="companyName" id="companyName" value="" /><br /><br />

            <label for="jobTitle">Job Title</label>
            <input type="text" name="jobTitle" id="jobTitle" value=""><br /><br />

            <label for="yearsExperience">Years Experience</label>
            <input type="number" name="yearsExperience" id="yearsExperience" min="1" max="40" value=""><br /><br />

            <input id="userIdExperience" type="hidden" name="userId" value="<?= $_SESSION['id']; ?>">

            <button type="submit" class="addNewExpBtn">
                Save
            </button>

            <button type="button" class="closeNewExpBtn">
                Cancel
            </button>
        </form>

    </div>
</dialog>

<!-- value="<?= $experience->company_name; ?>" /><br /><br />
value="<?= $experience->job_title; ?>"><br /><br />
value="<?= $experience->years_experience; ?>"><br /><br />
value="<?= $_SESSION['id']; ?>"> -->

<script defer src="./public/js/updateUserExperience.js"></script>
<script>
    // const modalEdit = document.querySelector("dialog");
    const editBtns = document.querySelectorAll(".editUserExperience"); //button for edit for opening the dialog(modal)

    for (editBtn of editBtns) {
        editBtn.addEventListener("click", (e) => {
            e.target.parentNode.nextElementSibling.showModal(); //grabbing the dialog to show - DOM moving
            //this is to get the specif info on each card to edit
        });
    }
    // DUN WORK
    // for (editBtn of editBtns) { editBtn.addEventListener("click", () => { modalEdit.showModal(); });
    // console.log(e.target.parentNode.textContent);}
    const closeEditBtns = document.getElementsByClassName("closeEditExpBtn"); // button for cancel

    for (closeEditBtn of closeEditBtns) {
        closeEditBtn.addEventListener("click", (e) => {
            // console.log(e.target.parentNode.parentNode.parentNode);
            e.target.parentNode.parentNode.parentNode.close();
        })
    }
    const modalBoxs = document.getElementsByClassName("editExperience"); // button for update
    for (let modalBox of modalBoxs) {
        modalBox.addEventListener("click", function(e) {
            if (event.target === modalBox) {
                modalBox.close();
            }
        })
    }
    const modalDeletes = document.getElementsByClassName("deleteExpBtn");
    console.log(modalDeletes);
    for (let modalDelete of modalDeletes) {
        modalDelete.addEventListener("click", (e) => {

        })
    }
</script>

<script defer src="./public/js/addNewUserExperience.js"></script>
<script>
    const modalAdd = document.querySelector("#addExperience")

    document.querySelector("#newExpBtn").addEventListener("click", () => {
        modalAdd.showModal();
    });

    const closeBtns = document.getElementsByClassName("closeNewExpBtn");

    for (btn of closeBtns) {
        btn.addEventListener("click", () => {
            modalAdd.close();
        })
    }

    modalAdd.addEventListener("click", function(e) {
        if (event.target === modalAdd) {
            modalAdd.close();
        }
    })
</script>
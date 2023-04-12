<?php

if (empty($_SESSION['id'])) {
    header('location: http://localhost/sites/batch19-project/index.php');
exit;
}

?>
<h2>Experience</h2>
<style>
    /* #experience {
        display: flex;
    }

    .experienceContainer {} */

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

<script defer src="./public/js/addNewUserExperience.js"></script>
<!-- <script defer src="./public/js/deleteUserExperience.js"></script> -->
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

<script defer src="./public/js/updateUserExperience.js"></script>
<script>
    // const modalEdit = document.querySelector("dialog");
    const editBtns = document.querySelectorAll(".editUserExperience"); // edit button on the  for opening the dialog(modal)

    for (editBtn of editBtns) {
        editBtn.addEventListener("click", (e) => {
            e.target.parentNode.nextElementSibling.showModal(); //grabbing the dialog to show - DOM moving
            //this is to get the specif info on each card to edit
        });
    }
    // DUN WORK // for (editBtn of editBtns) { editBtn.addEventListener("click", () => { modalEdit.showModal(); }); // console.log(e.target.parentNode.textContent);}
    const closeEditBtns = document.getElementsByClassName("closeEditExpBtn"); // button for cancel

    for (closeEditBtn of closeEditBtns) {
        closeEditBtn.addEventListener("click", (e) => {
            // console.log(e.target.parentNode.parentNode.parentNode);
            e.target.parentNode.parentNode.parentNode.close();
        })
    }
    const modalBoxs = document.getElementsByClassName("editExperience"); // the update btn in JS file
    for (let modalBox of modalBoxs) {
        modalBox.addEventListener("click", function(e) {
            if (event.target === modalBox) {
                modalBox.close();
            }
        })
    }
    const modalDeletes = document.getElementsByClassName("deleteExpBtn"); //delete btn
    // console.log(modalDeletes);
    for (let modalDelete of modalDeletes) {
        modalDelete.addEventListener("click", (e) => {
            e.preventDefault();
            // console.log(e);
            const formData = new FormData();

            formData.append("jobID", e.target.value);

            // console.log("jobID:", e.target.value); //showing job ID
            // console.log(e); // shows everything
            let xhr = new XMLHttpRequest(); // it didn't work on the JS file so copied and pasted it into here directly.
            xhr.open(
                "POST",
                `http://localhost/sites/batch19-project/index.php?action=deleteUserExperience`
            );
            xhr.addEventListener("readystatechange", function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    window.location.href =
                        "http://localhost/sites/batch19-project/index.php?action=userProfileView";
                    // let response = xhr.responseText;
                    // experienceUpdateStatus.textContent = response;
                    // console.log(response); // 2nd step // shows the "query" DELETE FROM database table...
                }
            });
            xhr.send(formData);
        })
    }
</script>
<form id="experienceForm"> <!-- Submitted with AJAX -->

    <div class="userProfile">
        <div class="main">
            <h3>Job Experiences</h3><br>
            <div class="experiencesWrapper">
                <?php
                // print_r($listings);
                if (!empty($experiences) && empty($experienceId)) {
                    foreach ($experiences as $exprience) {
                        require "./view/components/jobPostingCard.php";
                    }
                } else if (!empty($experienceId)) {
                    require "./view/components/jobCard.php";
                } ?>
            </div>
            <?php

            if (!empty($exprienceId)) {
            ?>
                <div class="JobPostingActions">
                    <button id="jobPostingEditBtn" class="button">Edit</button>
                    <button id="jobPostingFinishBtn" class="button">Finish</button>
                    <button id="jobPostingBackBtn" class="button">Back</button>
                </div>

            <?php
            } else { ?>
                <a href="./index.php?action=createJobForm" id="addaJobBtn">
                    <button class="button">ADD AN EXPERIENCE</button>
                </a><?php
                } ?>
        </div>
    </div>


</form>
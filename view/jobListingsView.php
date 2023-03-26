<?php
$title = "company dashboard";
ob_start();
?>

<!-- main -->
<div class="userProfile">
    <div class="main">
        <h3>Job Listings</h3><br>
        <div class="jobListingWrapper">
            <?php
            // print_r($listings);
            if (!empty($listings)) {
                foreach ($listings as $listing) {
                    require "./view/components/jobPostingCard.php";
                }
            } ?>
        </div>
        <a href="./index.php?action=createJobForm" id="addaJobBtn">
            <button class="button">ADD A JOB</button>
        </a>
    </div>
</div>
<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
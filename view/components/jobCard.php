<div class="jobPostingCardFull">
    <div class="jobPostingCardHead">
        <div class="jobPostingCardCompanyLogo">
            <img src="<?= $jobCard->logo_img ?>" alt="">
        </div>
    </div>
    <div class="jobPostingInfo">
        <h1 class="jobPostingTitle"><?= $jobCard->title ?></h1>
        <p><?= $jobCard->city_name . ", " . $jobCard->country_code ?></p>
        <h2>About the job</h2>
        <p class="editableContext"><?= $jobCard->job_description ?></p>
        <p>Salary range: <span class="editableContext"><?= $jobCard->salary_min ?></span> <span>₩</span><span> - </span> <span class="editableContext"><?= $jobCard->salary_max ?></span> <span>₩</span></p><span>Application deadline: </span>
        <span class="editableContext" id="datetimepicker"><?= date_format(date_create($jobCard->deadline), "Y-m-d") ?></span><span>,</span>
        <span><?= "Date of posting: " . date_format(date_create($jobCard->date_created), "Y-m-d") ?></span>
        <div class="aboutTheCompany">
            <h2>About the company</h2>
            <p><?= $jobCard->name ?></p>
            <p><?= $jobCard->website_address ?></p>
        </div>
    </div>

</div>
<script defer src="public\javascript\editJobPosting.js"></script>
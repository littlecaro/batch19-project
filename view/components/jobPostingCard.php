<a href="index.php?action=jobListings&ListingId=<?= $listing->jobId ?>">
    <div class="jobPostingCard" data=<?= $listing->is_active ?>>
        <div class="jobPostingCardHead">
            <div class="jobPostingCardCompanyLogo">
                <img src="<?= $listing->logo_img ?>" alt="">
            </div>
        </div>
        <div class="jobPostingInfo">
            <p class="jobPostingTitle"><?= $listing->title ?></p>
            <p><?= $listing->name ?></p>
            <p><?= $listing->city_name . ", " . $listing->country_code ?></p>
            <p><?= "Application deadline: " . date_format(date_create($listing->deadline), "Y-m-d") ?></p>
        </div>

    </div>
</a>
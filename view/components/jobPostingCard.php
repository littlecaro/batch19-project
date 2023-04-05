<a href="index.php?action=jobListings&ListingId=<?= $listing->jobId ?>">
    <div class="jobPostingCard" data=<?= $listing->is_active ?>>
        <div class="jobPostingCardHead">
            <div class="jobPostingCardCompanyLogo">
                <img src="<?= htmlspecialchars($listing->logo_img) ?>" alt="">
            </div>
        </div>
        <div class="jobPostingInfo">
            <p class="jobPostingTitle"><?= htmlspecialchars($listing->title) ?></p>
            <p><?= htmlspecialchars($listing->name) ?></p>
            <p><?= htmlspecialchars($listing->city_name) . ", " . htmlspecialchars($listing->country_code) ?></p>
            <p><?= "Application deadline: " . date_format(date_create($listing->deadline), "Y-m-d") ?></p>
        </div>

    </div>
</a>
<!-- TODO: Will have more than one experience entry, so loop through and view until done.  -->
<div class="landingCard">
<h2><?= $experience->job_title; ?></h2>
        <div class="landingSameLine">
                <h3><?= $experience->company_name; ?></h3>
                <p><?= $experience->years_experience; ?> years</p>
        </div>
        <p><i class="fa-solid fa-location-dot"></i><?= $userManager->getCityName($experience->city_id)[0]->name; ?></p>
        <p><?= $experience->job_description; ?></p>
        </div>
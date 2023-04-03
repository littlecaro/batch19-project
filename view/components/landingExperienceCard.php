<div class="landingCard">
<h2><?= $profExp->job_title; ?></h2>
        <div class="landingSameLine">
                <h3><?= $profExp->company_name; ?></h3>
                <p><?= $profExp->years_experience; ?> years</p>
        </div>
        <p><i class="fa-solid fa-location-dot"></i><?= $userManager->getCityName($profExp->city_id)[0]->name; ?></p>
        <p><?= $profExp->job_description; ?></p>
        </div>
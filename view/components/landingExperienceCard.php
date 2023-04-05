<div class="landingCard">
<h2><?= !empty($profExp->job_title) ? $profExp->job_title : null ?></h2>
        <div class="landingSameLine">
                <h3><?= !empty($profExp->company_name) ? $profExp->company_name : null ?></h3>
                <?php if(!empty($profExp->years_experience AND $profExp->years_experience > 1)) {
                                $years = "years";
                        } else {
                                $years = "year";
                        } ?>
                <p><?= !empty($profExp->years_experience) ? "$profExp->years_experience $years" : null ?></p>
        </div>
        <!-- <i class="fa-solid fa-location-dot"></i> -->
        <p><?= !empty($profExp->city_id) ? $userManager->getCityName($profExp->city_id)[0]->name : null ?></p>
        <p><?= !empty($profExp->job_description) ? $profExp->job_description : null ?></p>
</div>
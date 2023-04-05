<div class="landingCard">
<h2><?= !empty($profExp->job_title) ? htmlspecialchars($profExp->job_title) : null ?></h2>
        <div class="landingSameLine">
                <h3><?= !empty($profExp->company_name) ? htmlspecialchars($profExp->company_name) : null ?></h3>
                <?php if(!empty(htmlspecialchars($profExp->years_experience) AND htmlspecialchars($profExp->years_experience) > 1)) {
                                $years = "years";
                        } else {
                                $years = "year";
                        } ?>
                <p><?= !empty($profExp->years_experience) ? htmlspecialchars($profExp->years_experience) . " $years" : null ?></p>
        </div>
        <!-- <i class="fa-solid fa-location-dot"></i> -->
        <p><?= !empty($profExp->city_id) ? htmlspecialchars($userManager->getCityName)($profExp->city_id)[0]->name : null ?></p>
        <p><?= !empty($profExp->job_description) ? htmlspecialchars($profExp->job_description) : null ?></p>
</div>
<div class="landingCard">
    <h2><?= !empty($education->institution) ? htmlspecialchars($education->institution) : null ?></h2>
        <div class="landingSameLine">
            <h3><?php
                    if (!empty ($education->degree_level)) {
                        switch (htmlspecialchars($education->degree_level)) {
                            case 0:
                                echo "High School, ";
                                break;
                            case 2:
                                echo "Associates Degree, ";
                                break;
                            case 3:
                                echo "Undergraduate, ";
                                break;
                            case 4:
                                echo "Graduate, ";
                                break;
                            case 5:
                                echo "PhD, ";
                                break;
                            }
                    }
            ?>
        
            <?= !empty($education->degree) ? htmlspecialchars($education->degree) : null ?></h3>
            <p> <?= !empty($education->date_start) ? htmlspecialchars(eduDateToStr($education->date_start)) . " - " . eduDateToStr($education->date_end) : null ?></p>
        </div>
        <!-- <i class="fa-solid fa-location-dot"></i> -->
        <p><?= !empty($education->city_id) ? htmlspecialchars($userManager->getCityName)($education->city_id)[0]->name : null ?></p>
        <p><?= !empty($education->description) ? htmlspecialchars($education->description) : null ?></p>
</div>

<?php

function eduDateToStr($str) {
    $d = strtotime($str);
    return date("F Y", $d);
}

?>
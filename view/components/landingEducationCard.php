<div class="landingCard">
    <h2><?= $education->institution ?></h2>
        <div class="landingSameLine">
            <h3><?php       switch ($education->degree_level) {
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
            ?>
        
            <?= $education->degree ?></h3>
            <p> <?= eduDateToStr($education->date_start) . " - " . eduDateToStr($education->date_end); ?></p>
        </div>
        <p><i class="fa-solid fa-location-dot"></i><?= $userManager->getCityName($education->city_id)[0]->name; ?></p>
        <p><?= $education->description ?></p>
</div>

<?php

function eduDateToStr($str) {
    $d = strtotime($str);
    return date("F Y", $d);
}

?>
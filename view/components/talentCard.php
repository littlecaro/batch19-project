<div class="talentCard">
    <div class="talentCardHead">
        <div class="talentCardHeadLeft">
            <div class="messageProfileImg">
                <img src="<?= $talentInfo[0]->profile_picture ?>" alt="">
            </div>
            <p><?= $talentInfo[0]->first_name . " " . $talentInfo[0]->last_name; ?></p>
        </div>
        <div class="talentMatch"><?php
                                    if (isset($rating)) {
                                    ?><p>Match rating:<?php
                                                        echo floor($rating * 100) . "%";
                                                        ?></p>
                <progress id="matchperc" value=<?= $rating * 100 ?> max="100"></progress>
            <?php }  ?>
        </div>
    </div>
    <div class="talentCardMain">
        <div class="talentBasicInfo">
            <h4>Basic information</h4>
            <ul>
                <li>Years of Experience: <?= $yearsExperience[0]->years_experience1 ?></li>
                <li>Highest Degree: <?php
                                    $degreeEquivalents = (object) array(
                                        0 => "Mandatory Education",
                                        2 => "2 Year College Equivalent",
                                        3 => "Bachelors Equivalent",
                                        4 => "Masters Equivalent",
                                        5 => "Phd Equivalent"
                                    );
                                    $degreeLevel = $highestDegree[0]->highestDegree;
                                    if (!empty($degreeEquivalents->$degreeLevel)) {
                                        echo
                                        $degreeEquivalents->$degreeLevel;
                                    } else {
                                        echo "none";
                                    } ?></li>
                <li>Location: <?= $talentLocation[0]->location ?? "None" ?></li>
            </ul>
        </div>
        <div class="talentDesiredPosition">
            <h4>Desired position</h4>
            <ul>
                <?php if (!empty($desiredPositions)) {
                    foreach ($desiredPositions as $desiredPosition) {
                ?>
                        <li><?= $desiredPosition->desired_position ?></li>
                <?php
                    }
                }
                ?>
            </ul>
        </div>
        <div class="talentSkills">
            <h4>Skills / Technologies</h4>
            <p>
                <?php
                if (!empty($skills)) {
                    foreach ($skills as $skill) {
                ?>
                        <span class="skillIssue"><?= $skill->skills_fixed ?></span>
                <?php
                    }
                }
                ?>
            </p>
        </div>
    </div>
</div>
<?php

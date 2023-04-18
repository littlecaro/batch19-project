<!-- separate card to not conflict with the $user in messages -->
<div class="landingPersonalCard" class="landingCard">
    <div class="left">
        <img class="profile-img" src="<?= htmlspecialchars($talent->profile_picture); ?>" alt="" width="100" height="100">
    </div>
    <div class="right">
        <h1><?php if (!empty($talent->first_name)) {
                    echo htmlspecialchars($talent->first_name ?? null) . " " . htmlspecialchars($talent->last_name ?? null);
                    }; ?></h1>
        <p><b>Email:</b> <?= htmlspecialchars($talent->email); ?></p>
        <p><b>Phone number:</b> <?= !empty($talent->phone_number) ? htmlspecialchars($talent->phone_number) : "User has not entered a phone number."; ?></p>
        <p><b>Current location:</b> <?php if(!empty($talent->city_id)) {
                                            echo "{$userManager->getCityName($talent->city_id)[0]->name}";
                                            } else {
                                                echo "User has not entered a city.";
                                            }  ?></p>
        <p><b>Uploaded resume:</b> <?php 
                                    if (!empty($talent->resume_file_url)) {
                                        ?>
                                            <a onclick="event.stopPropagation()" href="<?=htmlspecialchars($talent->resume_file_url)?>" target="_blank" rel="noopener noreferrer">Click link to open resume.</a> 
                                        <?php } else {
                                            echo "User has not uploaded a resume.";
                                        } ?></p>
        <p><b>Expected salary (KRW):</b> <?= !empty($talent->desired_salary) ? htmlspecialchars($talent->desired_salary) : "User has not entered an expected salary."; ?></p>
        <p><b>Need visa sponsorship:</b> <?php 
                                        if ($talent->visa_sponsorship == 1) 
                                        { 
                                            echo "Yes";
                                        } 
                                        else if ($talent->visa_sponsorship == 0) 
                                        {
                                            echo "No";
                                        }
                                        ?></p>
    </div>      
</div>
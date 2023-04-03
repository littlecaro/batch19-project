<div class="landingPersonalCard" class="landingCard">
    <div class="left">
        <img src="<?= "$user->profile_picture"; ?>" alt="" width="100" height="100">
    </div>
    <div class="right">
        <h1><?php if (!empty($user->first_name)) {
                    echo "$user->first_name $user->last_name";
                    }; ?></h1>
        <p><b>Email:</b> <?= "$user->email"; ?></p>
        <p><b>Phone number:</b> <?= "$user->phone_number"; ?></p>
        <p><b>Current location:</b> <?php if(!empty($user->city)) {
                                            echo "{$userManager->getCityName($user->city_id)[0]->name}";
                                            }  ?></p>
        <p><b>Expected salary (KRW):</b> <?= $user->desired_salary; ?></p>
        <p><b>Need visa sponsorship:</b> <?php 
                                        if ($user->visa_sponsorship == 1) 
                                        { 
                                            echo "Yes";
                                        } 
                                        else if ($user->visa_sponsorship == 0) 
                                        {
                                            echo "No";
                                        }
                                        ?></p>
    </div>      
</div>
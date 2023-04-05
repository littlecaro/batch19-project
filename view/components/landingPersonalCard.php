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
        <p><b>Current location:</b> <?php if(!empty($user->city_id)) {
                                            echo "{$userManager->getCityName($user->city_id)[0]->name}";
                                            }  ?></p>
        <p class="resume"><b>Uploaded resume:</b> <?php 
                                    if (!empty($user->resume_file_url)) {
                                        ?>
                                            <a class="resume resumeU resumeV" onclick="event.stopPropagation()" href="<?=$user->resume_file_url?>" target="_blank" rel="noopener noreferrer">View your resume</a> 
                                        <?php } ?> <span class="resumeU" id="resumeUpload">Upload new resume</span></p>


                                        
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

<script>
    const resumeUpload = document.querySelector("#resumeUpload");
    resumeUpload.addEventListener("click", (e) => {
        event.stopPropagation();
        myFunction('resume');
    });
</script>
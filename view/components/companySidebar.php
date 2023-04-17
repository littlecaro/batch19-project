<div class="sidebar">
    <div class="profile">
        <!-- We need here a profile picture -->
        <img class="profile-img" src="<?= isset($companyInfo->logo_img) ? htmlspecialchars($companyInfo->logo_img) : "./public/images/uploaded/defaultComp.jpg" ?>" alt="Company logo"><br>
        <div class="profile-name">
            <h4><?= isset($companyInfo->name) ? htmlspecialchars($companyInfo->name) : "NEW COMPANY" ?></h4>
            <p>Member since <?= $companyInfo->date_created ?? "unknown" ?></p>
        </div>
    </div>
    <div class="menus">
        <a href="./index.php?action=companyDashboard"><button><img src="public/images/biz/house.png" width="15">&nbsp;&nbsp;Company Info</button></a>
        <a href="./index.php?action=employeeInfo"><button><img src="public/images/biz/user.png" width="15">&nbsp;&nbsp;Employee Info</button></a>
        <a href="./index.php?action=jobListings"><button><img src="public/images/biz/list.png" width="15">&nbsp;&nbsp;Job Listings</button></a>
        <a href="./index.php?action=savedProfiles"><button><img src="public/images/biz/ribbon.png" width="15">&nbsp;&nbsp;Saved Profiles</button></a>
        <a href="./index.php?action=bookedMeetings"><button><img src="public/images/biz/tick-mark.png" width="15">&nbsp;&nbsp;Booked Meetings</button></a>
    </div>
</div>

<!-- <form action="index.php?action=userProfileView" method="POST"> -->
<form id="personalForm"> <!-- Submitted with AJAX -->
    <script>
        const cityName = `<?php if (!empty($cityName)) {
                                echo  $cityName[0]->name;
                            } ?>`
    </script>
    <h2>Personal</h2>
    <label for="phonenb">Phone Number:</label>
    <input type="text" name="phoneNb" id="phoneNb" value="<?= $user->phone_number; ?>" />
    <br />
    <p>
        <span class="tooltip">Please select a city: </span>
        <!-- change all placeholders to $user->... -->
        <select name="city" id="city">
            <option value="">Select your city of residence</option>
            <option value="Andong">Andong</option>
            <option value="Ansan">Ansan</option>
            <option value="Anyang">Anyang</option>
            <option value="Boryeong">Boryeong</option>
            <option value="Bucheon">Bucheon</option>
            <option value="Busan">Busan</option>
            <option value="Cheonan">Cheonan</option>
            <option value="Cheongju">Cheongju</option>
            <option value="Chungju">Chungju</option>
            <option value="Daejeon">Daejeon</option>
            <option value="Dangjin">Dangjin</option>
            <option value="Gangneung">Gangneung</option>
            <option value="Gimcheon">Gimcheon</option>
            <option value="Gimhae">Gimhae</option>
            <option value="Gimpo">Gimpo</option>
            <option value="Gongju">Gongju</option>
            <option value="Goyang">Goyang</option>
            <option value="Cheonan">Cheonan</option>
            <option value="Gunsan">Gunsan</option>
            <option value="Guri">Guri</option>
            <option value="Gwangju">Gwangju</option>
            <option value="Gwangmyeong">Gwangmyeong</option>
            <option value="Gwangyang">Gwangyang</option>
            <option value="Gyeongju">Gyeongju</option>
            <option value="Hanam">Hanam</option>
            <option value="Hwaseong">Hwaseong</option>
            <option value="Icheon">Icheon</option>
            <option value="Iksan">Iksan</option>
            <option value="Incheon">Incheon</option>
            <option value="Jecheon">Jecheon</option>
            <option value="Jeju">Jeju</option>
            <option value="Jeongeup">Jeongeup</option>
            <option value="Jeonju">Jeonju</option>
            <option value="Jinju">Jinju</option>
            <option value="Mokpo">Mokpo</option>
            <option value="Naju">Naju</option>
            <option value="Namyangju">Namyangju</option>
            <option value="Gyeongju">Gyeongju</option>
            <option value="Osan">Osan</option>
            <option value="Paju">Paju</option>
            <option value="Pocheon">Pocheon</option>
            <option value="Pochang">Pochang</option>
            <option value="Pyeongtaek">Pyeongtaek</option>
            <option value="Samcheok">Samcheok</option>
            <option value="Sejong">Sejong</option>
            <option value="Seogwipo">Seogwipo</option>
            <option value="Seongnam">Seongnam</option>
            <option value="Soesan">Soesan</option>
            <option value="Seoul">Seoul</option>
            <option value="Suncheon">Suncheon</option>
            <option value="Suwon">Suwon</option>
            <option value="Uijeongbu">Uijeongbu</option>
            <option value="Ulsan">Ulsan</option>
            <option value="Wonju">Wonju</option>
            <option value="Yangju">Yangju</option>
            <option value="Yeosu">Yeosu</option>
            <option value="Yongin">Yongin</option>
        </select>
    </p>
    <label for="salary">Expected salary (KRW):</label>
    <input type="text" name="salary" id="salary" value="<?= $user->desired_salary; ?>" /><br />
    <p>
        Do you need visa sponsorhip?
        <label for="yes">Yes</label>
        <input type="radio" name="visa" id="visa" value=1 <?php if ($user->visa_sponsorship == 1) {
                                                                echo "checked";
                                                            } ?> />
        <label for="no">No</label>
        <input type="radio" name="visa" id="visa" value=0 <?php if ($user->visa_sponsorship == 0) {
                                                                echo "checked";
                                                            } ?> />
    </p>

    <input id="id" type="hidden" name="id" value="<?= $_SESSION['id']; ?>">
    <input type="submit" value="Save">
    <p id="personalUpdateStatus"></p>
    <script>
    </script>
    <script defer src="./public/js/updateUserPersonal.js"></script>
</form>
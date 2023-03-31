<!-- <form action="index.php?action=userProfileView" method="POST"> -->
<style>
    #slider-square {
        border-radius: 0;
    }

    #slider-square .noUi-handle {
        border-radius: 0;
        background: #2980b9;
        height: 18px;
        width: 18px;
        top: -1px;
        right: -9px;
    }

    .slider-styled,
    .slider-styled .noUi-handle {
        box-shadow: none;
    }

    /* Hide markers on slider handles */
    .slider-styled .noUi-handle::before,
    .slider-styled .noUi-handle::after {
        display: none;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js" integrity="sha512-UOJe4paV6hYWBnS0c9GnIRH8PLm2nFK22uhfAvsTIqd3uwnWsVri1OPn5fJYdLtGY3wB11LGHJ4yPU1WFJeBYQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css" integrity="sha512-qveKnGrvOChbSzAdtSs8p69eoLegyh+1hwOMbmpCViIwj7rn4oJjdmMvWOuyQlTOZgTlZA0N2PXA7iA8/2TUYA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <br><br><br><br>
    <div class="salaryslider" style=" display:flex; justify-content:center">
        <div class="slider-styled" id="slider-square" style="width:300px;"></div>

        <input type="hidden" name="salary" id="salary" value="<?= $user->desired_salary; ?>" />
        <!-- <input id="salaryMin" type="hidden" name="salaryMin">
        <input id="salaryMax" type="hidden" name="salaryMax"> -->
    </div>

    <br />
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
    <script>
        var arbitraryValuesSlider = document.getElementById('slider-square');
        var arbitraryValuesForSlider = ['₩0', '₩10M', '₩20M', '₩30M', '₩40M', '₩50M', '₩60M', '₩70M', '₩80M+'];
        var format = {
            to: function(value) {
                return arbitraryValuesForSlider[Math.round(value)];
            },
            from: function(value) {
                return arbitraryValuesForSlider.indexOf(value);
            }
        };

        noUiSlider.create(arbitraryValuesSlider, {
            // start values are parsed by 'format'
            start: ['₩50M'],
            connect: true,
            range: {
                min: 0,
                max: arbitraryValuesForSlider.length - 1
            },
            step: 1,
            tooltips: true,
            format: format,
            // pips: {
            //     mode: 'steps',
            //     format: format,
            //     density: 50
            // },
        });
    </script>
    <script>
        const form = document.querySelector("form");
        const slider = document.querySelector("#slider-square");
        form.addEventListener("submit", function(e) {
            const userSalary = slider.noUiSlider.get();
            console.log(userSalary);
            user = userSalary.substr(1, 2);
            document.getElementById('salary').value = parseInt(user);
            e.preventDefault();
        });
    </script>
    <script defer src="./public/js/updateUserPersonal.js"></script>
</form>
<?php
$title = "company dashboard";
ob_start();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js" integrity="sha512-UOJe4paV6hYWBnS0c9GnIRH8PLm2nFK22uhfAvsTIqd3uwnWsVri1OPn5fJYdLtGY3wB11LGHJ4yPU1WFJeBYQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const cities = <?= json_encode($cities); ?>;
</script>
<script src="./public/javascript/multi-selector.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css" integrity="sha512-qveKnGrvOChbSzAdtSs8p69eoLegyh+1hwOMbmpCViIwj7rn4oJjdmMvWOuyQlTOZgTlZA0N2PXA7iA8/2TUYA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- main -->

<div class="bizProfile">
    <div class="main">
        <h3>Add a Job</h3>
        <br>
        <form action="./index.php?action=addNewJob" method="POST">
            <table id="table">
                <tr>
                    <th>Job title</th>
                    <td>
                        <input type="text" name="jobTitle" id="jobTitle" placeholder="Enter a job title">
                        <span class="required" id="demo1"></span>
                    </td>
                </tr>
                <tr>
                    <th id="jobdescription">Job description</th>
                    <td>
                        <textarea id="jobStory" name="jobStory" rows="6" cols="33" placeholder="Enter a job description"></textarea>
                        <span class="required" id="demo2"></span>
                    </td>
                </tr>
                <tr>
                    <th id="salary"><br>Salary</th>
                    <td><br>
                        <div id="slider"></div>
                        <span class="required" id="demo5"></span>
                    </td>
                    <input id="salaryMin" type="hidden" name="salaryMin">
                    <input id="salaryMax" type="hidden" name="salaryMax">
                </tr>
                <tr>
                    <th>City<br><br></th>
                    <td>
                        <?php
                        $containerId = "cities";
                        require("./view/components/multiSelector.php");
                        ?>
                        <span class="required" id="demo4"></span>
                    </td>
                </tr>
                <tr>
                    <th>Job deadline</th>
                    <td>
                        <input type="date" name="deadline" id="deadline" placeholder="Date of job deadline" />
                        <span class="required" id="demo6"></span>
                    </td>
                </tr>
            </table><br>
            <span class="endform">
                <input type="submit" value="SUBMIT" class="button" id="submit">
            </span>
        </form>
    </div>
</div>
<script>
    createMultiSelector(cities, 'cities', 1);
    var arbitraryValuesSlider = document.getElementById('slider');

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
        start: ['₩30M', '₩50M'],
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

    const form = document.querySelector("form");
    form.addEventListener('submit', function(e) {
        const salaries = slider.noUiSlider.get();
        console.log(salaries);
        salaryMin.value = salaries[0];
        salaryMax.value = salaries[1];
        // e.preventDefault();
    })
</script>

<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
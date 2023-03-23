<?php
$title = "company dashboard";
ob_start();
?>

<!-- main -->

<div class="main">
    <h3>Add a Job</h3>
    <br>
    <form action="#" method="POST">
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
                    <textarea id="jobstory" name="jobstory" rows="6" cols="33" placeholder="Enter a job description"></textarea>
                    <span class="required" id="demo2"></span>
                </td>
            </tr>
            <tr>
                <th>City</th>
                <td>
                    <input type="text" name="city" id="city" placeholder="City" />
                    <span class="required" id="demo4"></span>
                </td>
            </tr>
            <tr>
                <th>Salary</th>
                <td>
                    <input type="text" name="salary" id="salary" placeholder="Salary" />
                    <span class="required" id="demo5"></span>
                </td>
            </tr>
            <tr>
                <th>Job deadline</th>
                <td>
                    <input type="text" name="deadline" id="deadline" placeholder="Date of job deadline" />
                    <span class="required" id="demo6"></span>
                </td>
            </tr>
        </table><br>
        <span class="endform">
            <input type="submit" value="SUBMIT" class="button" id="submit">
        </span>
    </form>
</div>

<?php
$content = ob_get_clean();
require('./view/companyDashboardTemplate.php');
?>
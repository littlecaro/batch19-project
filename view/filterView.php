<?php
$title = "Talent Search";
ob_start();
?>
<div class="talentMain">
    <div class="talentHeader">
        <button id="editSearch">Edit Search</button>
        <button id="cancelSearch">Reset Search</button>
        <div class="searchTags">

        </div>
    </div>
    <div class="talentSide">

    </div>
    <div class="editSearch hidden">
        <div class="editSearchMain">
            <h1>Filter Candidates</h1>
            <div class="SearchFormInputsWrapper">
                <div class="editSearchLeft">
                    <p>Seniority:</p>
                    <p>Desired positions:</p>
                    <p>Languages:</p>
                    <p>Locations:</p>
                    <p>Skills:</p>
                </div>
                <form action="">
                    <?php
                    include "./view/components/slider.php";
                    ?>
                    <div id="simple-tag" class="simple-tags" data-simple-tags="developer">
                    </div>
                    <div id="simple-tag" class="simple-tags" data-simple-tags="any">
                    </div>
                    <div id="simple-tag" class="simple-tags" data-simple-tags="anywhere">
                    </div>
                    <div id="simple-tag" class="simple-tags" data-simple-tags="any">
                    </div>
                    <label class="toggle">
                        <input class="toggle-checkbox" type="checkbox" checked>
                        <div class="toggle-switch"></div>
                        <span class="toggle-label">I want to save this search</span>
                    </label>
                </form>
            </div>
            <div class="saveSearchWrapper">
                <button class="saveSearch" id="saveBtn">Save</button>
                <button class="saveSearch" id="cancelBtn">Cancel</button>
            </div>
        </div>
    </div>
    <div class="talentCenter">
        <div class="talentSearchMain">
            <?= $talentCards; ?>
        </div>
    </div>
</div>
<script src="./public/javascript/scriptTags.js"></script>
<script src="./public/javascript/talentSearch.js"></script>

<link href="./public/css/styleTags.css" rel="stylesheet">
<?php
$content = ob_get_clean();
require('./view/template.php');
?>
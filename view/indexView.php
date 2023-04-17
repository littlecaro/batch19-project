<?php
$title = "Waygukwin";
ob_start();

?>
<!-- <div id="all-of-main"> -->
<div class="main-index-div">
    <div class="main_box">
        <div class="main_left"></div>
        <div class="main_right">
            <!-- <img src="./images/Other-07.png" width="100%" /> -->
            <br />
            <h1>Find the job you want from the company you trust</h1>
            <h4>
                The perfect job you're looking for is just around the corner with
                our powerful AI algorithms to guide you through the search process.
            </h4>
            <a class="button" href="http://localhost/sites/batch19-project/index.php?action=userSignUpView"><button>SIGN UP</button></a>
        </div>
    </div>
</div>
<div class="feature-companies">
    <h3>get hired by the top companies in tech</h3>
    <div class="logos">
        <img src="./public/images/logos/facebook.png" />
        <img src="./public/images/logos/netflix.png" />
        <img src="./public/images/logos/coupang.png" />
        <img src="./public/images/logos/kb.png" />
        <img src="./public/images/logos/naver.png" />
        <img src="./public/images/logos/twitter.png" />
        <img src="./public/images/logos/microsoft.png" />
        <img src="./public/images/logos/google.png" />
        <img src="./public/images/logos/Telus-Logo.png" />
    </div>
</div>


<div class="feature-new-job">
    <div class="job_table">
        <h1>
            <span style="color: white">Need Help Attracting</span><br />
            <span style="color: #13c2c5">Top Global Talent?</span>
        </h1>
        <h1>
            <span style="font-size: 20px; color: white">Waygukwin can help you</span>
        </h1>
        <table>
            <tr>
                <td>
                    <img src="./public/images/contract.png" width="100" /><br /><br />
                    <strong>Write a Job Post</strong><br />
                    That catches talent attention
                </td>
                <td>
                    <img src="./public/images/chat.png" width="100" /><br /><br />
                    <strong>Interview Candidates</strong><br />
                    To find you the perfect match
                </td>
                <td>
                    <img src="./public/images/shuttle.png" width="100" /><br /><br />
                    <strong>Onboard Talent</strong><br />
                    To ensure the best job start
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="feature-testimonials">
    <h3>Testimonials</h3>
    <div class="testimonials">
        <figure class="snip1139">
            <blockquote>
                This is the best place to find raw talent if you're a young
                entrepreneur who's willing to go to the next level.
                <div class="arrow"></div>
            </blockquote>
            <img src="./public/images/users/first.jpg" alt="sample1" />
            <div class="author">
                <h5>Tom Green <span>- CEO of Doordash</span></h5>
            </div>
        </figure>
        <figure class="snip1139 hover">
            <blockquote>
                Within a few hours I had the top players in the tech industry asking
                me for an interview. Waygukwin is awesome!
                <div class="arrow"></div>
            </blockquote>
            <img src="./public/images/users/second.jpg" alt="sample2" />
            <div class="author">
                <h5>Anna Karina<span>- Data Analyst</span></h5>
            </div>
        </figure>
        <figure class="snip1139">
            <blockquote>
                Move over, LinkedIn. Waygukwin is where the cool cats are at. Job
                hunting has never been easier.
                <div class="arrow"></div>
            </blockquote>
            <img src="./public/images/users/third.jpg" alt="sample3" />
            <div class="author">
                <h5>John Cho<span>- Programmer</span></h5>
            </div>
        </figure>
    </div>
</div>
<div class="middle">
    <div class="middle_box">
        <div class="middle_left">
            <img src="./public/images/Other 03.png" width="100%" />
        </div>
        <div class="middle_right">
            <br />
            <h2>No more spam or wasted time on pointless emails</h2>
            <h4>
                "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet,
                consectetur, adipisci velit..."
            </h4>
            <a class="button" href="http://localhost/sites/batch19-project/index.php?action=userSignUpView"><button>TRY IT FOR FREE</button></a>
        </div>
    </div>
</div>
</div>

<?php
$content = ob_get_clean();
require('./view/template.php');
?>
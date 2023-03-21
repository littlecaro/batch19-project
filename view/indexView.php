<?php
$title = "TODO:change";
ob_start();

// include "./view/chatView.php"; // TODO: move this to logged in view
?>

    <div class="header">
        <div class="logo">
            <p>waygukwin</p>
        </div>
        <div class="menu">
            <button id="signup" onclick="location.href='view/start.html'">
                SIGN UP
            </button>
            <button onclick="location.href='view/signin.html'">SIGN IN</button>
        </div>
    </div>
    <div class="main">
        <div class="main_box">
            <div class="main_left"></div>
            <div class="main_right">
                <!-- <img src="./images/Other-07.png" width="100%" /> -->
                <br />
                <h1>Find the job you want from the company you trust</h1>
                <h4>
                    The perfect job you're looking for is just around the corner with
                    our powerful AI algorithms to guide you through the search process
                </h4>
                <button>LEARN MORE</button>
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
            <img src="./public/images/logos/twitter.jpg" />
            <img src="./public/images/logos/facebook.png" />
            <img src="./public/images/logos/netflix.png" />
            <img src="./public/images/logos/Telus-Logo.png" />
        </div>
    </div>
    <div class="feature-new-job">
        <h3>new job openings</h3>
        <div class="job_table">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <img src="./public/images/logo_3186236735.png_crop_23-03-13" width="50" />
                        </td>
                        <td class="job_name">
                            <strong>Intern, Digital Solutions</strong><br />Visa Korea |
                            Seoul
                        </td>
                        <td><button class="job_type">Internship</button></td>
                        <td class="expiry_date">Expires: 31 Mar 2023</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="./public/images/kcggi_f908abbc5a.PNG_crop_23-03-08" width="50" />
                        </td>
                        <td class="job_name">
                            <strong>German Project Intern for Energy Projects in Trade Services
                                Division</strong><br />
                            Korean-German Chamber of Commerce and Industry
                        </td>
                        <td><button class="job_type">Internship</button></td>
                        <td class="expiry_date">Expires: 17 Mar 2023</td>
                    </tr>
                    <tr>
                        <td>
                            <img src="./public/images/logo_3186236735.png_crop_23-03-13" width="50" />
                        </td>
                        <td class="job_name">
                            <strong>Intern, Digital Solutions</strong><br />Visa Korea |
                            Seoul
                        </td>
                        <td><button class="job_type">Internship</button></td>
                        <td class="expiry_date">Expires: 31 Mar 2023</td>
                    </tr>

                    <td class="last_line" colspan="4">
                        <br /><button>FIND&nbsp;MORE&nbsp;JOBS</button>
                    </td>
                </tbody>
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
                    me for an interview. Waygookin is awesome!
                    <div class="arrow"></div>
                </blockquote>
                <img src="./public/images/users/second.jpg" alt="sample2" />
                <div class="author">
                    <h5>Anna Karina<span>- Data Analyst</span></h5>
                </div>
            </figure>
            <figure class="snip1139">
                <blockquote>
                    Move over, LinkedIn. Waygookin is where the cool cats are at. Job
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
                <button>TRY FOR FREE</button>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="links">
            <div class="one">
                <h4>Waygookin</h4>
                <p>
                    1101-ho | IS Biz Tower 2, Room 1101, 23, Seonyu-ro 49-gil,
                    Yeongdeungpo-gu, Seoul, South Korea
                </p>
                <p>02-501-6064</p>
                <p>waygookin@wcoding.com</p>
            </div>
            <div class="two">
                <h4>Connect with us</h4>
                <ul>
                    <li>Part-time jobs</li>
                    <li>Full-time jobs</li>
                </ul>
            </div>
            <div class="three">
                <h4>About Us</h4>
                <ul>
                    <li>Our story</li>
                    <li>Contact us</li>
                </ul>
            </div>

            <div class="four">
                <p>Sign up to our newsletter</p>
                <input placeholder="your email" /><button>GO</button>
            </div>
        </div>
        <p>Terms of service | Legal notice | Privacy policy</p>
    </div>



    <?php
    include("./view/components/googleSignIn.php");
    $content = ob_get_clean();
    require('./view/template.php');
    ?>
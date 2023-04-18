<?php
$title = "Sign Up";
ob_start();
?>

<div class="header">
  <div class="logo">
    <p><a href="index.php">waygukwin</a></p>
  </div>
  <div class="menu">
    <a href="index.php?action=userSignInView"><button class="topbutton">SIGN IN</button></a>
  </div>
</div>
<h3>Let's get started</h3>
<div class="template">
  <div class="box">
    <img src="./public/images/Saly-25.png" width="300px" />
    <h4>I am a</h4>
    <button id="boxbiz" onclick="showSignUp('company')">
      BUSINESS<br>LOOKING TO HIRE
    </button>
    <button id="boxuser" onclick="showSignUp('user')">
      USER<br>LOOKING FOR WORK
    </button>
    <br><br>
    <p><?= isset($_GET['error']) ? $_GET['error'] : "" ?></p>
    <h4>Don't want to create an account?<br>Register with Google</h4>
    <?php include("./view/components/googleSignIn.php"); ?>
    <br><br>
    <div id="createAccount">

      <h3>CREATE AN ACCOUNT</h3>
      <!-- why doesn't user sign up work? -->
      <form action="index.php?action=companySignUp" method="POST">
        <table id="table">
          <tr>
            <th>First name</th>
            <td>
              <input type="text" name="fName" id="fName" placeholder="First name">
              <span></span>
            </td>
          </tr>
          <tr>
            <th>Last name</th>
            <td>
              <input type="text" name="lName" id="lName" placeholder="Last name">
              <span></span>
            </td>
          </tr>
          <tr>
            <th>E-mail</th>
            <td>
              <input type="text" name="email" id="email" placeholder="E-mail" />
              <span></span>
            </td>
          </tr>
          <tr>
            <th>Password</th>
            <td>
              <input type="text" name="pwd" id="pwd" placeholder="Password" />
              <span></span>
            </td>
          </tr>
          <tr>
            <th>Password confirmation</th>
            <td>
              <input type="text" name="pwdconf" id="pwdconf" placeholder="Type your password again" />
              <span></span>
            </td>
          </tr>
          <tr class="company-input">
            <th>Company Name</th>
            <td>
              <input type="text" name="companyname" id="companyname" class="companyonly" placeholder="Company Name" />
              <span></span>
            </td>
          </tr>
          <tr class="company-input">
            <th>Company Job Title</th>
            <td>
              <input type="text" name="companytitle" id="companytitle" class="companyonly" placeholder="Your role in the company." />
              <span></span>
            </td>
          </tr>
          <tr>
            <th> </th>
            <td id="newsletter">
              <label><input type="checkbox" id="checkbox" />
                I want to receive the newsletter!</label>
            </td>
          </tr>
          <tr>
            <th> </th>
            <td id="policy">
              <label><input type="checkbox" id="checkbox" />
                I Agree to the Privacy Policy.</label>
            </td>
          </tr>
        </table><br>
        <button type="submit" value="SUBMIT" class="button" id="sign-up-submit">SUBMIT</button>
      </form>
    </div>
  </div>
</div>
</div>
<div class="footer">
  <div class="links">
    <div class="one">
      <h4>Waygukwin</h4>
      <p>
        <img src="./public/images/footer/placeholder.png" width="15px" />
        1101-ho | IS Biz Tower 2, Room 1101, 23, Seonyu-ro 49-gil,
        Yeongdeungpo-gu, Seoul, South Korea<br />
      </p>
      <p>
        <img src="./public/images/footer/telephone.png" width="15px" />
        02-501-6064
      </p>
      <p>
        <img src="./public/images/footer/contract.png" width="15px" />
        <a href="mailto:waygukwin@wcoding.com">waygukwin@wcoding.com</a>
      </p>
    </div>
    <div class="two">
      <h4>About Us</h4>
      <p>
        Waygukwin is a job networking platform for businesses and
        individuals located in Korea.
      </p>
      <br><br>
      <p>
        <a href="#">Terms of service</a> | <a href="#">Legal notice</a> |
        <a href="#">Privacy policy</a>
      </p>
    </div>
    <div class="three">
      <h4>Follow Us</h4>
      <a href="#"><img src="./public/images/footer/facebook.png" width="35" /></a>&nbsp;&nbsp;
      <a href="#"><img src="./public/images/footer/instagram.png" width="35" /></a>&nbsp;&nbsp;
      <a href="#"><img src="./public/images/footer/linkedin.png" width="35" /></a>&nbsp;&nbsp;
      <a href="#"><img src="./public/images/footer/twitter.png" width="35" /></a>
      <h4>Sign up to our newsletter</h4>
      <input placeholder="your email" />&nbsp;&nbsp;<button class="button">GO</button>
    </div>
  </div>
</div>


<?php
$content = ob_get_clean();
require('./view/signUpTemplate.php');
?>
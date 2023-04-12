<?php
$title = "Sign In";
ob_start();
?>

<div class="header">
  <div class="logo">
    <p><a href="index.php">waygukwin</a></p>
  </div>
  <div class="menu">
    <a href="index.php?action=userSignUpView"><button class="topbutton">SIGN UP</button></a>
  </div>
</div>

<h3>Sign In</h3>
<div class="template">
  <div class="box">
    <p><?= isset($_GET['error']) ? $_GET['error'] : "" ?></p>
    <form action="index.php?action=userSignIn" method="POST">
      <input type="text" name="email" placeholder="Email" /><br><br>
      <input type="text" name="pwd" placeholder="Password" /><br />
      <p>

      </p><br />
      <input id="submit" type="submit" value="SIGN IN" class="button">
      <br /><br />
      <?php include("./view/components/googleSignIn.php"); ?>

    </form>
    <h4>Don't have an account?</h4>
    <button class="button">
      <span class="buttonlink">
        <a href="index.php?action=userSignUpView">Sign up here</span></a>
    </button>
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
require('./view/signInTemplate.php');
?>
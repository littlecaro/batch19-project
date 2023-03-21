<?php
$title = "Sign In";
ob_start();
?>
<div class="main">
  <p><?= isset($_GET['error']) ? $_GET['error'] : "" ?></p>
  <form action="index.php?action=userSignIn" method="POST">
    <input type="text" name="email" placeholder="Email" /><br />
    <input type="text" name="pwd" placeholder="Password" /><br /><br />
    <input id="submit" type="submit" value="Sign in" />
    <!-- TODO: google -->
  </form>
  <h2>Don't have an account?</h2>
  <button>
    <a href="./view/signUpView.php">Sign up here</a>
  </button>
</div>

<?php
$content = ob_get_clean();
require('./view/signUpSignInTemplate.php');
?>
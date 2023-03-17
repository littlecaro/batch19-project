<?php
    $title = "Sign Up";
    ob_start();
?>
<div class="main">
      <p><?=isset($_GET['error']) ? $_GET['error'] : ""?></p>
      <form action="index.php?action=userSignUp" method="POST">
        <input type="text" name="firstName" id="firstName" placeholder="First Name">
        <input type="text" name="lastName" id="lastName" placeholder="Last Name">
        <input type="text" name="email" id="email" placeholder="Email"/><br />
        <input type="text" name="pwd" id="pwd" placeholder="Password"/><br /><br />
        <input type="text" name="pwdconf" id="pwdconf" placeholder="Type your password again"/><br />
        <input id="submit" type="submit" value="Sign up" />

        <!-- TODO: google -->
      </form>
      <h2>Already have an account?</h2>
      <button>
        <a href="TODO:">Sign in here</a>
      </button>
    </div>

<?php 
    $content = ob_get_clean();
    require('./view/signUpSignInTemplate.php');
?>
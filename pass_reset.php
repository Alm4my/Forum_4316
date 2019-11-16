<?php
$msg_title = "Password Reset";
$msg_sub = "Please fill the form with your email, so we can help you reset your password.";
include 'connect.php';
include 'header.php';
include 'app.php';
?>

<form class="log-in-form" action="login.php" method="post">
    <?php include ('errors.php') ?>
    <h5 class="text-center">Process to reset password </h5>
    <ol>
        <li> Enter your email address below </li>
        <li> Go to your mail box and click on the received link </li>
        <li> Enter your new password </li>
    </ol>
    <label>Email
        <input type="email" placeholder="guillermo@iugb.edu.ci" name="email">
    </label>

    <p><input type="submit" class="button expanded" value="Reset Password" name="pass_reset"></p>
</form>

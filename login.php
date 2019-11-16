<?php
session_start();
$msg_title = "Log In";
$msg_sub = "Please fill in your username and password in order to be able to post in the forum";
include 'connect.php';
include 'header.php';
include 'app.php';

?>

<form class="log-in-form" action="login.php" method="post">
    <?php include ('errors.php') ?>
    <h4 class="text-center">Username & Password </h4>
    <label>Username
        <input type="text" placeholder="Guillermo" name="username">
    </label>
    <label>Password
        <input type="password" placeholder="Password" name="password">
    </label>
    <p><input type="submit" class="button expanded" value="Log in" name="login_user"></p>
    <p class="text-center"><a href="pass_reset.php">Forgot your password?</a></p>
</form>
<br>

<?php include ('footer.php'); ?>
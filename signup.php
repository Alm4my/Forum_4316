<?php
session_start();
$msg_title = "Sign Up";
$msg_sub = "Please fill in the requested information so you can be part of our awesome community ✩◝(◍⌣̎◍)◜✩ <br>
            Don't Forget, sharing is caring! ( ͡° ͜ʖ ͡°)";
include 'connect.php';
include 'header.php';
include 'app.php';

?>
<!-- HTML SIGN UP FORM -->
    <form class="log-in-form" method="post" action="signup.php" enctype="multipart/form-data">
        <?php include('errors.php'); ?>

        <h3 class="text-center">Fill this out!</h3>
        <label>Username
            <input type="text" placeholder="Guillermo" name="username" value="<?php echo $username; ?>">
        </label>
        <label>Email
            <input type="email" placeholder="somebody@example.com" name="email" value="<?php echo $email; ?>">
        </label>
        <label>Password
            <input type="password" placeholder="Password" name="password_1">
        </label>
        <label> Retype Password
            <input type="password" placeholder="Password" name="password_2">
        </label>
        <label> Profile picture (default: mario)
            <input type="file" name="image" >
        </label>
        <label> Level
            <input type="text" placeholder="0 - Newbie" readonly>
        </label>
        <p>
            <input type="submit" name="reg_user" class="button expanded" value="Register">
        </p>
        <br>
    </form>

    <?php include 'footer.php' ?>;
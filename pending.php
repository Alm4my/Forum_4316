<?php
$msg_title = "Password Link Sent!";
$msg_sub = "We sent an email to the provided email account to help you recover your password.";
include 'connect.php';
include 'header.php';
include 'app.php';
?>

<form class="login-form" action="login.php" method="post" style="text-align: center;">
    Please login into your email account and click on the link we sent to reset your password
</form>

<?php include ('footer.php'); ?>

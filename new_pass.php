<?php
$msg_title = "New Password";
$msg_sub = "Enter your new password so you can enjoy our forum";
include 'connect.php';
include 'header.php';
include 'app.php';
?>

<form class="log-in-form" action="login.php" method="post">
    <?php include ('errors.php') ?>
    <h5 class="text-center">Enter your new safe password </h5>
    <ul style="list-style: none;"> Remember, password should have 8 characters in total and contain at least
        <li> 1 uppercase character  </li>
        <li> 1 lowercase character </li>
        <li> 1 number </li>
    </ul>
    <label>Password
        <input type="password" placeholder="Min. 8 Characters" name="new_pass">
    </label>
    <label>Password
        <input type="password" placeholder="Repeat" name="new_pass_c">
    </label>

    <p><input type="submit" class="button expanded" value="Set Password" name="set_new_pass"></p>
</form>

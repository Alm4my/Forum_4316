<?php
session_start();
$msg_title = "Profile Page";
$msg_sub = "Here, you can change some of your information";
include 'connect.php';
include 'header.php';
include 'app.php';

    if(!isset($_SESSION['signed_in'])) {
    echo '<div data-closable class="alert-box callout alert">
              <i class="fa fa-ban"></i> 
              You must be signed in to view this page. <a href="login.php"> Click Here to log in. </a>
              <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                  <span aria-hidden="true">&CircleTimes;</span>
              </button>
          </div>';
    }
    else{

?>
        <form class="log-in-form" action="" method="post">
            <?php include ('errors.php') ?>
            <label>
                <h5 class="">Change Username </h5>
                <input type="text" placeholder="New username" name="username">
            </label>
            <input type="submit" class="button " value="Change Username" name="username_chg">
        </form>
        <form class="log-in-form" action="" method="post">
            <?php //include ('errors.php') ?>
            <label>
                <h5 class="">Change Email Address </h5>
                <input type="text" placeholder="new email address" name="email">
            </label>
            <input type="submit" class="button" value="Change Email" name="email_chg">
        </form>
        <form class="log-in-form" action="" method="post">
            <?php //include ('errors.php') ?>
            <label>
                <h5 class="">Change Password </h5>
                <input type="text" placeholder="8 Characters min." name="password_1">
                <input type="text" placeholder="Repeat" name="password_2">
            </label>
            <input type="submit" class="button " value="Change Email" name="pass_chg">
        </form>

<?php }

    include 'footer.php';
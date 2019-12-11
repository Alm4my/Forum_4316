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
            <input type="submit" class="button " value="Change Password" name="pass_chg">
        </form>
        <!-- Image -->
        <form class="log-in-form" action="" method="post" enctype="multipart/form-data">
            <?php //include ('errors.php') ?>
            <label>
                <h5 class="">Change Profile Picture </h5>
                <input type="hidden" name="size" value="1000000">
                <input type="file"  name="user_image">
            </label>
            <input type="submit" class="button " value="Upload" name="chg_image">
        </form>


<?php }
        $result = mysqli_query($conn, "SELECT * FROM image WHERE image_for=".$_SESSION['user_id']);
        while ($row = mysqli_fetch_array($result)) {
            echo "<br>
                <div class='image' >
                <h4 class='text-center'> <strong>Current Picture</strong></h4>
                <img src='assets/img/profile/".$row['image']."' style='margin-left: 15%;'>
                </div>
                ";
        }
    include 'footer.php';
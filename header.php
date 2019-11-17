<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>

    <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="International University of Grand Bassam (IUGB) Student Government Association Forum">
    <meta name="author" content="Almamy Coulibaly">
    <title>SGA - Forum</title>

    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href="assets/css/raleway.css" rel="stylesheet" type="text/css">

    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet"  href="assets/css/normalize.css">
    <link rel="stylesheet"  href="assets/css/foundation.min.css">
    <link rel="stylesheet"  href="assets/css/foundation-icons/foundation-icons.css">
    <link rel="stylesheet"  href="assets/css/app.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css"


    <!-- Favicon
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <!-- <link rel="icon" type="image/png" href="images/favicon.png">  -->

</head>
<body>

<!-- Primary Page Layout
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<div class="grid-container " >
    <div class="grid-x grid-margin-x grid-padding-x " >
        <div class="cell small-4 medium-4 large-6 ">
            <h6 class="" id="title" >
                <a href="index.php">
                    <!-- Student Government Association -->
                    <img src="assets/img/SGALOGOPROJECT.svg" style="height: 6em;" alt="Logo">
                </a>
            </h6>

        </div>

        <div class="cell small-8 medium-8 large-6 padded" >
            <ul class="dropdown menu" data-dropdown-menu>
                <li>
                    <form action="search.php" id="search-form">
                        <input id="search" name="search" type="search" placeholder="Search Forum" aria-label="search">
                    </form>
                </li>
                <?php
                    if ( !isset($_SESSION['signed_in']) || $_SESSION['signed_in'] == false ){
                        echo '<li>
                              <a href="login.php" class="hollow button hcolor">Log In</a>
                              </li>
                              <li class="hcolor">
                              <a href="signup.php" class="hollow button">Sign Up</a>
                              </li>';
                    }
                    else {
                        echo ' <li>
                               <a href="signout.php" class="hollow button hcolor">Sign Out</a>
                               </li>
                               <li>
                               <i class="fas fa-users-cog fa-2x" id="torso"> </i>'/*. $_SESSION['user_name'] */.'
                               <ul class="menu vertical">
                                  <li><span style="font-weight: bold; color: #667c99">'. $_SESSION['user_name'] .'</span></li>
                                  <li><a href="profile.php">Profile</a></li>
                                  <li><a href="mailto:albcoulibaly@gmail.com">Email Us!</a></li>
                               </ul>
                               
                               </li>
                               </ul>
                               ';

                    }
                ?>
            </ul>
        </div>
    </div>
</div>
<div class="grid-container full" id="header">
    <!--    -->
    <div class="callout message" data-closable>
        <button class="close-button" aria-label="Close alert" type="button" data-close>
            <span aria-hidden="true">&times;</span>
        </button>
        <h4>
            <?php echo $msg_title ?>
        </h4>
        <p>
            <?php echo $msg_sub ?>
        </p>
    </div>
</div>

<div class="grid-container">
    <div class="grid-x grid-margin-x grid-padding-x down">
        <div class="cell large-3 medium-3 small-3" >
            <ul class="side-list">
                <li>
                    <a href="topic_creation.php" aria-label="Start a Discussion"  class="button" id="discuss-btn">
                        <span id="discuss-txt"> START A DISCUSSION </span>
                    </a>
                </li>
                <li>
                    <a href="index.php" >
                        <i class="fi-social-windows"></i>
                        <span id="all-discuss"> All Discussions</span>
                    </a>
                </li>

            </ul>
            <ul class="vertical menu ">
                <li style=" margin-left: 30%; font-weight: bold;"> Categories </li>
                <?php include('category_mp.php'); ?>


            </ul>
        </div>
        <div class="cell large-8 medium-8 small-8 main">
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

    <!-- Favicon
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <!-- <link rel="icon" type="image/png" href="images/favicon.png">  -->

</head>
<body>

<!-- Primary Page Layout
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<div class="grid-container " >
    <?php
    //add full to adjust it
    // TODO Use Y grid to put footer always down

    ?>
    <div class="grid-x grid-margin-x grid-padding-x " >
        <div class="cell small-4 medium-4 large-6 ">
            <h6 class="" id="title" >
                <a href="index.php">
                    <!-- Student Government Association -->
                    <img src="assets/img/SGALOGOPROJECT.svg" style="height: 6em;">
                </a>
            </h6>

        </div>

        <div class="cell small-8 medium-8 large-6 padded" >
            <ul class="menu">
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
                               <i class=" fi-torso small"> </i>'/*. $_SESSION['user_name'] */.'
                               </li>';
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
                    <a href="topic_creation.php" aria-label="Start a Discussion" name="create_topic" class="button" id="discuss-btn">
                        <span id="discuss-txt"> START A DISCUSSION </span>
                    </a>
                </li>
                <li>
                    <a href="index.php" id="all-discuss">All Discussions</a>
                </li>
            </ul>
            <ul>
                <?php include('category_mp.php'); ?>
                <li>
                    <a href="cat_creation.php"> Create a Category</a>
                </li>

            </ul>
        </div>
        <div class="cell large-8 medium-8 small-8 main">
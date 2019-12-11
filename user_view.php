<?php
//  USER VIEW
//   Displays selected user page

session_start();    // Start session

// Variables for header
$msg_title = "User Page";
$msg_sub = "Information about the selected user.";

// Include statements
include 'connect.php';
include 'app.php';
include 'header.php';

// Main code
    if (!isset($_GET['id']))
        // Display error message if there is no user id
        echo 'No user selected for display. Go back to <a href="index.php"> Main Page. </a>';
    else{
        // Initial User Query
        $user_query = "SELECT user_name FROM users WHERE user_id = " . $_GET['id'];
        $user_result = mysqli_query($conn, $user_query);

        $row = mysqli_fetch_row($user_result);

        // Picture Query
        $p_query = "SELECT image FROM image WHERE image_for=". $_GET['id'];
        $p_query = mysqli_query($conn, $p_query);
        $p_result = mysqli_fetch_assoc($p_query);

        // Echo different info about user
        echo '<h2> <a href="user_view.php?id=' . $_GET['id'] . '">  ' . $row[0] . ' </a></h2>';
        echo '
            <h4> Number of Posts: ' . numberOfPosts($_GET['id']) . '  </h4>
            <h4> Number of Topics: ' . numberOfTopics($_GET['id']) . '  </h4>
            <h4> User Level: ' . userLevel($_GET['id']) . '  </h4>
            <h4> Last Post: <a href="topic_view.php?id='. lastPost($_GET['id'], 2)[1] . '"> '
            . lastPost($_GET['id'], 2)[0] . '  </a></h4>
            <h4> Last Topic: 
            <a href="topic_view.php?id='. lastPost($_GET['id'], 1)[1] . '"> '
            . lastPost($_GET['id'], 1)[0] . '  </a></h4>
            <br>
            <div id="profile_picture">
            <h4 class="text-center"> <strong>Profile Picture </strong></h4>
            <img src="assets/img/profile/'. $p_result['image'] .'" alt="profile picture" id="profileP">
            </div>
        ';
    }
    include 'footer.php';
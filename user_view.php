<?php
session_start();
include 'connect.php';
include 'app.php';
include 'header.php';

    if (!isset($_GET['id']))
        echo 'No user selected for display. Go back to <a href="index.php"> Main Page. </a>';
    else{
        // Initial User Query
        $user_query = "SELECT user_name FROM users WHERE user_id = " . $_GET['id'];
        $user_result = mysqli_query($conn, $user_query);

        $row = mysqli_fetch_row($user_result);

        echo '<h2> <a href="user_view.php?id=' . $_GET['id'] . '">  ' . $row[0] . ' </a></h2>';
        echo '
            <h4> Number of Posts: ' . numberOfPosts($_GET['id']) . '  </h4>
            <h4> Number of Topics: ' . numberOfTopics($_GET['id']) . '  </h4>
            <h4> User Level: ' . userLevel($_GET['id']) . '  </h4>
            <h4> Last Post: ' . lastPost($_GET['id'], 2) . '  </h4>
            <h4> Last Topic: ' . lastPost($_GET['id'], 1) . '  </h4>
        ';





    }
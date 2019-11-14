<?php

include 'connect.php';
include 'header.php';


    // Initial Topic Query
    $top_query = "SELECT topic_subject FROM topics WHERE topic_id = 3" ;
    $top_result = mysqli_query($conn, $top_query);

    $row = mysqli_fetch_row($top_result);

    echo '<h2> <a href="topic.pnp?id=' . $row[0] . '">  ' . $row[0] . ' </a></h2>';

    // Getting posts
    $post_query = "SELECT post_topic, post_content, post_date, post_by, 
                    users.user_id, users.user_name FROM posts LEFT JOIN users 
                    ON posts.post_by = users.user_id WHERE post_topic" ;
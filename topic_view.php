<?php
include 'reply.php';
include 'connect.php';
include 'header.php';

    if (!isset($_GET['id']))
        echo 'No topic selected for display. Go back to <a href="index.php"> Post Page. </a>';
    else{

    // Initial Topic Query
    $top_query = "SELECT topic_subject FROM topics WHERE topic_id = " . $_GET['id'];
    $top_result = mysqli_query($conn, $top_query);

    $row = mysqli_fetch_row($top_result);

    echo '<h2> <a href="topic_view.php?id=' . $_GET['id'] . '">  ' . $row[0] . ' </a></h2>';

    // Getting posts
    $post_query = "SELECT post_topic, post_content, post_date, post_by,
                    users.user_id, users.user_name FROM posts LEFT JOIN users
                    ON posts.post_by = users.user_id WHERE post_topic = " . $_GET['id'] ;

    $post_result = mysqli_query($conn, $post_query);
    while ($row = mysqli_fetch_assoc($post_result)){
        $user_name_query = "SELECT user_name FROM users WHERE user_id = ". $row['post_by'];
        $user_name_query = mysqli_query($conn, $user_name_query);
        $user_name = mysqli_fetch_row($user_name_query);
        echo '
            <h3> '. $row['post_content'] .' </h3>
            <br>
            <h3> '. $row['post_date'] .' </h3>
            <br>
            <h3> '.  $user_name[0] .' </h3>
        ';
    }
    $post_id = "SELECT MAX(post_id) FROM posts";
    $post_id = mysqli_query($conn, $post_id);
    $post_id = mysqli_fetch_row($post_id);
    $post = $post_id[0] + 1;

    echo '
    <form method="post" action="reply.php?id=' . $post . '">
        <input name="id" value="'. $_GET['id'] .'" hidden>
        <textarea rows="3" name="reply_content"></textarea>
        <input type="submit" value="Submit reply" />
    </form>
    
    <!-- TEXTAREA PLUGIN -->
    <script src="assets/ckeditor/ckeditor.js"></script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( \'reply_content\' );
    </script>
    ';
    }

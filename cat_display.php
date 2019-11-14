<!--Display Categories and their topic {Main Page}-->
<?php
session_start();
$msg_title = "Welcome to the International University of Grand-Bassam's
              Student Government Association forum.";
$msg_sub = "This is a platform where student can exchange
            about their issues and together find solutions.";
include 'connect.php';
include 'header.php';

    // Questions Div
    echo '<div class="questions">';

    // Initial Category Query
    $cat_query = "SELECT * FROM categories " ;
    $cat_result = mysqli_query($conn, $cat_query);

    // Show up database topics
    while ($row = mysqli_fetch_assoc($cat_result)){
        echo '<h2>Topics in ' . $row['cat_name'] . ' </h2>';
        $topic_query = "SELECT * FROM topics WHERE topic_cat =" .$row['cat_id'];
        $topic_result= mysqli_query($conn, $topic_query);
        while ($line = mysqli_fetch_assoc($topic_result)){
            // QUERIES
                // Username
            $user_name_query = "SELECT user_name FROM users WHERE user_id =" . $line['topic_by'];
            $user_name_req = mysqli_query($conn, $user_name_query);
            $user_name = mysqli_fetch_row($user_name_req);
                // Date
            $date_query = "SELECT topic_date FROM topics WHERE topic_id =" . $line['topic_id'];
            $date_req = mysqli_query($conn, $date_query);
            $date = mysqli_fetch_row($date_req);
//            echo '<script> alert('. $user_name .') </script>';

            echo '  
                      <div id="question'. $line['topic_id'] .'">
                          <img alt="avatar" id="avatar" src="assets/img/avatar.png">
                          <p>
                            <a href="#">
                                <a href="topic.php?id=' . $line['topic_id'] . '">' . $line['topic_subject'] . '</a>
                            </a>
                            <br>
                            <span class="user">
                                <b> <a href="user.php?id=' . $line['topic_by'] . '">
                                '. $user_name[0] .'
                                </a> </b> started '. $date[0] .' 
                            </span>
                           </p>
                       </div>

            ';
        }

    }
    echo '</div>';

include 'footer.php';


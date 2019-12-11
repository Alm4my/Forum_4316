<!--Display each category individually-->
<?php
session_start();
include 'func.php';
$msg_title = welcomeVariables($_GET['cat'])[0];
$msg_sub = welcomeVariables($_GET['cat'])[1];
include 'connect.php';
include 'header.php';

    if (!isset($_GET['cat']))
        echo 'No topic selected for display. Go back to <a href="index.php"> Main Page. </a>';
    else {
        // Questions Div
        echo '<div class="questions">';

        // Initial Category Query
        $cat_query = "SELECT * FROM categories WHERE cat_id=" . $_GET['cat'];
        $cat_result = mysqli_query($conn, $cat_query);

        // Show Topics for the category
        while ($row = mysqli_fetch_assoc($cat_result)) {
            echo '<h2> <a href="category.php?cat=' . $row['cat_id'] . '"> ' . $row['cat_name'] . '</a></h2>';
            $topic_query = "SELECT * FROM topics WHERE topic_cat =" . $row['cat_id']. " ORDER BY topic_date DESC";
            $topic_result = mysqli_query($conn, $topic_query);
            while ($line = mysqli_fetch_assoc($topic_result)) {
                // QUERIES
                // Username
                $user_name_query = "SELECT user_name FROM users WHERE user_id =" . $line['topic_by'];
                $user_name_req = mysqli_query($conn, $user_name_query);
                $user_name = mysqli_fetch_row($user_name_req);
                // Date
                $date_query = "SELECT topic_date FROM topics WHERE topic_id =" . $line['topic_id'];
                $date_req = mysqli_query($conn, $date_query);
                $date = mysqli_fetch_row($date_req);
                $date[0] = strtotime($date[0]);
                $s_date = date("h:i a", $date[0]);
                $d_date = date("Y-m-d", $date[0]);
                // Picture Query
                $p_query = "SELECT image FROM image WHERE image_for=". $line['topic_by'];
                $p_query = mysqli_query($conn, $p_query);
                $p_result = mysqli_fetch_assoc($p_query);

                echo '  
                          <div class="question">
                              <img alt="avatar" id="avatar" src="assets/img/profile/'. $p_result['image'] . '">
                              <p>
                                <a href="#">
                                    <a href="topic_view.php?id=' . $line['topic_id'] . '">' . $line['topic_subject'] . '</a>
                                </a>
                                <br>
                                <span class="user">
                                     Started on ' . $d_date . ' at ' . $s_date . ' by
                                     <b> <a href="user_view.php?id=' . $line['topic_by'] . '">
                                    ' . $user_name[0] . '
                                    </a> </b>
                                </span>
                               </p>
                           </div>
    
                ';
            }
        }
        // Question Div Closing
        echo '</div>';
    }

include 'footer.php';
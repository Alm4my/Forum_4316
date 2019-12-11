<?php
session_start();
$msg_title = "Search Result";
$msg_sub = "Below is the list of topic with the searched keyword";
include 'connect.php';
include 'header.php';

    // Gets value from search form
    $query = $_GET['search'];


    // Set minimum length of query
    $min_length = 3;
    if(strlen($query) >= $min_length){
        // changes characters used in html to their equivalents, for example: < to &gt;
        $query = htmlspecialchars($query);

        // Copy what was searched and by whom in the search table
        if (isset($_SESSION['user_id'])) {
            $user = $_SESSION['user_id'];
            $s_query = "INSERT INTO search(value, search_by, date) VALUES ('$query', $user, NOW())";
            $s_result = mysqli_query($conn, $s_query);
        }

        // makes sure nobody uses SQL injection *****
        $query = mysqli_real_escape_string($conn, $query);
        $query = "SELECT * FROM topics
                WHERE (`topic_subject` LIKE '%".$query."%')";

        $raw_result = mysqli_query($conn, $query);

        if(mysqli_num_rows($raw_result) > 0){
            while($results = mysqli_fetch_array($raw_result)){
                // Puts data from database into array, while it's valid it does the loop

                $date = strtotime($results['topic_date']);
                $s_date = date("h:i a", $date);
                $d_date = date("m-d-Y", $date);

                // QUERY USER WHO POSTED
                $post = "SELECT user_name FROM users WHERE user_id=" .$results['topic_by'];
                $post = mysqli_query($conn, $post);
                $post = mysqli_fetch_row($post);

                // Picture Query
                $p_query = "SELECT image FROM image WHERE image_for=". $results['topic_by'];
                $p_query = mysqli_query($conn, $p_query);
                $p_result = mysqli_fetch_row($p_query);

                echo "<div class='question'>
                        <p>
                        <h4><a href='topic_view.php?id=". $results['topic_id'] . "' >
                        ".$results['topic_subject']."
                        </a></h4>
                     Posted on ". $d_date ." at ". $s_date . " 
                     by 
                     <img src='assets/img/profile/" . $p_result[0] . "' alt='picture' id='avatar'>
                     <a href='user_view.php?id=".$results['topic_by']."'>". $post[0] ."</a>
                     </p>
                     </div>
                ";
                // Posts results gotten from database
            }
        }
        else{ // If there is no matching rows do following
            echo '<div data-closable class="alert-box callout alert">
                      <i class="fa fa-ban"></i> 
                      No results found! Please try with some other keyword.
                      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                          <span aria-hidden="true">&CircleTimes;</span>
                      </button>
                  </div>';
        }
    }
    else{
        // if query length is less than minimum
        echo '<div data-closable class="alert-box callout alert">
                      <i class="fa fa-ban"></i> 
                      Minimum length of search is '.$min_length.' characters
                      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                          <span aria-hidden="true">&CircleTimes;</span>
                      </button>
                  </div>';
    }

    include 'footer.php';
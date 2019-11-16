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

                echo "<p><h3>".$results['topic_subject']."</p>";
                // Posts results gotten from database
            }
        }
        else{ // If there is no matching rows do following
            echo "No results";
        }
    }
    else{
        // if query length is less than minimum
        echo "Minimum length is ".$min_length;
    }

    include 'footer.php';
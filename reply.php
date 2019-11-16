<?php
session_start();
include 'connect.php';
include 'app.php';


    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        //someone is calling the file directly, which we don't want
//        echo 'This file cannot be called directly.';
    }
    else{
        if(!isset($_SESSION['signed_in'])) {
            echo 'You must be signed in to post a reply.';
        }
        else {
            $query = "INSERT INTO posts (post_content, post_date, post_topic, post_by) 
                        VALUES (' ". $_POST['reply_content']." ', 
                                NOW(), ". $_POST['id'] . "," .
                                $_SESSION['user_id'] . ")" ;
            $query_result = mysqli_query($conn, $query);

            if(!$query_result) {
                echo 'Your reply has not been saved, please try again later.';
            }
            else {
//                echo 'Your reply has been added, check out <a href="topic_view.php?id=' . $_POST['id'] . '">the topic</a>.';
                header("Location: topic_view.php?id=". $_POST['id'] ." ");
            }
        }
    }
<?php
// REPLY
//  Sends reply to topic page
session_start();
include 'connect.php';
include 'app.php';

    if(isset($_POST['submit_reply'])) {
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
            echo '<script> console.log("GET used instead of POST") </script>';
        else {
            if (!isset($_SESSION['signed_in'])) {
                echo '
                <div data-closable class="alert-box callout alert">
                  <i class="fa fa-ban"></i> 
                  You must be signed in to post a reply.
                  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                      <span aria-hidden="true">&CircleTimes;</span>
                  </button>
                </div>
                ';
            }
            else {
                $post_content = mysqli_real_escape_string($conn, $_POST['reply_content']);
                if (empty($post_content)) {
                    array_push($errors, "Message is empty. You have to write something...");
                }
                else {
                    $query = "INSERT INTO posts (post_content, post_date, post_topic, post_by) 
                            VALUES (' " . $_POST['reply_content'] . " ', 
                                    NOW(), " . $_POST['id'] . "," .
                        $_SESSION['user_id'] . ")";
                    $query_result = mysqli_query($conn, $query);

                    // Update of the post number
                    $increase = "UPDATE users SET user_posts = (user_posts + 1) WHERE user_id=" . $_SESSION['user_id'];
                    $increase = mysqli_query($conn, $increase);

                    if (!$query_result) {
                        echo '
                    <div data-closable class="alert-box callout alert">
                      <i class="fa fa-ban"></i> 
                      Your reply has not been saved, please try again later.
                      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                          <span aria-hidden="true">&CircleTimes;</span>
                      </button>
                    </div>
                    ';
                    } else {
                        //                echo 'Your reply has been added, check out <a href="topic_view.php?id=' . $_POST['id'] . '">the topic</a>.';
                        header("Location: topic_view.php?id=" . $_POST['id'] . " ");
                    }
                }
            }
        }
    }
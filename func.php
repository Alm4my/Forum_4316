<?php
//$conn = new mysqli('mysql', 'sgafor', 'PassSGA1', 'sgafor');

// FUNCTIONS
function validateUsername($name) {
    return ctype_alnum($name) && strlen($name) >= 3;
}
function validatePassword($str) {
    return ctype_alnum($str)
        && strlen($str) >= 8
        && preg_match('/[A-Z]/', $str)
        && preg_match('/[a-z]/', $str)
        && preg_match('/[0-9]/', $str);
}
function userLevels($cal){
    global $conn;
    global $user_id;
    if ($cal > 32){
        $query = "UPDATE users SET user_level = 1 WHERE user_id =" . $user_id;
        mysqli_query($conn, $query);
    }
    if ($cal > 256){
        $query = "UPDATE users SET user_level = 2 WHERE user_id =" . $user_id;
        mysqli_query($conn, $query);
    }
    if ($cal > 512){
        $query = "UPDATE users SET user_level = 3 WHERE user_id =" . $user_id;
        mysqli_query($conn, $query);
    }
    if ($cal > 1024){
        $query = "UPDATE users SET user_level = 4 WHERE user_id =" . $user_id;
        mysqli_query($conn, $query);
    }
}
function userLevelsQuery(){
    global $user_id, $conn;

    $query = "SELECT user_posts FROM users WHERE user_id=" .$user_id;
    $query = mysqli_query($conn, $query);
    $query = mysqli_fetch_row($query);
    $post_value = $query[0];
    $query = "SELECT user_topics FROM users WHERE user_id=" .$user_id;
    $query = mysqli_query($conn, $query);
    $query = mysqli_fetch_row($query);
    $topic_value = $query[0];
    $total_value = $topic_value + $post_value;
    userLevels($total_value);
}
function userLevel($user_id){
    global $conn;

    $query = "SELECT user_level FROM users WHERE user_id=" .$user_id;
    $query = mysqli_query($conn, $query);
    $query = mysqli_fetch_row($query);
    if ($query[0] == 0)
        return "0 - Newbie";
    elseif ($query[0] == 1)
        return "1 - Rookie";
    elseif ($query[0] == 2)
        return "2 - Skilled";
    elseif ($query[0] == 3)
        return "3 - Advanced";
    elseif ($query[0] == 4)
        return "4 - Senior";
    elseif ($query[0] == 5)
        return "5 - Expert";
    elseif ($query[0] == 6)
        return "6 - Moderator";
    else
        return "X - Admin";
}
function numberOfPosts($user_id){
    global $conn;
    $query = "SELECT user_posts FROM users WHERE user_id=". $user_id;
    $query = mysqli_query($conn, $query);
    $query = mysqli_fetch_row($query);
    return $query[0];
}
function numberOfTopics($user_id){
    global $conn;
    $query = "SELECT user_topics FROM users WHERE user_id=". $user_id;
    $query = mysqli_query($conn, $query);
    $query = mysqli_fetch_row($query);
    return $query[0];
}
function lastPost($user_id, $topicOrContent){
    global $conn;
    if ($topicOrContent == 1){
        $query = "SELECT topic_subject, topic_id FROM topics WHERE topic_by=". $user_id ." ORDER BY topic_date DESC";
        $query = mysqli_query($conn, $query);
        $query = mysqli_fetch_row($query);
        return array($query[0], $query[1]);
    }
    else{
        $query = "SELECT post_content, post_topic FROM posts WHERE post_by=". $user_id ." ORDER BY post_date DESC";
        $query = mysqli_query($conn, $query);
        $query = mysqli_fetch_row($query);
        return array($query[0], $query[1]);
    }
}
function userEmail($user_id){
    global $conn;
    $query = "SELECT user_email FROM users WHERE user_id=". $user_id;
    $query = mysqli_query($conn, $query);
    $query = mysqli_fetch_row($query);
    return $query[0];
}
function welcomeVariables($id){
    if ($id == 1){
         return array("Mathematics","This Forum is dedicated to all questions from Mathematics majors.");
    }
    elseif ($id == 2){
        return array("Computer Science","This Forum is dedicated to all questions from Computer Science and Computer Information Science majors.");
    }
    elseif ($id == 3){
        return array("Mechanical Engineering","This Forum is dedicated to all questions from Mechanical Engineering majors.");
    }
    elseif ($id == 4){
        return array("Marketing & Management","This Forum is dedicated to all questions from Marketing & Management majors.");
    }
    elseif ($id == 5){
        return array("Economics","This Forum is dedicated to all questions from Economics majors.");
    }
    elseif ($id == 6){
        return array("Finance","This Forum is dedicated to all questions from Finance majors.");
    }
    else {
        return array("Political Science","This Forum is dedicated to all questions from Political Science majors.");
    }

}

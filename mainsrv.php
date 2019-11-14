<?php
// initializing variables
    $username = "";
    $email    = "";
    $errors = array();

include 'connect.php';

// REGISTER USER
    if (isset($_POST['reg_user'])) {
        // receive all input values from the form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
        $d=strtotime("now");
        $user_date = date("Y-m-d h:i:sa", $d);
        $user_level = 0;

        // form validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error unto $errors array
        if (empty($username)) { array_push($errors, "Username is required"); }
        if(strlen($username > 30))  { array_push($errors, "The username cannot be longer than 30 characters."); }
        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($password_1)) { array_push($errors, "Password is required"); }
        if ($password_1 != $password_2) {
            array_push($errors, "The two passwords do not match. Try again!");
        }

        // first check the database to make sure
        // a user does not already exist with the same username and/or email
        $user_check_query = "SELECT * FROM users WHERE user_name='$username' OR user_email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) { // if user exists
            if ($user['user_name'] === $username) {
                array_push($errors, "Username already exists. Try again!");
            }

            if ($user['user_email'] === $email) {
                array_push($errors, "email already exists. Have you forgotten your password?");
            }
        }

        // Finally, register user if there are no errors in the form
        if (count($errors) == 0) {
            $password = sha1($password_1); //encrypt the password before saving in the database

            $query = "INSERT INTO users(user_name, user_pass, user_email, user_date, user_level) 
                      VALUES('$username', '$password','$email', NOW(), 0)";
            $final_result = mysqli_query($conn, $query);
            if (!$final_result){
                echo "Something went wrong. Please try again later. <br>";
                die ('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
            }
            else{
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";
                echo '<script>alert("You have registered successfully!")</script>';
            }
        }
    }

// LOG IN USER
    if (isset($_POST['login_user'])) {
        //first, check if the user is already signed in. If that is the case, there is no need to display this page
        if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
            echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
        }
        else{
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            if (empty($username)) {
                array_push($errors, "Username is required");
            }
            if (empty($password)) {
                array_push($errors, "Password is required");
            }
            if (count($errors) == 0) {
                $password = sha1($password);
                $query = "SELECT * FROM users WHERE user_name='$username' AND user_pass='$password'";
                $results = mysqli_query($conn, $query);
                if (mysqli_num_rows($results) == 1) {
                    $_SESSION['username'] = $username;
                    $_SESSION['success'] = "You are now logged in";
                    //set the $_SESSION['signed_in'] variable to TRUE
                    $_SESSION['signed_in'] = true;

                    //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
                    while($row = mysqli_fetch_assoc($results)) {
                        $_SESSION['user_id']    = $row['user_id'];
                        $_SESSION['user_name']  = $row['user_name'];
                        $_SESSION['user_level'] = $row['user_level'];
                    }

                    echo 'Welcome, ' . $_SESSION['user_name'] . '. <a href="index.php">Proceed to the forum overview</a>.';
                    echo '<script> window.location.href = \'index.php\' </script>'; //TODO make this a visual alert
                }
                else {
                    array_push($errors, "Wrong username/password combination");
                }
            }
        }
    }


// ADD CATEGORY
    if (isset($_POST['cat_creation'])) {
        if(!isset($_SESSION['signed_in']) || $_SESSION['signed_in'] == false) {
            //the user is not signed in
            echo 'Sorry, you have to be <a href="login.php">logged in</a> to create a category.';
            die; // Remove the content from page
        }
        else{
            $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);
            $cat_desc = mysqli_real_escape_string($conn, $_POST['cat_description']);
            if (empty($cat_name)) { array_push($errors, "Category name is required"); }
            if (empty($cat_desc)) { array_push($errors, "Minimum Description is required"); }

            // Check if category exists already
            $cat_check_query = "SELECT * FROM categories WHERE cat_name='$cat_name' OR cat_description='$cat_desc' LIMIT 1";
            $result = mysqli_query($conn, $cat_check_query);
            $cat = mysqli_fetch_assoc($result);

            if ($cat) { // if Category exists
                if ($cat['cat_name'] === $cat_name) {
                    array_push($errors, "Category already exists. Try changing the name.");
                }
                if ($cat['cat_description'] === $cat_desc) {
                    array_push($errors, "Description corresponds to another one. Can you change it?");
                }
            }
            if (count($errors) == 0) {
                $query = "INSERT INTO categories(cat_name, cat_description) 
                          VALUES('$cat_name', '$cat_desc')";
                $final_result = mysqli_query($conn, $query);
                if (!$final_result){
                    echo "Something went wrong. Please retry or send us an <a href='mailto:albcoulibaly@gmail.com'>email.</a> <br>";
                    die ('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
                }
                else{
                    echo '<script>alert("Category successfully added!")</script>';
                }
            }
        }
    }

// CREATE TOPICS
    if (isset($_POST['topic_creation'])){
        if(!isset($_SESSION['signed_in']) || $_SESSION['signed_in'] == false) {
            //the user is not signed in
            echo 'Sorry, you have to be <a href="login.php">logged in</a> to create a topic.';
            die; // Remove the content from page
        }
        else {
            $user_id = $_SESSION['user_id'];

            //start the transaction
            $query  = "BEGIN WORK;";
            $result = mysqli_query($conn, $query);
            if (!$result)
                echo 'An error occurred while creating your topic. Please try again later.'; // The query failed, quit
            $topic_sub = mysqli_real_escape_string($conn, $_POST['topic_subject']);
            $topic_cat = mysqli_real_escape_string($conn, $_POST['topic_cat']);
            $post_content = mysqli_real_escape_string($conn, $_POST['post_content']); // TODO CHECk to see if needed
            if (empty($topic_sub)) {
                array_push($errors, "Subject  is required");
            }

            $topic_check_query = "SELECT * FROM topics WHERE topic_subject='$topic_sub' LIMIT 1";
            $result = mysqli_query($conn, $topic_check_query);
            $topic = mysqli_fetch_assoc($result);

            if ($topic) { // if Topic exists
                if ($topic['topic_subject'] == $topic_sub) {
                    array_push($errors, "Topic already exists. Try changing the name.");
                    include ('errors.php'); //TODO Notification style
                }
            }
            if (count($errors) == 0) {
                $query = "INSERT INTO topics(topic_subject, topic_date, topic_cat, topic_by)
                             VALUES ('$topic_sub', NOW(), $topic_cat, $user_id)";
                $result = mysqli_query($conn, $query);
                if (!$result){
                    // Something went wrong, display the error
                    echo 'An error occurred while inserting your data. Please try again later.';
                    echo('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
                    $query = "ROLLBACK;";
                    $result = mysqli_query($conn, $query);
                }
                else{
                    //the first query worked, now start the second, posts query
                    //retrieve the id of the freshly created topic for usage in the posts query
                    $topic_id = mysqli_insert_id($conn);

                    $query = "INSERT INTO posts(post_content, post_date, post_topic, post_by)
                            VALUES ('$post_content', NOW(), $topic_id, $user_id)";
                    $result = mysqli_query($conn, $query);
                    if (!$result){
                        // Something went wrong, display the error
                        echo 'An error occurred while inserting your post. Please try again later.';
                        echo('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
                        $query = "ROLLBACK;";
                        $result = mysqli_query($conn, $query);
                    }
                    else{
                        $query = "COMMIT;";
                        $result = mysqli_query($conn, $query);
                        echo 'You have successfully created <a href="topic.php?id='. $topic_id . '">a new topic</a>';
                    }
                }
            }
        }
    }
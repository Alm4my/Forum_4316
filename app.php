<?php
include 'connect.php';
include 'func.php';

// initializing variables
    $username = "";
    $email    = "";
    $errors = array();
//    $_SESSION['signed_in'] = false;

// REGISTER USER
    if (isset($_POST['reg_user'])) {
        // receive all input values from the form
        $username = mysqli_real_escape_string($conn, trim($_POST['username']));
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
        $d=strtotime("now");
        $user_date = date("Y-m-d h:i:sa", $d);
        $user_level = 0;
        $image = $_FILES['image']['tmp_name'];
        $image_id = basename($image);

        // Image file directory
        $target = "assets/img/profile/".$image_id;

        // form validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error unto $errors array
        if (!validateUsername($username)) {array_push($errors, "The username must have at least 6 characters and contain only alphanumeric characters"); }
        if (!validatePassword($_POST['password_1'])){array_push($errors, "Your password must be at least 8 characters long and contain 1 uppercase, 1 lowercase, and 1 number. Please retry.");}
        if (empty($username)) { array_push($errors, "Username is required"); }
        if(strlen($username > 30))  { array_push($errors, "The username cannot be longer than 30 characters."); }
        if (empty($email)) { array_push($errors, "Email is required"); }
        if (empty($password_1)) { array_push($errors, "Password is required"); }
        if ($password_1 != $password_2) {
            array_push($errors, "The two passwords do not match. Try again!");
        }
        if (strlen($password_1) < 6){array_push($errors, "The password must be more than 6 characters. Please, retry");}



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
                echo '
                        <div data-closable class="alert-box callout alert">
                          <i class="fa fa-ban"></i> 
                          Something went wrong. Please try again later.
                          <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                              <span aria-hidden="true">&CircleTimes;</span>
                          </button>
                        </div>
                ';
                die ('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
            }
            else{
                $query = "SELECT user_id FROM users WHERE user_name= '$username' ";
                $query = mysqli_query($conn, $query);
                if ($query)
                $results = mysqli_fetch_assoc($query);
                if (empty($_FILES['image'])){
                    // Insert the image name and image content in image_table
                    $insert_image ="INSERT INTO image (image, image_for) VALUES ('$image_id', " .$results['user_id']. ")";
                    $image_query = mysqli_query($conn, $insert_image);
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                        $msg = "Image uploaded successfully";
                    }
                    else{
                        array_push($errors,  "Failed to upload image");
                    }
                }
                else{
                    $insert_image = "INSERT INTO image(image_for) VALUES (" .$results['user_id']. ")";
                    $image_query = mysqli_query($conn, $insert_image);
                }

                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";
                echo '<div data-closable class="alert-box callout success">
                        <i class="fa fa-check"></i> 
                        You have successfully registered!
                        You will be redirected to <a href="login.php">the login page shortly </a>
                        <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                            <span aria-hidden="true">&CircleTimes;</span>
                         </button>
                      </div>
                      <script>
                            setTimeout(function(){window.location.href = \'login.php\';}, 2500);                        
                      </script>
                      ';

            }
        }
    }

// LOG IN USER
    if (isset($_POST['login_user'])) {
        //first, check if the user is already signed in. If that is the case, there is no need to display this page
        if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
            echo '
                <div data-closable class="alert-box callout warning">
                  <i class="fa fa-exclamation-triangle"></i> 
                  You are already signed in, <a href="signout.php">Click here</a> to log out.
                  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                    <span aria-hidden="true">&CircleTimes;</span>
                  </button>
                </div>
                ';
        }
        else{
            $username = mysqli_real_escape_string($conn, trim($_POST['username']));
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
                    // Shows welcome message and redirects after 1.7 seconds
                    echo '
                        <div data-closable class="alert-box callout success">
                            <i class="fa fa-check"></i> 
                            Welcome ' . $_SESSION['user_name'] . ',
                            You logged in successfully. You will be redirected in one moment.
                            <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                                <span aria-hidden="true">&CircleTimes;</span>
                            </button>
                            </div>
                    ';
                    echo '<script>
                            setTimeout(function(){window.location.href = \'index.php\';}, 1700);                        
                        </script>';
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
            echo '
                <div data-closable class="alert-box callout alert">
                  <i class="fa fa-ban"></i> 
                  Sorry, you have to be <a href="login.php">logged in</a> to create a category.
                  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                         <span aria-hidden="true">&CircleTimes;</span>
                  </button>
                </div>
                ';
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
                    echo "
                            <div data-closable class=\"alert-box callout alert\">
                              <i class=\"fa fa-ban\"></i> 
                              Something went wrong. Please retry or send us an <a href='mailto:albcoulibaly@gmail.com'>email.</a> <br>
                              <button class=\"close-button\" aria-label=\"Dismiss alert\" type=\"button\" data-close>
                                     <span aria-hidden=\"true\">&CircleTimes;</span>
                              </button>
                            </div>
                    ";
                    die ('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
                }
                else{
                    echo '
                        <div data-closable class="alert-box callout success">
                            <i class="fa fa-check"></i> 
                            Category Successfully Added!
                            <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                                <span aria-hidden="true">&CircleTimes;</span>
                            </button>
                            </div>
                    ';
                }
            }
        }
    }

// CREATE TOPICS
    if (isset($_POST['topic_creation'])){
        if(!isset($_SESSION['signed_in']) || $_SESSION['signed_in'] == false) {
            //the user is not signed in
            echo '
                <div data-closable class="alert-box callout alert">
                  <i class="fa fa-ban"></i> 
                  Sorry, you have to be <a href="login.php">logged in</a> to create a Topic.
                  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                         <span aria-hidden="true">&CircleTimes;</span>
                  </button>
                </div>
            ';
            die; // Remove the content from page
        }
        else {
            $user_id = $_SESSION['user_id'];

            //start the transaction
            $query  = "BEGIN WORK;";
            $result = mysqli_query($conn, $query);
            if (!$result)
                echo '
                    <div data-closable class="alert-box callout alert">
                      <i class="fa fa-ban"></i> 
                      An error occurred while creating your topic. Please try again later.
                      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                             <span aria-hidden="true">&CircleTimes;</span>
                      </button>
                    </div>
                '; // The query failed, quit
            $topic_sub = mysqli_real_escape_string($conn, $_POST['topic_subject']);
            $topic_cat = mysqli_real_escape_string($conn, $_POST['topic_cat']);
            $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
            if (empty($topic_sub)) {
                array_push($errors, "Subject  is required");
            }
            if (empty($post_content)) {
                array_push($errors, "Message is empty. You have to write something...");
            }

            $topic_check_query = "SELECT * FROM topics WHERE topic_subject='$topic_sub' LIMIT 1";
            $result = mysqli_query($conn, $topic_check_query);
            $topic = mysqli_fetch_assoc($result);

            if ($topic) { // if Topic exists
                if ($topic['topic_subject'] == $topic_sub) {
                    array_push($errors, "Topic already exists. Try to change the name or use the search bar to find the topic.");
                }
            }
            if (count($errors) == 0) {
                $query = "INSERT INTO topics(topic_subject, topic_date, topic_cat, topic_by)
                             VALUES ('$topic_sub', NOW(), $topic_cat, $user_id)";
                $result = mysqli_query($conn, $query);
                if (!$result){
                    // Something went wrong, display the error
                    echo '
                    <div data-closable class="alert-box callout alert">
                      <i class="fa fa-ban"></i> 
                      An error occurred while inserting your data. Please try again later.
                      <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                             <span aria-hidden="true">&CircleTimes;</span>
                      </button>
                    </div>
                    ';
                    echo('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
                    $query = "ROLLBACK;";
                    $result = mysqli_query($conn, $query);
                }
                else{
                    // First query worked, now start the second, posts query
                    // Retrieve the id of the freshly created topic for usage in the posts query
                    $topic_id = mysqli_insert_id($conn);
                    userLevelsQuery();

                    // Increase post_count of user and of forum
                    $q = "UPDATE users SET user_topics = user_topics + 1 WHERE user_id =" .$user_id;
                    $r = mysqli_query($conn, $q);

                    $query = "INSERT INTO posts(post_content, post_date, post_topic, post_by)
                            VALUES ('$post_content', NOW(), $topic_id, $user_id)";
                    $result = mysqli_query($conn, $query);
                    if (!$result){
                        // Something went wrong, display the error
                        echo '
                        <div data-closable class="alert-box callout alert">
                          <i class="fa fa-ban"></i> 
                          An error occurred while inserting your post. Please try again later.
                          <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                                 <span aria-hidden="true">&CircleTimes;</span>
                          </button>
                        </div>
                        ';
                        echo('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
                        $query = "ROLLBACK;";
                        $result = mysqli_query($conn, $query);
                    }
                    else{
                        $query = "COMMIT;";
                        $result = mysqli_query($conn, $query);
                        $q = "UPDATE users SET user_posts = (user_posts + 1) WHERE user_id =" .$user_id;
                        $r = mysqli_query($conn, $q);
                        echo '
                            <div data-closable class="alert-box callout success">
                              <i class="fa fa-check"></i> 
                              You have successfully created <a href="topic_view.php?id='. $topic_id . '">a new topic</a>
                              <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                                <span aria-hidden="true">&CircleTimes;</span>
                              </button>
                            </div>
                        ';
                        // Check if user reached number of post and topics to get a higher rank.
                        userLevelsQuery();
                    }
                }
            }
        }
    }

//RESET PASSWORD
    if (isset($_POST['pass_reset'])) {
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        // ensure that the user exists on our system
        $query = "SELECT user_email FROM users WHERE user_email='$email'";
        $results = mysqli_query($conn, $query);
        if (empty($email)) {
            array_push($errors, "Your email is required");
        }
        else if(mysqli_num_rows($results) <= 0) {
            array_push($errors, "Sorry, no user exists on our system with that email");
        }
        // generate a unique random token of length 100
        try {
            $token = bin2hex(random_bytes(50));
        }
        catch (Exception $e) {
            array_push($errors, "Could not generate token. Please email the admin with the link at the bottom of the page.");
        }

        if (count($errors) == 0) {
            // store token in the password-reset database table against the user's email
            $query = "INSERT INTO password_recovery(email, token) VALUES ('$email', '$token')";
            $results = mysqli_query($conn, $query);

            // Send email to user with the token in a link they can click on
            $to = $email;
            $subject = "Password Reset [Ngbako]";
            $msg = "Hi there, click on this <a href=\"new_pass.php?token=" . $token . "\">link</a> to reset your password.";
            $msg = wordwrap($msg,70);
            $headers = "From: reset@ngbako.com";
            mail($to, $subject, $msg, $headers);
            header('location: pending.php?email=' . $email);
        }
    }

// ENTER NEW PASSWORD
if (isset($_POST['set_new_pass'])) {
    $new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);
    $new_pass_c = mysqli_real_escape_string($conn, $_POST['new_pass_c']);

    // Grab to token that came from the email link
    $token = $_SESSION['token'];
    if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");
    if ($new_pass !== $new_pass_c) array_push($errors, "Passwords do not match");
    if (count($errors) == 0) {
        // select email address of user from the password_reset table
        $query = "SELECT email FROM password_recovery WHERE token='$token' LIMIT 1";
        $result = mysqli_query($conn, $query);
        $email = mysqli_fetch_assoc($result)['email'];
        if ($email) {
            $new_pass = sha1($new_pass);
            $query = "UPDATE users SET user_pass='$new_pass' WHERE user_email='$email'";
            $result = mysqli_query($conn, $query);
            if ($result){
                echo '<script> alert("Password successfully changed. Please log in with your new credentials") </script>  
                        <div data-closable class="alert-box callout success">
                            <i class="fa fa-check"></i> 
                            Password successfully changed. Please <a href="login.php"> log in </a> with your new credentials
                            <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                                <span aria-hidden="true">&CircleTimes;</span>
                            </button>
                            </div>
                            
                            <script>
                            setTimeout(function(){window.location.href = \'login.php\';}, 1700);                        
                            </script>
                    ';
            }
        }
    }
}

// PROFILE INDIVIDUAL CHANGES
// USERNAME
    if (isset($_POST['username_chg'])){
        $new_username = mysqli_real_escape_string($conn, trim($_POST['username']));
        // Validation
        if(strlen($new_username > 30))  { array_push($errors, "The username cannot be longer than 30 characters."); }
        if (!validateUsername($new_username)) {array_push($errors, "The username must have at least 6 characters and contain only alphanumeric characters"); }
        if (empty($new_username)) { array_push($errors, "Username is required"); }

        // Check Database to confirm that username does not exist
        $user_check_query = "SELECT * FROM users WHERE user_name='$new_username' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) { // if user exists
            if ($user['user_name'] === $new_username) {
                array_push($errors, "Username already exists. Try with another one!");
            }
        }
        // Change username if there are no errors in the form
        if (count($errors) == 0) {
            $query = "UPDATE users SET user_name =  
                      '$new_username' WHERE user_id=" . $_SESSION['user_id'];
            $final_result = mysqli_query($conn, $query);
            if (!$final_result){
                echo '
                        <div data-closable class="alert-box callout alert">
                          <i class="fa fa-ban"></i> 
                          Something went wrong. Please try again later.
                          <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                              <span aria-hidden="true">&CircleTimes;</span>
                          </button>
                        </div>
                ';
                die ('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
            }
            else{
                $_SESSION['username'] = $new_username;
                echo '<div data-closable class="alert-box callout success">
                        <i class="fa fa-check"></i> 
                        Your username was changed successfully
                        You will be redirected to <a href="index.php">the main page shortly </a>
                        <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                            <span aria-hidden="true">&CircleTimes;</span>
                         </button>
                      </div>
                      <script>
                            setTimeout(function(){window.location.href = \'login.php\';}, 1700);                        
                      </script>
                      ';

            }
        }
    }

// EMAIL ADDRESS
    if (isset($_POST['email_chg'])){
        $new_email = mysqli_real_escape_string($conn, trim($_POST['email']));

        // Check Database to confirm that username does not exist
        $user_check_query = "SELECT * FROM users WHERE user_email='$new_email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) { // if user exists
            if ($user['user_email'] === $new_email) {
                array_push($errors, "email address already exists. Make sure it is correct!");
            }
        }
        // Change username if there are no errors in the form
        if (count($errors) == 0) {
            $query = "UPDATE users SET user_email 
                      = '$new_email' WHERE user_id=" .$_SESSION['user_id'];
            $final_result = mysqli_query($conn, $query);
            if (!$final_result){
                echo '
                        <div data-closable class="alert-box callout alert">
                          <i class="fa fa-ban"></i> 
                          Something went wrong. Please try again later.
                          <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                              <span aria-hidden="true">&CircleTimes;</span>
                          </button>
                        </div>
                ';
                die ('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
            }
            else{
                echo '<div data-closable class="alert-box callout success">
                        <i class="fa fa-check"></i> 
                        Your email address was changed successfully
                        You will be redirected to <a href="index.php">the main page shortly </a>
                        <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                            <span aria-hidden="true">&CircleTimes;</span>
                         </button>
                      </div>
                      <script>
                            setTimeout(function(){window.location.href = \'signout.php\';}, 1100);                        
                            setTimeout(function(){window.location.href = \'login.php\';}, 2000);                        
                      </script>
                      ';
            }
        }
    }

// PASSWORD
    if (isset($_POST['pass_chg'])) {
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

        // Validation
        if (!validatePassword($_POST['password_1'])) {
            array_push($errors, "Your password must be at least 8 characters long and contain 1 uppercase, 1 lowercase, and 1 number. Please retry.");
        }
        if (empty($password_1)) {
            array_push($errors, "Password is required");
        }
        if ($password_1 != $password_2) {
            array_push($errors, "The two passwords do not match. Try again!");
        }
        if (strlen($password_1) < 6) {
            array_push($errors, "The password must be more than 6 characters. Please, retry");
        }

        // Change password
        if (count($errors) == 0) {
            $password = sha1($password_1); // Encrypt the password before saving in the database
            $query = "UPDATE users SET user_pass = 
                      '$password' WHERE user_id=" .$_SESSION['user_id'];
            $final_result = mysqli_query($conn, $query);
            if (!$final_result) {
                echo '
                        <div data-closable class="alert-box callout alert">
                          <i class="fa fa-ban"></i> 
                          Something went wrong. Please try again later.
                          <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                              <span aria-hidden="true">&CircleTimes;</span>
                          </button>
                        </div>
                ';
                die ('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
            }
            else {
                echo '<div data-closable class="alert-box callout success">
                        <i class="fa fa-check"></i> 
                        Password Changed!
                        You will be redirected to <a href="index.php">the main page shortly </a>
                        <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                            <span aria-hidden="true">&CircleTimes;</span>
                         </button>
                      </div>
                      <script>
                            setTimeout(function(){window.location.href = \'signout.php\';}, 1500);                        
                            setTimeout(function(){window.location.href = \'login.php\';}, 1500);                        
                      </script>
                      ';

            }
        }
    }

// IMAGE UPLOAD
    if (isset($_POST['chg_image'])){
        $image_new = $_FILES['user_image']['tmp_name'];

        // image file directory
        $target = "assets/img/profile/".basename($image_new);
        $image = basename($image_new);

        // Insert the image name and image content in image_table
//        $insert_image ="INSERT INTO image (image) VALUES ('$image')";
        $insert_image = "UPDATE image SET image = '$image' WHERE image_for=".$_SESSION['user_id'];
  	    // Execute query
        $final_result = mysqli_query($conn, $insert_image);

        if (!$final_result) {
            echo '
                        <div data-closable class="alert-box callout alert">
                          <i class="fa fa-ban"></i> 
                          Could not upload your picture. Please try again later.
                          <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                              <span aria-hidden="true">&CircleTimes;</span>
                          </button>
                        </div>
                ';
            die ('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
        }
        else {
            if (move_uploaded_file($_FILES['user_image']['tmp_name'], $target)) {
                 $msg = "Image uploaded successfully";
            }
            else{
                array_push($errors,  "Failed to upload image");
            }
            echo '<div data-closable class="alert-box callout success">
                        <i class="fa fa-check"></i> 
                        Picture Changed!
                        <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                            <span aria-hidden="true">&CircleTimes;</span>
                         </button>
                      </div>
                      ';
        }
    }
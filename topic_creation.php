<?php
session_start();
if (isset($_SESSION['user_id']))
    $user_id = $_SESSION['user_id'];

$msg_title = "Time to Speak!";
$msg_sub = "Create your topic so that you can discuss with your peers.";

include 'connect.php';
include 'header.php';
include 'app.php';
?>

<form class="log-in-form" method="post" action="">
    <h3 class="text-center">Posting Time!</h3>
    <label>
        Subject
        <input type="text" placeholder="Subject for discussion" name="topic_subject" >
    </label>
    <label>
        Category
        <select name="topic_cat">
            <?php
                $query ="SELECT cat_id,  cat_name, cat_description FROM categories";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)){
                    echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                }
            ?>
        </select>
    </label>
    <label>
        Message
        <textarea name="post_content" rows="5"> </textarea>
    </label>
    <p>
        <input type="submit" name="topic_creation" class="button expanded" value="Create Topic">
    </p>
    <br>

</form>

<?php include ('footer.php');

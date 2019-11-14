<?php
session_start();
$msg_title = "Create Category";
$msg_sub = "Create a category that can help user talk about a specific set of topics.";
include 'connect.php';
include 'header.php';
include 'mainsrv.php';

?>
<form method="post" action="" >
    <?php include('errors.php'); ?>
    <label>
        Category name
        <input type="text" name="cat_name" />
    </label>
     <label>
         Category description
        <textarea name="cat_description" rows="6"></textarea>
    </label>
    <input type="submit" value="Add category" class="button expanded" name="cat_creation"/>
</form>

<?php include ('footer.php');

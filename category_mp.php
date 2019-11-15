<!-- Categories on main page-->
<?php
include 'connect.php';

    $query = "SELECT cat_id, cat_name, cat_description FROM categories";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 0){
        echo 'No Categories';
    }
    else{
        while ($row = mysqli_fetch_assoc($result)){
        echo '
            <li><a href="category.php?id='. $row['cat_id'] .'">' . $row['cat_name'] . ' </a>    
        ';
        
        }
    }
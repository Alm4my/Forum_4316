<!-- Categories on main page-->
<?php
include 'connect.php';

function icon($cat_id){
    if ($cat_id == 1)
        print '<i class="fi-superscript"></i>';
    if ($cat_id == 2)
        echo '<i class="fi-euro"></i>';
    if ($cat_id == 3)
        echo '<i class="fi-laptop"></i>';
}
$i = 0;
$active = [];
$active[0] = "";


    $query = "SELECT cat_id, cat_name, cat_description FROM categories";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 0){
        echo 'No Categories';
    }
    else{
        while ($row = mysqli_fetch_assoc($result)){

            if (isset($_GET['cat'])){
                $id = $_GET['cat'];
                if ($id == 1){
                    $active[1] = 'is-active';
                    $active[2] = $active[0];
                    $active[3] = $active[0];
                }
                elseif ($id == 2){
                    $active[1] = $active[0];
                    $active[2] = 'is-active';
                    $active[3] = $active[0];
                }
                elseif($id == 3){
                    $active[1] = $active[0];
                    $active[2] = $active[0];
                    $active[3] = 'is-active';
                }
                echo '
                    <li class="'. $active[++$i] . '"> 
                      <a href="category.php?cat='. $row['cat_id' ] .'"> 
                 ';
                icon($row['cat_id']); // Icons for each categories
                // Category Name
                echo ' <span id="all-discuss">'. $row['cat_name'] . '
                            </span>
                            </a>  
                            </li>  
                  ';
            }
            else{
                $active[$i] = $active[0];
                echo '
            <li class="'. $active[$i] . '"> 
                <a href="category.php?cat='. $row['cat_id' ] .'"> 
            ';
                icon($row['cat_id']); // Icons for each categories
                // Category Name
                echo ' <span id="all-discuss">'. $row['cat_name'] . '
              </span>
              </a>  
            </li>  
        ';
            }
        
        }
    }
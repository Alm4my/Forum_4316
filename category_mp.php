<!-- Categories on main page-->
<?php
include 'connect.php';

function icon($cat_id){
    if ($cat_id == 1)
        print '<i class="fas fa-square-root-alt  "></i>';
    if ($cat_id == 2)
        echo '<i class="fas fa-laptop-code"></i>';
    if ($cat_id == 3)
        echo '<i class="fas fa-cogs"></i>';
    if ($cat_id == 4)
        echo '<i class="fas fa-tasks"></i>';
    if ($cat_id == 5)
        echo '<i class="fas fa-globe-africa"></i>';
    if ($cat_id == 6)
        echo '<i class="fas fa-euro-sign"></i>';
    if ($cat_id == 7)
        echo '<i class="fas fa-fist-raised"></i>';
    if ($cat_id == 8)
        echo '<i class="fas fa-camera"></i>';
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
                    $active[4] = $active[0];
                    $active[5] = $active[0];
                    $active[6] = $active[0];
                    $active[7] = $active[0];
                    $active[8] = $active[0];
                }
                elseif ($id == 2){
                    $active[1] = $active[0];
                    $active[2] = 'is-active';
                    $active[3] = $active[0];
                    $active[4] = $active[0];
                    $active[5] = $active[0];
                    $active[6] = $active[0];
                    $active[7] = $active[0];
                    $active[8] = $active[0];
                }
                elseif($id == 3){
                    $active[1] = $active[0];
                    $active[2] = $active[0];
                    $active[3] = 'is-active';
                    $active[4] = $active[0];
                    $active[5] = $active[0];
                    $active[6] = $active[0];
                    $active[7] = $active[0];
                    $active[8] = $active[0];
                }
                elseif($id == 4){
                    $active[1] = $active[0];
                    $active[2] = $active[0];
                    $active[3] = $active[0];
                    $active[4] = 'is-active';
                    $active[5] = $active[0];
                    $active[6] = $active[0];
                    $active[7] = $active[0];
                    $active[8] = $active[0];
                }
                elseif($id == 5){
                    $active[1] = $active[0];
                    $active[2] = $active[0];
                    $active[3] = $active[0];
                    $active[4] = $active[0];
                    $active[5] = 'is-active';
                    $active[6] = $active[0];
                    $active[7] = $active[0];
                    $active[8] = $active[0];
                }
                elseif($id == 6){
                    $active[1] = $active[0];
                    $active[2] = $active[0];
                    $active[3] = $active[0];
                    $active[4] = $active[0];
                    $active[5] = $active[0];
                    $active[6] = 'is-active';
                    $active[7] = $active[0];
                    $active[8] = $active[0];
                }
                elseif($id == 7){
                    $active[1] = $active[0];
                    $active[2] = $active[0];
                    $active[3] = $active[0];
                    $active[4] = $active[0];
                    $active[5] = $active[0];
                    $active[6] = $active[0];
                    $active[7] = 'is-active';
                    $active[8] = $active[0];
                }
                elseif($id == 8){
                    $active[1] = $active[0];
                    $active[2] = $active[0];
                    $active[3] = $active[0];
                    $active[4] = $active[0];
                    $active[5] = $active[0];
                    $active[6] = $active[0];
                    $active[7] = $active[0];
                    $active[8] = 'is-active';
                }
                echo '
                    <li class="'. $active[++$i] . ' left-side "> 
                      <a href="category.php?cat='. $row['cat_id' ] .'"> 
                 ';
                icon($row['cat_id']); // Icons for each categories
                // Category Name
                echo  $row['cat_name'] . '
                            
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
//                icon($row['cat_id']); // Icons for each categories
                // Category Name
                echo ' <span id="">'. $row['cat_name'] . '
              </span>
              </a>  
              '. icon($row['cat_id']) .' 
            </li>  
        ';
            }
        
        }
    }
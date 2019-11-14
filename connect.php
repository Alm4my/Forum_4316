<?php
// Connection to the database
    $server = 'mysql';
    $username = 'sgafor';
    $password = 'PassSGA1';
    $database = 'sgafor';

    // Create connection
    $conn = new mysqli($server, $username, $password, $database);
    // Check Connection
    if ($conn -> connect_error){
        die('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
    }
    if (!mysqli_select_db($conn, $database)) {
        die('Connect Error (' . $conn->connect_errno /* Error Code */ . ') ' . $conn->connect_error /* Error Desc */);
    }

//    echo "Connected Successfully";
//    mysqli_close($conn);



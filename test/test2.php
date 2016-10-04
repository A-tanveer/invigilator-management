<?php

    $id = $_GET['id'];

    $db_servername = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'testdb';

    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

    if($conn->connect_error){
        die('Connection failed: ' . $conn->connect_error);
    }
//    echo "Connected successfully";


    $sql = "SELECT * FROM `logins` WHERE id={$id}";
    
    $result = $conn->query($sql);
    
    
    if($result->num_rows > 0){
        $username = "";
        $fullname = "";
        while($row = $result->fetch_assoc()){
            $username = $row['Username'];
            $fullname = $row['Fullname'];
        }
        echo "Name : {$fullname}<br>Username: {$username}";
    }
    else{
        echo "Wrong id";
    }
?>
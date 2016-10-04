<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <?php
        $db_servername = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'examroutine';

    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

    if($conn->connect_error){
        die('Connection failed: ' . $conn->connect_error);
    }
//    echo "Connected successfully";
    
    $id = $_POST['del'];
    
    $conn->query("DELETE FROM `invigilators` WHERE exam_routine_id={$id}");
    $conn->query("DELETE FROM `exam_routine` WHERE exam_routine_id={$id}");
    
    header("location:../index.php");
    
    ?>
</body>
</html>
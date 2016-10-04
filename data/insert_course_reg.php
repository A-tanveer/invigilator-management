<?php

//    create connection with DATABASE examroutine.
    $db_servername = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'examroutine';

    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

    if($conn->connect_error){
        die('Connection failed: ' . $conn->connect_error);
    }
    echo "Connected successfully<br>";
?>


<?php
$a =0;
$ins = 'INSERT INTO `course_reg` VALUES ';
$sql = 'SELECT course_id FROM `course` where semester = "1/1"';
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
    $x = $row['course_id'];
    for($i = 241; $i <= 300; $i++){
        $a++;
        $xyz = $ins .'(' .$a. ',' .$i. ',' .$x. '),';
        $ins = $xyz;
    }    
}
$sql = 'SELECT course_id FROM `course` where semester = "2/1"';
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
    $x = $row['course_id'];
    for($i = 181; $i <= 240; $i++){
        $a++;
        $xyz = $ins .'(' .$a. ',' .$i. ',' .$x. '),';
        $ins = $xyz;
    }    
}

$sql = 'SELECT course_id FROM `course` where semester = "3/1"';
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
    $x = $row['course_id'];
    for($i = 121; $i <= 180; $i++){
        $a++;
        $xyz = $ins .'(' .$a. ',' .$i. ',' .$x. '),';
        $ins = $xyz;
    }    
}

$sql = 'SELECT course_id FROM `course` where semester = "4/1"';
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
    $x = $row['course_id'];
    for($i = 61; $i <= 120; $i++){
        $a++;
        $xyz = $ins .'(' .$a. ',' .$i. ',' .$x. '),';
        $ins = $xyz;
    }    
}


    for($i = 1; $i <= 60; $i++){
        $x = rand(13,37);
        $a++;
        $xyz = $ins .'(' .$a. ',' .$i. ',' .$x. '),';
        $ins = $xyz;
    }
echo $ins;


?>






<?php
//    $sql = 'INSERT INTO `student` VALUES ';
//    $x = 2010;
//    $y = 0;
//    echo $sql;
//    for($i = 0; $i <= 4; $i++){
//        $x++;
//        for($j = 1; $j <= 60; $j++){
//            echo '<br>';
//            $y++;
//            if($j>9) $r = $x.'3310'.$j;
//            else $r = $x.'33100'.$j;
//            if($j%3 == 0) $g = 'female';
//            else $g = 'male';
//            $ins = $y.','.$r.',"'.$r.'@sust.edu",1,"8801xxxxxxxxx","xyz street,sylhet", "abc","def","single","A/B/AB/O","islam/hindu/others","1995-12-12","'.$g.'"';
//            echo '('.$ins.'),';
//            $xyz = $sql. '(' .$ins. '),';
//            $sql = $xyz;
//        }    
//    }
//    echo '<br><br><br>';
//    //$conn->query($sql);
//echo $sql;


?>
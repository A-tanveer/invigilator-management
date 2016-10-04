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

    $id = $_POST['id'];
//    echo $id;
    $date = $_POST['Date'];
    $time = $_POST['Time'];
    $course = $_POST['Course'];
    $inst = $_POST['instructor'];
    $i_1 = $_POST['invigilator_1'];
    $i_2 = $_POST['invigilator_2'];
    $i_3 = $_POST['invigilator_3'];
    $i_4 = $_POST['invigilator_4'];
    
    if($date == NULL || $time == NULL || $course == NULL || $inst == NULL || $i_1 == NULL || $i_2 == NULL){
        header("Location: actionPopUpdate.php?id={$id}&type=update");
    }
    else{
        
    $sql = "SELECT course_id FROM `course` WHERE course_code = '{$course}'";
    $result = $conn->query($sql);
    $x = $result->fetch_assoc();
    $course_no = $x['course_id'];

    $sql = "SELECT semester FROM `course` WHERE course_code = '{$course}'";
    $result = $conn->query($sql);
    $x = $result->fetch_assoc();
    $semester = $x['semester'];

    $sql = "SELECT accepting_dept FROM `course` WHERE course_code = '{$course}'";
    $result = $conn->query($sql);
    $x = $result->fetch_assoc();
    $accepting_dept = $x['accepting_dept'];

    //upadating exam_routine table*********************************************  UPDATE EXAM ROUTINE  ***************************

    $sql = "UPDATE `exam_routine` SET exam_date = '{$date}', time = '{$time}', course_code = '{$course}',
    course_id = {$course_no}, semester = '{$semester}', dept = '{$accepting_dept}' WHERE exam_routine_id = {$id};";
    $conn->query($sql);
    echo $sql.'<br>';

    
    $sql = "SELECT instructor_id FROM `teacher` WHERE employee_code ='{$inst}'";
    $result = $conn->query($sql);
    $x = $result->fetch_assoc();
    $inst = $x['instructor_id'];


    //updating teaches table********************************************  UPDATE TEACHES  ********************

    $sql = "SELECT teaches_id FROM `teaches` WHERE course_id ={$course_no}";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        $sql = "UPDATE `teaches` SET instructor_id = {$inst} WHERE course_id ={$course_no}";
        $conn->query($sql);
        echo $sql;
    }else{
        //iserting data in teaches table**********************************  INSERT TEACHES  ******************************
        
        $sql = "INSERT INTO `teaches` (`course_id`,`instructor_id`) VALUES ({$course_no},{$inst})";
        $conn->query($sql);
        echo $sql.'<br>';
    }

    $sql = "SELECT instructor_id FROM `teacher` WHERE employee_code ='{$i_1}'";
    $result = $conn->query($sql);
    $x = $result->fetch_assoc();
    $i_1 = $x['instructor_id'];

    $sql = "SELECT instructor_id FROM `teacher` WHERE employee_code ='{$i_2}'";
    $result = $conn->query($sql);
    $x = $result->fetch_assoc();
    $i_2 = $x['instructor_id'];

    $sql = "SELECT instructor_id FROM `teacher` WHERE employee_code ='{$i_3}'";
    $result = $conn->query($sql);
    $x = $result->fetch_assoc();
    $i_3 = $x['instructor_id'];

    $sql = "SELECT instructor_id FROM `teacher` WHERE employee_code ='{$i_4}'";
    $result = $conn->query($sql);
    $x = $result->fetch_assoc();
    $i_4 = $x['instructor_id'];


    //update invigilators table ***********************************************  UPDATE INVIGILATORS  *********************

    if($i_3 != NULL && $i_4 != NULL){
        $sql = "UPDATE `invigilators` SET instructor_id = {$inst}, invigilator1 = {$i_1}, invigilator2 = {$i_2}, invigilator3 = {$i_3}, invigilator4 = {$i_4} WHERE exam_routine_id = {$id} ;";
        echo '<br>'.$sql;
     $conn->query($sql);
    }
    else if($i_3 == NULL && $i_4 != NULL){
        $sql = "UPDATE `invigilators` SET instructor_id = {$inst}, invigilator1 = {$i_1}, invigilator2 = {$i_2}, invigilator3 = NULL, invigilator4 = {$i_4} WHERE exam_routine_id = {$id} ;";
        echo '<br>'.$sql;
     $conn->query($sql);
    }
    else if($i_3 != NULL && $i_4 == NULL){
        $sql = "UPDATE `invigilators` SET instructor_id = {$inst}, invigilator1 = {$i_1}, invigilator2 = {$i_2}, invigilator3 = {$i_3}, invigilator4 = NULL WHERE exam_routine_id = {$id} ;";
        echo '<br>'.$sql;
     $conn->query($sql);
    }
    else{
        $sql = "UPDATE `invigilators` SET instructor_id = {$inst}, invigilator1 = {$i_1}, invigilator2 = {$i_2}, invigilator3 = NULL, invigilator4 = NULL WHERE exam_routine_id = {$id} ;";
        echo '<br>'.$sql;
     $conn->query($sql);
    }


    $conn->close();

    header("Location: ../index.php");

}
?>

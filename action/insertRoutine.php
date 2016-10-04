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
    $date = $_POST['Date'];
    $time = $_POST['Time'];
    $course = $_POST['Course'];

    if($date == NULL || $time == NULL || $course == NULL){
                header("Location: actionPopUpdate.php?id={$id}&type=insert");
    }else{
        $sql = "SELECT course_id FROM course WHERE course_code = '{$course}'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $sql = "SELECT COUNT(*) AS total FROM `course_reg` WHERE course_id = (SELECT course_id FROM course WHERE course_code = '{$course}');";
    //    echo $sql.'<br>';
        $result = $conn->query($sql);
        $x = $result->fetch_assoc();
        $numOfStudent = $x['total'];
        if($numOfStudent >= 62)
            $room2 = 5;
        else
            $room2 = NULL;

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

        if($room2 != NULL)
            $sql = "INSERT INTO `exam_routine` VALUES ({$id},'{$date}','{$time}',4,{$room2},{$course_no},'{$course}','{$semester}','{$accepting_dept}');";
        else
            $sql = "INSERT INTO `exam_routine` (exam_routine_id,exam_date,time,room_1_id,course_id,course_code,semester,dept) VALUES ({$id},'{$date}','{$time}',4,{$course_no},'{$course}','{$semester}','{$accepting_dept}');";
        $conn->query($sql);
        echo $sql.'<br>';

    //    $sql = "SELECT exam_routine_id FROM `exam_routine` WHERE course_code = '{$course}'";
    //    $result = $conn->query($sql);
    //    $x = $result->fetch_assoc();
    //    $accepting_dept = $x['accepting_dept'];

        $sql = "SELECT exam_routine_id FROM `exam_routine` WHERE exam_date = '{$date}' AND course_code = '{$course}';";
        $result = $conn->query($sql);
        $x = $result->fetch_assoc();
        $ex_id = $x['exam_routine_id'];

    //    $sql = "INSERT INTO `exam_routine` VALUES ({$id},'{$date}','{$time}',4,{$room2},(SELECT course_id FROM `course` WHERE course_code = '{$course}'),'{$course}',(SELECT semester FROM `course` WHERE course_code = '{$course}'),(SELECT accepting_dept FROM `course` WHERE course_code = '{$course}'));";    //why it isn't working ?!?
    //    echo $sql.'<br>';
    //    $conn->query($sql);
        
        $sql = "SELECT instructor_id FROM `teaches` WHERE course_id = {$course_no}";
        $result = $conn->query($sql);        
        if ($result->num_rows > 0){            
            $x = $result->fetch_assoc();
            $insrtuctor = $x['instructor_id'];
            
            if($room2 != NULL){
            if($id%4 == 0)
                $sql = "INSERT INTO `invigilators` (`exam_routine_id`, `instructor_id`, `invigilator1`, `invigilator2`, `invigilator3`, `invigilator4`) VALUES ({$ex_id},{$insrtuctor},7,6,8,3);";
            else if($id%5 == 0)
                $sql = "INSERT INTO `invigilators` (`exam_routine_id`, `instructor_id`, `invigilator1`, `invigilator2`, `invigilator3`, `invigilator4`) VALUES ({$ex_id},{$insrtuctor},1,3,6,2);";
            else if($id%3 == 0)
                $sql = "INSERT INTO `invigilators` (`exam_routine_id`, `instructor_id`, `invigilator1`, `invigilator2`, `invigilator3`, `invigilator4`) VALUES ({$ex_id},{$insrtuctor},9,6,8,4);";
            else
                $sql = "INSERT INTO `invigilators` (`i_id`, `exam_routine_id`, `instructor_id`, `invigilator1`, `invigilator2`, `invigilator3`, `invigilator4`) VALUES ({$ex_id},{$insrtuctor},4,3,1,7);";
            }
            else{
                if($id%4 == 0 )
                    $sql = "INSERT INTO `invigilators` (`exam_routine_id`, `instructor_id`, `invigilator1`, `invigilator2`) VALUES ({$ex_id},{$insrtuctor},1,7);";
                else if($id%5 == 0)
                    $sql = "INSERT INTO `invigilators` (`exam_routine_id`, `instructor_id`, `invigilator1`, `invigilator2`) VALUES ({$ex_id},{$insrtuctor},1,3);";
                else if($id%3 == 0)
                    $sql = "INSERT INTO `invigilators` (`exam_routine_id`, `instructor_id`, `invigilator1`, `invigilator2`) VALUES ({$ex_id},{$insrtuctor},2,9);";
                else
                    $sql = "INSERT INTO `invigilators` (`exam_routine_id`, `instructor_id`, `invigilator1`, `invigilator2`) VALUES ({$ex_id},{$insrtuctor},8,4);";
            }
        }else{
            if($room2 != NULL){
            if($id%4 == 0)
                $sql = "INSERT INTO `invigilators` (`exam_routine_id`,  `invigilator1`, `invigilator2`, `invigilator3`, `invigilator4`) VALUES ({$ex_id},7,6,8,3);";
            else if($id%5 == 0)
                $sql = "INSERT INTO `invigilators` (`exam_routine_id`,  `invigilator1`, `invigilator2`, `invigilator3`, `invigilator4`) VALUES ({$ex_id},1,3,6,2);";
            else if($id%3 == 0)
                $sql = "INSERT INTO `invigilators` (`exam_routine_id`,  `invigilator1`, `invigilator2`, `invigilator3`, `invigilator4`) VALUES ({$ex_id},9,6,8,4);";
            else
                $sql = "INSERT INTO `invigilators` (`exam_routine_id`,  `invigilator1`, `invigilator2`, `invigilator3`, `invigilator4`) VALUES ({$ex_id},4,3,1,7);";
        }
        else{
            if($id%4 == 0 )
                $sql = "INSERT INTO `invigilators` (`exam_routine_id`, `invigilator1`, `invigilator2`) VALUES ({$ex_id},1,7);";
            else if($id%5 == 0)
                $sql = "INSERT INTO `invigilators` (`exam_routine_id`, `invigilator1`, `invigilator2`) VALUES ({$ex_id},1,3);";
            else if($id%3 == 0)
                $sql = "INSERT INTO `invigilators` (`exam_routine_id`, `invigilator1`, `invigilator2`) VALUES ({$ex_id},2,9);";
            else
                $sql = "INSERT INTO `invigilators` (`exam_routine_id`, `invigilator1`, `invigilator2`) VALUES ({$ex_id},8,4);";
            }
        }
        
        $conn->query($sql);
        echo $sql;

    }else 
        echo"Course Not Found !";
            
        
    $conn->close();
    header("Location: ../index.php");

    }

    
?>
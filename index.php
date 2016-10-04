<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="test/bootstrap.min.css">
    <style>
        .but {
            text-align: center;
        }

        .edit {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 2px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }

        .del {
            background-color: #AF4C50;
            border: none;
            color: white;
            padding: 2px 4px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }

        .insert {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 40px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 18px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .pdf {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 40px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 18px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .pop {
            display: none;
        }

        .content {
            border-radius: 0px;
            box-shadow: 0 0 20px #FFFFFF;
            padding-top: 10px;
            padding-left: 30px;
            padding-right: 30px;
            background-color: #FFFFFF;
            min-width: 808px;
            ;
        }

        table.tc {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table.tc td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            text-transform: uppercase;
        }

        table.tc th {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #4CAF50;
            color: white;
        }

        table.tc tr:nth-child(even) {
            background-color: #f2f2f2
        }

        table.tc tr:hover {
            background-color: #cdc;
        }
    </style>

</head>

<body>
    <div class="pop">
        <div class="content"></div>
    </div>

    <header style="text-align:center; font-size:300%; color:white; background-color: #4CAF50; "> Dept. of Computer Science and Engineering
        <br>Invigilation Routine
        <br>
        <p style="text-align:center; font-size:18px">Final Examination 2016 (Semester January-June 2015)</p>
    </header>


    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.bpopup.min.js"></script>
    <script src="js/custom.js"></script>
</body>


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


    $sql = "SELECT * FROM `exam_routine` JOIN `invigilators` WHERE `exam_routine`.`exam_routine_id` = `invigilators`.`exam_routine_id` ORDER BY exam_date;";

    $result = $conn->query($sql);
    echo "<table class= 'tc' align = 'center' id = 'routine'>";

    if($result->num_rows > 0){
?>

    <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Room no.</th>
        <th>Course no.</th>
        <th>Semester</th>
        <th>Dept</th>
        <th>Instructor</th>
        <th>Invigilator
            <br>Gallery 1</th>
        <th>Invigilator
            <br>Gallery 2</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

    <?php
        date_default_timezone_set("Asia/Dhaka");
        $datetime = new DateTime('tomorrow');
        $d = $datetime->format('Y-m-d');
        $idIns = 0;

        while($row = $result->fetch_assoc()){
            $date = $row['exam_date'];
            $time = $row['time'];
            if($row['room_2_id'] != NULL)
                $room = 'Gallery 1, 2';
            else
                $room = 'Gallery 1';
            $course = $row['course_code'];
            $sem = $row['semester'];
            $dept = $row['dept'];



            $sql = "SELECT course_id FROM `course` WHERE course_code = '{$row['course_code']}'";
            $i = $conn->query($sql);
            $x = $i->fetch_assoc();
            // echo $sql."<br>";

            $sql = "SELECT employee_code FROM `teaches` JOIN `teacher` WHERE teaches.instructor_id = teacher.instructor_id AND teaches.course_id = {$x['course_id']}" ;
            $i = $conn->query($sql);
            $c_i = '?';
            if($i->num_rows > 0) {
                $x = $i->fetch_assoc();
                $c_i = $x['employee_code'];
            }
            // echo $c_i." ";
            // echo $sql."<br><br>";


            $sql = 'SELECT employee_code FROM `teacher` WHERE instructor_id = ' .$row['invigilator1'] ;
            $i = $conn->query($sql);
            $x = $i->fetch_assoc();
            $i_11 = $x['employee_code'];

            $sql = 'SELECT employee_code FROM `teacher` WHERE instructor_id = ' .$row['invigilator2'] ;
            $i = $conn->query($sql);
            $x = $i->fetch_assoc();
            $i_12 = $x['employee_code'];

            $ig1 = $i_11. ', ' .$i_12;

            if($row['invigilator3'] != NULL && $row['invigilator4'] == NULL){
                $sql = 'SELECT employee_code FROM `teacher` WHERE instructor_id = ' .$row['invigilator3'] ;
                $i = $conn->query($sql);
                $x = $i->fetch_assoc();
                $ig_2 = $x['employee_code'];
            }
            else if($row['invigilator4'] != NULL && $row['invigilator3'] == NULL){
                $sql = 'SELECT employee_code FROM `teacher` WHERE instructor_id = ' .$row['invigilator4'] ;
                $i = $conn->query($sql);
                $x = $i->fetch_assoc();
                $ig_2 = $x['employee_code'];
            }
            else if($row['invigilator4'] != NULL && $row['invigilator3'] != NULL){
                $sql = 'SELECT employee_code FROM `teacher` WHERE instructor_id = ' .$row['invigilator4'] ;
                $i = $conn->query($sql);
                $x = $i->fetch_assoc();
                $i_21 = $x['employee_code'];
                $sql = 'SELECT employee_code FROM `teacher` WHERE instructor_id = ' .$row['invigilator3'] ;
                $i = $conn->query($sql);
                $x = $i->fetch_assoc();
                $i_22 = $x['employee_code'];

                $ig_2 = "{$i_21}, {$i_22}";
            }
            else if($row['invigilator4'] == NULL && $row['invigilator3'] == NULL){
                $ig_2 = '-----';
            }


//            if($row['room_2_id'] != NULL){
//                $ig2 = $i_21. ', ' .$i_22;
//            }else $ig2 = NULL;


            echo '<tr>';
            echo '<td>'. $date . '</td>';
            $time = date('h:i A', strtotime($time));
            echo '<td>'. $time . '</td>';
            echo '<td>'. $room . '</td>';
            echo '<td>'. $course . '</td>';
            echo '<td>'. $sem . '</td>';
            echo '<td>'. $dept . '</td>';
            echo '<td>'. $c_i . '</td>';
            echo '<td>'. $ig1 . '</td>';
            echo '<td>'. $ig_2 . '</td>';

            if($date >= $d){
                echo '<td><button class="edit" type="button" id = "'. $row['exam_routine_id'] .'">Edit</button></td>';
            }else echo "<td></td>";
            echo '<td>
            <form action="action/delete.php" method="POST">
                <button type="submit" class="del" name="del" value='. $row['exam_routine_id'] .'>Delete</button>
            </form>

            </td>';
            echo '</tr>';

            if($row['exam_routine_id'] >= $idIns)
            $idIns = $row['exam_routine_id']+1;

        }
    }
       echo '</table>';
?>

        <body>
            <br>
            <div class="but">
                <!--                <button  class="pdf" onclick="window.location.href='generatePdf.php'" type="button">DOWNLOAD</button>-->
                <button class="insert" type="button" id="<?php echo $idIns ?>">ADD EXAM</button>
                <input type="button" class="pdf" value="DOWNLOAD" onclick="window.open('generatePdf.php')" />

            </div>
        </body>


        <?php
    $conn->close();
?>


</html>

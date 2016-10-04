<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../test/bootstrap.min.css">

    <style>
        .frm {
            text-align: left;
            text-transform: uppercase;
        }

        .ttl {
            background-color: #4CAF50;
            width: 100%;
            text-align: center;
            color: white;
        }

        .but {
            text-align: center;
        }

        .sub {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 8px 25px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            margin: 6px 3px;
            cursor: pointer;
        }

        input {
            text-transform: uppercase;
        }

        input.same_width {
            width: 100%;
            height: 27px;
            border: 3px solid #bbddbb;
            border-bottom-right-radius: 7px;
            border-top-right-radius: 7px;
        }

        input.x {
            width: 100%;
            height: 27px;
            border: 3px solid #eecbcb;
            border-bottom-right-radius: 7px;
            border-top-right-radius: 7px;
        }

        input:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 8px #4CAF50;
        }
    </style>


    <script>
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };

        function validateForm() {
            var type = getUrlParameter('type');
            //            alert(type);
            //            var id = $('#test').val();
            //            alert(id);

            if (type == 'update') {
                var x = document.forms["updateForm"]["Date"].value;
                var y = document.forms["updateForm"]["Time"].value;
                var z = document.forms["updateForm"]["Course"].value;
                var a = document.forms["updateForm"]["instructor"].value;
                var b = document.forms["updateForm"]["invigilator_1"].value;
                var c = document.forms["updateForm"]["invigilator_2"].value;
                var d = document.forms["updateForm"]["invigilator_3"].value;
                var e = document.forms["updateForm"]["invigilator_4"].value;

                if (x == null || x == "" || y == null || y == "" || z == null || z == "" || a == null || a == "" || b == null || b == "" || c == null || c == "" || d == null || d == "" || e == null || e == "") {

                    alert("GREEN BORDERED FIELDS CAN NOT BE LEFT EMPTY !!");
                    return false;
                }
            }
            if (type == 'insert') {
                var x = document.forms["insertForm"]["Date"].value;
                var y = document.forms["insertForm"]["Time"].value;
                var z = document.forms["insertForm"]["Course"].value;

                if (x == null || x == "" || y == null || y == "" || z == null || z == "") {
                    alert("MAKE SURE NO FIELD IS EMPTY !!");
                    return false;
                }
            }

        }
    </script>

</head>

<?php
    $id = $_GET['id'];
    $type = $_GET['type'];

    $db_servername = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'examroutine';

    $conn = new mysqli('localhost', 'root', '', 'examroutine' );
    if($conn->connect_error){
        die('connection error: ' . $conn->connect_error);
    }
//    echo "connected";

        if($type == 'update'){

            $result = $conn->query("SELECT exam_date FROM `exam_routine` WHERE exam_routine_id = '{$id}'");
            $x = $result->fetch_assoc();
            $date = $x['exam_date'];

            $result = $conn->query("SELECT time FROM `exam_routine` WHERE exam_routine_id = '{$id}'");
            $x = $result->fetch_assoc();
            $time = $x['time'];

            $result = $conn->query("SELECT course_code FROM `exam_routine` WHERE exam_routine_id = '{$id}'");
            $x = $result->fetch_assoc();
            $course = $x['course_code'];

            $tea = $conn->query("SElECT employee_code FROM `teacher` WHERE dept_id = (SELECT dept_id FROM `department` WHERE dept_code = (SELECT offering_dept FROM `course` WHERE course_code = '{$course}'))");

            $result = $conn->query("SELECT employee_code FROM `teacher` WHERE instructor_id = (SELECT invigilator1 FROM `invigilators` where exam_routine_id = {$id});");
            $x = $result->fetch_assoc();
            $inv1 = $x['employee_code'];

            $result = $conn->query("SELECT employee_code FROM `teacher` WHERE instructor_id = (SELECT invigilator2 FROM `invigilators` where exam_routine_id = {$id});");
            $x = $result->fetch_assoc();
            $inv2 = $x['employee_code'];

            $result = $conn->query("SELECT employee_code FROM `teacher` WHERE instructor_id = (SELECT invigilator3 FROM `invigilators` where exam_routine_id = {$id});");
            $x = $result->fetch_assoc();
            $inv3 = $x['employee_code'];

            $result = $conn->query("SELECT employee_code FROM `teacher` WHERE instructor_id = (SELECT invigilator4 FROM `invigilators` where exam_routine_id = {$id});");
            $x = $result->fetch_assoc();
            $inv4 = $x['employee_code'];

            $result = $conn->query("SELECT employee_code FROM `teacher` WHERE instructor_id = (SELECT instructor_id FROM `invigilators` where exam_routine_id = {$id});");
            $x = $result->fetch_assoc();
            $inst = $x['employee_code'];
?>

    <body>
        <div class="frm">
            <h3 class="ttl">Update Routine For : <?php echo $course; ?></h3>
            <form name="updateForm" onsubmit="return validateForm()" action="../ExamRoutine/action/updateRoutine.php" method='POST'>

                <h5>Date:</h5>
                <input type="date" class="same_width" name='Date' value="<?php echo $date; ?>" placeholder="Enter Date ( NOT EMPTY )">
                <br>
                <h5>Time:</h5>
                <input type="time" class="same_width" name='Time' value="<?php echo $time; ?>" placeholder="Enter Time ( NOT EMPTY )">
                <br>

                <h5>Instructor:</h5>
                <input type="text" list="teacher" class="same_width" name="instructor" value="<?php echo $inst; ?>" placeholder="Employee Code of The Instructor ( NOT EMPTY )">
                <datalist id="teacher">
                    <?php
                        if($tea->num_rows > 0){
                            while($row = $tea->fetch_assoc()){
                                echo "<option> {$row['employee_code']}";
                            }
                        }else echo "NO TEACHER FOUND";

                    ?>
                </datalist>
                <br>

                <h5>Invigilator 1:</h5>
                <input type="text" list="ins1" class="same_width" name="invigilator_1" value="<?php echo $inv1; ?>" placeholder="Employee Code of One Invigilator ( NOT EMPTY )">
                <datalist id="ins1">
                    <?php
                        $tea = $conn->query("SElECT employee_code FROM `teacher` WHERE dept_id = (SELECT dept_id FROM `department` WHERE dept_code = (SELECT offering_dept FROM `course` WHERE course_code = '{$course}'))");
                        if($tea->num_rows > 0){
                            while($row = $tea->fetch_assoc()){
                                echo "<option> {$row['employee_code']}";
                            }
                        }else echo "NO TEACHER FOUND";

                    ?>
                </datalist>
                <br>

                <h5>Invigilator 2:</h5>
                <input type="text" list="iins2" class="same_width" name="invigilator_2" value="<?php echo $inv2; ?>" placeholder="Employee Code of One Invigilator ( NOT EMPTY )">
                <datalist id="iins2">
                    <?php
                        $tea = $conn->query("SElECT employee_code FROM `teacher` WHERE dept_id = (SELECT dept_id FROM `department` WHERE dept_code = (SELECT offering_dept FROM `course` WHERE course_code = '{$course}'))");
                        if($tea->num_rows > 0){
                            while($row = $tea->fetch_assoc()){
                                echo "<option> {$row['employee_code']}";
                            }
                        }else echo "NO TEACHER FOUND";

                    ?>
                </datalist>
                <br>

                <h5>Invigilator 3:</h5>
                <input type="text" list="ins3" class="x" name="invigilator_3" value="<?php echo $inv3; ?>" placeholder="Employee Code of One Invigilator  ">
                <datalist id="ins3">
                    <?php
                        $tea = $conn->query("SElECT employee_code FROM `teacher` WHERE dept_id = (SELECT dept_id FROM `department` WHERE dept_code = (SELECT offering_dept FROM `course` WHERE course_code = '{$course}'))");
                        if($tea->num_rows > 0){
                            while($row = $tea->fetch_assoc()){
                                echo "<option> {$row['employee_code']}";
                            }
                        }else echo "NO TEACHER FOUND";

                    ?>
                </datalist>
                <br>

                <h5>Invigilator 4:</h5>
                <input type="text" list="inst4" class="x" name="invigilator_4" value="<?php echo $inv4; ?>" placeholder="Employee Code of One Invigilator  ">
                <datalist id="inst4">
                    <?php
                        $tea = $conn->query("SElECT employee_code FROM `teacher` WHERE dept_id = (SELECT dept_id FROM `department` WHERE dept_code = (SELECT offering_dept FROM `course` WHERE course_code = '{$course}'))");
                        if($tea->num_rows > 0){
                            while($row = $tea->fetch_assoc()){
                                echo "<option> {$row['employee_code']}";
                            }
                        }else echo "NO TEACHER FOUND";
                    ?>
                </datalist>
                <br>
                <input type="hidden" name="Course" value="<?php echo $course ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <br>
                <div class="but">
                    <button class="sub" type='submit'>SUBMIT</button>
                </div>

                <br>
            </form>
        </div>

        <?php



        }else if($type == 'insert'){

            $sql = "SELECT course_code FROM `course`;";
            $dropDown = $conn->query($sql);
    ?>


            <div class="frm">
                <h3 class="ttl">Add New Exam</h3>
                <form name="insertForm" onsubmit="return validateForm()" action="../ExamRoutine/action/insertRoutine.php" method='POST'>

                    <h5>Date:</h5>
                    <input type="date" class="same_width" name='Date' placeholder="Enter Date ( NOT EMPTY )">
                    <br>
                    <h5>Time:</h5>
                    <input type="time" class="same_width" name='Time' placeholder="Enter Time ( NOT EMPTY )">
                    <br>
                    <h5>Course:</h5>
                    <input type="text" list="crs" id='test' class="same_width" name='Course' placeholder="Enter Course Code ( NOT EMPTY )">
                    <datalist id="crs">
                        <?php
                        if($dropDown->num_rows > 0){
                            while($row = $dropDown->fetch_assoc()){
                                echo "<option> {$row['course_code']}";
                            }
                        }else echo "EMPTY COURSE TABLE";

                    ?>
                    </datalist>
                    <br>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <br>
                    <div class="but">
                        <button class="sub" type='submit'>SUBMIT</button>
                    </div>

                    <br>
                </form>
            </div>

            <?php
            $conn->close();

        }

    ?>

                <script src="../js/jquery.min.js"></script>
    </body>

</html>

<?php

require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tanveer Ahmed');
$pdf->SetTitle('Exam Routine With Invigilators');
$pdf->SetSubject('CSE 334 Lab Project');
$pdf->SetKeywords('TCPDF, PDF, project, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 9);

// add a page
$pdf->AddPage();

// set some text to print
$html = '<h2 style="text-align:center"> Dept. of Computer Science and Engineering
    <br>Invigilation Routine</h2>
    <p style="text-align:center; font-size:12">Final Examination 2016 (Semester January-June 2015)</p>';

    $pageVar = 0;

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


    if($result->num_rows > 0){


     $html = $html . '<table border="1" cellpadding="2">
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
        </tr>';


        date_default_timezone_set("Asia/Dhaka");
        $datetime = new DateTime('tomorrow');
        $d = $datetime->format('Y-m-d');
        $breakVal = 0;

        while($row = $result->fetch_assoc()){

            if ($pageVar != 0 && $pageVar%25 == 0){

                $html = $html. '</table>';
                $pdf->writeHTML($html, true, false, true, false, '');
                //$pdf->Output('pdfex.pdf', 'I');
                // reset pointer to the last page
                $pdf->lastPage();


                // add a page
                $pdf->AddPage();

                // set some text to print
                $html = '<h2 style="text-align:center"> Dept. of Computer Science and Engineering
                <br>Invigilation Routine</h2>
                <p style="text-align:center; font-size:12">Final Examination 2016 (Semester January-June 2015)</p>';
                $html = $html . '<table border="1" cellpadding="2">
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
                </tr>';

            }
            $pageVar++;

            $date = $row['exam_date'];
            $time = $row['time'];
            if($row['room_2_id'] != NULL)
                $room = 'Gallery 1, 2 ';
            else
                $room = 'Gallery 1';
            $course = $row['course_code'];
            $sem = $row['semester'];
            $dept = $row['dept'];

			$sql = "SELECT course_id FROM `course` WHERE course_code = '{$row['course_code']}'";
            $i = $conn->query($sql);
            $x = $i->fetch_assoc();
            $course_id = $x['course_id'];

            $sql = "SELECT employee_code FROM `teaches` JOIN `teacher` WHERE teaches.instructor_id = teacher.instructor_id AND teaches.course_id = {$course_id}" ;
            $i = $conn->query($sql);
            if($i->num_rows > 0) {
                $x = $i->fetch_assoc();
                $c_i = $x['employee_code'];
            }else {
                $c_i = '?';
            }


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



            $html = $html. '<tr>';
            $html = $html. '<td>'. $date .' '. '</td>';
            $time = date('h:i A', strtotime($time));
            $html = $html. '<td>'. $time . '</td>';
            $html = $html. '<td>'. $room .' '. '</td>';
            $html = $html. '<td>'. $course . '</td>';
            $html = $html. '<td>'. $sem . '</td>';
            $html = $html. '<td>'. $dept . '</td>';
            $html = $html. '<td>'. $c_i . '</td>';
            $html = $html. '<td>'. $ig1 . '</td>';
            $html = $html. '<td>'. $ig_2 . '</td>';

            $html = $html. '</tr>';
//            $html = $html.'<br><br>';

        }
    }
       $html = $html. '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output('pdfex.pdf', 'I');
?>

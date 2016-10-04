<!DOCTYPE html>
<html>

<head>
    <style>
        .rem {
            text-align: center;
            width: 100%;
            height: 100%;
            border: 5px solid;
            border-color: darkgreen;
            background-color: #4CAF50;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .lnk{
            text-align: left;
        }
        a{
            color: white;
        }
        a:visited
        {
            color: white;
        }
    </style>
</head>

<body>
    <div class="rem">

        <?php

//            require("sendgrid-php/sendgrid-php.php");
            $db_servername = 'localhost';
            $db_username = 'root';
            $db_password = '';
            $db_name = 'examroutine';

            $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

            if($conn->connect_error){
                die('Connection failed: ' . $conn->connect_error);
            }
        //    echo "Connected successfully";


        //    setting timezone and taking tomorrows date to check if there is any exam tomorrow
                date_default_timezone_set("Asia/Dhaka");
                $datetime = new DateTime('tomorrow');
            //    $datetime = new DateTime('2016-04-18');//data for testing !!  (having less than 4 assingned invigilators)
            //    $datetime = new DateTime('2016-04-14');//data for testing !!  (having 4 assingned invigilators)
                $date = $datetime->format('Y-m-d');

                $sql = "SELECT exam_routine_id FROM `exam_routine` WHERE exam_date = '" .$date. "' ";
                $result = $conn->query($sql);

                if($result->num_rows > 0){
                    $data = $result->fetch_assoc();
                    $examId = $data['exam_routine_id'];


                    $sql = 'SELECT instructor_id, invigilator1, invigilator2, invigilator3, invigilator4 FROM `invigilators` WHERE exam_routine_id = ' .$examId;
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){

                            $chief_invigilator = $row['instructor_id'];
                            $invigilatorId1 = $row['invigilator1'];
                            $invigilatorId2 = $row['invigilator2'];
                            $invigilatorId3 = $row['invigilator3'];
                            $invigilatorId4 = $row['invigilator4'];
                        }
                    }

                    $sql = 'SELECT contact_no, email FROM `teacher` WHERE instructor_id = ' .$chief_invigilator;
                    $result = $conn->query($sql);
                    $data = $result->fetch_assoc();
            //        sendRemainder($data['email']);
                    echo 'INSTRUCTOR<br>Call: ' .$data['contact_no'].'<br>Email: '.$data['email'];

                    $sql = 'SELECT contact_no, email FROM `teacher` WHERE instructor_id = ' .$invigilatorId1;
                    $result = $conn->query($sql);
                    $data = $result->fetch_assoc();
            //        sendRemainder($data['email']);
                    echo '<br><br><hr><br>INVIGILATOR 1<br>Call: ' .$data['contact_no'].'<br>Email: '.$data['email'];

                    $sql = 'SELECT contact_no, email FROM `teacher` WHERE instructor_id = ' .$invigilatorId2;
                    $result = $conn->query($sql);
                    $data = $result->fetch_assoc();
            //        sendRemainder($data['email']);
                    echo '<br><br><hr><br>INVIGILATOR 2<br>CAll: ' .$data['contact_no'].'<br>Email: '.$data['email'];

                    if($invigilatorId3 != NULL){
                        $sql = 'SELECT contact_no, email FROM `teacher` WHERE instructor_id = ' .$invigilatorId3;
                        $result = $conn->query($sql);
                        $data = $result->fetch_assoc();
            //          sendRemainder($data['email']);
                        echo '<br><br><hr><br>INVIGILATOR 3<br>Call: ' .$data['contact_no'].'<br>Email: '.$data['email'];
                    }

                    if($invigilatorId4 != NULL){
                        $sql = 'SELECT contact_no, email FROM `teacher` WHERE instructor_id = ' .$invigilatorId4;
                        $result = $conn->query($sql);
                        $data = $result->fetch_assoc();
            //          sendRemainder($data['email']);
                        echo '<br><br><hr><br>INVIGILATOR 4<br>Call: ' .$data['contact_no'].'<br>Email: '.$data['email'].'<br>';
                    }
                    ?>
                     <div class="lnk">
                        <a href="instruction.html">Schedule This</a>
                    </div>
                    <?php

                }else{
                    echo '<h2>No Exams Tommorow !</h2>';
                    ?>
                     <div class="lnk">
                        <a href="instruction.html">Schedule This</a>
                    </div>
                    <?php
                }






            //    this function is for sending email to invigilators.
//        function sendRemainder($emailAddress){
//
//
//            $sendgrid = new SendGrid("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");
//
//            $email    = new SendGrid\Email();
//
//            $email->addTo($emailAddress);
//            $email->setFrom("blacktanvir@gmail.com");
//            $email->setSubject("Remainder");
//            $email->setHtml("You have duty as an invigilator tommorow.");
//
//            if($sendgrid->send($email)) echo "email sent to: " .$emailAddress;
//            else echo "Failed";
//
//        }
            $conn->close();

        ?>
    </div>

</body>

</html>

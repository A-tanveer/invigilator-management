
<?php
    $sql = 'INSERT INTO `student` VALUES ';
    $x = 2010;
    $y = 0;
    echo $sql;
    for($i = 0; $i <= 4; $i++){
        $x++;
        for($j = 1; $j <= 60; $j++){
            echo '<br>';
            $y++;
            if($j>9) $r = $x.'3310'.$j;
            else $r = $x.'33100'.$j;
            if($j%3 == 0) $g = 'female';
            else $g = 'male';
            $ins = $y.','.$r.',"'.$r.'@sust.edu",1,"8801xxxxxxxxx","xyz street,sylhet", "abc","def","single","A/B/AB/O","islam/hindu/others","1995-12-12","'.$g.'"';
            echo '('.$ins.'),';
            $xyz = $sql. '(' .$ins. '),';
            $sql = $xyz;
        }    
    }
    echo '<br><br><br>';
echo $sql;


?>
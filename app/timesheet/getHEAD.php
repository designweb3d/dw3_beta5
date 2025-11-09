<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$currentUSER = $_GET['USER_ID'];
$year  = mysqli_real_escape_string($dw3_conn, $_GET['Y']);
$month  = mysqli_real_escape_string($dw3_conn, $_GET['M']);


$wkyear = date($year);
$wkmonth = date($month);
$days = cal_days_in_month(CAL_GREGORIAN, $wkmonth, $wkyear);
$html = "[ ";

for ($i=1; $i<=$days; $i++) {
    $day = sprintf("%02d", $i);
    $date = "$wkyear-$wkmonth-$day 00:00:00";
    
//count lines of the day
    //count lines during the schedule
    $sql2 = "SELECT COUNT(id) as line_count FROM schedule_line 
    WHERE user_id = '" . $currentUSER . "' AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "' AND DAY(start_date) ='" . $day . "'";
    $result2 = mysqli_query($dw3_conn, $sql2);
    $data2 = mysqli_fetch_assoc($result2);
    $line_count_tot = $data2['line_count'];
    $lines_count_schedules = 0;
    //count events during the schedule
    $sql3 = "SELECT COUNT(id) as events_count FROM event 
    WHERE user_id = '" . $currentUSER . "' AND event_type='TASK' 
    AND YEAR(date_start) = '" . $year . "' AND MONTH(date_start) = '" . $month . "'  AND DAY(date_start) = '" . $day . "'";
    $result3 = mysqli_query($dw3_conn, $sql3);
    $data3= mysqli_fetch_assoc($result3);
    $events_count_tot = $data3['events_count'];
    $events_count_schedules = 0;
    
    $sql = "SELECT *
            FROM schedule_head 
            WHERE user_id = '" . $currentUSER . "' AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "'  AND DAY(start_date) = '" . $day . "'
            ORDER BY start_date";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        $events_count_schedules = 0;
        $lines_count_schedules = 0;
        while($row = $result->fetch_assoc()) {
            //count lines during the schedule
            $sql2 = "SELECT COUNT(id) as line_count FROM schedule_line 
            WHERE user_id = '" . $currentUSER . "' AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "' AND DAY(start_date) = DAY('" . $row['start_date'] . "')
            AND SUBSTR(start_date,12,5) >= SUBSTR('" . $row['start_date'] . "',12,5)
            AND SUBSTR(start_date,12,5) < SUBSTR('" . $row['end_date'] . "',12,5)";
            $result2 = mysqli_query($dw3_conn, $sql2);
            $data2 = mysqli_fetch_assoc($result2);
            $line_count = $data2['line_count'];
            $lines_count_schedules = $lines_count_schedules + $line_count;
            
            //count events during the schedule
            $sql3 = "SELECT COUNT(id) as events_count FROM event 
            WHERE user_id = '" . $currentUSER . "' AND event_type='TASK' 
            AND YEAR(date_start) = '" . $year . "' AND MONTH(date_start) = '" . $month . "'  AND DAY(date_start) = DAY('" . $row['start_date'] . "')
            AND SUBSTR(date_start,12,5) >= SUBSTR('" . $row['start_date'] . "',12,5)
            AND SUBSTR(date_start,12,5) < SUBSTR('" . $row['end_date'] . "',12,5)";
            $result3 = mysqli_query($dw3_conn, $sql3);
            $data3= mysqli_fetch_assoc($result3);
            $events_count = $data3['events_count'];
            $events_count_schedules = $events_count_schedules + $events_count;

            $html .= '{"head_id":"'. $row['id'] .'","user_id":"' . $row['user_id'] .'","block_size":"' . $row['block_size'] .'","start_date":"' .$row['start_date'] . '","end_date":"' .$row['end_date'] . '","line_count":"'.$data2["line_count"].'","events_count":"'.$data3["events_count"].'"},';

        }
    } else {

            //count lines
            $sql2 = "SELECT COUNT(id) as line_count FROM schedule_line 
            WHERE user_id = '" . $currentUSER . "' AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "' AND DAY(start_date) = '" . $day . "'";
            $result2 = mysqli_query($dw3_conn, $sql2);
            $data2 = mysqli_fetch_assoc($result2);
            $line_count = $data2['line_count'];
            $lines_count_schedules = $lines_count_schedules + $line_count;
            
            //count events
            $sql3 = "SELECT COUNT(id) as events_count FROM event 
            WHERE user_id = '" . $currentUSER . "' AND event_type='TASK' AND YEAR(date_start) = '" . $year . "' AND MONTH(date_start) = '" . $month . "'  AND DAY(date_start) = '" . $day . "'";
            $result3 = mysqli_query($dw3_conn, $sql3);
            $data3= mysqli_fetch_assoc($result3);
            $events_count = $data3['events_count'];
            $events_count_schedules = $events_count_schedules + $events_count;

            $html .= '{"head_id":"0","user_id":"","block_size":"","start_date":"' .$date . '","end_date":"' .$date . '","line_count":"'.$data2["line_count"].'","events_count":"'.$data3["events_count"].'"},';

    }
    //if there are lines or events without schedule, add a fake schedule head -1
    if ($line_count_tot > $lines_count_schedules || $events_count_tot > $events_count_schedules) {
        $lc_out = $line_count_tot - $lines_count_schedules; if ($lc_out < 0) { $lc_out = 0; }
        $ec_out = $events_count_tot - $events_count_schedules; if ($ec_out < 0) { $ec_out = 0; }
        $html .= '{"head_id":"-1","user_id":"","block_size":"","start_date":"' .$date . '","end_date":"' .$date . '","line_count":"'.$lc_out.'","events_count":"'.$ec_out.'"},';
    }

}


    /* $sql = "SELECT *
            FROM schedule_head 
            WHERE user_id = '" . $currentUSER . "' AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "' 
                OR user_id = '" . $currentUSER . "' AND YEAR(end_date) = '" . $year . "' AND MONTH(end_date) = '" . $month . "' 
            ORDER BY start_date";
    $result = $dw3_conn->query($sql);
    $html = "[ ";
    $xy=0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
            //count lines
            $sql2 = "SELECT COUNT(id) as line_count FROM schedule_line 
            WHERE user_id = '" . $currentUSER . "' AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "' AND DAY(start_date) = DAY('" . $row['start_date'] . "')
            AND SUBSTR(start_date,12,5) >= SUBSTR('" . $row['start_date'] . "',12,5)
            AND SUBSTR(start_date,12,5) < SUBSTR('" . $row['end_date'] . "',12,5)";
            $result2 = mysqli_query($dw3_conn, $sql2);
            $data2 = mysqli_fetch_assoc($result2);
            $line_count = $data2['line_count'];
            //error_log($sql2);
            
            //count events
            $sql3 = "SELECT COUNT(id) as events_count FROM event 
            WHERE user_id = '" . $currentUSER . "' AND event_type='TASK' 
            AND YEAR(date_start) = '" . $year . "' AND MONTH(date_start) = '" . $month . "'  AND DAY(date_start) = DAY('" . $row['start_date'] . "')
            AND SUBSTR(date_start,12,5) >= SUBSTR('" . $row['start_date'] . "',12,5)
            AND SUBSTR(date_start,12,5) < SUBSTR('" . $row['end_date'] . "',12,5)";
            $result3 = mysqli_query($dw3_conn, $sql3);
            $data3= mysqli_fetch_assoc($result3);
            $events_count = $data3['events_count'];

            $html .= '{"head_id":"'. $row['id'] .'","user_id":"' . $row['user_id'] .'","block_size":"' . $row['block_size'] .'","start_date":"' .$row['start_date'] . '","end_date":"' .$row['end_date'] . '","line_count":"'.$data2["line_count"].'","events_count":"'.$data3["events_count"].'"},';
            $xy = $xy + 1;
        }
    } */
    $html = substr($html,0,strlen($html)-1) . " ]";
    header(200);
    $dw3_conn->close();
    die($html);
?>
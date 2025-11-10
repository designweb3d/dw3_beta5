<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';

$suser_id  = mysqli_real_escape_string($dw3_conn, $_GET['U']);
$year  = mysqli_real_escape_string($dw3_conn, $_GET['Y']);
$month  = mysqli_real_escape_string($dw3_conn, $_GET['M']);
    $sql = "SELECT *
            FROM schedule_head
            WHERE YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "' and user_id = '".$suser_id."'
                OR  YEAR(end_date) = '" . $year . "' AND MONTH(end_date) = '" . $month . "' and user_id = '".$suser_id."'
            ORDER BY start_date";
    $result = $dw3_conn->query($sql);
    $html = "[ ";
    $xy=0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $html .= '{"head_id":"'. $row['id'] .'","user_id":"' . $row['user_id'] .'","block_size":"' . $row['block_size'] .'","start_date":"' .$row['start_date'] . '","end_date":"' .$row['end_date'] . '"},';
            $xy = $xy + 1;
        }
    }
    $html = substr($html,0,strlen($html)-1) . " ]";
    header(200);
    $dw3_conn->close();
    die($html);
?>
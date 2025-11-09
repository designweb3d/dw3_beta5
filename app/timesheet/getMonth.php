<?php

//use getHEAD instead of getMonth

require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$currentUSER = $_GET['USER_ID'];
$year  = mysqli_real_escape_string($dw3_conn, $_GET['Y']);
$month  = mysqli_real_escape_string($dw3_conn, $_GET['M']);
    $sql = "SELECT A.id as schedule_id, A.user_id as user_id,CONCAT(D.first_name, ' ',D.last_name) as user_name, A.customer_id, CONCAT(D.first_name, ' ',D.last_name) as customer_name, A.product_id, C.name_fr as product_name,C.price1 as product_price,C.service_length as service_length,C.inter_length as inter_length, A.start_date as start_date, A.end_date as end_date
            FROM schedule_line A
            LEFT JOIN customer B ON B.id = A.customer_id
            LEFT JOIN product C ON C.id = A.product_id
            LEFT JOIN user D ON C.id = A.user_id
            WHERE A.user_id = '" . $currentUSER . "' AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "' 
                OR A.user_id = '" . $currentUSER . "' AND YEAR(end_date) = '" . $year . "' AND MONTH(end_date) = '" . $month . "' 
            ORDER BY start_date";
    $result = $dw3_conn->query($sql);
    $html = "[ ";
    $xy=0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $html .= '{"schedule_id":"'. $row['schedule_id'] .'","user_id":"' . $row['user_id'] .'","user_name":"' . $row['user_name'] .'","customer_id":"' . $row['customer_id'] .'","customer_name":"' . $row['customer_name'] .'","product_id":"' .$row['product_id'] . '","product_name":"'. $row['product_name'] .'","product_price":"' . $row['product_price'] .'","service_length":"' . $row['service_length'] .'","inter_length":"' . $row['inter_length'] .'","start_date":"' .$row['start_date'] . '","end_date":"' .$row['end_date'] . '"},';
            $xy = $xy + 1;
        }
    }
    $html = substr($html,0,strlen($html)-1) . " ]";
    header(200);
    $dw3_conn->close();
    die($html);
?>
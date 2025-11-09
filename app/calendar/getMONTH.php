<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$year  = mysqli_real_escape_string($dw3_conn, $_GET['Y']);
$month  = mysqli_real_escape_string($dw3_conn, $_GET['M']);
$dspUser  = $_GET['DU'];
$dspCustomer  = $_GET['DC'];
$dspEvent  = $_GET['E'];
$dspEmail  = $_GET['A'];
$dspOrder  = $_GET['O'];
$dspSH  = $_GET['SH'];
$dspSL  = $_GET['SL'];
$dspTask  = $_GET['T']??'';
$dspNewCustomer   = $_GET['NC'];

if ($dspUser == ""){$dspUser = "ALL";}
if ($dspCustomer == ""){$dspCustomer = "ALL";}

$html = "[ ";

//event
if ($dspEvent=="true"){
    $sql = "SELECT A.id as event_id, A.user_id as user_id,CONCAT(D.first_name, ' ',D.last_name) as user_name,D.name as user_face,D.picture_url as user_pic,D.picture_type as user_pic_type, A.customer_id, CONCAT(D.first_name, ' ',D.last_name) as customer_name, A.date_start as date_start, A.end_date as end_date, A.name as event_name, A.event_type as event_type
            FROM event A
            LEFT JOIN customer B ON B.id = A.customer_id
            LEFT JOIN user D ON D.id = A.user_id WHERE 1 ";
            if ($dspCustomer != "ALL"){
                $sql .=  " AND A.customer_id IN (" . $dspCustomer . ") ";
            }
            if ($dspUser != "ALL"){
                $sql .=  " AND A.user_id IN (" . $dspUser . ") ";
            }
        $sql .=" AND YEAR(date_start) = '" . $year . "' AND MONTH(date_start) = '" . $month . "' ORDER BY date_start";
    $result = $dw3_conn->query($sql);

    $xy=0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $html .= '{"id":"'. $row['event_id'] .'","type":"event","user_id":"' . $row['user_id'] .'","user_pic":"' . $row['user_pic'] .'","user_pic_type":"' . $row['user_pic_type'] .'","user_face":"' . $row['user_face'] .'","customer_id":"' . $row['customer_id'] .'","customer_name":"","description":"","start_date":"' .$row['date_start'] . '","end_date":"' .$row['end_date'] . '"},';
            $xy = $xy + 1;
        }
    }
}
//email
/* if ($dspEmail=="true"){
    $sql = "SELECT * FROM email WHERE 1 ";
            if ($dspUser != "ALL"){
                $sql .=  " AND user_created IN (" . $dspUser . ") ";
            }
        $sql .=" AND YEAR(date_created) = '" . $year . "' AND MONTH(date_created) = '" . $month . "' ORDER BY date_created";
        //die($sql);
    $result = $dw3_conn->query($sql);

    $xy=0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $html .= '{"id":"'. $row['id'] .'","type":"email","user_id":"' . $row['user_created'] .'","user_pic":"","user_pic_type":"","user_face":"","customer_id":"","customer_name":"' . $row['head_from'] .'","description":"","start_date":"' .$row['date_created'] . '","end_date":"' .$row['date_created'] . '"},';
            $xy = $xy + 1;
        }
    }
} */

//order
if ($dspSL=="true"){
    $sql = "SELECT A.id as order_id, A.user_id as user_id,CONCAT(D.first_name, ' ',D.last_name) as user_name,D.name as user_face,D.picture_url as user_pic,D.picture_type as user_pic_type, A.customer_id, CONCAT(D.first_name, ' ',D.last_name) as customer_name,A.date_created as start_date, A.date_created as end_date
            FROM order_head A
            LEFT JOIN customer B ON B.id = A.customer_id
            LEFT JOIN user D ON D.id = A.user_id WHERE 1 ";
            if ($dspCustomer != "ALL"){
                $sql .=  " AND A.customer_id IN (" . $dspCustomer . ") ";
            }
            if ($dspUser != "ALL"){
                $sql .=  " AND A.user_id IN (" . $dspUser . ") ";
            }
        $sql .=" AND YEAR(A.date_created) = '" . $year . "' AND MONTH(A.date_created) = '" . $month . "' ORDER BY A.date_created";
    $result = $dw3_conn->query($sql);

    $xy=0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $html .= '{"id":"'. $row['order_id'] .'","type":"order","user_id":"' . $row['user_id'] .'","user_pic":"' . $row['user_pic'] .'","user_pic_type":"' . $row['user_pic_type'] .'","user_face":"' . $row['user_face'] .'","customer_id":"' . $row['customer_id'] .'","customer_name":"","description":"","start_date":"' .$row['start_date'] . '","end_date":"' .$row['end_date'] . '"},';
            $xy = $xy + 1;
        }
    }
}

//schedule_head
if ($dspSH=="true"){
    $sql = "SELECT A.id as schedule_id, A.user_id as user_id,CONCAT(D.first_name, ' ',D.last_name) as user_name,D.name as user_face,D.picture_url as user_pic,D.picture_type as user_pic_type, A.start_date as start_date, A.end_date as end_date
            FROM schedule_head A
            LEFT JOIN user D ON D.id = A.user_id WHERE 1 ";
            if ($dspUser != "ALL"){
                $sql .=  " AND A.user_id IN (" . $dspUser . ") ";
            }
        $sql .=" AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "' ORDER BY start_date";
    $result = $dw3_conn->query($sql);

    $xy=0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $html .= '{"id":"'. $row['schedule_id'] .'","type":"schedule_head","user_id":"' . $row['user_id'] .'","user_pic":"' . $row['user_pic'] .'","user_pic_type":"' . $row['user_pic_type'] .'","user_face":"' . $row['user_face'] .'","customer_id":"0","customer_name":"","description":"","start_date":"' .$row['start_date'] . '","end_date":"' .$row['end_date'] . '"},';
            $xy = $xy + 1;
        }
    }
}

//schedule_line
if ($dspSL=="true"){
    $sql = "SELECT A.id as schedule_id, A.user_id as user_id,CONCAT(D.first_name, ' ',D.last_name) as user_name,D.name as user_face,D.picture_url as user_pic,D.picture_type as user_pic_type, A.customer_id, CONCAT(D.first_name, ' ',D.last_name) as customer_name, A.product_id, C.name_fr as product_name,C.price1 as product_price,C.service_length as service_length,C.inter_length as inter_length, A.start_date as start_date, A.end_date as end_date
            FROM schedule_line A
            LEFT JOIN customer B ON B.id = A.customer_id
            LEFT JOIN product C ON C.id = A.product_id
            LEFT JOIN user D ON D.id = A.user_id WHERE 1 ";
            if ($dspCustomer != "ALL"){
                $sql .=  " AND A.customer_id IN (" . $dspCustomer . ") ";
            }
            if ($dspUser != "ALL"){
                $sql .=  " AND A.user_id IN (" . $dspUser . ") ";
            }
        $sql .=" AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "' ORDER BY start_date";
    $result = $dw3_conn->query($sql);

    $xy=0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $html .= '{"id":"'. $row['schedule_id'] .'","type":"schedule_line","user_id":"' . $row['user_id'] .'","user_pic":"' . $row['user_pic'] .'","user_pic_type":"' . $row['user_pic_type'] .'","user_face":"' . $row['user_face'] .'","customer_id":"' . $row['customer_id'] .'","customer_name":"","description":"","start_date":"' .$row['start_date'] . '","end_date":"' .$row['end_date'] . '"},';
            $xy = $xy + 1;
        }
    }
}

$html = substr($html,0,strlen($html)-1) . " ]";
header(200);
$dw3_conn->close();
die($html);?>
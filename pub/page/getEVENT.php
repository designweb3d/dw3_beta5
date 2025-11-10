<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$ID  = mysqli_real_escape_string($dw3_conn, $_GET['ID']);

    $sql = "SELECT *
            FROM event
            WHERE id='".$ID."' AND event_type = 'PUBLIC';";
    $result = $dw3_conn->query($sql);
    $html = "[ ";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $html .= '{"id":"'. $row['id'] .'","name_fr":"' . $row['name'] .'","name_en":"' . $row['name_en'] .'","description":"' . $row['description'] .'","description_en":"' . $row['description_en'] .'","href":"' . $row['href'] .'","date_start":"' .$row['date_start'] . '","end_date":"' .$row['end_date'] . '"},';
        }
    }
    $html = substr($html,0,strlen($html)-1) . " ]";
    header(200);
    $dw3_conn->close();
    die($html);
?>
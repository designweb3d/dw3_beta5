<?php
date_default_timezone_set('America/New_York');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8");
if ($dw3_conn->connect_error) {
    $dw3_conn->close();
    header("Location: https://" . $_SERVER["SERVER_NAME"] . "/");
    exit;
}

$year  = mysqli_real_escape_string($dw3_conn, $_GET['Y']);
$month  = mysqli_real_escape_string($dw3_conn, $_GET['M']);
    $sql = "SELECT *
            FROM event
            WHERE YEAR(date_start) = '" . $year . "' AND MONTH(date_start) = '" . $month . "' AND event_type = 'PUBLIC'
                OR  YEAR(end_date) = '" . $year . "' AND MONTH(end_date) = '" . $month . "'  AND event_type = 'PUBLIC'
            ORDER BY date_start";
    $result = $dw3_conn->query($sql);
    $html = "[ ";
    $xy=0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $html .= '{"id":"'. $row['id'] .'","name_fr":"' . $row['name'] .'","name_en":"' . $row['name_en'] .'","description":"' . $row['description'] .'","description_en":"' . $row['description_en'] .'","href":"' . $row['href'] .'","date_start":"' .$row['date_start'] . '","end_date":"' .$row['end_date'] . '"},';
            $xy = $xy + 1;
        }
    }
    $html = substr($html,0,strlen($html)-1) . " ]";
    header(200);
    $dw3_conn->close();
    die($html);
?>
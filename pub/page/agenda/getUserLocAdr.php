<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';

$user_id  = $_GET['UID'];
$location_id  = $_GET['LID'];

//$sql2 = "SELECT A.id, A.location_id, B.adr1 as adr1, B.adr2 as adr2, B.city as city, B.province as province, B.country as country, B.postal_code as postal_code FROM user A
if($location_id != "0"){
    $sql2 = "SELECT * FROM location WHERE id = '".$location_id."'";
} else {
    $sql2 = "SELECT A.id, A.location_id, B.adr1 as adr1, B.adr2 as adr2, B.city as city FROM user A
            LEFT JOIN (SELECT * FROM location) B ON A.location_id = B.id
            WHERE A.id = '".$user_id."';";
}
    $result2 = $dw3_conn->query($sql2);
    if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
            echo $row2["adr1"]." ".$row2["adr2"]." ".$row2["city"];
        }
    }
$dw3_conn->close();
?>
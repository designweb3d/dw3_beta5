<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php';  
$LOC = $_GET['ID'];
if ($USER_TYPE != "user" && $USER_TYPE != "user"){
    $sql = "UPDATE customer SET location_id = '" . $LOC . "' WHERE id = '" . $USER . "' LIMIT 1";
    if ($dw3_conn->query($sql) == TRUE) {
        echo "";
    } else {
        echo $dw3_conn->error;
    }
}
$dw3_conn->close();
?>
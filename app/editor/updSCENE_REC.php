<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SCENE_ID  = mysqli_real_escape_string($dw3_conn, $_GET['ID']);
$RECORD_NAME  = mysqli_real_escape_string($dw3_conn, $_GET['REC']);
$RECORD_VALUE = mysqli_real_escape_string($dw3_conn, $_GET['VAL']);
if ($SCENE_ID == "" || $RECORD_NAME == "") {
    $dw3_conn->close();
    die("Erreur de paramètres");
}   
$sql = "UPDATE scene SET " . $RECORD_NAME . " = '" . $RECORD_VALUE . "' WHERE id = '" . $SCENE_ID . "' LIMIT 1;";
if ($dw3_conn->query($sql) === TRUE) {
    //echo "";
} else {
    echo $dw3_conn->error; 
}
$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$NAME   = str_replace("'","’",$_GET['NAME']);
$TYPE  = $_GET['TYPE'];
$PRIORITY  = $_GET['PRIORITY'];
$DATE_START  = $_GET['DATE_START'];
$DATE_END  = $_GET['DATE_END'];

if ($TYPE == "TASK"){
    $status = "TO_DO";
} else {
    $status = "N/A";
}

//insert
	$sql = "INSERT INTO event
    (name,event_type,priority,date_start,end_date,status)
    VALUES 
        ('" . $NAME  . "',
         '" . $TYPE  . "',
         '" . $PRIORITY  . "',
         '" . $DATE_START . "',
         '" . $DATE_END  . "',
         '".$status."')";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
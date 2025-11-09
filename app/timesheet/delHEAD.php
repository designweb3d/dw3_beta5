<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID   = $_GET['ID'];
$confirmed_delete = $_GET['CF']??'0';

if ($confirmed_delete == "0") {
    //verify if schedule is repeated
    $sql = "SELECT * FROM schedule_head WHERE id = '" . $ID . "' LIMIT 1";
    $result = $dw3_conn->query($sql);  
    $data = $result->fetch_assoc();
    $schedule_parent = $data["parent_id"];

    if ($schedule_parent != 0) {
        echo "Err1";
        $dw3_conn->close();
        exit;
    }
}

	$sql = "DELETE FROM schedule_head
	 WHERE id = '" . $ID ."'
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
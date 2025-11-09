<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LST  = htmlspecialchars($_GET['LST']);
$rtID  = $_GET['ID'];

	$sql = "DELETE FROM road_user 
			WHERE road_id = '" . $rtID . "'
			AND user_id IN " . $LST;
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$PRJ = $_GET['PRJ'];
$CLI = $_GET['CLI'];
$BYPASS_ERR1 = $_GET['BP1'];

	//vérification du project_id actuel
	$sql = "SELECT project_id FROM event WHERE id = '" . $ID . "'  LIMIT 1";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['project_id'] == $PRJ) {
		$PRJ = "0";
	} else if ($data['project_id'] != "0" && $BYPASS_ERR1 == 'false') {
		$dw3_conn->close();
		die("ERR1");
	}


	$sql = "UPDATE event
     SET    
	 project_id   = '" . $PRJ . "',
	 customer_id   = '" . $CLI . "'
	 
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>

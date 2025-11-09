<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$DB     = $_GET['DB'];
$PRJ     = $_GET['PRJ'];
$BYPASS_ERR1 = $_GET['BP1'];

if ($DB == "order"){$DB ="order_head";}
if ($DB == "invoice"){$DB ="invoice_head";}
if ($DB == "purchase"){$DB ="purchase_head";}


	//vérification du project_id actuel
	$sql = "SELECT project_id FROM ".$DB." WHERE id = '" . $ID . "'  LIMIT 1";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['project_id'] == $PRJ) {
		$PRJ = "0";
	} else if ($data['project_id'] != "0" && $BYPASS_ERR1 == 'false') {
		$dw3_conn->close();
		die("ERR1");
	}


	$sql = "UPDATE ".$DB."
     SET    
	 project_id   = '" . $PRJ . "',
	 date_modified   = '" . $datetime   . "',
	 user_modified   = '" . $USER   . "'
	 
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>

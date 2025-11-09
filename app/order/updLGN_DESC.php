<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$DESC     = str_replace("'","’",$_GET['DESC']);

	$sql = "UPDATE order_line
     SET    
	 product_desc   = '" . $DESC  . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) { 
        $sqlx = "UPDATE order_head SET date_modified   = '" . $datetime   . "',	 user_modified   = '" . $USER   . "' WHERE id IN (SELECT head_id FROM order_line WHERE id = '" . $ID . "') LIMIT 1";
        $resultx = mysqli_query($dw3_conn, $sqlx);
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>

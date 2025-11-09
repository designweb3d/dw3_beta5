<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$PRICE     = $_GET['PRICE'];

//get qty data before update 
$sql = "SELECT * FROM order_line WHERE id = '" .  $ID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$lgQTE = $data["qty_order"];
$INVOICE_ID = $data["head_id"];

//get prd data before update 
$sql = "SELECT * FROM product WHERE id = (SELECT product_id FROM order_line WHERE id = '" .  $ID . "') LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

//update
	$sql = "UPDATE order_line SET    
	 price  = '" . $PRICE  . "'
	 WHERE id = '" . $ID . "' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
              $sqlx = "UPDATE order_head SET date_modified   = '" . $datetime   . "',	 user_modified   = '" . $USER   . "' WHERE id = '" .  $INVOICE_ID . "' LIMIT 1";
              $resultx = mysqli_query($dw3_conn, $sqlx);
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>

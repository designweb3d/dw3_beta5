<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$CHECKED     = $_GET['CHECKED'];

if ($CHECKED == "true"){
    $CHECKED = "1";
} else {
    $CHECKED = "0";
}

//get qty data before update 
$sql = "SELECT * FROM order_line WHERE id = '" .  $ID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$INVOICE_ID = $data["head_id"];

//update
	$sql = "UPDATE order_line SET    
	 product_renew  = '" . $CHECKED  . "'
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

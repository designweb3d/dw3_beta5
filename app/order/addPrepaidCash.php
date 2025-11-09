<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
//$AMOUNT    = mysqli_real_escape_string($dw3_conn,$_GET['AMOUNT']);
$AMOUNT    = round(mysqli_real_escape_string($dw3_conn,$_GET['AMOUNT']),2);
//data from head
$sql = "SELECT *
FROM order_head 
WHERE id = '" . $ID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_prepaid = round($data['prepaid_cash'],2);
$new_amount = round($head_prepaid+$AMOUNT,2);

	$sql = "UPDATE order_head
     SET    
	 prepaid_cash    = " . $new_amount    . ",
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

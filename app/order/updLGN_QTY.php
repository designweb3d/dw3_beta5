<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$QTE     = $_GET['QTE'];

//get price data before update 
$sql = "SELECT * FROM order_line WHERE id = '" .  $ID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$INVOICE_ID = $data["head_id"];
$product_id = $data["product_id"];
//$PRICE = $data["price"];

    //get customer id
    $sql = "SELECT customer_id FROM order_head WHERE id = '".$INVOICE_ID."'";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $customer_id = $data['customer_id'];
    //get price from getPRICE.php
    $product_qty = $QTE;
    require $_SERVER['DOCUMENT_ROOT'] . '/app/product/getPRICE.php';

	$sql = "UPDATE order_line SET    
	 qty_order   = '" . $QTE  . "', price = '".$product_price."'
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
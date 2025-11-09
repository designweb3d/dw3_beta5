<?php 
require_once 'security_db.php';
$invoice_id = $_GET['FCT']??NULL;
$cart_or_market = $_GET['FROM']??'';

//data from invoice
$sql = "SELECT * FROM invoice_head WHERE id = '" .  $invoice_id . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$paid = $data["paid_stripe"] + $data["paid_moneris"] + $data["paid_cash"] + $data["paid_paypal"];
$paid_amount = round($data["total"]-$paid,2);
$paypal_cost = round(($paid_amount*2.9)/100,2)+.3;

$sql = "INSERT INTO transaction (invoice_id,paid_amount,paid_amount_currency,payment_status,payment_type,created,modified) 
VALUES('" . $invoice_id . "','" . $paid_amount . "','CAD','succeeded','Paypal','".$datetime."','".$datetime."')";
$result = mysqli_query($dw3_conn, $sql);

$sql = "UPDATE invoice_head SET stat='2', paid_paypal = '" . $paid_amount . "',transaction_cost = '".$paypal_cost."', date_modified = '" . $datetime . "' WHERE id = '" . $invoice_id  . "' LIMIT 1;";
$result = mysqli_query($dw3_conn, $sql);

header("HTTP/1.1 303 See Other");
header("Location: dashboard.php?KEY=". $KEY. "&PAYPAL_RESULT=success&FCT=".$invoice_id."&PAYPAL_FROM=".$cart_or_market);
?>
<?php 
$invoice_id = $_GET['FCT']??NULL;
$cart_or_market = $_GET['FROM']??'';
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 

//$payload = @file_get_contents('php://input');
//error_log("SQUARE_HOOK: ".$payload );

//try {
    //$event = json_decode($payload, true);
/* } catch {
    // Invalid payload
    //$dw3_conn->close();
    //http_response_code(400);
    //error_log("\n" . "Invalid payload:". $log);
    //exit();
} */

/* if (isset($event->data->object->payment->status)){
    $status = $event->data->object->payment->status;
} else {
    $status = "failed";
} */
sleep(2);

    $sql = "SELECT * FROM transaction WHERE invoice_id = '" .  $invoice_id . "' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
if (isset($data["id"])){
    $status = $data["payment_status"];
    if ($status == "success" || $status == "succeeded") {
        //data from transaction

    /*     $session_id= $data["stripe_checkout_session_id"];
        $paid = $data["paid_stripe"] + $data["paid_moneris"] + $data["paid_cash"] + $data["paid_paypal"];
        $to_pay = round($data["total"]-$paid,2);
        $square_cost = round(($to_pay*2.9)/100,2)+.3;

        $sql = "INSERT INTO transaction (invoice_id,paid_amount,payment_status,paid_amount_currency,payment_type,created,modified) VALUES('" . $invoice_id . "','" . $to_pay . "','success','CAD','Square','".$datetime."','".$datetime."')";
        $result = mysqli_query($dw3_conn, $sql);

        $sql = "UPDATE invoice_head SET paid_stripe = '" . $to_pay . "',transaction_cost = '".$square_cost."', date_modified = '" . $datetime . "' WHERE id = '" . $invoice_id  . "' ";
        $result = mysqli_query($dw3_conn, $sql); */

        header("HTTP/1.1 303 See Other");
        header("Location: dashboard.php?KEY=". $KEY. "&SQUARE_RESULT=success&FCT=".$invoice_id."&SQUARE_FROM=".$cart_or_market);
    } else {
        header("HTTP/1.1 303 See Other");
        header("Location: dashboard.php?KEY=". $KEY. "&SQUARE_RESULT=".$status); 
    }
} else {
        header("HTTP/1.1 303 See Other");
        header("Location: dashboard.php?KEY=". $KEY. "&SQUARE_RESULT=error");
}
?>
<?php  
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
if ($CIE_STRIPE_MODE == "" || $CIE_STRIPE_MODE == "DEV"){
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_TKEY);
} else if ($CIE_STRIPE_MODE == "PROD"){
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
}
$invoice_id = $_GET['FCT']??NULL;

//data from invoice
$sql = "SELECT * FROM invoice_head WHERE id = '" . $invoice_id . "' ;";
//die($sql);
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$customer_id = $data["customer_id"];
$paid = $data["paid_stripe"] + $data["paid_moneris"] + $data["paid_cash"] + $data["paid_paypal"];
$to_pay = round($data["total"]-$paid,2);
$invoice_name = "Facture #" . $invoice_id;
//data from customer
$sql = "SELECT * FROM customer WHERE id = '" .  $customer_id . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$stripe_customer_id= $data["stripe_id"];

$checkout_session = $stripe->checkout->sessions->create([
  'line_items' => [[
    'price_data' => [
      'currency' => 'cad',
      'product_data' => [
        'name' => $invoice_name,
      ],
      'unit_amount' => number_format($to_pay,2,'',''),
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'customer' => $stripe_customer_id,
  'success_url' => 'https://' . $_SERVER["SERVER_NAME"] . '/client/stripe-success.php?KEY='. $KEY. '&FCT='. $invoice_id.'&FROM=cart',
  'cancel_url' => 'https://' . $_SERVER["SERVER_NAME"] . '/client/stripe-cancel.php',
]);
$new_stripe_id = $checkout_session->id;
$new_stripe_status = $checkout_session->payment_status;
//updater la commande dans le systeme avec checkout session id
//data from customer
$sql = "INSERT INTO transaction (invoice_id,stripe_checkout_session_id,payment_status,payment_type,created,modified) VALUES('" . $invoice_id . "','" .  $new_stripe_id . "','" .  $new_stripe_status . "','Stripe','".$datetime."','".$datetime."')";
$result = mysqli_query($dw3_conn, $sql);
$sql = "UPDATE invoice_head SET stripe_checkout_session_id ='" .  $new_stripe_id . "' WHERE id = '" . $invoice_id  . "'";
$result = mysqli_query($dw3_conn, $sql);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
?>
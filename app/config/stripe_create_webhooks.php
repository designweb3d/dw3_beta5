<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

if ($CIE_STRIPE_KEY != ""){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
    if ($CIE_STRIPE_MODE == "" || $CIE_STRIPE_MODE == "DEV"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_TKEY);
    } else if ($CIE_STRIPE_MODE == "PROD"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
    }
}else {
    $dw3_conn->close();
    die("No Stripe Key");
}

$webhookEndpoints = $stripe->webhookEndpoints->all(['limit' => 3]);
$webhooks_count = count($webhookEndpoints->data);
if ($webhooks_count > 0){
    $dw3_conn->close();
    die("Webhooks already created.");
}

$webhookEndpoint = $stripe->webhookEndpoints->create([
  'enabled_events' => [
    'checkout.session.completed', 
    'invoice.upcoming', 
    'invoice.created', 
    'invoice.payment_succeeded', 
    'invoice.payment_failed', 
    'cash_balance.funds_available', 
    'payout.paid'
],
  'url' => 'https://'.$_SERVER['SERVER_NAME'].'/api/callbacks/stripe_cb.php',
]);
echo "Webhooks created: " . $webhookEndpoint->id;
$dw3_conn->close();
?>
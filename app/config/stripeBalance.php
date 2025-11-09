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
$balance = $stripe->balance->retrieve([]);
echo "Disponible: " . round($balance->available[0]->amount/100, 2) . "$<br>À venir: " . round($balance->pending[0]->amount/100, 2) . "$";
$dw3_conn->close();
?>
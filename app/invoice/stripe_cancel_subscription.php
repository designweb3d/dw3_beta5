<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$order_id     = $_GET['orderID'];

if ($CIE_STRIPE_KEY != ""){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
    if ($CIE_STRIPE_MODE == "" || $CIE_STRIPE_MODE == "DEV"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_TKEY);
    } else if ($CIE_STRIPE_MODE == "PROD"){
        $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
    }
}else {
    echo "No Stripe Key";
}

	$sql = "UPDATE order_head SET subscription_stat = 'canceled' WHERE id = '" . $order_id . "' LIMIT 1";
    $dw3_conn->query($sql);
	$sql = "UPDATE invoice_head SET subscription_stat = 'canceled' WHERE order_id = '" . $order_id . "';";
	$dw3_conn->query($sql);

    $sql = "SELECT * FROM order_head WHERE id = '" . $order_id . "' LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);

    if ($data["subscription_id"] != ""){
        try {
            $stripe_result = $stripe->subscriptions->cancel(
                $data["subscription_id"],
                []
            );
            //echo "Subscription canceled: " . $stripe_result->id;
        } catch (Exception $e) {
            echo 'Error canceling subscription: ' . $e->getMessage();
        }
    } else {
        echo "No subscription ID found for this order.";
    }

$dw3_conn->close();
?>
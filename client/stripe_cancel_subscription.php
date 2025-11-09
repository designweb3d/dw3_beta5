<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');

$invoice_id     = $_GET['INVOICE_ID'];
$reason         = $_GET['REASON'];
$comment         = $_GET['COMMENT'];

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

    $sql = "SELECT A.*, B.subscription_id as subscription_id
    FROM invoice_head A
    LEFT JOIN order_head B ON A.order_id = B.id
    WHERE A.id = '" . $invoice_id . "' LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $order_id = $data["order_id"];

	$sql = "UPDATE order_head SET subscription_stat = 'canceled' WHERE id = '" . $order_id . "' LIMIT 1";
    $dw3_conn->query($sql);
	$sql = "UPDATE invoice_head SET subscription_stat = 'canceled', cancel_reason = '" . $reason . "' WHERE order_id = '" . $order_id . "';";
	$dw3_conn->query($sql);

    if ($data["subscription_id"] != ""){
        try {
            $stripe_result = $stripe->subscriptions->cancel(
                $data["subscription_id"],
                ['cancellation_details' => ['feedback' => $reason]]
            );
            //echo "Subscription canceled: " . $stripe_result->id;
        } catch (Exception $e) {
            //echo 'Error canceling subscription: ' . $e->getMessage();
        }
    } else {
        //echo "No subscription ID found for this order.";
    }

 $subject = "Annulation d’abonnement Commande #". $order_id;
    $mainMessage = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
    <body><h4>Annulation d’abonnement Commande #'. $order_id .'</h4>';
    $mainMessage .= 'Le client #'.$data["customer_id"].' a annulé son abonnement.<br><br>Nom du client : '.dw3_decrypt($data["name"]).'<br>Raison d’annulation : ' . $reason . '<br>Commentaire : ' . $comment . '<br>';
    $mainMessage .= ' </table></body></html>';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $email = new PHPMailer();
    $email->CharSet = "UTF-8";
    $email->SetFrom("no-reply@".$_SERVER["SERVER_NAME"]);
    $email->Subject   = $subject;
    $email->Body      = $mainMessage;
    $email->IsHTML(true); 
    if (trim($CIE_EML3) == ""){
        $email->AddAddress($CIE_EML1);
    } else {
        $email->AddAddress($CIE_EML3);
    }
    $mail_ret = $email->Send();

    if ($mail_ret == 1) {
        echo "";
    } else {
        //echo $mail_ret;
    }

$dw3_conn->close();
?>
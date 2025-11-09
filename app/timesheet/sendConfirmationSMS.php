<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$sid = $_GET['sid'];

$phone = "15147422894";
$message = "Veuillez confirmer votre RDV le .. en répondant OUI ou par NON pour l'annuler. Merci.";

$data = array(
    "message"=>$message,
    "to"=>$phone,
    "bypass_optout"=>true,
    "sender_id"=>$CIE_SMS_SENDER,
    "callback_url"=>"https://".$_SERVER['SERVER_NAME']."/api/callbacks/sms_cb_out.php"
);
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => "https://api.sms.to/sms/send",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS => json_encode($data),
CURLOPT_HTTPHEADER => array(
"Authorization: Bearer ".$CIE_SMS_KEY,
"Content-Type: application/json"
),
));

$response = curl_exec($curl);

curl_close($curl);
$dw3_conn->close();
die ($response);
//DW3 - Your activation code is 973423 and will expire in 20 minutes.
//or
//DW3- Delivery status changed. Log-In to trace your package.
//To stop receiving these messages awnser StopSMS or click here
?>
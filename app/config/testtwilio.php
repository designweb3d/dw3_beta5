<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/twilio/autoload.php';
use Twilio\Rest\Client;

$sid    = $CIE_TWILIO_SID;
$token  = $CIE_TWILIO_AUTH;
$twilio = new Client($sid, $token);

$message = $twilio->messages
  ->create("+15147422894", // to
    array(
      "from" => "+".$CIE_TWILIO_SENDER,
      "body" => "Your Message"
    )
  );

print($message->sid);
exit();
?>
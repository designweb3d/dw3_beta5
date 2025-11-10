<?php
//require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/twilio/autoload.php';
use Twilio\TwiML\MessagingResponse;
$response = new MessagingResponse();

if(isset($_POST['From']) && isset($_POST['Body'])) {
    if(trim(strtoupper($_POST['Body']))=="START") {
        //no reply
    } else {
        if(trim(strtoupper($_POST['Body']))=="STATUS") {
            $response->message("L'état du dossier est:");
        } else {
            $response->message("Veuillez communiquer avec nous au 514-742-2894 ou visitez le https://dw3.ca");
        }
        print $response;
    }
} else {
    //no reply
}
exit();
?>
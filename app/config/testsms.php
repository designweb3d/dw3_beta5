<?php
// 2-WAY # 18332718776
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

function grs($length = 6) {
    $characters = '123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.sms.to/sms/send',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "message": "This is your activation code: ' . grs() . ' \n dw3.ca/dashboard/dashboard.php",
    "to": "15147422894",
    "bypass_optout": false,
    "sender_id": "18332718776",
    "callback_url": "https://dw3.ca/sbin/sms_callback.php"
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer ',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://auth.sms.to/api/balance',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer ',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
$dw3_conn->close();
die($response);
?>
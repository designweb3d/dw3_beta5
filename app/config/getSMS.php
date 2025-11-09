<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sms.to/v1/recent/inbound-sms',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$CIE_SMS_KEY,
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
//$output = "Recent SMS: " . implode(",", $response);
$output = "Recent SMS: " . $response;
curl_close($curl);
//$str = "";
//if ($response != ""){
    //if (count($response)>0){$str = implode(",", $response);}
//}
//error_log("Recent SMS: " . $str);
//error_log("Recent SMS: " . json_decode($response));
error_log($output);
header('Status: 200');
die($output);
?>
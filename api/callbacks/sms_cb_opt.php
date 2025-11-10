<?php
date_default_timezone_set('America/New_York');
$datetime = date("Y-m-d H:i:s");  
$headers = apache_request_headers();

$log="sms.to OPTOUT \n";
foreach ($headers as $header => $value) {
    $log .= "$header: $value \n";
}

if(!empty($_POST))
{
    $log .= "POST: " . implode(",", $_POST);
}

error_log($log . " \n");
header('Status: 200');
?>
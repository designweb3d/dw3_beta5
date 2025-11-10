<?php
date_default_timezone_set('America/New_York');
$datetime = date("Y-m-d H:i:s");  
error_log("sms.to OUTBOUND ");
//$url_components = parse_url($_SERVER['REQUEST_URI']);
//parse_str($url_components['query'], $params);
//error_log(count($_GET[]));
$headers = apache_request_headers();
$log="";
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
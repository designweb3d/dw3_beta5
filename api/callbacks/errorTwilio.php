<?php
$payload = @file_get_contents('php://input');
$log=trim(preg_replace('/\s+/', ' ', $payload));
/* foreach ($payload as $header => $value) {
    $log .= "$header: $value, ";
} */
$remote_ip = $_SERVER['REMOTE_ADDR'];
$dw3_conn->close();
http_response_code(200);
error_log($log);
exit(); 
?>
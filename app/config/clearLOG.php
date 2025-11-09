<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$LOG_DIR = mysqli_real_escape_string($dw3_conn, $_GET['L']);
if ($LOG_DIR == 'root'){
    $file_pointer = $_SERVER['DOCUMENT_ROOT']."/error_log";
}else{
    $file_pointer = $_SERVER['DOCUMENT_ROOT']."/" .$LOG_DIR. "/error_log";
}
if (!unlink($file_pointer)) {
    echo ("$file_pointer cannot be deleted due to an error");
}
else {
    echo ("$file_pointer has been deleted");
}
$dw3_conn->close(); 
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$fn = $_GET['fn'];
$from_path  = $_SERVER['DOCUMENT_ROOT'] . '/pub/font_lib/';
$to_path  = $_SERVER['DOCUMENT_ROOT'] . '/pub/font/';

copy($from_path . $fn, $to_path . $fn);
if (file_exists($to_path . $fn)) {
    die("OK");
} else {
    die("NOK");
}
$dw3_conn->close();
?>
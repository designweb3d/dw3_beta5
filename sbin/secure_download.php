<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$dw3_conn->close();
$fn = $_GET['fn'];
$attachment_location = $_SERVER["DOCUMENT_ROOT"] . $fn;
if (file_exists($attachment_location)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
    header("Cache-Control: public"); // needed for internet explorer
    header("Content-Type: application/octet-stream");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length:".filesize($attachment_location));
    header("Content-Disposition: attachment; filename=".basename($fn));
    readfile($attachment_location);
    die();        
} else {
    die("Error: File not found.");
} 
?>
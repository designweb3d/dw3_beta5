<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/pub/upload/";
$fn  = $_GET['fn']??'';
if (trim($fn)==""){
    $dw3_conn->close();
    die ("Error");
}
$ret = unlink($target_dir . $fn );
$dw3_conn->close();
die ($ret);
?>
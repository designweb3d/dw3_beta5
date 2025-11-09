<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$fn  = $_GET['fn']??'';
$DIR  = $_GET['d'];

if ($DIR == "img"){
    $sys_dir = "/pub/img/";
} else if ($DIR == "upload"){
    $sys_dir = "/pub/upload/";
} else if ($DIR == "font"){
    $sys_dir = "/pub/font/"; 
}
$target_dir = $_SERVER['DOCUMENT_ROOT'] . $sys_dir;

if (trim($fn)==""){
    $dw3_conn->close();
    die ("Error");
}
$ret = unlink($target_dir . $fn );
$dw3_conn->close();
die ($ret);
?>
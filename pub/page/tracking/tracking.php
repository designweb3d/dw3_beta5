<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
$tracking_number = $_GET['TRN']??0;
echo $tracking_number;


?>
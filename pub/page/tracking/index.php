<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
$tracking_number = $_GET['TRN']??"";
if ($tracking_number != "") {
    $dw3_conn->close(); 
    header("Location: /pub/page/tracking/tracking.php?TRN=" . $tracking_number); 
    exit();
} 

echo "Enter tracking number: ";

$dw3_conn->close();
?>
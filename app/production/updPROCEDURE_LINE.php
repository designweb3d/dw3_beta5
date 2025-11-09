<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID             = $_GET['ID'];
$PRD             = $_GET['PRD'];
$QTY  			= $_GET['QTY'];

     $sql = "UPDATE procedure_line SET    
	 product_id = '" . $PRD . "',
	 qty_by_unit = '" . $QTY . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";

    if ($dw3_conn->query($sql) === TRUE) {
        echo "";
	} else {
	    echo $dw3_conn->error;
	}
$dw3_conn->close();
die();
?>
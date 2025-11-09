<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID             = $_GET['ID'];
$PRD             = $_GET['PRD'];
$SUPPLY          = $_GET['SUPPLY'];
$DELAY           = $_GET['DELAY'];
$Q1              = str_replace("'","’",$_GET['Q1']);
$Q2              = str_replace("'","’",$_GET['Q2']);
$Q3              = str_replace("'","’",$_GET['Q3']);
$Q4              = str_replace("'","’",$_GET['Q4']);
$NOM  			= str_replace("'","’",$_GET['NOM']);

     $sql = "UPDATE procedure_head SET    
	 name_fr = '" . $NOM . "',
	 product_id = '" . $PRD . "',
	 supply_id = '" . $SUPPLY . "',
	 delay_by_unit = '" . $DELAY . "',
	 quality_v1_desc = '" . $Q1 . "',
	 quality_v2_desc = '" . $Q2 . "',
	 quality_v3_desc = '" . $Q3 . "',
	 quality_v4_desc = '" . $Q4 . "'
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
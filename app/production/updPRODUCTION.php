<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID             = $_GET['ID'];
$QTY_NEEDED          = $_GET['QTY_NEEDED'];
$QTY_PRODUCED           = $_GET['QTY_PRODUCED'];
$LOT              = str_replace("'","’",$_GET['LOT']);
$ORDER              = $_GET['ORDER'];
$STORAGE              = $_GET['STORAGE'];
$QUALITY_1              = str_replace("'","’",$_GET['QUALITY_1']);
$QUALITY_2              = str_replace("'","’",$_GET['QUALITY_2']);
$QUALITY_3              = str_replace("'","’",$_GET['QUALITY_3']);
$QUALITY_4              = str_replace("'","’",$_GET['QUALITY_4']);
$START  			= str_replace("'","’",$_GET['START']);
$END  			= str_replace("'","’",$_GET['END']);

     $sql = "UPDATE production SET    
	 qty_needed = '" . $QTY_NEEDED . "',
	 qty_produced = '" . $QTY_PRODUCED . "',
	 lot_no = '" . $LOT . "',
	 order_id = '" . $ORDER . "',
	 storage_id = '" . $STORAGE . "',
	 quality_val1 = '" . $QUALITY_1 . "',
	 quality_val2 = '" . $QUALITY_2 . "',
	 quality_val3 = '" . $QUALITY_3 . "',
	 quality_val4 = '" . $QUALITY_4 . "',
	 date_start = '" . $START . "',
	 date_end = '" . $END . "'
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
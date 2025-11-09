<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$option_id   = $_GET['OPT'];

	$sql = "DELETE FROM product_option WHERE id = '" . $option_id ."' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  	$sql = "DELETE FROM product_option_line WHERE option_id = '" . $option_id ."';";
    	if ($dw3_conn->query($sql) === TRUE) {
	    //echo $ID;
        } else {
            echo "Erreur: " . $dw3_conn->error;
        }
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
exit();
?>
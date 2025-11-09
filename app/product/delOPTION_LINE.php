<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$line_id   = $_GET['LNG'];

	  	$sql = "DELETE FROM product_option_line WHERE id = '" . $line_id ."';";
    	if ($dw3_conn->query($sql) === TRUE) {
	    //echo $ID;
        } else {
            echo "Erreur: " . $dw3_conn->error;
        }

$dw3_conn->close();
exit();
?>
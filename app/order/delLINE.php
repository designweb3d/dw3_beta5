<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$lgID   = $_GET['ID'];

if ($lgID == "") {
	die ("Erreur ligne de produit inconnue.");
}

	$sql = "DELETE FROM order_line WHERE id = '" . $lgID ."' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	    $sqlx = "DELETE FROM order_option WHERE line_id = '" . $lgID ."'";
        $resultx = mysqli_query($dw3_conn, $sqlx);
	    $sqly = "UPDATE order_head SET date_modified   = '" . $datetime   . "',	 user_modified   = '" . $USER   . "' WHERE id IN (SELECT head_id FROM order_line WHERE id = '" . $lgID . "') LIMIT 1";
        $resulty = mysqli_query($dw3_conn, $sqly);
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$CODE   = $_GET['CODE'];
if ($CODE == "") {
	die ("Erreur inconnue.");
}
$sql = "SELECT * FROM gls
WHERE gl_code = '" . $CODE . "' ";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    $dw3_conn->close();
    die("Ce code est utilisé, par conséquent ne peut être effacé.");
}
	$sql = "DELETE FROM gl
	 WHERE code = '" . $CODE ."'
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
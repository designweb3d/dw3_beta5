<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID   = $_GET['ID'];

if ($ID == "") {
	die ("Erreur: # de ligne de procédure invalide.");
}

    $sql = "DELETE FROM procedure_line WHERE id = '" . $ID ."'; ";
    $dw3_conn->query($sql);

$dw3_conn->close();
exit();
?>
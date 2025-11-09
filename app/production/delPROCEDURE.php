<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID   = $_GET['ID'];

if ($ID == "") {
	die ("Erreur: # de procédure invalide.");
}
//VERIFICATIONS
$sql = "SELECT COUNT(id) as rowCount FROM production WHERE procedure_id = " . $ID;
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if ($data['rowCount'] >= "1") {
    die ("Erreur: Ne peut être supprimée après avoir été placée en production.");
}

$sql = "DELETE FROM procedure_head WHERE id = '" . $ID ."' LIMIT 1";
if ($dw3_conn->query($sql) === TRUE) {
    $sql = "DELETE FROM procedure_line WHERE procedure_id = '" . $ID ."'; ";
    $dw3_conn->query($sql);
    echo "";
} else {
    echo "Erreur: " . $dw3_conn->error;
}

$dw3_conn->close();
exit();
?>
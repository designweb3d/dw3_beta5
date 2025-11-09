<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID   = $_GET['ID'];

if ($ID == "") {
	die ("Erreur: # de production invalide.");
}
//VERIFICATIONS
$sql = "SELECT * FROM production WHERE id = " . $ID;
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if ($data['status'] != "TO_DO") {
    die ("Erreur: Seul le status peut être modifié après avoir été placé en production.");
}

$sql = "DELETE FROM production WHERE id = '" . $ID ."' LIMIT 1";
if ($dw3_conn->query($sql) === TRUE) {
    echo "";
} else {
    echo "Erreur: " . $dw3_conn->error;
}

$dw3_conn->close();
exit();
?>
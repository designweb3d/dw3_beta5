<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$sql = "SELECT IFNULL(MAX(sort_number),0) AS last_sn FROM realisation;";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$next_sn = $data["last_sn"]+1;

	$sql = "INSERT INTO `realisation` (`id`,`sort_number`) VALUES (NULL,".$next_sn.");";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
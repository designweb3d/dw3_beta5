<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
	$sql = "INSERT INTO `storage` (`id`) VALUES (NULL);";
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        echo $inserted_id;
	}
$dw3_conn->close();
?>
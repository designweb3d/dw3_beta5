<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$usID   = $_GET['usID'];
$appID   = $_GET['appID'];
$isChecked = $_GET['isChecked'];
if ($isChecked == 'true') { $isChecked = true; } else { $isChecked = false; }

	$sql = "UPDATE app_user SET read_only = '" . ($isChecked ? 1 : 0) . "' WHERE user_id = '" . $usID   . "' AND app_id = '" . $appID  . "' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
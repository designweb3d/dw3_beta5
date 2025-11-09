<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$LST  = htmlspecialchars($_GET['LST']);
$LSTA = explode(",",str_replace("(", "",str_replace(")", "",$LST)));

//DELETE BDCLNT	
	$sql = "DELETE FROM event 
			WHERE id IN " . $LST;
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  //echo $sql . " " . $dw3_conn->error;
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>

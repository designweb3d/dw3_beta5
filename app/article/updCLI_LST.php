<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$LST  = htmlspecialchars($_GET['LST']);
$LSTA = explode(",",str_replace("(", "",str_replace(")", "",$LST)));
die $LSTA;
	$sql = "UPDATE customer SET news_stat = 0 WHERE id NOT IN " . $LST;
	if ($dw3_conn->query($sql) === TRUE) {
        $sql2 = "UPDATE customer SET news_stat = 1 WHERE id IN " . $LST;
        if ($dw3_conn->query($sql2) === TRUE) {
          echo "";
        }
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>

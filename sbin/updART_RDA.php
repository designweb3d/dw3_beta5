<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$article_id   = $_GET['A'];
$minutes   = $_GET['M'];

if ($minutes == "0"){
    $dw3_conn->close();
    exit;
}

//insert
	$sql = "INSERT INTO article_readings (article_id,minuts) VALUES ('".$article_id."','".$minutes."') ";
	if ($dw3_conn->query($sql) === TRUE) {
        //done
	}
$dw3_conn->close();
exit;
?>
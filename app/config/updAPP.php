<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$appID    = $_GET['ID'];
$AUTH    = $_GET['AUTH'];
$NAME_FR   = str_replace("'","’",$_GET['NAME_FR']);
$NAME_EN    = str_replace("'","’",$_GET['NAME_EN']);
$SORT    = $_GET['SORT'];
$ICON    = $_GET['ICON'];
$COLOR    = $_GET['COLOR'];

$sql = "UPDATE app SET    
auth = '" . $AUTH . "',
name_fr = '" . $NAME_FR . "',
name_en = '" . $NAME_EN . "',
sort_number = '" . $SORT . "',
icon = '" . $ICON . "',
color = '" . $COLOR . "'
WHERE id = '" . $appID . "' LIMIT 1;";
	if ($dw3_conn->query($sql) === TRUE) {
        header('Status: 200');
	    echo ""; 
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$ORDER   = mysqli_real_escape_string($dw3_conn,$_GET['ORDER']);
$TITLE_FR   = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['TITLE_FR']));
$TITLE_EN   = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['TITLE_EN']));
$FR = mysqli_real_escape_string($dw3_conn,$_GET['FR']);
$EN = mysqli_real_escape_string($dw3_conn,$_GET['EN']);

	$sql = "UPDATE index_line
     SET    
	 title_fr  = '" . $TITLE_FR   . "',
	 title_en  = '" . $TITLE_EN   . "',
	 sort_order  = '" . $ORDER   . "',
	 html_fr= '" . $FR . "',
	 html_en= '" . $EN . "'
	 WHERE id = '" . $ID . "'";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo $dw3_conn->error;
	}

    $dw3_conn->close();
    die(""); 

?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID = $_GET['ID'];
$KIND  = mysqli_real_escape_string($dw3_conn,$_GET['K']);
$YEAR  = mysqli_real_escape_string($dw3_conn,$_GET['YR']);
$PERIOD  = mysqli_real_escape_string($dw3_conn,$_GET['PER']);
$AMOUNT  = mysqli_real_escape_string($dw3_conn,$_GET['MNT']);
$GL_CODE  = mysqli_real_escape_string($dw3_conn,$_GET['GL']);
$SOURCE  = mysqli_real_escape_string($dw3_conn,$_GET['SOURCE']);
$CUSTOMER_ID  = mysqli_real_escape_string($dw3_conn,$_GET['CLI']);
$SUPPLIER_ID  = mysqli_real_escape_string($dw3_conn,$_GET['SUP']);
$USER_ID  = mysqli_real_escape_string($dw3_conn,$_GET['USR']);
$DOCUMENT  = mysqli_real_escape_string($dw3_conn,$_GET['DOC']);

//insert
	$sql = "UPDATE gls SET kind='" . $KIND  . "', year='" . $YEAR  . "',period='" . $PERIOD  . "',amount='" . $AMOUNT  . "',gl_code='" . $GL_CODE  . "',source='" . $SOURCE  . "',customer_id='" . $CUSTOMER_ID  . "',supplier_id='" . $SUPPLIER_ID  . "',user_id='" . $USER_ID  . "',document='" . $DOCUMENT  . "' WHERE id='" . $ID . "' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
        echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
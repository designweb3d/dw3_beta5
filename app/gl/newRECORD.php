<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
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
	$sql = "INSERT INTO gls
    (kind,year,period,amount,gl_code,source,customer_id,supplier_id,user_id,document,date_created)
    VALUES 
        ('" . $KIND  . "',
         '" . $YEAR  . "',
         '" . $PERIOD  . "',
         '" . $AMOUNT  . "',
         '" . $GL_CODE  . "',
         '" . $SOURCE  . "',
         '" . $CUSTOMER_ID  . "',
         '" . $SUPPLIER_ID  . "',
         '" . $USER_ID  . "',
         '" . $DOCUMENT  . "',
         '" . $datetime  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        //echo $inserted_id;
        echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

$dw3_conn->close();
?>
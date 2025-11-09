<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$GENR	= mysqli_real_escape_string($dw3_conn,$_GET['GENR']);
$CODE  = mysqli_real_escape_string($dw3_conn,$_GET['CODE']);
$DSC1  = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['DSC1']));
$DSC2  = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['DSC2']));
$DSC3  = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['DSC3']));
$DSC4  = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['DSC4']));

	$sql = "UPDATE config SET text1 = '" . $DSC1  . "', text2 = '" . $DSC2  . "' , text3 = '" . $DSC3  . "' , text4 = '" . $DSC4  . "' 
    WHERE kind = '" . $GENR  . "' AND code = '" . $CODE  . "';";
	if ($dw3_conn->query($sql) === TRUE) {
	    echo $GENR  . "/" . $CODE  . " " . $dw3_lbl["MODIFIED"];
	} else {
	    echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
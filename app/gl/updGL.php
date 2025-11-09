<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$OLD_CODE  = mysqli_real_escape_string($dw3_conn,$_GET['OLD_CODE']);
$NEW_CODE  = mysqli_real_escape_string($dw3_conn,$_GET['NEW_CODE']);
$KIND  = mysqli_real_escape_string($dw3_conn,$_GET['KIND']);
$NAME_FR  = mysqli_real_escape_string($dw3_conn,$_GET['NAME_FR']);
$NAME_EN  = mysqli_real_escape_string($dw3_conn,$_GET['NAME_EN']);
$DESC_FR  = mysqli_real_escape_string($dw3_conn,$_GET['DESC_FR']);
$DESC_EN  = mysqli_real_escape_string($dw3_conn,$_GET['DESC_EN']);

if ($NEW_CODE != $OLD_CODE){
    $sql = "SELECT * FROM gl
    WHERE code = '" . $NEW_CODE . "'";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        $dw3_conn->close();
        die("Ce code est déjà utilisé pour un autre poste.");
    }
    $sql = "SELECT * FROM gls
    WHERE gl_code = '" . $NEW_CODE . "' ";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        $dw3_conn->close();
        die("Ce code est utilisé, par conséquent ne peut être effacé.");
    }
}

//update
	$sql = "UPDATE gl SET kind='" . $KIND  . "', code='" . $NEW_CODE  . "',name_fr='" . $NAME_FR  . "',name_en='" . $NAME_EN  . "',desc_fr='" . $DESC_FR  . "',desc_en='" . $DESC_EN  . "' WHERE code='" . $OLD_CODE . "' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
        echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID= $_POST['ID'];
$desc_fr = mysqli_real_escape_string($dw3_conn,$_POST['DESC_FR']);
$desc_en = mysqli_real_escape_string($dw3_conn,$_POST['DESC_EN']);
$data_ia_desc = mysqli_real_escape_string($dw3_conn,$_POST['DIA']);

$sql = "UPDATE product SET    
description_fr = '" . $desc_fr . "',
description_en = '" . $desc_en . "',
desc_dataia_fr = '" . $data_ia_desc . "'
WHERE id = '" . $ID . "' 
LIMIT 1";

if ($dw3_conn->query($sql) === TRUE) {
    echo "";
} else {
    echo $dw3_conn->error;
}
$dw3_conn->close();
die();
?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$ID  = $_GET['ID'];
$FN = $_GET['FN'];
$SEQ = $_GET['SEQ'];

if ($SEQ == '1'){
    $sql = "UPDATE classified SET img_link = '" . $FN . "' WHERE id = '" . $ID . "' LIMIT 1";
}
if ($SEQ == '2'){
    $sql = "UPDATE classified SET img_link2 = '" . $FN . "' WHERE id = '" . $ID . "' LIMIT 1";
}
if ($SEQ == '3'){
    $sql = "UPDATE classified SET img_link3 = '" . $FN . "' WHERE id = '" . $ID . "' LIMIT 1";
}


if ($dw3_conn->query($sql) == TRUE) {
    echo "";
} else {
  echo $dw3_conn->error;
}
$dw3_conn->close();
?>
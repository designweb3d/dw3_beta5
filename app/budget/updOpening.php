<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$AMOUNT   = $_GET['A'];

//aller cherche le solde d'ouverture
$sql = "UPDATE config SET text2 = '$AMOUNT' WHERE kind = 'GL' AND code = 'YEAR' LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result === TRUE) {
    echo "OK";
} else {
    echo "Error: " . $sql . "<br>" . $dw3_conn->error;
}
$dw3_conn->close();
?>
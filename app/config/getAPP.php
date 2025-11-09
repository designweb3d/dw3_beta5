<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$appID  = $_GET['ID'];
$sql = "SELECT * FROM app WHERE id = '" . $appID   . "' LIMIT 1;";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
echo '{"auth":"'.$data["auth"].'","name_fr":"'.$data["name_fr"].'","name_en":"'.$data["name_en"].'","sort_number":"'.$data["sort_number"].'","icon":"'.$data["icon"].'","color":"'.$data["color"].'"}';
$dw3_conn->close();
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$sql = "SELECT IFNULL(SUM(price*(qty_order)),0) as head_stotal
FROM invoice_line 
WHERE head_id = '" . $ID . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$gtot = $data['head_stotal']??"0";
echo "(Sous-total: " . number_format($gtot,2,',','.') . "$" . ")";
$dw3_conn->close();
?>

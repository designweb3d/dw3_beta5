<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];
$sql = "SELECT IFNULL(SUM(price*(qty_order)),0) as head_stotal
FROM purchase_line 
WHERE head_id = '" . $enID . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$gtot = $data['head_stotal']??"0";
echo number_format($gtot,2,',','.') . " $" . "net";
$dw3_conn->close();
?>

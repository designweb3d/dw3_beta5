<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['enID'];
$sql = "SELECT * FROM purchase_line 
WHERE head_id = '" . $ID . "' ";

$result = $dw3_conn->query($sql);
$numrows = $result->num_rows;
$gtotal=0;
$stotal=0;
$tvq=0;
$tps=0;
if ($numrows > 0) {
    while($row = $result->fetch_assoc()) {
        $row_tvq = 0;
        $row_tps = 0;
        if($row["tax_prov"] == 1){$row_tvq = round((($row["price"]*$row["qty_order"])/100)*9.975,2);}
        if($row["tax_fed"] == 1){$row_tps = round((($row["price"]*$row["qty_order"])/100)*5,2);}
        $tvq = $tvq + $row_tvq;
        $tps = $tps + $row_tps;
        $stotal = $stotal + round($row["price"]*$row["qty_order"],2);
    }
    $gtotal = round($stotal + $tps + $tvq,2); 
/*     $balance = round($gtotal - $paid,2); 
    if($balance > 0){$topay=$balance;} */
}

	$sql = "UPDATE purchase_head
     SET    
	 stat = '1',
	 prepaid_cash    = '" . $gtotal    . "',
	 date_modified   = '" . $datetime   . "',
	 user_modified   = '" . $USER   . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>

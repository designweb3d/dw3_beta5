<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];

$head_tps=0;
$head_tvq=0;
$head_stotal=0;
$head_total=0;
//data from head
$sql = "SELECT * FROM purchase_head WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$supplier_id = $data['supplier_id'];
$transport = $data['transport'];
$document = $data['document'];
$date_due = date_create(substr($data['date_due'],0,10));
$date_facture = $data['date_created'];

//data from lines
$sql = "SELECT * FROM purchase_line WHERE head_id = '" . $enID . "' ORDER BY line";
$result = $dw3_conn->query($sql);
$numrows = $result->num_rows;
if ($numrows > 0) {	
    while($row = $result->fetch_assoc()) {
        $PRIX_LGN = round($row["qty_order"] * $row["price"],2);
        $TX_FED = 0;
        $TX_PROV= 0;
        if ($row["tax_fed"] == '1'){
            $TX_FED = round($PRIX_LGN * 0.05,2);
            $head_tps = $head_tps + $TX_FED;
        } 
        if ($row["tax_prov"] == '1'){
            $TX_PROV = round($PRIX_LGN * (9.975/100),2);
            $head_tvq = $head_tvq + $TX_PROV;
        }
        $PRIX_LGN_TX = $PRIX_LGN + $TX_FED + $TX_PROV;
        $head_stotal += $PRIX_LGN;
        $head_total += $PRIX_LGN_TX;
    }

    //la y va falloir looper dans expense par group_name
    $sql3 ="INSERT INTO gls (kind,gl_code,source,source_id,supplier_id,year,period,amount,date_created,user_created,document) VALUES "
    ."('CREDIT','1060','PURCHASE','".$enID."','".$supplier_id."','".date_format($date_due,"Y")."','".date_format($date_due,"m")."','".$head_total."','".$date_facture."','".$USER."','/fs/purchase/". $document . "'),"
    . "('DEBIT','5775','PURCHASE','".$enID."','".$supplier_id."','".date_format($date_due,"Y")."','".date_format($date_due,"m")."','".$head_stotal."','".$date_facture."','".$USER."','/fs/purchase/". $document . "'),"
    . "('DEBIT','2315','PURCHASE','".$enID."','".$supplier_id."','".date_format($date_due,"Y")."','".date_format($date_due,"m")."','".$head_tps."','".$date_facture."','".$USER."','/fs/purchase/". $document . "'),"
    . "('DEBIT','2345','PURCHASE','".$enID."','".$supplier_id."','".date_format($date_due,"Y")."','".date_format($date_due,"m")."','".$head_tvq."','".$date_facture."','".$USER."','/fs/purchase/". $document . "'),"
    . "('DEBIT','5300','PURCHASE','".$enID."','".$supplier_id."','".date_format($date_due,"Y")."','".date_format($date_due,"m")."','".$transport."','".$date_facture."','".$USER."','/fs/purchase/". $document . "');";
    if ($dw3_conn->query($sql3) === TRUE) {}

    //update status to paid
	$sql2 = "UPDATE invoice_head SET    
	 stat = '1',
	 date_modified   = '" . $datetime   . "',
	 user_modified   = '" . $USER   . "'	 
	 WHERE id = '" . $enID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql2) === TRUE) {
	  echo "";
	} else {
	  echo"Erreur maj status facture: " . $dw3_conn->error;
	}

}
$dw3_conn->close();
die();
?>
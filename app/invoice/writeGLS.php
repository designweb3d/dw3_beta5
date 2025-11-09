<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];

//data from head
$sql = "SELECT * FROM invoice_head WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

    $sql2 ="INSERT INTO gls (kind,gl_code,source,source_id,customer_id,year,period,amount,date_created,user_created,document) VALUES "
            .  "('DEBIT','1060','INVOICE','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','".$data['total']."','".$datetime."','".$USER."','/fs/invoice/". $enID . ".pdf'),"
            . "('CREDIT','4200','INVOICE','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','".$data['stotal']-$data['discount']."','".$datetime."','".$USER."','/fs/invoice/". $enID . ".pdf'),";
    //if ($data['discount'] != "0") {$sql2 .= "('CREDIT','5615','INVOICE','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','-".$data['discount']."','".$datetime."','".$USER."','/fs/invoice/". $enID . ".pdf'),";}
    if ($data['transport'] != "0") { $sql2 .= "('CREDIT','5300','INVOICE','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','".$data['transport']."','".$datetime."','".$USER."','/fs/invoice/". $enID . ".pdf'),";}
    $sql2 .= "('CREDIT','2340','INVOICE','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','".$data['tvp']."','".$datetime."','".$USER."','/fs/invoice/". $enID . ".pdf'),"
            . "('CREDIT','2310','INVOICE','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','".$data['tvh']+$data['tps']."','".$datetime."','".$USER."','/fs/invoice/". $enID . ".pdf')";
            //die($sql2);
    if ($dw3_conn->query($sql2) === TRUE) {
        echo "Écriture au GL terminée.";
    } else {
        echo "Erreur écriture au GL: " . $dw3_conn->error;
    }

	$sql2 = "UPDATE invoice_head SET    
	 stat = '1',
	 date_modified = '" . $datetime   . "',
	 user_modified = '" . $USER   . "'	 
	 WHERE id = '" . $enID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql2) === TRUE) {
	      $sql4 = "UPDATE order_head SET    
            stat = '1',
            date_modified   = '" . $datetime   . "',
            user_modified   = '" . $USER   . "'	 
            WHERE id = '" . $data['order_id'] . "' 
            LIMIT 1";
            if ($dw3_conn->query($sql4) === TRUE) {
                echo "";
            } else {
                echo"Erreur maj status commande: " . $dw3_conn->error;
            }
	} else {
	  echo"Erreur maj status facture: " . $dw3_conn->error;
	}

$dw3_conn->close();
die();
?>
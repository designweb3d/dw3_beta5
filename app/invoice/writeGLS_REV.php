<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];
$REFUND  = $_GET['A']??"nd";
$REASON  = str_replace("'","’", $_GET['R']);
$refunded = 0;
$cancel_cmd  = $_GET['CC'];
$cmd_stat = "1";
if($cancel_cmd == "0"){ $cmd_stat = "0"; }
if($cancel_cmd == "1"){ $cmd_stat = "4"; }

//data from head
$sql = "SELECT * FROM invoice_head WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

//revif si transactions faites
$sql7 = "SELECT IFNULL(SUM(paid_amount),0) AS total_paid FROM transaction WHERE invoice_id = " . $enID . " AND payment_status = 'succeeded';";
$result7 = mysqli_query($dw3_conn, $sql7);
$data7 = mysqli_fetch_assoc($result7);
if($data7["total_paid"] != "0"){
    if ($REFUND != "nd" & $REFUND > $data7["total_paid"]){
        $dw3_conn->close();
       die("Erreur: Le montant à rembourser excède le montant payé qui est de ".$data7["total_paid"] ."$.");
    }
    if ($REFUND == "nd"){
        $sql = "UPDATE customer SET balance_before = balance, balance = balance + ".$data7["total_paid"]." WHERE id = ".$data["customer_id"].";";
        $result = mysqli_query($dw3_conn, $sql);
        echo "1"; 
        $refunded = $data7["total_paid"];
    } else if ($REFUND != 0){
        $sql = "UPDATE customer SET balance_before = balance, balance = balance + ".$REFUND." WHERE id = ".$data["customer_id"]."";
        $result = mysqli_query($dw3_conn, $sql);
        echo "1"; 
        $refunded = $REFUND;
    }
}

//revif si gls fait
$sqlx = "SELECT COUNT(*) as total_lines FROM gls WHERE source_id = '".$enID ."' AND source = 'INVOICE' ;";
$resultx = mysqli_query($dw3_conn, $sqlx);
$datax = mysqli_fetch_assoc($resultx);
if($datax["total_lines"] != "0"){
    $sql2 ="INSERT INTO gls (kind,gl_code,source,source_id,customer_id,year,period,amount,date_created,user_created,document) VALUES "
            . "('DEBIT','1060','INVOICE-REFUND','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','-".$data['total']-$data['transaction_cost'] ."','".$datetime."','".$USER."','/fs/invoice/". $enID . ".pdf'),";
    if ($data['transaction_cost'] != "0") {$sql2 .= "('DEBIT','5896','INVOICE-REFUND','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','-".$data['transaction_cost']."','".$datetime."','".$USER."','/fs/invoice/". $enID . ".pdf'),";}
    $sql2 .=  "('CREDIT','4200','INVOICE-REFUND','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','-".$data['stotal']-$data['discount']."','".$datetime."','".$USER."','/fs/invoice/". $enID . ".pdf'),";
    //if ($data['discount'] != "0") {$sql2 .= "('CREDIT','5615','INVOICE-REFUND','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','".$data['discount']."','".$datetime."','".$USER."','/fs/invoice/". $ID . ".pdf'),";}
    if ($data['transport'] != "0") { $sql2 .= "('CREDIT','5300','INVOICE-REFUND','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','-".$data['transport']."','".$datetime."','".$USER."','/fs/invoice/". $enID . ".pdf'),";}
    $sql2 .= "('CREDIT','2340','INVOICE-REFUND','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','-".$data['tvp']."','".$datetime."','".$USER."','/fs/invoice/". $enID . ".pdf'),"
           . "('CREDIT','2310','INVOICE-REFUND','".$enID."','".$data['customer_id']."','".date("Y")."','".date("m")."','-".$data['tvh']+$data['tps']."','".$datetime."','".$USER."','/fs/invoice/". $enID . ".pdf')";
            //die($sql2);
    if ($dw3_conn->query($sql2) === TRUE) {
        //echo "Écriture au GL terminée.";
    } else {
        echo "Erreur écriture au GL: " . $dw3_conn->error;
    }
}

$sql3 = "UPDATE invoice_head SET    
    stat = '3',
    date_modified   = '" . $datetime   . "',
    user_modified   = '" . $USER   . "'	,user_cancel   = '" . $USER   . "',cancel_reason = '".$REASON ."', refunded = '".$refunded."'
    WHERE id = '" . $enID . "' 
    LIMIT 1";
if ($dw3_conn->query($sql3) === TRUE) {
    $sql4 = "UPDATE order_head SET    
    stat = '$cmd_stat',
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
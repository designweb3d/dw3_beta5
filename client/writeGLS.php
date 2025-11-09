<?php //not sure if its good..
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$ID  = $_GET['ID'];
$classified_id = "";

//check if previous gls lines written
$sql = "SELECT COUNT(*) AS is_gls_written FROM gls WHERE source_id = " . $ID . " AND source = 'INVOICE';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if($data["is_gls_written"] == "0"){$is_gls_written = false;} else {$is_gls_written = true;}

//data from head
$sql = "SELECT * FROM invoice_head WHERE id = '" . $ID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

if ($data['stat']!="2" && $data['stat']!="3"){
    //already invoiced
    if ($data['stat']=="1" && $is_gls_written){
        if ($data['transaction_cost'] != "0"){
            $sql2 ="INSERT INTO gls (kind,gl_code,source,source_id,customer_id,year,period,amount,date_created,user_created,document) VALUES "
            . "('CREDIT','1060','INVOICE','".$ID."','".$USER."','".date("Y")."','".date("m")."','".$data['transaction_cost']."','".$datetime."','0','/fs/invoice/". $ID . ".pdf'),"
            . "('DEBIT','5896','INVOICE','".$ID."','".$USER."','".date("Y")."','".date("m")."','".$data['transaction_cost']."','".$datetime."','0','/fs/invoice/". $ID . ".pdf')";
        } 
    } else {
    //new gls (100% web based)
        $sql2 ="INSERT INTO gls (kind,gl_code,source,source_id,customer_id,year,period,amount,date_created,user_created,document) VALUES "
            . "('DEBIT','1060','INVOICE','".$ID."','".$USER."','".date("Y")."','".date("m")."','".$data['total']-$data['transaction_cost']."','".$datetime."','0','/fs/invoice/". $ID . ".pdf'),";
            if ($data['transaction_cost'] != "0") {$sql2 .= "('DEBIT','5896','INVOICE','".$ID."','".$USER."','".date("Y")."','".date("m")."','".$data['transaction_cost']."','".$datetime."','0','/fs/invoice/". $ID . ".pdf'),";}
            $sql2 .= "('CREDIT','4200','INVOICE','".$ID."','".$USER."','".date("Y")."','".date("m")."','".$data['stotal']-$data['discount']."','".$datetime."','0','/fs/invoice/". $ID . ".pdf'),";
            //if ($data['discount'] != "0") {$sql2 .= "('CREDIT','5615','INVOICE','".$ID."','".$USER."','".date("Y")."','".date("m")."','-".$data['discount']."','".$datetime."','0','/fs/invoice/". $ID . ".pdf'),";}
            if ($data['transport'] != "0") {$sql2 .= "('CREDIT','5300','INVOICE','".$ID."','".$USER."','".date("Y")."','".date("m")."','".$data['transport']."','".$datetime."','0','/fs/invoice/". $ID . ".pdf'),";}
            $sql2 .= "('CREDIT','2340','INVOICE','".$ID."','".$USER."','".date("Y")."','".date("m")."','".$data['tvp']."','".$datetime."','0','/fs/invoice/". $ID . ".pdf'),"
            . "('CREDIT','2310','INVOICE','".$ID."','".$USER."','".date("Y")."','".date("m")."','".$data['tvh']+$data['tps']."','".$datetime."','0','/fs/invoice/". $ID . ".pdf')";
    }
    if ($dw3_conn->query($sql2) === TRUE) {
        $sql3 = "UPDATE invoice_head SET stat = '2', date_modified='".$datetime."' WHERE id = '" . $ID . "' LIMIT 1";
        if ($dw3_conn->query($sql3) === TRUE) {
            $sql4= "SELECT * FROM invoice_line WHERE head_id = '" . $data['id'] . "';";
            $result = $dw3_conn->query($sql4);
            $numrows = $result->num_rows;
            if ($numrows > 0) {	
                while($row = $result->fetch_assoc()) {
                    if ($row["product_id"] != "0"){
                        $sqlX = "UPDATE product SET purchase_qty = purchase_qty + " . $row["qty_order"] . " WHERE id = '" . $row["product_id"] . "' LIMIT 1";
                        $resultX = mysqli_query($dw3_conn, $sqlX);
                        /*$sqlY = "INSERT INTO transfer " . $row["qty_order"] . " WHERE id = '" . $row["product_id"] . "'";
                        $resultX = mysqli_query($dw3_conn, $sqlX); */
                    } else if ($row["classified_id"] != "0"){
                        //update qty_available
                        $classified_id = $row["classified_id"];
                        $sqlX = "UPDATE classified SET qty_available = qty_available - " . $row["qty_order"] . " WHERE id = '" . $row["classified_id"] . "' LIMIT 1";
                        $resultX = mysqli_query($dw3_conn, $sqlX);
                        //get classified price & retailer
                        $sqlY= "SELECT * FROM classified WHERE id = '" . $classified_id . "';";
                        $resultY = $dw3_conn->query($sqlY);
                        $dataY = mysqli_fetch_assoc($resultY);
                        //update retailer balance
                        $line_price = floatval($dataY["price"]) * $row["qty_order"];
                        $retailer_profit = $line_price - (($line_price/floatval($CIE_GRAB_POURCENT))-floatval($CIE_GRAB_AMOUNT));
                        $sqlZ= "UPDATE customer SET balance = balance + ".$retailer_profit." WHERE id = '" . $dataY['customer_id'] . "';";
                        $resultZ = $dw3_conn->query($sqlZ);
                    }
                }
            }
        }
        if ($data['ship_type']!=""){
            $sqlC= "UPDATE order_head SET stat = '2' WHERE id = '" . $data['order_id'] . "';";
            $resultC = $dw3_conn->query($sqlC);   
        }
    } else {
        //echo "Erreur écriture au GL: " . $dw3_conn->error;
    }
    //if retailer sale add credit to his account balance
    if ($data['line_source']=='classified'){
        //get retailer id
        /*  $sqlY= "SELECT * FROM classified WHERE id = '" . $classified_id . "';";
        $resultY = $dw3_conn->query($sqlY);
        $dataY = mysqli_fetch_assoc($resultY);

        $retailer_profit = floatval($data["total"]) - ((floatval($data["total"])/floatval($CIE_GRAB_POURCENT))-floatval($CIE_GRAB_AMOUNT));
        $sqlZ= "UPDATE customer SET balance = balance + ".$retailer_profit." WHERE id = '" . $dataY['customer_id'] . "';";
        $resultZ = $dw3_conn->query($sqlZ); */
    }
} 
$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$NO = $_GET['CHECK_NO'];
$AMOUNT = $_GET['AMOUNT'];

//verifs
$sql = "SELECT * FROM invoice_head WHERE id = '" .  $ID . "'";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$tot_diff = $data["total"] - ($AMOUNT + $data["prepaid"]+ $data["paid_cash"]+ $data["paid_check"]+ $data["paid_stripe"]+ $data["paid_moneris"]);
$fct_stat = $data["stat"];
if($tot_diff <= 0){
    $fct_stat = 2;
}

//data from order lines
$sql = "SELECT COUNT(*) AS rowCount FROM order_line WHERE head_id = '" . $data['order_id'] . "' AND product_renew = '1';";
$result = mysqli_query($dw3_conn, $sql);
$dataC = mysqli_fetch_assoc($result);
$cmd_stat = "1";
    //si payé et aucun produit renouvelable fermer la commande
    if ($dataC["rowCount"] == "0" && $fct_stat == 2){
        $cmd_stat = "5";
        //update order status
        $sql4 = "UPDATE order_head SET    
        stat = '$cmd_stat'
        WHERE id = '" . $data['order_id'] . "' 
        LIMIT 1";
        if ($dw3_conn->query($sql4) === TRUE) {
            echo "";
        } else {
            echo"Erreur maj status commande: " . $dw3_conn->error;
        }
    }

$sql = "INSERT INTO transaction (invoice_id,paid_amount,payment_status,payment_type,txn_id,created,modified,paid_amount_currency) 
VALUES('" . $ID . "','" .  $AMOUNT . "','succeeded','CHECK','".$NO."','".$datetime."','".$datetime."','cad')";
if ($dw3_conn->query($sql) === TRUE) {
	$sql2 = "UPDATE invoice_head SET paid_cash=paid_cash+".$AMOUNT." , stat = '".$fct_stat."'   
    WHERE id = '" . $ID . "' 
    LIMIT 1";
    if ($dw3_conn->query($sql2) === TRUE) {
        echo "";
      } else {
        echo $dw3_conn->error;
      }
  } else {
    echo $dw3_conn->error;
  }
$dw3_conn->close();
?>

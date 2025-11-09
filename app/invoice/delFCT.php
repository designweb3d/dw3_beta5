<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$CID  = $_GET['CID'];
$cancel_cmd  = $_GET['CC'];
$REASON  = str_replace("'","’", $_GET['R']);

$sql = "SELECT IFNULL(SUM(paid_amount),0) AS total_paid FROM transaction WHERE invoice_id = " . $ID . " AND payment_status = 'succeeded';";
$result = mysqli_query($dw3_conn, $sql);
if ($result->num_rows > 0) {
    $data = mysqli_fetch_assoc($result);
    if($data["total_paid"] != "0"){
        die ("Erreur: Cette facture ne peut être renversé ou annulé, car il y a déjà eu un paiement. Vous pouvez faire un remboursement par l'application 'Achats' et inscrire y le # de facture.");
    }
}

$sql = "UPDATE invoice_head SET stat = '3',date_modified   = '" . $datetime   . "',user_modified   = '" . $USER   . "',user_cancel   = '" . $USER   . "',cancel_reason = '".$REASON ."'	WHERE id = '" . $ID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);

//reactivate order if not paid
/* $sql = "SELECT COUNT(*) AS paid FROM invoice_head WHERE order_id = " . $CID . " AND stat = '2';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if(cancel_cmd == "0"){ */
if($cancel_cmd == "0"){
    $sql2 = "UPDATE order_head SET stat = '0', date_modified   = '" . $datetime   . "',user_modified   = '" . $USER   . "'	WHERE id = '" . $CID . "' LIMIT 1";
    $result2 = mysqli_query($dw3_conn, $sql2);
} else {
    $sql2 = "UPDATE order_head SET stat = '4', date_modified   = '" . $datetime   . "',user_modified   = '" . $USER   . "'	WHERE id = '" . $CID . "' LIMIT 1";
    $result2 = mysqli_query($dw3_conn, $sql2); 
}
//}

    //ajout évènement
    $sql_task = "INSERT INTO event (event_type,name,description,date_start,user_id) 
        VALUES('INVOICE','Facture annulée','No de Facture: ".$ID."\nModifiée par: ".$USER_FULLNAME ."','". $datetime ."','".$USER."')";
    $result_task = $dw3_conn->query($sql_task);

$dw3_conn->close();
die ("");
?>

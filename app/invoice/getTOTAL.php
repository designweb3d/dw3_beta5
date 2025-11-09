<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$invoice_id  = $_GET['enID'];

$paid = 0;
$topay = 0;
$balance = 0;
$html = "";

//get transactions
$sql = "SELECT SUM(ROUND(paid_amount,2)) as total_paid FROM transaction WHERE invoice_id = '" . $invoice_id . "' AND payment_status = 'succeeded';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$paid = $data['total_paid']??0;
//get stat
$sql = "SELECT A.*, CONCAT(IFNULL(B.first_name,''),' ',IFNULL(B.last_name,'')) AS user_cancel_name FROM invoice_head A
LEFT JOIN (SELECT id,first_name,last_name FROM user) B ON A.user_cancel = B.id
WHERE A.id = '" . $invoice_id . "' LIMIT 1;";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$invoice_stat = $data['stat'];

$balance = round($data['total'] - $paid,2); 
if($balance > 0){$topay=$balance;}
if ($invoice_stat == '1'){
    if ($APREAD_ONLY == false) { 
        $html .= "<div style='display:inline-block;vertical-align:top;'>
                    <span style='font-size:12px;'>Encaissement</span>
                    <input type='number' id='txtToPay' value='". number_format($balance,2) ."' style=\"text-align:right;padding-right:18px;width:80px;background: url('/pub/img/dw3/arrow-money.png') 99% / 20px no-repeat #dedede; ?>;\">
                    <span class='material-icons' style='vertical-align:middle;'>start</span>
                    <button class='green' onclick='payCASH();'><span class='material-icons' style='vertical-align:middle;' title='Payé en argent'>paid</span></button>
                    <button class='green' onclick='payINTERAC();'><img src='/pub/img/dw3/interac.png' style='vertical-align:middle;width:25px;height:25px;' title='Payé par Interac'></button>
                    <button class='green' onclick='payCHECK_NUMBER();'><span class='material-icons' style='vertical-align:middle;' title='Payé par chèque'>payments</span></button>
                    <button class='green' onclick='payBANK_NUMBER();'><span class='material-icons' style='vertical-align:middle;' title='Payé par transfert bancaire'>account_balance</span></button>
                    <button disabled onclick='paySTRIPE();' style=\"display:none;width:45px;height:40px;background-image:url('/pub/img/dw3/stripe2.png');background-size: 42px 42px;background-position: center center;background-attachment: fixed;background-repeat: no-repeat;\"> <div style='width:24px;height:24px;'></button>
                    <button disabled onclick='payMONERIS();' style=\"display:none;width:45px;height:40px;background-image:url('/pub/img/dw3/moneris.png');background-size: 40px 40px;background-position: center center;background-attachment: fixed;background-repeat: no-repeat;\"> <div style='width:24px;height:24px;'></button>
                    <button disabled onclick='payPAL();' style=\"display:none;width:45px;height:40px;background-image:url('/pub/img/dw3/Paypal.png');background-size: 40px 40px;background-position: center center;background-attachment: fixed;background-repeat: no-repeat;\"> <div style='width:24px;height:24px;'></button>
                </div>";
    }
}
$html .= "<div style='width:350px;display:inline-block;vertical-align:top;'>";
if ($invoice_stat == '0'){
    if ($APREAD_ONLY == false) { 
        $html .="<button onclick=\"writeGLS('".$invoice_id."');\" style='width:170px;'><span class='material-icons'>request_quote</span> Confirmer</button>
                <button onclick='cancelInvoice();'><span class='material-icons'>delete_forever</span> Annuler</button>";
    }
} else if($invoice_stat == '1'){
    if ($APREAD_ONLY == false) { 
        $html .="
                <button class='red' onclick=\"reverseInvoice('".$paid."','".$data['total']."');\"><span class='material-icons'>delete_forever</span> Renverser</button>
                <button class='blue' title='Envoyer la facture par courriel' onclick='sendInvoiceEmail();'><span class='material-icons'>outgoing_mail</span></button>
                <button class='blue' title='Envoyer 2e avis par courriel' onclick='sendInvoice2Email();'><span class='material-icons'>outgoing_mail</span> 2<sup>e</sup> avis</button>
                <button class='grey' title='Voir le PDF de la facture' onclick=\"dw3_secure_download('/fs/invoice/".$invoice_id.".pdf','_blank');\"><span class='material-icons'>picture_as_pdf</span></button>";
    } else {
        $html .="<button class='grey' title='Voir le PDF de la facture' onclick=\"dw3_secure_download('/fs/invoice/".$invoice_id.".pdf','_blank');\"><span class='material-icons'>picture_as_pdf</span></button>";
    }
} else if($invoice_stat == '2'){
    if ($APREAD_ONLY == false) { 
        $html .="
                <button class='red' onclick=\"repayInvoice('".$paid."','".$data['total']."');\"><span class='material-icons'>delete_forever</span> Rembourser</button>
                <button class='blue' title='Envoyer la facture payé par courriel' onclick='sendInvoice3Email();'><span class='material-icons'>outgoing_mail</span> </button>
                <button class='grey' title='Voir le PDF de la facture' onclick=\"dw3_secure_download('/fs/invoice/".$invoice_id.".pdf','_blank');\"><span class='material-icons'>picture_as_pdf</span></button>";
    } else {
        $html .="<button class='grey' title='Voir le PDF de la facture' onclick=\"dw3_secure_download('/fs/invoice/".$invoice_id.".pdf','_blank');\"><span class='material-icons'>picture_as_pdf</span></button>";
    }
} else if($invoice_stat == '3'){
    if ($APREAD_ONLY == false) { 
        $html .="
                <button class='blue' title='Envoyer la facture annulée par courriel' onclick='sendCanceledInvoice();'><span class='material-icons'>outgoing_mail</span></button>
                <button class='grey' title='Voir le PDF de la facture' onclick=\"dw3_secure_download('/fs/invoice/".$invoice_id.".pdf','_blank');\"><span class='material-icons'>picture_as_pdf</span></button>";
                $html .= "<div class='divBOX'>Raison de l'annulation / remboursement: <br><b>".$data["cancel_reason"]."</b></div>";
                $html .= "<div class='divBOX'>Montant crédité au compte: <br><b>".$data["refunded"]."</b>$ par <b>".$data["user_cancel_name"]."</b></div>";         
    } else {
        $html .="<button class='grey' title='Voir le PDF de la facture' onclick=\"dw3_secure_download('/fs/invoice/".$invoice_id.".pdf','_blank');\"><span class='material-icons'>picture_as_pdf</span></button>";
    }
}

$html .= "</div>
        <div style='max-width:350px;min-width:200px;display:inline-block;vertical-align:top;'>

<div style='width:100%;display:flex;justify-content:right;font-size:0.8em;'><div>Sous-Total: </div><div style='width:150px;border-bottom:1px solid var(--dw3_head_color);'> <span style='text-align:right;width:100%; font-size:0.9em' id='txtSTotal'>" . number_format($data['stotal'],2,'.',' ') . " $</span></div></div>
<div style='width:100%;display:flex;justify-content:right;font-size:0.8em;'><div>Rabais: </div>  <div style='width:150px;border-bottom:1px solid var(--dw3_head_color);'>   <span style='text-align:right;width:100%; font-size:0.9em' id='txtDISCOUNT'>" . number_format($data['discount'] ,2,'.',' ') . " $</span></div></div>
<div style='width:100%;display:flex;justify-content:right;font-size:0.8em;'><div>TPS: </div>  <div style='width:150px;border-bottom:1px solid var(--dw3_head_color);'>      <span style='text-align:right;width:100%; font-size:0.9em' id='txtTPS'>" .  number_format($data['tps'],2,'.',' ') . " $</span></div></div>
<div style='width:100%;display:flex;justify-content:right;font-size:0.8em;'><div>TVP: </div>  <div style='width:150px;border-bottom:1px solid var(--dw3_head_color);'>      <span style='text-align:right;width:100%; font-size:0.9em' id='txtTVP'>" . number_format($data['tvp'],2,'.',' ') . " $</span></div></div>
<div style='width:100%;display:flex;justify-content:right;font-size:0.8em;'><div>Transport: </div>  <div style='width:150px;border-bottom:1px solid var(--dw3_head_color);'><span style='text-align:right;width:100%; font-size:0.9em' id='txtTRP'>" . number_format($data['transport'],2,'.',' ') . " $</span></div></div>
<div style='width:100%;display:flex;justify-content:right;font-size:0.8em;'><div>Total: </div><div style='width:150px;border-bottom:1px solid var(--dw3_head_color);'>      <span style='text-align:right;width:100%; font-size:0.9em' id='txtTotal'>" . number_format($data['total'],2,'.',' ') . " $</span></div></div>
<div style='width:100%;display:flex;justify-content:right;font-size:0.8em;'><div>Payé: </div> <div style='width:150px;border-bottom:1px solid var(--dw3_head_color);'>      <span style='text-align:right;width:100%; font-size:0.9em' id='txtPaid'>" . number_format($paid,2,'.',' ') . " $</span></div></div>";
if ($balance==0){
    //facture payé envoyer email facture payé
        $html .= "<div style='width:100%;display:flex;justify-content:right;vertical-align:bottom;'><div style='text-align:right;'>Balance: </div>       <div style='width:150px;'><input type='text' id='txChange' value='" . number_format($balance,2,'.',' ') . "' disabled style=\"background: url('/pub/img/dw3/arrow-money.png') 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:19px;box-shadow:3px 6px 3px #40bf40;border-radius:0px;\"></div></div>";
    }else if ($balance < 0){
    //monnaie à remettre
        $html .= "<div style='width:100%;display:flex;justify-content:right;vertical-align:bottom;'><div style='text-align:right;'>Monnaie: </div>       <div style='width:150px;'><input type='text' id='txChange' value='" . number_format($balance,2,'.',' ') . "' disabled style=\"background: url('/pub/img/dw3/arrow-money.png') 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:19px;box-shadow:3px 6px 3px gold;border-radius:0px;\"></div></div>";
    }else if ($balance > 0){
    //commande impayé
        if ($paid == 0){
            //totalement impayé
            $html .= "<div style='width:100%;display:flex;justify-content:right;vertical-align:bottom;'><div style='text-align:right;'>Solde: </div>       <div style='width:150px;'><input type='text' id='txChange' value='" . number_format($balance,2,'.',' ') . "' disabled style=\"background: url('/pub/img/dw3/arrow-money.png') 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:19px;box-shadow:3px 6px 3px red;border-radius:0px;\"></div></div>";
        }else{
            //partielement payé
            $html .= "<div style='width:100%;display:flex;justify-content:right;vertical-align:bottom;'><div style='text-align:right;'>Solde: </div>       <div style='width:150px;'><input type='text' id='txChange' value='" . number_format($balance,2,'.',' ') . "' disabled style=\"background: url('/pub/img/dw3/arrow-money.png') 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:19px;box-shadow:3px 6px 3px red;border-radius:0px;\"></div></div>";
        }
    }

$html .= "</div></div>";
echo $html;
$dw3_conn->close();
?>
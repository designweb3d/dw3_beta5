<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];
$html = "";
$head_stotal = 0;
//data from head
$sql = "SELECT *
FROM purchase_head 
WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_total = round($data['total'],2);
$head_prepaid = round($data['prepaid_cash'],2);
$head_eml = $data['eml'];
$transport = $data['transport'];
$head_document = $data['document'];
$head_stat = $data['stat'];
$tvq = 0;
$tps = 0;
$stotal = 0;
$gtotal = 0;
$balance = 0;
//data from lines
/* $sql = "SELECT IFNULL(SUM(price*(qty_order-qty_shipped)),0) as head_stotal
FROM purchase_line 
WHERE head_id = '" . $enID . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_stotal = $data['head_stotal'];
$head_tvq = round($head_stotal*0.05,2);
$head_tps = round($head_stotal*0.0975,2);
$head_total = round($head_stotal + $head_tps + $head_tvq,2);
$balance = $head_total - $head_prepaid; */

//get lines
$sql = "SELECT * FROM purchase_line 
WHERE head_id = '" . $enID . "' ";
$result = $dw3_conn->query($sql);
$numrows = $result->num_rows;
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
    $gtotal = round($stotal + $tps + $tvq + $transport,2); 
    $balance = round($gtotal - $head_prepaid,2); 
    if($balance > 0){$topay=$balance;}
}

$html .= "
<table class='' style='width:100%;margin:left:auto;margin:right:auto;'>
<tr><td rowspan=7 style='text-align:center;'>";
if ($APREAD_ONLY == false) { 
    if ($head_stat=="0"){
        $html .="<button onclick='pay_purchase();'><span class='material-icons'>paid</span> Confirmer le paiement complet</button><br style='margin:0;'>
        <button style='background:red;' onclick=\"deleteCMD('" . $enID . "');\"><span class='material-icons'>delete</span> " .$dw3_lbl["DEL"] . " l'achat</button><br style='margin:0;'>";
        } else {
            $html .="<button style='background:red;' disabled><span class='material-icons'>delete</span> " .$dw3_lbl["DEL"] . "</button><br style='margin:0;'>";
        }
            $html .="<button onclick='closeEDITOR(this);' style='display:none;background:#555555;'><span class='material-icons'>print</span> Imprimer</button><br style='margin:0;'>";
            $html .="<button id='fileuploadbtn'><span class='material-icons'>upload</span> Téléverser la pièce justificative</button><input id='fileUpload' type='file' name='fileUpload' style='display:none;'><br style='margin:0;'>";
            $html .="<button style='cursor:help;' "; if ($head_document == "") {$html .= "disabled";} $html .=" onclick=\"getFCT_FILE('".$head_document."')\"><span class='material-icons'>info</span> Voir la pièce justificative</button><br style='margin:0;'>";
} else {
            $html .="<button style='cursor:help;' "; if ($head_document == "") {$html .= "disabled";} $html .=" onclick=\"getFCT_FILE('".$head_document."')\"><span class='material-icons'>info</span> Voir la pièce justificative</button><br style='margin:0;'>";
}
            $html .="</td><td style='text-align:right;font-size:0.7em;'>Sous-Total</td><td><input type='text' id='txtSTotal' value='" . number_format($stotal,2,'.',',') . "' disabled style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:15px;min-width:100px;'>
                </td></tr>
                <tr><td style='text-align:right;font-size:0.7em;'>TPS</td>        <td><input type='text' id='txtTPS' value='" .  number_format($tps,2,'.',',') . "' disabled style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;min-width:100px;'></td></tr>
                <tr><td style='text-align:right;font-size:0.7em;'>TVQ</td>        <td><input type='text' id='txtTVQ' value='" . number_format($tvq,2,'.',',') . "' disabled style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;min-width:100px;'></td></tr>
                <tr><td style='text-align:right;font-size:0.7em;'>Total</td>      <td><input type='text' id='txtTotal' value='" . number_format($gtotal,2,'.',',') . "' disabled style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:20px;min-width:100px;'></td>
                <tr><td style='text-align:right;font-size:0.7em;'>Payé</td>       <td><input type='text' id='txtPaid' value='" . number_format($head_prepaid,2,'.',',') . "' disabled style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;min-width:100px;'></td></tr>";
if ($balance==0){
    //commande payé créer facture et envoyer email facture payé
        $html .= "<tr><td style='text-align:right;font-size:0.7em;'>Balance</td>       <td><input type='text' id='txChange' value='" . number_format($balance,2,'.',',') . "' disabled style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;box-shadow:3px 6px 3px #40bf40;min-width:100px;'></td></tr>";
    }else if ($balance < 0){
    //monnaie à remettre
        $html .= "<tr><td style='text-align:right;font-size:0.7em;'>Monnaie</td>       <td><input type='text' id='txChange' value='" . number_format($balance,2,'.',',') . "' disabled style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;box-shadow:3px 6px 3px gold;min-width:100px;'></td></tr>";
    }else if ($balance > 0){
    //commande impayé
        if ($head_prepaid == 0){
            //totalement impayé
            $html .= "<tr><td style='text-align:right;font-size:0.7em;'>Solde</td>       <td><input type='text' id='txChange' value='" . number_format($balance,2,'.',',') . "' disabled style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;box-shadow:3px 6px 3px red;min-width:100px;'></td></tr>";
        }else{
            //partielement payé
            $html .= "<tr><td style='text-align:right;font-size:0.7em;'>Solde</td>       <td><input type='text' id='txChange' value='" . number_format($balance,2,'.',',') . "' disabled style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;box-shadow:3px 6px 3px red;min-width:100px;'></td></tr>";
        }
    }

$html .= "</table>";
echo $html;
$dw3_conn->close();
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];
$html = "";
$head_stotal = 0;
//data from head
$sql = "SELECT *
FROM order_head 
WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_prepaid = round($data['prepaid_cash'],2);
$head_eml = $data['eml'];
//data from lines
$sql = "SELECT IFNULL(SUM(price*(qty_order-qty_shipped)),0) as head_stotal
FROM order_line 
WHERE head_id = '" . $enID . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_stotal = $data['head_stotal'];
$head_tvq = round($head_stotal*0.05,2);
$head_tps = round($head_stotal*0.0975,2);
$head_total = round($head_stotal + $head_tps + $head_tvq,2);
$balance = $head_total - $head_prepaid;

$html .= "
<table class='' style='width:100%;'>
<tr><td width='10%' style='text-align:right;font-size:0.7em;'>Sous-Total</td><td width='150px'><input type='text' id='txtSTotal' value='" . number_format($head_stotal,2,',','.') . "' disabled style='background: url(/img/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:15px;'></td></tr>
<tr><td style='text-align:right;font-size:0.7em;'>TPS</td>        <td><input type='text' id='txtTPS' value='" .  number_format($head_tps,2,',','.') . "' disabled style='background: url(/img/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;'></td></tr>
<tr><td style='text-align:right;font-size:0.7em;'>TVQ</td>        <td><input type='text' id='txtTVQ' value='" . number_format($head_tvq,2,',','.') . "' disabled style='background: url(/img/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;'></td></tr>
<tr><td style='text-align:right;font-size:0.7em;'>Total</td>      <td><input type='text' id='txtTotal' value='" . number_format($head_total,2,',','.') . "' disabled style='background: url(/img/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:20px;'></td>
<tr><td style='text-align:right;font-size:0.7em;'>Payé</td>       <td><input type='text' id='txtPaid' value='" . number_format($head_prepaid,2,',','.') . "' disabled style='background: url(/img/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;'></td></tr>";
if ($balance==0){
    //commande payé créer facture et envoyer email facture payé
        $html .= "<tr><td style='text-align:right;font-size:0.7em;'>Balance</td>       <td><input type='text' id='txChange' value='" . number_format($balance,2,',','.') . "' disabled style='background: url(/img/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;box-shadow:3px 6px 3px #40bf40;'></td></tr>";
    }else if ($balance < 0){
    //monnaie à remettre
        $html .= "<tr><td style='text-align:right;font-size:0.7em;'>Monnaie</td>       <td><input type='text' id='txChange' value='" . number_format($balance,2,',','.') . "' disabled style='background: url(/img/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;box-shadow:3px 6px 3px gold;'></td></tr>";
    }else if ($balance > 0){
    //commande impayé
        if ($head_prepaid == 0){
            //totalement impayé
            $html .= "<tr><td style='text-align:right;font-size:0.7em;'>Solde</td>       <td><input type='text' id='txChange' value='" . number_format($balance,2,',','.') . "' disabled style='background: url(/img/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;box-shadow:3px 6px 3px red;'></td></tr>";
        }else{
            //partielement payé
            $html .= "<tr><td style='text-align:right;font-size:0.7em;'>Solde</td>       <td><input type='text' id='txChange' value='" . number_format($balance,2,',','.') . "' disabled style='background: url(/img/arrow-money.png) 99% / 20px no-repeat #ccc;text-align:right;padding-top:1px;padding-bottom:1px;font-size:14px;box-shadow:3px 6px 3px red;'></td></tr>";
        }
    }

$html .= "</table>";
echo $html;
$dw3_conn->close();
?>

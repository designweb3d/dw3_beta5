<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
$invoice_id  = $_GET['ID'];

//data from head
    $sql = "SELECT A.*, B.date_delivery AS date_delivery, CONCAT(IFNULL(C.name,''), ' ', IFNULL(C.adr1,''),' ', IFNULL(C.city,''),' ', IFNULL(C.postal_code,'')) AS loc_adr
    FROM invoice_head A
    LEFT JOIN order_head B ON A.order_id = B.id
    LEFT JOIN location C ON A.location_id = B.id
    WHERE A.id = '" . $invoice_id . "' LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);

//$head_prepaid = round($paid+$data['prepaid']+$data['paid_cash']+$data['paid_stripe']+$data['paid_moneris']+$data['paid_check'],2);
//$head_order_id = $data['order_id'];
$date_delivery = $data['date_delivery'];
$head_stat = $data['stat'];
$transport = $data['transport'];
$head_total = round($data['total'],2);
$head_customer = dw3_decrypt($data['name']);
$head_adr = dw3_decrypt($data['adr1_sh']);
$head_adr .= " ".dw3_decrypt($data['adr2_sh']);
$head_adr .= " ".$data['city_sh'];
$head_ship_type = $data['ship_type'];
$location_adress = $data['loc_adr'];
if($head_ship_type == "DOM.RP"){
    $head_ship_type = "Poste Canada Régulier";
} else if($head_ship_type == "DOM.EP"){
    $head_ship_type = "Poste Canada Accéléré";
} else if($head_ship_type == "DOM.XP"){
    $head_ship_type = "Poste Canada Express";
} else if($head_ship_type == "PICKUP" ){
    $head_ship_type = "Ramassé en magasin";
} else if($head_ship_type == "" ){
    $head_ship_type = "N/D";
}
    //$subject = iconv('UTF-8','ASCII//TRANSLIT',"Nouvelle Commande #". $head_order_id); //je sais pas pk mais si je met un accent dans le sujet ca passe pas..
    $subject = "La facture #". $invoice_id." a été payée.";
    $mainMessage = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
    <body><h4>Bonjour,</h4>';
        $mainMessage .= 'La facture #'.$invoice_id.' a été payé. Vérifiez si une expédition ou une autre action est nécessaire.<br>';
        $sql = "SELECT * FROM invoice_line WHERE head_id = '".$invoice_id."'";
          $mainMessage .= 'Client: <b>'.$head_customer.'</b> '.$head_adr.'<br>
          Montant total: '.round($head_total+$transport,2).'$<br>
          Mode de livraison:<b>'.$head_ship_type.'</b><br>
          Location:<b>'.$location_adress.'</b><br>
          Date et heure prévue:<b>'.$date_delivery.'</b><br><br>
          Détails de la facture:<br><table cellspacing=0 style="width:100%;border-collapse: collapse;">
            <tr style="border:1px solid #333;background:#333;color:goldenrod;"><th style"text-align:left;"># de Produit</th><th style"text-align:left;">Nom du produit</th><th style="text-align:center;">Quantité commandée</th></tr>';
          $result = $dw3_conn->query($sql);
          $numrows = $result->num_rows;
            if ($numrows > 0) {	
              while($row = $result->fetch_assoc()) {
                $mainMessage .= '<tr>
                <td style="border-bottom:1px solid gold;">'.$row["product_id"].'</td><td style="border-bottom:1px solid gold;" width="*">'.$row["product_desc"].$row["product_opt"].'</td><td style="border-bottom:1px solid gold;text-align:center;padding-right:10px;font-weight:bold;">'.round($row["qty_order"]).'</td></tr>';
              }
            }
            $mainMessage .= ' </table></body></html>';

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 $email = new PHPMailer();
 $email->CharSet = "UTF-8";
 $email->SetFrom("no-reply@".$_SERVER["SERVER_NAME"]);
 $email->Subject   = $subject;
 $email->Body      = $mainMessage;
 $email->IsHTML(true); 
 if (trim($CIE_EML2) == ""){
    $email->AddAddress($CIE_EML1);
} else {
    $email->AddAddress($CIE_EML2);
}
 $mail_ret = $email->Send();

if ($mail_ret == 1) {
        echo "";
} else {
    echo $mail_ret;
}
$dw3_conn->close();
?>
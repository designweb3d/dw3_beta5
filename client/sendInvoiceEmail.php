<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dompdf/autoload.inc.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
$enID  = $_GET['ID'];
$no_avis  = '1';

use Dompdf\Dompdf; 
use Dompdf\Options;
$head_stotal = 0;

//get transactions total
$sql = "SELECT SUM(paid_amount) as total_paid FROM transaction WHERE invoice_id = '" . $enID . "' AND payment_status = 'succeeded';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_paid = $data['total_paid']??0;
$tot_due = $data['total'] - $head_paid;

//data from head
$sql = "SELECT * FROM invoice_head WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

if ($data["ship_type"] == "" || $data["ship_type"] == "PICKUP"){
    $sql2 = "SELECT * FROM location WHERE id = '" .  $data["location_id"] . "'";
    $result2 = mysqli_query($dw3_conn, $sql2);
    $data2 = mysqli_fetch_assoc($result2);
    $province_tx = $data2["province"];
} else {
    if ($data["province_sh"] == ""){
        $province_tx = $data["province"];
    } else if ($data["prov"] != ""){
        $province_tx = $data["prov"];
    } else {
        $province_tx = $CIE_PROV;
    }
}

switch ($province_tx) {
    case "AB":case "Alberta":
        $PTPS = $TPS_AB;$PTVP = $TVP_AB;$PTVH = $TVH_AB;break;
    case "BC":case "British Columbia":
        $PTPS = $TPS_BC;$PTVP = $TVP_BC;$PTVH = $TVH_BC;break;
    case "QC":case "Quebec":case "Québec":
        $PTPS = $TPS_QC;$PTVP = $TVP_QC;$PTVH = $TVH_QC;break;
    case "MB":case "Manitoba":
        $PTPS = $TPS_MB;$PTVP = $TVP_MB;$PTVH = $TVH_MB;break;
    case "NB":case "New Brunswick":
        $PTPS = $TPS_NB;$PTVP = $TVP_NB;$PTVH = $TVH_NB;break;
    case "NT":
        $PTPS = $TPS_NT;$PTVP = $TVP_NT;$PTVH = $TVH_NT;break;
    case "NL":
        $PTPS = $TPS_NL;$PTVP = $TVP_NL;$PTVH = $TVH_NL;break;
    case "NS":case "Nova Scotia":
        $PTPS = $TPS_NS;$PTVP = $TVP_NS;$PTVH = $TVH_NS;break;
    case "NU":
        $PTPS = $TPS_NU;$PTVP = $TVP_NU;$PTVH = $TVH_NU;break;
    case "ON":case "Ontario":
        $PTPS = $TPS_ON;$PTVP = $TVP_ON;$PTVH = $TVH_ON;break;
    case "PE":
        $PTPS = $TPS_PE;$PTVP = $TVP_PE;$PTVH = $TVH_PE;break;
    case "SK":case "Saskatshewan":
        $PTPS = $TPS_SK;$PTVP = $TVP_SK;$PTVH = $TVH_SK;break;
    case "YT":case "Yukon":
        $PTPS = $TPS_YT;$PTVP = $TVP_YT;$PTVH = $TVH_YT;break;
}

if ($data['company'] != ""){
    $head_bill_to = $data['company'];
} else {
    $head_bill_to = dw3_decrypt($data['name']);
}
$html_PDF = "<!DOCTYPE html><html><head><meta charset='utf-8'>
    <title>" . $CIE_NOM . "</title><meta http-equiv=\"Content-Type\" content=\"text/html\">
        <style>
        body { margin: 150px 30px 50px 30px; }
        @page {margin: 0cm 0cm;}
        header {position: fixed;top: 0px;left: 0px;right: 0px;height: 140px;}
        footer {position: fixed; bottom: 0px; left: 0px; right: 0px;height: 50px; }
        footer .page-number:after { content: counter(page);}
        </style></head>
        <body style='text-align:left;'>";
        if ($tot_due==0){ $html_PDF .= "<div style='position:absolute;top:2px;left:0px;right:0px;text-align:center;color:green;text-align:center;font-size:1.3em;'><b>PAYÉ</b></div>"; }        
        $html_PDF .= "<header><table style='width:100%;'><tr><td style='text-align:left;padding:20px;'><img src='https://" . $_SERVER["SERVER_NAME"] . "/pub/img/".$CIE_LOGO2."' style='height:100px;width:auto;max-width:500px;'><br>
            <div style='width:100%;text-align:center;'>
            " . $CIE_EML1 . " <b> " . $CIE_TEL2 . " </b> " . $CIE_TEL1 .  "
            </div></td>
                <td style='text-align:right;padding:10px;'><b style='font-size:20px;'>Facture </b>#<br>Commande #<br>Compte #<br>Date de facture<br>Date due<br></td>
                <td style='text-align:right;padding:25px;'><b style='font-size:20px;'>" . $enID . "</b><br>" . $data['order_id']. "<br>" . $data['customer_id']. "<br>" . substr($data['date_created'],0,10) . "<br><b>" . substr($data['date_due'],0,10) . "</b></td></tr>
                </table>
        </header><main><table style='width:100%;'><tr>
                        <td width='*' style='vertical-align:top;padding:20px;'><b>Facturé à:</b><br>" . $head_bill_to . "<br>" . dw3_decrypt($data['adr1']) . "<br>"; if($data['adr2'] != ""){ $html_PDF .= dw3_decrypt($data['adr2']) . "<br>";} $html_PDF .= $data['city'] . " " . $data['prov'] . "<br>" . $data['country'] . ", " . $data['postal_code'] . "</td>
                        <td width='*' style='vertical-align:top;padding:20px;'><b>Payer à:</b><br>" . $CIE_NOM . "<br>" . $CIE_ADR1; if (trim($CIE_ADR2) != ""){ $html_PDF .= "<br>" . $CIE_ADR2;} $html_PDF .= "<br>".$CIE_VILLE.", " . $CIE_PROV . "<br>" .$CIE_PAYS . ", " . $CIE_CP . "</td>
                    </tr>
                </tr></table>
        ";


$sql = "SELECT A.*, B.name_fr, B.url_img, B.upc, B.tax_fed, B.tax_prov FROM invoice_line A 
LEFT JOIN product B ON A.product_id = B.id WHERE A.head_id = " . $enID . " ORDER BY A.line";
$result = $dw3_conn->query($sql);
$numrows = $result->num_rows;
if ($numrows > 0) {	
    $html_PDF.= "<table cellspacing=0 style='width:100%;border-collapse: collapse;border-left: none;border-right: none;'>
                    <tr style='background:#555;color:#EEE;text-align:left;'>
                        <th style='text-align:left;'>
                        </th><th style='text-align:left;'>Description</th><th style='text-align:center;'>Quantité</th><th style='text-align:right;'>Prix unitaire</th><th style='text-align:right;'>Avant taxes</th></tr>";
    while($row = $result->fetch_assoc()) {
        $filename= $row["url_img"];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["product_id"] . "/" . $filename)){
            $filename = "/img/nd.png";
        } else {
            if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["product_id"] . "/" . $filename)){
                $filename = "/img/nd.png";
            }else{
                $filename = "/fs/product/" . $row["product_id"] . "/" . $filename;
            }
        }
        $PRIX_LGN = round($row["qty_order"] * $row["price"],2);
        $html_PDF.= "<tr>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;'><img src='https://" . $_SERVER["SERVER_NAME"] .  $filename . "' style='height:40px;width:auto;max-width:60px;'></td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;'>" . $row["product_desc"].$row["product_opt"] . "</td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;text-align:center;'>" . number_format($row["qty_order"],2,'.',',') . "</td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;text-align:right;'>" . number_format($row["price"],2,'.',',') . "$</td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;text-align:right;'>" . number_format($PRIX_LGN,2,'.',',') . "$</td>";
        $html_PDF.= "</tr>";
    }
    $html_PDF.= "</table>";

    //transactions
    $sql = "SELECT * FROM transaction WHERE invoice_id = " . $enID . " AND payment_status='succeeded' ORDER BY created DESC";
    $result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
    if ($numrows > 0) {	
        $html_PDF.= "<table cellspacing=0 style='width:100%;border-collapse: collapse;border-left: none;border-right: none;margin:5px 0px;'>
                        <tr style='background:#777;color:#fff;text-align:left;'><th style='text-align:left;'><b>Transaction</b></th><th style='text-align:left;'>No</th><th style='text-align:left;'>Date</th><th style='text-align:right;'>Montant</th></tr>";
        while($row = $result->fetch_assoc()) {
            $html_PDF.= "<tr>";
            $html_PDF.= "<td style='border-bottom:1px solid goldenrod;'>" . $row["payment_type"] . "</td>";
            $html_PDF.= "<td style='border-bottom:1px solid goldenrod;text-align:left;'>" . $row["txn_id"] . "</td>";
            $html_PDF.= "<td style='border-bottom:1px solid goldenrod;text-align:left;'>" . substr($row["modified"],0,10) . "</td>";
            $html_PDF.= "<td style='border-bottom:1px solid goldenrod;text-align:right;'>" . number_format($row["paid_amount"],2,'.',' ') . "$</td>";
            $html_PDF.= "</tr>";
        }
        $html_PDF.= "</table>";
    }

    $html_PDF.= "<table cellspacing=0 style='width:100%;'><tr><td width='90%'></td><td style='width:150px;'>Sous-total</td><td style='text-align:right;'><u>" . number_format($data['stotal'],2,'.',',') . "</u>$</td></tr>";
    //$html_PDF.= "<tr><td width='90%'></td><td style='width:150px;'>TVH</td><td style='text-align:right;color:#444;'>0.00$</td></tr>";
    if ($data['discount'] > 0){
        $html_PDF.= "<tr><td width='90%'></td><td>Rabais</td><td style='text-align:right;color:#444;'>" . number_format($data['discount'],2,'.',',') . "$</td></tr>";
    }
    if ($data['tps'] > 0){$html_PDF.= "<tr><td width='90%'></td><td>TPS ".$PTPS."%</td><td style='text-align:right;color:#444;'>" . number_format($data['tps'],2,'.',',') . "$</td></tr>";}
    if ($data['tvp'] > 0){$html_PDF.= "<tr><td width='90%'></td><td>TVP ".$PTVP."%</td><td style='text-align:right;color:#444;'>" . number_format($data['tvp'],2,'.',',') . "$</td></tr>";}
    if ($data['tvh'] > 0){$html_PDF.= "<tr><td width='90%'></td><td>TVH ".$PTVH."%</td><td style='text-align:right;color:#444;'>" . number_format($data['tvh'],2,'.',',') . "$</td></tr>";}
    $html_PDF.= "<tr><td width='90%'></td><td>Transport</td><td style='text-align:right;color:#444;'>" . number_format($data['transport'],2,'.',',') . "$</td></tr>";
    $html_PDF.= "<tr><td width='90%'></td><td style='border-top:1px solid goldenrod;border-bottom:1px solid goldenrod;'>Total CA$</td><td style='text-align:right;border-bottom:1px solid goldenrod;border-top:1px solid goldenrod;'>" . number_format($data['total'],2,'.',',') . "$</td></tr>";
    $html_PDF.= "<tr><td width='90%'></td><td>Paiements</td><td style='text-align:right;'>" . number_format($head_paid,2,'.',',') . "$</td></tr>";
    if ($tot_due < 0){
        $html_PDF.= "<tr><td width='90%'></td><td>Crédit</td><td style='text-align:right;font-size:1.2em;border-bottom:1px solid goldenrod;'>" . number_format($data['total'] - $head_paid,2,'.',',') . "$</td></tr>";
    }else if($tot_due > 0){
        $html_PDF.= "<tr><td width='90%'></td><td>Balance à payer</td><td style='text-align:right;font-size:1.2em;border-bottom:1px solid goldenrod;'>" . number_format($data['total'] - $head_paid,2,'.',',') . "$</td></tr>";
    } else if ($tot_due == 0){
        $html_PDF.= "<tr><td width='90%'></td><td colspan='2' style='color:green;font-weight:bold;text-align:center;font-size:1.2em;border-bottom:1px solid goldenrod;'> PAYÉ </td></tr>";
    }
    $html_PDF.= "</table>#TPS:<b> ".$CIE_TPS."</b> | #TVQ:<b> ".$CIE_TVQ."</b><br style='margin:0px;line-height:1px;'>
    ".$CIE_INVOICE_NOTE."
    </main>";
    $html_PDF .= "<footer><hr><table style='width:100%;'><tr><th style='width:50px;border: 0px solid #333;'>&#160;&#160;</th><th style='border:0px solid grey;'>" . $CIE_NOM . "</th><th style='width:50px;border: 0px solid #333;'></th></tr></table></footer>";
    $html_PDF .= "</body></html>";
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isJavascriptEnabled', true);
    $dompdf = new Dompdf($options);
    $dompdf->set_option('defaultMediaType', 'all');
    $dompdf->set_option('isFontSubsettingEnabled', true);
    $dompdf->loadHtml($html_PDF, 'UTF-8'); 
    $dompdf->setPaper('letter', 'portrait'); 
    $dompdf->render(); 
    $font = $dompdf->getFontMetrics()->get_font("Verdana", "");
    $dompdf->get_canvas()->page_text(577, 770, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0,0,0));
    $fileatt = $dompdf->output();
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/fs/invoice/". $enID . ".pdf", $fileatt); 
    
    $semi_rand     = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
    $fileatttype = "application/pdf";

} else {
    $dw3_conn->close();
    die("Erreur la facture ne contient aucuns items.");
}

$fileattname = "invoice_". $enID . ".pdf";
if ($no_avis == "1" && $data['stat'] == "1"){
    //$subject = iconv('UTF-8','ASCII//TRANSLIT',$CIE_NOM ." - Facture #". $enID . " " . $datetime); //je sais pas pk mais si je met un accent dans le sujet ca passe pas..
    $subject = 'Facture #'. $enID;
    $mainMessage = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
    <body>
          <h3>Bonjour ' .$head_bill_to . ',</h3>
          Vous trouverez ci-joint votre facture ainsi que les modes de paiements en format PDF, qui se retrouvent aussi dans votre espace client sur <a href="https://' . $_SERVER["SERVER_NAME"] . '/client" target="_blank">https://' . $_SERVER["SERVER_NAME"] . '/client</a>
          <br><br>Pour obtenir plus de renseignements, veuillez communiquer avec nous. 
          <table style="border: 0px dashed #FB4314;font-size:17px;font-size:13px;margin-top:40px;"> 
              <tr> 
              <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO2.'" height="100"></td>
              <td width="99%" style="vertical-align:top;padding-top:10px;"><b style="font-size:15px;">' . $CIE_NOM . '</b>
              <br>' . $CIE_TEL1 . ' 
              ' . $CIE_TEL2 . '
              <br>' . $CIE_EML1 . '</td></tr>
            </table><br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a>
            </body></html>';
}else if ($no_avis == "2" && $data['stat'] == "1"){
    $subject = "2iem avis - Facture #". $enID ;
    $mainMessage = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
    <body>
          <h3>Bonjour ' . $head_bill_to . ',</h3>
          Ceci est un deuxième avis pour la facture #'.$enID.' ainsi que les modes de paiements en format PDF, qui se retrouvent aussi dans votre espace client sur <a href="https://' . $_SERVER["SERVER_NAME"] . '/client" target="_blank">https://' . $_SERVER["SERVER_NAME"] . '/client</a>
          <br><br>Pour obtenir plus de renseignements, veuillez communiquer avec nous. 
          <table style="border: 0px dashed #FB4314;font-size:17px;font-size:13px;margin-top:40px;"> 
              <tr> 
              <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO2.'" height="100"></td>
              <td width="99%" style="vertical-align:top;padding-top:10px;"><b style="font-size:15px;">' . $CIE_NOM . '</b>
              <br>' . $CIE_TEL1 . ' 
              ' . $CIE_TEL2 . '
              <br>' . $CIE_EML1 . '</td></tr>
          </table><br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a>
          </body></html>';
} else if($data['stat'] == "2"){
    $subject = "Confirmation de paiement: Facture #". $enID;
    $mainMessage = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body>
          <h3>Bonjour ' . $head_bill_to . ',</h3>
          Ceci est un reçu pour le paiement de la facture #'.$enID.'<br>
          Pour consulter vos factures rendez-vous dans votre espace client à l\'adresse suivante: <a href="https://' . $_SERVER["SERVER_NAME"] . '/client/">https://' . $_SERVER["SERVER_NAME"] . '/client/</a>
          <table style="border: 0px dashed #FB4314;font-size:17px;font-size:13px;margin-top:40px;"> 
              <tr> 
              <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO2.'" height="100"></td>
              <td width="99%" style="vertical-align:top;padding-top:10px;"><b style="font-size:15px;">' . $CIE_NOM . '</b>
              <br>' . $CIE_TEL1 . ' 
              ' . $CIE_TEL2 . '
              <br>' . $CIE_EML1 . '</td></tr>
            </table><br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a>
            </body></html>';
} else if($data['stat'] == "3"){
    $subject = "Annulation de la facture #". $enID;
    $mainMessage = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body>
          <h3>Bonjour ' . $head_bill_to . ',</h3>
          Ceci est une confirmation que la facture #'.$enID.' a été annulée<br>
          Pour consulter votre dossier rendez-vous dans votre espace client à l\'adresse suivante: <a href="https://' . $_SERVER["SERVER_NAME"] . '/client/">https://' . $_SERVER["SERVER_NAME"] . '/client/</a>
          <table style="border: 0px dashed #FB4314;font-size:17px;font-size:13px;margin-top:40px;"> 
              <tr> 
              <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO2.'" height="100"></td>
              <td width="99%" style="vertical-align:top;padding-top:10px;"><b style="font-size:15px;">' . $CIE_NOM . '</b>
              <br>' . $CIE_TEL1 . ' 
              ' . $CIE_TEL2 . '
              <br>' . $CIE_EML1 . '</td></tr>
              </table><br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a>
            </body></html>';

}


 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 $email = new PHPMailer();
 $email->CharSet = "UTF-8";
 $email->SetFrom($CIE_EML1,$CIE_NOM);
 $email->Subject = $subject;
 $email->Body = $mainMessage;
 $email->IsHTML(true);
 $email->AddAddress(dw3_decrypt($data['eml']));
 
 $file_to_attach = $_SERVER['DOCUMENT_ROOT'] . "/fs/invoice/". $enID . ".pdf";
 $email->AddAttachment( $file_to_attach , $enID . '.pdf' );
 $mail_ret = $email->Send();

if ($mail_ret == 1) {
        //update header
        $sql = "UPDATE invoice_head SET date_email='" . $datetime . "', user_email='0' WHERE id = '" . $enID . "' LIMIT 1";
        $result = mysqli_query($dw3_conn, $sql);
        echo "";
} else {
    echo $mail_ret;
}

$dw3_conn->close();
?>
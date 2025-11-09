<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dompdf/autoload.inc.php';
$enID  = $_GET['enID'];

use Dompdf\Dompdf; 
use Dompdf\Options;
$head_stotal = 0;

//data from head
$sql = "SELECT * FROM purchase_head WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_prepaid = round($data['prepaid_cash'],2);
$head_supplier = $data['supplier_id'];
$head_eml = $data['eml'];
$html_PDF = "<!DOCTYPE html><html><head>
    <title>" . $CIE_NOM . "</title><meta http-equiv=\"Content-Type\" content=\"text/html;\ charset=utf-8\"><style></style></head>
        <body style='text-align:left;'><img src='https://" . $_SERVER["SERVER_NAME"] . "/img/logo2.png' style='width:auto;height:100px;'><br>
            <h3 style='text-align:left;'>Commande #" . $enID . "</h3><br>
            <table style='width:100%;'>
                <tr><td colspan=3>" . $today . "</td><td colspan=2>Compte #" . $data['supplier_id'] . "</td></tr>
                <tr>
                    <td style='vertical-align:top;width:40px;'>De:</td><td>" . $data['name'] . "<br>" . $data['adr1'] . "<br>"; if($data['adr2'] != ""){ $html_PDF .= $data['adr2'] . "<br>";} $html_PDF .= $data['city'] . ", " . $data['prov'] . "<br>" . $data['country'] . ", " . $data['postal_code'] . "<br></td>
                    <td width='*'> </td>
                    <td style='vertical-align:top;width:40px;'>À:</td><td>" . $CIE_NOM . "<br>" . $CIE_ADR1 . "<br>"; if($CIE_ADR2 != ""){ $html_PDF .= $CIE_ADR2. "<br>";} $html_PDF .= $CIE_VILLE . ", " . $CIE_PROV . "<br>" . $CIE_PAYS . ", " . $CIE_CP . "</td>
                </tr>
                <tr><td colspan=2 style='text-align:left;'>" . $CIE_EML1 . " " . $CIE_TEL1 . " " . $CIE_TEL2 .  "</td><td></td><td colspan=2 style='text-align:right;'>" . $data['eml'] . " " . $data['tel'] . "</td>
            </tr></table>";

//sum to ship
$sql = "SELECT IFNULL(SUM(price*(qty_order-qty_shipped)),0) as head_stotal FROM purchase_line WHERE head_id = '" . $enID . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_stotal = $data['head_stotal'];
$head_tvq = round($head_stotal*0.05,2);
$head_tps = round($head_stotal*0.0975,2);
$head_total = round($head_stotal + $head_tps + $head_tvq,2);
//data from lines
$sql = "SELECT A.*, B.name_fr, B.url_img, B.upc FROM purchase_line A LEFT JOIN product B ON A.product_id = B.id WHERE A.head_id = " . $enID . " ORDER BY A.line";
$result = $dw3_conn->query($sql);
$numrows = $result->num_rows;
if ($numrows > 0) {	
    $html_PDF.= "<table cellspacing=0 style='width:100%;'><tr style='border:1px solid #333;background:#333;color:goldenrod;text-align:left;'><th style='border:1px solid #333;text-align:left;'></th><th style='border:1px solid #333;text-align:left;'>#UPC</th><th style='border:1px solid #333;text-align:left;'>Item</th><th style='border:1px solid #333;text-align:left;'>Qt. commandé</th><th style='border:1px solid #333;text-align:left;'>Qt. expédié</th></tr>";
    while($row = $result->fetch_assoc()) {
        $filename= $row["url_img"];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/product/" . $row["product_id"] . "/" . $filename)){
            $filename = "/img/nd.png";
        } else {
            if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/product/" . $row["product_id"] . "/" . $filename)){
                $filename = "/img/nd.png";
            }else{
                $filename = "/product/" . $row["product_id"] . "/" . $filename;
            }
        }
        $PRIX_LGN = $row["qty_order"] * $row["price"];
        $html_PDF.= "<tr>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;'><img src='https://" . $_SERVER["SERVER_NAME"] .  $filename . "' style='height:40px;width:auto;max-width:60px;'></td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;'>" . $row["upc"] . "</td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;'>" . $row["name_fr"] . "</td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;'>" . $row["qty_order"] . "</td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;'>" . $row["qty_shipped"] . "</td>";
        //$html_PDF.= "<td style='border-bottom:1px solid gold;'>" . $row["price"] . "</td>";
        //$html_PDF.= "<td style='border-bottom:1px solid gold;'>" . $PRIX_LGN . "</td>";
        $html_PDF.= "</tr>";
    }
    $head_ship_cost = "0.00";
    $html_PDF.= "</table>";
    //$html_PDF.= "</table><hr style='height:1px;background:#777;'>";
    //$html_PDF.= "<table cellspacing=0><tr><td>Sous-total</td><td style='text-align:right;'><b>" . number_format($head_stotal,2,',','.') . "</b>$</td></tr>";
    //$html_PDF.= "<tr><td style='width:150px;'>TPS 5%</td><td style='text-align:right;'>" . number_format($head_tps,2,',','.') . "$</td></tr>";
    //$html_PDF.= "<tr><td>TVQ 9.975%</td><td style='text-align:right;'>" . number_format($head_tvq,2,',','.') . "$</td></tr>";
    //$html_PDF.= "<tr><td>Transport</td><td style='text-align:right;'>" . number_format($head_ship_cost,2,',','.') . "$</td></tr>";
    //$html_PDF.= "<tr><td style='border-bottom:1px solid gold;'>Total</td><td style='text-align:right;border-bottom:1px solid gold;'><b>" . number_format($head_total,2,',','.') . "</b>$</td></tr>";
    //$html_PDF.= "<tr><td>Prépaiment</td><td style='text-align:right;'>" . number_format($head_prepaid,2,',','.') . "$</td></tr>";
    //if (($head_total - $head_prepaid)<0){
    //    $html_PDF.= "<tr><td>Balance au compte</td><td style='text-align:right;'>" . number_format($head_total - $head_prepaid,2,',','.') . "$</td></tr>";
    //}else if(($head_total - $head_prepaid)>0){
    //    $html_PDF.= "<tr><td>Balance à payer</td><td style='text-align:right;'>" . number_format($head_total - $head_prepaid,2,',','.') . "$</td></tr>";
    //} else if (($head_total - $head_prepaid)==0){
    //    $html_PDF.= "<tr><td>Balance</td><td style='text-align:right;'>" . number_format($head_total - $head_prepaid,2,',','.') . "$</td></tr>";
    //}
    //$html_PDF.= "</table>";
    $html_PDF .= "<div id='footer' style='position:fixed;bottom:0px;right:0px;left:0px;height:20px;'><table style='width:100%;'><tr><th style='width:50px;border: 0px solid #333;'>&#160;&#160;</th><th style='border:0px solid grey;'>Copyright &copy; " . date("Y") . " " . $CIE_NOM . "</th><th style='width:50px;border: 0px solid #333;'><span class='page-number'>Page </span></th></tr></table></div>";
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
    $fileatt = $dompdf->output("Invoice.pdf"); 
    $semi_rand     = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
    $fileatttype = "application/pdf";

} else {
    $dw3_conn->close();
    die("Erreur la commande ne contient aucuns items.");
}
//data from head
$sql = "SELECT * FROM supplier WHERE id = '" . $head_supplier . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if($head_eml == "" && $data["eml1"] == ""){
    $dw3_conn->close();
    die("Erreur aucun email trouvé pour envoyer la commande d'achat.");
} else if ($head_eml == "" && $data["eml1"] != ""){
    $head_eml = $data["eml1"];
}
$fileattname = "Purchase_". $enID . ".pdf";
$subject = iconv('UTF-8','ASCII//TRANSLIT',$CIE_NOM ." - Commande #". $enID . " " . $datetime); //je sais pas pk mais si je met un accent dans le sujet ca passe pas..
$mainMessage = ' 
        <h3>Bonjour ' . trim($data["contact_name"] . ' ' . $data["company_name"]  . ',</h3>
        Avis de commande d\'achat pour vos produits/services. Elle a été approuvée et sera payée selon ce qui a été convenus.<br>
        Vous trouverez ci-joint notre commande en PDF. Veuillez noter que les montants ne seront pas inscrits sur ce document.<br><br>
        <table style="border: 0px dashed #FB4314;font-size:17px;font-size:13px;"> 
            <tr> 
            <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/img/logo.png" style="height:100px;width:auto;"></td>
            <td width="99%" style="vertical-align:top;"><b style="font-size:15px;">' . $CIE_NOM . '</b>
            <br>' . $CIE_TEL1 . ' 
            ' . $CIE_TEL2 . '
            <br>' . $CIE_EML1 . '
            <br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a></td> 
            </tr> 
        </table>';
$headers = 'From: ' . $CIE_NOM . ' <' . $CIE_EML1 . '>' . "\r\n";
$headers .= "MIME-Version: 1.0\n" .
  "Content-Type: multipart/mixed;\n" .
  " boundary=\"{$mime_boundary}\"";
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=UTF-8" . "\r\n" . "Content-Transfer-Encoding: 7bit\n\n" . $mainMessage  . "\n\n";
$fileatt = chunk_split(base64_encode($fileatt));
$message .= "--{$mime_boundary}\n" .
  "Content-Type: {$fileatttype};\n" . " name=\"{$fileattname}\"\n" .
  "Content-Disposition: attachment;\n" . " filename=\"{$fileattname}\"\n" .
  "Content-Transfer-Encoding: base64\n\n" . $fileatt . "\n\n" . "--{$mime_boundary}--\n";
if(mail($head_eml, $subject, $message, $headers)) {
    //update header
        $sql = "UPDATE purchase_head SET date_email='" . $datetime . "', user_email='" . $USER . "' WHERE id = '" . $enID . "' LIMIT 1";
        $result = mysqli_query($dw3_conn, $sql);
    echo "";
  }
  else {
    echo "There was an error sending the mail.";
  }
$dw3_conn->close();
?>
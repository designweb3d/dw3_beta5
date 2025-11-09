<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dompdf/autoload.inc.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
$enID  = $_GET['enID'];
$enEML  = $_GET['enEML'];

$SUB_TOTAL = 0;

use Dompdf\Dompdf; 
use Dompdf\Options;
$head_stotal = 0;

//data from head
$sql = "SELECT * FROM order_head WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
    if ($data['stat'] == 7){ $head_status = "Soumission"; } else { $head_status = "Commande"; }
$head_prepaid = round($data['prepaid_cash'],2);
$head_customer = $data['customer_id'];
$html_PDF = "<!DOCTYPE html><html><head>
    <title>" . $CIE_NOM . "</title><meta http-equiv=\"Content-Type\" content=\"text/html;\ charset=utf-8\"><style></style></head>
        <body style='text-align:left;'><img src='https://" . $_SERVER["SERVER_NAME"] . "/pub/img/".$CIE_LOGO2."' style='height:100px;width:auto;max-width:500px;'><br>
            <h3 style='text-align:left;'>" . $head_status . " #" . $enID . "</h3>
            <table style='width:100%;'>
                <tr><td colspan=3>" . $today . "</td><td colspan=2>Compte #" . $data['customer_id'] . "</td></tr>
                <tr>
                    <td style='vertical-align:top;width:40px;'>De:</td><td>" . $CIE_NOM . "<br>" . $CIE_ADR1 . "<br>"; if($CIE_ADR2 != ""){ $html_PDF .= $CIE_ADR2. "<br>";} $html_PDF .= $CIE_VILLE . ", " . $CIE_PROV . "<br>" . $CIE_PAYS . ", " . $CIE_CP . "</td>
                    <td width='*'> </td>
                    <td style='vertical-align:top;width:40px;'>À:</td><td>" . dw3_decrypt($data['name']) . "<br>" . dw3_decrypt($data['adr1']) . "<br>"; if($data['adr2'] != ""){ $html_PDF .= dw3_decrypt($data['adr2']) . "<br>";} $html_PDF .= $data['city'] . ", " . $data['prov'] . "<br>" . $data['country'] . ", " . $data['postal_code'] . "<br></td>
                </tr>
                <tr><td colspan=2 style='text-align:left;'>" . $CIE_EML1 . " " . $CIE_TEL1 . " " . $CIE_TEL2 .  "</td><td></td><td colspan=2 style='text-align:right;'>" . dw3_decrypt($data['eml']) . " " . dw3_decrypt($data['tel']) . "</td>
            </tr></table>";

//data from lines
$sql = "SELECT A.*, B.name_fr, B.url_img, B.upc FROM order_line A LEFT JOIN product B ON A.product_id = B.id WHERE A.head_id = " . $enID . " ORDER BY A.line";
$result = $dw3_conn->query($sql);
$numrows = $result->num_rows;
if ($numrows > 0) {	
    $html_PDF.= "<table cellspacing=0 style='width:100%;'><tr style='border-top:1px solid #555;background:#666;color:gold;text-align:left;'><th colspan='2' style='border:1px solid #333;text-align:left;'></th><th style='border:1px solid #333;text-align:left;'>Quantité</th><th style='border:1px solid #333;text-align:left;'>Prix unitaire</th><th style='border:1px solid #333;text-align:left;'>Total</th></tr>";
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
        $product_id = $row["product_id"];
        $product_qty = $row["qty_order"];
        $customer_id = $head_customer;
        include($_SERVER['DOCUMENT_ROOT'] . '/app/product/getPRICE.php');
        $PRIX_LGN = $row["qty_order"] * $product_price;
        $SUB_TOTAL += $PRIX_LGN;
        $html_PDF.= "<tr>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;'><img src='https://" . $_SERVER["SERVER_NAME"] .  $filename . "' style='height:40px;width:auto;max-width:60px;'></td>";
        $html_PDF.= "<td width='*' style='border-bottom:1px solid gold;'>" . $row["product_desc"] . $row["product_opt"]. "</td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;text-align:center;'>" . round($row["qty_order"]) . "</td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;text-align:right;'>" . number_format($product_price, 2, '.', ' ') . "</td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;text-align:right;'>" . number_format($PRIX_LGN, 2, '.', ' ') . "</td>";
        $html_PDF.= "</tr>";
    }
    $html_PDF.= "<tr><td colspan=5 style='text-align:right;border-top:2px solid #333;'><b>Sous-total:</b></td><td style='border-top:2px solid #333;'>" . number_format($SUB_TOTAL, 2, '.', ' ') . "</td></tr>";
    /* if ($data['tax_rate'] > 0){
        $tax_amount = round($SUB_TOTAL * ($data['tax_rate']/100),2);
        $html_PDF.= "<tr><td colspan=5 style='text-align:right;'><b>Taxe (" . $data['tax_rate'] . "%):</b></td><td>" . number_format($tax_amount, 2, '.', ' ') . "</td></tr>";
    } else {
        $tax_amount = 0;
    }
    if ($head_prepaid > 0){
        $html_PDF.= "<tr><td colspan=5 style='text-align:right;'><b>Prépayé:</b></td><td>-" . number_format($head_prepaid, 2, '.', ' ') . "</td></tr>";
    }
    $grand_total = round($SUB_TOTAL + $tax_amount - $head_prepaid,2);
    $html_PDF.= "<tr><td colspan=5 style='text-align:right;border-top:2px solid #333;'><b>Total à payer:</b></td><td style='border-top:2px solid #333;'>" . number_format($grand_total, 2, '.', ' ') . "</td></tr>"; */
    $html_PDF.= "</table>";
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
    $fileatt = $dompdf->output();
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/fs/order/". $enID . ".pdf", $fileatt); 
       
/*     $semi_rand     = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
    $fileatttype = "application/pdf"; */

} else {
    $dw3_conn->close();
    die("Erreur la " . strtolower($head_status) . " ne contient aucuns items.");
}
//data from head
$sql = "SELECT * FROM customer WHERE id = '" . $head_customer . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$fileattname = "Order_". $enID . ".pdf";
$subject = $CIE_NOM ." - " . $head_status . " #". $enID . " " . $datetime;
$mainMessage = ' 
        <h3>Bonjour ' . trim($data["prefix"] . ' ' . dw3_decrypt($data["first_name"]) . ' ' . dw3_decrypt($data["middle_name"]) . ' ' . dw3_decrypt($data["last_name"]) . ' ' . dw3_decrypt($data["suffix"])) . ',</h3>';
        if ($head_status == "Soumission") {
            $mainMessage .= 'Votre soumission a été complétée! Nous attendons votre retour pour discuter des prochaines étapes.';
        } else {
            $mainMessage .= 'Merci pour votre commande! Elle sera traitée le plus rapidement possible.';
        }
        $mainMessage .= '<br>Vous trouverez ci-joint votre ' . strtolower($head_status) . ' en PDF, qui est aussi dans votre espace client, <br>
        ainsi que la facture et les détails d\'expédition, en vous connectant à l\'adresse suivante: <br><br>
        <a href="https://' . $_SERVER["SERVER_NAME"] . '/client/dashboard.php?KEY='. $data["key_128"] . '">https://' . $_SERVER["SERVER_NAME"] . '/client/dashboard.php?KEY='. $data["key_128"] . '</a>
        <br><br><br>
        <table style="border: 0px dashed #FB4314;font-size:17px;font-size:13px;"> 
            <tr> 
            <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO1.'" height="100"></td>
            <td width="*" style="vertical-align:top;"><b style="font-size:15px;">' . $CIE_NOM . '</b>
            <br>' . $CIE_TEL1 . ' 
            ' . $CIE_TEL2 . '
            <br>' . $CIE_EML1 . '
            <br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a></td> 
            </tr> 
        </table>
        <span style="font-size:12px">Ce courriel est confidentiel, peut être protégé par le secret professionnel et est destiné à l’usage exclusif de son destinataire. Si vous avez reçu ce message par erreur ou si vous n’êtes pas le destinataire prévu, veuillez le détruire, ainsi que toutes pièces jointes ou copies, et il vous est interdit de conserver, distribuer, divulguer ou utiliser les informations qu’il contient. Veuillez nous informer de l’erreur de livraison par courriel de retour. Veuillez noter que les courriels non chiffrés peuvent ne pas être sécurisés et ne doivent pas être utilisés pour communiquer des informations personnelles. Veuillez réduire le risque de divulgation involontaire en chiffrant les courriels contenant des informations personnelles. En cas de doute sur la sécurité d’un courriel ou la confidentialité d’un message, veuillez nous contacter. Merci de votre coopération.</span>';
/* $headers = 'From: ' . $CIE_NOM . ' <' . $CIE_EML1 . '>' . "\r\n";
$headers .= "MIME-Version: 1.0\n" .
  "Content-Type: multipart/mixed;\n" .
  " boundary=\"{$mime_boundary}\"";
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=UTF-8" . "\r\n" . "Content-Transfer-Encoding: 7bit\n\n" . $mainMessage  . "\n\n";
$fileatt = chunk_split(base64_encode($fileatt));
$message .= "--{$mime_boundary}\n" .
  "Content-Type: {$fileatttype};\n" . " name=\"{$fileattname}\"\n" .
  "Content-Disposition: attachment;\n" . " filename=\"{$fileattname}\"\n" .
  "Content-Transfer-Encoding: base64\n\n" . $fileatt . "\n\n" . "--{$mime_boundary}--\n"; */

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 $email = new PHPMailer();
 $email->CharSet = "UTF-8";
 $email->SetFrom($CIE_EML1,$CIE_NOM); //Name is optional
 $email->Subject   = $subject;
 $email->Body      = $mainMessage;
 $email->IsHTML(true); 
 $email->AddAddress( $enEML );
 $file_to_attach = $_SERVER['DOCUMENT_ROOT'] . "/fs/order/". $enID . ".pdf";
 $email->AddAttachment( $file_to_attach , $enID . '.pdf' );
 $mail_ret = $email->Send();

if ($mail_ret == 1) {
        //update header
        $sql = "UPDATE order_head SET date_email='" . $datetime . "', user_email='" . $USER . "' WHERE id = '" . $enID . "' LIMIT 1";
        $result = mysqli_query($dw3_conn, $sql);

        //ajout évènement
        $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
            VALUES('EMAIL','Envoi de " . strtolower($head_status) . " par courriel','No de " . strtolower($head_status) . ": ".$enID."\nEnvoyé par: ".$USER_FULLNAME ."','". $datetime ."','".$data['id']."','".$USER."')";
        $result_task = $dw3_conn->query($sql_task);

        /* $sql = "INSERT INTO email (head_from,head_to,to_cc,to_bcc,subject,date_created,box,user_created,is_attachement) VALUES (
            '".$CIE_EML1."',
            '".$enEML."',
            '',
            '',
            '".$subject."',
            '".$datetime."',
            'SENT',
            '".$USER."','1')";
                if ($dw3_conn->query($sql) === TRUE) {
                    $last_id = $dw3_conn->insert_id;
                    if (!file_exists($_SERVER['DOCUMENT_ROOT']."/app/email/mail/".trim($last_id))) {
                        mkdir($_SERVER['DOCUMENT_ROOT']."/app/email/mail/".trim($last_id), 0777, true);
                        $fhtml = fopen($_SERVER['DOCUMENT_ROOT']."/app/email/mail/".trim($last_id)."/message.html", "w") or die("Unable to open file!");
                        fwrite($fhtml, $mainMessage);
                        fclose($fhtml);
                        file_put_contents($_SERVER['DOCUMENT_ROOT'] ."/app/email/mail/".trim($last_id)."/". $enID . ".pdf", $fileatt);
                    }
                } */

        echo "";
} else {
    echo $mail_ret;
}

$dw3_conn->close();
?>
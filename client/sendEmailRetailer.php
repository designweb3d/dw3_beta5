<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
$enID  = $_GET['ID'];

//data from head
$sql = "SELECT * FROM invoice_head WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
//data from location
/* $sql2 = "SELECT * FROM location WHERE id = '" . $data['location_id'] . "' LIMIT 1";
$result2 = mysqli_query($dw3_conn, $sql2);
$data2 = mysqli_fetch_assoc($result2);
$retailer_eml = $data2['eml1'];
$retailer_name = $data2['name']; */
//$head_prepaid = round($paid+$data['prepaid']+$data['paid_cash']+$data['paid_stripe']+$data['paid_moneris']+$data['paid_check'],2);
$head_order_id = $data['order_id'];
$head_total = round($data['total'],2);
$head_customer = dw3_decrypt($data['name']);

    //$subject = iconv('UTF-8','ASCII//TRANSLIT',"Nouvelle Commande #". $head_order_id); //je sais pas pk mais si je met un accent dans le sujet ca passe pas..
    $subject = "Nouvelle commande pour ". $head_customer;
    $mainMessage1 = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body>
          <h3>Bonjour,</h3>
          <h2>Vérifiez si une expédition ou une autre action est nécessaire</h2><br>
          Date et heure commandé: '.$data['date_modified'].'<br>
          Client: '.$head_customer.'<br>
          #Tel Client: '.dw3_decrypt($data['tel']).'<br>
          Mode de livraison: non-déterminé<br><br>
          Détails de la commande:<br><table cellspacing=0 style="width:100%;">
            <tr style="border:1px solid #333;background:#333;color:goldenrod;text-align:left;"><th style="text-align:left;width:100px;padding:5px;">Annonce#</th><th style="text-align:left;padding:5px;">Produit</th></tr>';
    $mainMessage3 = ' </table>
            <b>Veuillez ne pas répondre à ce courriel.</b><br><br>Pour voir plus de détails sur la commande vous pouvez vous connecter à votre espace-client sur: <a href="https://' . $_SERVER["SERVER_NAME"] . '/client">https://' . $_SERVER["SERVER_NAME"] . '/client</a> <br><br>Si vous avez des questions veuillez communiquer avec nous:<br>
            <table style="border: 0px dashed #FB4314;font-size:17px;font-size:13px;"> 
              <tr> 
              <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO1.'" height="100"></td>
              <td width="99%" style="vertical-align:top;padding-top:10px;"><b style="font-size:15px;">' . $CIE_NOM . '</b>
              <br>' . $CIE_TEL1 . ' 
              ' . $CIE_TEL2 . '
              <br>' . $CIE_EML1 . '
              <br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a></td> 
              </tr></table></body></html>';

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 $email = new PHPMailer();
 $email->CharSet = "UTF-8";
 $email->SetFrom("$CIE_EML1","$CIE_NOM"); //Name is optional
 $email->Subject   = $subject;

 $sql = "SELECT A.*,B.customer_id as retailer_id, C.eml1 as retailer_eml
        FROM order_line 
        LEFT JOIN classified B ON B.id = A.classified_id 
        LEFT JOIN classified C ON C.id = B.customer_id
        WHERE head_id = '".$head_order_id."' ORDER BY retailer_id ASC";
 $result = $dw3_conn->query($sql);
 $numrows = $result->num_rows;
 if ($numrows > 0) {
    $mainMessage2 =	"";
    $retailer_id = "";
     while($row = $result->fetch_assoc()) {
        if ($retailer_id != $row["retailer_id"] && $retailer_id != ""){
            $email->Body = $mainMessage1.$mainMessage2.$mainMessage3;
            $email->IsHTML(true); 
            $email->AddAddress($retailer_eml);
            $email->AddAddress($CIE_EML1);
            $mail_ret = $email->Send();
            $mainMessage2 = '<tr><td style="border:1px solid #333;text-align:center;padding:5px;">'.$row["classified_id"].'</td><td style="border:1px solid #333;padding:5px;">'.$row["product_desc"].$row["product_opt"].'</td></tr>';
        } else if ($retailer_id == $row["retailer_id"] || $retailer_id == ""){
            $mainMessage2 .= '<tr><td style="border:1px solid #333;text-align:center;padding:5px;">'.$row["classified_id"].'</td><td style="border:1px solid #333;padding:5px;">'.$row["product_desc"].$row["product_opt"].'</td></tr>';
        }
        $retailer_id = $row["retailer_id"];
        $retailer_eml = $row["retailer_eml"];
     }
     $email->Body = $mainMessage1.$mainMessage2.$mainMessage3;
     $email->IsHTML(true); 
     $email->AddAddress($retailer_eml);
     $email->AddAddress($CIE_EML1);
     $mail_ret = $email->Send();
   }

if ($mail_ret == 1) {
        echo "";
} else {
    echo $mail_ret;
}
$dw3_conn->close();
?>
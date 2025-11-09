<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
$enID  = $_GET['enID'];
$enEML  = $_GET['enEML'];

//data from invoice head
$sql = "SELECT * FROM invoice_head WHERE id = '" . $enID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if ($data['company'] != ""){
    $head_bill_to = $data['company'];
} else {
    $head_bill_to = dw3_decrypt($data['name']);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$email = new PHPMailer();
$email->CharSet = "UTF-8";

$fileattname = "invoice_". $enID . ".pdf";

$subject = "Annulation de la facture #". $enID;
$mainMessage = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body>
        <h3>Bonjour ' . $head_bill_to . ',</h3>
        Ceci est une confirmation que la facture #'.$enID.' a été annulée<br>
        Pour consulter votre dossier rendez-vous dans votre espace client à l\'adresse suivante: <a href="https://' . $_SERVER["SERVER_NAME"] . '/client/">https://' . $_SERVER["SERVER_NAME"] . '/client/</a>
        <table style="border-top: 0px dashed #FB4314;font-size:17px;font-size:13px;"> 
            <tr> 
            <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO1.'" width="100"></td>
            <td width="99%" style="vertical-align:top;padding-top:10px;"><b style="font-size:15px;">' . $CIE_NOM . '</b>
            <br>' . $CIE_TEL1 . ' 
            <br>' . $CIE_TEL2 . '
            <br>' . $CIE_EML1 . '</td> 
            </tr></table><br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a>
            <span style="font-size:12px">Ce courriel est confidentiel, peut être protégé par le secret professionnel et est destiné à l’usage exclusif de son destinataire. Si vous avez reçu ce message par erreur ou si vous n’êtes pas le destinataire prévu, veuillez le détruire, ainsi que toutes pièces jointes ou copies, et il vous est interdit de conserver, distribuer, divulguer ou utiliser les informations qu’il contient. Veuillez nous informer de l’erreur de livraison par courriel de retour. Veuillez noter que les courriels non chiffrés peuvent ne pas être sécurisés et ne doivent pas être utilisés pour communiquer des informations personnelles. Veuillez réduire le risque de divulgation involontaire en chiffrant les courriels contenant des informations personnelles. En cas de doute sur la sécurité d’un courriel ou la confidentialité d’un message, veuillez nous contacter. Merci de votre coopération.</span>
            </body></html>';

$email->SetFrom($CIE_EML1,$CIE_NOM); //Name is optional
$email->Subject = $subject;
$email->Body = $mainMessage;
$email->IsHTML(true); 
$email->AddAddress( $enEML );
$file_to_attach = $_SERVER['DOCUMENT_ROOT'] . "/fs/invoice/". $enID . ".pdf";
$email->AddAttachment( $file_to_attach , $enID . '.pdf' );
$mail_ret = $email->Send();

if ($mail_ret == 1) {
        //update header
        $sql = "UPDATE invoice_head SET date_email='" . $datetime . "', user_email='" . $USER . "' WHERE id = '" . $enID . "' LIMIT 1";
        $result = mysqli_query($dw3_conn, $sql);

        //ajout évènement
        $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
            VALUES('EMAIL','Envoi de facture annulée par courriel','No de Facture: ".$enID."\nEnvoyé par: ".$USER_FULLNAME ."','". $datetime ."','".$data['customer_id']."','".$USER."')";
        $result_task = $dw3_conn->query($sql_task);

        echo "";
} else {
    echo $mail_ret;
}

$dw3_conn->close();
?>
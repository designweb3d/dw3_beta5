<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php';
use PHPMailer\PHPMailer\PHPMailer;
$email = new PHPMailer();
$email->CharSet = "UTF-8";
$email->Priority = 1;
$ID = $_GET['ID'];

    $sql2 = "SELECT * FROM customer WHERE id = '" . $ID . "' LIMIT 1";
	$result2 = $dw3_conn->query($sql2);
	if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
            if ($row2["lang"] == "FR" || $row2["lang"] == "fr"){
                $subject = "Confirmation de remboursement - " . $CIE_NOM ;
                $htmlContent = '
                <!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
                <body> 
                    <h3>Bonjour ' . dw3_decrypt($row2["first_name"]) . ' ' . dw3_decrypt($row2["last_name"]) . ',</h3>
                    Votre crédit de <b>' .$row2["balance"]. '$</b>CAD vous sera transféré de la façon convenue le prochain jour ouvrable. Le délai de dépôt peut varier en fonction des délais de traitement de votre banque.
                    <br><div style="border: 0px dashed #FB4314; width: 100%;padding:2px;text-align:center;"><b>SVP ne pas répondre à ce courriel.</b></div>
                    Pour communiquer avec nous:<br>
                    <table style="font-size:17px;"> 
                        <tr> 
                        <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO1.'" height="100"/></td>
                        <td><b>' . $CIE_NOM . '</b>
                        <br>' . $CIE_EML1 . '
                        <br>' . $CIE_TEL1 . '
                        </td> 
                        </tr> 
                    </table><br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a><br>
                    <span style="font-size:12px">Ce courriel est confidentiel, peut être protégé par le secret professionnel et est destiné à l’usage exclusif de son destinataire. Si vous avez reçu ce message par erreur ou si vous n’êtes pas le destinataire prévu, veuillez le détruire, ainsi que toutes pièces jointes ou copies, et il vous est interdit de conserver, distribuer, divulguer ou utiliser les informations qu’il contient. Veuillez nous informer de l’erreur de livraison par courriel de retour. Veuillez noter que les courriels non chiffrés peuvent ne pas être sécurisés et ne doivent pas être utilisés pour communiquer des informations personnelles. Veuillez réduire le risque de divulgation involontaire en chiffrant les courriels contenant des informations personnelles. En cas de doute sur la sécurité d’un courriel ou la confidentialité d’un message, veuillez nous contacter. Merci de votre coopération.</span>
                </body></html>';
            } else {
                $subject = "Refund confirmation - " . $CIE_NOM ;
                $htmlContent = '
                <!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
                <body> 
                    <h3>Hi ' . dw3_decrypt($row2["first_name"]) . ' ' . dw3_decrypt($row2["last_name"]) . ',</h3>
                    Your <b>' .$row2["balance"]. '$</b>CAD credit will be transferred to you as agreed upon on the next business day. Deposit times may vary depending on your bank’s processing times.
                    <br><div style="border: 0px dashed #FB4314; width: 100%;padding:2px;text-align:center;"><b>Please do not reply to this email.</b></div>
                    To contact us:<br>
                    <table style="font-size:17px;"> 
                        <tr> 
                        <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO1.'" height="100"/></td>
                        <td><b>' . $CIE_NOM . '</b>
                        <br>' . $CIE_EML1 . '
                        <br>' . $CIE_TEL1 . '
                        </td> 
                        </tr> 
                    </table><br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a><br>
                    <span style="font-size:12px">This email message is confidential, may be legally privileged and is intended for the exclusive use of the addressee. If you received this message in error or are not the intended recipient, you should destroy the email message and any attachments or copies, and you are prohibited from retaining, distributing, disclosing or using any information contained. Please inform us of the delivery error by return email. Please be aware that non-encrypted internet email may not be secure and should not be used as a method to communicate personal account information. Please reduce the risk of unintended disclosure by encrypting email messages containing personal account information. If you are uncertain about the security of an email or the confidentiality of any message, please contact us. Thank you for your cooperation.</span>
                </body></html>';  
            }
            //$mailer = mail($row2["eml1"], $subject, $htmlContent, $headers);
            $email->SetFrom("no-reply@".$_SERVER["SERVER_NAME"],$CIE_NOM); //Name is optional
            $email->Subject = $subject;
            $email->Body = $htmlContent;
            $email->IsHTML(true); 
            $email->AddAddress(dw3_decrypt($row2["eml1"]));
            //$file_to_attach = $_SERVER['DOCUMENT_ROOT'] . "/fs/invoice/". $enID . ".pdf";
            //$email->AddAttachment( $file_to_attach , $enID . '.pdf' );
            $mail_ret = $email->Send();

            $sqlx = "UPDATE customer SET balance=0, balance_before='".$row2["balance"]."'  WHERE id= '" . $ID . "' LIMIT 1";
            $resultx = $dw3_conn->query($sqlx);

/*             $sql = "INSERT INTO email (head_from,head_to,to_cc,to_bcc,subject,date_created,box,user_created) VALUES (
                '".$CIE_EML1."',
                '".dw3_decrypt($row2["eml1"])."',
                '',
                '',
                '".$subject."',
                '".$datetime."',
                'SENT',
                '".$USER."')";
                    if ($dw3_conn->query($sql) === TRUE) {
                        $last_id = $dw3_conn->insert_id;
                        if (!file_exists($_SERVER['DOCUMENT_ROOT']."/app/email/mail/".trim($last_id))) {
                            mkdir($_SERVER['DOCUMENT_ROOT']."/app/email/mail/".trim($last_id), 0777, true);
                            $fhtml = fopen($_SERVER['DOCUMENT_ROOT']."/app/email/mail/".trim($last_id)."/message.html", "w") or die("Unable to open file!");
                            fwrite($fhtml, $htmlContent);
                            fclose($fhtml);
                        }
                    } */
        //ajout évènement
        $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
            VALUES('EMAIL','Courriel crédit au client','Envoyé par: ".$USER_FULLNAME ." \n Montant: ".$row2["balance"]."$','". $datetime ."','". $ID."','".$USER."')";
        $result_task = $dw3_conn->query($sql_task); 
        }
                        
    $dw3_conn->close();
    die("");
    }
?>	

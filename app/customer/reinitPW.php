<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$email = new PHPMailer();
$email->CharSet = "UTF-8";
$email->Priority = 1;
$ID = $_GET['clID'];
$KEY = generateRandomString(128) ;
$key_expire = date('Y-m-d H:i:s', strtotime( date("Y-m-d H:i:s") . ' + 1 days'));
$subject = "Réinitialisation du mot de passe - " . $CIE_NOM; //je sais pas pk mais on dirait que si je met un accent dans le sujet ca passe pas..
/* $headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'From: no-reply@'.$_SERVER["SERVER_NAME"]  . "\r\n" ;
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n"; */

    $sql = "UPDATE customer SET key_reset= '" .  $KEY . "', key_expire='" . $key_expire . "', date_modified='".$datetime."'
    WHERE id= '" . $ID . "' LIMIT 1";
    if ($dw3_conn->query($sql) === FALSE) {
        $dw3_conn->close();
        //die("err upd cust");
        die("Erreur de mise à jour, veuillez contacter l'administrateur pour corriger le problème ou essayez un mot de passe différent.");
    }

    $sql2 = "SELECT * FROM customer WHERE id = '" . $ID . "' LIMIT 1";
	$result2 = $dw3_conn->query($sql2);
	if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
            $htmlContent = ' 
            <!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
            <body> 
                <h3>Bonjour ' . dw3_decrypt($row2["first_name"]) . ' ' . dw3_decrypt($row2["last_name"]) . ',</h3>
                <b>Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien suivant:</b> <a href="https://' . $_SERVER["SERVER_NAME"] . '/sbin/reinitpw.php?KEY=' . $KEY .'">"https://' . $_SERVER["SERVER_NAME"] . '/sbin/reinitpw.php?KEY=' . $KEY .'"</a><br><hr>Ce lien expire dans 24H ->' . $key_expire . '.' . 
                '<br><div style="border: 0px dashed #FB4314; width: 100%;padding:2px;text-align:center;"><b>SVP ne pas répondre à ce courriel.</b></div>
                Pour communiquer avec nous:<br>
                <table style="font-size:17px;"> 
                    <tr> 
                    <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO1.'" height="100"/></td>
                    <td width="99%"><b>' . $CIE_NOM . '</b>
                    <br>' . $CIE_EML1 . '
                    <br>' . $CIE_TEL1 . '
                    <br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a></td> 
                    </tr> 
                </table> 
            </html>';

            //$mailer = mail($row2["eml1"], $subject, $htmlContent, $headers);
            $email->SetFrom($CIE_EML1,$CIE_NOM); //Name is optional
            $email->Subject = $subject;
            $email->Body = $htmlContent;
            $email->IsHTML(true); 
            $email->AddAddress(dw3_decrypt($row2["eml1"]));
            //$file_to_attach = $_SERVER['DOCUMENT_ROOT'] . "/fs/invoice/". $enID . ".pdf";
            //$email->AddAttachment( $file_to_attach , $enID . '.pdf' );
            $mail_ret = $email->Send();

            //if ($mail_ret == 1) {
            //die($mailer . "cl");

            /* $sql = "INSERT INTO email (head_from,head_to,to_cc,to_bcc,subject,date_created,box,user_created) VALUES (
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
                        //echo $last_id;
                    } */
                $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
                    VALUES('EMAIL','Courriel pour réinitialiser le mot de passe du client','Envoyé par: ".$USER_FULLNAME ."','". $datetime ."','". $ID."','".$USER."')";
                $result_task = $dw3_conn->query($sql_task); 
            $dw3_conn->close();
            die("");
        }
    }
    

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>	

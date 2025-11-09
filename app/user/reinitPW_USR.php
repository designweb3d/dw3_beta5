<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$USID = trim(htmlspecialchars($_GET['USID']??""));

if ( $USID=="") {die("");}

$sql = "SELECT * FROM user WHERE id= '" . $USID . "' LIMIT 1";
$USER_TYPE = "" ;
$KEY = generateRandomString(128) ;
$key_expire = date('Y-m-d H:i:s', strtotime( date("Y-m-d H:i:s") . ' + 1 days'));
$subject = "Modification du mot de passe - ". $_SERVER["SERVER_NAME"]; //je sais pas pk mais on dirait que si je met un accent dans le sujet ca passe pas..
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'From: no-reply@'.$_SERVER["SERVER_NAME"]  . "\r\n" ;
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

//check user first
$result = $dw3_conn->query($sql);
if ($result->num_rows == 0) {
    //if not a user maybe a customer
    //$result2 = $dw3_conn->query($sql2);
    //if ($result2->num_rows == 0) { //no user and no customer found exit         
        //$dw3_conn->close();
        die("nf");
    //} else { //a customer was found
        
    //}
} else { //a user was found	
    while($row = $result->fetch_assoc()) {
        $EML = $row["eml1"];
        $sql = "UPDATE user SET key_reset= '" .  $KEY . "', key_expire='" . $key_expire . "' 
                WHERE id= '" . $USID . "' LIMIT 1";
        if ($dw3_conn->query($sql) === FALSE) {
            $dw3_conn->close();
            //die("err upd usr");
            die("");
        }
        //send email
        $email = new PHPMailer();
        $email->CharSet = "UTF-8";

        $htmlContent = ' 
        <html> 
        <head> 
            <title>' . $CIE_NOM . '</title> 
        </head> 
        <body> 
            <h3>Bonjour ' . $row["prefix"] . ' ' . $row["first_name"] . ' ' . $row["middle_name"] . ' ' . $row["last_name"] . ' ' . $row["suffix"] . ',</h3>
            <b>Pour modifier votre mot de passe, veuillez cliquer sur le lien suivant:</b> <a href="https://' . $_SERVER["SERVER_NAME"] . '/sbin/reinitpw.php?KEY=' . $KEY .'">"https://' . $_SERVER["SERVER_NAME"] . '/sbin /reinitpw.php?KEY=' . $KEY .'"</a><br>Ce lien expire dans 24H, soit:' . $key_expire . '.' . 
            '<br><br><div style="width: 100%;padding:2px;text-align:center;margin-top:20px;"><b>SVP ne pas répondre à ce courriel.</b></div>
            Pour communiquer avec nous:<br>
            <table style="font-size:17px;border:0px;"> 
                <tr> 
                <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/favicon.ico" style="height:100px;width:auto;"  height="100" width="auto"></td>
                <td><b>' . $CIE_NOM . '</b>
                <br><b>' . $CIE_TEL1 . '</b>
                <br>' . $CIE_EML1 . '
                <br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a></td> 
                </tr> 
            </table> 
        </body> 
        </html>';
    //$mailer = mail($EML, $subject, $htmlContent, $headers);

    $email->SetFrom("no-reply@".$_SERVER["SERVER_NAME"],$CIE_NOM);
    $email->Subject = $subject;
    $email->Body = $htmlContent;
    $email->IsHTML(true); 
    $email->AddAddress( $EML );
    $mail_ret = $email->Send();

    $dw3_conn->close();
    //die($mailer . "us" .$EML. $subject. $htmlContent. $headers);
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

<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/twilio/autoload.php';
use Twilio\Rest\Client;
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$TYPE = $_GET['TYPE']; 
$code_expire = date('Y-m-d H:i:s', strtotime( date("Y-m-d H:i:s") . ' +20 minutes'));
$code_val = generateRandomString();

$sql = "UPDATE customer SET  
two_factor_code = '" . $code_val . "',
two_factor_expire = '" . $code_expire . "'	 
WHERE id = '" . $USER . "' 
LIMIT 1";
if ($dw3_conn->query($sql) == TRUE) {
    if ($TYPE == "EML"){
        $subject = "Code pour la connexion à 2 facteurs";
        $mainMessage = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body>
              <h3>Bonjour,</h3>'.'Votre code pour la connexion à 2 facteurs est le: <br><br><div style="width:80%;max-width:600px;box-shadow:inset 1px 1px 3px 7px grey;padding:30px;text-align:center;"><div style="margin:10px;font-size:35px;border:1px solid yellow;"><b>' . $code_val . '</b></div></div><br> et va expirer dans 20 minutes.          
              <br><br>Pour obtenir plus de renseignements, veuillez communiquer avec nous. 
              <table style="border: 0px dashed #FB4314;font-size:17px;font-size:13px;"> 
                  <tr> 
                  <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/favicon.png" style="width:100px;height:auto;;"></td>
                  <td width="99%" style="vertical-align:top;"><b style="font-size:15px;">' . $CIE_NOM . '</b>
                  <br>' . $CIE_TEL1 . ' 
                  ' . $CIE_TEL2 . '
                  <br>' . $CIE_EML1 . '
                  </td></tr></table>
                  <br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a>
                  </body></html>' ;
        $email = new PHPMailer();
        $email->CharSet = "UTF-8";
        $email->SetFrom('no-reply@'.$_SERVER["SERVER_NAME"]); 
        $email->Subject   = $subject;
        $email->Body      = $mainMessage;
        $email->IsHTML(true); 
        $email->AddAddress($USER_EML1);
        $email->Priority = 1;
        $mail_ret = $email->Send();
       
       if ($mail_ret == 1) {
            //echo "";
       } else {
            //echo $mail_ret;
       }

    } else if ($TYPE == "TEL"){
        $code_msg = "DW3 - Your activation code is " . $code_val . " and will expire in 20 minutes.";
        $cleanTel = str_replace(" ","",str_replace("-","",str_replace("(","",str_replace(")","",str_replace(".","",$USER_TEL1)))));

        if ($CIE_TWILIO_SID !="" && $CIE_TWILIO_SENDER !=""){
            $sid    = $CIE_TWILIO_SID;
            $token  = $CIE_TWILIO_AUTH;
            $twilio = new Client($sid, $token);
            if (substr($cleanTel,0,1)!="1"){$cleanTel = "1".$cleanTel;}
            $message = $twilio->messages
            ->create("+".$cleanTel,
                array(
                "from" => "+".$CIE_TWILIO_SENDER,
                "body" => "DW3 - Votre code d'activation est le: " . $code_val . " et va expirer dans 20 minutes."
                )
            );
        } else if ($CIE_SMS_KEY != "" && $CIE_SMS_SENDER != ""){
            $data = array(
                "message"=>$code_msg,
                "to"=>$cleanTel,
                "bypass_optout"=>true,
                "sender_id"=>$CIE_SMS_SENDER,
                "callback_url"=>"https://".$_SERVER['SERVER_NAME']."/api/callbacks/sms_cb_out.php"
            );
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sms.to/sms/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$CIE_SMS_KEY,
            "Content-Type: application/json"
            ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
        }
    }
}

function generateRandomString($length = 6) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


if ($USER_LANG == "FR"){
    echo "<h3>Connexion à 2 facteurs</h3>Entrez le code reçu pour la connexion à 2 facteurs."; 
}else{
    echo "<h3>2 factors login</h3>Enter the code received for the 2-factor login.";
}?>
    <div class="divBOX" style='padding:10px;'>
        <?php if ($USER_LANG == "FR"){ echo "Code"; }else{echo "Code";}?>:
        <input id='txtCode' style='width:70%;float:right;text-align:center;' type="text" value="">
    </div><br>
<button onclick="validate2Factor();" id='btnSEND'><span class="material-icons">verified</span><?php if ($USER_LANG == "FR"){ echo "Valider"; }else{echo "Validate";}?></button>
<?php
$dw3_conn->close();
exit();
?>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';

$START_DATE   = $_GET['START'];
$ISO_START   = $_GET['ISTART'];
$END_DATE   = $_GET['END'];
$ISO_END   = $_GET['IEND'];
$EML   = $_GET['C']??'';
$TEL   = $_GET['T']??'';
$NOM   = str_replace("'","’",$_GET['N']??'');
$MSG   = str_replace("'","’",$_GET['M']??'');
$PRD_NAME   = str_replace("'","’",$_GET['D']??'');
$PRD   = $_GET['P']??'';
$USER_ID   = $_GET['U']??'0';
$RDV_TYPE   = $_GET['Y']??'L';
$CL = 0;
$inserted_id = 0;
$CUSKEY = dw3_make_key(128);

$year = substr($START_DATE,0,4);
$month = substr($START_DATE,5,2);
$day = substr($START_DATE,8,2);
$start_time = substr($START_DATE,11,5);
$end_time = substr($END_DATE,11,5);

//get cie info
$sql = "SELECT * FROM config WHERE kind = 'CIE'";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
        //no related to language data
        if ($row["code"] == "HOME")	{$CIE_HOME = trim($row["text1"]);	
        } else if ($row["code"] == "NOM")	{$CIE_NOM = trim($row["text1"]);
        } else if ($row["code"] == "NOM_HTML")	{$CIE_NOM_HTML = trim($row["text1"]);
        } else if ($row["code"] == "TEL1")	{$CIE_TEL1 = trim($row["text1"]);			
        } else if ($row["code"] == "EML1")	{$CIE_EML1 = trim($row["text1"]);			
        } else if ($row["code"] == "EML2")	{$CIE_EML2 = trim($row["text1"]);		
        } else if ($row["code"] == "COLOR1")	{$CIE_COLOR1 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR1_2")	{$CIE_COLOR1_2 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR1_3")	{$CIE_COLOR1_3 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR2")	{$CIE_COLOR2 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR3")	{$CIE_COLOR3 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR4")	{$CIE_COLOR4 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR5")	{$CIE_COLOR5 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR6")	{$CIE_COLOR6 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR7")	{$CIE_COLOR7 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR8")	{$CIE_COLOR8 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR9")	{$CIE_COLOR9 = trim($row["text1"]);
        } else if ($row["code"] == "COLOR10")	{$CIE_COLOR10 = trim($row["text1"]);
        } else if ($row["code"] == "EML1")	{$CIE_EML1 = $row["text1"];$CIE_EML1PW = trim($row["text2"]);			
        } else if ($row["code"] == "EML2")	{$CIE_EML2 = $row["text1"];$CIE_EML2PW = trim($row["text2"]);		
        } else if ($row["code"] == "EML3")	{$CIE_EML3 = $row["text1"];$CIE_EML3PW = trim($row["text2"]);
        } else if ($row["code"] == "EML4")	{$CIE_EML4 = $row["text1"];$CIE_EML4PW = trim($row["text2"]);	
        } else if ($row["code"] == "LOGO1")	{$CIE_LOGO1 = $row["text1"];
        } else if ($row["code"] == "LOGO2")	{$CIE_LOGO2 = $row["text1"];
        } else if ($row["code"] == "LOGO3")	{$CIE_LOGO3 = $row["text1"];
        } else if ($row["code"] == "LOGO4")	{$CIE_LOGO4 = $row["text1"];
        } else if ($row["code"] == "LOGO5")	{$CIE_LOGO5 = $row["text1"];
        } else if ($row["code"] == "FADE")	    {$CIE_FADE = trim($row["text1"]);
        } else if ($row["code"] == "FRAME")	    {$CIE_FRAME = trim($row["text1"]);
        } else if ($row["code"] == "BTN_RADIUS")	    {$CIE_BTN_RADIUS = trim($row["text1"]);
        } else if ($row["code"] == "BTN_SHADOW")	    {$CIE_BTN_SHADOW = trim($row["text1"]);
        } else if ($row["code"] == "FONT1")	    {$CIE_FONT1 = trim($row["text1"]);
        } else if ($row["code"] == "FONT2")	    {$CIE_FONT2 = trim($row["text1"]);
        } else if ($row["code"] == "FONT3") 	{$CIE_FONT3 = trim($row["text1"]);	
        } else if ($row["code"] == "SMS_SENDER")		{$CIE_SMS_SENDER = trim($row["text1"]);		
        } else if ($row["code"] == "SMS_KEY")		{$CIE_SMS_KEY = trim($row["text1"]);
        }
		}
	}


//find or create customer account with email
$sql = "SELECT * FROM customer WHERE eml1 = '" . dw3_crypt(trim(strtolower($EML))) . "' LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
  $CL = $row['id'];
  if($row['key_128'] == ""){
    $sql = "UPDATE customer SET key_128 = '" . trim($CUSKEY) . "' WHERE id='" . $CL . "' ";
    if ($dw3_conn->query($sql) === TRUE) {
      //$CL = $dw3_conn->insert_id;
    } 
  }else{
    $CUSKEY = $row['key_128'];
  }
  }
} else {
  $sql = "INSERT INTO customer (last_name,eml1,tel1,key_128,crypted) VALUES('" . dw3_crypt(trim($NOM)) . "','" . dw3_crypt(trim(strtolower($EML))) . "', '" . dw3_crypt(trim($TEL)) . "', '" . $CUSKEY . "',1)";
	if ($dw3_conn->query($sql) === TRUE) {
    $CL = $dw3_conn->insert_id;
    if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/fs/customer/" . $CL)){
        mkdir($_SERVER['DOCUMENT_ROOT'] . "/fs/customer/" . $CL);
    }
  } 
}

//get user infos
$sql = "SELECT A.*, B.adr1 as loc_adr1, B.adr2 as loc_adr2, B.city as loc_city, B.postal_code as loc_cp FROM user A
LEFT JOIN (SELECT * FROM location) B ON A.location_id = B.id
WHERE A.id = '" . $USER_ID . "' LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
  $KEY = $row['key_128'];
  $USER_EMAIL1 =  trim($row['eml1']); //personal email
  $USER_EMAIL2 = trim($row['eml2']);  // gmail
  $USER_EMAIL3 = trim($row['eml3']);  //company email
  $USER_PHONE =  str_replace(")","",str_replace("(","",str_replace(" ","",str_replace("-","",str_replace(".","",trim($row['tel1'])))))); //user phone
  $USER_NAME =  trim($row['first_name']);
  $USER_MSG=  trim($row['msg_rdv']);
  $USER_SMS=  trim($row['sms_rdv']);
  $USER_LOC = trim($row['location_id']);
  $USER_ADR1 = trim($row['loc_adr1']);
  $USER_ADR2 = trim($row['loc_adr2']);
  $USER_CITY = trim($row['loc_city']);
  $USER_CP = trim($row['loc_cp']);
  }
}

//find schedule head
$sql = "SELECT * FROM schedule_head
			WHERE user_id = '" . $USER_ID . "' AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "'  AND DAY(start_date) = '" . $day . "' 
            AND SUBSTR(start_date,12,5) >= '" . $start_time . "'
            AND SUBSTR(start_date,12,5) < '" . $end_time . "' LIMIT 1;";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
        while($row = $result->fetch_assoc()) {
            $location_id = $row['location_id'];
        }
    } else {
        $location_id =$USER_LOC;
    }

//insert
	$sql = "INSERT INTO schedule_line
    (user_id,start_date,iso_start,end_date,iso_end,product_id,location_type,location_id,commentaire,state,customer_id)
    VALUES 
        ('".$USER_ID."',
         '" . $START_DATE  . "',
         '" . $ISO_START  . "',
         '" . $END_DATE  . "',
         '" . $ISO_END . "',
         '" . $PRD  . "',
         '" . $RDV_TYPE  . "',
         '" . $location_id  . "',
         '" . $MSG  . "',
         'CLIENT',
         '" . $CL  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
      $inserted_id = $dw3_conn->insert_id;
      //$dw3_conn->close();
	  //die("");
	} else {
        $dw3_conn->close();
        exit;
	  //die("Erreur: " . $dw3_conn->error);
	}
    ob_start();

    echo("https://" . $_SERVER["SERVER_NAME"]  . "/client/schedule_ics.php?KEY=". $CUSKEY ."&ID=". $inserted_id);
    
    // Get the size of the output.
    $size = ob_get_length();
    
    // Disable compression (in case content length is compressed).
    header("Content-Encoding: none");
    
    // Set the content length of the response.
    header("Content-Length: {$size}");
    
    // Close the connection.
    header("Connection: close");
    
    // Flush all output.
    ob_end_flush();
    @ob_flush();
    flush();


$days = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi','Jeudi','Vendredi', 'Samedi');
$unixTimestamp = strtotime(str_replace("/","-",substr($START_DATE,0,10)));
$day = $days[date('w',$unixTimestamp)];
$rdv_time = substr($START_DATE,11,5);
/* $dt_fr = strftime("%A, %e %B %Y", strtotime(str_replace("/","-",substr($START_DATE,0,10))));
$dt_fr = mb_convert_encoding($dt_fr, 'utf-8'); */

  //email client
  $subject = "Confirmez votre rendez-vous pour le " .str_replace("/","-",substr($START_DATE,0,10));
/*   $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
  $headers .= 'From: ' . $USER_EMAIL3  . "\r\n" ; */
  //$headers .= 'From: no-reply@' . $_SERVER["SERVER_NAME"]  . "\r\n" ;
  $htmlContent = "<html><head><title>Confirmation de rendez-vous</title>
  <style>
  .email-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: grey;
    background-image: linear-gradient(to bottom right, yellow , gold, yellow );
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
    }

    .email-button:hover {
        color: white;
        background-color: #333;
        background-image: linear-gradient(to bottom right, gold , lightyellow, gold );
    }
  </style>
  </head> 
    <body style='padding:10px;'>
    <div style='box-shadow:0px 0px 10px 10px ".$CIE_COLOR6.";max-width:900px;'>
        <h4>Bonjour ".trim($NOM).",</h4>
        Veuillez confirmer votre rendez-vous avec " . $USER_NAME . " pour " . $day . " <b>" . str_replace("/","-",substr($START_DATE,0,10)) . "</b> à <b>".$rdv_time."</b><br><br>";
        $htmlContent .= "<a class='email-button' href='https://" . $_SERVER["SERVER_NAME"] . "/client/dashboard.php?KEY=".$CUSKEY."&HNDL=2&MID=". $inserted_id."'>Confirmer votre rendez-vous</a><br><br>";  
    if ($RDV_TYPE== "V"){
        $htmlContent .= "Une fois le rendez-vous confirmé, un lien pour la visioconférence vous sera bientôt envoyé par courriel.<br><hr><br>";
    }else if ($RDV_TYPE== "P"){
        $htmlContent .= "Une fois le rendez-vous confirmé, Nous vous contacterons par téléphone à l'heure prévue.<br><hr><br>";
    }else if ($RDV_TYPE== "R"){
        $htmlContent .= "Accédez à votre compte pour entrer votre adresse pour le rendez-vous avec le lien qui suit.<br><hr><br>";
    }else if ($RDV_TYPE== "L" || $RDV_TYPE== "L0"){
        $htmlContent .= "Lieu du rendez-vous : ".$USER_ADR1." ".$USER_ADR2.", ".$USER_CITY." ".$USER_CP."<br><hr><br>";
    }                    
  $htmlContent .= "<div style='max-width:600px;'><pre>".$USER_MSG."</pre></div><br><hr>";
  $htmlContent .= "<br><img src='https://" . $_SERVER["SERVER_NAME"] . "/pub/img/".$CIE_LOGO1."' style='width:auto;max-height:100px;height:100px;'>
                        <br><table style='width:100%;font-size:10px;'><tr>
                        <td width='45%' style='text-align:center;'>".$CIE_NOM."</td>
                        <td width='2%' style='text-align:center;'>|</td><td width='45%' style='text-align:center;'>".$CIE_TEL1."</td>
                        </tr><tr><td colspan=3 style='text-align:center;'>https://" . $_SERVER["SERVER_NAME"] . "</td></tr>
                        </table>
                  </div>
                  </html>";
  //$mailer = mail($EML, $subject, $htmlContent, $headers);
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  $email = new PHPMailer();
  $email->CharSet = "UTF-8";
  $email->SetFrom('no-reply@'.$_SERVER["SERVER_NAME"],$CIE_NOM); //Name is optional
  $email->Subject   = $subject;
  $email->Body      = $htmlContent;
  $email->IsHTML(true); 
  $email->AddAddress( $EML );
 // $file_to_attach = $_SERVER['DOCUMENT_ROOT'] . "/fs/invoice/". $enID . ".pdf";
 // $email->AddAttachment( $file_to_attach , $enID . '.pdf' );
  $mail_ret = $email->Send();
  if (!$mail_ret){
    error_log("Mailer Error: newScheduleLine:" .$email->ErrorInfo . " From:" . $USER_EMAIL3 . " To: " . $EML);
  }

  //email employé
  $subject2 = "Rendez-vous le " . $START_DATE;
/*   $headers2  = 'MIME-Version: 1.0' . "\r\n";
  $headers2 .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
  $headers2 .= 'From: no-reply@'. $_SERVER["SERVER_NAME"]  . "\r\n" ;
  $headers2 .= 'Cc: ' .  $USER_EMAIL1 . "\r\n"; */
  $htmlContent2 = " 
  <html> 
    <body style='padding:10px;'> 
        <h3>Bonjour,</h3>
        Un rendez-vous a été ajouté avec <b>". trim($NOM) ."</b>, " . $day . " <b>" . str_replace("/","-",substr($START_DATE,0,10)) . "</b> à <b>".$rdv_time."</b>.<br>
        <br>Pour: <b>".$PRD_NAME."</b>
        <br>Message du client lors de la prise de rendez-vous: <b>". $MSG. "</b><hr>
        Pour voir les détails et l'ajouter à votre calendrier Google veuillez cliquer sur le lien suivant:<br>
        <a href='https://" . $_SERVER["SERVER_NAME"] . "/app/timesheet/timesheet.php?KEY=".$KEY."'>https://" . $_SERVER["SERVER_NAME"] . "/app/timesheet/timesheet.php?KEY=".$KEY."</a>
        <br><table style='width:100%;font-size:10px;'><tr>
        <td width='45%' style='text-align:center;'>".$CIE_NOM."</td>
        <td width='2%' style='text-align:center;'>|</td><td width='45%' style='text-align:center;'>".$CIE_TEL1."</td>
        </tr><tr><td colspan=3 style='text-align:center;'>https://" . $_SERVER["SERVER_NAME"] . "</td></tr>
        </table>
    </body>
  </html>";
  //$mailer2 = mail($USER_EMAIL, $subject2, $htmlContent2, $headers2);
  $email2 = new PHPMailer();
  $email2->CharSet = "UTF-8";
  $email2->SetFrom('no-reply@'.$_SERVER["SERVER_NAME"],$CIE_NOM); 
  $email2->Subject   = $subject2;
  $email2->Body      = $htmlContent2;
  $email2->IsHTML(true); 
  $email2->AddAddress($USER_EMAIL1);
  $email2->AddAddress($USER_EMAIL2);
 // $file_to_attach = $_SERVER['DOCUMENT_ROOT'] . "/fs/invoice/". $enID . ".pdf";
 // $email->AddAttachment( $file_to_attach , $enID . '.pdf' );
  $mail_ret2 = $email2->Send();
  if (!$mail_ret2){
    error_log("Mailer Error: newScheduleLine:" .$email2->ErrorInfo . " From:" . 'no-reply@'.$_SERVER["SERVER_NAME"] . " To: " . $USER_EMAIL1);
  }


//a changer pour twillio
/* if ( $USER_SMS == "1"){
    if ($CIE_SMS_KEY != "" && $CIE_SMS_SENDER != ""){
        $message = "Un rendez-vous a été ajouté avec ". trim($NOM) .", " . $day . " " . str_replace("/","-",substr($START_DATE,0,10)) . " à ".$rdv_time."";
        $data = array(
            "message"=>$message,
            "to"=>$USER_PHONE,
            "bypass_optout"=>true,
            "sender_id"=>$CIE_SMS_SENDER,
            "callback_url"=>"https://".$_SERVER['SERVER_NAME']."/api/sms.to/sms_cb_out.php"
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
    }
} */
exit;
?>
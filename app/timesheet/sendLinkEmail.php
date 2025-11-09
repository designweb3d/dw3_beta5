<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');

$line_id  = $_GET['ID'];
$PLATFORM  = $_GET['PLATFORM'];
$LINK  = $_GET['LINK'];
$PASSWORD  = $_GET['PW'];
$customer_id = "0";

$sql = "SELECT A.*, B.adr1 as loc_adr1, B.adr2 as loc_adr2, B.city as loc_city, B.postal_code as loc_cp, B.name as loc_name, B.type as loc_type,
        C.last_name as cust_name, C.adr1 as cust_adr1, C.adr2 as cust_adr2, C.postal_code as cust_cp, C.city as cust_city,C.eml1 as cust_eml, C.tel1 as cust_tel,
        D.name_fr as prod_name, D.service_length as service_length, D.inter_length as inter_length
        FROM schedule_line A
        LEFT JOIN (SELECT * FROM location) B ON A.location_id = B.id
        LEFT JOIN (SELECT * FROM customer) C ON A.customer_id = C.id
        LEFT JOIN (SELECT * FROM product) D ON A.product_id = D.id
        WHERE A.id = '" . $line_id . "';";
        //error_log($sql);
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
        while($row = $result->fetch_assoc()) {
            $EML = dw3_decrypt($row["cust_eml"]);
            $NOM = dw3_decrypt($row["cust_name"]);
            //$PLATFORM = $row["link_platform"];
            //$PASSWORD = $row["link_pw"];
            //$LINK = $row["link_url"];
            $customer_id = $row["customer_id"];
            $START_DATE = $row["start_date"];
            $RDV_TYPE = $row["location_type"];
        }
    } else {
        $dw3_conn->close();
        die("Erreur: " . $dw3_conn->error);
    }
$days = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi','Jeudi','Vendredi', 'Samedi');
$unixTimestamp = strtotime(str_replace("/","-",substr($START_DATE,0,10)));
$day = $days[date('w',$unixTimestamp)];
$rdv_time = substr($START_DATE,11,5);
/* $dt_fr = strftime("%A, %e %B %Y", strtotime(str_replace("/","-",substr($START_DATE,0,10))));
$dt_fr = mb_convert_encoding($dt_fr, 'utf-8'); */

  //email client
  $subject = "Lien pour votre rendez-vous le " .str_replace("/","-",substr($START_DATE,0,10));
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
        Voici le lien pour la visioconférence sur ".$PLATFORM.": <a href='" . $LINK ."'>".$LINK."</a><br><br>";
        if ($PASSWORD != ""){
            $htmlContent .= "Code secret: <b>" . $PASSWORD . "</b><br><br>";
        }
        $htmlContent .= "Date et heure: " . $day . " <b>" . str_replace("/","-",substr($START_DATE,0,10)) . "</b> à <b>".$rdv_time."</b><br><br>
        ";                
          $htmlContent .= 'Pour consulter votre dossier rendez-vous dans votre espace client à l\'adresse suivante: <a href="https://' . $_SERVER["SERVER_NAME"] . '/client/">https://' . $_SERVER["SERVER_NAME"] . '/client/</a>
          <table style="border-top: 0px dashed #FB4314;font-size:17px;font-size:13px;"> 
              <tr> 
              <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO1.'" width="100" /></td>
              <td width="*" style="vertical-align:top;padding-top:10px;"><b style="font-size:15px;">' . $CIE_NOM . '</b>
              <br>' . $CIE_TEL1 . ' 
              <br>' . $CIE_TEL2 . '
              <br>' . $CIE_EML1 . '</td> 
              </tr></table><br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a></body></html>';
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
    error_log("Mailer Error: sendLinkEmail:" .$email->ErrorInfo . " To: " . $EML);
    echo "Mailer Error: " .$email->ErrorInfo . " To: " . $EML;
  } else {
    //update is_link_sent
    $sql = "UPDATE schedule_line SET is_link_sent = '1' WHERE id = '" . $line_id . "';";
    if ($dw3_conn->query($sql) === TRUE) {
        //ok
    } else {
        error_log("Erreur update is_link_sent: " . $dw3_conn->error);
        //echo "Erreur update is_link_sent: " . $dw3_conn->error;
    }   
    //ajout évènement
    $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
        VALUES('EMAIL','Lien pour un rendez-vous en ligne','".$subject."\nEnvoyé par: ".$USER_FULLNAME ."','". $datetime ."','".$customer_id."','".$USER."')";
    $result_task = $dw3_conn->query($sql_task); 
  }

$dw3_conn->close();
?>
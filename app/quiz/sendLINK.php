<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php';

$report_id = $_GET['ID'];
$EML_TO = $_GET['EML'];
$UID = $_GET['UID'];

$sql = "SELECT A.head_id AS head_id, B.name_fr AS name_fr, B.parent_table AS parent_table, B.parent_id AS parent_id FROM prototype_report A
LEFT JOIN prototype_head B ON A.head_id = B.id
WHERE A.id = '".$report_id ."'";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$head_id = $data['head_id']??'';
$head_name = $data['name_fr']??'';
$head_table = $data['parent_table']??'';
$head_parent_id = $data['parent_id']??0;

$NEW_KEY = dw3_make_key(128) ;
$key_expire = date('Y-m-d H:i:s', strtotime( date("Y-m-d H:i:s") . ' + 90 days'));

if ($head_table == "customer"){
    $sql = "UPDATE customer SET key_128= '" .  $NEW_KEY . "', key_expire='" . $key_expire . "'
    WHERE id= '" . $UID . "' LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
} else if ($head_table == "user"){
    $sql = "UPDATE user SET key_128= '" .  $NEW_KEY . "', key_expire='" . $key_expire . "'
    WHERE id = '" . $UID . "' LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$email = new PHPMailer(true);
$email->CharSet = "UTF-8";
$subject = $head_name;
$htmlContent = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
<body>
    <h3>Bonjour,</h3>
    Voici un lien pour consulter le document: '.$head_name.'.<div style="height:10px;"> </div>' . 
    '<a href="https://' . $_SERVER["SERVER_NAME"] . '/pub/page/quiz/index.php?KEY=' . $NEW_KEY .'&ID='.$head_id.'&RID='.$report_id.'">"https://' . $_SERVER["SERVER_NAME"] . '/pub/page/quiz/index.php?KEY=' . $NEW_KEY .'&ID='.$head_id.'&RID='.$report_id.'"</a><br><hr>'.
    '<div style="height:30px;"> </div><div style="border-bottom: 1px dashed #999; width: 100%;padding:2px;">Veuillez noter que cette boîte courriel ne peut recevoir de réponse.</div>
    <b>Pour communiquer avec nous</b>:<br>
    <table style="border: 0px dashed #FB4314;font-size:17px;"> 
        <tr> 
        <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO1.'" style="height:48px;width:auto;"></td>
        <td><b>'.$CIE_NOM.'</b>
        <br>'.$CIE_EML1.'
        <br>'.$CIE_TEL1.'</td> 
        </tr> 
    </table> 
    <br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a>
</html>';
$email->SetFrom("no-reply@".$_SERVER["SERVER_NAME"],$CIE_NOM); //Name is optional
$email->Subject = $subject;
$email->Body = $htmlContent;
$email->IsHTML(true); 
$email->AddAddress( trim($EML_TO) );
try {
    $mail_ret = $email->Send();
    echo "Courriel envoyé.";
    if ($head_table == "customer"){
        //ajout évènement
        $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
            VALUES('EMAIL','Lien vers un document','".$subject."\nEnvoyé par: ".$USER_FULLNAME ."','". $datetime ."','".$head_parent_id."','".$USER."')";
        $result_task = $dw3_conn->query($sql_task);
    }
} catch (phpmailerException $e) {
    echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    echo $e->getMessage(); //Boring error messages from anything else!
}

$dw3_conn->close();
?>
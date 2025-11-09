<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php';
use PHPMailer\PHPMailer\PHPMailer;
$email = new PHPMailer();
$email->CharSet = "UTF-8";

$ID  = $_GET['ID'];
$LST_CLI = $_GET['CLI'];
$LST_USR = $_GET['USR'];
$sql = "SELECT * FROM article WHERE id = " . $ID . " LIMIT 1;";
$result = mysqli_query($dw3_conn, $sql);
if ($result->num_rows > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    die ("Erreur: Article #". $ID. " invalide.");
}

if 	($data["is_active"] =="1"){ 
    $browse_link_fr = '<div style="width:90%;padding:20px;margin:0px 0px 10px 0px;background:rgba(0,0,0,0.6);color:white;">Pour lire cet article dans votre navigateur <u><a style="color:gold" href="https://'.$_SERVER["SERVER_NAME"].'/pub/page/article/article.php?ID='.$ID.'">Cliquez ici</a></u>.</div><br><i>(Temps de lecture: ' . round(str_word_count($data["html_fr"])/130) . ' minutes)</i>';
    $browse_link_en = '<div style="width:90%;padding:20px;margin:0px 0px 10px 0px;background:rgba(0,0,0,0.6);color:white;">To read this article in your navigator <u><a style="color:gold" href="https://'.$_SERVER["SERVER_NAME"].'/pub/page/article/article.php?ID='.$ID.'">Click here</a></u>.</div><i>(Reading time: ' . round(str_word_count($data["html_en"])/130) . ' minutes)</i>';
} else {
    $browse_link_fr = '';
    $browse_link_en = '';
}

$subject_fr = "Infolettre #".$data["id"] . " - " . $data["title_fr"];
$htmlContent_fr = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><style>*{margin:0;padding:0;}</style></head><body style="text-align:center;font-size:18px;"><div style="text-align:center;display:inline-block;max-width:800px;width:100%;">'.$browse_link_fr.'<h2 style="text-align:center;margin:10px 0px;">'.$data["title_fr"].'</h2><img src="https://'.$_SERVER["SERVER_NAME"].'/pub/upload/'.$data["img_link"].'" style="width:100%;box-shadow:0px 3px 1px 3px black;border-radius:10px 10px 0px 0px;"><h3 style="margin:20px 0px;text-align:left;">'.$data["description_fr"].'</h3><div style="text-align:left;">'.$data["html_fr"].'</div></div>';
$subject_en = "Newsletter #".$data["id"] . " - " . $data["title_en"];
$htmlContent_en = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><style>*{margin:0;padding:0;}</style></head><body style="text-align:center;font-size:18px;"><div style="text-align:center;display:inline-block;max-width:800px;width:100%;">'.$browse_link_en.'<h2 style="text-align:center;margin:10px 0px;">'.$data["title_en"].'</h2><img src="https://'.$_SERVER["SERVER_NAME"].'/pub/upload/'.$data["img_link"].'" style="width:100%;box-shadow:0px 3px 1px 3px black;border-radius:10px 10px 0px 0px;"><h3 style="margin:20px 0px;text-align:left;">'.$data["description_en"].'</h3><div style="text-align:left;">'.$data["html_en"].'</div></div>';

$email->SetFrom($CIE_EML1,$CIE_NOM); 
$email->IsHTML(true); 

if ($LST_CLI != "()"){
    $xrow = 0;
    $sql = "SELECT * FROM customer WHERE id IN ".$LST_CLI." AND news_stat = 1 AND stat=0;";
    //die($sql);
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	
        $trows = $result->num_rows;
		while($row = $result->fetch_assoc()) {
            $xrow++;
            /* $NEW_KEY = dw3_make_key(128) ;
            $key_expire = date('Y-m-d H:i:s', strtotime( date("Y-m-d H:i:s") . ' + 365 days'));
            $sql2 = "UPDATE customer SET key_128= '" .  $NEW_KEY . "', key_expire='" . $key_expire . "' WHERE id= '" . $row["id"] . "' LIMIT 1";
            $result2 = $dw3_conn->query($sql2); */
            if ($row["lang"] == "FR" || trim($data["html_en"]) == ""){
                $footer = '<div style="padding:20px 0px;margin:20px 0px 0px 0px;width:100%;background:#333;color:#FFF;"><img src="https://'.$_SERVER["SERVER_NAME"].'/pub/img/'.$CIE_LOGO1.'" style="height:100px;width:auto;"><br><h3>'.$CIE_NOM.'</h3><small>'.$CIE_ADR.'<br>'.$CIE_TEL1.' | '.$CIE_EML1.'<br><u><a href="https://'.$_SERVER["SERVER_NAME"].'" style="color:#FFF;">'.$_SERVER["SERVER_NAME"].'</a></u> - <u><a href="https://'.$_SERVER["SERVER_NAME"].'/sbin/unsubscribe.php?eml='.urlencode(dw3_decrypt($row["eml1"])).'" style="color:#FFF;">Se désinscrire</a></u></small></div></body></html>';
                $email->Subject = $subject_fr;
                $email->Body = $htmlContent_fr.$footer;
            } else {
                $footer = '<div style="padding:20px 0px;margin:20px 0px 0px 0px;width:100%;background:#333;color:#FFF;"><img src="https://'.$_SERVER["SERVER_NAME"].'/pub/img/'.$CIE_LOGO1.'" style="height:100px;width:auto;"><br><h3>'.$CIE_NOM.'</h3><small>'.$CIE_ADR.'<br>'.$CIE_TEL1.' | '.$CIE_EML1.'<br><u><a href="https://'.$_SERVER["SERVER_NAME"].'" style="color:#FFF;">'.$_SERVER["SERVER_NAME"].'</a></u> - <u><a href="https://'.$_SERVER["SERVER_NAME"].'/sbin/unsubscribe.php?eml='.urlencode(dw3_decrypt($row["eml1"])).'" style="color:#FFF;">Unsubscribe</a></u></small></div></body></html>';
                $email->Subject = $subject_en;
                $email->Body = $htmlContent_en.$footer;
            }
            //unsubscribe headers
            $email->addCustomHeader(
                'List-Unsubscribe',
                "<mailto:info@".$_SERVER["SERVER_NAME"]."?subject=Unsubscribe%20:%20{".urlencode(dw3_decrypt($row["eml1"]))."}>,<https://".$_SERVER["SERVER_NAME"]."/sbin/unsubscribe.php?eml=".urlencode(dw3_decrypt($row["eml1"])).">"
            );
            $email->addCustomHeader(
                'List-Unsubscribe-Post',
                'List-Unsubscribe=One-Click'
            );
            $email->ClearAddresses();
            $email->ClearCCs();
            $email->ClearBCCs();
            $email->AddAddress(dw3_decrypt($row["eml1"]));
            $mail_ret = $email->Send();

            //ajout évènement
            $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
                VALUES('EMAIL','Infolettre #".$ID ."','".$data["title_fr"]."\nEnvoyé par: ".$USER_FULLNAME ."','". $datetime ."','".$row['id']."','".$USER."')";
            $result_task = $dw3_conn->query($sql_task);

            echo strval(ceil(($xrow/$trows)*50)) . "%";
            ob_flush();
            flush();
            time_nanosleep(0,5);
        }
    }
}
if ($LST_USR != "()"){
    $xrow = 0;
    $sql = "SELECT * FROM user WHERE id IN ".$LST_USR." AND news_stat = 1 AND stat=0;";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	
        $trows = $result->num_rows;
		while($row = $result->fetch_assoc()) {
            $xrow++;
            //$NEW_KEY = dw3_make_key(128) ;
            //$key_expire = date('Y-m-d H:i:s', strtotime( date("Y-m-d H:i:s") . ' + 365 days'));
            //$sql2 = "UPDATE customer SET key_128= '" .  $NEW_KEY . "', key_expire='" . $key_expire . "' WHERE id= '" . $row["id"] . "' LIMIT 1";
            //$result2 = $dw3_conn->query($sql2);
            if ($row["lang"] == "FR" || trim($data["html_en"]) == "" || trim($data["html_en"]) == "''"){
                $footer = '<div style="margin:10px 0px;width:100%;background:#333;color:#FFF;"><img alt="Logo de la compagnie" src="https://'.$_SERVER["SERVER_NAME"].'/pub/img/'.$CIE_LOGO1.'" style="height:100px;width:auto;"><br><h3>'.$CIE_NOM.'</h3><small>'.$CIE_ADR1.' '.$CIE_ADR2.', '.$CIE_VILLE.'<br>'.$CIE_PROV.' '.$CIE_PAYS.' '.$CIE_CP.'<br>'.$CIE_TEL1.' | '.$CIE_EML1.'<br><u><a href="https://'.$_SERVER["SERVER_NAME"].'" style="color:#FFF;">'.$_SERVER["SERVER_NAME"].'</a></u> - <u><a href="https://'.$_SERVER["SERVER_NAME"].'/sbin/unsubscribe.php?eml='.urlencode(dw3_decrypt($row["eml1"])).'" style="color:#FFF;">Se désinscrire</a></u></small></div></body></html>';
                $email->Subject = $subject_fr;
                $email->Body = $htmlContent_fr.$footer;
            } else {
                $footer = '<div style="margin:10px 0px;width:100%;background:#333;color:#FFF;"><img alt="Logo of the company" src="https://'.$_SERVER["SERVER_NAME"].'/pub/img/'.$CIE_LOGO1.'" style="height:100px;width:auto;"><br><h3>'.$CIE_NOM.'</h3><small>'.$CIE_ADR1.' '.$CIE_ADR2.', '.$CIE_VILLE.'<br>'.$CIE_PROV.' '.$CIE_PAYS.' '.$CIE_CP.'<br>'.$CIE_TEL1.' | '.$CIE_EML1.'<br><u><a href="https://'.$_SERVER["SERVER_NAME"].'" style="color:#FFF;">'.$_SERVER["SERVER_NAME"].'</a></u> - <u><a href="https://'.$_SERVER["SERVER_NAME"].'/sbin/unsubscribe.php?eml='.urlencode(dw3_decrypt($row["eml1"])).'" style="color:#FFF;">Unsubscribe</a></u></small></div></body></html>';
                $email->Subject = $subject_en;
                $email->Body = $htmlContent_en.$footer;
            }
            $email->ClearAddresses();
            $email->ClearCCs();
            $email->ClearBCCs();
            $email->AddAddress($row["eml1"]);
            $mail_ret = $email->Send();
            echo strval(ceil(($xrow/$trows)*50)+50) . "%";
            ob_flush();
            flush();
            time_nanosleep(0,5);
        }
    }
}
$dw3_conn->close();
exit();

//unsubscribe headers
/* $headers .= "List-Unsubscribe: <https://".$_SERVER["SERVER_NAME"]."/sbin/unsubscribe.php?eml=".$NEW_KEY.">\r\n";
$headers .= "List-Unsubscribe-Post: List-Unsubscribe=One-Click\r\n"; */
?>
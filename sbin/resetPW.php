<?php
header("X-Robots-Tag: noindex, nofollow", true);
    $EML = trim(htmlspecialchars($_GET['EML']??""));
    if ($EML=="") {die("Adresse courriel invalide.");}
    if (!filter_var($EML, FILTER_VALIDATE_EMAIL)) {
        die("$EML n'est pas une adresse courriel valide.");
    }

    date_default_timezone_set('America/New_York');
    $dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
    $dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
    $dw3_conn->set_charset("utf8mb4");
	if ($dw3_conn->connect_error) {
		$dw3_conn->close();
		die("");
	}		

require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
//GLOBAL
	$sql = "SELECT *
    FROM config
    WHERE kind = 'CIE'";

$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
    if ($row["code"] == "TITRE")			{$CIE_TITRE = $row["text1"];
    } else if ($row["code"] == "NOM")		{$CIE_NOM = $row["text1"];	
    } else if ($row["code"] == "THEME")	{$CIE_THEME = $row["text1"]; //css theme	
    } else if ($row["code"] == "HOME")	{$CIE_HOME = $row["text1"];
    } else if ($row["code"] == "TYPE")	{$CIE_TYPE = $row["text1"];
    } else if ($row["code"] == "CAT")		{$CIE_CAT = $row["text1"];
    } else if ($row["code"] == "EML1")	{$CIE_EML1 = $row["text1"];			
    } else if ($row["code"] == "EML2")	{$CIE_EML2 = $row["text1"];		
    } else if ($row["code"] == "COLOR1")	{$CIE_COLOR1 = $row["text1"];
    } else if ($row["code"] == "COLOR1_2")	{$CIE_COLOR1_2 = trim($row["text1"]);
    } else if ($row["code"] == "COLOR1_3")	{$CIE_COLOR1_3 = trim($row["text1"]);
    } else if ($row["code"] == "COLOR2")	{$CIE_COLOR2 = $row["text1"];
    } else if ($row["code"] == "COLOR3")	{$CIE_COLOR3 = $row["text1"];
    } else if ($row["code"] == "COLOR4")	{$CIE_COLOR4 = $row["text1"];
    } else if ($row["code"] == "COLOR5")	{$CIE_COLOR5 = $row["text1"];
    } else if ($row["code"] == "COLOR6")	{$CIE_COLOR6 = $row["text1"];
    } else if ($row["code"] == "COLOR7")	{$CIE_COLOR7 = $row["text1"];
    } else if ($row["code"] == "COLOR8")	{$CIE_COLOR8 = $row["text1"];
    } else if ($row["code"] == "COLOR8_2")	{$CIE_COLOR8_2 = trim($row["text1"]);
    } else if ($row["code"] == "COLOR8_3")	{$CIE_COLOR8_3 = trim($row["text1"]);
    } else if ($row["code"] == "COLOR8_4")	{$CIE_COLOR8_4 = trim($row["text1"]);
    } else if ($row["code"] == "COLOR8_3S")	{$CIE_COLOR8_3S = trim($row["text1"]);
    } else if ($row["code"] == "COLOR8_4S")	{$CIE_COLOR8_4S = trim($row["text1"]);
    } else if ($row["code"] == "COLOR9")	{$CIE_COLOR9 = $row["text1"];
    } else if ($row["code"] == "COLOR10")	{$CIE_COLOR10 = trim($row["text1"]);
    } else if ($row["code"] == "EML1")	{$CIE_EML1 = $row["text1"];		
    } else if ($row["code"] == "EML2")	{$CIE_EML2 = $row["text1"];	
    } else if ($row["code"] == "EML3")	{$CIE_EML3 = $row["text1"];
    } else if ($row["code"] == "EML4")	{$CIE_EML4 = $row["text1"];	
    } else if ($row["code"] == "LOGO1")	{$CIE_LOGO1 = $row["text1"];
    } else if ($row["code"] == "LOGO2")	{$CIE_LOGO2 = $row["text1"];
    } else if ($row["code"] == "LOGO3")	{$CIE_LOGO3 = $row["text1"];
    } else if ($row["code"] == "LOGO4")	{$CIE_LOGO4 = $row["text1"];
    } else if ($row["code"] == "LOGO5")	{$CIE_LOGO5 = $row["text1"];
    } else if ($row["code"] == "FONT")	{$CIE_FONT = $row["text1"];
    } else if ($row["code"] == "FONT_SERIF")	{$CIE_FONT_SERIF = $row["text1"];
    } else if ($row["code"] == "ADR1")	{$CIE_ADR1 = $row["text1"];						
    } else if ($row["code"] == "ADR2")	{$CIE_ADR2 = $row["text1"];						
    } else if ($row["code"] == "TEL1")	{$CIE_TEL1 = $row["text1"];										
    } else if ($row["code"] == "TEL2")	{$CIE_TEL2 = $row["text1"];												
    } else if ($row["code"] == "VILLE")		{$CIE_VILLE_ID = $row["text1"];			
    } else if ($row["code"] == "PROV")		{$CIE_PROV_ID = $row["text1"];			
    } else if ($row["code"] == "PAYS")		{$CIE_PAYS_ID = $row["text1"];						
    }
}
}


    $sql = "SELECT * FROM user WHERE LCASE(eml1) = '" . strtolower($EML) . "' LIMIT 1";
    $sql2 = "SELECT * FROM customer WHERE eml1= '" . dw3_crypt(strtolower(trim($EML))) . "' LIMIT 1";
    $USER_TYPE = "" ;
    $KEY = dw3_make_key(128) ;
    $key_expire = date('Y-m-d H:i:s', strtotime( date("Y-m-d H:i:s") . ' + 1 days'));
    $subject = "Modification du mot de passe - " . $CIE_NOM; //je sais pas pk mais on dirait que si je met un accent dans le sujet ca passe pas..
    $subject = "Subject: =?UTF-8?B?".base64_encode($subject)."?=";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'From: no-reply@'.$_SERVER["SERVER_NAME"]  . "\r\n" ;
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

    //check user first
	$result = $dw3_conn->query($sql);
	if ($result->num_rows == 0) {
        //if not a user maybe a customer
        $result2 = $dw3_conn->query($sql2);
        if ($result2->num_rows == 0) { //no user and no customer found exit         
            $dw3_conn->close();
            die("");
        } else { //a customer was found
            while($row2 = $result2->fetch_assoc()) {
                $sql = "UPDATE customer SET key_reset= '" .  $KEY . "', key_expire='" . $key_expire . "'
                        WHERE eml1= '" . dw3_crypt(strtolower(trim($EML))) . "' LIMIT 1";
                if ($dw3_conn->query($sql) === FALSE) {
                    $dw3_conn->close();
                    //die("err upd cust");
                    die("Erreur de mise à jour, veuillez contacter l'administrateur pour corriger le problème ou essayez un mot de passe différent.");
                }
                $htmlContent = ' 
                <html> 
                <head> 
                    <title>' . $CIE_NOM . '</title> 
                </head> 
                <body> 
                    <h3>Bonjour ' . dw3_decrypt($row2["prefix"]) . ' ' . dw3_decrypt($row2["first_name"]) . ' ' . dw3_decrypt($row2["middle_name"]) . ' ' . dw3_decrypt($row2["last_name"]) . ' ' . dw3_decrypt($row2["suffix"]) . ',</h3>
                    <b>Pour modifier votre mot de passe, veuillez cliquer sur le lien suivant:</b> <a href="https://' . $_SERVER["SERVER_NAME"] . '/sbin/reinitpw.php?KEY=' . $KEY .'">"https://' . $_SERVER["SERVER_NAME"] . '/sbin/reinitpw.php?KEY=' . $KEY .'"</a><br><hr>Ce lien expire dans 24H ->' . $key_expire . '.' . 
                    '<br><div style="border: 0px dashed #FB4314; width: 100%;padding:2px;text-align:center;"><b>SVP ne pas répondre à ce courriel.</b></div>
                    Pour communiquer avec nous:<br>
                    <table style="font-size:17px;"> 
                        <tr> 
                        <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/'.$CIE_LOGO1.'" style="height:100px;width:auto;"></td>
                        <td width="99%"><b>' . $CIE_NOM . '</b>
                        <br>' . $CIE_EML1 . '
                        <br>' . $CIE_TEL1 . '
                        <br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a></td> 
                        </tr> 
                    </table> 
                </html>';

                $mailer = mail(strtolower(trim($EML)), $subject, $htmlContent, $headers);
                $dw3_conn->close();
                //die($mailer . "cl".$EML.$headers);
                die("");
            }
        }
    } else { //a user was found	
		while($row = $result->fetch_assoc()) {
            $sql = "UPDATE user SET key_reset= '" .  $KEY . "', key_expire='" . $key_expire . "' 
                    WHERE eml1= '" . strtolower(trim($EML)) . "'  LIMIT 1";
            if ($dw3_conn->query($sql) === FALSE) {
                $dw3_conn->close();
                //die("err upd usr");
                die("Erreur de mise à jour, veuillez contacter l'administrateur pour corriger le problème ou essayez un mot de passe différent.");
            }
            //send email
            $htmlContent = ' 
            <html> 
            <head> 
                <title>' . $CIE_NOM . '</title> 
            </head> 
            <body> 
                <h3>Bonjour ' . $row["prefix"] . ' ' . $row["first_name"] . ' ' . $row["middle_name"] . ' ' . $row["last_name"] . ' ' . $row["suffix"] . ',</h3>
                <b>Pour modifier votre mot de passe, veuillez cliquer sur le lien suivant:</b> <a href="https://' . $_SERVER["SERVER_NAME"] . '/sbin/reinitpw.php?KEY=' . $KEY .'">"https://' . $_SERVER["SERVER_NAME"] . '/sbin/reinitpw.php?KEY=' . $KEY .'"</a><br>Ce lien expire dans 24H, soit:' . $key_expire . '.' . 
                '<br><div style="border: 1px dashed #FB4314; width: 100%;padding:2px;text-align:center;"><b>SVP ne pas répondre à ce courriel.</b></div>
                Pour communiquer avec nous:<br>
                <table style="font-size:17px;"> 
                    <tr> 
                    <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/pub/img/' . $CIE_LOGO1.'" style="height:100px;width:auto;"></td>
                    <td width="99%"><b>' . $CIE_NOM . '</b>
                    <br>' . $CIE_EML1 . '
                    <br>' . $CIE_TEL1 . '
                    <br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a></td> 
                    </tr> 
                </table> 
            </body> 
            </html>';
        $mailer = mail(strtolower(trim($EML)), $subject, $htmlContent, $headers);
		$dw3_conn->close();
        //die($mailer . "us" .$EML. $subject. $htmlContent. $headers);
        die("");
	}
}
?>	

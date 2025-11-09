<?php
header("X-Robots-Tag: noindex, nofollow", true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
date_default_timezone_set('America/New_York');
setlocale(LC_ALL, 'fr_CA');
$USER_EMAIL = trim(filter_var( $_GET['USER']??"", FILTER_SANITIZE_EMAIL));
$PW = $_GET['PW']??"";
//$TEL = $_GET['TEL']??"";
$USER_LANG  = "FR";

$datetime = date("Y-m-d H:i:s");  
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8mb4");

	if ($dw3_conn->connect_error) {
		$dw3_conn->close();
		die("Erreur système, veuillez revenir plus tard.");
	}		

    require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/env_var.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
    if(isset($_COOKIE["LANG"])) { 
        if ($_COOKIE["LANG"] != "") {
            $USER_LANG = $_COOKIE["LANG"];
        }
    }
    if (trim($USER_LANG) == ""){
        $USER_LANG = "FR";
    }
    if ($PW==""){
        die("Try again!");
    } else if(strlen($PW)<8){
        die("Password too short!");
    }
    if (!filter_var($USER_EMAIL, FILTER_VALIDATE_EMAIL) || trim($USER_EMAIL)==""){
        if (strtoupper($USER_LANG) == "FR"){
            die("$USER_EMAIL n'est pas une adresse courriel valide.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            die("$USER_EMAIL is not a valid email address.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        }
    }
    
    require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
    
    if (trim($USER_EMAIL)!="" && trim($PW)!="") {
        $sql = "SELECT * FROM customer WHERE eml1 = '" . dw3_crypt(trim(strtolower($USER_EMAIL))) . "' OR eml2 = '" . dw3_crypt(trim(strtolower($USER_EMAIL))) . "';";
        $sql2 = "SELECT * FROM user WHERE UCASE(eml1) = '" . trim(strtoupper($USER_EMAIL)) . "' OR UCASE(eml2) = '" . trim(strtoupper($USER_EMAIL)) . "';";
    } else { 
        if (strtoupper($USER_LANG) == "FR"){
            die("Adresse courriel et mot de passe requis.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else {
            die("Email and password required to signin.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        }
    }

    //get cie info
    $sql4 = "SELECT * FROM config WHERE kind = 'CIE'";
	$result4 = $dw3_conn->query($sql4);
	if ($result4->num_rows > 0) {
		while($row = $result4->fetch_assoc()) {
            if ($row["code"] == "HOME")	{$CIE_HOME = trim($row["text1"]);	
            } else if ($row["code"] == "NOM")	{$CIE_NOM = trim($row["text1"]);
            } else if ($row["code"] == "NOM_HTML")	{$CIE_NOM_HTML = trim($row["text1"]);
            } else if ($row["code"] == "TYPE")	{$CIE_TYPE = trim($row["text1"]);
            } else if ($row["code"] == "CAT")		{$CIE_CAT = trim($row["text1"]);
            } else if ($row["code"] == "EML1")	{$CIE_EML1 = trim($row["text1"]);			
            } else if ($row["code"] == "EML2")	{$CIE_EML2 = trim($row["text1"]);		
            } else if ($row["code"] == "COLOR1")	{$CIE_COLOR1 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR2")	{$CIE_COLOR2 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR3")	{$CIE_COLOR3 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR4")	{$CIE_COLOR4 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR5")	{$CIE_COLOR5 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR6")	{$CIE_COLOR6 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR7")	{$CIE_COLOR7 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR8")	{$CIE_COLOR8 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR9")	{$CIE_COLOR9 = trim($row["text1"]);
            } else if ($row["code"] == "COLOR10")	{$CIE_COLOR10 = trim($row["text1"]);
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
			} else if ($row["code"] == "FONT4") 	{$CIE_FONT4 = trim($row["text1"]);
            } else if ($row["code"] == "ADR1")	    {$CIE_ADR1 = trim($row["text1"]);						
            } else if ($row["code"] == "ADR2")	    {$CIE_ADR2 = trim($row["text1"]);						
			} else if ($row["code"] == "VILLE")		{$CIE_VILLE = trim($row["text1"]);			
			} else if ($row["code"] == "PROV")		{$CIE_PROV = trim($row["text1"]);			
			} else if ($row["code"] == "PAYS")		{$CIE_PAYS = trim($row["text1"]);							
            } else if ($row["code"] == "CODE_POSTAL")	{$CIE_CP = trim($row["text1"]);						
            } else if ($row["code"] == "TEL1")	    {$CIE_TEL1 = trim($row["text1"]);										
            } else if ($row["code"] == "TEL2")	    {$CIE_TEL2 = trim($row["text1"]);										
			} else if ($row["code"] == "RS_LINKEDIN")	{$CIE_LINKEDIN = trim($row["text1"]);			
			} else if ($row["code"] == "RS_FB")		{$CIE_FB = trim($row["text1"]);
            } else if ($row["code"] == "ADR_PUB")		{$CIE_ADR_PUB = trim($row["text1"]);		
            } else if ($row["code"] == "SMS_SENDER")		{$CIE_SMS_SENDER = trim($row["text1"]);		
            } else if ($row["code"] == "SMS_KEY")		{$CIE_SMS_KEY = trim($row["text1"]);		
            }
		}
        $CIE_ADR = trim($CIE_ADR1 . " " .$CIE_ADR2). ", " .$CIE_VILLE. ", " .$CIE_PROV. " " .$CIE_PAYS. " " .$CIE_CP;
	}


	$result = $dw3_conn->query($sql2);
	if ($result->num_rows > 0) {   
        $dw3_conn->close();
        //die($sql2);
        if (strtoupper($USER_LANG) == "FR"){
            die("Adresse courriel déjà existante.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='showHELP();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide/Help</button>");
        } else {
            die("Already existing email address.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='showHELP();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide/Help</button>");
        }
	}
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {   
        $dw3_conn->close();
        //die($sql);
        if (strtoupper($USER_LANG) == "FR"){
            die("Adresse courriel déjà existante.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='showHELP();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide/Help</button>");
        } else {
            die("Already existing email address.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='showHELP();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span>Aide/Help</button>");
        }
    } else { 
        $KEY = dw3_make_key(128) ;
        //$cookie_name = "LANG";
        //$cookie_value = $LANG;
        //setcookie($cookie_name, $cookie_value, time() + 86400 , "/"); 
        //$sql = "INSERT INTO customer (eml1,tel1,pw,key_128,lang,date_created,crypted) 
        //VALUES ('" .  dw3_crypt(trim(strtolower($USER_EMAIL))) . "','" .  dw3_crypt($TEL) . "','" .  dw3_crypt($PW) . "','" .  $KEY . "','" . $USER_LANG . "', '" . $datetime . "',1)";
        $sql = "INSERT INTO customer (eml1,pw,key_128,lang,date_created,crypted) 
        VALUES ('" .  dw3_crypt(trim(strtolower($USER_EMAIL))) . "','" .  dw3_crypt($PW) . "','" .  $KEY . "','" . $USER_LANG . "', '" . $datetime . "',1)";
        error_log($sql);
        if ($dw3_conn->query($sql) === FALSE) {
                $err = $dw3_conn->connect_error;
                $dw3_conn->close();
                die($err."<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button><button onclick='showHELP();'><span class='material-icons' style='vertical-align:middle;'>phone_forwarded</span> Aide/Help</button>");
        } else{
            $inserted_uid = $dw3_conn->insert_id;
            if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/fs/customer/" . $inserted_uid)){
                mkdir($_SERVER['DOCUMENT_ROOT'] . "/fs/customer/" . $inserted_uid);
            }
        }
    }
/*         $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
                    'From: info@'.$_SERVER["SERVER_NAME"] . "\r\n";
                    'X-Mailer: PHP/' . phpversion();
        $subject = "Activation du compte - ".$_SERVER["SERVER_NAME"];
        $message = "<html><body><h2>". $subject ."</h2></body></html>"; */
        //mail($USER_EMAIL,$subject,$message,$headers);
        if (strtoupper($USER_LANG) == "FR"){
        $htmlContent = "<html><head><title>Ouverture de compte</title></head> 
        <body style='padding:10px;'>
        <div style='box-shadow:0px 0px 10px 10px ".$CIE_COLOR6.";max-width:900px;'>
          <img src='https://" . $_SERVER["SERVER_NAME"] . "/pub/img/" . $CIE_LOGO1 . "' style='width:auto;max-height:100px;height:100px;'>
          <h4>Bonjour,</h4>
          Pour activer votre compte sur ". $_SERVER["SERVER_NAME"]. " veuillez cliquer sur le lien suivant: <a href='https://". $_SERVER["SERVER_NAME"] . "/client/dashboard.php?KEY=".$KEY."&HNDL=1'>https://". $_SERVER["SERVER_NAME"] . "/client/dashboard.php?KEY=".$KEY."&HNDL=1</a><br>
              <br><table style='width:100%;font-size:10px;'><tr>
              <td width='45%' style='text-align:center;'>".$CIE_NOM."</td>
              <td width='2%' style='text-align:center;'>|</td><td width='45%' style='text-align:center;'>".$CIE_TEL1."</td>
              </tr><tr><td colspan=3 style='text-align:center;'>https://" . $_SERVER["SERVER_NAME"] . "</td></tr>
              </table>
        </div>
        </html>";
        } else {
            $htmlContent = "<html><head><title>New account</title></head> 
            <body style='padding:10px;'>
            <div style='box-shadow:0px 0px 10px 10px ".$CIE_COLOR6.";max-width:900px;'>
              <img src='https://" . $_SERVER["SERVER_NAME"] . "/pub/img/" . $CIE_LOGO1 . "' style='width:auto;max-height:100px;height:100px;'>
              <h4>Hi,</h4>
              To activate your account on ".$_SERVER["SERVER_NAME"]. " please click on the following link: <a href='https://". $_SERVER["SERVER_NAME"] . "/client/dashboard.php?KEY=".$KEY."&HNDL=1'>https://". $_SERVER["SERVER_NAME"] . "/client/dashboard.php?KEY=".$KEY."&HNDL=1</a><br>
                  <br><table style='width:100%;font-size:10px;'><tr>
                  <td width='45%' style='text-align:center;'>".$CIE_NOM."</td>
                  <td width='2%' style='text-align:center;'>|</td><td width='45%' style='text-align:center;'>".$CIE_TEL1."</td>
                  </tr><tr><td colspan=3 style='text-align:center;'>https://" . $_SERVER["SERVER_NAME"] . "</td></tr>
                  </table>
            </div>
            </html>";
            }
            if (strtoupper($USER_LANG) == "FR"){
                $subject = "Activation du compte - ".$CIE_NOM;
            } else {
                $subject = "Account activation - ".$CIE_NOM;  
            }
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        $email = new PHPMailer();
        $email->CharSet = "UTF-8";
        $email->SetFrom('no-reply@'.$_SERVER["SERVER_NAME"]); //Name is optional
        $email->Subject   = $subject;
        $email->Body      = $htmlContent;
        $email->IsHTML(true); 
        $email->AddAddress( $USER_EMAIL );
       // $file_to_attach = $_SERVER['DOCUMENT_ROOT'] . "/fs/invoice/". $enID . ".pdf";
       // $email->AddAttachment( $file_to_attach , $enID . '.pdf' );
        $mail_ret = $email->Send();
        if (!$mail_ret){
            error_log("Mailer Error: " .$email->ErrorInfo . " From: no-reply@" . $_SERVER["SERVER_NAME"] . " To: " . $USER_EMAIL);
            echo "Une erreur s'est produite. " . $email->ErrorInfo;
        } else{     
            if (strtoupper($USER_LANG) == "FR"){  
		        echo("Vérifiez votre boite courriel pour activer votre nouveau compte!<br><br><button onclick=\"closeMSG();window.open('/client','_self');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
            } else {
		        echo("Check your email inbox to activate your new account!<br><br><button onclick=\"closeMSG();window.open('/client','_self');\"><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
            }
        }

//auto add reports
        $sql4 = "SELECT * FROM prototype_head WHERE auto_add = '1' and parent_table = 'customer';";
        $result4 = $dw3_conn->query($sql4);
          if ($result4->num_rows > 0) {	
              while($row4 = $result4->fetch_assoc()) {
                $reports_count++;
                $sql = "INSERT INTO prototype_report
                (head_id,parent_id,date_submited)
                VALUES 
                    ('" . $row4['id']  . "',
                     '" . $inserted_uid  . "',
                     '" . $datetime  . "')";
                if ($dw3_conn->query($sql) === TRUE) {
                  $inserted_id = $dw3_conn->insert_id;
                  $sql2 = "SELECT * FROM prototype_line WHERE head_id = '" . $row4['id'] . "';";
                  $result2 = $dw3_conn->query($sql2);
                    if ($result2->num_rows > 0) {	
                        while($row2 = $result2->fetch_assoc()) {
                            if ($row2['response_type']!="NONE"){
                                $sql3 = "INSERT INTO `prototype_data` (`report_id`, `line_id`) 
                                VALUES ('".$inserted_id."','".$row2['id']."');";
                                $result3 = mysqli_query($dw3_conn, $sql3);
                            }
                        }
                    }
                } else {
                  //echo "Erreur: " . $dw3_conn->error;
                }
        
              }
          }


		$dw3_conn->close();

require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
?>	

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$NEW_USER   = mysqli_real_escape_string($dw3_conn,$_GET['USER']);
$PRENOM   = mysqli_real_escape_string($dw3_conn,$_GET['PRENOM']);
$PRENOM2   = mysqli_real_escape_string($dw3_conn,$_GET['PRENOM2']);
$NOM   = mysqli_real_escape_string($dw3_conn,$_GET['NOM']);
$PREFIX   = mysqli_real_escape_string($dw3_conn,$_GET['PREFIX']);
$SUFFIX   = mysqli_real_escape_string($dw3_conn,$_GET['SUFFIX']);
$EML1   = trim(strtolower(mysqli_real_escape_string($dw3_conn,$_GET['EML1'])));
$LANG  = $_GET['LANG'];
$AUTH  = $_GET['AUTH'];
$SEXE  = $_GET['SEXE'];
$LOC    = $_GET['LOC'];
$POS    = $_GET['POS'];
$INIT_PW    = $_GET['I'];
$NEW_KEY = generateRandomString(128) ;
$key_expire = date('Y-m-d H:i:s', strtotime( date("Y-m-d H:i:s") . ' + 7 days'));
if (trim($EML1)==""){
    $dw3_conn->close();
    die ("Erreur: Adresse courriel requise pour créer un utilisateur.");
}
if (!filter_var($EML1, FILTER_VALIDATE_EMAIL)) {
    $dw3_conn->close();
    die("Erreur: '$EML1' n'est pas une adresse courriel valide.");
}

//Verifs
	$sql = "SELECT COUNT(*) as counter FROM user
			WHERE trim(LCASE(eml1)) = '" . $EML1   . "' OR trim(LCASE(name)) = '" . $EML1   . "';";
			$result = mysqli_query($dw3_conn, $sql);
			$data = mysqli_fetch_assoc($result);
			if ($data['counter'] > 0){
				$dw3_conn->close();
				die ("Erreur: Adresse courriel déjà utilisé.");
			}
	$sql = "SELECT COUNT(*) as counter FROM user
			WHERE trim(LCASE(name)) = '" . trim(strtolower($NEW_USER))   . "' OR trim(LCASE(name)) = '" . trim(strtolower($NEW_USER))   . "';";
			$result = mysqli_query($dw3_conn, $sql);
			$data = mysqli_fetch_assoc($result);
			if ($data['counter'] > 0){
				$dw3_conn->close();
				die ("Erreur: Nom d'utilisateur déjà utilisé.");
			}
	$sql = "SELECT COUNT(*) as counter FROM customer
			WHERE trim(LCASE(eml1)) = '" . $EML1   . "';";
			$result = mysqli_query($dw3_conn, $sql);
			$data = mysqli_fetch_assoc($result);
			if ($data['counter'] > 0){
				$dw3_conn->close();
				die ("Erreur: Adresse courriel déjà utilisé pour un compte client");
			}
	$sql = "SELECT COUNT(*) as counter FROM customer
			WHERE trim(LCASE(eml1)) = '" . trim(strtolower($NEW_USER))   . "';";
			$result = mysqli_query($dw3_conn, $sql);
			$data = mysqli_fetch_assoc($result);
			if ($data['counter'] > 0){
				$dw3_conn->close();
				die ("Erreur: Nom d'utilisateur déjà utilisé pour un compte client comme courriel");
			}
//insert
	$sql = "INSERT INTO user
    (name,first_name,middle_name,last_name,prefix,suffix,lang,auth,gender,eml1,location_id,position_id,key_reset,key_expire,stat)
    VALUES 
        ('" . trim($NEW_USER) . "',
         '" . $PRENOM . "',
         '" . $PRENOM2 . "',
         '" . $NOM . "',
         '" . $PREFIX . "',
         '" . $SUFFIX . "',
         '" . $LANG . "',
         '" . $AUTH . "',
         '" . $SEXE . "',
         '" . $EML1 . "',
         '" . $LOC . "',
         '" . $POS . "',
         '" . $NEW_KEY . "',
         '" . $key_expire . "',
         '0')";
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        echo $inserted_id;
        if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/fs/user/" . $inserted_id)){
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/fs/user/" . $inserted_id);
        }
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

    if ($AUTH == "GES"){
        $dw3_conn->query("INSERT INTO app_user (user_id,app_id) SELECT '" . $inserted_id . "',id FROM app");
    } else if ($AUTH == "ADM"){
        $dw3_conn->query("INSERT INTO app_user (user_id,app_id) SELECT '" . $inserted_id . "',id FROM app WHERE auth = 'ADM' OR auth = 'USR'");
    } else if ($AUTH == "USR"){
        $dw3_conn->query("INSERT INTO app_user (user_id,app_id) SELECT '" . $inserted_id . "',id FROM app WHERE auth = 'USR'");
    }

if ($INIT_PW =='true'){
    $email = new PHPMailer();
    $email->CharSet = "UTF-8";
    //$subject = str_replace("'","’", $CIE_NOM)." - Initialisation du mot de passe"; //je sais pas pk mais on dirait que si je met un accent dans le sujet ca passe pas..
    $subject = "Initialisation du mot de passe"; //je sais pas pk mais on dirait que si je met un accent dans le sujet ca passe pas..
    //$headers  = 'MIME-Version: 1.0' . "\r\n";
    //$headers .= 'From: no-reply@'.$_SERVER["SERVER_NAME"]  . "\r\n" ;
    //$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $htmlContent = ' 
    <html> 
    <head> 
        <title>' . $CIE_NOM . '</title> 
    </head> 
    <body> 
        <h3>Bonjour ' . $PREFIX . ' ' . $PRENOM . ' ' . $PRENOM2 . ' ' . $NOM . ' ' .$SUFFIX. ',</h3>
        <b>Pour initialiser votre mot de passe, veuillez cliquer sur le lien suivant:</b> <a href="https://' . $_SERVER["SERVER_NAME"] . '/sbin/reinitpw.php?KEY=' . $NEW_KEY .'">"https://' . $_SERVER["SERVER_NAME"] . '/sbin/reinitpw.php?KEY=' . $NEW_KEY .'"</a><br>Ce lien ne sera plus fonctionnel une fois le mot de passe entré.' . 
        '<br><br><div style="width: 100%;padding:2px;margin-top:20px;"><b>SVP ne pas répondre à ce courriel.</b></div>
        Pour communiquer avec nous:<br>
        <table style="font-size:17px;"> 
            <tr> 
            <td style="padding:0px;"><img src="https://' . $_SERVER["SERVER_NAME"] . '/favicon.png" style="height:100px;width:auto;" height="100" width="auto"></td>
            <td><b>' . $CIE_NOM . '</b>
            <br>' . $CIE_EML1 . '
            <br>' . $CIE_TEL1 . '
            <br><a href="https://' . $_SERVER["SERVER_NAME"] . '">https://' . $_SERVER["SERVER_NAME"] . '</a></td> 
            </tr> 
        </table> 
    </html>';
    //echo "Eml";
    //$mailer = mail($EML1, $subject, $htmlContent, $headers);
    $email->SetFrom("no-reply@".$_SERVER["SERVER_NAME"],$CIE_NOM);
    $email->Subject = $subject;
    $email->Body = $htmlContent;
    $email->IsHTML(true); 
    $email->AddAddress( $EML1 );
    $mail_ret = $email->Send();
    //echo $email->ErrorInfo;
}

    //ajout évènement
    $sql_task = "INSERT INTO event (event_type,name,description,date_start,user_id) 
        VALUES('USER','Nouvel utilisateur','No de user: ".$inserted_id."\nNom: ".$NOM."\nCréée par: ".$USER_FULLNAME ."','".$datetime ."','".$USER."')";
    $result_task = $dw3_conn->query($sql_task); 

$dw3_conn->close();

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
exit();
?>
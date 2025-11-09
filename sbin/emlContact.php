<?php
$REDIR = "<html><head><title>Redirected</title><meta http-equiv=\"refresh\" content=\"0;URL='https://" . $_SERVER["SERVER_NAME"] . "'\"></head></html>";  
$REDIR_EXPIRE = "<html><head><title>Redirected</title><meta http-equiv=\"refresh\" content=\"5;URL='https://" . $_SERVER["SERVER_NAME"] . "'\"></head><body>Le lien pour initialiser votre mot de passe est invalide, veuillez faire une requête de mot de passe perdu à l'adresse suivante: <a href='https://" .$_SERVER["SERVER_NAME"] . "' target='_self'>" .$_SERVER["SERVER_NAME"] . "</a><hr>Redirection dans quelques secondes..</body></html>";  

date_default_timezone_set('America/New_York');
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8mb4");
if ($dw3_conn->connect_error) {
    $dw3_conn->close();
    die($REDIR);
}	

$sql = "SELECT * FROM config WHERE kind = 'CIE' AND code = 'EML1' LIMIT 1;";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $eml_to = trim($row["text1"]);
    }
} else {
    $eml_to = 'info@'.$_SERVER['SERVER_NAME'];
}
    
$eml_from = $_GET['E']??'';
$name = $_GET['N']??'';
$tel = $_GET['T']??'';
$msg = $_GET['M']??'';
$RIP = $_SERVER['REMOTE_ADDR'];

if (!filter_var($eml_from, FILTER_VALIDATE_EMAIL)) {
    $dw3_conn->close();
    die("e1");
}

if (trim($eml_from) == '' || trim($name) == '' || trim($msg) == ''){
    http_response_code(200);
    echo "Erreur d'envoi du message";
    $dw3_conn->close();
    exit;   
}

$subject = "Message Web";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$html = "<html><head><title>Message Web</title></head> 
                <body>                 
                Email: " . $eml_from . "<br>
                Name: " . $name . "<br>
                Phone: " . $tel . "<br>
                Message: " . $msg . "<br>
                </body></html>";
$mailer = mail($eml_to, $subject, $html, $headers);

http_response_code(200);
if ($mailer){
    echo "ok";
} else {
    echo "Erreur d'envoi du message";
    error_log("IP:".$RIP."|METHOD:".$method."|MAILER_RESPONSE".$mailer);
}
$dw3_conn->close();
exit;
?>
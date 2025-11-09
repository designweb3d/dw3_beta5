<?php
header("X-Robots-Tag: noindex, nofollow", true);
$KEY = $_GET['KEY']??"";
if ($KEY == "") {
    die ('Option invalide');
}	
date_default_timezone_set('America/New_York');
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8mb4");
$PW = mysqli_real_escape_string($dw3_conn,$_GET['PW']);
$TYPE = mysqli_real_escape_string($dw3_conn,$_GET['TYPE']);
if ($dw3_conn->connect_error) {
   //$dw3_conn->close();
   die($REDIR);
}	
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
if ($PW == "") {
    $dw3_conn->close();
    die ('Veuillez entrer un mot de passe');
} 
if ($TYPE == "") {
    $dw3_conn->close();
    die ('erreur systeme');
} 

if ($TYPE == "CLIENT") {
    $sql = "UPDATE customer SET    
    pw  = '" . dw3_crypt($PW)   . "',
    activated  = '1',
    key_reset  = '',
    key_expire = ''
    WHERE key_reset = '" . $KEY . "' LIMIT 1";
} else if($TYPE == "USER"){
    $sql = "UPDATE user SET    
    pw  = '" . $PW   . "',
    key_reset = '',
    key_expire = ''
    WHERE key_reset = '" . $KEY. "' LIMIT 1";
}
    
if ($dw3_conn->query($sql) === TRUE) {
    echo "";
} else {
    echo $dw3_conn->error;
}

$dw3_conn->close();
?>
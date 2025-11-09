<?php 
header("X-Robots-Tag: noindex, nofollow", true);
$KEY = $_GET['KEY']??'';
$comment_id  = $_GET['C'];

if ($KEY == ''){
    $KEY= $_POST['KEY']??'';
    if ($KEY == ''){
        header("Location: https://" . $_SERVER["SERVER_NAME"] . "/");
        exit;
    }
}
date_default_timezone_set('America/New_York');
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8mb4");
if ($dw3_conn->connect_error) {
    $dw3_conn->close();
    die($REDIR);
}	

$sql = "SELECT * FROM user WHERE key_128 = '" . $KEY . "' LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result->num_rows == 0) {
    //error_log("Invalid key: ". $KEY. " ip:".$RIP); 
    $dw3_conn->close();
    header("Location: https://" . $_SERVER["SERVER_NAME"] . "/");
    exit;
} 

$sql = "DELETE FROM article_comment WHERE id = ".$comment_id." LIMIT 1;";
if ($dw3_conn->query($sql) === TRUE) {
    echo "Commentaire supprimé.";
} else {
    echo "Erreur: Commande invalide.";
}
$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID   = $_GET['ID'];
$FILE  = $_GET['FILE'];
$html = "";
if ($ID == "" || $FILE == "") {
	$html = "Erreur: fichier invalide.";
}

$target_file = $_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $ID . "/" . $FILE;
if (file_exists($target_file)){
    $del_status=unlink($target_file); 
} else {
    $html = "Erreur: fichier introuvable.";
}

$sql = "SELECT url_img FROM product WHERE id = '" . $ID  . "' LIMIT 1;";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

if ($data["url_img"] == $FILE){
    $sql = "UPDATE product SET url_img = '' WHERE id = '" . $ID . "'  LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo "ok";
	} else {
	  $html .= "Erreur: ".$dw3_conn->error;
	}
}
//$html .= $del_status . $target_file;
$dw3_conn->close();
header('Status: 200');
die($html);
?>
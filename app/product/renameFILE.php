<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$prID  = $_GET['ID'];
$FROM  = mysqli_real_escape_string($dw3_conn,$_GET['FROM']);
$TO  = mysqli_real_escape_string($dw3_conn,$_GET['TO']);
$folder=$_SERVER['DOCUMENT_ROOT'] ."/fs/product/" .$prID . "/";

if (file_exists($folder.$TO)){
    die("Erreur: Le nom de fichier existe déjà.");
}

$sql = "SELECT url_img FROM product WHERE id = '" . $prID  . "' LIMIT 1;";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

$rename_result = rename($folder.$FROM,$folder.$TO);

if ($rename_result && $data["url_img"] == $FROM){
    $sql = "UPDATE product SET url_img = '" . $TO . "' WHERE id = '" . $prID . "'  LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo "ok";
	} else {
	  echo "Erreur: ".$dw3_conn->error;
	}
}

$dw3_conn->close();
header('Status: 200');
die($rename_result);
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$CATEGORY   = mysqli_real_escape_string($dw3_conn,$_GET['CATEGORY']);
$PARENT   = mysqli_real_escape_string($dw3_conn,$_GET['PARENT']);
$DESC  = mysqli_real_escape_string($dw3_conn,$_GET['DESC']);
$IMG  = mysqli_real_escape_string($dw3_conn,$_GET['IMG']);
$NAME_EN  = mysqli_real_escape_string($dw3_conn,$_GET['NAME_EN']);
$DESC_EN  = mysqli_real_escape_string($dw3_conn,$_GET['DESC_EN']);

$sql = "SELECT COUNT(*) as counter FROM product_category
WHERE name_fr = '" . $CATEGORY   . "';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if ($data['counter'] > 0){
    $dw3_conn->close();
    die("Erreur: Cette catégorie existe déjà.");
}

	$sql = "INSERT INTO product_category
    (name_fr,parent_name,name_en,description_fr,description_en,img_url)
    VALUES 
        ('" . $CATEGORY   . "',
         '" . $PARENT   . "',
         '" . $NAME_EN  . "',
         '" . $DESC  . "',
         '" . $DESC_EN  . "',
         '" . $IMG  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
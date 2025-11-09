<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$CATEGORY   = mysqli_real_escape_string($dw3_conn,$_GET['CATEGORY']);

$sql = "SELECT COUNT(*) as counter FROM product_category
WHERE parent_name = '".$CATEGORY."';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if ($data['counter'] > 0){
    $dw3_conn->close();
    die("Erreur: Supprimer d'abord les sous-catégories.");
}

	$sql = "DELETE FROM product_category
	 WHERE name_fr = '" . $CATEGORY . "'";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
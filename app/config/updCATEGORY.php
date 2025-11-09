<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];
$FROM   = str_replace("'","’",str_replace('"','&quot;',$_GET['FROM']));
$TO   = str_replace("'","’",str_replace('"','&quot;',$_GET['TO']));
$PARENT   = str_replace("'","’",str_replace('"','&quot;',$_GET['PARENT']));
$IMG  = str_replace("'","’",$_GET['IMG']);
$NAME_EN  = str_replace("'","’",str_replace('"','&quot;',$_GET['NAME_EN']));
$DESC  = str_replace("'","’",str_replace('"','&quot;',$_GET['DESC']));
$DESC_EN  = str_replace("'","’",str_replace('"','&quot;',$_GET['DESC_EN']));

$sql = "SELECT COUNT(*) as counter FROM product_category
WHERE name_fr = '" . $TO   . "' AND id <> '".$ID."';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if ($data['counter'] > 0){
    $dw3_conn->close();
    die("Erreur: Cette catégorie existe déjà.");
}

	$sql = "UPDATE product_category
     SET    
	 name_fr  = '" . $TO  . "',
	 name_en  = '" . $NAME_EN   . "',
	 parent_name = '" . $PARENT  . "',
	 img_url = '" . $IMG  . "',
	 description_fr = '" . $DESC . "',
	 description_en = '" . $DESC_EN  . "'
	 WHERE name_fr = '" . $FROM . "' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo "0";
	} else {
	  echo $dw3_conn->error;
	}

	$sql = "UPDATE product_category
     SET    
	 parent_name  = '" . $TO   . "'
	 WHERE parent_name = '" . $FROM . "' AND parent_name <> ''";
	if ($dw3_conn->query($sql) === TRUE) {
	  //ok
	} else {
	  echo $dw3_conn->error;
	}
echo "";
$dw3_conn->close();
?>
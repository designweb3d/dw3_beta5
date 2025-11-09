<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
//$PRICE  = str_replace("'","’",$_GET['PRICE']);
/* $DESC_FR  = str_replace("'","’",$_GET['DESC_FR']);
$DESC_EN  = str_replace("'","’",$_GET['DESC_EN']); */
$NOM_FR   = str_replace("'","’",$_GET['NOM_FR']);
$NOM_EN   = str_replace("'","’",$_GET['NOM_EN']);
//$FRN1   = htmlspecialchars($_GET['FRN1']);
$UPC  = htmlspecialchars($_GET['UPC']);
$CAT  = htmlspecialchars($_GET['CAT']);
$BILLING  = htmlspecialchars($_GET['BILLING']);
//$PACK  = str_replace("'","’",$_GET['PACK']);’'

//Verif
	if ($UPC != ""){
	$sql = "SELECT COUNT(*) as counter FROM product
			WHERE trim(upc) = '" . trim($UPC)   . "';";
			$result = mysqli_query($dw3_conn, $sql);
			$data = mysqli_fetch_assoc($result);
			if ($data['counter'] > 0){
				//$dw3_conn->close();
				die ("Erreur: #UPC déjà utilisé.");
			}
	}
if ($BILLING == "" || $BILLING == "FINAL" || $BILLING == "LOCATION"){
    $ship_type = $CIE_TRANSPORT;
} else {
    $ship_type = "N/A";
}

//insert
	$sql = "INSERT INTO product
    (billing,ship_type,name_fr,name_en,upc,category_id,date_created,date_modified,user_created,user_modified)
    VALUES 
        ('".$BILLING."',
         '" . $ship_type  . "',
         '" . $NOM_FR  . "',
         '" . $NOM_EN  . "',
         '" . $UPC  . "',
         '" . $CAT . "',
         '" . $datetime  . "',
         '" . $datetime  . "',
         '" . $USER . "',
         '" . $USER . "')";
		//die("Erreur: ".$sql);
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        echo $inserted_id;
        if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id)){mkdir($_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id);}
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}


$dw3_conn->close();
?>

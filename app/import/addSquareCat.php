<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$SQ_PARENT  = str_replace("'","’",$_GET['SQ_PARENT']);
$SQ_NAME   = str_replace("'","’",$_GET['SQ_NAME']);
$SQ_ID   = str_replace("'","’",$_GET['SQ_ID']);

//verif
    $sql = "SELECT COUNT(*) as counter FROM product_category
    WHERE trim(name_fr) = '" . trim($SQ_NAME) . "' AND trim(parent_name) = '" . trim($SQ_PARENT) . "';";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    if ($data['counter'] > 0){
        die("Catégorie déjà créée.");
    }

//insert
	$sql = "INSERT INTO product_category
    (parent_name,name_fr,square_id)
    VALUES 
        ('".$SQ_PARENT."',
         '" . $SQ_NAME  . "',
         '" . $SQ_ID  . "')"; 
		//die("Erreur: ".$sql);
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        echo "Catégorie créée.";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

$dw3_conn->close();
?>
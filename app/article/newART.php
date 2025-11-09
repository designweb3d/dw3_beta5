<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$NAME_FR   = str_replace("'", "\'", htmlspecialchars($_GET['FR']));
$NAME_EN   = str_replace("'", "\'", htmlspecialchars($_GET['EN']));

//insert
	$sql = "INSERT INTO article
    (title_fr,title_en)
    VALUES 
        ('" . $NAME_FR  . "',
         '" . $NAME_EN  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
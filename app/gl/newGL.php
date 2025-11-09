<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$CODE  = mysqli_real_escape_string($dw3_conn,$_GET['CODE']);
$KIND  = mysqli_real_escape_string($dw3_conn,$_GET['KIND']);
$NAME_FR  = mysqli_real_escape_string($dw3_conn,$_GET['NAME_FR']);
$NAME_EN  = mysqli_real_escape_string($dw3_conn,$_GET['NAME_EN']);
$DESC_FR  = mysqli_real_escape_string($dw3_conn,$_GET['DESC_FR']);
$DESC_EN  = mysqli_real_escape_string($dw3_conn,$_GET['DESC_EN']);
//verif
    $sql = "SELECT * FROM gl
    WHERE code = '" . $CODE . "' LIMIT 1";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        echo("Le code <b><u>" . $CODE . "</u></b> est déjà utilisé pour le poste: <b>" . $row["name_fr"]) . "</b>.";
        $dw3_conn->close();
        die("");
        }
    }
//insert
	$sql = "INSERT INTO gl
    (code,kind,name_fr,name_en,desc_fr,desc_en)
    VALUES 
        ('" . $CODE  . "',
         '" . $KIND  . "',
         '" . $NAME_FR  . "',
         '" . $NAME_EN  . "',
         '" . $DESC_FR  . "',
         '" . $DESC_EN  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
        echo "";
	} else {
	    echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
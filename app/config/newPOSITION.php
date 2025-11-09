<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$POSTE   = mysqli_real_escape_string($dw3_conn,$_GET['POSTE']);
$AUTH  = $_GET['AUTH'];
$PARENT   = mysqli_real_escape_string($dw3_conn,$_GET['PARENT']);
$DESC  = mysqli_real_escape_string($dw3_conn,$_GET['DESC']);


$sql = "SELECT COUNT(*) as counter FROM position
WHERE name = '" . $POSTE   . "';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if ($data['counter'] > 0){
    $dw3_conn->close();
    die("Erreur: Ce poste existe déjà.");
}


	$sql = "INSERT INTO position
    (name,parent_name,auth,description)
    VALUES 
        ('" . $POSTE   . "',
         '" . $PARENT   . "',
         '" . $AUTH  . "',
         '" . $DESC  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
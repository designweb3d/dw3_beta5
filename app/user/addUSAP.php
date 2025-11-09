<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$usID   = $_GET['usID'];
$apID   = $_GET['apID'];

//verify if user can add this app
$sql = "SELECT * FROM app WHERE id = '" . $apID   . "';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

$can_user_add = true;
if ($USER_AUTH == "USR" && $data["auth"] == "ADM"){$can_user_add = false;}
if ($USER_AUTH == "USR" && $data["auth"] == "GES"){$can_user_add = false;}
if ($USER_AUTH == "ADM" && $data["auth"] == "GES"){$can_user_add = false;}

if ($can_user_add == true){
	$sql = "INSERT INTO app_user
    (user_id,app_id)
    VALUES 
        ('" . $usID   . "',
         '" . $apID  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
} else {
    echo "Erreur: Vous ne possedez pas l'autorité necessaire pour ajouter cette application." ;
}
$dw3_conn->close();
?>
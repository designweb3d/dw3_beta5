<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$TYPE  = $_GET['TYPE'];
$PARENT  = $_GET['PARENT'];
$MAX  = $_GET['MAX'];
$NAME   = mysqli_real_escape_string($dw3_conn, $_GET['NAME']);
$DESC   = mysqli_real_escape_string($dw3_conn, $_GET['DESC']);

$sql = "SELECT COUNT(*) AS doublons FROM prototype_head WHERE LCASE(name_fr) = '" . strtolower($NAME) . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$doublons = $data['doublons']??'0';
if ($doublons != "0"){
    $dw3_conn->close();
    die("Erreur: Un document porte déjà ce nom.");
}

	$sql = "INSERT INTO prototype_head
    (name_fr,description_fr,total_type,parent_table,total_max)
    VALUES 
        ('" . $NAME  . "',
         '" . $DESC  . "',
         '" . $TYPE  . "',
         '" . $PARENT . "',
         '" . $MAX  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
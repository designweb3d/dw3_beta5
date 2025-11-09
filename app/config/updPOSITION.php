<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];
$FROM   = mysqli_real_escape_string($dw3_conn,$_GET['FROM']);
$TO   = mysqli_real_escape_string($dw3_conn,$_GET['TO']);
$AUTH  = $_GET['AUTH'];
$PARENT   = mysqli_real_escape_string($dw3_conn,$_GET['PARENT']);
$DESC  = mysqli_real_escape_string($dw3_conn,$_GET['DESC']);

$sql = "SELECT COUNT(*) as counter FROM position
WHERE name = '" . $TO   . "' AND id <> '".$ID."';";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if ($data['counter'] > 0){
    $dw3_conn->close();
    die("Erreur: Ce poste existe déjà.");
}

	$sql = "UPDATE position
     SET    
	 name  = '" . $TO   . "',
	 parent_name = '" . $PARENT  . "',
	 description = '" . $DESC  . "',
	 auth = '" . $AUTH  . "'
	 WHERE name = '" . $FROM . "' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo "0";
	} else {
	  echo $dw3_conn->error;
	}

	$sql = "UPDATE position
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
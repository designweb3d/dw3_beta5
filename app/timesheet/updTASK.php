 <?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$STATUS   = $_GET['STAT'];
$DESC  = str_replace("'", "\'", htmlspecialchars($_GET['DESC']));

if ($STATUS == "DONE") {
	$sql = "UPDATE event SET    
	 status   = '" . $STATUS   . "',
	 description   = '" . $DESC   . "',
	 closed_date  = '" . $datetime   . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
} else {
	$sql = "UPDATE event SET    
	 status   = '" . $STATUS   . "',
	 description   = '" . $DESC   . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
}
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
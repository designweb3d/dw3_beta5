  <?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$NAME   = str_replace("'", "\'", htmlspecialchars($_GET['NAME']));
$TYPE  = $_GET['TYPE'];
$PRIORITY  = $_GET['PRIORITY'];
$STATUS  = $_GET['STATUS'];
$START  = str_replace("'", "\'", htmlspecialchars($_GET['START']));
$END  = str_replace("'", "\'", htmlspecialchars($_GET['END']));
$DESC  = str_replace("'", "\'", htmlspecialchars($_GET['DESC']));
$HREF  = str_replace("'", "\'", htmlspecialchars($_GET['HREF']));
$IMG  = str_replace("'", "\'", htmlspecialchars($_GET['IMG']));

	$sql = "UPDATE event SET    
	 name   = '" . $NAME   . "',
	 event_type   = '" . $TYPE   . "',
	 status   = '" . $STATUS   . "',
	 priority   = '" . $PRIORITY   . "',
	 date_start  = '" . $START    . "',
	 end_date    = '" . $END    . "',
	 description   = '" . $DESC   . "',
	 href   = '" . $HREF   . "',
	 img_src   = '" . $IMG   . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
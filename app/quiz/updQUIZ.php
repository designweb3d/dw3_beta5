<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$TYPE  = $_GET['TYPE'];
$PARENT  = $_GET['PARENT'];
$MAX  = $_GET['MAX'];
$NEXT  = $_GET['NEXT'];
$REEDIT  = $_GET['REEDIT'];
$CAPTCHA  = $_GET['CAPTCHA'];
$LINK_TO  = $_GET['LINK_TO'];
$VIEW  = $_GET['VIEW'];
$AUTO_ADD  = $_GET['AUTO_ADD'];
$NAME   = mysqli_real_escape_string($dw3_conn, $_GET['NAME']);
$DESC   = mysqli_real_escape_string($dw3_conn, $_GET['DESC']);
$NAME_EN   = mysqli_real_escape_string($dw3_conn, $_GET['NAME_EN']);
$DESC_EN   = mysqli_real_escape_string($dw3_conn, $_GET['DESC_EN']);

$sql = "SELECT COUNT(*) AS doublons FROM prototype_head WHERE id <> '".$ID ."' AND LCASE(name_fr) = '" . strtolower($NAME) . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$doublons = $data['doublons']??'0';
if ($doublons != "0"){
    $dw3_conn->close();
    die("Erreur: Un document porte déjà ce nom.");
}

$sql = "UPDATE prototype_head SET    
	 total_type   = '" . $TYPE   . "',
	 parent_table   = '" . $PARENT   . "',
	 next_id   = '" . $NEXT   . "',
	 total_max   = '" . $MAX   . "',
	 allow_user_reedit = '" . $REEDIT   . "',
	 link_to_user = '" . $LINK_TO   . "',
	 captcha_required = '" . $CAPTCHA   . "',
	 allow_user_view = '" . $VIEW   . "',
	 auto_add = '" . $AUTO_ADD   . "',
	 name_fr   = '" . $NAME   . "',
	 description_fr    = '" . $DESC    . "',
	 name_en   = '" . $NAME_EN   . "',
	 description_en    = '" . $DESC_EN . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
exit();
?>
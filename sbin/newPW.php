<?php
$KEY = $_GET['KEY'];
date_default_timezone_set('America/New_York');
$dw3_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/config.ini");
$dw3_conn = new mysqli($dw3_ini["mysqli_servername"],$dw3_ini["mysqli_username"], $dw3_ini["mysqli_password"], $dw3_ini["mysqli_dbname"]);
$dw3_conn->set_charset("utf8");
$PW = mysqli_real_escape_string($dw3_conn,$_GET['PW']);
if ($dw3_conn->connect_error) {
   $dw3_conn->close();
   die($REDIR);
}	

	if ($KEY == "") {
		$dw3_conn->close();
		die ('Parametre invalide');
	}	
	if ($PW == "") {
		$dw3_conn->close();
		die ('Veuillez entrer un mot de passe');
	} 

        $sql = "UPDATE user SET    
        pw  = '" . $PW   . "',
        key_reset = '',
        key_expire = ''
        WHERE key_128 = '" . $KEY. "' LIMIT 1";
	 
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $LBL_ERROR . $dw3_conn->error;
	}
$dw3_conn->close();
?>
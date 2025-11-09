<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$GENR	= mysqli_real_escape_string($dw3_conn,$_GET['GENR']);
$CODE  = mysqli_real_escape_string($dw3_conn,$_GET['CODE']);
$DSC1  = mysqli_real_escape_string($dw3_conn,$_GET['DSC1']);
$DSC2  = mysqli_real_escape_string($dw3_conn,$_GET['DSC2']);
$DSC3  = mysqli_real_escape_string($dw3_conn,$_GET['DSC3']);
$DSC4  = mysqli_real_escape_string($dw3_conn,$_GET['DSC4']);
//Verif
if ($GENR != "" && $CODE != ""){
	$sql = "SELECT COUNT(*) as counter FROM config
			WHERE trim(kind) = '" . trim($GENR)   . "' AND trim(code) = '" . trim($CODE)   . "' ;";
			$result = mysqli_query($dw3_conn, $sql);
			$data = mysqli_fetch_assoc($result);
			if ($data['counter'] > 0){
				//$dw3_conn->close();
				echo ("Erreur: Type de code deja existant");
                $dw3_conn->close();
                exit;
			}
	}else{
        echo "Code invalide";
    }

	$sql = "INSERT INTO config
    (kind, code,text1,text2,text3,text4)
    VALUES 
        ('" . trim($GENR)  . "', '" . trim($CODE)  . "', '" . $DSC1  . "', '" . $DSC2  . "', '" . $DSC3  . "', '" . $DSC4  . "');";
	if ($dw3_conn->query($sql) === TRUE) {
	    echo "Le nouveau code " . $GENR  . "/" . $CODE  . " a été créé.";
	} else {
	    echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID   = $_GET['enID'];
$lgDESC   = mysqli_real_escape_string($dw3_conn,$_GET['desc']);
$lgQTE   = $_GET['lgQTE'];
//get next LGN
$sql = "SELECT MAX(line)+1 as nextLGN FROM purchase_line WHERE head_id = '" . $enID . "'";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$nextLGN = $data['nextLGN'];
if ($nextLGN == 0 || $nextLGN == ''){$nextLGN == '1';}

//insert
	$sql = "INSERT INTO purchase_line
    (head_id,line,name_fr,qty_order,price,date_created,date_modified)
    VALUES 
        ('" . $enID  . "',
        '" . $nextLGN . "',
        '" . $lgDESC . "',
         '" . $lgQTE . "',
         '0.00',
         '" . $datetime  . "',
         '" . $datetime  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
        echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

$dw3_conn->close();
?>

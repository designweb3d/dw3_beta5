<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID   = $_GET['enID'];
$prUPC   = $_GET['prUPC'];
$lgQTE   = $_GET['lgQTE'];
//get next LGN
$sql = "SELECT MAX(line)+1 as nextLGN FROM purchase_line WHERE head_id = '" . $enID . "'";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$nextLGN = $data['nextLGN'];
if ($nextLGN == 0 || $nextLGN == ''){$nextLGN == '1';}

//get prd data before insert 
	$sql = "SELECT * FROM product WHERE upc = '" .  $prUPC . "' AND upc <> '' LIMIT 1";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);

//insert
	$sql = "INSERT INTO purchase_line
    (head_id,line,product_id,qty_order,price,tax_prov,tax_fed,date_created,date_modified)
    VALUES 
        ('" . $enID  . "',
        '" . $nextLGN . "',
        '" . $data['id']??'0' . "',
         '" . $lgQTE . "',
         '" . $data['price1']??'0'  . "',
         '" . $data['tax_prov']??'0'  . "',
         '" . $data['tax_fed']??'0'  . "',
         '" . $datetime  . "',
         '" . $datetime  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
        echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

$dw3_conn->close();
?>

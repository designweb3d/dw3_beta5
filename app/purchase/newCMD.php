<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$FRN   = $_GET['FRN'];

//get cli data before insert 
	$sql = "SELECT * FROM supplier WHERE id = '" .  $FRN . "'";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);


//insert
	$sql = "INSERT INTO purchase_head
    (supplier_id,name,eml,adr1,adr2,city,prov,country,postal_code,date_created,date_due,date_modified)
    VALUES 
        ('" . $data['id']  . "',
        '" . $data['company_name']  . "',
         '" . $data['eml1']   . "',
         '" . $data['adr1']   . "',
         '" . $data['adr2']  . "',
         '" . $data['city']  . "',
         '" . $data['province']  . "',
         '" . $data['country'] . "',
         '" . $data['postal_code']  . "',
         '" . $datetime  . "',
         '" . $datetime  . "',
         '" . $datetime  . "')";
//die($sql);
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        echo $inserted_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

$dw3_conn->close();
?>

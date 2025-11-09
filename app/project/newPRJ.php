<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$CLI   = $_GET['CLI'];

//get cli data before insert 
	$sql = "SELECT * FROM customer WHERE id = '" .  $CLI . "'";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);


//insert
	$sql = "INSERT INTO project
    (customer_id,title,adr,city,province,country,postal_code,date_created,date_due,date_modified)
    VALUES 
        ('" . $data['id']  . "',
        '" . $data['company']  . "',
         '" . dw3_decrypt($data['adr1']) . " ".dw3_decrypt($data['adr1'])  . "',
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

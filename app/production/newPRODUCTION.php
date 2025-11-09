<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$procID   = $_GET['procID'];

//GET PROCEDURE INFO
$sql = "SELECT * FROM procedure_head WHERE id = " . $procID . " LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$date_end = date('Y-m-d H:i:s', strtotime($datetime . ' +' . $data["delay_by_unit"] . ' minutes'));
//insert
	$sql = "INSERT INTO production (status,procedure_id,qty_needed,date_start,date_end,date_due)
    VALUES ('TO_DO',
         '" . $procID  . "',
         '1',
         '" . $datetime  . "',
         '" . $date_end  . "',
         '" . $date_end  . "')";
		//die("Erreur: ".$sql);
	if ($dw3_conn->query($sql) === TRUE) {
        echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$rtID  = $_GET['rtID'];

	$sql = "SELECT A.adr1 as clADR, A.id as clID,B.sort_number as bclORD
			FROM customer A
            LEFT JOIN (SELECT * FROM road_line WHERE road_id = " . $rtID . ") B ON A.id = B.customer_id  
			WHERE A.id IN(SELECT DISTINCT customer_id FROM road_line 
						WHERE road_id = " . $rtID . ")
			ORDER BY bclORD";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
			echo "
					<option value='" . $row["clID"] . "'>(" . str_pad($row["bclORD"], 3, '0', STR_PAD_LEFT) . ") " .dw3_decrypt($row["clADR"]) . "</option>";
		}
	}
$dw3_conn->close();
?>

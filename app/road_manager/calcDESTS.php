<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$rtID = $_GET['rtID'];
$rtLOC = "";
//effacer l'ordre
	$sql = "UPDATE road_line SET sort_number = 0 WHERE road_id = '" . $rtID . "' ";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo "";
	} else {
	  echo $dw3_conn->error;
	}
	
//aller chercher infos sur la route
	$sql = "SELECT * FROM location WHERE id IN (SELECT location_id FROM road_head WHERE id = '" . $rtID . "')			
			LIMIT 1";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {		
			while($row = $result->fetch_assoc()) {
				$rtLOC = $row["id"];
				//echo $rtID;
			}
		}	
//aller chercher quantite destinations
	$sql = "SELECT COUNT(*) as qtyCLI FROM road_line WHERE road_id = " . $rtID . " LIMIT 1";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {		
			while($row = $result->fetch_assoc()) {
				$qtyDEST = $row["qtyCLI"];
				//echo $qtyDEST;
			}
		}

//aller chercher le plus proche du depart
	$sql = "SELECT
				ABS(A.latitude - B.latitude) as DIST1, 
				ABS(A.longitude - B.longitude) as DIST2,
				ABS(ABS(A.latitude - B.latitude)+ABS(A.longitude - B.longitude)) AS DIST_TOT,
				A.*
			FROM customer A 
			LEFT JOIN (SELECT * FROM location) B ON B.id = '" . $rtLOC  . "'
			WHERE A.id IN (SELECT customer_id FROM road_line WHERE road_id = '" . $rtID . "'  AND sort_number = 0)
			AND A.longitude <> 0
			AND A.latitude <> 0
			ORDER BY DIST_TOT ASC 
			LIMIT 1";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {		
			while($row = $result->fetch_assoc()) {
				//update ORD
				$sql2 = "UPDATE road_line SET sort_number = 1
				 WHERE road_id = '" . $rtID . "'
				 AND customer_id = '" . $row["id"] . "';";
				if ($dw3_conn->query($sql2) === TRUE) {
				  //echo "";
				  $nextID = $row["id"];
				  //echo $nextID;
				} else {
				  echo $dw3_conn->error;
				}
			}
		}
//tri
for ($x = 0; $x <= ($qtyDEST-1); $x++) {
	$y = $x + 2;
	$sql = "SELECT
				ABS(A.latitude - B.latitude) as DIST1, 
				ABS(A.longitude - B.longitude) as DIST2,
				ABS(ABS(A.latitude - B.latitude)+ABS(A.longitude - B.longitude)) AS DIST_TOT,
				A.*
			FROM customer A 
			LEFT JOIN (SELECT * FROM customer) B ON B.id = '" . $nextID . "'
			WHERE A.id IN (SELECT customer_id FROM road_line WHERE road_id = '" . $rtID . "' AND sort_number = 0)
			AND A.longitude <> 0
			AND A.latitude <> 0
			ORDER BY DIST_TOT ASC 
			LIMIT 1";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {		
			while($row = $result->fetch_assoc()) {

				$sql2 = "UPDATE road_line SET sort_number = '". $y . "'
				 WHERE road_id = '" . $rtID . "'
					AND customer_id = '" . $row["id"] . "'
				 ";
				if ($dw3_conn->query($sql2) === TRUE) {
				  echo "" ;
				} else {
				  echo $dw3_conn->error;
				}
				$nextID = $row["id"] ;
			}
			
		}
  
  
  
  
}

	
$dw3_conn->close();
?>
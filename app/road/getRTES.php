<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$rtID  = $_GET['rtID'];
$clID  = $_GET['clID'];

if ($clID != ""){
	$oneCLI = " AND A.id = '" . $clID . "' ";
} else { 
	$oneCLI = "";
}

//DATA->JSON
$sql = "SELECT A.*,B.sort_number as bclORD
			FROM customer A
            LEFT JOIN (SELECT * FROM road_line WHERE road_id = " . $rtID . ") B ON A.id = B.customer_id  
			WHERE A.id IN(SELECT DISTINCT customer_id FROM road_line 
						WHERE road_id = " . $rtID .  $oneCLI .")
			ORDER BY bclORD";
            //if ($clID != ""){die($sql);}
$result = $dw3_conn->query($sql);
$numResults = $result->num_rows;
$counter = 0;
$var_out = "";
date_default_timezone_set('America/New_York');
if ($result->num_rows > 0) {
	$var_out = '{"data":[';
    while($row = $result->fetch_assoc()) {
		//couleur
		if ($row["freq_visit_day"] == "0" && $row["freq_visit_hour"] == "0"){
			//si 1 seule visite	
			//si visite frequentes au client (neige, entretien..)
			$couleur = 'DodgerBlue';
		} else {
			$dateLiv=date_create($row["last_visit_day"] . " " . $row["last_visit_hour"]);
			$now2 = date_create($today . " " . $time);
			$diff=date_diff($dateLiv,$now2);
			$diff_way = $diff->format("%R");
			$diff_y = $diff->format("%y");
			$diff_m = $diff->format("%m");
			$diff_d = $diff->format("%d");
			$diff_h = $diff->format("%h");
			$diff_i = $diff->format("%I");
			
			if ($diff_way == "+"){
				$couleur = 'SeaGreen';
				
				date_add($dateLiv,date_interval_create_from_date_string( $row["freq_visit_day"] . " days " . $row["freq_visit_hour"] . " hours"));
				$diff1=date_diff($dateLiv,$now2);
				$d1_way = $diff1->format("%R");
				$d1_h = $diff1->format("%h");
				
				date_add($dateLiv,date_interval_create_from_date_string( $row["freq_visit_day"] . " days " . $row["freq_visit_hour"] . " hours"));
				$diff2=date_diff($dateLiv,$now2);
				$d2_way = $diff2->format("%R");
				$d2_h = $diff2->format("%h");
				
				date_add($dateLiv,date_interval_create_from_date_string( $row["freq_visit_day"] . " days " . $row["freq_visit_hour"] . " hours"));
				$diff3=date_diff($dateLiv,$now2);
				$d3_way = $diff3->format("%R");
				$d3_h = $diff3->format("%h");

				date_add($dateLiv,date_interval_create_from_date_string( $row["freq_visit_day"] . " days " . $row["freq_visit_hour"] . " hours"));
				$diff4=date_diff($dateLiv,$now2);
				$d4_way = $diff4->format("%R");
				$d4_h = $diff4->format("%h");
				
				date_add($dateLiv,date_interval_create_from_date_string( $row["freq_visit_day"] . " days " . $row["freq_visit_hour"] . " hours"));
				$diff5=date_diff($dateLiv,$now2);
				$d5_h = $diff5->format("%h");
				$d5_way = $diff5->format("%R");

				if ($d1_way == "+") {
					$couleur = 'yellow';
				//BLUE
				}
				if ($d2_way == "+") {
					$couleur = 'orange';
				//VERT
				} 				
				if ($d3_way == "+") {
					$couleur = 'IndianRed';
				//JAUNE  
				}	
				if ($d4_way == "+"){
					$couleur = 'red';
				//ORANGE 
				}	
				if ($d5_way == "+") {
					$couleur = 'brown';
				//BLUE
				} 
			}
		}
		if (strlen($row["note"]) <= 30){
			$notes = str_replace('<br>', '&#10;', $row["note"]);
		} else {
			$notes = substr(str_replace('<br>', '&#10;', $row["note"]),0,30) . "...";
		}
		$var_out .= '{"id":"' . $row["id"] . '","nom":"' . dw3_decrypt($row["last_name"])  . '","adr":"' . dw3_decrypt($row["adr1"]) . '","ord":"' . $row["bclORD"] . '","lng":"' . $row["longitude"] . '","lat":"' . $row["latitude"] . '","heure":"' . $row["last_visit_hour"] . '","jour":"' . $row["last_visit_day"] . '","couleur":"' . $couleur . '","note":"' . $notes . '","phone":"' . dw3_decrypt($row["tel1"]) . '" }';
		if (++$counter == $numResults) {
		// last row
				//echo "";
		} else {
		// not last row
				$var_out .= ",";
		}
    } 
	$var_out .= "]}";
}
echo $var_out;
$dw3_conn->close();
?>

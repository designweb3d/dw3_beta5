<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$rtID  = $_GET['rtID'];
$n  = $_GET['n'];
$s  = $_GET['s'];
$e  = $_GET['e'];
$w  = $_GET['w'];
$f  = $_GET['f']; //filtre 0-aucun 1-ceux deja sur cette route 2-ceux qui ont deja une route
$r  = $_GET['r']; //filtre par recherche 

if ($f=="0"){
    $sql = "SELECT A.*, IFNULL(B.customer_id,0) as clID, IFNULL(B.sort_number,-0) as bclORD
    FROM customer A 
    LEFT JOIN (SELECT * FROM road_line WHERE road_id = " . $rtID . ")
    B ON A.id = B.customer_id
    WHERE A.stat = 0 
        AND A.latitude < " . $n . "
        AND A.latitude > " . $s . "
        AND A.longitude < " . $e . "
        AND A.longitude > " . $w . "
        ";

} else if ($f=="1"){
    $sql = "SELECT A.*, IFNULL(B.customer_id,0) as clID, IFNULL(B.sort_number,-0) as bclORD
    FROM customer A 
    LEFT JOIN (SELECT * FROM road_line WHERE road_id = " . $rtID . ")
    B ON A.id = B.customer_id
    WHERE A.stat = 0  
        AND A.id NOT IN(SELECT DISTINCT customer_id FROM road_line 
                        WHERE road_id = " . $rtID . ")
        AND A.latitude < " . $n . "
        AND A.latitude > " . $s . "
        AND A.longitude < " . $e . "
        AND A.longitude > " . $w . "
        ";

} else if ($f=="2"){
    $sql = "SELECT A.*, IFNULL(B.customer_id,0) as clID, IFNULL(B.sort_number,-0) as bclORD
    FROM customer A 
    LEFT JOIN (SELECT * FROM road_line WHERE road_id = " . $rtID . ")
    B ON A.id = B.customer_id
    WHERE A.stat = 0 
        AND A.id NOT IN(SELECT DISTINCT customer_id FROM road_line)
        AND A.latitude < " . $n . "
        AND A.latitude > " . $s . "
        AND A.longitude < " . $e . "
        AND A.longitude > " . $w . "
        ";
}
if ($r!=""){
    $sql .= " AND CONCAT(A.first_name,A.last_name,A.adr1,A.adr2,A.city,A.province,A.country,A.tel1,A.eml1) LIKE '%" . $r . "%'";
}

$result = $dw3_conn->query($sql);
$numResults = $result->num_rows;
$counter = 0;
$var_out = "";
date_default_timezone_set('America/New_York');
if ($result->num_rows > 0) {
	$var_out = '{"data":[';
    while($row = $result->fetch_assoc()) {
		if ($row["clID"] == "0"){
			$couleur = 'SeaGreen';
		} else {	
			$couleur = 'grey';
		}
		$var_out .= '{"id":"' . $row["clID"] . '","nom":"' . dw3_decrypt($row["last_name"])  . '","adr":"' . dw3_decrypt($row["adr1"]) . '","ord":"' . $row["bclORD"] . '","lng":"' . $row["longitude"] . '","lat":"' . $row["latitude"] . '","heure":"' . $row["freq_visit_hour"] . '","jour":"' . $row["freq_visit_day"] . '","couleur":"' . $couleur . '","note":"' . $row["note"] . '" }';
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
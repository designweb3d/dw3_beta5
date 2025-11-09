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
        $sql = "SELECT A.*, IFNULL(B.id,0) as clID, IFNULL(B.sort_number,-0) as bclORD
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
        $sql = "SELECT A.*, IFNULL(B.id,0) as clID, IFNULL(B.sort_number,-0) as bclORD
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
        $sql = "SELECT A.*, IFNULL(B.id,0) as clID, IFNULL(B.sort_number,-0) as bclORD
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
    $sql .= " ORDER BY last_name,first_name";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		echo "<form onsubmit='submitForm(event)' id='frmDEST' style='overflow:hidden;'><table class='tblSEL'>";		
		while($row = $result->fetch_assoc()) {
			echo "<tr draggable='true' ondragstart='start()' ondragover='dragover()'><td style='width:15px;'>
					<input id='chkCLI" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox'></td>
					<td onclick='selCHK(\"chkCLI" . $row["id"] . "\");' style='width:200px;'>". dw3_decrypt($row["last_name"]) . "</td>
					<td onclick='selCHK(\"chkCLI" . $row["id"] . "\");' style='width:100%;'>" . dw3_decrypt($row["adr1"]) . "</td></tr>";
		}
		echo "</table></form>";
		echo "<button style='background:#444444;' onclick='selALL(\"frmDEST\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
		echo "<button style='background:#444444;' onclick='selNONE(\"frmDEST\",\"checkbox\");'><span class='material-icons'>remove_done</span></button>";
		echo "<button style='background:#444444;' onclick='closeMAP();'><span class='material-icons'>close</span> Fermer</button>";
		echo "<button onclick='addCLIS();'><span class='material-icons'>more</span> Ajouter</button>";
	} else {
		echo "<table class='tblDATA'><tr><th>Destinations</th></tr>";		
		echo " <tr><td>Aucune destination disponible</td></tr>";
		echo "</table>";

	}

$dw3_conn->close();
?>

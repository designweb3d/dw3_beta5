<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$html = "";
	$sql = "SELECT * FROM procedure_head ORDER BY name_fr ASC";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		$html .= "<table class='tblDATA'><tr><th>Action</th><th>Nom</th></tr>";
		while($row = $result->fetch_assoc()) {
            if ($APREAD_ONLY == false) {
                $html .= "<tr><td width='160px'><button onclick='getPROCEDURE(\"" . $row["id"] . "\");'><span class='material-icons'>edit</span></button>";
            } else {
                $html .= "<tr><td width='40px'><button onclick='getPROCEDURE(\"" . $row["id"] . "\");'><span class='material-icons'>visibility</span></button>";
            }
            if ($APREAD_ONLY == false) { $html .= "<button class='blue' onclick='newPRODUCTION(\"" . $row["id"] . "\");'><span class='material-icons'>precision_manufacturing</span> Produire</button>";}
            $html .= "</td><td>" . $row["name_fr"] . "</td></tr>";
		}
		$html .= "</table>";
	}
$dw3_conn->close();
header('Status: 200');
die($html);
?>
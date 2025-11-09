<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$why  = mysqli_real_escape_string($dw3_conn, $_GET['why']);
$html="";
			$sql = "SELECT A.*
				FROM product A
				WHERE A.stat = 0 ";
			if ($SS != "")		{ $sql = $sql . " AND  CONCAT(A.id,A.upc, A.name_fr, A.description_fr) like '%" . $SS . "%' "; }
			$sql = $sql . "
				ORDER BY name_fr ASC
				LIMIT 100";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<div style='max-width:100%;overflow-y:auto;'>" ;		
			$html .= "<table class='tblSEL'>
			<tr></tr>
				<th>" . $dw3_lbl["ID"] . "</th>
				<th>UPC</th>
				<th>" . $dw3_lbl["NOM"] . "</th>"; 
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
				$html .= "<tr onclick='validatePRD(\"". $row["id"] . "\",\"" . $why . "\");'>";
				$html .= "<td><b>". $row["id"] . "</b></td>";
				$html .= "<td>". $row["upc"] .   "</td>";
				$html .= "<td>" . $row["name_fr"] .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table></div>";
            if ($result->num_rows == 100) {
                $html .= "<div style='margin-top:10px;color:#666666;font-size:0.9em;'><i>Limite de 100 résultats, affinez votre recherche.</i></div>";
            }
		}
			
echo $html;
$dw3_conn->close();
?>

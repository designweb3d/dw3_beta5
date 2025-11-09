<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$html="";
			$sql = "SELECT * FROM scene";
			if ($SS != "") { $sql = $sql . " AND UCASE(CONCAT(name_fr,description_fr)) like '%" . strtoupper($SS) . "%' "; }
			$sql = $sql . "
				ORDER BY name_fr ASC ;";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<div style='max-width:100%;overflow-y:auto;'>
            <table class='tblSEL'>
			<tr></tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Description</th>";  
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
				$html .= "<tr onclick=\"validateSCENE('". $row["id"] . "');\">";
				$html .= "<td>". $row["id"] .   "</td>";
				$html .= "<td>". $row["name_fr"] .   "</td>";
				$html .= "<td>" . $row["description_fr"] .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table></div>";
		}
$dw3_conn->close();
die($html);
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LOOK_FOR  = mysqli_real_escape_string($dw3_conn, $_GET['LOOK_FOR']);
$OUTPUT_ID  = mysqli_real_escape_string($dw3_conn, $_GET['OUTPUT_ID']);
$html="";

        $sql = "SELECT * FROM user WHERE stat = 0";
        if ($LOOK_FOR != "") { $sql = $sql . " AND UCASE(CONCAT(first_name,last_name, eml1, tel1)) like '%" . strtoupper($LOOK_FOR) . "%' "; }
        $sql = $sql . " ORDER BY last_name ASC, first_name ASC LIMIT 100";
        //die($sql);
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
            if ($result->num_rows > 100) {	
                $html .= "<div style='padding:10px;color:darkred;'>Plus de 100 résultats, veuillez affiner votre recherche..</div>";
            }
			$html .= "<div style='max-width:100%;overflow-y:auto;'>";		
			$html .= "<table class='tblSEL'>
			<tr></tr>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Email</th>
				<th>Téléphone</th>
				<th>Adresse</th>";  
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
				$html .= "<tr onclick=\"validateUSER('". $row["id"] . "','" . $OUTPUT_ID . "');\">";
				$html .= "<td>". $row["last_name"] .   "</td>";
				$html .= "<td>". $row["first_name"] .   "</td>";
				$html .= "<td>" . $row["eml1"] .  "</td>";
				$html .= "<td>" . $row["tel1"] .  "</td>";
				$html .= "<td>" . $row["adr1"] . " " . $row["city"]  .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table></div>";
		} else {
            $html .= "<div style='padding:10px;color:darkred;'>Aucun utilisateur trouvé..</div>";
        }
			
$dw3_conn->close();
die($html);
?>

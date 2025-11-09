<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$LOOK_FOR  = mysqli_real_escape_string($dw3_conn, $_GET['LOOK_FOR']);
$OUTPUT_ID  = mysqli_real_escape_string($dw3_conn, $_GET['OUTPUT_ID']);
$html="";
//$already_send  = "(".substr($already_send,0,-1) . ")";
        $sql = "SELECT * FROM customer WHERE stat = 0 ";
        if ($LOOK_FOR != "") { $sql = $sql . " AND UCASE(CONCAT(first_name,last_name, eml1, tel1)) like '%" . strtoupper(dw3_crypt($LOOK_FOR)) . "%' "; }
        $sql = $sql . " ORDER BY last_name ASC, first_name ASC LIMIT 100";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {
            if ($result->num_rows > 100) {	
                $html .= "<div style='padding:10px;color:darkred;'>Plus de 100 résultats, veuillez affiner votre recherche..</div>";
            }
			$html .= "<div style='max-width:100%;overflow-y:auto;'>";		
			$html .= "<table class='tblSEL'>
			<tr></tr>
				<th>Langue</th>
				<th>Nom</th>
				<th>Email</th>
				<th>Téléphone</th>
				<th>Adresse</th>";  
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
				$html .= "<tr onclick='validateCLI(\"". $row["id"] . "\",\"" . $OUTPUT_ID . "\");'>";
				$html .= "<td style='text-align:center;'>". strtoupper($row["lang"]) .   "</td>";
				$html .= "<td>". dw3_decrypt($row["last_name"]) .   "</td>";
				$html .= "<td>" . dw3_decrypt($row["eml1"]) .  "</td>";
				$html .= "<td>" . dw3_decrypt($row["tel1"]) .  "</td>";
				$html .= "<td>" . dw3_decrypt($row["adr1"]) . " " . $row["city"]  .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table></div>";
		} else {
            $html .= "Tout les clients ont le document dans leur espace-client.";
        }
			
$dw3_conn->close();
die($html);
?>

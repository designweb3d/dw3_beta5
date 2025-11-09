<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$why  = mysqli_real_escape_string($dw3_conn, $_GET['why']);
$html="";
			$sql = "SELECT A.*, IFNULL(B.date_modified,''), IFNULL(C.date_modified,'')
				FROM customer A
                LEFT JOIN (SELECT customer_id,MAX(date_modified) AS date_modified FROM order_head) B ON A.id = B.customer_id 
                LEFT JOIN (SELECT customer_id,MAX(date_modified) AS date_modified FROM invoice_head) C ON A.id = C.customer_id 
				WHERE A.stat = 0 ";
			if ($SS != "")		{ $sql = $sql . " AND  CONCAT(A.id,A.first_name, A.last_name, A.adr1, A.adr2,A.tel1,A.tel2,A.eml1,A.eml2) like '%" . dw3_crypt($SS) . "%' "; }
			$sql = $sql . "
				ORDER BY B.date_modified DESC,C.date_modified DESC
				LIMIT 100";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<div style='max-width:100%;overflow-x:auto;'>" ;		
			$html .= "<table class='tblSEL''>
			<tr></tr>
				<th style='border-top-left-radius: 12px;'>" . $dw3_lbl["ID"] . "</th>
				<th>" . $dw3_lbl["NOM"] . "</th>
				<th  style='border-top-right-radius: 12px;'>" . $dw3_lbl["ADR"] . "</th>"; 
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
				$html .= "<tr onclick='validateCLI(\"". $row["id"] . "\",\"" . $why . "\");'>";
				$html .= "<td><b>". $row["id"] . "</b></td>";
				$html .= "<td>". dw3_decrypt($row["last_name"]) . ", " . dw3_decrypt($row["first_name"]) .  "</td>";
				$html .= "<td>" . dw3_decrypt($row["adr1"]) . ", " . $row["city"] .  "</td>";
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

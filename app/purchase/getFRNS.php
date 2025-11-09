<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$html="";
			$sql = "SELECT A.*, IFNULL(B.date_modified,'')
				FROM supplier A
                LEFT JOIN (SELECT supplier_id,MAX(date_modified) AS date_modified FROM purchase_head) B ON A.id = B.supplier_id 
				WHERE A.stat = 0 ";
			if ($SS != "")		{ $sql = $sql . " AND  CONCAT(A.id,A.company_name, A.contact_name, A.adr1, A.adr2,A.tel1,A.tel2,A.eml1,A.eml2,A.contact_note) like '%" . $SS . "%' "; }
			$sql = $sql . "
				ORDER BY B.date_modified DESC
				LIMIT 100";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "" ;		
			$html .= "<table id='dataFRNS' class='tblSEL'>";
			while($row = $result->fetch_assoc()) {
				$html .= "<tr onclick='validateFRN(\"". $row["id"] . "\",this);'>";
				$html .= "<td>". $row["type"] . "</td>";
				$html .= "<td>". $row["company_name"] . "  " . $row["contact_name"] .  "</td>";
				$html .= "<td>" . $row["city"] .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table>";
		} else {
            $html .= "Aucun fournisseur trouvé";
            //$html .= $sql;
        }
			
echo $html;
$dw3_conn->close();
?>

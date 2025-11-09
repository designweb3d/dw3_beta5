<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$html="";
			$sql = "SELECT A.*, IFNULL(B.date_modified,'') AS order_modified
				FROM customer A
                LEFT JOIN (SELECT customer_id,MAX(date_modified) AS date_modified FROM order_head  GROUP BY customer_id) B ON A.id = B.customer_id 
				WHERE A.stat = 0 ";
			if ($SS != "")		{ $sql = $sql . " AND  CONCAT(A.id,A.company, A.last_name, A.adr1,A.tel1,A.eml1) like '%" . $SS . "%' "; }
			$sql = $sql . "
				ORDER BY order_modified DESC
				LIMIT 100";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "" ;		
			$html .= "<table id='dataCLIS' class='tblSEL'>";
			while($row = $result->fetch_assoc()) {
				$html .= "<tr onclick='validateCLI(\"". $row["id"] . "\",this);'>";
				$html .= "<td>". $row["type"] . "</td>";
				$html .= "<td>". $row["company"] . "  " . dw3_decrypt($row["last_name"]) .  "</td>";
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

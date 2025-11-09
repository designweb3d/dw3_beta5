<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$html="";

			$sql = "SELECT A.*, IFNULL(B.head_stotal,0) as head_stotal FROM order_head A
                    LEFT JOIN (SELECT head_id, SUM(price*(qty_order-qty_shipped)) as head_stotal FROM order_line GROUP BY head_id) B ON A.id = B.head_id
                    WHERE stat = 0 ";
			if ($SS != "")		{ $sql = $sql . " AND  CONCAT(id,company,eml,note) like '%" . $SS . "%' "; }
			$sql = $sql . "
				ORDER BY id DESC
				LIMIT 100";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<div style='max-height:50%;max-width:100%;overflow-x:auto;'>" ;		
			$html .= "<table id='dataCMDS' class='tblSEL'>
			<tr></tr>
				<th style='border-top-left-radius: 12px;'>" . $dw3_lbl["ID"] . "</th>
				<th colspan=2>" . $dw3_lbl["NOM"] . "</th>
				<th  style='border-top-right-radius: 12px;'>Total</th>"; 
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
				$html .= "<tr onclick='validateCMD(\"". $row["id"] . "\",this);'>";
				$html .= "<td>". $row["id"] . "</td>";
				$html .= "<td>". dw3_decrypt($row["name"]) . " </td>";
				$html .= "<td>" . $row["company"] . "</td>";
				$html .= "<td>" . number_format($row["head_stotal"],2,'.',',') ."$</td>";
				$html .= "</tr>";
			}
            $html .= "</table></div>";
		} else {
            $html .= "<div style='height:75px;max-width:100%;overflow-x:auto;'>" ;		
			$html .= "<table id='dataCMDS' class='tblDATA'><tr><td>Aucune commande facturable trouvée.</td></tr>";
            $html .= "</table></div>";
        }	
echo $html;
$dw3_conn->close();
?>

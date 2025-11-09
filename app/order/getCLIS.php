<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$html="";
			$sql = "SELECT A.*, IFNULL(B.date_modified,''), IFNULL(C.date_modified,'')
				FROM customer A
                LEFT JOIN (SELECT customer_id,MAX(date_modified) AS date_modified FROM order_head) B ON A.id = B.customer_id 
                LEFT JOIN (SELECT customer_id,MAX(date_modified) AS date_modified FROM invoice_head) C ON A.id = C.customer_id 
				WHERE A.stat = 0 ";
			if ($SS != "")		{ 
                $sql = $sql . " AND  CONCAT(A.id,A.city,A.company) like '%" . $SS . "%' "; 
                $sql = $sql . " OR A.stat = 0 AND A.last_name like '%" . dw3_crypt($SS) . "%' "; 
                $sql = $sql . " OR A.stat = 0 AND A.tel1 like '%" . dw3_crypt($SS) . "%' "; 
                $sql = $sql . " OR A.stat = 0 AND A.eml1 like '%" . dw3_crypt($SS) . "%' "; 
            }
			$sql = $sql . "
				ORDER BY A.date_modified DESC
				LIMIT 100";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			//$html .= "<div style='max-width:100%;overflow-x:hidden;overflow-y:scroll;'>" ;		
			$html .= "<table id='dataCLIS' class='tblSEL' style='border-collapse:collapse;border:0px;'>
			    <tr>
				<th style='border-top-left-radius: 12px;'>Cie</th>
				<th>Contact</th>
				<th  style='border-top-right-radius: 12px;'>Adresse</th>"; 
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
                $row_color = "white";
                if ($row["type"]=="PARTICULAR"){$row_color = "blue";}
                if ($row["type"]=="COMPANY"){$row_color = "green";}
                if ($row["type"]=="RETAILER"){$row_color = "orange";}
                if ($row["type"]=="INTERNAL"){$row_color = "grey";}
				$html .= "<tr onclick='validateCLI(\"". $row["id"] . "\",this);' style='box-shadow: inset 0px 0px 5px 2px ".$row_color ."'>";
				$html .= "<td style='border:0px;'>". $row["company"] . "</td>";
                if (strlen($row["last_name"])>20){
				    $html .= "<td style='border:0px;'>". substr(dw3_decrypt($row["last_name"]),0,20) . "..</td>";
                } else {
                    $html .= "<td style='border:0px;'>". dw3_decrypt($row["last_name"]) . "</td>";
                }
                if (strlen($row["adr1"])>20){
				    $html .= "<td style='border:0px;'>" . substr(dw3_decrypt($row["adr1"]),0,20) . ".., " . $row["city"] .  "</td>";
                } else {
				    $html .= "<td style='border:0px;'>" . dw3_decrypt($row["adr1"]) . ", " . $row["city"] .  "</td>";
                }
				$html .= "</tr>";
			}
            $html .= "</table>";
            //$html .= "</table></div>";
		}
			
echo $html;
$dw3_conn->close();
?>

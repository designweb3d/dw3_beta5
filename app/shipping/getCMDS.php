<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$html="";
			/* $sql = "SELECT A.*, IFNULL(C.qty_to_ship,0) as qty_to_ship, IFNULL(B.prd_ship_type,0) as prd_ship_type 
			FROM order_head A
                LEFT JOIN (select head_id, COUNT(*) as qty_to_ship FROM order_line GROUP BY head_id HAVING qty_order > qty_shipped) C ON A.id = C.head_id 
                LEFT JOIN (select id, COUNT(*) as prd_ship_type FROM product GROUP BY id HAVING ship_type = 'CARRIER' OR ship_type = 'INTERNAL') B ON C.product_id = B.id 
				WHERE stat <> -1 "; */
			$sql = "SELECT A.*, COUNT(C.product_id) as qty_to_ship, COUNT(B.id) as prd_ship_type 
					FROM order_head A 
					LEFT JOIN (select head_id, product_id FROM order_line WHERE qty_order > qty_shipped) C ON A.id = C.head_id 
					LEFT JOIN (select id FROM product WHERE ship_type = 'CARRIER' OR ship_type = 'INTERNAL') B ON C.product_id = B.id 
					WHERE stat <> -1 
					GROUP BY A.id ";
			if ($SS != "")		{ 
                $sql = $sql . " AND  CONCAT(id,city_sh,company) like '%" . $SS . "%' "; 
                $sql = $sql . " OR name like '%" . dw3_crypt($SS) . "%' "; 
                $sql = $sql . " OR tel like '%" . dw3_crypt($SS) . "%' "; 
                $sql = $sql . " OR adr1_sh like '%" . dw3_crypt($SS) . "%' "; 
                //die ($sql);
            }
			$sql = $sql . "
				ORDER BY prd_ship_type DESC, date_modified DESC
				LIMIT 100";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<table id='dataCMDS' class='tblSEL'>
			    <tr>
				<th>ID</th>
				<th>Date</th>
				<th style='border-top-left-radius: 12px;'>Client</th>
				<th  style='border-top-right-radius: 12px;'>Adresse</th>"; 
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
				if ($row["qty_to_ship"] > 0 && $row["prd_ship_type"] > 0) {
					$valid_shipment = "box-shadow: inset 0px 0px 4px 2px greenyellow;";
				} else {
					$valid_shipment = "box-shadow: inset 0px 0px 4px 2px orangered;";
				}
				$html .= "<tr onclick='validateCMD(\"". $row["id"] . "\",this);' style='".$valid_shipment."'>";
				$html .= "<td style='border:0px;'>". $row["id"] . "</td>";
				$html .= "<td style='border:0px;'>". $row["date_created"] . "</td>";
                if (strlen($row["name"])>20){
				    $html .= "<td style='border:0px;'>". $row["company"]. " " . substr(dw3_decrypt($row["name"]),0,20) . "..</td>";
                } else {
                    $html .= "<td style='border:0px;'>".  $row["company"]. " " . dw3_decrypt($row["name"]) . "</td>";
                }
                if (strlen($row["adr1_sh"])>20){
				    $html .= "<td style='border:0px;'>" . substr(dw3_decrypt($row["adr1_sh"]),0,20) . ".., " . $row["city_sh"] .  "</td>";
                } else {
				    $html .= "<td style='border:0px;'>" . dw3_decrypt($row["adr1_sh"]) . ", " . $row["city_sh"] .  "</td>";
                }
				$html .= "</tr>";
			}
            $html .= "</table>";
            if ($result->num_rows > 100) {
                $html .= "<div style='text-align:center;color:red;'>Plus de 100 résultats, veuillez affiner votre recherche.</div>";
            }
		} else {
            $html .= "<div style='text-align:center;color:red;'>Aucune commande trouvée selon la recherche.</div>";
        }
			
echo $html;
$dw3_conn->close();
?>

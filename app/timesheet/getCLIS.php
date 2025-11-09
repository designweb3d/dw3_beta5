<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$html="";
			$sql = "SELECT A.*, IFNULL(B.date_modified,''), IFNULL(C.date_modified,'')
				FROM customer A
                LEFT JOIN (SELECT customer_id,MAX(date_modified) AS date_modified FROM order_head) B ON A.id = B.customer_id 
                LEFT JOIN (SELECT customer_id,MAX(date_modified) AS date_modified FROM invoice_head) C ON A.id = C.customer_id 
				WHERE A.stat = 0 ";
			if ($SS != "")		{ $sql = $sql . " AND  CONCAT(A.id,A.first_name, A.last_name, A.adr1, A.adr2,A.tel1,A.tel2,A.eml1,A.eml2,A.note) like '%" . dw3_crypt($SS) . "%' "; }
			$sql = $sql . "
				ORDER BY B.date_modified DESC,C.date_modified DESC
				LIMIT 20";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<div style='max-height:50%;max-width:100%;overflow-x:auto;'>" ;		
			$html .= "<table id='dataCLIS' class='tblSEL' style='font-size:0.8em;border-radius:15px;border:0px;'>";
			while($row = $result->fetch_assoc()) {
				$html .= "<tr onclick='validateCLI(\"". $row["id"] . "\",this);' style='border-radius:15px;border:0px;'>";
/*                 if (trim(dw3_decrypt($row["last_name"])) != ''){
                    if (trim(dw3_decrypt($row["first_name"])) != ''){
                        $html .= "<td style='border-radius:15px;border:0px;'>". dw3_decrypt($row["last_name"]) . ", " . dw3_decrypt($row["first_name"]) .  "</td>";
                    } else {
                        $html .= "<td style='border-radius:15px;border:0px;'>" . dw3_decrypt($row["last_name"]) .  "</td>";
                    }
                } else {
                    $html .= "<td style='border-radius:15px;border:0px;'>". dw3_decrypt($row["first_name"]) .  "</td>";
                } */
                $html .= "<td style='border-radius:15px;border:0px;'>". dw3_decrypt($row["first_name"]) . " " . dw3_decrypt($row["last_name"]) .  "</td>";
				$html .= "<td style='border-radius:15px;border:0px;width:100px;text-align:center;'>". dw3_decrypt($row["tel1"]) . "</td>";
				$html .= "<td style='border-radius:15px;border:0px;'>" . dw3_decrypt($row["eml1"]) .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table></div>";
		}
			
echo $html;
$dw3_conn->close();
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$PRJ  = mysqli_real_escape_string($dw3_conn, $_GET['PRJ']);
$CLI  = mysqli_real_escape_string($dw3_conn, $_GET['CLI']);
$LOOK_FOR  = mysqli_real_escape_string($dw3_conn, $_GET['LOOK_FOR']);
$DB  = mysqli_real_escape_string($dw3_conn, $_GET['DB']);
$html="<div>
<span style='padding:2px 4px;border-radius:4px;font-size:12px;background:darkgreen;color:white;'>Associé à <b>ce</b> projet</span>
<span style='padding:2px 4px;border-radius:4px;font-size:12px;background:darkblue;color:white;'>Associé à <b>aucun</b> projet</span>
<span style='padding:2px 4px;border-radius:4px;font-size:12px;background:#555;color:white;'>Associé à <b>un autre</b> projet</span>
</div>";

if ($DB == 'order'){
    $html .= "<h2>Commandes client</h2>";
    $sql = "SELECT A.*, IFNULL(B.product_desc,'') AS products_desc, IFNULL(C.product_desc,'') AS products_desc2, IFNULL(D.stotal,0) AS enNET
     FROM order_head A 
    LEFT JOIN (SELECT * FROM order_line) B ON B.id = (SELECT MIN(id) FROM order_line BB WHERE BB.head_id = A.id) 
    LEFT JOIN (SELECT * FROM order_line) C ON C.id = (SELECT MAX(id) FROM order_line CC WHERE CC.head_id = A.id) 
    LEFT JOIN (SELECT head_id, SUM(qty_order*price) AS stotal FROM order_line GROUP BY head_id) D ON D.head_id = A.id
    WHERE A.customer_id = '".$CLI."' OR project_id = '".$PRJ."' ";
    if ($LOOK_FOR != "") { $sql = $sql . " OR A.id like '%" . $LOOK_FOR . "%' OR A.name like '%" . dw3_crypt(strtolower($LOOK_FOR)) . "%' OR A.name like '%" . dw3_crypt(strtoupper($LOOK_FOR)) . "%' OR A.name like '%" . dw3_crypt(ucfirst($LOOK_FOR)) . "%' "; }
    $sql = $sql . " ORDER BY A.id DESC LIMIT 100";
} else if ($DB == 'invoice'){
    $html .= "<h2>Factures client</h2>";
    $sql = "SELECT A.*, IFNULL(B.product_desc,'') AS products_desc, IFNULL(C.product_desc,'') AS products_desc2, IFNULL(D.stotal,0) AS enNET
    FROM invoice_head A 
    LEFT JOIN (SELECT * FROM invoice_line) B ON B.id = (SELECT MIN(id) FROM invoice_line BB WHERE BB.head_id = A.id) 
    LEFT JOIN (SELECT * FROM invoice_line) C ON C.id = (SELECT MAX(id) FROM invoice_line CC WHERE CC.head_id = A.id) 
    LEFT JOIN (SELECT head_id, SUM(qty_order*price) AS stotal FROM invoice_line GROUP BY head_id) D ON D.head_id = A.id
    WHERE A.customer_id = '".$CLI."'  OR project_id = '".$PRJ."'";
    if ($LOOK_FOR != "") { $sql = $sql . " OR A.id like '%" . strtoupper($LOOK_FOR) . "%' "; }
    $sql = $sql . " ORDER BY A.id DESC LIMIT 100";
} else if ($DB == 'purchase'){
    $html .= "<h2>Achats</h2>";
    $sql = "SELECT A.*, IFNULL(B.name_fr,'') AS products_desc, IFNULL(C.name_fr,'') AS products_desc2, IFNULL(D.stotal,0) AS enNET
    FROM purchase_head A
    LEFT JOIN (SELECT * FROM purchase_line) B ON B.id = (SELECT MIN(id) FROM purchase_line BB WHERE BB.head_id = A.id) 
    LEFT JOIN (SELECT * FROM purchase_line) C ON C.id = (SELECT MAX(id) FROM purchase_line CC WHERE CC.head_id = A.id) 
    LEFT JOIN (SELECT head_id, SUM(qty_order*price) AS stotal FROM purchase_line GROUP BY head_id) D ON D.head_id = A.id
    ";
    if ($LOOK_FOR != "") { $sql = $sql . " WHERE UCASE(CONCAT(A.id,A.name)) like '%" . strtoupper($LOOK_FOR) . "%' "; }
    $sql = $sql . " ORDER BY A.id DESC LIMIT 100";
} 
//error_log($sql);
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<table class='tblSEL'><tr></tr>
				<th>ID</th>
                <th>Nom</th>
				<th>Project ID</th>
				<th>Produits</th>
				<th>Total</th>
				<th>Modifié</th>";  
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
                $txtstyle = "";
                if ($row["project_id"] == $PRJ) {
                    $txtstyle =  "style='background:darkgreen;color:white;' ";
                } else if ($row["project_id"] == "0") {
                    $txtstyle =  "style='background:darkblue;color:white;' ";
                } else {
                    $txtstyle =  "style='background:darkgrey;color:white;' ";
                }
				$html .= "<tr onclick='validateENT(\"". $row["id"] . "\",\"" . $PRJ . "\",\"" . $DB . "\",\"false\");'>";
				$html .= "<td ".$txtstyle.">". $row["id"] .   "</td>";
                if ($DB == 'purchase'){
				    $html .= "<td ".$txtstyle.">". $row["name"] .   "</td>";
                } else{
				    $html .= "<td ".$txtstyle.">". dw3_decrypt($row["name"]) .   "</td>";
                }
				$html .= "<td ".$txtstyle.">". $row["project_id"] .   "</td>";
                if ($row["products_desc"] != $row["products_desc2"]){
				    $html .= "<td ".$txtstyle.">" . $row["products_desc"] .", ".$row["products_desc2"] .  "..</td>";
                } else {
                    $html .= "<td ".$txtstyle.">" . $row["products_desc"] .  "</td>";
                }
				$html .= "<td ".$txtstyle.">" . format_number($row["enNET"], 2, '.', ' ') .  "$</td>";
				$html .= "<td ".$txtstyle.">" . $row["date_modified"] .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table></div>";
            if ($result->num_rows > 100) {
                $html .= "<div style='text-align:center;color:red;'>Plus de 100 résultats, veuillez affiner votre recherche.</div>";
            } else {
                $html .= "<div style='text-align:center;'>Total résultat(s): " . $result->num_rows . ". Par défaut seulement les achats et les commandes de ce client apparaissent, pour afficher les autres faites une recherche.</div>";
            }
		} else {
            $html .= "<div>Aucun résultat trouvé.</div>";
        }
$dw3_conn->close();
die($html);
?>

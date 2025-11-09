<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$html = "";
	$sql = "SELECT A.*, IFNULL(B.name_fr,'Non défini') AS product_name
    FROM procedure_line A 
    LEFT JOIN (SELECT id, name_fr FROM product) B ON A.product_id = B.id
    WHERE A.procedure_id = '" . $ID . "'";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	
        $html .= "<table class='tblSEL' style='text-align:left;font-size:0.8em;'><tr><th>Produit</th><th style='width:80px;text-align:center;'>Quantité</th></tr>";	
		while($row = $result->fetch_assoc()) {
            $html .= "<tr onclick=\"getPROCEDURE_LINE('" . $row["id"] . "');\">";
            $html .= "<td>" . $row["product_name"] . "</td>";
            $html .= "<td style='text-align:center;'>" . $row["qty_by_unit"] . "</td></tr>";
        }
        $html .= "</table>";           
	} else {
        $html .= "<div style='text-align:center;font-size:0.9em;color:grey;padding:20px;'><i>Aucune ligne définie pour cette procédure.</i></div>";
    }
$dw3_conn->close();
header('Status: 200');
die($html);
?>
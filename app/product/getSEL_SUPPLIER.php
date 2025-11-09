<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SPRD  = mysqli_real_escape_string($dw3_conn, $_GET['SP']);
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$html="";
$supplier_id= "0";

if($SPRD !=""){
    $sql = "SELECT * FROM product WHERE id='".$SPRD."' LIMIT 1";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
        while($row = $result->fetch_assoc()) {
            $supplier_id = $row["supplier_id"];
        }
    }
}
			$sql = "SELECT * FROM supplier WHERE stat=0 ";
			if ($SS != "") { $sql = $sql . " AND UCASE(CONCAT(company_name,contact_name, city, tel1,eml1)) like '%" . strtoupper($SS) . "%' "; }
			$sql = $sql . "
				ORDER BY company_name ASC ;";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<div style='max-width:100%;overflow-y:auto;'>
            <table class='tblSEL'>
			<tr></tr>
				<th>ID</th>
				<th>Fournisseur</th>
				<th>Ville</th>";  
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
                $txtstyle = "";
                if ($supplier_id == $row["id"]) {
                    $txtstyle =  "style='background:green;color:white;' ";
                }
				$html .= "<tr onclick='validateSUPPLIER(\"". $row["id"] . "\",\"". $row["company_name"] .   "\");'>";
				$html .= "<td ".$txtstyle.">". $row["id"] .   "</td>";
				$html .= "<td ".$txtstyle.">". $row["company_name"] .   "</td>";
				$html .= "<td ".$txtstyle.">" . $row["city"] .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table></div>";
		}
$dw3_conn->close();
die($html);
?>

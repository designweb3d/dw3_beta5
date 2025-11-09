<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SPRD  = mysqli_real_escape_string($dw3_conn, $_GET['SP']);
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$why  = mysqli_real_escape_string($dw3_conn, $_GET['why']);
$html="";
$import = "0";
$export = "0";

if($SPRD !=""){
    $sql = "SELECT * FROM product WHERE id='".$SPRD."' LIMIT 1";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
        while($row = $result->fetch_assoc()) {
            $import = $row["import_storage_id"];
            $export = $row["export_storage_id"];
        }
    }
}
			$sql = "SELECT A.*, CONCAT(IFNULL(B.name,'Adresse'), ' (', IFNULL(A.local,''), ' ', IFNULL(A.row,'Non définie'), ' ', IFNULL(A.shelf,''), ' ', IFNULL(A.section,''), ')') AS storage_desc , B.name AS location_name
            FROM storage A
            LEFT JOIN location B ON A.location_id = B.id ";
			if ($SS != "") { $sql = $sql . " WHERE UCASE(CONCAT(local,row, shelf, section)) like '%" . strtoupper($SS) . "%' "; }
			$sql = $sql . "
				ORDER BY local ASC, row ASC,shelf ASC,section ASC
				LIMIT 100";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<div style='max-width:100%;overflow-y:auto;'>
            <div width:100%;text-align:left;line-height:1em;>
                <div style='background:orange;color:white;font-size:12px;'>Emplacement entreposage par défault</div>
                <div style='background:darkblue;color:white;font-size:12px;'>Emplacement boutique par défault</div>
                <div style='background:darkgreen;color:white;font-size:12px;'>Emplacement entreposage et boutique par défault</div>
            </div>";		
			$html .= "<table class='tblSEL'>
			<tr></tr>
				<th>ID</th>
				<th>Adresse</th>
				<th>Local</th>
				<th>Allée</th>
				<th>Étagère</th>
				<th>Section</th>";  
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
                $txtstyle = "";
                if ($import != "0" && $import == $row["id"] && $import != $export) {
                    $txtstyle =  "style='background:orange;color:white;' ";
                } else if ($export != "0" && $export == $row["id"] && $import != $export) {
                    $txtstyle =  "style='background:darkblue;color:white;' ";
                } else if ($export != "0" && $export == $row["id"] && $import == $export) {
                    $txtstyle =  "style='background:darkgreen;color:white;' ";
                }
				$html .= "<tr onclick=\"validateSTORAGE('". $row["id"] . "','" . $row["storage_desc"] . "');\">";
				$html .= "<td ".$txtstyle.">". $row["id"] .   "</td>";
				$html .= "<td ".$txtstyle.">". $row["location_name"] .   "</td>";
				$html .= "<td ".$txtstyle.">". $row["local"] .   "</td>";
				$html .= "<td ".$txtstyle.">" . $row["row"] .  "</td>";
				$html .= "<td ".$txtstyle.">" . $row["shelf"] .  "</td>";
				$html .= "<td ".$txtstyle.">" . $row["section"] .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table></div>";
            if ($result->num_rows > 100) {
                $html .= "<div style='text-align:center;color:red;'>Plus de 100 résultats, veuillez affiner votre recherche.</div>";
            }
		} else {
            $html .= "<div style='text-align:center;color:red;'>Aucun emplacement trouvé.</div>";
        }
$dw3_conn->close();
die($html);
?>

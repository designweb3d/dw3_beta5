<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
//$SUSER  = mysqli_real_escape_string($dw3_conn, $_GET['SU']);
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$why  = mysqli_real_escape_string($dw3_conn, $_GET['why']);
$RID  = $_GET['RID']??'0';
$html="";
$import = "0";
$export = "0";
$already_send = "";

if($RID !="0"){
	$sql = "SELECT head_id FROM prototype_report WHERE id = '" . $RID . "'";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $head_id = $data['head_id']??0;

    $sql = "SELECT parent_id FROM prototype_report WHERE head_id='".$head_id."';";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
        while($row = $result->fetch_assoc()) {
            $already_send .= $row["parent_id"] .",";
        }
    }
}
$already_send  = "(".substr($already_send,0,-1) . ")";
        $sql = "SELECT * FROM customer WHERE stat = 0 ";
        if ($SS != "") { $sql = $sql . " AND UCASE(CONCAT(first_name,last_name, eml1, tel1)) like '%" . strtoupper(dw3_crypt($SS)) . "%' "; }
        $sql = $sql . " AND id NOT IN ".$already_send." ORDER BY last_name ASC, first_name ASC LIMIT 100";
        //die($sql);
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<div style='max-width:100%;overflow-y:auto;'>";		
			$html .= "<table class='tblSEL'>
			<tr></tr>
				<th>Langue</th>
				<th>Nom</th>
				<th>Email</th>
				<th>Téléphone</th>
				<th>Adresse</th>";  
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
/*                 $txtstyle = "";
                if ($import != "0" && $import == $row["id"] && $import != $export) {
                    $txtstyle =  "style='background:orange;color:white;' ";
                } else if ($export != "0" && $export == $row["id"] && $import != $export) {
                    $txtstyle =  "style='background:darkblue;color:white;' ";
                } else if ($export != "0" && $export == $row["id"] && $import == $export) {
                    $txtstyle =  "style='background:darkgreen;color:white;' ";
                } */
				$html .= "<tr onclick='validateCUSTOMER(\"". $row["id"] . "\",\"" . $why . "\");'>";
				$html .= "<td style='text-align:center;'>". strtoupper($row["lang"]) .   "</td>";
				$html .= "<td>". dw3_decrypt($row["last_name"]) .   "</td>";
				$html .= "<td>" . dw3_decrypt($row["eml1"]) .  "</td>";
				$html .= "<td>" . dw3_decrypt($row["tel1"]) .  "</td>";
				$html .= "<td>" . dw3_decrypt($row["adr1"]) . " " . $row["city"]  .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table></div>";
		} else {
            $html .= "Tout les clients ont le document dans leur espace-client.";
        }
			
$dw3_conn->close();
die($html);
?>

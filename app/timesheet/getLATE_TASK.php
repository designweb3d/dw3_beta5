<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$currentUSER = $_GET['USER_ID'];
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$html="";
        $sql = "SELECT * FROM event WHERE user_id = '" . $currentUSER . "' AND event_type='TASK'  AND end_date < NOW() AND status <> '' AND status <> 'DONE' AND status <> 'N/A'";
        if ($SS != "") { $sql = $sql . " AND UCASE(CONCAT(name,description)) like '%" . strtoupper($SS) . "%' "; }
        $sql = $sql . "ORDER BY name ASC ;";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<div style='max-width:100%;overflow-y:auto;'>
            <table id='tblLATE_TASKS' class='tblSEL' style='white-space: normal;'>
			<tr></tr>
				<th>État</th>
				<th>Priorité</th>
				<th>Nom</th>
				<th>Détails</th>  
				<th>Date et heure due</th>";  
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
				$html .= "<tr onclick=\"getTASK('". $row["id"] . "');\">";
				$html .= "<td width='75'>";
                    if ($row["status"] == "TO_DO"){
                        $html .="<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:grey;color:white;border-radius:10px;width:75px;text-align:center;'>À FAIRE</span>";
                    }else if ($row["status"] == "IN_PROGRESS"){
                        $html .="<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:grey;color:turquoise;border-radius:10px;width:75px;text-align:center;'>EN COURS</span>";
                    }else if ($row["status"] == "DONE"){
                        $html .="<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:green;color:white;border-radius:10px;width:75px;text-align:center;'>TERMINÉ</span>";
                    } else {
                        $html .="<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:grey;color:white;border-radius:10px;width:75px;text-align:center;'>N/A</span>";
                    }
                $html .="</td>";
				$html .= "<td width='75'>";
                    if ($row["priority"] == "LOW"){
                        $html .= "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:gold;color:white;border-radius:10px;width:75px;text-align:center;'>BASSE</span>";
                    }else if ($row["priority"] == "MEDIUM"){
                        $html .= "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:orange;color:white;border-radius:10px;width:75px;text-align:center;'>MOYENNE</span>";
                    }else if ($row["priority"] == "HIGH"){
                        $html .= "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:red;color:white;border-radius:10px;width:75px;text-align:center;'>HAUTE</span>";
                    } else {
                        $html .= "<span style='font-family:Roboto;font-size:13px;padding:5px;background-color:grey;color:white;border-radius:10px;width:75px;text-align:center;'>N/D</span>";
                    } 
                $html .="</td>";
				$html .= "<td>". $row["name"] .   "</td>";
                if (strlen($row["description"]) <= 128){
                    $html .= "<td width='*'>" . $row["description"] .  "</td>";
                } else {
				    $html .= "<td width='*'>" . substr($row["description"],0,128) .  "..</td>";
                }
				$html .= "<td width='150'>" . $row["end_date"] .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table></div>";
		}

$dw3_conn->close();
echo $html;
exit();
?>
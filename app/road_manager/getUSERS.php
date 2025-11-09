<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$rtID  = $_GET['rtID'];

	$sql = "SELECT * FROM user 
			WHERE id NOT IN(SELECT DISTINCT user_id FROM road_user 
						WHERE road_id = '" . $rtID . "')
			ORDER BY first_name, last_name";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		echo "<form onsubmit='submitForm(event)' id='frmSEL' style='overflow:hidden;'><table class='tblSEL'>";		
		while($row = $result->fetch_assoc()) {
/* 			echo "<tr onclick='addUSER(\"" . $row["id"] . "\");' >
					<td style='width:200px;'>" . $row["first_name"] . " " . $row["last_name"] . "</td>
					<td style='width:100%;text-overflow:ellipsis;'>" . $row["eml1"] . "</td></tr>"; */
			echo "<tr><td style='15px;'>
					<input id='chkUSR" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox'></td>
					<td onclick='selCHK(\"chkUSR" . $row["id"] . "\");' style='width:200px;'>" . $row["first_name"] . " " . $row["last_name"] . "</td>
					<td onclick='selCHK(\"chkUSR" . $row["id"] . "\");' style='width:100%;text-overflow:ellipsis;'>" . $row["eml1"] . "</td></tr>";
		}
		echo "</table></form>";
		echo "<button style='background:#444444;' onclick='selALL(\"frmSEL\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
		echo "<button style='background:#444444;' onclick='selNONE(\"frmSEL\",\"checkbox\");'><span class='material-icons'>remove_done</span></button>";
		echo "<button style='background:#444444;' onclick='closeEDITOR();'>Annuler</button>";
		echo "<button onclick='addUSERS();'>Ajouter</button>";
	} else {
		echo "<table class='tblDATA'><tr><th>Utilisateurs</th></tr>";		
		echo " <tr><td>Aucun utilisateur disponible</td></tr>";
		echo "</table>";
		echo "<button onclick='closeEDITOR();'>Ok</button>";

	}

$dw3_conn->close();
?>
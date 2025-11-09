<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

		$sql = "SELECT * FROM prototype_head ORDER BY id DESC ;";			
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			echo "<div style='max-width:100%;width:100%;overflow-x:auto;'>		
			<table class='tblSEL'>
			<tr style='background:white;'>
				<th style='width:30px;text-align:center;'>#</th>
				<th style='width:40px;'>Publié</th>
				<th>Titre</th>
				<th>Destinataire</th>
				<th>Type de total</th>
				<th style='width:50px;'>Total max.</th>
			</tr>";
			while($row = $result->fetch_assoc()) {
				echo "<tr onclick=\"optQUIZ('". $row["id"] . "','".str_replace("'","’",$row["name_fr"])."','".$row["parent_table"]."');\">";
                echo "<td style='text-align:center;'><b>". $row["id"] . "</b></td>";
                if ($row["published"] == "0"){
                    echo "<td style='text-align:center;'>Non</td>";
                }else if ($row["published"] == "1"){
                    echo "<td style='text-align:center;'><b>Oui</b></td>";
                } else {
                    echo "<td>Erreur</td>";
                }
                echo "<td>". $row["name_fr"] . "</td>";
                if ($row["parent_table"] == "customer"){
                    echo "<td>Client</td>";
                }else if ($row["parent_table"] == "user"){
                    echo "<td>Employé</td>";
                } else {
                    echo "<td>Aucun</td>";
                }
                if ($row["total_type"] == "NONE"){
                    echo "<td>Aucun</td>";
                }else if ($row["total_type"] == "CASH"){
                    echo "<td>Argent</td>";
                }else if ($row["total_type"] == "POINTS"){
                    echo "<td>Points</td>";
                }else if ($row["total_type"] == "POURCENT"){
                    echo "<td>Pourcentage</td>";
                } else {
                    echo "<td>Erreur</td>";
                }
                echo "<td style='text-align:right;'>". $row["total_max"] . "</td>";
				echo "</tr>";
			}
			echo "</table></div>";

		} else {
			echo "<hr><table id='dataTABLE' class='tblSEL'>
					<tr><th>" . $APNAME . "</th><tr>
					<tr onclick='openNEW();'><td>Aucunes donn&#233;es trouv&#233;.. Pour ajouter un nouveau appuyez sur [+]</td></tr>
					</table>";
		}
$dw3_conn->close();
?>
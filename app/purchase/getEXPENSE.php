<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$html = "<h3>Dépenses</h3>
<button style='background:#555555;top:0px;left:0px;padding:4px;position:absolute;' onclick=\"newEXPENSELINE();\"><span class='material-icons'>add</span></button>
<button style='background:#555555;top:0px;right:0px;padding:4px;position:absolute;' onclick=\"this.parentElement.style.display='none';closeEDITOR();\"><span class='material-icons'>cancel</span></button>
<br>
<br>
<hr style='margin-bottom:1px;'>
<table id='dataEXPENSE' class='tblDATA'><tr><th></th><th>Description</th><th>Type</th><th>Poste</th><th>Montant</th></tr>";
        $sql = "SELECT A.*, B.name_fr AS code_name FROM expense A
        LEFT JOIN gl B ON A.gl_code = B.code
        order by A.group_name,A.kind,A.gl_code";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			while($row = $result->fetch_assoc()) {
				$html .= "<tr><td width='10%'>
                        <button style='padding:3px;background-color:red;' onclick='delEXPENSE(\"". $row["id"] . "\");'><span class='material-icons'>delete</span></button>
                        <button style='padding:3px;' onclick='modEXPENSE(\"". $row["id"] . "\");'><span class='material-icons'>save</span></button>
                    </td>";
				$html .= "<td width='*'><input type='text' id='ES_N_". $row["id"] . "' value='". $row["group_name"] . "'></td>";
				$html .= "<td><input type='text' id='ES_K_". $row["id"] . "' value='". $row["kind"] . "' style='width:80px;'></td>";
				$html .= "<td><input type='text' id='ES_C_". $row["id"] . "' value='". $row["gl_code"] . "' style='width:80px;'><br><div style='margin:-5px 0px -12px 0px;font-size:12px;'>" . $row["code_name"] .  "</div></td>";
				$html .= "<td><input type='text' id='ES_A_". $row["id"] . "' value='" . $row["amount"] .  "' style='width:80px;'></td>";
				$html .= "</tr>";
			}
		} else {
            $html .= "<tr><td>Aucune dépense trouvé</td></tr>";
            //$html .= $sql;
        }

echo $html . "</table>";
$dw3_conn->close();
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID = $_GET['ID'];
$html="";
			$sql = "SELECT A.*, B.name_fr AS code_name FROM expense A
            LEFT JOIN gl B ON A.gl_code = B.code
            order by A.group_name,A.kind,A.gl_code";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<h3>Dépenses</h3>
            <button style='background:#555555;top:0px;right:0px;padding:4px;position:absolute;' onclick=\"this.parentElement.style.display='none';\"><span class='material-icons'>cancel</span></button>
            <table id='dataEXPENSE' class='tblSEL'>";
			while($row = $result->fetch_assoc()) {
				$html .= "<tr onclick=\"addEXPENSE('".$ID."','". $row["group_name"] . "')\"><td width='*'>". $row["group_name"] . "</td>";
				$html .= "<td>". $row["kind"] . "</td>";
				$html .= "<td>". $row["gl_code"] . " " . $row["code_name"] .  "</td>";
				$html .= "<td>" . $row["amount"] .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table>";
		} else {
            $html .= "Aucune dépense trouvé";
            //$html .= $sql;
        }
			
echo $html;
$dw3_conn->close();
?>

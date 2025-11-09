<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];

echo "<div id='divEDIT_HEADER' class='dw3_form_head'>
<h2>Réponses au document #" . $ID . "</b>
 <button style='background:#555555;top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
</div>
<div style='position:absolute;top:40px;left:0px;right:0px;bottom:0px;overflow-x:hidden;overflow-y:auto;'>
<table class='tblSEL' id='dataTABLE'>
<tr style='background:white;'>
    <th onclick=\"sortTable2(0,'dataTABLE');\">ID</th>
    <th onclick=\"sortTable2(1,'dataTABLE');\">Langue</th>
    <th onclick=\"sortTable2(2'dataTABLE');\">Date & Heure complété</th>
    <th onclick=\"sortTable2(3,'dataTABLE');\">Nom</th>
    <th onclick=\"sortTable2(4,'dataTABLE');\">Courriel</th>
</tr>";

	$sql = "SELECT B.*,A.lang AS report_lang, A.id as report_id, A.parent_id as parent_id, A.date_completed as date_completed, A.report_eml as report_eml,     
            A.head_id as head_id, IFNULL(C.eml1,A.report_eml) AS customer_eml, IFNULL(D.eml1,A.report_eml) AS user_eml, IFNULL(D.last_name,'') AS user_last_name, IFNULL(D.first_name,'') AS user_first_name, IFNULL(C.last_name,'') AS customer_last_name, IFNULL(C.first_name,'') AS customer_first_name      
    FROM prototype_report A
    LEFT JOIN prototype_head B ON A.head_id = B.id
    LEFT JOIN customer C ON A.parent_id = C.id
    LEFT JOIN user D ON A.parent_id = D.id
    WHERE A.head_id = '" . $ID . "' ORDER BY date_completed DESC";
	$result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
            echo "<tr onclick=\"getREPORT('". $row["report_id"] . "');\">";
            echo "<td>". $row["report_id"] . "</td>";
            echo "<td>". strtoupper($row["report_lang"]) . "</td>";
            echo "<td>". $row["date_completed"] . "</td>";
            if ($row["parent_table"]=="customer"){
                echo "<td>". dw3_decrypt($row["customer_last_name"]) ." ".dw3_decrypt($row["customer_first_name"]) . "</td>";
                echo "<td>". dw3_decrypt($row["customer_eml"]) . "</td>";
            }else if ($row["parent_table"]=="user"){
                echo "<td>". $row["user_last_name"] .", ".$row["user_first_name"] .  "</td>";
                if ($row["parent_id"] != "0"){
                    echo "<td>". $row["user_eml"] . "</td>";
                } else {
                    echo "<td>n/a</td>";
                }
            }
            echo "</tr>";
		}
	}
    echo "</div>";
    $dw3_conn->close();
?>
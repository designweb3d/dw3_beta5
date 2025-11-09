<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$PRJ  = mysqli_real_escape_string($dw3_conn, $_GET['PRJ']);
$CLI  = mysqli_real_escape_string($dw3_conn, $_GET['CLI']);
$LOOK_FOR  = mysqli_real_escape_string($dw3_conn, $_GET['LOOK_FOR']);
$html="";

echo "<button onclick=\"addTASK('$PRJ','$CLI');\"><span class='material-icons'>add</span> Ajouter une tâche</button>";

    $sql = "SELECT A.*, CONCAT(IFNULL(B.first_name,''),'',IFNULL(B.last_name,'')) AS user_fullname, IFNULL(C.last_name,'') AS customer_name
    FROM event A
    LEFT JOIN (SELECT * FROM user) B ON B.id = A.user_id
    LEFT JOIN (SELECT * FROM customer) C ON C.id = A.customer_id
    WHERE event_type = 'TASK'
    ";
    if ($LOOK_FOR != "") { $sql = $sql . " AND UCASE(CONCAT(A.id,A.name)) like '%" . strtoupper($LOOK_FOR) . "%' "; }
    $sql = $sql . " ORDER BY A.id DESC LIMIT 100";

//error_log($sql);
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
			$html .= "<table class='tblSEL'><tr></tr>
				<th>ID</th>
                <th>Nom</th>
				<th>Project ID</th>
				<th>Utilisateur</th>
				<th>Client</th>
				<th>Date</th>";  
			$html .= "</tr>";
			while($row = $result->fetch_assoc()) {
                $txtstyle = "";
                if ($row["project_id"] == $PRJ) {
                    $txtstyle =  "style='background:darkgreen;color:white;' ";
                } else if ($row["project_id"] == "0") {
                    $txtstyle =  "style='background:darkblue;color:white;' ";
                } else {
                    $txtstyle =  "style='background:darkgrey;color:white;' ";
                }
				$html .= "<tr onclick='validateTASK(\"". $row["id"] . "\",\"" . $PRJ . "\",\"" . $CLI . "\",\"false\");'>";
				$html .= "<td ".$txtstyle.">". $row["id"] .   "</td>";
				$html .= "<td ".$txtstyle.">". $row["name"] .   "</td>";
				$html .= "<td ".$txtstyle.">". $row["project_id"] .   "</td>";
				$html .= "<td ".$txtstyle.">" . $row["user_fullname"] .  "</td>";
				$html .= "<td ".$txtstyle.">" . dw3_decrypt($row["customer_name"]) .  "</td>";
				$html .= "<td ".$txtstyle.">" . substr($row["date_start"],0,10) .  "</td>";
				$html .= "</tr>";
			}
            $html .= "</table></div>";
		}
$dw3_conn->close();
die($html);
?>

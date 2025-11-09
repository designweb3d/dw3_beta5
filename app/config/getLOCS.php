<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 

    $sql = "SELECT *
				FROM location 
				ORDER BY id";

		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {		
			echo "<table id='dataTABLE' class='tblSEL'>
			<tr><th onclick='sortTable(0)'>Nom</th><th onclick='sortTable(1)'>Ville</th><th onclick='sortTable(2)'>Adresse</th></tr>";
			while($row = $result->fetch_assoc()) {
				echo "
					 <tr onclick='getLOC(\"". $row["id"] . "\");'>"
					. "<td>". $row["name"] ."</td>"
					. "<td>". $row["city"] . "</td>"
					. "<td>". $row["adr1"] ."</td>"

					. "</tr>";
			}
			echo "</table>";
		}
	
$dw3_conn->close();
?>
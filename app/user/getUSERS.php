<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/js/Multiavatar.php';
$multiavatar = new Multiavatar();
	$sql = "SELECT A.*, B.name as location_name
		FROM user A
		LEFT JOIN location B ON A.location_id = B.id 
		ORDER BY A.stat ASC, trim(A.first_name), trim(A.last_name)";

		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {		
			echo "<table id='dataTABLE' class='tblSEL'>
			<tr><th onclick=\"sortTable2(0,'dataTABLE')\"></th><th style='width:66px;' onclick=\"sortTable2(1,'dataTABLE')\">Status</th><th onclick=\"sortTable2(2,'dataTABLE')\">". $dw3_lbl["FULLNAME"] ."</th><th onclick=\"sortTable2(3,'dataTABLE')\">". $dw3_lbl["LOC"] ."</th><th onclick=\"sortTable2(4,'dataTABLE')\">Type</th><th onclick=\"sortTable2(5,'dataTABLE')\">". $dw3_lbl["EML1"] ."</th></tr>";
			while($row = $result->fetch_assoc()) {
                $avatarsvg = $multiavatar($row["name"], null, null);
				if ($row["stat"] == '0'){ $usSTAT = 'ACTIF';$STAT_COLOR = 'darkgreen';} else { $usSTAT = 'INACTIF'; $STAT_COLOR = 'darkred';}
				echo "
					 <tr onclick='getUSER(\"". $row["id"] . "\");'>"
					. "<td style='background:" . $STAT_COLOR . ";width:40px;padding:3px 3px 1px 3px;border:1px solid #333;'>";
                    if ($row["picture_type"] == "AVATAR"){
                        $avatarsvg = $multiavatar($row["name"], null, null);
                        echo "<div style='width:40px;height:40px;display: inline-block;'>" . $avatarsvg . "</div>";
                    } else if ($row["picture_type"] == "PHOTO"){
                        echo "<img src='/fs/user/" . $row["id"] . ".png?t=".rand(1,9999999)."' style='width:auto;height:40px;border-radius:4px;display: inline-block;' />";
                    } else if ($row["picture_type"] == "PICTURE"){
                        echo "<img src='/pub/upload/" . $row["picture_url"] . "?t=".rand(1,9999999)."' style='width:auto;height:40px;border-radius:4px;display: inline-block;' />";
                    } else if ($row["picture_type"] == "PICTURE2"){
                        echo "<img src='/pub/img/avatar/" . $row["picture_url"] . "?t=".rand(1,9999999)."' style='width:auto;height:40px;border-radius:4px;display: inline-block;' />";
                    }
                    if ($row["stat"]=='1') {
                        $stat_desc = "<span style='color:white;background-color:darkred;font-weight:bold;padding:2px 4px;border-radius:10px;width:60px;text-align:center;font-size:0.7em;' title='Inactif'>INACTIF</span>";
                    } else if ($row["stat"]=='0') {
                        $stat_desc = "<span style='color:white;background-color:darkgreen;font-weight:bold;padding:2px 4px;border-radius:10px;width:60px;text-align:center;font-size:0.7em;' title='Actif'>ACTIF</span>";
                    } else {
                        $stat_desc = "<span style='color:white;background-color:darkorange;font-weight:bold;padding:2px 4px;border-radius:10px;width:60px;text-align:center;font-size:0.7em;' title='Statut inconnu'>N/D</span>";
                    }
					echo "</td><td>".$stat_desc."</td>"
					. "<td><b>". trim(strtoupper($row["first_name"]) . " " . strtoupper($row["last_name"])) . "</b></td>"
					. "<td>". $row["location_name"] . "</td>"
					. "<td>". $row["auth"] . "</td>"
					. "<td>". $row["eml1"] . "</td>"
					. "</tr>";
			}
			echo "</table>";
            	echo " <button onclick=\"ExportToPDF('dataTABLE','Users');\"><span class='material-icons'>picture_as_pdf</span></button> ";
				echo " <button onclick=\"ExportToExcel('dataTABLE','xlsx','Users');\"><span class='material-icons'>table_view</span></button> ";

		}
$dw3_conn->close();
?>
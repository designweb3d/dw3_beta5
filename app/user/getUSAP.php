<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$usID  = $_GET['usID'];

	$sql2 = "SELECT *
			FROM app_user
			JOIN app on app_user.app_id = app.id
			WHERE user_id = '" . $usID . "'
			ORDER BY CONVERT(name_fr USING utf8mb4) ASC";

	$result2 = $dw3_conn->query($sql2);
	if ($result2->num_rows > 0) {	
        if ($APREAD_ONLY == false) {	
		    echo "<table class='tblSEL'><tr><th style='font-size: 12px;'>Read<br>Only</th><th>Application</th></tr>";
        } else {
            echo "<table class='tblDATA'><tr><th style='font-size: 12px;'>Read<br>Only</th><th>Application</th></tr>";
        }
		while($row2 = $result2->fetch_assoc()) {
            if ($row2["app_id"] == "1" || $row2["app_id"] == "3" || $row2["app_id"] == "5" || $row2["app_id"] == "12" || $row2["app_id"] == "14" || $row2["app_id"] == "16" || $row2["app_id"] == "17" || $row2["app_id"] == "18" || $row2["app_id"] == "19" || $row2["app_id"] == "20" || $row2["app_id"] == "21" || $row2["app_id"] == "22" || $row2["app_id"] == "23" || $row2["app_id"] == "29" || $row2["app_id"] == "33") {
                $dsp_ro = "display:none;";
                $dsp_ro2 = "<span style='border:2px solid black;border-radius:3px;background:#fff;color:#333;font-size:12px;'>N/A</span>";
            } else {
                $dsp_ro = "";
                $dsp_ro2 = "";
            }
            if ($APREAD_ONLY == false) {
			    echo "<tr><td width='20px;'>".$dsp_ro2."<input style='".$dsp_ro."' type='checkbox' ".($row2["read_only"] == "1" ? "checked" : "")." onclick=\"changeUSAPAuth('". $row2["user_id"] . "','". $row2["app_id"] . "',this.checked)\"></td><td style='cursor: zoom-out;' onclick=\"delUSAP('". $row2["user_id"] . "','". $row2["app_id"] . "')\"><span class='material-icons'>". $row2["icon"] . "</span> <b> ". $row2["name_fr"] ."</b>". " (". $row2["auth"] . ")</td></tr>";
            } else {
                echo "<tr><td width='20px;'>".$dsp_ro2."<input style='".$dsp_ro."' disabled type='checkbox' ".($row2["read_only"] == "1" ? "checked" : "")."></td><td><span class='material-icons'>". $row2["icon"] . "</span> <b> ". $row2["name_fr"] ."</b>". " (". $row2["auth"] . ")</td></tr>";
            }
		}
		echo "</table>";
	}
?>
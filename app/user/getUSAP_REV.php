<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$usID  = $_GET['usID'];

	$sql2 = "SELECT *
			FROM app
			WHERE id NOT IN 
				(SELECT app_id from app_user where user_id = " . $usID  . ")
			ORDER BY CONVERT(name_fr USING utf8mb4) ASC";

	$result2 = $dw3_conn->query($sql2);
	if ($result2->num_rows > 0) {
		if ($APREAD_ONLY == false) {
			echo "<table class='tblSEL'>";
		} else {
			echo "<table class='tblDATA'>";
		}
		while($row2 = $result2->fetch_assoc()) {
			if ($APREAD_ONLY == false) {
				echo "<tr style='cursor: zoom-out;' onclick='addUSAP(\"". $usID . "\",\"". $row2["id"] . "\")'><td><span class='material-icons'>". $row2["icon"] . "</span> <b> ". $row2["name_fr"] ."</b>". " (". $row2["auth"] . ")</td></tr>";
			} else {
				echo "<tr><td><span class='material-icons'>". $row2["icon"] . "</span> <b> ". $row2["name_fr"] ."</b>". " (". $row2["auth"] . ")</td></tr>";
			}
		}
		echo "</table>";
	}
?>
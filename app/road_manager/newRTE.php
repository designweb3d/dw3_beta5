<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$NOM   = htmlspecialchars($_GET['NOM']);
$LOC   = $_GET['EML'];
$FJR  = $_GET['FJR'];
$FHR  = $_GET['FHR'];
$MHW  = $_GET['MHW'];
$MFR  = $_GET['MFR'];

	$sql = "INSERT INTO road_head
			(name,location_id,
			freq_day,
			freq_hour,
			highway,
			ferrie)
    VALUES 
        ('" . $NOM  . "',
         '" . $LOC  . "',
         '" . $FJR  . "',
         '" . $FHR . "',
         '" . $MHW  . "',
         '" . $MFR    . "')";
	if ($dw3_conn->query($sql) === TRUE) {
        $sql = "SELECT LAST_INSERT_ID() as ID;";
		$result = mysqli_query($dw3_conn, $sql);
		$data = mysqli_fetch_assoc($result);
        $tmp['result'][] = "ok";
        $tmp['data'][] = $data["ID"];
        die(json_encode($tmp));
	} else {
        $tmp['result'][] = "err";
        $tmp['data'][] = $dw3_conn->error;;
        die(json_encode($tmp));
	}
$dw3_conn->close();
?>
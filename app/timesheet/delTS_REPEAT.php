<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID   = $_GET['ID'];
$DEL_TYPE  = $_GET['TYPE']??'0'; //0=NA, 1=ALL, 2= THIS ONE AND FUTURE ONES

if ($DEL_TYPE == "0") {
    echo "Err_TYPE";
    $dw3_conn->close();
    exit();
}

    //get record info
    $sql = "SELECT * FROM schedule_head WHERE id = '" . $ID . "' LIMIT 1";
    $result = $dw3_conn->query($sql);  
    $data = $result->fetch_assoc();
    $parent_date = $data["start_date"];
    $parent_id = $data["parent_id"];

	$sql = "DELETE FROM schedule_head
	 WHERE parent_id = '" . $parent_id . "'";

    if ($DEL_TYPE == 2) {
        $sql .= " AND start_date >= '" . $parent_date . "'";
    }

	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
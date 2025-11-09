<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];
$DEL_NEXT  = $_GET['DEL_NEXT']??""; //'' = NA, 1=NO, 2=ALL

$sql = "SELECT * FROM event WHERE id = '" . $ID . "' LIMIT 1";
$result = $dw3_conn->query($sql);  
$data = $result->fetch_assoc();
if($data["parent_id"] != 0 && $DEL_NEXT == "" && $data["period_duration"] <> $data["period_sequence"]){
    echo "Err_PARENT";
    $dw3_conn->close();
    exit();
}

if ($DEL_NEXT == "1" || $DEL_NEXT == ""){
    $sql = "DELETE FROM event
	 WHERE id = '" . $ID ."' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $ID;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
} else if ($DEL_NEXT == "2"){
    if ($data["parent_id"] == 0){
        $sql = "DELETE FROM event
        WHERE (id = '" . $ID ."' OR parent_id = '" . $ID . "') AND period_sequence >= '" . $data["period_sequence"] . "' ";
    } else {
        $sql = "DELETE FROM event
            WHERE (id = '" . $ID ."' OR parent_id = '" . $data["parent_id"] . "') AND period_sequence >= '" . $data["period_sequence"] . "' ";
    }
} 
if ($dw3_conn->query($sql) === TRUE) {
    //echo $ID;
} else {
    echo "Erreur: " . $dw3_conn->error;
}


$dw3_conn->close();
?>
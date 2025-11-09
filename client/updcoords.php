<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$ID  = $_GET['ID'];
$LNG  = $_GET['LNG'];
$LAT  = $_GET['LAT'];
$sql = "UPDATE customer SET longitude = '" . $LNG . "', latitude = '" . $LAT . "' WHERE id = '" . $ID . "' LIMIT 1";
if ($dw3_conn->query($sql) == TRUE) {
    $sql = "SELECT * FROM customer WHERE id = '" . $ID . "' LIMIT 1";;
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    if ($data["retailer_loc_id"] != "0"){
        $sqlx = "UPDATE location SET longitude = '" . $LNG . "', latitude = '" . $LAT . "' WHERE id = '" . $data["retailer_loc_id"] . "' LIMIT 1";
        $resultx = mysqli_query($dw3_conn, $sqlx);
    }
    echo "";
} else {
    echo $dw3_conn->error;
}
$dw3_conn->close();
?>
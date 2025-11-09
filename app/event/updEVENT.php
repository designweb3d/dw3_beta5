<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$NAME   = str_replace("'","’", $_GET['NAME']);
$NAME_EN   = str_replace("'","’", $_GET['NAME_EN']);
$LOC   = $_GET['LOC'];
$USER   = $_GET['USER'];
$TYPE  = $_GET['TYPE'];
$PRIORITY  = $_GET['PRIORITY'];
$STATUS  = $_GET['STATUS'];
$CLI  = $_GET['CLI'];
$PRJ  = $_GET['PRJ'];
$START  = $_GET['START'];
$END  = $_GET['END'];
$DURATION  = $_GET['DURATION'];
$DESC  = str_replace("'","’", $_GET['DESC']);
$DESC_EN  = str_replace("'","’", $_GET['DESC_EN']);
$HREF  = $_GET['HREF'];
$IMG  = $_GET['IMG'];

$UPD_NEXT  = $_GET['UPD_NEXT']??""; //'' = NA, 1=NO, 2=ALL

$sql = "SELECT * FROM event WHERE id = '" . $ID . "' LIMIT 1";
$result = $dw3_conn->query($sql);  
$data = $result->fetch_assoc();

if($data["periodic"] != 0 && $UPD_NEXT == "" && $data["period_duration"] <> $data["period_sequence"]){
    echo "Err_PARENT";
    $dw3_conn->close();
    exit();
}

//update event
		$sql = "UPDATE event SET    
		name   = '" . $NAME   . "',
		name_en   = '" . $NAME_EN   . "',
		event_type   = '" . $TYPE   . "',
		priority   = '" . $PRIORITY   . "',
		status   = '" . $STATUS   . "',
		location_id   = '" . $LOC   . "',
		project_id   = '" . $PRJ . "',
		user_id   = '" . $USER   . "',
		date_start  = '" . $START    . "',
		end_date    = '" . $END    . "',
		customer_id    = '" . $CLI . "',
		location_id    = '" . $LOC . "',
		description   = '" . $DESC   . "',
		description_en   = '" . $DESC_EN   . "',
		href   = '" . $HREF   . "',
		img_src   = '" . $IMG   . "'";
         $sql .= " WHERE id = '" . $ID . "' LIMIT 1";
//update all following events without modifying dates
    if ($UPD_NEXT == "2"){
		$sql = "UPDATE event SET    
		name   = '" . $NAME   . "',
		name_en   = '" . $NAME_EN   . "',
		event_type   = '" . $TYPE   . "',
		priority   = '" . $PRIORITY   . "',
		status   = '" . $STATUS   . "',
		location_id   = '" . $LOC   . "',
		project_id   = '" . $PRJ . "',
		user_id   = '" . $USER   . "',
		customer_id    = '" . $CLI . "',
		location_id    = '" . $LOC . "',
		description   = '" . $DESC   . "',
		description_en   = '" . $DESC_EN   . "',
		href   = '" . $HREF   . "',
		img_src   = '" . $IMG   . "'";
		if ($data["parent_id"] == 0){
        	$sql .= " WHERE parent_id = '" . $ID . "' AND period_sequence >= '" . $data["period_sequence"] . "' ";
		} else {
			$sql .= " WHERE parent_id = '" . $data["parent_id"] . "' AND period_sequence >= '" . $data["period_sequence"] . "' ";
		}
     }

	if ($dw3_conn->query($sql) === TRUE) {
	  echo $sql;
	} else {
	  echo $dw3_conn->error;
	}

$dw3_conn->close();
?>
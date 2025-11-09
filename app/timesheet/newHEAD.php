<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$currentUSER = $_GET['USER_ID'];
$START_DATE   = mysqli_real_escape_string($dw3_conn,$_GET['START']);
$END_DATE   = mysqli_real_escape_string($dw3_conn,$_GET['END']);
$BLOCK_SIZE   = $_GET['BLOCK'];
$LOC   = $_GET['LOC'];
$PUB   = $_GET['P'];
$TYPE_V   = $_GET['V'];
$TYPE_R   = $_GET['R'];
$TYPE_L   = $_GET['L'];
$TYPE_P   = $_GET['U'];

//Verifs
	$sql = "SELECT COUNT(*) as counter FROM schedule_head
			WHERE user_id = '" . $currentUSER . "' AND start_date <= '" . $START_DATE . "' AND end_date >= '" . $END_DATE . "' 
			   OR user_id = '" . $currentUSER . "' AND start_date >= '" . $START_DATE . "' AND start_date <= '" . $END_DATE . "'  
			   OR user_id = '" . $currentUSER . "' AND end_date >= '" . $START_DATE . "' AND end_date <= '" . $END_DATE . "' ;";
			$result = mysqli_query($dw3_conn, $sql);
			$data = mysqli_fetch_assoc($result);
			if ($data['counter'] > 0){
				$dw3_conn->close();
				die ("Erreur: Il y a déjà un horaire prévu dans cette période de temps pour cet utilisateur.".$sql);
			}

//insert
	$sql = "INSERT INTO schedule_head
    (user_id,location_id,start_date,end_date,block_size,is_public,virtual_enable,road_enable,local_enable,phone_enable,created)
    VALUES 
        ('" . $currentUSER   . "',
         '" . $LOC  . "',
         '" . $START_DATE  . "',
         '" . $END_DATE  . "',
         '" . $BLOCK_SIZE  . "',
         '" . $PUB  . "',
         '" . $TYPE_V  . "',
         '" . $TYPE_R  . "',
         '" . $TYPE_L  . "',
         '" . $TYPE_P  . "',
         '" . $today  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
      $inserted_id = $dw3_conn->insert_id;
      $dw3_conn->close();
	  die($inserted_id);
	} else {
        $dw3_conn->close();
	  die("Erreur: " . $dw3_conn->error);
	}

?>
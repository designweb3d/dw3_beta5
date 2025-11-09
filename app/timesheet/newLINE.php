<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$currentUSER = $_GET['USER_ID'];
$START_DATE   = mysqli_real_escape_string($dw3_conn,$_GET['START']);
$END_DATE   = mysqli_real_escape_string($dw3_conn,$_GET['END']);
$CL   = $_GET['C'];
$PRD   = $_GET['P'];
$LOC_TYPE   = $_GET['L'];

$year = substr($START_DATE,0,4);
$month = substr($START_DATE,5,2);
$day = substr($START_DATE,8,2);
$start_time = substr($START_DATE,11,5);
$end_time = substr($END_DATE,11,5);

//get user info
$sql = "SELECT * FROM user WHERE id = '" . $currentUSER . "'  ;";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

//find schedule head
$sql = "SELECT * FROM schedule_head
			WHERE user_id = '" . $currentUSER . "' AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "'  AND DAY(start_date) = '" . $day . "' 
            AND SUBSTR(start_date,12,5) >= '" . $start_time . "'
            AND SUBSTR(start_date,12,5) < '" . $end_time . "' LIMIT 1;";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
        while($row = $result->fetch_assoc()) {
            $location_id = $row['location_id'];
        }
    } else {
        $location_id = $data['location_id'];
    }

//insert
	$sql = "INSERT INTO schedule_line
    (user_id,start_date,end_date,product_id,location_type,location_id,confirmed,state,customer_id)
    VALUES 
        ('" . $currentUSER   . "',
         '" . $START_DATE  . "',
         '" . $END_DATE  . "',
         '" . $PRD  . "',
         '" . $LOC_TYPE  . "',
         '" . $location_id  . "',
         '1',
         '" . $data['name'] . "',
         '" . $CL  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
      $inserted_id = $dw3_conn->insert_id;
      //$dw3_conn->close();
	  //die("");
	} else {
        $dw3_conn->close();
	  die("Erreur: " . $dw3_conn->error);
	}

?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$UID   = $_GET['UID'];
$Y = $_GET['Y'];
$M = $_GET['M'];
$D = $_GET['D'];
$task_date = $Y . '-' . $M . '-' . $D;
//insert
	$sql = "INSERT INTO event
    (name,event_type,priority,date_start,end_date,user_id,status)
    VALUES 
        ('Nouvelle tâche',
         'TASK',
         'MEDIUM',
         '" . $task_date . " 08:00:00',
         '" . $task_date . " 17:00:00',
         '" . $UID  . "',
         'TO_DO')";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
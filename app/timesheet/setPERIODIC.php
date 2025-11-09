<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$TYPE   = $_GET['TYPE'];
$DURATION   = $_GET['DURATION'];

$sql = "UPDATE event SET    
     periodic = 1,
     period_type = '" . $TYPE   . "',
     period_duration   = '" . $DURATION+1   . "',
     period_sequence = 1
     WHERE id = '" . $ID . "' 
     LIMIT 1";
$result = $dw3_conn->query($sql); 
if ($dw3_conn->query($sql) === TRUE) {
  //echo "";
} else {
  echo $dw3_conn->error;
}


$sql = "SELECT * FROM event WHERE id = '" . $ID . "' LIMIT 1";
$result = $dw3_conn->query($sql);  
$data = $result->fetch_assoc();
$next_date_start = $data["date_start"];
$next_date_end = $data["end_date"];

     for ($i=1; $i<=$DURATION; $i++) {
        if($TYPE == "WEEKLY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +7 day'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +7 day'));
        }
        if($TYPE == "BI-WEEKLY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +15 day'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +15 day'));
        }
        if($TYPE == "MONTHLY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 month'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 month'));
        }
        if($TYPE == "MONTHLY3"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +3 month'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +3 month'));
        }
        if($TYPE == "MONTHLY6"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +6 month'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +6 month'));
        }
        if($TYPE == "YEARLY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 year'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 year'));
        }
        if($TYPE == "DAILY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 day'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 day'));
        }
            $sql = "INSERT INTO event (parent_id, project_id, user_id,location_id,event_type,priority,
                    status,customer_id,name,name_en,date_start,end_date,duration,description,description_en,href,img_src,
                    periodic,period_type,period_duration,period_sequence) VALUES (
            '" . $ID . "',
            '" . $data["project_id"]   . "',
            '" . $data["user_id"]   . "',
            '" . $data["location_id"]   . "',
            '" . $data["event_type"]   . "',
            '" . $data["priority"]   . "',
            '" . "TO_DO" . "',
            '" . $data["customer_id"]   . "',
            '" . $data["name"]   . "',
            '" . $data["name_en"]   . "',
            '" . $next_date_start  . "',
            '" . $next_date_end  . "',
            '" . $data["duration"]   . "',
            '" . $data["description"]   . "',
            '" . $data["description_en"]   . "',
            '" . $data["href"]   . "',
            '" . $data["img_src"]   . "',
            '1',
            '" . $data["period_type"]   . "',
            '" . $data["period_duration"]   . "',
            '" . $i+1   . "'
            )";
            if ($dw3_conn->query($sql) === TRUE) {
            //echo "";
            } else {
            echo $dw3_conn->error;
            }
    }
$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$currentUSER   = $_GET['UID'];
$TYPE   = $_GET['TYPE'];
$YEAR_END   = $_GET['YEAR_END'];
$DURATION   = $_GET['DURATION'];

if ($YEAR_END == 1) {
    $DURATION = 365;
}

$valid_schedule = true;

$sql = "SELECT * FROM schedule_head WHERE id = '" . $ID . "' LIMIT 1";
$result = $dw3_conn->query($sql);  
$data = $result->fetch_assoc();
$next_date_start = $data["start_date"];
$next_date_end = $data["end_date"];

//Verifier si la plage horaire ne chevauche pas une autre
     for ($i=1; $i<=$DURATION; $i++) {
        if($TYPE == "DAILY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 day'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 day'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        if($TYPE == "WEEKDAYS"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 day'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 day'));
            $next_weekday = date('N', strtotime($next_date_start));
            if ($next_weekday == 6) {
                $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +2 day'));
                $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +2 day'));
            } else if ($next_weekday == 0) {
                $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 day'));
                $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 day'));
            }
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        } 
        if($TYPE == "WEEKLY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +7 day'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +7 day'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        if($TYPE == "BI-WEEKLY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +15 day'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +15 day'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        if($TYPE == "MONTHLY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 month'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 month'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        if($TYPE == "MONTHLY3"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +3 month'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +3 month'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        if($TYPE == "MONTHLY6"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +6 month'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +6 month'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        if($TYPE == "YEARLY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 year'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 year'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        $sql2 = "SELECT COUNT(*) as count_conflict FROM schedule_head WHERE (
            (start_date <= '" . $next_date_start . "' AND end_date > '" . $next_date_start . "')
            OR
            (start_date < '" . $next_date_end . "' AND end_date >= '" . $next_date_end . "')
            OR
            (start_date >= '" . $next_date_start . "' AND end_date <= '" . $next_date_end . "')
            ) AND id <> '" . $ID . "'  AND user_id = '" . $currentUSER . "' LIMIT 1";
        $result2 = $dw3_conn->query($sql2);  
        $data2 = $result2->fetch_assoc();
        if ($data2["count_conflict"] > 0) {
            $valid_schedule = false;
            $conflicting_schedule = date('d/m/Y H:i', strtotime($next_date_start)) . " - " . date('d/m/Y H:i', strtotime($next_date_end));
            break;
        }
    }

if ($valid_schedule == false) {
    echo "Le créneau horaire chevauche une autre plage horaire (" . $conflicting_schedule . "). Le processus est annulé.";
    $dw3_conn->close();
    exit;
}

$next_date_start = $data["start_date"];
$next_date_end = $data["end_date"];
for ($i=1; $i<=$DURATION; $i++) {
        if($TYPE == "DAILY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 day'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 day'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        if($TYPE == "WEEKDAYS"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 day'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 day'));
            $next_weekday = date('N', strtotime($next_date_start));
            if ($next_weekday == 6) {
                $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +2 day'));
                $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +2 day'));
            } else if ($next_weekday == 0) {
                $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 day'));
                $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 day'));
            }
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        } 
        if($TYPE == "WEEKLY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +7 day'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +7 day'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        if($TYPE == "BI-WEEKLY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +15 day'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +15 day'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        if($TYPE == "MONTHLY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 month'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 month'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        if($TYPE == "MONTHLY3"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +3 month'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +3 month'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        if($TYPE == "MONTHLY6"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +6 month'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +6 month'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }
        if($TYPE == "YEARLY"){
            $next_date_start = date('Y-m-d H:i:s', strtotime($next_date_start . ' +1 year'));
            $next_date_end = date('Y-m-d H:i:s', strtotime($next_date_end . ' +1 year'));
            if ($YEAR_END == 1 && date('Y') < date('Y',strtotime($next_date_start))) {
                break;
            }
        }

            $sql = "INSERT INTO schedule_head (parent_id,user_id,start_date,end_date,block_size,description,
            is_public,virtual_enable,road_enable,local_enable,phone_enable,location_id,local_id,created) VALUES (
            '" . $ID . "',
            '" . $data["user_id"]   . "',
            '" . $next_date_start  . "',
            '" . $next_date_end  . "',
            '" . $data["block_size"]   . "',
            '" . $data["description"]   . "',
            '" . $data["is_public"]   . "',
            '" . $data["virtual_enable"]   . "',
            '" . $data["road_enable"]   . "',
            '" . $data["local_enable"]   . "',
            '" . $data["phone_enable"]   . "',
            '" . $data["location_id"]   . "',
            '" . $data["local_id"]   . "',
            '" . $datetime  . "'
            )";
            if ($dw3_conn->query($sql) === TRUE) {
            //echo "";
            } else {
            echo $dw3_conn->error;
            }
    }
//set parent_id for the original event
$sql = "UPDATE schedule_head SET parent_id = '" . $ID . "' WHERE id = '" . $ID. "' LIMIT 1";
$dw3_conn->query($sql);

$dw3_conn->close();
?>
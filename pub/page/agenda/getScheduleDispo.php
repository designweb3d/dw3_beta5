<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';

$USER_LANG  = "FR";
if(isset($_COOKIE["LANG"])) { 
    if ($_COOKIE["LANG"] != "") {
        $USER_LANG = $_COOKIE["LANG"];
    }
}

$suser_id  = mysqli_real_escape_string($dw3_conn,$_GET['U']);
$product_id  = mysqli_real_escape_string($dw3_conn,$_GET['P']);
$service_location  = mysqli_real_escape_string($dw3_conn,$_GET['L']);
$day  = mysqli_real_escape_string($dw3_conn,$_GET['D']);
$year  = mysqli_real_escape_string($dw3_conn, $_GET['Y']);
$month  = mysqli_real_escape_string($dw3_conn, $_GET['M']);
$html = "";
$time_req = "60"; //default service length
$location_sql = "";
if($service_location == "V"){$location_sql = " AND virtual_enable = 1 ";}
if($service_location == "R"){$location_sql = " AND road_enable = 1 ";}
if($service_location == "L"){$location_sql = " AND local_enable = 1 ";}
if($service_location == "P"){$location_sql = " AND phone_enable = 1 ";}

//get product info
$sql2 = "SELECT *
            FROM product
			WHERE  id = '" . $product_id . "' LIMIT 1";
				$result2 = $dw3_conn->query($sql2);
				if ($result2->num_rows > 0) {	
					while($row2 = $result2->fetch_assoc()) {
                        $time_req = floor($row2["service_length"]+$row2["inter_length"]);
					}
                }
//get all lines time in array
$rdv_start = array();
$rdv_end = array();
$sql2 = "SELECT *
            FROM schedule_line
			WHERE  YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "'  AND DAY(start_date) = '" . $day . "'  AND user_id = '".$suser_id."'
                OR   YEAR(end_date) = '" . $year . "' AND MONTH(end_date) = '" . $month . "'  AND DAY(end_date) = '" . $day . "'  AND user_id = '".$suser_id."'
			ORDER BY start_date";
				$result2 = $dw3_conn->query($sql2);
                
				if ($result2->num_rows > 0) {	
					while($row2 = $result2->fetch_assoc()) {
                            array_push($rdv_start,$row2["start_date"]);
                            array_push($rdv_end,$row2["end_date"]);
					}
                }

//die ($sql2);
//verif dispo
$sql = "SELECT *
            FROM schedule_head
			WHERE   YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "'  AND DAY(start_date) = '" . $day . "'  and user_id = '".$suser_id."'  ".$location_sql."
                OR  YEAR(end_date) = '" . $year . "' AND MONTH(end_date) = '" . $month . "'  AND DAY(end_date) = '" . $day . "'  and user_id = '".$suser_id."'  ".$location_sql."
			ORDER  BY start_date";
            $result = $dw3_conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $from_time = strtotime($row["start_date"]); 
                    $to_time = strtotime($row["end_date"]); 
                    $diff = round(abs($from_time - $to_time) / 60);                         
                    $total_block = floor($diff/$row["block_size"]); 
                    for ($x = 0; $x <= $total_block; $x++) {
                        $valid_block = true;
                        $i = 0;
                        $block_from = strtotime($row["start_date"]) + floor($row["block_size"]*$x*60); 
                        $block_to = strtotime($row["start_date"]) + ($time_req*60) + floor($row["block_size"]*$x*60); 
                        while($i < count($rdv_start))
                        {
                            $rdv_from = strtotime($rdv_start[$i]); 
                            $rdv_to = strtotime($rdv_end[$i]);
                            //die("block_from:".$block_from."==rdv_from".$rdv_from);
                            if($block_from == $rdv_from || $block_from <= $rdv_from && $block_to >= $rdv_to || $block_from <= $rdv_from && $block_to > $rdv_to || $block_from > $rdv_from && $block_from < $rdv_to|| $block_to > $rdv_from && $block_to <= $rdv_to){
                                $valid_block = false;
                                //$html .= "block:".$block_to . " rdv_from:" . $$rdv_from ;
                            }
                            $i++;
                        }
                        $i = 0;
                        if($block_to > $to_time || $block_from < (strtotime($datetime)+3600)){
                            $valid_block = false;
                            //$html .= "block:".$block_to . " rdv_from:" . $$rdv_from ;
                        }
                        if ($valid_block == true){
                            //$html .= "block_from:". ($rdv_to - $block_from) ;
                            $html .= "<div onclick=\"document.getElementById('sel_" . $x . "_" . $i . "').checked = true;document.getElementById('divHEURE_OUTPUT').innerHTML = '<h1>". date("H:i",$block_from) ."</h1>';openRDV('3','2');\" style='display:inline-block;border-bottom-right-radius:30px;border-top-left-radius:30px;background:rgba(0,0,0,0.07);padding:5px;width:130px;margin:5px;'><input type='radio' name='selBLOCK' id='sel_" . $x . "_" . $i . "' value='" . date("H:i",$block_from) ."' style='cursor:pointer;'> <label for='sel_" . $x . "_" . $i . "' style='cursor:pointer;'> " . date("H:i",$block_from) ."</label></div>";
                        }
                      }                
                }
                if ($html == ""){
                    if ($USER_LANG == "FR"){
                        $html .= "<div style='display:inline-block;width:auto;text-align:center;font-weight:bold;background-image: linear-gradient(180deg, rgba(255,255,255,0), rgba(155,200,255,0.3),rgba(255,255,255,0));padding:10px;font-size:23px;'>Aucune disponibilité.</div>";
                    }else{
                        $html .= "<div style='display:inline-block;width:auto;text-align:center;font-weight:bold;background-image: linear-gradient(180deg, rgba(255,255,255,0), rgba(155,200,255,0.3),rgba(255,255,255,0));padding:10px;font-size:23px;'>No availability.</div>";
                    }
                    //$html .= $sql;
                }
                
            }else{
                if ($USER_LANG == "FR"){
                    $html .= "<div style='display:inline-block;width:auto;text-align:center;font-weight:bold;background-image: linear-gradient(180deg, rgba(255,255,255,0), rgba(155,200,255,0.3),rgba(255,255,255,0));padding:10px;font-size:23px;'>Aucune disponibilité.</div>";
                }else{
                    $html .= "<div style='display:inline-block;width:auto;text-align:center;font-weight:bold;background-image: linear-gradient(180deg, rgba(255,255,255,0), rgba(155,200,255,0.3),rgba(255,255,255,0));padding:10px;font-size:23px;'>No availability.</div>";
                }
                //$html .= $sql;
            }
//$html .= "</table>";
$dw3_conn->close();
die($html);
?>
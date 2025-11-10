
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';

$product_id  = mysqli_real_escape_string($dw3_conn,$_GET['P']);
$service_user_id  = mysqli_real_escape_string($dw3_conn,$_GET['U']);
$service_location  = mysqli_real_escape_string($dw3_conn,$_GET['L']);
$datetime = date("Y-m-d H:i:s");
$year = date("Y");
$month = date("m");
$day = date("d");
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
                        $time_req = $row2["service_length"];
					}
                }

//get all lines time in array
$rdv_start = array();
$rdv_end = array();
$sql2 = "SELECT *
            FROM schedule_line
			WHERE  YEAR(end_date) >= '" . $year . "' AND MONTH(end_date) >= '" . $month . "'  AND DAY(end_date) >= '" . $day . "'  AND head_id IN (SELECT id from schedule_head WHERE user_id = '".$service_user_id."' ".$location_sql.")
			OR YEAR(end_date) >= '" . $year . "' AND MONTH(end_date) > '" . $month . "'  AND head_id IN (SELECT id from schedule_head WHERE user_id = '".$service_user_id."' ".$location_sql.")
			OR YEAR(end_date) > '" . $year . "'  AND head_id IN (SELECT id from schedule_head WHERE user_id = '".$service_user_id."' ".$location_sql.")
            
			ORDER BY start_date";
				$result2 = $dw3_conn->query($sql2);
                
				if ($result2->num_rows > 0) {	
					while($row2 = $result2->fetch_assoc()) {
                            array_push($rdv_start,$row2["start_date"]);
                            array_push($rdv_end,$row2["end_date"]);
					}
                }


//verif dispo
$sql = "SELECT * FROM schedule_head
			WHERE  YEAR(end_date) >= '" . $year . "' AND MONTH(end_date) >= '" . $month . "'  AND DAY(end_date) >= '" . $day . "' AND is_public = 1 AND user_id = '".$service_user_id."'  ".$location_sql."
			    OR YEAR(end_date) = '" . $year . "' AND MONTH(end_date) > '" . $month . "' AND is_public = 1 AND user_id = '".$service_user_id."'  ".$location_sql."
			    OR YEAR(end_date) > '" . $year . "' AND is_public = 1 AND user_id = '".$service_user_id."'  ".$location_sql."
			ORDER  BY start_date";
            $result = $dw3_conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    //$start_date = new DateTime($row["start_date"]);
                    //$end_date = new DateTime($row["end_date"]);
                    $from_time = strtotime($row["start_date"]); 
                    $to_time = strtotime($row["end_date"]); 
                    $diff = round(abs($from_time - $to_time) / 60);                         
                    $total_block = floor($diff/$row["block_size"]); 
                // user_id = '" . $USER . "' AND start_date <= '" . $START_DATE . "' AND end_date >= '" . $END_DATE . "' 
			   // user_id = '" . $USER . "' AND start_date >= '" . $START_DATE . "' AND start_date <= '" . $END_DATE . "'  
			   // user_id = '" . $USER . "' AND end_date >= '" . $START_DATE . "' AND end_date <= '" . $END_DATE . "' ;";

                    for ($x = 0; $x <= $total_block; $x++) {
                        $valid_block = true;
                        $i = 0;
                        $block_from = strtotime($row["start_date"]) + floor($row["block_size"]*$x*60); 
                        $block_to = strtotime($row["start_date"]) + ($time_req*60) + floor($row["block_size"]*$x*60); 
                        while($i < count($rdv_start))
                        {
                            $rdv_from = strtotime($rdv_start[$i]); 
                            $rdv_to = strtotime($rdv_end[$i]);
                            
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
                            $html = date("Y-m-d H:i:s",$block_from);
                            $dw3_conn->close();
                            die(trim($html));
                        }
                      }                
                }
                if ($html == ""){
                    //$html .= "<div style='display:inline-block;width:auto;text-align:center;font-weight:bold;background-image: linear-gradient(180deg, rgba(255,255,255,0), rgba(155,200,255,0.3),rgba(255,255,255,0));padding:10px;font-size:23px;'>Aucune disponibilité.</div>";
                }
                
            }else{
                $html = "";
            }
//$html .= "</table>";
$dw3_conn->close();
die(trim($html));
?> 
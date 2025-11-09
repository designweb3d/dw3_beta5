
<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$currentUSER = $_GET['USER_ID'];
$product_id  = mysqli_real_escape_string($dw3_conn,$_GET['P']);
$service_location  = mysqli_real_escape_string($dw3_conn,$_GET['L']);
$day  = mysqli_real_escape_string($dw3_conn,$_GET['D']);
$year  = mysqli_real_escape_string($dw3_conn, $_GET['Y']);
$month  = mysqli_real_escape_string($dw3_conn, $_GET['M']??0);
$month = str_pad($month +1, 2, '0', STR_PAD_LEFT);
$html = "";
$time_req = "60"; //default service length
$location_sql = "";
if($service_location == "V"){$location_sql = " AND virtual_enable = 1 ";}
if($service_location == "R"){$location_sql = " AND road_enable = 1 ";}
if($service_location == "L"){$location_sql = " AND local_enable = 1 ";}

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
			WHERE user_id = '" . $currentUSER . "' AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "'  AND DAY(start_date) = '" . $day . "' 
                OR user_id = '" . $currentUSER . "' AND YEAR(end_date) = '" . $year . "' AND MONTH(end_date) = '" . $month . "'  AND DAY(end_date) = '" . $day . "' 
			ORDER  BY start_date";
				$result2 = $dw3_conn->query($sql2);
                
				if ($result2->num_rows > 0) {	
					while($row2 = $result2->fetch_assoc()) {
                            array_push($rdv_start,$row2["start_date"]);
                            array_push($rdv_end,$row2["end_date"]);
					}
                }


//verif dispo
$sql = "SELECT *
            FROM schedule_head
			WHERE user_id = '" . $currentUSER . "' AND YEAR(start_date) = '" . $year . "' AND MONTH(start_date) = '" . $month . "'  AND DAY(start_date) = '" . $day . "' 
                OR user_id = '" . $currentUSER . "' AND YEAR(end_date) = '" . $year . "' AND MONTH(end_date) = '" . $month . "'  AND DAY(end_date) = '" . $day . "' 
			ORDER  BY start_date";
            $result = $dw3_conn->query($sql);
            if ($result->num_rows > 0) {
                $html .= "<div style='width:95%;text-align:left;'>Disponibilités:</div>";
                while($row = $result->fetch_assoc()) {
                    //$start_date = new DateTime($row["start_date"]);
                    //$end_date = new DateTime($row["end_date"]);
                    $from_time = strtotime($row["start_date"]); 
                    $to_time = strtotime($row["end_date"]); 
                    $diff = round(abs($from_time - $to_time) / 60);                         
                    $total_block = floor($diff/$row["block_size"]); 

                // user_id = '" . $currentUSER . "' AND start_date <= '" . $START_DATE . "' AND end_date >= '" . $END_DATE . "' 
			   // user_id = '" . $currentUSER . "' AND start_date >= '" . $START_DATE . "' AND start_date <= '" . $END_DATE . "'  
			   // user_id = '" . $currentUSER . "' AND end_date >= '" . $START_DATE . "' AND end_date <= '" . $END_DATE . "' ;";

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
                        if($block_to > $to_time){
                            $valid_block = false;
                            //$html .= "block:".$block_to . " rdv_from:" . $$rdv_from ;
                        }
                        if ($valid_block == true){
                            //$html .= "block_from:". ($rdv_to - $block_from) ;
                            $html .= "<div style='display:inline-block;border-bottom-right-radius:30px;border-top-left-radius:30px;background:rgba(0,0,0,0.07);padding:5px;width:130px;margin:5px;'><input type='radio' name='selBLOCK' id='sel_" . $x . "_" . $i . "' value='" . date("H:i",$block_from) ."' style='cursor:pointer;'> <label for='sel_" . $x . "_" . $i . "' style='cursor:pointer;'> " . date("H:i",$block_from) ."</label></div>";
                        }
                      }                
                }
                
            }else{
                $html .= "<div style='width:95%;text-align:left;'>Aucune disponibilité.</div>".$sql;
            }
//$html .= "</table>";
$dw3_conn->close();
die($html);
?>
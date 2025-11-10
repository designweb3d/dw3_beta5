<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$ID = $_GET['ID'];

$LINES = "";
$lastLineID ="";
$lastKEY ="";
$val1 = "";
$val2 = "";
$val3 = "";
$val4 = "";
$val5 = "";
$val6 = "";
$val7 = "";
$val8 = "";
$val9 = "";
$val0 = "";
$xLoop=0;
$is_customer = false;
$customer_id = 0;
$total_value = 0;
$total2_value = 0;
$total_multiplier = 0;

    //get prototype header
    /* $sql = "SELECT * FROM prototype_head WHERE id = '" . $ID . "' LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result); */

/*     if ($head_parent_table == "customer"){
        $sql = "SELECT id FROM customer WHERE eml1 = '" . dw3_crypt(trim(strtolower($EML))) . "' AND eml1 <> '' LIMIT 1";
        $result = mysqli_query($dw3_conn, $sql);
            if ($result->num_rows > 0) {
                $is_customer = true;
                $data = mysqli_fetch_assoc($result);
                $customer_id = $data["id"];

            }
    }  */

    //compile data 
    foreach ($_GET as $key => $value) {
        if ($key != "ID" && $key != "EML" && $key != "CPTCH" && $key != "RID"){
            $lineID = substr($key,2);
            $lineValID = substr($key,0,1);

                $val1 = "";
                $val2 = "";
                $val3 = "";
                $val4 = "";
                $val5 = "";
                $val6 = "";
                $val7 = "";
                $val8 = "";
                $val9 = "";
                $val0 = "";

            if($lineValID == "1"){$val1 = $value;}
            if($lineValID == "2"){$val2 = $value;}
            if($lineValID == "3"){$val3 = $value;}
            if($lineValID == "4"){$val4 = $value;}
            if($lineValID == "5"){$val5 = $value;}
            if($lineValID == "6"){$val6 = $value;}
            if($lineValID == "7"){$val7 = $value;}
            if($lineValID == "8"){$val8 = $value;}
            if($lineValID == "9"){$val9 = $value;}
            if($lineValID == "0"){$val0 = $value;}

                $sql = "SELECT A.*, IFNULL(COUNT(B.multiplied),0) AS is_multed FROM prototype_line A
                LEFT JOIN (SELECT id, multiplied FROM prototype_line) B ON A.id = B.multiplied
                WHERE A.id = '" . $lineID . "' LIMIT 1";
                
                $result = mysqli_query($dw3_conn, $sql);
                if ($result->num_rows > 0) {
                    $data = mysqli_fetch_assoc($result);
                    if ($data["response_type"] == "TEXT"){
                        if($data["multiplier"] =="1"){
                            if ($data["multiplied"] =="0"){
                                $total_multiplier += (float)$val1;
                            } else {
                                foreach ($_GET as $key2 => $value2) {
                                    if ($data["multiplied"] == substr($key2,2)){
                                        $sqlm = "SELECT * FROM prototype_line WHERE id='".substr($key2,2)."' LIMIT 1;";
                                        $resultm = mysqli_query($dw3_conn, $sqlm);
                                        $datam = mysqli_fetch_assoc($resultm);
                                        if ($resultm->num_rows > 0) {
                                            if ($datam["response_type"] == "TEXT"){
                                                    $total_value+=(float)$datam["choice_value1"]*(float)$val1;
                                            } else if ($datam["response_type"] == "CHOICE"){
                                                //echo "choice_name1:".$datam["choice_name1"]. " value2:" .$value2;
                                                if ($datam["choice_name1"] == $value2){
                                                    $total_value+=((float)$datam["choice_value1"]*(float)$val1);
                                                    //echo "cval1:".$datam["choice_value1"]." val1:".$val1;
                                                    //echo "tval:".$total_value;
                                                } else if ($datam["choice_name2"] == $value2){
                                                    $total_value+=((float)$datam["choice_value2"]*(float)$val1);
                                                } else if ($datam["choice_name3"] == $value2){
                                                    $total_value+=((float)$datam["choice_value3"]*(float)$val1);
                                                } else if ($datam["choice_name4"] == $value2){
                                                    $total_value+=((float)$datam["choice_value4"]*(float)$val1);
                                                } else if ($datam["choice_name5"] == $value2){
                                                    $total_value+=((float)$datam["choice_value5"]*(float)$val1);
                                                } else if ($datam["choice_name6"] == $value2){
                                                    $total_value+=((float)$datam["choice_value6"]*(float)$val1);
                                                } else if ($datam["choice_name7"] == $value2){
                                                    $total_value+=((float)$datam["choice_value7"]*(float)$val1);
                                                } else if ($datam["choice_name8"] == $value2){
                                                    $total_value+=((float)$datam["choice_value8"]*(float)$val1);
                                                } else if ($datam["choice_name9"] == $value2){
                                                    $total_value+=((float)$datam["choice_value9"]*(float)$val1);
                                                } else if ($datam["choice_name0"] == $value2){
                                                    $total_value+=((float)$datam["choice_value0"]*(float)$val1);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } else if ($data["response_type"]  == "CHOICE"){
                        if ($data["exclude_multiplier"]=="0"){ //ne pas additionner si un multiplicateur
                            if ($data["is_multed"] == "0"){ //ne pas additionner si multiplié par une autre ligne
                                if ($val1 == $data["choice_name1"]){
                                    $total_value+=(float)$data["choice_value1"];
                                } else if ($val1 == $data["choice_name2"]){
                                    $total_value+=(float)$data["choice_value2"];
                                } else if ($val1 == $data["choice_name3"]){
                                    $total_value+=(float)$data["choice_value3"];
                                } else if ($val1 == $data["choice_name4"]){
                                    $total_value+=(float)$data["choice_value4"];
                                } else if ($val1 == $data["choice_name5"]){
                                    $total_value+=(float)$data["choice_value5"];
                                } else if ($val1 == $data["choice_name6"]){
                                    $total_value+=(float)$data["choice_value6"];
                                } else if ($val1 == $data["choice_name7"]){
                                    $total_value+=(float)$data["choice_value7"];
                                } else if ($val1 == $data["choice_name8"]){
                                    $total_value+=(float)$data["choice_value8"];
                                } else if ($val1 == $data["choice_name9"]){
                                    $total_value+=(float)$data["choice_value9"];
                                } else if ($val1 == $data["choice_name0"]){
                                    $total_value+=(float)$data["choice_value0"];
                                }
                            }
                        } else {
                            if ($val1 == $data["choice_name1"]){
                                $total2_value+=(float)$data["choice_value1"];
                            } else if ($val1 == $data["choice_name2"]){
                                $total2_value+=(float)$data["choice_value2"];
                            } else if ($val1 == $data["choice_name3"]){
                                $total2_value+=(float)$data["choice_value3"];
                            } else if ($val1 == $data["choice_name4"]){
                                $total2_value+=(float)$data["choice_value4"];
                            } else if ($val1 == $data["choice_name5"]){
                                $total2_value+=(float)$data["choice_value5"];
                            } else if ($val1 == $data["choice_name6"]){
                                $total2_value+=(float)$data["choice_value6"];
                            } else if ($val1 == $data["choice_name7"]){
                                $total2_value+=(float)$data["choice_value7"];
                            } else if ($val1 == $data["choice_name8"]){
                                $total2_value+=(float)$data["choice_value8"];
                            } else if ($val1 == $data["choice_name9"]){
                                $total2_value+=(float)$data["choice_value9"];
                            } else if ($val1 == $data["choice_name0"]){
                                $total2_value+=(float)$data["choice_value0"];
                            }     
                        }
                    } else if ($data["response_type"]  == "CHECKBOX"){
                        if ($val1 == "1"){
                            if ($data["exclude_multiplier"]=="0"){
                                $total_value+=(float)$data["choice_value1"];
                            } else {
                                $total2_value+=(float)$data["choice_value1"];
                            }
                        }
                    } else if ($data["response_type"]  == "MULTI-CHOICE"){
                        if ($data["exclude_multiplier"]=="0"){
                            if ($val1 == "1"){$total_value+=(float)$data["choice_value1"];} 
                            if ($val2 == "1"){$total_value+=(float)$data["choice_value2"];}
                            if ($val3 == "1"){$total_value+=(float)$data["choice_value3"];}
                            if ($val4 == "1"){$total_value+=(float)$data["choice_value4"];} 
                            if ($val5 == "1"){$total_value+=(float)$data["choice_value5"];} 
                            if ($val6 == "1"){$total_value+=(float)$data["choice_value6"];} 
                            if ($val7 == "1"){$total_value+=(float)$data["choice_value7"];} 
                            if ($val8 == "1"){$total_value+=(float)$data["choice_value8"];} 
                            if ($val9 == "1"){$total_value+=(float)$data["choice_value9"];} 
                            if ($val0 == "1"){$total_value+=(float)$data["choice_value0"];}
                        } else {
                            if ($val1 == "1"){$total2_value+=(float)$data["choice_value1"];}
                            if ($val2 == "1"){$total2_value+=(float)$data["choice_value2"];}
                            if ($val3 == "1"){$total2_value+=(float)$data["choice_value3"];}
                            if ($val4 == "1"){$total2_value+=(float)$data["choice_value4"];}
                            if ($val5 == "1"){$total2_value+=(float)$data["choice_value5"];}
                            if ($val6 == "1"){$total2_value+=(float)$data["choice_value6"];}
                            if ($val7 == "1"){$total2_value+=(float)$data["choice_value7"];}
                            if ($val8 == "1"){$total2_value+=(float)$data["choice_value8"];}
                            if ($val9 == "1"){$total2_value+=(float)$data["choice_value9"];}
                            if ($val0 == "1"){$total2_value+=(float)$data["choice_value0"];}
                        }
                    }
                }
                
                
/*                 $val1 = "";
                $val2 = "";
                $val3 = "";
                $val4 = "";
                $val5 = "";
                $val6 = "";
                $val7 = "";
                $val8 = "";
                $val9 = "";
                $val0 = "";
            //}     
            if($lineValID == "1"){$val1 = $value;}
            if($lineValID == "2"){$val2 = $value;}
            if($lineValID == "3"){$val3 = $value;}
            if($lineValID == "4"){$val4 = $value;}
            if($lineValID == "5"){$val5 = $value;}
            if($lineValID == "6"){$val6 = $value;}
            if($lineValID == "7"){$val7 = $value;}
            if($lineValID == "8"){$val8 = $value;}
            if($lineValID == "9"){$val9 = $value;}
            if($lineValID == "0"){$val0 = $value;}
            $lastLineID = $lineID;
            $lastKEY = $key;
            $xLoop++; */
        }
    }

if ($total_multiplier != 0){
    $total_value = $total_value*$total_multiplier;
}
$total_value = $total_value + $total2_value;

echo number_format($total_value,2,"."," ") . "$";  
$dw3_conn->close();
?>
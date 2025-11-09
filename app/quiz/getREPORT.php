<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$report_id  = $_GET['ID'];

echo "<div id='divEDIT_LINE_HEADER' class='dw3_form_head'>
        <h2>Réponse #" . $report_id . "</b>
        <button style='background:#555555;top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDIT_LINE();'><span class='material-icons'>cancel</span></button>
    </div>";

	$sql = "SELECT B.*, A.lang AS report_lang, A.id as report_id, A.parent_id as parent_id, A.date_completed as date_completed, A.head_id as head_id, A.report_eml as report_eml, 
            IFNULL(C.eml1,'') AS customer_eml,IFNULL(C.first_name,'') AS customer_first_name,IFNULL(C.last_name,'') AS customer_last_name, IFNULL(D.eml1,'') AS user_eml, A.user_created AS user_created, IFNULL(E.last_name,'') AS creator_last_name, IFNULL(E.first_name,'') AS creator_first_name
    FROM prototype_report A
    LEFT JOIN prototype_head B ON A.head_id = B.id
    LEFT JOIN customer C ON A.parent_id = C.id
    LEFT JOIN user D ON A.parent_id = D.id
    LEFT JOIN user E ON A.user_created = E.id
    WHERE A.id = '" . $report_id . "'";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $head_id = $data['id']??0;
    $report_lang = $data["report_lang"];
    if ($report_lang == "FR"){
        $head_name = $data['name_fr']??0;
        $head_desc = $data['description_fr']??0;
    } else {
        $head_name = $data['name_en']??0;
        $head_desc = $data['description_en']??0;
    }
    $head_total_type = $data['total_type']??0;
    $head_total_max = $data['total_max']??0;
    $head_parent_table = $data['parent_table']??0;
    $head_parent_id = $data['parent_id']??0;
    $head_user_created = $data['user_created']??0;
    $head_creator = trim($data['creator_first_name'] . " " . $data['creator_last_name']);
    $head_customer_name = trim(dw3_decrypt($data['customer_first_name']) . " " . dw3_decrypt($data['customer_last_name']));
    if ($head_parent_id != "0"){
        $head_user_eml = $data['user_eml']??'';
    } else {
        $head_user_eml = "";
    }
    $head_report_eml = $data['report_eml']??0;
    $head_customer_eml = dw3_decrypt($data['customer_eml'])??0;
    $date_completed = $data['date_completed']??0;

    $total_value = 0;
    $total2_value = 0;
    $total_multiplier = 0;
    //$values[]; to make fit with multipliers

    echo "<div style='position:absolute;top:40px;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>";
    echo "<div class='divBOX'>Date et heure complété:
            <input disabled type='datetime-local' value='".$date_completed."'>
          </div>";
    echo "<div class='divBOX'>Créé (et signé) par:
            <input disabled type='text' value='". $head_creator."'>
          </div><br class='br_small'>";
    if ($head_parent_table == "customer"){
        $parent_eml =  $head_customer_eml;
        echo "<div class='divBOX'>Email entré sur le formulaire:
            <input disabled type='text' value='".dw3_decrypt($head_report_eml) ."'>
        </div>";
        echo "<div class='divBOX'>Client trouvé:";
        if ($head_customer_eml == "" && $head_customer_name == ""){
            echo "<button onclick=\"linkToCustomer('".$report_id."')\">Associer à un client</button>";
        }
        echo "<input disabled type='text' value='".$head_customer_name." ".$head_customer_eml."'></div>";
    } else if (($head_parent_table == "user")){
        $parent_eml =  $head_user_eml;
        echo "<div class='divBOX'>Email entré sur le formulaire:
            <input disabled type='text' value='".$head_report_eml ."'>
        </div>";
        echo "<div class='divBOX'>Employé trouvé:";
            if (($head_user_eml == "" || $head_parent_id == "0") && $APREAD_ONLY == false){
                echo "<button onclick=\"linkToUser('".$report_id."')\">Associer à un employé</button>";
            }
        echo "<input disabled type='text' value='".$head_user_eml."'></div>";
    }
    echo "<hr><form id='report_editor' onsubmit='return false;'>";
        $sql = "SELECT A.*,B.* FROM prototype_line A
        LEFT JOIN (SELECT * FROM prototype_data WHERE report_id = '" . $report_id . "') B ON A.id = B.line_id
        WHERE A.head_id = '".$head_id."' ORDER BY position ASC;";
	$result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
            if($report_lang == "FR"){
                $line_name = $row["name_fr"];
                $line_desc = $row["description_fr"];
                $line_c1 = $row["choice_name1"];
                $line_c2 = $row["choice_name2"];
                $line_c3 = $row["choice_name3"];
                $line_c4 = $row["choice_name4"];
                $line_c5 = $row["choice_name5"];
                $line_c6 = $row["choice_name6"];
                $line_c7 = $row["choice_name7"];
                $line_c8 = $row["choice_name8"];
                $line_c9 = $row["choice_name9"];
                $line_c0 = $row["choice_name0"];
            } else {
                $line_name = $row["name_en"];
                $line_desc = $row["description_en"];
                $line_c1 = $row["choice_name1_en"];
                $line_c2 = $row["choice_name2_en"];
                $line_c3 = $row["choice_name3_en"];
                $line_c4 = $row["choice_name4_en"];
                $line_c5 = $row["choice_name5_en"];
                $line_c6 = $row["choice_name6_en"];
                $line_c7 = $row["choice_name7_en"];
                $line_c8 = $row["choice_name8_en"];
                $line_c9 = $row["choice_name9_en"];
                $line_c0 = $row["choice_name0_en"];
            }
            if($row["mandatory"]=="1"){
                $req=" title='Requis' ";
                $required_field = "<span style='color:red;font-weight:bold;'>*</span>";
            }else{
                $req='';
                $required_field = "";
            }

            if($row["box_size"]=="SMALL"){
                $box_size = "200px";
            } else if($row["box_size"]=="MEDIUM"){
                $box_size = "335px";
            } else if($row["box_size"]=="LARGE"){
                $box_size = "90%";
            } else {
                $box_size = "335px";
            }
    //NONE
            if($row["response_type"] == "NONE"){
                //if($line_name != ""){
                   echo "<h3 style='background:#".$CIE_COLOR6.";color:#".$CIE_COLOR7.";'>".$line_name."</h3>";
                //}
                if($line_desc != ""){
                    echo "<br class='br_small'><div style='font-size:0.8em;font-weight:normal;width:100%;text-align:left;'>".$line_desc."</div>";
                }
    //TEXT
            } else if($row["response_type"] == "TEXT"){
                echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b>";
                if ($row["record_name"] != "" && $row["record_name"] != "NONE"){
                    echo "<button style='float:right;padding:2px;' onclick=\"updDB('".strtolower($row["record_name"])."','".$head_parent_table."','".$head_parent_id."','".$row["value1"]."');\"><span class='material-icons' style='font-size:0.9em;'>upgrade</span></button>";
                }
                if($line_desc!= ""){
                    echo "<div style='font-size:0.7em;'>".$line_desc."</div>";
                }
                echo "<input id='lnVAL1_".$row["id"]."' value='".$row["value1"]."' type='text' style='text-align:".strtolower($row["response_align"]).";'></div>";
                if($row["multiplier"] =="1"){
                    if ($row["multiplied"] =="0"){
                        $total_multiplier += (float)$row["value1"];
                    } else {
                        $sqlm = "SELECT A.*,B.* FROM prototype_line A
                        LEFT JOIN (SELECT * FROM prototype_data WHERE report_id = '" . $report_id . "') B ON A.id = B.line_id
                        WHERE id='".$row["multiplied"]."' LIMIT 1;";
                        $resultm = mysqli_query($dw3_conn, $sqlm);
                        $datam = mysqli_fetch_assoc($resultm);
                         if ($resultm->num_rows > 0) {
                            if ($datam["response_type"] == "TEXT"){
                                $total_value+=(float)$datam["choice_value1"]*(float)$row["value1"];
                            } else if ($datam["response_type"] == "CHOICE"){
                                if ($row["exclude_multiplier"]=="0"){
                                    if ($datam["choice_name1"] == $datam["value1"]){
                                        $total_value+=(float)$datam["choice_value1"]*(float)$row["value1"];
                                    } else if ($datam["choice_name2"] == $datam["value1"]){
                                        $total_value+=(float)$datam["choice_value2"]*(float)$row["value1"];
                                    } else if ($datam["choice_name3"] == $datam["value1"]){
                                        $total_value+=(float)$datam["choice_value3"]*(float)$row["value1"];
                                    } else if ($datam["choice_name4"] == $datam["value1"]){
                                        $total_value+=(float)$datam["choice_value4"]*(float)$row["value1"];
                                    } else if ($datam["choice_name5"] == $datam["value1"]){
                                        $total_value+=(float)$datam["choice_value5"]*(float)$row["value1"];
                                    } else if ($datam["choice_name6"] == $datam["value1"]){
                                        $total_value+=(float)$datam["choice_value6"]*(float)$row["value1"];
                                    } else if ($datam["choice_name7"] == $datam["value1"]){
                                        $total_value+=(float)$datam["choice_value7"]*(float)$row["value1"];
                                    } else if ($datam["choice_name8"] == $datam["value1"]){
                                        $total_value+=(float)$datam["choice_value8"]*(float)$row["value1"];
                                    } else if ($datam["choice_name9"] == $datam["value1"]){
                                        $total_value+=(float)$datam["choice_value9"]*(float)$row["value1"];
                                    } else if ($datam["choice_name0"] == $datam["value1"]){
                                        $total_value+=(float)$datam["choice_value0"]*(float)$row["value1"];
                                    }
                                } else {
                                    if ($datam["choice_name1"] == $datam["value1"]){
                                        $total2_value+=(float)$datam["choice_value1"]*(float)$row["value1"];
                                    } else if ($datam["choice_name2"] == $datam["value1"]){
                                        $total2_value+=(float)$datam["choice_value2"]*(float)$row["value1"];
                                    } else if ($datam["choice_name3"] == $datam["value1"]){
                                        $total2_value+=(float)$datam["choice_value3"]*(float)$row["value1"];
                                    } else if ($datam["choice_name4"] == $datam["value1"]){
                                        $total2_value+=(float)$datam["choice_value4"]*(float)$row["value1"];
                                    } else if ($datam["choice_name5"] == $datam["value1"]){
                                        $total2_value+=(float)$datam["choice_value5"]*(float)$row["value1"];
                                    } else if ($datam["choice_name6"] == $datam["value1"]){
                                        $total2_value+=(float)$datam["choice_value6"]*(float)$row["value1"];
                                    } else if ($datam["choice_name7"] == $datam["value1"]){
                                        $total2_value+=(float)$datam["choice_value7"]*(float)$row["value1"];
                                    } else if ($datam["choice_name8"] == $datam["value1"]){
                                        $total2_value+=(float)$datam["choice_value8"]*(float)$row["value1"];
                                    } else if ($datam["choice_name9"] == $datam["value1"]){
                                        $total2_value+=(float)$datam["choice_value9"]*(float)$row["value1"];
                                    } else if ($datam["choice_name0"] == $datam["value1"]){
                                        $total2_value+=(float)$datam["choice_value0"]*(float)$row["value1"];
                                    }
                                }
                            }
                        }    
                    }
                }
    //MULTI-TEXT
            } else if($row["response_type"] == "MULTI-TEXT"){
                echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b>";
                if ($row["is_total"] == "1"){
                    echo "<button class='green' style='float:right;' onclick=\"calculTotal('".$row["id"]."');\">Calculer les taxe et le total</button>";
                }
                if($line_desc!= ""){
                    echo "<br class='br_small'><div style='font-size:0.7em;'>".$line_desc."</div>";
                }
                //valeur1
                if($line_c1 != ""){
                    echo "<br class='br_small'>".$line_c1;
                }
                    echo "<input id='lnVAL1_".$row["id"]."' value='".$row["value1"]."' type='text' style='text-align:".strtolower($row["response_align"]).";'>";
                //valeur2
                if($line_c2 != ""){
                    echo "<br class='br_small'>".$line_c2;
                    echo "<input id='lnVAL2_".$row["id"]."' value='".$row["value2"]."' type='text' style='text-align:".strtolower($row["response_align"]).";'>";
                }
                //valeur3
                if($line_c3 != ""){
                    echo "<br class='br_small'>".$line_c3;
                    echo "<input id='lnVAL3_".$row["id"]."' value='".$row["value3"]."' type='text' style='text-align:".strtolower($row["response_align"]).";'>";
                }
                //valeur4
                if($line_c4 != ""){
                    echo "<br class='br_small'>".$line_c4;
                    echo "<input id='lnVAL4_".$row["id"]."' value='".$row["value4"]."' type='text' style='text-align:".strtolower($row["response_align"]).";'>";
                }
                //valeur5
                if($line_c5 != ""){
                    echo "<br class='br_small'>".$line_c5;
                    echo "<input id='lnVAL5_".$row["id"]."' value='".$row["value5"]."' type='text' style='text-align:".strtolower($row["response_align"]).";'>";
                }
                //valeur6
                if($line_c6 != ""){
                    echo "<br class='br_small'>".$line_c6;
                    echo "<input id='lnVAL6_".$row["id"]."' value='".$row["value6"]."' type='text' style='text-align:".strtolower($row["response_align"]).";'>";
                }
                //valeur7
                if($line_c7 != ""){
                    echo "<br class='br_small'>".$line_c7;
                    echo "<input id='lnVAL7_".$row["id"]."' value='".$row["value7"]."' type='text' style='text-align:".strtolower($row["response_align"]).";'>";
                }
                //valeur8
                if($line_c8 != ""){
                    echo "<br class='br_small'>".$line_c8;
                    echo "<input id='lnVAL8_".$row["id"]."' value='".$row["value8"]."' type='text' style='text-align:".strtolower($row["response_align"]).";'>";
                }
                //valeur9
                if($line_c9 != ""){
                    echo "<br class='br_small'>".$line_c9;
                    echo "<input id='lnVAL9_".$row["id"]."' value='".$row["value9"]."' type='text' style='text-align:".strtolower($row["response_align"]).";'>";
                }
                //valeur0
                if($line_c0 != ""){
                    echo "<br class='br_small'>".$line_c0;
                    echo "<input id='lnVAL0_".$row["id"]."' value='".$row["value0"]."' type='text' style='text-align:".strtolower($row["response_align"]).";'>";
                }
                echo "</div>";
    //CHECKBOX        
            } else if($row["response_type"] == "CHECKBOX"){
                if ($row["value1"]=="1"){
                    $is_checked = "checked";$total_value+=(float)$row["choice_value1"];} else {$is_checked = "";}
                echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><input id='lnVAL1_".$row["id"]."' ".$is_checked." type='checkbox' style='float:right;margin:5px 10px;'><br class='br_small'><small>".$line_desc."</small></div>";
    //YES/NO      
            } else if($row["response_type"] == "YES/NO"){
                echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b>";
                if($line_desc!= ""){
                    echo "<br class='br_small'><div style='font-size:0.7em;'>".$line_desc."</div>";
                }
                //echo " <b> <u>".$row["value1"]."</u></b></div>";
                echo "<select id='lnVAL1_".$row["id"]."' style='width:120px;float:right;text-align:center;' ".$req.">";
                if($report_lang == "FR"){
                        echo "<option value=''>Non défini</option>";
                        echo "<option ";if ($row["value1"]=="YES" || $row["value1"]=="OUI"){echo " selected ";} echo ">OUI</option>";
                        echo "<option ";if ($row["value1"]=="NO" || $row["value1"]=="NON"){echo " selected ";} echo ">NON</option>";
                } else {
                    echo "<option value=''>Not defined</option>";
                    echo "<option ";if ($row["value1"]=="YES" || $row["value1"]=="OUI"){echo " selected ";} echo ">YES</option>";
                    echo "<option ";if ($row["value1"]=="NO" || $row["value1"]=="NON"){echo " selected ";} echo ">NO</option>";
                }
                echo "</select></div>";
    //CHOICE        
            } else if($row["response_type"] == "CHOICE"){
                echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b>";
                if($line_desc!= ""){
                    echo "<br class='br_small'><div style='font-size:0.7em;display:inline-block;'>".$line_desc."</div>";
                }
                //echo " <u>".$row["value1"]."</u></div>";
                echo "<select id='lnVAL1_".$row["id"]."' style='max-width:100%;width:auto;float:right;' ".$req.">";
                //valeur1
                    echo "<option";if ($row["value1"]==$line_c1){echo " selected ";} echo ">".$line_c1."</option>";
                //valeur2
                    echo "<option";if ($row["value1"]==$line_c2){echo " selected ";} echo ">".$line_c2."</option>";
                //valeur3
                if($line_c3 != ""){
                    echo "<option";if ($row["value1"]==$line_c3){echo " selected ";} echo ">".$line_c3."</option>";
                }
                //valeur4
                if($line_c4 != ""){
                    echo "<option";if ($row["value1"]==$line_c4){echo " selected ";} echo ">".$line_c4."</option>";
                }
                //valeur5
                if($line_c5 != ""){
                    echo "<option";if ($row["value1"]==$line_c5){echo " selected ";} echo ">".$line_c5."</option>";
                }
                //valeur6
                if($line_c6 != ""){
                    echo "<option";if ($row["value1"]==$line_c6){echo " selected ";} echo ">".$line_c6."</option>";
                }
                //valeur7
                if($line_c7 != ""){
                    echo "<option";if ($row["value1"]==$line_c7){echo " selected ";} echo ">".$line_c7."</option>";
                }
                //valeur6
                if($line_c8 != ""){
                    echo "<option";if ($row["value1"]==$line_c8){echo " selected ";} echo ">".$line_c8."</option>";
                }
                //valeur6
                if($line_c9 != ""){
                    echo "<option";if ($row["value1"]==$line_c9){echo " selected ";} echo ">".$line_c9."</option>";
                }
                //valeur6
                if($line_c0 != ""){
                    echo "<option";if ($row["value1"]==$line_c0){echo " selected ";} echo ">".$line_c0."</option>";
                }
                echo "</select></div>";
                if ($row["exclude_multiplier"]=="0"){
                    if ($line_c1== $row["value1"]){
                        $total_value+=(float)$row["choice_value1"];
                    } else if ($line_c2 == $row["value1"]){
                        $total_value+=(float)$row["choice_value2"];
                    } else if ($line_c3 == $row["value1"]){
                        $total_value+=(float)$row["choice_value3"];
                    } else if ($line_c4 == $row["value1"]){
                        $total_value+=(float)$row["choice_value4"];
                    } else if ($line_c5 == $row["value1"]){
                        $total_value+=(float)$row["choice_value5"];
                    } else if ($line_c6 == $row["value1"]){
                        $total_value+=(float)$row["choice_value6"];
                    } else if ($line_c7 == $row["value1"]){
                        $total_value+=(float)$row["choice_value7"];
                    } else if ($line_c8 == $row["value1"]){
                        $total_value+=(float)$row["choice_value8"];
                    } else if ($line_c9 == $row["value1"]){
                        $total_value+=(float)$row["choice_value9"];
                    } else if ($line_c0 == $row["value1"]){
                        $total_value+=(float)$row["choice_value0"];
                    }
                } else {
                    if ($line_c1== $row["value1"]){
                        $total2_value+=(float)$row["choice_value1"];
                    } else if ($line_c2 == $row["value1"]){
                        $total2_value+=(float)$row["choice_value2"];
                    } else if ($line_c3 == $row["value1"]){
                        $total2_value+=(float)$row["choice_value3"];
                    } else if ($line_c4 == $row["value1"]){
                        $total2_value+=(float)$row["choice_value4"];
                    } else if ($line_c5 == $row["value1"]){
                        $total2_value+=(float)$row["choice_value5"];
                    } else if ($line_c6 == $row["value1"]){
                        $total2_value+=(float)$row["choice_value6"];
                    } else if ($line_c7 == $row["value1"]){
                        $total2_value+=(float)$row["choice_value7"];
                    } else if ($line_c8 == $row["value1"]){
                        $total2_value+=(float)$row["choice_value8"];
                    } else if ($line_c9 == $row["value1"]){
                        $total2_value+=(float)$row["choice_value9"];
                    } else if ($line_c0 == $row["value1"]){
                        $total2_value+=(float)$row["choice_value0"];
                    }
                }
    //MULTI-CHOICE
            } else if($row["response_type"] == "MULTI-CHOICE"){
                echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b>";
                if($line_desc!= ""){
                    echo "<br class='br_small'><div style='font-size:0.7em;display:inline-block;'>".$line_desc."</div>";
                }
                echo "<div style='float:right;margin-right:5px;text-align:right;'>";
                //valeur1
                    if ($row["value1"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value1"];} else {$is_checked = "";}
                    echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL1_".$row["id"]."'>".$line_c1."</label> <input id='lnVAL1_".$row["id"]."' ".$is_checked." type='checkbox' style='margin:2px 2px 2px 5px;'></div>";
                //valeur2
                    if ($row["value2"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value2"];} else {$is_checked = "";}
                    echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL2_".$row["id"]."'>".$line_c2."</label> <input id='lnVAL2_".$row["id"]."' ".$is_checked." type='checkbox' style='margin:2px 2px 2px 5px;'></div>";
                //valeur3
                if($line_c3 != ""){
                    if ($row["value3"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value3"];} else {$is_checked = "";}
                    echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL3_".$row["id"]."'>".$line_c3."</label> <input id='lnVAL3_".$row["id"]."' ".$is_checked." type='checkbox' style='margin:2px 2px 2px 5px;'></div>";
                }
                //valeur4
                if($line_c4 != ""){
                    if ($row["value4"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value4"];} else {$is_checked = "";}
                    echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL4_".$row["id"]."'>".$line_c4."</label><input id='lnVAL4_".$row["id"]."' ".$is_checked." type='checkbox' style='margin:2px 2px 2px 5px;'></div>";
                }
                //valeur5
                if($line_c5 != ""){
                    if ($row["value5"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value5"];} else {$is_checked = "";}
                    echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL5_".$row["id"]."'>".$line_c5."</label> <input id='lnVAL5_".$row["id"]."' ".$is_checked." type='checkbox' style='margin:2px 2px 2px 5px;'></div>";
                }
                //valeur6
                if($line_c6 != ""){
                    if ($row["value6"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value6"];} else {$is_checked = "";}
                    echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL6_".$row["id"]."'>".$line_c6."</label> <input id='lnVAL6_".$row["id"]."' ".$is_checked." type='checkbox' style='margin:2px 2px 2px 5px;'></div>";
                }
                //valeur7
                if($line_c7 != ""){
                    if ($row["value7"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value7"];} else {$is_checked = "";}
                    echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL7_".$row["id"]."'>".$line_c7."</label> <input id='lnVAL7_".$row["id"]."' ".$is_checked." type='checkbox' style='margin:2px 2px 2px 5px;'></div>";
                }
                //valeur8
                if($line_c8 != ""){
                    if ($row["value8"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value8"];} else {$is_checked = "";}
                    echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL8_".$row["id"]."'>".$line_c8."</label> <input id='lnVAL8_".$row["id"]."' ".$is_checked." type='checkbox' style='margin:2px 2px 2px 5px;'></div>";
                }
                //valeur9
                if($line_c8 != ""){
                    if ($row["value9"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value9"];} else {$is_checked = "";}
                    echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL9_".$row["id"]."'>".$line_c9."</label> <input id='lnVAL9_".$row["id"]."' ".$is_checked." type='checkbox' style='margin:2px 2px 2px 5px;'></div>";
                }
                //valeur0
                if($line_c0 != ""){
                    if ($row["value0"]=="1"){$is_checked = "checked";$total_value+=(float)$row["choice_value0"];} else {$is_checked = "";}
                    echo "<div style='border-bottom:1px dotted lightgrey;'><label for='lnVAL0_".$row["id"]."'>".$line_c0."</label> <input id='lnVAL0_".$row["id"]."' ".$is_checked." type='checkbox' style='margin:2px 2px 2px 5px;'></div>";
                }
                echo "</div></div>";
                if ($row["exclude_multiplier"]=="0"){
                    if ($row["value1"] == "1"){$total_value+=(float)$row["choice_value1"];} 
                    if ($row["value2"] == "1"){$total_value+=(float)$row["choice_value2"];}
                    if ($row["value3"] == "1"){$total_value+=(float)$row["choice_value3"];}
                    if ($row["value4"] == "1"){$total_value+=(float)$row["choice_value4"];} 
                    if ($row["value5"] == "1"){$total_value+=(float)$row["choice_value5"];} 
                    if ($row["value6"] == "1"){$total_value+=(float)$row["choice_value6"];} 
                    if ($row["value7"] == "1"){$total_value+=(float)$row["choice_value7"];} 
                    if ($row["value8"] == "1"){$total_value+=(float)$row["choice_value8"];} 
                    if ($row["value9"] == "1"){$total_value+=(float)$row["choice_value9"];} 
                    if ($row["value0"] == "1"){$total_value+=(float)$row["choice_value0"];}
                } else {
                    if ($row["value1"] == "1"){$total2_value+=(float)$row["choice_value1"];}
                    if ($row["value2"] == "1"){$total2_value+=(float)$row["choice_value2"];}
                    if ($row["value3"] == "1"){$total2_value+=(float)$row["choice_value3"];}
                    if ($row["value4"] == "1"){$total2_value+=(float)$row["choice_value4"];}
                    if ($row["value5"] == "1"){$total2_value+=(float)$row["choice_value5"];}
                    if ($row["value6"] == "1"){$total2_value+=(float)$row["choice_value6"];}
                    if ($row["value7"] == "1"){$total2_value+=(float)$row["choice_value7"];}
                    if ($row["value8"] == "1"){$total2_value+=(float)$row["choice_value8"];}
                    if ($row["value9"] == "1"){$total2_value+=(float)$row["choice_value9"];}
                    if ($row["value0"] == "1"){$total2_value+=(float)$row["choice_value0"];}
                }
    //FILE
            } else if($row["response_type"] == "FILE"){
                if ($row["value1"] == ""){
                    $extension = "";
                }else {
                    $extension = pathinfo($row["value1"], PATHINFO_EXTENSION);
                }
                if ($extension=="png" || $extension=="jpg" || $extension=="jpeg" || $extension=="webp"){
                    if ($head_parent_id != 0){
                        echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><br class='br_small'><small>".$line_desc."</small><br class='br_small'><img style='width:300px;' src='/fs/".$head_parent_table."/".$head_parent_id."/".$row["value1"]."'></div>";
                    } else {
                        echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><br class='br_small'><small>".$line_desc."</small><br class='br_small'><img style='width:300px;' src='/fs/".$head_parent_table."/upload/".$row["value1"]."'></div>";
                    }
                } else if ($row["value1"] != 'undefined') {
                    if ($head_parent_id != 0){
                        echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><br class='br_small'><small>".$line_desc."</small><br class='br_small'><a href='/fs/".$head_parent_table."/".$head_parent_id."/".$row["value1"]."' target='_blank'>".$row["value1"]."</a></div>";
                    } else {
                        echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><br class='br_small'><small>".$line_desc."</small><br class='br_small'><a href='/fs/".$head_parent_table."/upload/".$row["value1"]."' target='_blank'>".$row["value1"]."</a></div>";
                    }
                } else {
                    echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><br class='br_small'><small>".$line_desc."</small><br class='br_small'>".$row["value1"]."</div>";
                }
                //echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><small>".$line_desc."</small><input id='lnVAL1_".$row["id"]."' value='".$row["value1"]."' type='file'></div>";
    //COLOR
            } else if($row["response_type"] == "COLOR"){
                echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><br class='br_small'><small>".$line_desc."</small><input id='lnVAL1_".$row["id"]."' value='".$row["value1"]."' type='color'></div>";
    //PASSWORD
            } else if($row["response_type"] == "PASSWORD"){
                echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><br class='br_small'><small>".$line_desc."</small><input id='lnVAL1_".$row["id"]."' value='".$row["value1"]."' type='password'></div>";
    //DATE
            } else if($row["response_type"] == "DATE"){
                echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><br class='br_small'><small>".$line_desc."</small><input id='lnVAL1_".$row["id"]."' value='".$row["value1"]."' type='date'></div>";
    //TIME
            } else if($row["response_type"] == "TIME"){
                echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><br class='br_small'><small>".$line_desc."</small><input id='lnVAL1_".$row["id"]."' value='".$row["value1"]."' type='time'></div>";
    //SIGNATURE
            } else if($row["response_type"] == "SIGNATURE"){
                echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><br class='br_small'>".$line_desc;
                $sig_path = $_SERVER['DOCUMENT_ROOT'] . "/fs/customer/upload/doc-sig-". $report_id ."-".$row["id"]. ".png";
                $sig_path_pub = "/fs/customer/upload/doc-sig-". $report_id . "-".$row["id"].".png";
                if (file_exists($sig_path)){
                    echo "<div style='width:100%;text-align:center;'><img src='" . $sig_path_pub . "' style='width:auto;height:90px;max-width:335px;'></div>"; 

                }
                echo "</div>";
            } else if($row["response_type"] == "SIG-USER"){
                $RNDSEQ = rand(10,100000);
                echo "<div class='divBOX' style='min-height:20px;max-width:".$box_size.";width:".$box_size.";'><b>".$line_name."</b><br class='br_small'>".$line_desc;
                $sig_path = $_SERVER['DOCUMENT_ROOT'] . "/fs/user/".$head_user_created."/signature.png";
                $sig_path_pub = "/fs/user/".$head_user_created."/signature.png";
                if (file_exists($sig_path)){
                    echo "<div style='width:100%;text-align:center;'><img src='" . $sig_path_pub . "?t=" . $RNDSEQ."' style='width:auto;height:90px;max-width:335px;'></div>"; 

                }
                echo "</div>";
            }
		}
	}
    
    //if ($total_multiplier != 0){
        $total_value = $total_value*$total_multiplier;
    //}
    $total_value = $total_value+$total2_value;

    if ($head_total_type == "CASH" || $head_total_type == "POINTS"){
        echo "<div><h2 style='text-align:left;'>Total: ".$total_value;
        if ($head_total_type == "CASH"){ echo "$";}  
        if ($head_total_type == "POINTS"){ echo " points";}  
        echo "</h2></div>";
    }
    echo "<input type='text' id='invalid_input' style='display:none;'></form><br><br></div><div class='dw3_form_foot'>";
        if ($APREAD_ONLY == false) {echo "<button class='red' onclick='deleteREPORT(\"" .$report_id . "\");'><span class='material-icons'>delete</span></button>";}
        if ($APREAD_ONLY == false) { 
            echo "<button class='grey' onclick='closeEDIT_LINE();'><span class='material-icons'>cancel</span></button>";
        } else {
            echo "<button class='grey' onclick='closeEDIT_LINE();'><span class='material-icons'>cancel</span> Fermer</button>";
        }
        echo "<button class='gold' onclick=\"openPDF_REPORT('" .$report_id . "');\"><span class='material-icons'>picture_as_pdf</span></button>";
        if ($APREAD_ONLY == false) {echo "<button class='blue' onclick=\"pdfREPORT('" .$report_id . "','".$parent_eml."','".$head_parent_id."');\"><span class='material-icons'>send</span> Envoyer</button>";}
        if ($APREAD_ONLY == false) {echo "<button class='green' onclick='updREPORT(\"" .$report_id . "\");'><span class='material-icons'>save</span></button>";}
    echo "</div>";
    $dw3_conn->close();
?>
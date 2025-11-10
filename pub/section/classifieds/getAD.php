<?php 
//header("SECTION_ID:".$_SERVER['HTTP_SECTION_ID'])??'';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/loader.min.php';

if($USER_LANG == "FR"){
    $lbl1 = "Prix en promotion";
    $lbl2 = "Jusqu'au";
    $lbl3_0 = "Taxable";
    $lbl3 = "Taxes fédérales";
    $lbl4 = "Taxes provinciales";
    $lbl5 = "Allée";
    $lbl6 = "Fabriquant";
    $lbl7 = "# de modèle";
    $lbl8 = "Année du modèle";
    $lbl9 = "Litres";
    $lbl10 = "Disponible en magasin";
    $lbl11 = "Oui";
    $lbl12 = "Non";
    $lbl13 = "Hauteur";
    $lbl14 = "Largeur";
    $lbl15 = "Profondeur";
    $lbl16 = "Poid";
    $lbl17 = "Inventaire";
    $lbl18 = "État du produit";
}else{
    $lbl1 = "Promotional price";
    $lbl2 = "Valid until";
    $lbl3_0 = "Taxable";
    $lbl3 = "Federal taxes";
    $lbl4 = "Provincial taxes";
    $lbl5 = "Aisle";
    $lbl6 = "Manufacturer";
    $lbl7 = "Model #";
    $lbl8 = "Model year";
    $lbl9 = "Liters";
    $lbl10 = "Available in store";
    $lbl11 = "Yes";
    $lbl12 = "No";
    $lbl13 = "Height";
    $lbl14 = "Width";
    $lbl15 = "Depth";
    $lbl16 = "Weight";
    $lbl17 = "Inventory";
    $lbl18 = "Product condition";
}

$addID  = $_GET['A']??"";
$display_mode  = $_GET['M']??'';

$dw3_wish=array();
foreach ($_COOKIE as $key=>$val){
  if (substr($key, 0, 5) == "WISH2"){
    $dw3_wish[$key] = intval($dw3_wish[$key]??0) + intval($val);
  }
}

$html = "";
	$sql = "SELECT A.*, B.last_name AS retailer_name,B.company AS retailer_company, B.city AS retailer_city FROM classified A LEFT JOIN (SELECT * FROM customer) B ON A.customer_id = B.id WHERE A.id = " . $addID . " LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
            $filename= $row["img_link"];
            $filename2= $row["img_link2"];
            $filename3= $row["img_link3"];
            if (file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename2) && $filename2 != "" ){
                $filename2 = "/fs/customer/" . $row["customer_id"] . "/" . $filename2;
            }
            if (file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename3) && $filename3 != "" ){
                $filename3 = "/fs/customer/" . $row["customer_id"] . "/" . $filename3;
            }
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename)){
                $filename = "/pub/img/dw3/nd.png";
            } else {
                if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename)){
                    $filename = "/pub/img/dw3/nd.png";
                }else{
                    $filename = "/fs/customer/" . $row["customer_id"] . "/" . $filename;
                }
            }

			$html .= "<div class='dw3_form_head' id='dw3_editor_HEAD' style='min-width:300px;'>
                        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>";
                    if($USER_LANG == "FR"){ $html .= $row["name_fr"]; }else{$html .= $row["name_en"]; } $html .="</div></h3>
                        <button class='dw3_form_close' class='no-effect' onclick='dw3_editor_close();'><span class='material-icons'>cancel</span></button>
                    </div>
                    <div class='dw3_form_data' style='background:#f0f0f0;color:#333;min-width:300px;'>";
            
                //files
                $html .="<img id='imgPRD' style='margin:5px;box-shadow: 2px 2px 5px 2px black;width:auto;height:300px;max-height:300px;max-width:95%;border-radius:5px;' src='" . $filename . "' onerror='this.onerror=null; this.src=\"/img/dw3/nd.png\";'>";                
                 if ($filename2!="" || $filename3!=""){
                    $html .="<div class='dw3_section'>";
                    $html .= "<button class='no-effect' onclick=\"dw3_change_image('".$filename. "','imgPRD')\" style='box-shadow: 1px 1px 4px 2px #555;border:0px;margin:0px 3px 5px 3px;color:#111;text-shadow: 1px 1px #1baff3;height:40px;min-width:40px;max-width:40px;background-size:100% 100%;background-color:#FFF;background-image: url(\"".$filename . "\");'></button>";
                    if ($filename2!=""){
                        $html .= "<button class='no-effect' onclick=\"dw3_change_image('".$filename2. "','imgPRD')\" style='box-shadow: 1px 1px 4px 2px #555;border:0px;margin:0px 3px 5px 3px;color:#111;text-shadow: 1px 1px #1baff3;height:40px;min-width:40px;max-width:40px;background-size:100% 100%;background-color:#FFF;background-image: url(\"".$filename2 . "\");'></button>";
                    }
                    if ($filename3!=""){
                        $html .= "<button class='no-effect' onclick=\"dw3_change_image('".$filename3. "','imgPRD')\" style='box-shadow: 1px 1px 4px 2px #555;border:0px;margin:0px 3px 5px 3px;color:#111;text-shadow: 1px 1px #1baff3;height:40px;min-width:40px;max-width:40px;background-size:100% 100%;background-color:#FFF;background-image: url(\"".$filename3. "\");'></button>";
                    }
                    $html .= "</div>";
                 }
                
                //INFORMNATIONS GÉNÉRALES
                if($USER_LANG == "FR"){
                    $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;min-height:25px;width:90%;max-width:95%;font-weight:normal;'>" . $row["description_fr"] . "</div>	";
                }else{
                    $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;min-height:25px;width:90%;max-width:95%;font-weight:normal;'>" . $row["description_en"] . "</div>	";
                }
                $plitted = explode(".",$row["price"]);
                $whole = $plitted[0]??$row["price"];
                $fraction = $plitted[1]??0; 
                if ($fraction == 0){
                    $fraction = ".00";
                }else{
                    $fraction = ".".str_pad(rtrim($fraction, "0"), 2 , "0");
                }
                if($USER_LANG == "FR"){				
                            $html .="<div class='dw3_box' style='min-height:20px;'><b>Prix incluant les taxes</b>:
                            <span style='float:right;'>". number_format($whole) . "<sup>" . $fraction . "</sup></span>
                        </div>	";
                } else {				
                        $html .="<div class='dw3_box' style='min-height:20px;'><b>Price including taxes</b>:
                            <span style='float:right;'>". number_format($whole) . "<sup>" . $fraction . "</sup></span>
                        </div>	";
                }             
                    /*                 $html .= "<div class='dw3_box' style='min-height:20px;'><div style='position:absolute;width:340px;display:inline-block;vertical-align:middle;'>
                                        <b>".$lbl3_0."</b>:</div>
                                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                                            "; if ($row["taxable"] == true){ $html .= $lbl11; }else { $html .= $lbl12 ;} $html .= "
                                        </div>
                                    </div>"; */
                  
  
                  if ($row["brand"] != "" || $row["model"] != "" || $row["year_production"] != "0"){			
                   $html .="<div class='dw3_box' style='min-height:20px;'><b>".$lbl6."</b>: 
                   <span style='float:right;'>" . $row["brand"] . "</span>
                    </div>				
                    <div class='dw3_box' style='min-height:20px;'><b>".$lbl7."</b>:
                        <span style='float:right;'>" . $row["model"] . "</span>
                    </div>				
                    <div class='dw3_box' style='min-height:20px;'><b>".$lbl8."</b>:
                        <span style='float:right;'>" . $row["year_production"] . "</span>
                    </div>";
                  }
                  //etat
                    $ad_status = "Non-défini";
                    if($USER_LANG == "FR"){
                        if ($row["etat"] == "1"){$ad_status = "Neuf";}
                        if ($row["etat"] == "2"){$ad_status = "Presque neuf";}
                        if ($row["etat"] == "3"){$ad_status = "Usagé";}
                        if ($row["etat"] == "4"){$ad_status = "Remis à neuf";}
                    } else {
                        if ($row["etat"] == "1"){$ad_status = "New";}
                        if ($row["etat"] == "2"){$ad_status = "Almost new";}
                        if ($row["etat"] == "3"){$ad_status = "Used";}
                        if ($row["etat"] == "4"){$ad_status = "Refurbished";}
                    }		
                    $html .="<div class='dw3_box' style='min-height:20px;'><b>".$lbl18."</b>:
                    <span style='float:right;'>" . $ad_status . "</span>
                    </div>";	
                  //retailer
                    if($USER_LANG == "FR"){		
                        if ($row["retailer_company"]==""){		
                            $html .="<div class='dw3_box' style='min-height:20px;'><b>Détaillant</b>:<button class='blue' onclick=\"getRET_ADS('".$row["customer_id"]."')\" style='float:right;margin:5px;'><span class='material-icons'>info</span></button>
                                    <br><span style='font-weight:normal;'>". dw3_decrypt($row["retailer_name"]) . " (".$row["retailer_city"].")</span>
                                </div>	";
                        } else {
                            $html .="<div class='dw3_box' style='min-height:20px;'><b>Détaillant</b>:<button class='blue' onclick=\"getRET_ADS('".$row["customer_id"]."')\" style='float:right;margin:5px;'><span class='material-icons'>info</span></button>
                                    <br><span style='font-weight:normal;'>". $row["retailer_company"] . " (".$row["retailer_city"].")</span>
                                </div>	";              
                        }
                    } else {				
                        if ($row["retailer_company"]==""){		
                            $html .="<div class='dw3_box' style='min-height:20px;'><b>Retailer</b>:<button class='blue' onclick=\"getRET_ADS('".$row["customer_id"]."')\" style='float:right;margin:5px;'><span class='material-icons'>info</span></button>
                                    <br><span style='font-weight:normal;'>". dw3_decrypt($row["retailer_name"]) . " (".$row["retailer_city"].")</span>
                                </div>	";
                        } else {
                            $html .="<div class='dw3_box' style='min-height:20px;'><b>Retailer</b>:<button class='blue' onclick=\"getRET_ADS('".$row["customer_id"]."')\" style='float:right;margin:5px;'><span class='material-icons'>info</span></button>
                                    <br><span style='font-weight:normal;'>". $row["retailer_company"] . " (".$row["retailer_city"].")</span>
                                </div>	";              
                        }
                    } 
                  
                  if ($row["recommended"] != ""){
                    $html .="<hr>";
                    if($USER_LANG == "FR"){
                        $html .= "Produits recommendés:<br>";
                    } else {
                        $html .= "Recommended products:<br>";
                    }
                    $sql2 = "SELECT A.* FROM classified A WHERE id IN (" . $row["recommended"] . ") LIMIT 5";
                    $result2 = $dw3_conn->query($sql2);
                    if ($result2->num_rows > 0) {		
                        while($row2 = $result2->fetch_assoc()) {
                            $RNDSEQ=rand(100,100000);
                            $filename= $row2["img_link"];
                            if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename)){
                                $filename = "/pub/img/dw3/nd.png";
                            } else {
                                if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename)){
                                    $filename = "/pub/img/dw3/nd.png";
                                }else{
                                    $filename = "/fs/customer/" . $row["customer_id"] . "/" . $filename;
                                }
                            }
                            $html .="<div class='dw3_box' style='min-height:20px;cursor:pointer;max-width:125px;text-align:center;' onclick=\"getAD('" . $row2["id"]  . "');\">
                                        <img style='width:100px;height:auto;box-shadow: 2px 2px 3px 1px rgba(0, 0, 0, 0.35);' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"./img/dw3/nd.png\";' alt='Image du produit: ". $row["name_fr"] . "'>
                                        <br><strong>";
                            if($USER_LANG == "FR"){
                                $html .= $row2["name_fr"];
                            } else {
                                $html .= $row2["name_en"];
                            }
                            $html .= "</strong>
                                    </div>";	
                        }
                    }			
                }

            //actions
            $html .= "</div>";				
				$html .= "<div class='dw3_form_foot' style='min-width:300px;vertical-align:middle!important;text-align:center;'>";
                if($USER_LANG == "FR"){
                    if ($display_mode == "DISPLAY"){
                        $html .= "<button class='no-effect' onclick=\"dw3_editor_close();\" style='min-height:45px;margin-left:0px;border-bottom-right-radius:10px;padding:2px 7px;'><span style='width:92px;'>Fermer</span> <span class='material-icons' style='font-size:24px;vertical-align:middle;'>cancel</span></button>";
                    } else {
                        $html .= "<button class='no-effect' onclick=\"buyAD('" . $row["id"]  . "');\" style='min-height:45px;margin-left:0px;border-bottom-right-radius:10px;padding:2px 7px;'><span style='width:92px;'>Ajouter</span> <span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span></button>";
                    }
                } else {
                    if ($display_mode == "DISPLAY"){
                        $html .= "<button class='no-effect' onclick=\"dw3_editor_close();\" style='min-height:45px;margin-left:0px;border-bottom-right-radius:10px;padding:2px 7px;'><span style='width:92px;'>Close</span> <span class='material-icons' style='font-size:24px;vertical-align:middle;'>cancel</span></button>";
                    } else {
                        $html .= "<button class='no-effect' onclick=\"buyAD('" . $row["id"]  . "');\" style='min-height:45px;margin-left:0px;border-bottom-right-radius:10px;padding:2px 7px;'><span style='width:92px;'>Add</span> <span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span></button>";
                    }
                } 
                if ($INDEX_WISH=="true"){
                    $is_wished = false;
                    foreach ($dw3_wish as $key=>$val){
                        //$dw3_ad_string .= substr($key,6,strlen($key)-6) . ",";
                        if (intval($dw3_wish[$key]) > 0 && substr($key,0,5)=="WISH2" && substr($key,6,strlen($key)-6) == $row["id"]){
                            $is_wished = true;
                        }
                    }
                    if ($is_wished == true){
                        //$html .= "<button class='no-effect' style='position:absolute;left:0px;height:44px;border-bottom-left-radius:15px;' onclick='dw3_wish2_toogle(".$row["id"].");'><span id='dw3_wish2_".$row["id"]."' class='material-icons'>favorite</span></button>";
                        $html .= "<button class='no-effect' style='position:absolute;left:0px;height:44px;border-bottom-left-radius:15px;' onclick='dw3_wish2_toogle(".$row["id"].");'><span id='dw3_wish2_".$row["id"]."' class='dw3_font' style='font-size:24px;'>Q</span></button>";
                    } else {
                        $html .= "<button class='no-effect' style='position:absolute;left:0px;height:44px;border-bottom-left-radius:15px;' onclick='dw3_wish2_toogle(".$row["id"].");'><span id='dw3_wish2_".$row["id"]."' class='dw3_font' style='font-size:24px;'>R</span></button>";
                    }
                }
            $html .= "</div>";
		}
	}else{
        //$html .= $sql;
        $html .= "Error on classified #".$addID;
    }
$dw3_conn->close();
header('Status: 200');
die($html);
?>
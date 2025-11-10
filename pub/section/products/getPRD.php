<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';

if($USER_LANG == "FR"){
    $lbl1 = "Prix en promotion";
    $lbl2 = "Valide jusqu'au";
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
}else{
    $lbl1 = "Promotional price";
    $lbl2 = "Valid until";
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
}

$prID  = $_GET['P'];

$dw3_wish=array();
foreach ($_COOKIE as $key=>$val){
  if (substr($key, 0, 5) == "WISH_"){
    $dw3_wish[$key] = intval($dw3_wish[$key]??0) + intval($val);
  }
}
$html = "";
	$sql = "SELECT A.*, IFNULL(B.total,0) AS invTOT,IFNULL(C.name_fr,'') AS cat1_fr,IFNULL(C.name_en,'') AS cat1_en,IFNULL(D.name_fr,'') AS cat2_fr,IFNULL(D.name_en,'') AS cat2_en,IFNULL(E.name_fr,'') AS cat3_fr,IFNULL(E.name_en,'') AS cat3_en,IFNULL(F.company_name,'') AS supplier_name
            FROM product A 
            LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) B ON A.id = B.product_id
            LEFT JOIN (SELECT id, name_fr, name_en FROM product_category) C ON C.id = A.category_id
            LEFT JOIN (SELECT id, name_fr, name_en FROM product_category) D ON D.id = A.category2_id
            LEFT JOIN (SELECT id, name_fr, name_en FROM product_category) E ON E.id = A.category3_id
            LEFT JOIN (SELECT id, company_name FROM supplier) F ON F.id = A.supplier_id
            WHERE A.id = " . $prID . " LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
            //$filenames[] = asort(dw3_dir_to_array($_SERVER['DOCUMENT_ROOT'] ."/product/" .$row["id"] . "/"));
            $filenames = []; //asort(dw3_dir_to_array($_SERVER['DOCUMENT_ROOT'] ."/product/" .$row["id"] . "/"));
            $gal3names = []; 
            $folder=scandir($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" .$row["id"] . "/");
            foreach($folder as $file) {
                if (!is_dir($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $file) && $file != "." && $file != ".."){
                    $filenames[] = $file;
                    $gal3names[] = "/fs/product/".$row["id"]."/" .$file;
                }
            }
            $filename= $row["url_img"];
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                $filename = "/pub/img/dw3/nd.png";
            } else {
                if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                    $filename = "/pub/img/dw3/nd.png";
                }else{
                    $filename = "/fs/product/" . $row["id"] . "/" . $filename;
                }
            }

            if($USER_LANG == "FR"){ 
                $trad_name = $row["name_fr"]; 
            }else{
                $trad_name = $row["name_en"]; 
            }
            //if(count($filenames)>0 && $filename ==""){
              //  $filename =  "/" . $row["id"] . "/" . $filenames[0];
           // }else{
            //    $filename = "/img/nd.png";
            //}  
			$html .= "<div class='dw3_form_head' id='dw3_editor_HEAD' style='min-width:300px;'>
                        <h3 style='vertical-align:middle;height:40px;font-size:1em;'><div style='display: grid;align-items: center;height:40px;'>".$trad_name."</div></h3>
                        <button class='dw3_form_close no-effect white' onclick='dw3_editor_close();' style='padding:6px 6px 5px 5px;'><span class='dw3_font' style='font-size:20px;'>ď</span></button>
                    </div>
                    <div class='dw3_form_data' style='background:rgba(255,255,255,0.7);color:#333;min-width:300px;transition: height 0.3s linear;'>";
            
                //files
                    $html .="<img onclick=\"var gal3_images_array = ['".implode("','",$gal3names)."'];dw3_gal3_show(gal3_images_array,'imgPRD','".$trad_name."')\" id='imgPRD' alt='".$trad_name."' class='dw3_image_view' src='" . $filename . "' onerror='this.onerror=null; this.src=\"/img/dw3/nd.png\";'>";                
                    //$html .="<img onclick='toogleImageView()' id='imgPRD' class='dw3_image_view' src='" . $filename . "' onerror='this.onerror=null; this.src=\"/img/dw3/nd.png\";'>";                
                        if(count($filenames)>1){
                            $html .= "<div class='dw3_section'>";
                            foreach($filenames as $file) {
                                   $html .= "<img onclick=\"dw3_change_image('/fs/product/".$row["id"]."/" . $file . "','imgPRD')\" style='cursor:pointer;box-shadow: 1px 1px 4px 2px #555;border:0px;margin:0px 3px 5px 3px;height:50px;min-width:50px;width:auto;max-width:90px;' src='/fs/product/".$row["id"]."/" . $file . "'>";
                            }
                            $html .= "</div>";
                        }
                        $html .= "<br>";
        //INFORMNATIONS GÉNÉRALES
        if($USER_LANG == "FR" && $row["description_fr"] != ""){
            $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;width:90%;max-width:90%;font-weight:normal;'>" . $row["description_fr"] . "</div>	";
        }else if($USER_LANG != "FR" && $row["description_en"] != ""){
            $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;width:90%;max-width:90%;font-weight:normal;'>" . $row["description_en"] . "</div>	";
        }
        //INFORMNATIONS DE DATAIA
        if($USER_LANG == "FR" && $row["desc_dataia_fr"] != ""){
            $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;width:90%;max-width:90%;font-weight:normal;'>" . $row["desc_dataia_fr"] . "</div>	";
        }
/*         $plitted = explode(".",$row["price1"]);
        $whole = $plitted[0]??$row["price1"];
        $fraction = $plitted[1]??0; 
        if ($fraction == 0){
            $fraction = ".00";
        }else{
            $fraction = ".".str_pad(rtrim($fraction, "0"), 2 , "0");
        } */

        //CATEGORIES
        if($USER_LANG == "FR" && $row["cat1_fr"] != ""){ 
            $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;width:90%;max-width:90%;font-weight:normal;'><b>Catégorie</b>: " . $row["cat1_fr"] . "</div>	";
        }else if($USER_LANG == "EN" && $row["cat1_en"] != ""){
            $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;width:90%;max-width:90%;font-weight:normal;'><b>Category</b>: " . $row["cat1_en"] . "</div>	";
        }
        if($USER_LANG == "FR" && $row["cat2_fr"] != ""){ 
            $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;width:90%;max-width:90%;font-weight:normal;'><b>Catégorie secondaire</b>: " . $row["cat2_fr"] . "</div>	";
        }else if($USER_LANG == "EN" && $row["cat2_en"] != ""){
            $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;width:90%;max-width:90%;font-weight:normal;'><b>Second category</b>: " . $row["cat2_en"] . "</div>	";
        }
        if($USER_LANG == "FR" && $row["cat3_fr"] != ""){ 
            $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;width:90%;max-width:90%;font-weight:normal;'><b>Catégorie tertiaire</b>: " . $row["cat3_fr"] . "</div>	";
        }else if($USER_LANG == "EN" && $row["cat3_en"] != ""){
            $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;width:90%;max-width:90%;font-weight:normal;'><b>Third category</b>: " . $row["cat3_en"] . "</div>	";
        }

        //SUPPLIER 
        if($USER_LANG == "FR" && $row["supplier_name"] != "" && $INDEX_DSP_SUPPLIER == "true"){ 
            $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;width:90%;max-width:90%;font-weight:normal;'><b>Fournisseur</b>: " . $row["supplier_name"] . "</div>	";
        }else if($USER_LANG == "EN" && $row["supplier_name"] != "" && $INDEX_DSP_SUPPLIER == "true"){
            $html .="<div class='dw3_box' style='line-height:1.3em;background:rgba(255,255,255,0.7);color:#222;width:90%;max-width:90%;font-weight:normal;'><b>Supplier</b>: " . $row["supplier_name"] . "</div>	";
        }


        if($USER_LANG == "FR"){
            if ($row["price_text_fr"] ==""){				
/*                     $html .="<div class='dw3_box' style='min-height:20px;'><b>Prix avant taxes</b>:
                    <span style='float:right;'>". number_format($whole) . "<sup>" . $fraction . "</sup></span>
                </div>	"; */
            } else if (trim($row["price_text_fr"]) != ""){
                $html .="<div class='dw3_box' style='min-height:20px;text-align:center;'>
                " . $row["price_text_fr"] . "
                </div>	";    
            }
        } else {
            if ($row["price_text_en"] ==""){				
 /*                $html .="<div class='dw3_box' style='min-height:20px;'><b>Price before taxes</b>:
                    <span style='float:right;'>". number_format($whole) . "<sup>" . $fraction . "</sup></span>
                </div>	"; */
            }else if (trim($row["price_text_en"]) != ""){
                $html .="<div class='dw3_box' style='min-height:20px;text-align:center;'>
                " . $row["price_text_en"] . "
                </div>	";    
            }
        }
            if ($row["qty_min_price2"] > 0){
                if($USER_LANG == "FR"){
                    $html .="<div class='dw3_box' style='min-height:20px;'><b>Quantité minimum pour Prix 2*</b>:
                        " . $row["qty_min_price2"] . "
                    </div>	
                    <div class='dw3_box' style='min-height:20px;'><b>Prix 2 avant taxes</b>: 
                        " . round($row["price2"],2)  .  $row["price_suffix_fr"] . "

                    </div>";
                }else{
                    $html .="<div class='dw3_box' style='min-height:20px;'><b>Minimum quantity for Price 2*</b>:
                        " . $row["qty_min_price2"] . "
                    </div>	
                    <div class='dw3_box' style='min-height:20px;'><b>Price 2 before taxes</b>: 
                        " . round($row["price2"],2)  .  $row["price_suffix_en"] . "

                    </div>";
                }
            }
                       
                $date_promo = new DateTime($row["promo_expire"]);
                $now = new DateTime();
                if($date_promo > $now) {
                    $html .="<div class='dw3_box' style='min-height:20px;'>".$lbl1.": <b>". $row["promo_price"].$row["price_suffix_fr"] ."</b>" ;
                    $html .="<span style='color:gold;text-shadow:1px 1px 2px goldenrod;'><span>&#10024;</span></span>
                                <div style='display:block;'>".$lbl2.": <b>
                                 " . substr($row["promo_expire"],0,10) . "</b></div>
                            </div><br>";
                }
                if ($row["price1"] > 0){  
                    $html .= "<br><div class='dw3_box' style='min-height:20px;'><div style='position:absolute;width:340px;display:inline-block;vertical-align:middle;'>
                        <b>".$lbl3."</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            "; if ($row["tax_fed"] == true){ $html .= $lbl11; }else { $html .= $lbl12 ;} $html .= "
                        </div>
                    </div>				
                    <div class='dw3_box' style='min-height:20px;'><div style='position:absolute;width:340px;;display:inline-block;vertical-align:middle;'>
                    <b>".$lbl4."</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                        "; if ($row["tax_prov"] == true){ $html .= $lbl11; }else { $html .= $lbl12;} $html .= "
                        </div>
                    </div>";
                }
                if ($row["consigne"] > 0){
                    $html .= "<div class='dw3_box' style='min-height:20px;'><b>Consigne</b>:
                                " . $row["consigne"] . "$
                            </div>";	
                }
                  //technique   
                  if ($row["dsp_upc"] > 0){   
                    $html .= " <div class='dw3_box' style='min-height:20px;'><b>UPC</b>:
                                " . $row["upc"] . "
                            </div>";
                  }
                  if ($row["dsp_inv"] == 1 && $row["qty_max_by_inv"] == 1){
                    $html .= "<div class='dw3_box' style='min-height:20px;'>" . $lbl17  . ":
                                <div style='float:right;padding-right:5px;vertical-align:middle;'><b>" . $row["invTOT"] . "</b></div>
                            </div>";
                    $html .= "<div class='dw3_box' style='min-height:20px;'>
                    <div style='position:absolute;width:340px;display:inline-block;vertical-align:middle;'>
                    <b>".$lbl10."</b>:</div>
                    <div style='float:right;padding-right:5px;vertical-align:middle;'>
                        "; if ($row["mag_dsp"] == true){ $html .= $lbl11; }else{$html .= $lbl12; } $html .= "
                    </div>
                </div>";
                  }	
/*                   if ($row["dsp_mesure"] > 0){
                    $html .= "<div class='dw3_box' style='min-height:20px;'>Pack<b>
                        " . $row["pack"] . "</b> " . $row["pack_desc"] ."
                    </div>";
                  }	 */
                  if ($row["dsp_export_storage"] > 0){
                    $html .="<div class='dw3_box' style='min-height:20px;'><b>".$lbl5." </b>:
                                " . $row["export_storage_id"] . "
                            </div>";
                  }     
                  if ($row["dsp_model"] > 0){			
                   $html .="<div class='dw3_box' style='min-height:20px;'><b>".$lbl6."</b>:
                        <div style='float:right;padding-right:5px;vertical-align:middle;'><b>" . $row["brand"] . "</b></div>
                    </div>				
                    <div class='dw3_box' style='min-height:20px;'><b>".$lbl7."</b>:
                        <div style='float:right;padding-right:5px;vertical-align:middle;'><b>" . $row["model"] . "</b></div>
                    </div>				
                    <div class='dw3_box' style='min-height:20px;'><b>".$lbl8."</b>:
                        <div style='float:right;padding-right:5px;vertical-align:middle;'><b>" . $row["model_year"] . "</b></div>
                    </div>";
                  }
                  if ($row["is_bio"] > 0){
                    $html .="<div class='dw3_box' style='min-height:20px;'>
                        <div style='position:absolute;width:340px;display:inline-block;cursor:pointer;vertical-align:middle;'>
                        <b>Bio</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input disabled id='prIS_BIO' type='checkbox' style='margin-top:5px;'"; if ($row["is_bio"] == true){ $html .= " checked"; } $html .= ">
                        </div>
                    </div>";				
                  }
                  if ($row["dsp_mesure"] > 0){
                    if ($row["kg"] > 0){
                        $html .="<div class='dw3_box' style='min-height:20px;'>" . $lbl16  . ":";
                        if ($row["kg"] < 1){
                            $html .="<div style='float:right;padding-right:5px;vertical-align:middle;'><b>" . number_format($row["kg"]*1000). "g</b></div>";
                        }else{
                            $html .="<div style='float:right;padding-right:5px;vertical-align:middle;'><b>" . round($row["kg"],1). "kg</b></div>";
                        }
                        $html .="</div>	";
                    }
                    if ($row["liter"] > 0){
                    $html .="<div class='dw3_box' style='min-height:20px;'>Volume:";
                        if ($row["liter"] < 1){
                            $html .="<div style='float:right;padding-right:5px;vertical-align:middle;'><b>" . number_format($row["liter"]*1000) . "ml</b></div>";
                        } else {
                            $html .="<div style='float:right;padding-right:5px;vertical-align:middle;'><b>" . round($row["liter"],1) . "L</b></div>";
                        }
                    $html .="</div>	";	
                    }
                    if ($row["height"] > 0){
                    $html .="<div class='dw3_box' style='min-height:20px;'>" . $lbl13  . ":";
                    $html .="<div style='float:right;padding-right:5px;vertical-align:middle;'><b>" . number_format($row["height"]) . "cm</b></div>";
                    $html .="</div>	";	
                    }
                    if ($row["width"] > 0){
                        $html .="<div class='dw3_box' style='min-height:20px;'>" . $lbl14  . ":";
                        $html .="<div style='float:right;padding-right:5px;vertical-align:middle;'><b>" . number_format($row["width"]) . "cm</b></div>";
                        $html .="</div>";
                    }
                    if ($row["depth"] > 0){
                        $html .="<div class='dw3_box' style='min-height:20px;'>" . $lbl15  . ":";
                        $html .="<div style='float:right;padding-right:5px;vertical-align:middle;'><b>" . number_format($row["depth"]) . "cm</b></div>";
                        $html .="</div>	";           
                    }
                  }

        //bouton actions
                    $html .= "</div>";				
				$html .= "<div class='dw3_form_foot' style='min-width:300px;vertical-align:middle!important;'>";
                switch ($row["btn_action1"]) {
                    case "DOWNLOAD":
                        $ACTION = 'dw3_download("' . $row["id"]  . '","' . $row["url_action1"]  . '",this);';
                        break;
                    case "SUBMIT":
                        $ACTION = 'dw3_action_submit(' . $row["id"]  . ',this);';
                        break;
                    case "CART":
                        $ACTION = "dw3_cart_add(" . $row["id"]  . ",this);";
                        break;
                    case "LINK":
                        if (substr($row["url_action1"],0,1)== "/"){
                            $ACTION = "dw3_page_open(\"" . $row["url_action1"]  . "\",\"_self\");";
                        } else {
                            $ACTION = "dw3_page_open(\"" . $row["url_action1"]  . "\",\"_blank\");";
                        }
                        break;
                    case "BUY":
                        $ACTION = "dw3_buy(" . $row["id"]  . ",this);";
                        break;
                    case "SUBSCRIBE":
                        $ACTION = "dw3_subscribe(" . $row["id"]  . ",this);";
                        break;
                    default:
                        $ACTION = "";
                }
        //bouton info
                if ($row["btn_action1"] != "NONE" && $row["btn_action1"] != "" && $row["btn_action1"] != "WISH"){
                    $is_service = true;
                    if ($row["billing"] == "FINAL" || $row["billing"] == "LOCATION"){
                        $is_service = false;
                    }
                    if ($row["invTOT"] <= 0 && $row["qty_max_by_inv"] == 1 && $row["btn_action1"] == "CART" && $is_service == false){
                        if($USER_LANG == "FR"){
                            $html .= "<button class='no-effect' disabled style='border-bottom-right-radius:10px;'><span style='font-size:1em;vertical-align:middle;color:orange;'>&#10071;</span> Rupture de stock</button>";
                        } else{
                            $html .= "<button class='no-effect' disabled style='border-bottom-right-radius:10px;'><span style='font-size:1em;vertical-align:middle;color:orange;'>&#10071;</span> Out of stock</button>";
                        }
                    }else{
                        if($USER_LANG == "FR"){
                            $html .= "<button class='no-effect' style='' onclick='" . $ACTION . "'>" . $row["web_btn_fr"] . " <span class='dw3_font' style='font-size:1em;vertical-align:middle;'>" . $row["web_btn_icon"] . "</span></button>";
                        }else{
                            $html .= "<button class='no-effect' style='' onclick='" . $ACTION . "'>" . $row["web_btn_en"] . " <span class='dw3_font' style='font-size:1em;vertical-align:middle;'>" . $row["web_btn_icon"] . "</span></button>";
                        }
                    }
                } else {
                    if($USER_LANG == "FR"){
                        $html .= "<button class='grey no-effect' style='' onclick='dw3_editor_close();'><span>&#10062;</span> Fermer</button>";
                    }else{
                        $html .= "<button class='grey no-effect' style='' onclick='dw3_editor_close();'><span>&#10062;</span> Close</button>";
                    }
                }
            if ($INDEX_WISH=="true" || $row["btn_action1"]=="WISH"){
                $is_wished = false;
                foreach ($dw3_wish as $key=>$val){
                    if (intval($dw3_wish[$key]) > 0 && substr($key,0,5)=="WISH_" && ltrim($key,"WISH_") == $row["id"]){
                        $is_wished = true;
                    }
                }
                if ($is_wished == true){
                    //$html .= "<button class='no-effect' style='position:absolute;left:0px;margin:2px 0px 0px 2px;border-bottom-left-radius:15px;' onclick='dw3_wish_toogle(".$row["id"].");'><img id='dw3_wish_".$row["id"]."' src='https://".$_SERVER["SERVER_NAME"]."/pub/img/dw3/fav_full.png' style='width:15px;height:15px;'></button>";
                    $html .= "<button class='no-effect' style='position:absolute;left:0px;margin:2px 0px 0px 1px;padding:4px;border-bottom-left-radius:15px;' onclick='dw3_wish_toogle(".$row["id"].");'><span id='dw3_wish_".$row["id"]."' class='dw3_font' style='font-size:24px;'>Q</span></button>";
                } else {
                    //$html .= "<button class='no-effect' style='position:absolute;left:0px;margin:2px 0px 0px 2px;border-bottom-left-radius:15px;' onclick='dw3_wish_toogle(".$row["id"].");'><img id='dw3_wish_".$row["id"]."' src='https://".$_SERVER["SERVER_NAME"]."/pub/img/dw3/fav.png' style='width:15px;height:15px;'></button>";
                    $html .= "<button class='no-effect' style='position:absolute;left:0px;margin:2px 0px 0px 1px;padding:4px;border-bottom-left-radius:15px;' onclick='dw3_wish_toogle(".$row["id"].");'><span id='dw3_wish_".$row["id"]."' class='dw3_font' style='font-size:24px;'>R</span></button>";
                }
            }
            $html .= "</div>";
		}
        $sqlx = "UPDATE product SET qty_visited = qty_visited +1  WHERE id = '" . $prID . "' LIMIT 1";
        $resultx = mysqli_query($dw3_conn, $sqlx);
        
	}else{
        $html .= "Error on product#";
    }
$dw3_conn->close();
header('Status: 200');
die($html);
?>
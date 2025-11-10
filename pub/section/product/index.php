<?php 
$prID  = $_GET['prID'];
$html = "";
	$sql = "SELECT *
			FROM product 
			WHERE id = " . $prID . "
			LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
            //$filenames[] = asort(dw3_dir_to_array($_SERVER['DOCUMENT_ROOT'] ."/product/" .$row["id"] . "/"));
            $filenames = []; //asort(dw3_dir_to_array($_SERVER['DOCUMENT_ROOT'] ."/product/" .$row["id"] . "/"));
            $folder=scandir($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" .$row["id"] . "/");
            foreach($folder as $file) {
                if (!is_dir($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $file) && $file != "." && $file != ".."){
                    $filenames[] = $file;
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


            //if(count($filenames)>0 && $filename ==""){
              //  $filename =  "/" . $row["id"] . "/" . $filenames[0];
           // }else{
            //    $filename = "/img/nd.png";
            //}  
			$html .= "<div class='dw3_form_head' style='color:#".$CIE_COLOR4.";background-color:#".$CIE_COLOR3.";'>
                        <h2><b>". $row["name_fr"] ."</b></h2>
                        <button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
                    </div>
                    <div class='dw3_form_data'><img id='imgPRD' style='position:absolute;top:0px;left:0px;z-index:-1;width:100%;height:auto;' src='" . $filename . "' onerror='this.onerror=null; this.src=\"/img/dw3/nd.png\";'>";
            
                //files
                    $html .= "<div class='dw3_section'>";
                        if(count($filenames)>=1){
                            foreach($filenames as $file) {
                                if ($row["url_img"] == $file){
                                   $html .= "<button class='image' style='box-shadow: inset 1px 1px 25px goldenrod;margin:0px 3px 0px 3px;color:#111;text-shadow: 1px 1px #1baff3;height:100px;width:auto;min-width:100px;max-width:300px;background-image: url(\"/fs/product/".$row["id"]."/" . $file . "\");'><span style='background:rgba(255,255,255,0.7);padding:3px;border-radius:3px;margin-top:75px;'>" . $file . "</span></button>";
                                } else {
                                   $html .= "<button class='image' style='margin:0px 3px 0px 3px;color:#111;text-shadow: 1px 1px #1baff3;height:100px;width:auto;min-width:100px;max-width:300px;background-image: url(\"/fs/product/".$row["id"]."/" . $file . "\");'><span style='background:rgba(255,255,255,0.7);padding:3px;border-radius:3px;margin-top:75px;'>" . $file . "</span></button>";
                                }
                            }
                        }
                $html .= "</div>";
        //INFORMNATIONS GÉNÉRALES
                $html .= "<div class='dw3_box' style='min-height:25px;'><div style='padding:5px;position:absolute;width:340px;;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prTAX_FED\").focus();document.getElementById(\"prTAX_FED\").click();'>
                            <b>Ramassage en magasin</b>:</div>
                            <div style='float:right;padding-right:5px;vertical-align:middle;'>
                                <input id='prPICKUP' disabled type='checkbox' style='margin-top:5px;'"; if ($row["allow_pickup"] == true){ $html .= " checked"; } $html .= ">
                            </div>
                        </div>";
                        if ($row["price_text_fr"] ==""){				
                                $html .="<div class='dw3_box'><b>Prix avant taxes</b>:
                            " . $row["price1"] . " " .  $row["price_suffix_fr"] . "
                            </div>	";
                        }else{
                            $html .="<div class='dw3_box'><b>
                            " . $row["price_text_fr"] . "</b>
                            </div>	";    
                        }
                        if ($row["qty_min_price2"] > 0){
                        $html .="<div class='dw3_box'><b>Quantité minimum pour prix 2*</b>:
                            " . $row["qty_min_price2"] . "

                        </div>	
                        <div class='dw3_box'><b>Prix avant taxes</b>: 
                            " . $row["price2"] . "
  
                        </div>";
                        }
                       
                        $date_promo = new DateTime($row["promo_expire"]);
                        $now = new DateTime();
                        
                        if($date_promo < $now) {
                            $html .="<div class='dw3_box'><b>Prix en promotion</b>:". $row["promo_price"] ;
                           $html .="<span style='color:gold;text-shadow:1px 1px 2px goldenrod;'><span class='material-icons'>new_releases</span> Active!</span>
                                        Jusqu'à:
                                        <input disabled type='datetime-local' value='" . $row["promo_expire"] . "'>
                                    </div><br>";
                        }
                        $html .= "<div class='dw3_box' style='min-height:25px;'><div style='padding:5px;position:absolute;width:340px;;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prTAX_FED\").focus();document.getElementById(\"prTAX_FED\").click();'>
                            <b>Taxes fédérales</b>:</div>
                            <div style='float:right;padding-right:5px;vertical-align:middle;'>
                                <input disabled type='checkbox' style='margin-top:5px;'"; if ($row["tax_fed"] == true){ $html .= " checked"; } $html .= ">
                            </div>
                        </div>				
                        <div class='dw3_box' style='min-height:25px;'><div style='padding:5px;position:absolute;width:340px;;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prTAX_PROV\").focus();document.getElementById(\"prTAX_PROV\").click();'>
                        <b>Taxes provinciales:</div>
                            <div style='float:right;padding-right:5px;vertical-align:middle;'>
                                <input disabled type='checkbox' style='margin-top:5px;'"; if ($row["tax_prov"] == true){ $html .= " checked"; } $html .= ">
                            </div>
                        </div>";
                        if ($row["consigne"] > 0){
                            $html .= "<div class='dw3_box'><b>Consigne</b>:
                                       " . $row["consigne"] . "$
                                    </div>";	
                        }
                  //technique   
                  if ($row["dsp_upc"] > 0){   
                    $html .= " <div class='dw3_box'><b>UPC</b> / Code barre:
                                " . $row["upc"] . "
                            </div>";
                  }
                  if ($row["dsp_mesure"] > 0){
                    $html .= "<div class='dw3_box'><b>
                        " . $row["pack"] . "</b> " . $row["pack_desc"] ."
                    </div>";
                  }	
                  if ($row["dsp_export_storage"] > 0){
                    $html .="<div class='dw3_box'><b>Allée </b>:
                                " . $row["export_storage_id"] . "
                            </div>";
                  }     
                  if ($row["dsp_model"] > 0){			
                   $html .="<div class='dw3_box'><b>Fabriquant</b>:
                        <input id='prBRAND' type='text' value='" . $row["model_year"] . "'>
                    </div>				
                    <div class='dw3_box'><b># de Modèle</b>:
                        <input id='prMODEL' type='text' value='" . $row["model_year"] . "'>
                    </div>				
                    <div class='dw3_box'><b>Année du modèle</b>:
                        <input id='prMODEL_YEAR' type='number' value='" . $row["model_year"] . "'>
                    </div>"
                  }
                  if ($row["is_bio"] > 0){
                    $html .="<div class='dw3_box' style='min-height:25px;'>
                        <div style='padding:5px;position:absolute;width:340px;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById(\"prIS_BIO\").focus();document.getElementById(\"prIS_BIO\").click();'>
                        <b>Biologique</b>:</div>
                        <div style='float:right;padding-right:5px;vertical-align:middle;'>
                            <input disabled id='prIS_BIO' type='checkbox' style='margin-top:5px;'"; if ($row["is_bio"] == true){ $html .= " checked"; } $html .= ">
                        </div>
                    </div>";				
                  }
                  if ($row["dsp_mesure"] > 0){
                    if ($row["kg"] > 0){
                        $html .="<div class='dw3_box'><b>" . $dw3_lbl["KG"]  . "</b>(0.1 = 100g):
                            <input id='prKG' type='number' class='kg' value='" . $row["kg"]. "'>
                        </div>	";
                    }
                    if ($row["liter"] > 0){
                    $html .="<div class='dw3_box'><b>Litres</b> (0.1 = 100ml):
                        <input id='prLITER' type='number' value='" . $row["liter"] . "'>
                    </div>	";	
                    }
                    if ($row["height"] > 0){
                    $html .="<div class='dw3_box'><b>" . $dw3_lbl["HEIGHT"]  . "</b>:
                        " . $row["height"] . "cm
                    </div>	";	
                    }
                    if ($row["depth"] > 0){
                        $html .="<div class='dw3_box'><b>" . $dw3_lbl["DEPTH"]  . "</b>:
                            " . $row["depth"] . "cm
                        </div>	";           
                    }
                    if ($row["width"] > 0){
                        $html .="<div class='dw3_box'><b>" . $dw3_lbl["WIDTH"]  . "</b>:
                            " . $row["width"] . "cm
                        </div>";
                    }
                  }
        //actions
                    $html .= "<hr>
                    
                </div>";				
				$html .= "<div class='dw3_form_foot'>
			foot
            </div>";
		}
	}else{
        $html .= "# de produit introuvable.";
    }
header('Status: 200');
die($html);
?>
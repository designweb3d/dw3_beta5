<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
if ($CIE_STRIPE_MODE == "" || $CIE_STRIPE_MODE == "DEV"){
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_TKEY);
} else if ($CIE_STRIPE_MODE == "PROD"){
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
}

$ID             = $_GET['ID'];
$BILLING           = $_GET['BILLING'];
//$DESC  			= str_replace("'","’",str_replace("'","’",$_GET['DESC']));
//$DESC_EN  		= str_replace("'","’",str_replace("'","’",$_GET['DESC_EN']));
$NOM  			= str_replace("'","’",$_GET['NOM']);
$NOM_EN  		= str_replace("'","’",$_GET['NOM_EN']);
$DEPTH  		= str_replace("'","’",$_GET['DEPTH']);
$TAX_FED 		= $_GET['TAX_FED'];if ($TAX_FED=="false"){$TAX_FED=0;}else{$TAX_FED=1;}
$TAX_PROV 		= $_GET['TAX_PROV'];if ($TAX_PROV=="false"){$TAX_PROV=0;}else{$TAX_PROV=1;}
$TAX_VERTE 		= $_GET['TAX_VERTE'];
$MAG_DSP 		= $_GET['MAG_DSP'];if ($MAG_DSP=="false"){$MAG_DSP=0;}else{$MAG_DSP=1;}
$WEB_DSP 		= $_GET['WEB_DSP'];if ($WEB_DSP=="false"){$WEB_DSP=0;}else{$WEB_DSP=1;}
//$DSP_STATUS     = str_replace("'","’",$_GET['DSP_STATUS']);if ($DSP_STATUS=="false"){$DSP_STATUS=0;}else{$DSP_STATUS=1;}
$DSP_UPC 		= $_GET['DSP_UPC'];if ($DSP_UPC=="false"){$DSP_UPC=0;}else{$DSP_UPC=1;}
//$DSP_OPT		= str_replace("'","’",$_GET['DSP_OPT']);if ($DSP_OPT=="false"){$DSP_OPT=0;}else{$DSP_OPT=1;}
$DSP_INV 		= $_GET['DSP_INV'];if ($DSP_INV=="false"){$DSP_INV=0;}else{$DSP_INV=1;}
$IS_SCHEDULED 	= $_GET['IS_SCHEDULED'];if ($IS_SCHEDULED=="false"){$IS_SCHEDULED=0;}else{$IS_SCHEDULED=1;}
$WEB_BTN_FR  	= str_replace("'","’",$_GET['WEB_BTN_FR']);
$WEB_BTN_EN  	= str_replace("'","’",$_GET['WEB_BTN_EN']);
$WEB_BTN2_FR  	= str_replace("'","’",$_GET['WEB_BTN2_FR']);
$WEB_BTN2_EN  	= str_replace("'","’",$_GET['WEB_BTN2_EN']);
$WEB_BTN_ICON  	= str_replace("'","’",$_GET['WEB_BTN_ICON']);
$WEB_BTN2_ICON  	= str_replace("'","’",$_GET['WEB_BTN2_ICON']);
$UPC  			= str_replace("'","’",$_GET['UPC']);
$SKU  			= str_replace("'","’",$_GET['SKU']);
$URL_ACTION1  	  			= str_replace("'","’",$_GET['URL_ACTION1']);
$URL_ACTION2  	  			= str_replace("'","’",$_GET['URL_ACTION2']);
$BTN_ACTION1  	  			= str_replace("'","’",$_GET['BTN_ACTION1']);
$BTN_ACTION2 	  			= str_replace("'","’",$_GET['BTN_ACTION2']);
$QTY_MIN_SOLD 	  			= str_replace("'","’",$_GET['QTY_MIN_SOLD']);
$QTY_MAX_SOLD 	  			= str_replace("'","’",$_GET['QTY_MAX_SOLD']);
$STAT  			= $_GET['STAT'];
$PACK  			= $_GET['PACK'];
$STEP  			= $_GET['STEP'];
$SHIP 			= $_GET['SHIP'];
$PICKUP  			= $_GET['PICKUP'];
$PRIX_ACH  		= str_replace("'","’",$_GET['PRIX_ACH']);
$PRIX_VTE  		= str_replace("'","’",$_GET['PRIX_VTE']);
$PRIX_TRP  		= str_replace("'","’",$_GET['PRIX_TRP']);
$PRIX_TEXT      = str_replace("'","’",$_GET['PRIX_TEXT']);
$PRIX_TEXT_EN  	= str_replace("'","’",$_GET['PRIX_TEXT_EN']);
$PRIX_SUFFIX  	= str_replace("'","’",$_GET['PRIX_SUFFIX']);
$PRIX_SUFFIX_EN = str_replace("'","’",$_GET['PRIX_SUFFIX_EN']);
$JOURS_CONSERV  = $_GET['JRS_CNSRV'];
$SERV_LEN  = $_GET['SERV_LEN'];
$INTER_LEN  = $_GET['INTER_LEN'];
$KG  			= str_replace("'","’",$_GET['KG']);
$HEIGHT  		= str_replace("'","’",$_GET['HEIGHT']);
$WIDTH  		= str_replace("'","’",$_GET['WIDTH']);
$CAT  			= $_GET['CAT'];
$CAT2  			= $_GET['CAT2'];
$CAT3  			= $_GET['CAT3'];
$VTE2= str_replace("'","’",$_GET['VTE2']);   
$MIN2= str_replace("'","’",$_GET['MIN2']);   
$PROM_PRX= str_replace("'","’",$_GET['PROM_PRX']);    
$PROM_EXP= str_replace("'","’",$_GET['PROM_EXP']);   
$CNS= str_replace("'","’",$_GET['CNS']);   
$PACK_DSC= str_replace("'","’",$_GET['PACK_DSC']); 
$DSP_EXPORT= str_replace("'","’",$_GET['DSP_EXPORT']);     
$EXPORT= str_replace("'","’",$_GET['EXPORT']);     
$IMPORT= str_replace("'","’",$_GET['IMPORT']); 
$LT= str_replace("'","’",$_GET['LT']); 
$FAB= str_replace("'","’",$_GET['FAB']);  
$MOD= str_replace("'","’",$_GET['MOD']);  
$MOD_Y= str_replace("'","’",$_GET['MOD_Y']);
$QTY_MAX_BY_INV  =	$_GET['QTY_MAX_BY_INV'];if ($QTY_MAX_BY_INV=="false"){$QTY_MAX_BY_INV=0;}else{$QTY_MAX_BY_INV=1;}
$DSP_MESURE= $_GET['DSP_INV'];if ($DSP_MESURE=="false"){$DSP_MESURE=0;}else{$DSP_MESURE=1;}
$DSP_BRAND= $_GET['DSP_BRAND'];if ($DSP_BRAND=="false"){$DSP_BRAND=0;}else{$DSP_BRAND=1;}
$FRN1  			= $_GET['FRN1'];


//Verif
if ($UPC != ""){
    $sql = "SELECT COUNT(*) as counter FROM product
        WHERE trim(upc) = '" . trim($UPC)   . "' AND id <> '".$ID."';";
        $result = mysqli_query($dw3_conn, $sql);
        $data = mysqli_fetch_assoc($result);
        if ($data['counter'] > 0){
            //$dw3_conn->close();
            die ("Erreur: #UPC déjà utilisé.");
        }
}
//get product info before update to check if stripe price update
$sql = "SELECT * FROM product WHERE id = '".$ID."' LIMIT 1;";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

     $sql = "UPDATE product SET    
	 name_fr = '" . $NOM . "',
	 name_en = '" . $NOM_EN . "',
	 billing = '" . $BILLING . "',
	 ship_type = '" . $SHIP . "',
	 allow_pickup = '" . $PICKUP . "',
	 upc = '" . $UPC . "',	
     sku = '" . $SKU . "',
	 stat = '" . $STAT . "',
	 pack = '" . $PACK . "',
	 qty_step = '" . $STEP . "',
	 prod_cost = '" . $PRIX_ACH . "',
	 tax_verte = '" . $TAX_VERTE . "',
	 tax_fed = '" . $TAX_FED . "',
	 tax_prov = '" . $TAX_PROV . "',     
	 price1 = '" . $PRIX_VTE  	 . "',
     price2 = '" . $VTE2 . "',
     transport_supp = '" . $PRIX_TRP . "',
     qty_min_price2 = '" . $MIN2 . "',
     promo_price = '" . $PROM_PRX . "',
     promo_expire = '" . $PROM_EXP . "',
	 price_text_fr = '" . $PRIX_TEXT  . "',
	 price_text_en = '" . $PRIX_TEXT_EN  . "',
	 price_suffix_fr = '" . $PRIX_SUFFIX. "',
	 price_suffix_en = '" . $PRIX_SUFFIX_EN . "',
	 url_action1 = '" . $URL_ACTION1 . "',
	 url_action2 = '" . $URL_ACTION2  . "',
	 btn_action1 = '" . $BTN_ACTION1  . "',
	 btn_action2 = '" . $BTN_ACTION2  . "',
	 qty_min_sold = '" . $QTY_MIN_SOLD 	. "',
	 qty_max_sold = '" . $QTY_MAX_SOLD 	. "',
	 qty_max_by_inv = '" . $QTY_MAX_BY_INV . "',
	 web_btn_fr = '" . $WEB_BTN_FR . "',
	 web_btn_en = '" . $WEB_BTN_EN . "',
	 web_btn2_fr = '" . $WEB_BTN2_FR . "',
	 web_btn2_en = '" . $WEB_BTN2_EN . "',
	 web_btn_icon = '" . $WEB_BTN_ICON . "',
	 web_btn2_icon = '" . $WEB_BTN2_ICON . "',
	 depth = '" . $DEPTH . "',
	 mag_dsp = '" . $MAG_DSP. "',
	 web_dsp = '" . $WEB_DSP. "',
	 dsp_upc = '" . $DSP_UPC. "',
	 dsp_inv = '" . $DSP_INV . "',
	 is_scheduled = '" . $IS_SCHEDULED . "',
	 conservation_days = '" . $JOURS_CONSERV . "',
	 service_length = '" . $SERV_LEN . "',
	 inter_length = '" . $INTER_LEN . "',
	 kg = '" . $KG . "',
	 height = '" . $HEIGHT . "',
	 width = '" . $WIDTH . "',
	 category_id = '" . $CAT . "',
	 category2_id = '" . $CAT2 . "',
	 category3_id = '" . $CAT3 . "',
     supplier_id = '" . $FRN1 . "',
     consigne = '" . $CNS . "',
     pack_desc = '" . $PACK_DSC . "',
     dsp_export_storage = '" . $DSP_EXPORT . "',
     export_storage_id = '" . $EXPORT . "',
     import_storage_id = '" . $IMPORT . "',
     liter = '" . $LT . "',
     model = '" . $MOD . "',
     brand = '" . $FAB . "',
     model_year = '" . $MOD_Y . "',
     dsp_mesure = '" . $DSP_MESURE . "',
     dsp_model = '" . $DSP_BRAND . "', 
	 date_modified = '" . $datetime  . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";

    if ($dw3_conn->query($sql) === TRUE) {
        $filename= $data["url_img"];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $data["id"] . "/" . $filename)){
            $filename = "/pub/img/nd.png";
        } else {
            if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $data["id"] . "/" . $filename)){
                $filename = "/pub/img/nd.png";
            }else{
                $filename = "/fs/product/" . $data["id"] . "/" . $filename;
            }
        }
        $filename = ["https://" . $_SERVER["SERVER_NAME"] . $filename];
        error_log(print_r($filename,true));
        //check if price changed to update stripe price
        if ($data['price1'] != $PRIX_VTE || $data['billing'] != $BILLING){
            $upd_price = true;
        }else{
            $upd_price = false;
        }
        //taxes incluses dans prix stripe selon province
        $province_tx = $CIE_PROV;
        switch ($province_tx) {
            case "AB":case "Alberta":
                $PTPS = $TPS_AB;$PTVP = $TVP_AB;$PTVH = $TVH_AB;break;
            case "BC":case "British Columbia":
                $PTPS = $TPS_BC;$PTVP = $TVP_BC;$PTVH = $TVH_BC;break;
            case "QC":case "Quebec":case "Québec":
                $PTPS = $TPS_QC;$PTVP = $TVP_QC;$PTVH = $TVH_QC;break;
            case "MB":case "Manitoba":
                $PTPS = $TPS_MB;$PTVP = $TVP_MB;$PTVH = $TVH_MB;break;
            case "NB":case "New Brunswick":
                $PTPS = $TPS_NB;$PTVP = $TVP_NB;$PTVH = $TVH_NB;break;
            case "NT":
                $PTPS = $TPS_NT;$PTVP = $TVP_NT;$PTVH = $TVH_NT;break;
            case "NL":
                $PTPS = $TPS_NL;$PTVP = $TVP_NL;$PTVH = $TVH_NL;break;
            case "NS":case "Nova Scotia":
                $PTPS = $TPS_NS;$PTVP = $TVP_NS;$PTVH = $TVH_NS;break;
            case "NU":
                $PTPS = $TPS_NU;$PTVP = $TVP_NU;$PTVH = $TVH_NU;break;
            case "ON":case "Ontario":
                $PTPS = $TPS_ON;$PTVP = $TVP_ON;$PTVH = $TVH_ON;break;
            case "PE":
                $PTPS = $TPS_PE;$PTVP = $TVP_PE;$PTVH = $TVH_PE;break;
            case "SK":case "Saskatshewan":
                $PTPS = $TPS_SK;$PTVP = $TVP_SK;$PTVH = $TVH_SK;break;
            case "YT":case "Yukon":
                $PTPS = $TPS_YT;$PTVP = $TVP_YT;$PTVH = $TVH_YT;break;
        }
        if ($TAX_FED=='1'){
            $tps = round(((float)$PRIX_VTE/100)*$PTPS,2);
        } else {
            $tps = 0;
        }
        if ($TAX_FED=='1'){
            $tvp = round(((float)$PRIX_VTE/100)*$PTVP,2);
            $tvh = round(((float)$PRIX_VTE/100)*$PTVH,2);
        } else {
            $tvp = 0;
            $tvh = 0;
        }
        $price_tx = (float)$PRIX_VTE + $tvp + $tvh + $tps;
        //update stripe product
        $stripe_id = $data['stripe_id'];
        $stripe_price_id = $data['stripe_price_id'];
        if ($STAT == '0'){$is_active = true;}else{$is_active = false;}
        if($stripe_id != "" && $CIE_STRIPE_KEY != ""){
            try {
                if ($upd_price==true){
                    /* $stripe_result = $stripe->prices->create([
                        'unit_amount' => number_format($price_tx,2,"",""),
                        'currency' => 'cad',
                        'product' => $stripe_id,
                    ]); */
                    if ($BILLING =="MENSUEL"){
                        $stripe_result2 = $stripe->prices->create([
                            'unit_amount' => number_format($price_tx,2,"",""),
                            'currency' => 'cad',
                            'recurring' => ['interval' => 'month'],
                            'product' => $stripe_id,
                        ]);
                    } else if ($BILLING =="ANNUEL") {
                        $stripe_result2 = $stripe->prices->create([
                            'unit_amount' => number_format($price_tx,2,"",""),
                            'currency' => 'cad',
                            'recurring' => ['interval' => 'year'],
                            'product' => $stripe_id,
                        ]);
                    } else if ($BILLING =="HEBDO") {
                        $stripe_result2 = $stripe->prices->create([
                            'unit_amount' => number_format($price_tx,2,"",""),
                            'currency' => 'cad',
                            'recurring' => ['interval' => 'week'],
                            'product' => $stripe_id,
                        ]);
                    } else {
                        $stripe_result2 = $stripe->prices->create([
                            'unit_amount' => number_format($price_tx,2,"",""),
                            'currency' => 'cad',
                            'product' => $stripe_id,
                        ]);
                    }
                    $new_stripe_price_id = $stripe_result2->id;
                    $stripe_result3 = $stripe->products->update($stripe_id,[
                        'name' => trim($NOM),
                        'active' => $is_active,
                        'description' =>substr($data["description_fr"], 0, 100),
                        'images' => $filename,
                        'default_price' => $new_stripe_price_id ,
                        ]);
                      $sql = "UPDATE product
                      SET    
                      stripe_price_id   = '" .  $new_stripe_price_id . "'
                      WHERE id = '" . $ID . "' 
                      LIMIT 1";
                      if ($dw3_conn->query($sql) === TRUE) {
                          echo "";
                      } else {
                          echo $dw3_conn->error;
                      }
                      if ($stripe_price_id !=''){
                        $stripe_result2 = $stripe->prices->update($stripe_price_id,['active' => false]);
                      }
                      //$stripe_result2 = $stripe->plans->delete($stripe_price_id,[]);

                }else{
                    $stripe_result3 = $stripe->products->update($stripe_id,[
                        'name' => trim($NOM),
                        'active' => $is_active,
                        'description' => substr($data["description_fr"], 0, 100),
                        'images' => $filename
                        ]);
                }
            } catch (Error $e) {
                echo "Error Stripe: " . $e->getMessage();
            }
        }
        echo "";
	} else {
	    echo $dw3_conn->error;
	}
$dw3_conn->close();
die();
?>
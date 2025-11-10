<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';

if($USER_LANG == "FR"){
    $lbl1 = "Mon panier";
    $lbl2 = "Livraison GRATUITE avec une commande avant taxes de";
    $lbl3 = "$ et plus";
}else{
    $lbl1 = "My basket";
    $lbl2 = "FREE delivery with an order before taxes of";
    $lbl3 = "$ and more";
}

//CART
$coupon_valid = false;
$coupon_code = "";
$coupon_amount = "0";
$coupon_pourcent = "0";
$coupon_prd = "0";
$coupon_msg = "Le coupon est expiré.";
$coupon_saving = 0;

$dw3_cart_string = "";
$dw3_cart=array();
foreach ($_COOKIE as $key=>$val)
{
/*     if (substr($key, 0, 5) == "CART_" && $val != "0"){
    $dw3_cart[$key] = intval($dw3_cart[$key]??0) + intval($val);
    //echo "key: ". $key . "; dw3_cart[key]:".$dw3_cart[$key]. " ; value: ". $val. " calc=" . round($dw3_cart[$key] + $val);
    //$dw3_cart_string .= ltrim($key,"CART_") . ",";
    } */
    if ($key == "COUPON"){
        $coupon_code = $val;
    }
}

$sql = "SELECT * FROM coupon WHERE trim(code) = '" . trim($coupon_code) . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if (isset($data["id"])){
    $date_start = new DateTime($data["date_start"]);
    $date_end = new DateTime($data["date_end"]);
    $now = new DateTime();
    if ($date_start > $now){
        $coupon_msg = "Le coupon sera valide le ".substr($data['date_start'],0,10). " à " . substr($data['date_start'],11,8);
    } else if ($date_end < $now){
        $coupon_msg = "Le coupon a expiré le ".substr($data['date_end'],0,10) . " à " . substr($data['date_end'],11,8);
    } else {
        $coupon_valid = true;
        $coupon_msg = "Coupon validé.";
        $coupon_amount = $data['amount_val'];
        $coupon_pourcent = $data['pourcent_val'];
        $coupon_prd = $data['product_id'];
    }
}

/* foreach ($dw3_cart as $key=>$val)
{
    if (intval($dw3_cart[$key]) > 0){
        $dw3_cart_string .= ltrim($key,"CART_") . ",";
    }
}
$dw3_cart_string = rtrim($dw3_cart_string,","); */
$ship_required = false;
$taxable = 0;
$non_taxable = 0;
$wtotal = 0.00;
$stotal = 0.00;
$gtotal = 0.00;
$tot_tps = 0.00;
$tot_tvq = 0.00;
$transport = 0.00;

/* if ($dw3_cart_string != "") {  
    $sql = "SELECT  A.*, IFNULL(B.total,0) AS invTOT 
            FROM product A
            LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) B ON A.id = B.product_id
            WHERE stat = 0 AND web_dsp = 1 AND id IN (" . $dw3_cart_string . ") 
            ORDER BY price1 ASC, id DESC";
    //die($sql);
    $result = $dw3_conn->query($sql);
} */

$QTY_ROWS = 0;
$QTY_ROWS2 = 0;

    $sql_cart = "SELECT  * FROM cart_line WHERE device_id ='" . $USER_DEVICE . "' AND product_id IN( SELECT id FROM product WHERE stat = 0 AND web_dsp = 1) ORDER BY id ASC;";
    $result_cart = $dw3_conn->query($sql_cart);

    echo "<div class='dw3_form_head' id='dw3_cart_HEAD'>
    <h2 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>".$lbl1."</div></h2>
    <button class='white dw3_form_close no-effect' onclick='dw3_cart_close();' style='padding:5px;'><span class='dw3_font' style='font-size:20px;'>ď</span></button>
    </div>
        <div class='dw3_form_data' id='dw3_cart_DATA' style='background:#EEE;color:#333;'>";
        if($CIE_FREE_MIN !="" && $CIE_FREE_MIN!="0"){
            echo "<b>".$lbl2." ". $CIE_FREE_MIN . $lbl3."</b><br>";
        }
        
        $QTY_ROWS = $result_cart->num_rows??0;
        //echo $QTY_ROWS;
    if ($QTY_ROWS > 0) { 
        while($row_cart = $result_cart->fetch_assoc()) {
            $sql = "SELECT  A.*, IFNULL(B.total,0) AS invTOT FROM product A
            LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) B ON A.id = B.product_id
            WHERE stat = 0 AND web_dsp = 1 AND id ='" . $row_cart["product_id"] . "' LIMIT 1;";
            //echo $sql_cart;
            $result = $dw3_conn->query($sql);
            if ($result->num_rows > 0) { 
                while($row = $result->fetch_assoc()) {
                    $RNDSEQ=rand(100,100000);
                    $filename= $row["url_img"];
                    if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename) || trim($filename == "")){
                        $filename = "/pub/img/dw3/nd.png";
                    } else {
                        if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                            $filename = "/pub/img/dw3/nd.png";
                        }else{
                            $filename = "/fs/product/" . $row["id"] . "/" . $filename;
                        }
                    }
                    if ($row["ship_type"]!= ""){
                        $ship_required = true;
                    }
                    $is_tx_fed = false;
                    $is_tx_prov = false;
                    $line_tvq = 0.00;
                    $line_tps = 0.00;
                    $line_price = $row["price1"];
                    $line_qty = $row_cart["quantity"];

                    //prix2 remplacé par product_pack
                    /* if ($row["price2"] != 0 && $row["qty_min_price2"] > 1 && $line_qty >=$row["qty_min_price2"]){
                        $line_price = $row["price2"];
                    } */
                   $is_price_list = false;
                    //prix product_pack
                    $sql_inc_z = "SELECT  * FROM product_pack WHERE product_id ='" . $row["id"] . "' ORDER BY pack_qty ASC";
                    $result_inc_z = $dw3_conn->query($sql_inc_z);
                    if ($result_inc_z->num_rows> 0) { 
                        $is_price_list = true;
                        while($row_inc_z = $result_inc_z->fetch_assoc()) {
                            if ($line_qty >= $row_inc_z["pack_qty"]){
                                $line_price = $row_inc_z["pack_price"];
                            }
                        }
                    }
                    //prix promo
                    /* $date_promo = new DateTime($row["promo_expire"]);
                    $now = new DateTime();
                    if($date_promo > $now) {
                        $line_price = $row["promo_price"];
                    } */
                    $date_promo = new DateTime($row["promo_expire"]);
                    $now = new DateTime();
                    if($date_promo > $now && $line_price > $row["promo_price"] && $row["promo_price"] >= 0) {
                        $line_price = $row["promo_price"];
                    }
                    //verif si escompte produit du fournisseur x
                    /* if ($USER != ""){
                        $sqlx = "SELECT * FROM customer_discount WHERE customer_id = '".$USER."' AND supplier_id = '" . $row["supplier_id"] . "' AND supplier_id <> 0 LIMIT 1";
                        $resultx = mysqli_query($dw3_conn, $sqlx);
                        $datax = mysqli_fetch_assoc($resultx);
                        if (isset($datax["escount_pourcent"]) && $datax["escount_pourcent"] != 0){
                            $line_price = $line_price - (round($line_price*($datax["escount_pourcent"]/100),2));
                        }
                    } */
                   $customer_id = "0";
                       //escompte client / fournisseur
                    if (isset($USER) && $USER != "" && $USER_TYPE != "user" && $USER_TYPE != "nd"){
                        $customer_id = $USER;
                        $sql_inc_x = "SELECT * FROM customer_discount WHERE customer_id =  '".$customer_id."' AND supplier_id = '" . $row["supplier_id"] . "' AND supplier_id <> 0 LIMIT 1";
                        $result_inc_x = mysqli_query($dw3_conn, $sql_inc_x);
                        if ($result_inc_x->num_rows > 0) {
                            $data_inc_x = mysqli_fetch_assoc($result_inc_x);
                            if (isset($data_inc_x["escount_pourcent"]) && $data_inc_x["escount_pourcent"] != 0){
                                $discount_price = $line_price - (round($line_price*($data_inc_x["escount_pourcent"]/100),2));
                            } else {$discount_price = 0;}
                            if ($discount_price < $line_price && $discount_price > 0 && $line_price > $discount_price && $discount_price >= 0){
                                $line_price = $discount_price;
                            }
                        }
                    }

                    //options 
                    $sql2 = "SELECT * FROM cart_option WHERE line_id = '".$row_cart["id"]."';";
                    $result2 = $dw3_conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        while($row2 = $result2->fetch_assoc()) { 
                            $line_price = $line_price + $row2["price"];
                        }
                    }

                    echo "<div style='vertical-align:top;font-family:var(--dw3_form_font);display:inline-block;background:rgba(255,255,255,0.7);color:#222;padding:3px;margin:12px;border-radius:7px;max-width:340px;min-height:275px;box-shadow: inset 0px 0px 5px #777;'>
                        <button class='red no-effect' style='float:left;margin:-10px;padding:4px 3px 3px 3px;border-radius:15px;' onclick=\"dw3_cart_del('".$row_cart["id"] ."')\"><span class='dw3_font' style='font-size:20px;'>ď</span></button>
                            <table style='min-width:300px;white-space:wrap;margin-right:auto;margin-left:auto;font-family:var(--dw3_table_font);'>
                                <tr onclick=\"getPRD('". $row["id"] . "');\">";
                                if($USER_LANG == "FR"){ 
                                    echo "<td style='text-align:center;height:54px;vertical-align:middle;cursor:pointer;'><b>". strtoupper($row["name_fr"]) ."</b></td></tr>";
                                }else{
                                    echo "<td style='text-align:center;height:54px;vertical-align:middle;cursor:pointer;'><b>". strtoupper($row["name_en"]) ."</b></td></tr>";
                                }                            
                                echo "<tr onclick=\"getPRD('". $row["id"] . "');\">"
                                . "<td style='text-align:center;height:110px;vertical-align:middle;cursor:pointer;'><img class='photo' style='height:100px;width:auto;max-width:100%;' src='" . $filename. "' onerror='this.onerror=null; this.src=\"/pub/img/dw3/nd.png\";'></td></tr>";
                                if ($row["tax_fed"] == "1"){
                                    $line_tps = round((floatval($line_price)*$line_qty)*0.05,2);
                                    $is_tx_fed = true;
                                }
                                if ($row["tax_prov"] == "1"){
                                    $line_tvq = round((floatval($line_price)*$line_qty)*0.09975,2);
                                    $is_tx_prov = true;
                                }        
                                if ($is_tx_prov==false && $is_tx_fed == false){
                                    $non_taxable = $non_taxable + ($line_price*$line_qty);
                                } else{
                                    $taxable = $taxable + ($line_price*$line_qty);
                                } 
                    $is_service = true;
                    if ($row["billing"] == "FINAL" || $row["billing"] == "LOCATION"){
                        $is_service = false;
                    }                   
                    if ($is_service == false && $row["qty_max_by_inv"] == 1){
                        $qty_inv = $row["invTOT"];
                    } else {
                        $qty_inv = "";
                    }
                    //get product options
                    $sql2 = "SELECT * FROM product_option WHERE product_id = '".$row["id"]."' ORDER BY name_fr ASC;";
                    $result2 = $dw3_conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        echo "<tr><td>";
                        while($row2 = $result2->fetch_assoc()) {
                            echo "<div class='divBOX' style='text-align:left;'><b>".$row2["name_fr"].":</b><br><div style='width:100%;max-width:100%;'><div style='margin:0px 0px 0px 10px;text-align:left;display:inline-block;'>";	
                                //option_line selected
                                $sqlx = "SELECT * FROM cart_option WHERE line_id = '".$row_cart["id"] ."' AND option_id = '".$row2["id"]."' LIMIT 1;";
                                $resultx = mysqli_query($dw3_conn, $sqlx);
                                    $datax = mysqli_fetch_assoc($resultx);
                                    $selected_option_line = $datax["option_line_id"];
                                    $option_line_id = $datax["id"];
                                    //product_option_line
                                    $sql3 = "SELECT * FROM product_option_line WHERE option_id = '".$row2["id"]."' ORDER BY amount ASC;";
                                    $result3 = $dw3_conn->query($sql3);
                                    if ($result3->num_rows > 0) {
                                        while($row3 = $result3->fetch_assoc()) {
                                            if ($row3["amount"] != 0){
                                                $option_amount_dsp = "";
                                                //$option_amount_dsp = " <small>+" . $row3["amount"] . "$</small>";
                                            } else {
                                                $option_amount_dsp = "";
                                            }
                                            if ($selected_option_line == $row3["id"]){
                                                echo "<input onclick=\"updCART_OPTION('".$option_line_id."','".$row2["id"]."','".$row3["id"]."')\" id='opt".$row3["id"]."_".$option_line_id."' name='opts".$row2["id"]."_".$option_line_id."' type='radio' value='". $row3["id"] . "' checked> <label for='opt".$row3["id"]."_".$option_line_id."' style='padding-top:0px;'>". $row3["name_fr"] . $option_amount_dsp . "</label><br>";		
                                            } else {
                                                echo "<input onclick=\"updCART_OPTION('".$option_line_id."','".$row2["id"]."','".$row3["id"]."')\" id='opt".$row3["id"]."_".$option_line_id."' name='opts".$row2["id"]."_".$option_line_id."' type='radio' value='". $row3["id"] . "'> <label for='opt".$row3["id"]."_".$option_line_id."' style='padding-top:0px;'>". $row3["name_fr"] . $option_amount_dsp . "</label><br>";		
                                            }
                                        }
                                    }
                            echo "</div></div></div>";
                        }
                        echo "</td></tr>";
                    }
                    echo "<tr><td style='text-align:center;font-size:22px;'>
                    <button class='no-effect' style='width:42px;padding:10px;margin-right:10px;font-family:Consolas,monospace;font-weight:bold;' onclick=\"dw3_cart_minus('".$row_cart["id"] ."','".$row["qty_min_sold"]."')\">-".$row["qty_step"]."</button>
                     &nbsp;<input id='dw3_cart_item_qty_".$row_cart["id"]."' type='text' style='background:rgba(255,255,255,0.9);color:#222;text-align:center;border:0px;width:60px;font-weight:bold;border-radius:0px;padding:5px;font-size:18px;background-image:none;' value='". round($line_qty) ."' onchange=\"dw3_cart_change('".$row_cart["id"] ."','".$qty_inv ."','".$row["qty_min_sold"]."')\"></b>&nbsp; 
                     <button class='no-effect' style='width:42px;padding:10px;margin-left:10px;font-family:Consolas,monospace;font-weight:bold;' onclick=\"dw3_cart_plus('".$row_cart["id"] ."','".$qty_inv ."')\">+".$row["qty_step"]."</button>
                     </td></tr>";
                    if ($CIE_HIDE_PRICE == "true"){
                        echo "<tr><td style='text-align:center;vertical-align:bottom;display:none;'>";
                    } else {
                        echo "<tr><td style='text-align:center;vertical-align:bottom;'>";
                    }
                    $wtotal = $wtotal + floatval($row["kg"]);
                    //$stotal = $stotal + (floatval($line_price)*$line_qty);
                    $ltotal = (floatval($line_price)*$line_qty);
                    //$ltotal = (floatval($line_price)*$line_qty) + $line_tps + $line_tvq;
                    //$gtotal = $gtotal + $ltotal;
                    //$tot_tps = $tot_tps + $line_tps;
                    //$tot_tvq = $tot_tvq + $line_tvq;
                    if ( trim($row["price_text_fr"]) == "") {
                        $plitted = explode(".",$ltotal);
                        $whole = $plitted[0]??$ltotal;
                        $fraction = $plitted[1]??0;
                        if ($fraction == 0){
                            $fraction = "00";
                        }
                        echo number_format($line_price,2,"."," ") . "$/<small>". $row["pack_desc"]. "</small> x<b>".round($line_qty)."</b> = <b>". number_format($whole) . ".<sup>" . str_pad(rtrim($fraction, "0"), 2 , "0") . "$</sup></b>";
                    } else { 
                        if($USER_LANG == "FR"){ 
                            echo " " . $row["price_text_fr"] . "</b>";
                        }else{
                            echo " " . $row["price_text_en"] . "</b>";
                        }
                    }
                    if ($is_price_list == true){
                        if ($USER_LANG == "FR"){
                            echo "<br><button onclick='getPRICE_LIST(".$row["id"].",".$customer_id.",".$row_cart["id"].")' style='padding:0px 9px;'><span class='dw3_font'>£</span> Liste de prix</button>";
                        } else {
                            echo "<br><button onclick='getPRICE_LIST(".$row["id"].",".$customer_id.",".$row_cart["id"].")' style='padding:0px 9px;'><span class='dw3_font'>£</span> Price List</button>";
                        }
                    }
                        echo "</td></tr></table>";
                    if ($row["tax_verte"] != "0"){
                        if ($USER_LANG == "FR"){
                            echo "<div style='color:#444;font-size:0.8em;margin:5px 5px -5px 0px;width:100%;text-align:right;'>Frais inclus: ".number_format($row["tax_verte"],2,"."," ")." $ Envir <span onclick='taxeVERTE_INFO();' class='material-icons' style='font-size:19px;vertical-align:middle;cursor:pointer;'>&#128712;</span></div>";
                        }else{
                            echo "<div style='color:#444;font-size:0.8em;margin:5px 5px -5px 0px;width:100%;text-align:right;'>Incl $".number_format($row["tax_verte"],2,"."," ")." Env. fees <span onclick='taxeVERTE_INFO();' class='material-icons' style='font-size:19px;vertical-align:middle;cursor:pointer;'>&#128712;</span></div>";
                        }
                    }
                    echo "</div>";
                }
            }
        }
    }

        //si choix LIVRAISON ou PICKUP
        //if($ship_required == true){
           // if($CIE_PICKUP == "true"){
                //choix possible
/*                 echo "<div style='font-family:var(--dw3_form_font);width:100%;text-align:right;'>";
                echo "<div class='dw3_box' style='width:310px;margin:15px;padding:10px;text-align:left;box-shadow: 0px 0px 5px #777;'>
                        Transport:<select id='dw3_delivery_select' onchange=''dw3_set_delivery()'>";
                if ($USER_LANG == "FR"){
                    echo "<option value='DELIVERY'>Livraison</option>
                    <option "; if ($USER_DELIVERY == "PICKUP") {echo " selected";  } echo " value='PICKUP'>Ramasser en magasin</option>";
                }else{
                    echo "<option value='DELIVERY'>Delivery</option>
                    <option "; if ($USER_DELIVERY == "PICKUP") {echo " selected";  } echo " value='PICKUP'>Pickup in store</option>";
                }
                echo "</select>"; */
/*                 echo "<br><select id='dw3_store_select' onchange='dw3_set_store()'>";
                $sql7 = "SELECT * FROM location WHERE stat='0' AND type IN (1,2,7) ORDER BY name";
                $result7 = $dw3_conn->query($sql7);
                if ($result7->num_rows > 0) {	
                    while($row7 = $result7->fetch_assoc()) {
                        if ($row7["id"] == $USER_STORE)
                        { 
                            $strTMP = " selected"; 
                        } else {
                            $strTMP = " "; 
                        }
                        echo "<option value='". $row7["id"] . "' " . $strTMP . ">"	. $row7["name"] . " (" . $row7["province"] . ")</option>";
                    }
                }                        
                echo   "</select>"; */
                //echo   "</div></div>";
            //} else {
            //le montant de la livraison sera calculé dans l'espace client

           // }
        //}
 

//MARKET
    $ad_string = "";
    foreach ($_COOKIE as $key=>$val)
    {
        if (substr($key, 0, 3) == "AD_" && $val != "0"){
            $ad_string .= ltrim($key,"AD_").",";
        }
    }
    $ad_string = rtrim($ad_string,",");
    if ($ad_string != "") {
        $sql = "SELECT A.*, B.company FROM classified A
            LEFT JOIN (SELECT id as retailer_id, company FROM customer) B ON A.customer_id = B.retailer_id
            WHERE id IN (" . $ad_string . ") ORDER BY price ASC";
            //echo $sql;
            $result = $dw3_conn->query($sql);
            $QTY_ROWS2 = $result->num_rows??0;
            //if ($QTY_ROWS > 0) { 
            if ($QTY_ROWS2 > 0 ) { 
                while($row = $result->fetch_assoc()) {
                    $is_tx_fed = false;
                    $is_tx_prov = false;
                    $line_tvq = 0.00;
                    $line_tps = 0.00;
                    $line_price = $row["price"];
                    $RNDSEQ=rand(100,100000);
                    $line_qty = $_COOKIE['AD_'.$row["id"]];
                    $filename= $row["img_link"];
                    if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename)){
                        $filename = "/pub/img/dw3/nd.png";
                    } else {
                        if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename)){
                            $filename = "/pub/img/dw3/nd.png";
                        }else{
                            $filename = "/fs/customer/" . $row["customer_id"] . "/" . $filename;
                        }
                    }
                    if ($row["ship_type"]!= ""){
                        $ship_required = true;
                    }
                    echo "<div style='vertical-align:top;font-family:var(--dw3_form_font);display:inline-block;background:rgba(255,255,255,0.7);color:#222;padding:3px;margin:12px;border-radius:7px;max-width:340px;min-height:275px;box-shadow: inset 0px 0px 5px #777;'>
                        <button class='white no-effect' style='float:left;margin:-10px;font-family:Roboto-Light;padding:4px 3px 3px 3px;border-radius:15px;' onclick=\"deleteOneAd('".$row["id"] ."')\"><span class='dw3_font' style='font-size:20px;'>ď</span></button>
                        <table style='min-width:300px;white-space:wrap;margin-right:auto;margin-left:auto;font-family:var(--dw3_table_font);'>
                            <tr onclick=\"getAD('". $row["id"] . "');\">";
                            if($USER_LANG == "FR"){ 
                                echo "<td style='text-align:center;height:54px;vertical-align:middle;cursor:pointer;'><b>". strtoupper($row["name_fr"]) ."</b></td></tr>";
                            }else{
                                echo "<td style='text-align:center;height:54px;vertical-align:middle;cursor:pointer;'><b>". strtoupper($row["name_en"]) ."</b></td></tr>";
                            }                            
                            echo "<tr onclick=\"getAD('". $row["id"] . "');\">"
                            . "<td style='text-align:center;height:110px;vertical-align:middle;cursor:pointer;'><img class='photo' style='height:100px;width:auto;max-width:100%;' src='" . $filename . "' onerror='this.onerror=null; this.src=\"./pub/img/nd.png\";'></td></tr>";
                            if ($row["tax_fed"] == "1"){
                                $line_tps = round((floatval($line_price)*$line_qty)*0.05,2);
                                $is_tx_fed = true;
                            }
                            if ($row["tax_prov"] == "1"){
                                $line_tvq = round((floatval($line_price)*$line_qty)*0.09975,2);
                                $is_tx_prov = true;
                            }        
                            if ($is_tx_prov==false && $is_tx_fed == false){
                                $non_taxable = $non_taxable + ($line_price*$line_qty);
                            } else{
                                $taxable = $taxable + ($line_price*$line_qty);
                            }                    
                    echo "<tr><td style='text-align:center;'><button class='no-effect' style='width:42px;padding:10px;margin-right:10px;font-family:Roboto-Light;' onclick=\"minusAdCookie('".$row["id"] ."')\">-1</button> <b>". $_COOKIE['AD_'.$row["id"]]. "</b> <button class='no-effect' style='width:42px;padding:10px;margin-left:10px;font-family:Roboto-Light;' onclick=\"plusAdCookie('".$row["id"] ."','".$row["qty_available"] ."')\">+1</button></td></tr>";
                    echo "<tr><td style='text-align:center;vertical-align:bottom;'>";
                    $wtotal = $wtotal + floatval($row["kg"]);
                    //$stotal = $stotal + (floatval($line_price)*$line_qty);
                    $ltotal = (floatval($line_price)*$line_qty);
                    //$ltotal = (floatval($line_price)*$line_qty) + $line_tps + $line_tvq;
                    //$gtotal = $gtotal + $ltotal;
                    //$tot_tps = $tot_tps + $line_tps;
                    //$tot_tvq = $tot_tvq + $line_tvq;

                        $plitted = explode(".",$ltotal);
                        $whole = $plitted[0]??$ltotal;
                        $fraction = $plitted[1]??0;
                        if ($fraction == 0){
                            $fraction = "00";
                        }//else{$fraction = ".".$fraction;}
                        if ($line_tps == 0 && $line_tvq == 0){
                            echo $line_qty." x " . number_format($line_price,2,"."," ") . "$ = <b><span style='font-size:21px;'>". number_format($whole) . ".<sup>" . str_pad(rtrim($fraction, "0"), 2 , "0") . "</sup>$<span></b>";
                        }else {
                            echo $line_qty." x " . number_format($line_price,2,"."," ") . "$ = <b><span style='font-size:21px;'>". number_format($whole) . ".<sup>" . str_pad(rtrim($fraction, "0"), 2 , "0") . "</sup>$ +tx<span></b>";
                        }

                        echo "</td></tr></table>";
                    echo "</div>";
                    /* echo "<div style='text-align:center;border:1px solid #444;margin:15px; box-shadow: 5px 5px 5px 5px rgba(0,0,0,0.5);max-width:220px;width:220px;display:inline-block;border-radius:10px;background:rgba(255,255,255,0.9);color:#222;'>
                            <button style='float:left;margin:-15px;' onclick=\"deleteSelectedAd('".$row["id"]."')\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>cancel</span></button>
                            <table style='border-collapse: collapse;border:0px;width:220px;min-height:100%;border-radius:10px;'>";
                        //nom                           
                        echo "<tr style='padding:0px;border:0px;' onclick='getAD(". $row["id"] . ");'>";
                        if ($USER_LANG=="FR"){
                           echo "<td style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;height:50px;width:170px;font-size:16px;'>". $row["name_fr"] . "</td></tr>";
                        } else {
                           echo "<td style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;height:50px;width:170px;font-size:16px;'>". $row["name_en"] . "</td></tr>";
                        }    
                        //image                           
                        echo "<tr style='padding:0px;border:0px;' onclick='getAD(". $row["id"] . ");'>"
                            . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;vertical-align:middle;height:170px;'><img class='dw3_category_photo' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"/pub/img/dw3/nd.png\";'></td></tr>";
                        //retailer                           
                        echo "<tr style='padding:0px;border:0px;' onclick='getAD(". $row["id"] . ");'>"
                            . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;'>". $row["company"] . "</td></tr>";
                        //prix
                        $tot_line = round($row["price"]*$ad_line_qty,2);
                        $plitted = explode(".",$tot_line);
                        $whole = $plitted[0]??$tot_line;
                        $fraction = $plitted[1]??0; 
                        if ($fraction == 0){
                            $fraction = "00";
                        }else{
                            $fraction = str_pad(rtrim($fraction, "0"), 2 , "0");
                        }
                        echo "<tr style='height:35px;'><td style='font-family:Sunflower;border:0px;text-align:center;padding-right:5px;padding-top:13px;padding-bottom:13px;'><strong>". number_format($whole) . ".<sup>" . $fraction . "</sup></strong></td></tr>";
                        //quantité
                        if ($ad_line_qty < $row["qty_available"]){
                            echo "<tr><td style='text-align:center;'><button style='padding:5px 10px;' onclick=\"minusAdCookie('".$row["id"] ."')\">-1</button> &nbsp;". $ad_line_qty . " &nbsp;<button style='padding:5px 10px;' onclick=\"plusAdCookie('".$row["id"] ."')\">+1</button></td></tr>";
                        } else {
                            echo "<tr><td style='text-align:center;'><button style='padding:5px 10px;' onclick=\"minusAdCookie('".$row["id"] ."')\">-1</button> &nbsp;". $ad_line_qty . " &nbsp;<button disabled style='padding:5px 10px;' onclick=\"plusAdCookie('".$row["id"] ."')\">+1</button></td></tr>";
                        }
                        //checkout
                        if($USER_LANG == "FR"){
                            echo "<tr><td><img src='/pub/img/dw3/flag-canada.svg' style='width:20px;'> <span style='font-size:12px;'>Tous les prix sont en CAD</span><br><button onclick=\"marketTOcheckout('".$row["id"]."','". $ad_line_qty."');\" style='min-height:50px;margin-left:0px;border-bottom-right-radius:10px;'><span style='width:92px;'>Payer</span> <span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span></button></td></tr>";
                        } else {
                            echo "<tr><td><img src='/pub/img/dw3/flag-canada.svg' style='width:20px;'> <span style='font-size:12px;'>All prices are in CAD</span><br><button onclick=\"marketTOcheckout('".$row["id"]."''". $ad_line_qty."');\" style='min-height:50px;margin-left:0px;border-bottom-right-radius:10px;'><span style='width:92px;'>Pay</span> <span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span></button></td></tr>";
                        }
                        echo "</table></div>"; */
                }
            }
        }
    if ($QTY_ROWS == 0 && $QTY_ROWS2 == 0) { 
        if($USER_LANG == "FR"){ 
                echo "<div class='dw3_box' style='text-align:center;'><img src='/pub/img/dw3/empty_cart.jpg' style='width:100%;height:auto;'></div>
                <hr><h2 style='text-align:left;padding-left:10px;'>Le panier est vide</h2>";
                if ($CIE_DIST_AD == "" || $CIE_DIST_AD == "false"){
                    echo "<div style='text-align:left;padding-left:10px;'>On dirait que vous n’avez pas encore trouvé ce que vous cherchiez. <a href='/pub/page/products/index.php?KEY=". $KEY."&P1=all'> <button>Explorer les produits et services</button></a></div>";
                } else {
                    echo "<div style='text-align:left;padding-left:10px;'>On dirait que vous n’avez pas encore trouvé ce que vous cherchiez. <a href='/pub/page/classifieds/index.php?KEY=". $KEY."'> <button>Explorer le marché</button></a></div>";
                }
            } else { 
            echo "<div class='dw3_box' style='text-align:center;'><img src='/pub/img/dw3/empty_cart.jpg' style='width:100%;height:auto;'></div>
            <hr><h3 style='text-align:left;padding-left:10px;'>The cart is empty</h3>";
            if ($CIE_DIST_AD == "" || $CIE_DIST_AD == "false"){
                echo "<div style='text-align:left;padding-left:10px;'>Looks like you haven't found what you're looking for yet. <a href='/pub/page/products/index.php?KEY=". $KEY."&P1=all'> <button>Explore products and services</button></a></div>";
            } else {
                echo "<div style='text-align:left;padding-left:10px;'>Looks like you haven't found what you're looking for yet. <a href='/pub/page/classifieds/index.php?KEY=". $KEY."'> <button>Explore the market</button></a></div>";
            }
        }
    } else {
        //VERIFICATION DE COUPONS
        echo "<div style='font-family:var(--dw3_form_font);width:100%;text-align:right;'>";
        if ($USER_LANG == "FR"){
            echo "<div class='dw3_box' style='background:rgba(255,255,255,0.8);color:#222;width:310px;margin:15px;padding:10px;text-align:left;box-shadow: 0px 0px 5px #777;'>Code de promotion:<br><input id='dw3_input_coupon' type='text' style='width:200px;margin:8px 0px;'><button class='no-effect' style='font-family:Roboto-Light;padding:7px;border-radius:15px;float:right;' onclick=\"verify_code_coupon()\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>&#128270;</span> Vérifier</button></div>";
        }else{
            echo "<div class='dw3_box' style='background:rgba(255,255,255,0.8);color:#222;width:310px;margin:15px;padding:10px;text-align:left;box-shadow: 0px 0px 5px #777;'>Promotion code:<br><input id='dw3_input_coupon' type='text' style='width:200px;margin:8px 0px;'><button class='no-effect' style='font-family:Roboto-Light;padding:7px;border-radius:15px;float:right;' onclick=\"verify_code_coupon()\"><span class='material-icons' style='font-size:24px;vertical-align:middle;'>&#128270;</span> Verify</button></div>";
        }
        echo "</div>";
    //TOTAUX
    //si transport INTERNE
    if (trim($CIE_TRANSPORT) == "INTERNAL" && $ship_required == true) {
        $transport = floatval($CIE_TRANSPORT_PRICE);
    }
    //calculer si transport GRATUIT
    $is_transport_free = false;
    if (floatval($stotal) >= floatval($CIE_FREE_MIN) && floatval($CIE_FREE_MIN) > 0){
        $transport = 0.00;
        $is_transport_free = true;
    }

    //$ggtotal = $gtotal+$transport;
    $stotal = $non_taxable + $taxable;
    if ($coupon_valid==true){
        if($coupon_amount > 0){
            $coupon_saving = $coupon_saving + $coupon_amount;
        }
        if($coupon_pourcent > 0){
            $coupon_saving = $coupon_saving + round(($stotal)*($coupon_pourcent/100),2);
        }
        //$gtotal = $gtotal - $coupon_saving;
        $coupon_desc = "";
        //$coupon_desc = "<div style='display:inline-blockfont-size:14px;width:120px;text-align:left;'>";
        if ($coupon_amount > 0){
            $coupon_desc .= $coupon_amount."$";
        }
        if ($coupon_pourcent > 0){
            if ($coupon_amount > 0){$coupon_desc .= "+"; }
            $coupon_desc .= $coupon_pourcent."%";
        }
        //$coupon_desc .= "</div>";
    }
    $stotal = $stotal - $coupon_saving;
    //$tot_tvq = round((($taxable-$coupon_saving)/100)*9.975,2);
    //$tot_tps = round((($taxable-$coupon_saving)/100)*5,2);
    //$gtotal = $stotal + $tot_tvq + $tot_tps + $transport;

        if($USER_LANG == "FR"){ 
            echo "<div style='font-family:var(--dw3_form_font);width:100%;text-align:right;'><div style='background:rgba(255,255,255,0.8);color:#222;padding:15px;border-radius:3px;box-shadow:1px 1px 6px green;margin:15px;display:inline-block;width:300px;text-align:right;'>";
                if ($CIE_HIDE_PRICE == "true"){
                    echo "Sous-total: <div style='width:150px;display:inline-block;font-family:Roboto-Light;'>À déterminer</div><hr>";
                } else {
                    echo "Sous-total: <div style='width:150px;display:inline-block;font-family:Roboto-Light;'>".number_format($stotal+$coupon_saving,2,"."," ")."$</div><hr>";
                }
                if ($coupon_saving > 0){
                    echo "Rabais ".$coupon_desc.": <div style='width:150px;display:inline-block;font-family:Roboto-Light;'>-".number_format($coupon_saving,2,"."," ")."$</div><hr>";
                }
                echo "Taxes: <div style='width:150px;display:inline-block;font-family:Roboto-Light;'>À déterminer</div><hr>";
                if (trim($CIE_TRANSPORT) != "" && trim($CIE_TRANSPORT) != "INTERNAL" && $is_transport_free == false && $ship_required == true) {
                    echo "Transport : <div id='transportRate' style='width:150px;display:inline-block;font-family:Roboto-Light;'>À déterminer</div>";
                } else if ($ship_required == true){
                    echo "Transport : <div style='width:150px;display:inline-block;font-family:Roboto-Light;'>À déterminer</div>";
                }
/*             echo "Total avec taxes: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'><b>".number_format($gtotal,2,"."," ")."$</b></div>
                </div><br>"; */
                echo "</div><br>";
        }else{
            echo "<div style='font-family:var(--dw3_form_font);width:100%;text-align:right;'><div style='background:rgba(255,255,255,0.8);padding:15px;border-radius:3px;box-shadow:1px 1px 6px green;margin:15px;display:inline-block;width:300px;text-align:right;'>";
                if ($CIE_HIDE_PRICE == "true"){
                    echo "Subtotal: <div style='width:150px;display:inline-block;font-family:Roboto-Light;'>To be determined</div><hr>";
                } else {
                    echo "Subtotal: <div style='width:150px;display:inline-block;font-family:Roboto-Light;'>".number_format($stotal+$coupon_saving,2,"."," ")."$</div><hr>";
                }
                if ($coupon_saving > 0){
                    echo "Discount ".$coupon_desc.": <div style='width:150px;display:inline-block;font-family:Roboto-Light;'>-".number_format($coupon_saving,2,"."," ")."$</div><hr>";
                }
                echo "Tax: <div style='width:150px;display:inline-block;font-family:Roboto-Light;'>To be determined</div><hr>";
                if (trim($CIE_TRANSPORT) == "POSTE_CANADA" && $is_transport_free == false && $ship_required == true) {
                    echo "Transport : <div id='transportRate' style='width:150px;display:inline-block;font-family:Roboto-Light;'>To be determined</div>";
                }else{
                    echo "Transport : <div style='width:150px;display:inline-block;font-family:Roboto-Light;'>To be determined</div>";
                }
/*             echo "Total with taxes: <div style='width:120px;display:inline-block;font-family:Roboto-Light;'><b>".number_format($gtotal,2,"."," ")."$</b></div>
                </div><br>"; */
                echo "</div><br>";
        }
        if ($CIE_HIDE_PRICE == "true"){
            if($USER_LANG == "FR"){
                echo "Les prix peuvent varier et le total sera déterminé lors du ramassage de la commande en magasin.";
            }else{
                echo "Prices may vary and the total will be determined upon order pickup in store.";
            }
        }
    }

    echo "</div><div style='height:40px;'></div></div><div class='dw3_form_foot' style='background:#CCC;color:#333;padding:7px;height:auto;'>";				
    if ($QTY_ROWS != 0 || $QTY_ROWS2 != 0) {
        if($KEY != "" && $USER_NAME != ""){
            if($USER_LANG == "FR"){
                echo "<button class='no-effect green' style='margin:0px 5px 0px 5px;' onclick=\"window.open('/client/dashboard.php?KEY=".$KEY."','_self');\"><span class='dw3_font' style='font-size:24px;vertical-align:middle;'>Ľ</span> Continuer </button> (<b style='font-size:12px;'>".$USER_NAME."</b>)"; 
            }else{
                echo "<button class='no-effect green' style='margin:0px 5px 0px 5px;' onclick=\"window.open('/client/dashboard.php?KEY=".$KEY."','_self');\"><span class='dw3_font' style='font-size:24px;vertical-align:middle;'>Ľ</span> Continue </button> (<b style='font-size:12px;'>".$USER_NAME."</b>)"; 
            }
        } else {
            if($USER_LANG == "FR"){
                echo "<button class='no-effect green' style='margin:0px 5px 0px 5px;' onclick=\"window.open('/client','_self');\"><span class='dw3_font' style='font-size:24px;vertical-align:middle;'>Ľ</span> Continuer / Créer un compte </button> ";
            }else{
                echo "<button class='no-effect green' style='margin:0px 5px 0px 5px;' onclick=\"window.open('/client','_self');\"><span class='dw3_font' style='font-size:24px;vertical-align:middle;'>Ľ</span> Continue / Register </button> ";
            }
        }
    } else {
        if($USER_LANG == "FR"){
            echo "<button class='no-effect grey' style='margin:0px 5px 0px 5px;' onclick=\"dw3_cart_close();\"><span class='dw3_font' style='font-size:24px;'>ď</span> Fermer </button>"; 
        }else{
            echo "<button class='no-effect grey' style='margin:0px 5px 0px 5px;' onclick=\"dw3_cart_close();\"><span class='dw3_font' style='font-size:24px;'>ď</span> Close </button>"; 
        }
    }
    echo "</div>";
$dw3_conn->close();
die();
?>
<?php
//cart to order to invoice
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$carrierCode = $_GET['C'];
$serviceCode = $_GET['S'];
$selectedService = $_GET['SS'];
$transport = $_GET['P'];//price from transport api's only, product transport supplement by item not calculated yet

if ($CIE_DFT_ADR2 !=""){
    $location_id = $CIE_DFT_ADR2; //location exped dft
} else {
    $location_id = "1";
}
$coupon_valid = false;
$coupon_code = "";
$coupon_amount = "0";
$coupon_pourcent = "0";
$coupon_prd = "0";
$coupon_msg = "Le coupon est expiré.";
$coupon_saving = 0;

$dw3_cart=array();
    foreach ($_COOKIE as $cookie_key=>$val) {
        if (substr($cookie_key, 0, 5) == "CART_"){
        $dw3_cart[$cookie_key] = $val;
        }
        if ($cookie_key == "COUPON"){
            $coupon_code = $val;
        }
        if ($cookie_key == "STORE"){
            $location_id = $val;
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


if ($selectedService == "" || $selectedService == "PICKUP"){
    $sql2 = "SELECT * FROM location WHERE id = '" .  $location_id . "'";
    $result2 = mysqli_query($dw3_conn, $sql2);
    $data2 = mysqli_fetch_assoc($result2);
    $province_tx = $data2["province"];
} else {
    if ($USER_PROV_SH == ""){
        $province_tx = $USER_PROV;
    } else if ($USER_PROV != ""){
        $province_tx = $USER_PROV;
    } else {
        $province_tx = $CIE_PROV;
    }
}

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

$ship_required = false;
$cart_dimensions = 0.00; //dimension total
$cart_width = 0.00;
$cart_height = 0.00;
$cart_depth = 0.00;
$cart_weight = 0.00; //weight total
$qty_lines = 0;
$sql_head="";
$sql_lines="";
$stotal = 0.00;
$taxable = 0;
$non_taxable = 0;
$gtotal = 0.00;
$ggtotal = 0.00;
$tot_tps = 0.00;
$tot_tvp = 0.00;
$tot_tvh = 0.00;
$line_qty = 0;
//$transport = 0.00;
    foreach ($dw3_cart as $cookie_key=>$val) {
        $line_qty = $dw3_cart[$cookie_key];
        if (intval($line_qty) > 0){
            $qty_lines++;
            if ($qty_lines == 1){
                //créér lentete de commande
                $sql_head="INSERT INTO order_head (location_id,customer_id,stat,ship_type,ship_code,name,eml,tel,adr1,adr2,city,prov,country,postal_code,adr1_sh,adr2_sh,city_sh,province_sh,country_sh,postal_code_sh,date_created,date_modified,date_email) " 
                . " VALUES ('".$location_id. "','".$USER."','1','".$carrierCode."','".$serviceCode."','".dw3_crypt($USER_FULLNAME)."','".dw3_crypt($USER_EML1)."','".dw3_crypt($USER_TEL1)."','".dw3_crypt($USER_ADR1)."','".dw3_crypt($USER_ADR2)."','".$USER_VILLE."','".$USER_PROV."','".$USER_PAYS."','".$USER_CP."','".dw3_crypt($USER_ADR1_SH)."','".dw3_crypt($USER_ADR2_SH)."','".$USER_VILLE_SH."','".$USER_PROV_SH."','".$USER_PAYS_SH."','".$USER_CP_SH."','".$datetime."','".$datetime."','".$datetime."')" ;
                if ($dw3_conn->query($sql_head) === TRUE) {
                    $inserted_id = $dw3_conn->insert_id;
                } else {
                    die("ERR".$sql_head);
                }
            }        
            //aller chercher les infos du produit
            $sql = "SELECT * FROM product WHERE id = '" . ltrim($cookie_key,"CART_") . "' LIMIT 1";
            $result = $dw3_conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $is_tx_fed = false;
                    $is_tx_prov = false;
                    $line_tvp = 0.00;
                    $line_tps = 0.00;
                    $line_price = $row["price1"];
                    $transport = $transport + $row["transport_supp"]*$line_qty;
                    if ($row["price2"] != 0 && $row["qty_min_price2"] >=2 && $line_qty >=$row["qty_min_price2"]){
                        $line_price = $row["price2"];
                    }
                    $date_promo = new DateTime($row["promo_expire"]);
                    $now = new DateTime();
                    if($date_promo > $now && $line_price > $row["promo_price"]) {
                        $line_price = $row["promo_price"];
                    }
            
                    //verif si escompte produit du fournisseur pour ce client
                    $sqlx = "SELECT * FROM customer_discount WHERE customer_id = '".$USER."' AND supplier_id = '" . $row["supplier_id"] . "' AND supplier_id <> 0 LIMIT 1";
                    $resultx = mysqli_query($dw3_conn, $sqlx);
                    $datax = mysqli_fetch_assoc($resultx);
                    if (isset($datax["escount_pourcent"]) && $datax["escount_pourcent"] != 0){
                        $discount_price = $line_price - (round($line_price*($datax["escount_pourcent"]/100),2));
                    } else {$discount_price = 0;}
                    if ($discount_price < $line_price && $discount_price > 0){
                        $line_price = $discount_price;
                    }
                    //options 
                    $options_text = "";
                    $sql2 = "SELECT * FROM cart_option WHERE line_id = '".$row_cart["id"]."';";
                    $result2 = $dw3_conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        while($row2 = $result2->fetch_assoc()) { 
                            $line_price = $line_price + $row2["price"];
                            $options_text .= $row2["description_fr"];
                        }
                    }
                    if ($row["ship_type"] != ""){
                        $ship_required = true;
                    }
                    if ($row["tax_fed"] == "1"){
                        if ($PTPS != ""){
                            $line_tps = round(floatval(($line_price*$line_qty)*$PTPS)/100,2);
                        } else if ($PTVH != ""){
                            $line_tps = round(floatval(($line_price*$line_qty)*$PTVH)/100,2);
                        }
                        $is_tx_fed = true;
                    }
                    if ($row["tax_prov"] == "1"){
                        $line_tvp = round(floatval(($line_price*$line_qty)*$PTVP)/100,2);
                        $is_tx_prov = true;
                    }  
                    if ($is_tx_prov==false && $is_tx_fed == false){
                        $non_taxable = $non_taxable + ($line_price*$line_qty);
                    } else{
                        $taxable = $taxable + ($line_price*$line_qty);
                    } 

                    $cart_weight = $cart_weight + floatval($row["kg"]*$line_qty);
                    $cart_width = $cart_width + round($row["width"]*$line_qty,2);
                    $cart_height = $cart_height + round($row["height"]*$line_qty,2);
                    $cart_depth = $cart_depth + round($row["depth"]*$line_qty,2);
                    $cart_dimensions = $cart_dimensions + (round($row["width"]*$line_qty,2)*round($row["height"]*$line_qty,2)*round($row["depth"]*$line_qty,2));
                    $ltotal = (floatval($line_price)*$line_qty) + $line_tps + $line_tvp;
                    if ($USER_LANG == "FR"){
                        $sql_lines = "INSERT INTO order_line (head_id,product_id,product_desc,product_opt,qty_order,price,tps,tvp,date_created,date_modified)"
                        . " VALUES ('".$inserted_id."','".$row["id"]."','".$row["name_fr"]."','".$options_text."','".$line_qty."','".$line_price."','".round(floatval($line_tps),2)."','".round(floatval($line_tvp),2)."','".$datetime."','".$datetime."') ; ";
                        $result2 = mysqli_query($dw3_conn, $sql_lines);
                    }else{
                        $sql_lines = "INSERT INTO order_line (head_id,product_id,product_desc,product_opt,qty_order,price,tps,tvp,date_created,date_modified)"
                        . " VALUES ('".$inserted_id."','".$row["id"]."','".$row["name_en"]."','".$options_text."','".$line_qty."','".$line_price."','".round(floatval($line_tps),2)."','".round(floatval($line_tvp),2)."','".$datetime."','".$datetime."') ; ";
                        $result2 = mysqli_query($dw3_conn, $sql_lines);                  
                    }
                    $sqlX = "INSERT INTO transfer (kind,product_id,order_id,quantity,date_created) VALUES ('EXPORT','" . $row["id"] . "','".$inserted_id."','-".$line_qty."','".$datetime."')";
                    $resultX = mysqli_query($dw3_conn, $sqlX);
                }
            } else {
            }
        }
    }

    if ($qty_lines >= 1){
        if ($ship_required == true && $CIE_TRANSPORT == "INTERNAL" && $selectedService != "PICKUP"){
            $transport = $transport + floatval($CIE_TRANSPORT_PRICE??0);
        }
        if (floatval($stotal) >= floatval($CIE_FREE_MIN) && floatval($CIE_FREE_MIN) > 0){
            $transport = 0.00;
        }
        //$stotal = $stotal + $stotal_tx;
        $stotal = $non_taxable + $taxable;
        if ($coupon_valid==true){
            if($coupon_amount > 0 && $coupon_prd =='0'){
                $coupon_saving = $coupon_amount;
            }
            if($coupon_pourcent > 0 && $coupon_prd =='0'){
                $coupon_saving = $coupon_saving + round(($stotal)*($coupon_pourcent/100),2);
            }
            $coupon_desc = "";
            if ($coupon_amount > 0){
                $coupon_desc .= $coupon_amount."$";
            }
            if ($coupon_pourcent > 0){
                if ($coupon_amount > 0){$coupon_desc .= "+"; }
                $coupon_desc .= $coupon_pourcent."%";
            }
        }

        //get box size
        $sql = "SELECT *, ROUND((depth*width*height),2) as size FROM supply WHERE supply_type = 'BOX' ORDER BY size ASC";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($cart_dimensions <= $row["size"]){
                    $cart_width = $row["width"];
                    $cart_height = $row["height"];
                    $cart_depth = $row["depth"];
                    $cart_weight = $cart_weight+$row['weight'];
                    $cart_dimensions = $row["size"];
                    break;
                }
            }
        }

        $stotal = $stotal - $coupon_saving;
        $tot_tvp = round(($taxable/100)*$PTVP,2);
        $tot_tvh = round(($taxable/100)*$PTVH,2);
        $tot_tps = round(($taxable/100)*$PTPS,2);
        $gtotal = $stotal + $tot_tvp + $tot_tps + $tot_tvh + $transport;
        $sql_head="UPDATE order_head SET weight='".$cart_weight."',width='".$cart_width."',height='".$cart_height."',length='".$cart_depth."', stotal= '".$stotal."',tps= '".$tot_tps."',tvp= '".$tot_tvp."',tvh= '".$tot_tvh."',total = '".$gtotal."', transport = '".$transport."',discount='".$coupon_amount."' WHERE id = '". $inserted_id ."'" ;
        if ($dw3_conn->query($sql_head) === TRUE) {
        } else {
            die("ERR ". $sql_head);
        }
    }
    
    foreach ($_COOKIE as $cookie_key=>$val) {
        if (substr($cookie_key, 0, 5) == "CART_"){
            setcookie($cookie_key,0,time() - 3600,"/");
            unset($_COOKIE[$cookie_key]); 
        }
    }
    setcookie("COUPON","",time() - 3600,"/");
    if (isset($_COOKIE["COUPON"])){unset($_COOKIE["COUPON"]);}

    echo $inserted_id;
    $dw3_conn->close();
    ?>


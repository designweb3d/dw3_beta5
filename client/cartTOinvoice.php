<?php
//cart to order to invoice
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$carrierCode = $_GET['C'];
$serviceCode = $_GET['S'];
$selectedService = $_GET['SS'];
$pickup_date = $_GET['PK'];
$transport = $_GET['P']; //price from transport api's only, product transport supplement by item not calculated yet
//$location_id = mysqli_real_escape_string($dw3_conn,$_GET['L']);

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
        /* if (substr($cookie_key, 0, 5) == "CART_"){
        $dw3_cart[$cookie_key] = $val;
        } */
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


if ($selectedService = $_GET['SS'] == "" || $selectedService == "PICKUP"){
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
    $sql_cart = "SELECT  * FROM cart_line WHERE device_id ='" . $USER_DEVICE . "' ORDER BY id ASC;";
    $result_cart = $dw3_conn->query($sql_cart);
    $qty_lines = $result_cart->num_rows??0;
    if ($qty_lines > 0) {
            //créér lentete de commande
            $sql_head="INSERT INTO order_head (location_id,customer_id,stat,ship_type,ship_code,name,eml,tel,adr1,adr2,city,prov,country,postal_code,adr1_sh,adr2_sh,city_sh,province_sh,country_sh,postal_code_sh,date_created,date_modified,date_email,date_delivery) " 
            . " VALUES ('".$location_id. "','".$USER."','1','".$carrierCode."','".$serviceCode."','".dw3_crypt($USER_FULLNAME)."','".dw3_crypt($USER_EML1)."','".dw3_crypt($USER_TEL1)."','".dw3_crypt($USER_ADR1)."','".dw3_crypt($USER_ADR2)."','".$USER_VILLE."','".$USER_PROV."','".$USER_PAYS."','".$USER_CP."','".dw3_crypt($USER_ADR1_SH)."','".dw3_crypt($USER_ADR2_SH)."','".$USER_VILLE_SH."','".$USER_PROV_SH."','".$USER_PAYS_SH."','".$USER_CP_SH."','".$datetime."','".$datetime."','".$datetime."','".$pickup_date."')" ;
            if ($dw3_conn->query($sql_head) === TRUE) {
                $inserted_id = $dw3_conn->insert_id;
                $sql_head2="INSERT INTO invoice_head (line_source,order_id,location_id,stat,ship_type,ship_code,customer_id,name,eml,tel,adr1,adr2,city,prov,country,postal_code,adr1_sh,adr2_sh,city_sh,province_sh,country_sh,postal_code_sh,date_created,date_modified,date_email)"
                . " VALUES ('product',".$inserted_id.",'".$location_id. "','1','".$carrierCode."','".$serviceCode."','".$USER."','".dw3_crypt($USER_FULLNAME)."','".dw3_crypt($USER_EML1)."','".dw3_crypt($USER_TEL1)."','".dw3_crypt($USER_ADR1)."','".dw3_crypt($USER_ADR2)."','".$USER_VILLE."','".$USER_PROV."','".$USER_PAYS."','".$USER_CP."','".dw3_crypt($USER_ADR1_SH)."','".dw3_crypt($USER_ADR2_SH)."','".$USER_VILLE_SH."','".$USER_PROV_SH."','".$USER_PAYS_SH."','".$USER_CP_SH."','".$datetime."','".$datetime."','".$datetime."')" ;
                $result4 = mysqli_query($dw3_conn, $sql_head2);
                $inserted_id2 = $dw3_conn->insert_id;
            } else {
                //$dw3_conn->close();
                die("ERR".$sql_head);
                //die("ERR".$sql_head);
            }
                   
        while($row_cart = $result_cart->fetch_assoc()) { 
            //aller chercher les infos du produit
            $sql = "SELECT * FROM product WHERE id = '" . $row_cart["product_id"] . "' LIMIT 1";
            //die($sql);
            $result = $dw3_conn->query($sql);
            if ($result->num_rows > 0) {
                //echo ($sql );
                while($row = $result->fetch_assoc()) {
                    $line_qty = $row_cart["quantity"];
                    $is_tx_fed = false;
                    $is_tx_prov = false;
                    $line_tvp = 0.00;
                    $line_tps = 0.00;
                    $line_price = $row["price1"];
                    if ($selectedService != "" && $selectedService != "PICKUP"){
                        $transport = $transport + $row["transport_supp"]*$line_qty;
                    }
                    //product_pack
                    $sql_inc_z = "SELECT  * FROM product_pack WHERE product_id ='" . $row["id"] . "' ORDER BY pack_qty ASC";
                    $result_inc_z = $dw3_conn->query($sql_inc_z);
                    if ($result_inc_z->num_rows> 0) { 
                        while($row_inc_z = $result_inc_z->fetch_assoc()) {
                            if ($line_qty >= $row_inc_z["pack_qty"]){
                                $line_price = $row_inc_z["pack_price"];
                            }
                        }
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
                        //$stotal_tx = $stotal_tx + (floatval($line_price)*$line_qty);
                    } else {
                        //$stotal = $stotal + (floatval($line_price)*$line_qty);
                    }  
                    //die ("ERR tps:".$line_tps."PTPS:".$PTPS."ltotal:".$ltotal);
                    if ($is_tx_prov==false && $is_tx_fed == false){
                        $non_taxable = $non_taxable + ($line_price*$line_qty);
                    } else{
                        $taxable = $taxable + ($line_price*$line_qty);
                    } 
                    /* if ($row["id"]==$coupon_prd){
                        if ($coupon_valid==true){
                            if($coupon_amount > 0){
                                $coupon_saving = $coupon_amount;
                                $coupon_amount = 0;
                            }
                            if($coupon_pourcent > 0){
                                $coupon_saving = $coupon_saving + round(($line_price)*($coupon_pourcent/100),2);
                                $coupon_pourcent = 0;
                            }
                        }
                    } */
                    $cart_weight = $cart_weight + floatval($row["kg"]*$line_qty);
                    $cart_width = $cart_width + round($row["width"]*$line_qty,2);
                    $cart_height = $cart_height + round($row["height"]*$line_qty,2);
                    $cart_depth = $cart_depth + round($row["depth"]*$line_qty,2);
                    $cart_dimensions = $cart_dimensions + (round($row["width"]*$line_qty,2)*round($row["height"]*$line_qty,2)*round($row["depth"]*$line_qty,2));
                    //$stotal = $stotal + (floatval($line_price)*$line_qty);
                    $ltotal = (floatval($line_price)*$line_qty) + $line_tps + $line_tvp;
                    
                    //$gtotal = $gtotal + $ltotal;
                    //$tot_tps = $tot_tps + $line_tps;
                    //$tot_tvp = $tot_tvp + $line_tvp;
                    if ($USER_LANG == "FR"){
                        $sql_lines = "INSERT INTO order_line (head_id,product_id,product_desc,product_opt,qty_order,price,tps,tvp,date_created,date_modified)"
                        . " VALUES ('".$inserted_id."','".$row["id"]."','".$row["name_fr"]."','".$options_text."','".$line_qty."','".$line_price."','".round(floatval($line_tps),2)."','".round(floatval($line_tvp),2)."','".$datetime."','".$datetime."') ; ";
                        $result2 = mysqli_query($dw3_conn, $sql_lines);
                        $sql_lines2 = "INSERT INTO invoice_line (head_id,product_id,product_desc,,product_optqty_order,price,tps,tvp,date_created,date_modified)"
                        . " VALUES ('".$inserted_id2."','".$row["id"]."','".$row["name_fr"]."','".$options_text."','".$line_qty."','".$line_price."','".round(floatval($line_tps),2)."','".round(floatval($line_tvp),2)."','".$datetime."','".$datetime."') ; ";
                        $result3 = mysqli_query($dw3_conn, $sql_lines2);
                    }else{
                        $sql_lines = "INSERT INTO order_line (head_id,product_id,product_desc,,product_optqty_order,price,tps,tvp,date_created,date_modified)"
                        . " VALUES ('".$inserted_id."','".$row["id"]."','".$row["name_en"]."','".$options_text."','".$line_qty."','".$line_price."','".round(floatval($line_tps),2)."','".round(floatval($line_tvp),2)."','".$datetime."','".$datetime."') ; ";
                        $result2 = mysqli_query($dw3_conn, $sql_lines);
                        $sql_lines2 = "INSERT INTO invoice_line (head_id,product_id,product_desc,,product_optqty_order,price,tps,tvp,date_created,date_modified)"
                        . " VALUES ('".$inserted_id2."','".$row["id"]."','".$row["name_en"]."','".$options_text."','".$line_qty."','".$line_price."','".round(floatval($line_tps),2)."','".round(floatval($line_tvp),2)."','".$datetime."','".$datetime."') ; ";
                        $result3 = mysqli_query($dw3_conn, $sql_lines2);                   
                    }
                    //die ($sql_lines);
                    $sqlX = "INSERT INTO transfer (kind,product_id,order_id,quantity,date_created) VALUES ('EXPORT','" . $row["id"] . "','".$inserted_id."','-".$line_qty."','".$datetime."')";
                    $resultX = mysqli_query($dw3_conn, $sqlX);
                     /* $sqlX = "UPDATE product SET purchase_qty = purchase_qty + 1 WHERE id = '" . $row["id"] . "' LIMIT 1";
                    $resultX = mysqli_query($dw3_conn, $sqlX); */
                }
            } else {
                //echo "Erreur le produit #" . ltrim($cookie_key,"CART_") . " n'est plus disponible.";
            }
                //$result = mysqli_query($dw3_conn, $sql_lines);
                //if ($dw3_conn->query($sql_lines2) === TRUE) {

                //} else {
                    //$dw3_conn->close();
                    //die("Erreur: " . $dw3_conn->error);
                    //die($sql_lines);
                //}
        }

    }

    if ($qty_lines >= 1){
        if ($ship_required == true && $CIE_TRANSPORT == "INTERNAL" && $selectedService != "PICKUP"){
            $transport = $transport +floatval($CIE_TRANSPORT_PRICE??0);
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
/*         $stotal_tx = $stotal_tx - $coupon_saving;
        $tvp = round(($stotal_tx/100)*9.975,2);
        $tps = round(($stotal_tx/100)*5,2);
        $gtotal = $stotal +$tps +$tvp +$transport- $coupon_saving; */
        $sql_head="UPDATE order_head SET weight='".$cart_weight."',width='".$cart_width."',height='".$cart_height."',length='".$cart_depth."', stotal= '".$stotal."',tps= '".$tot_tps."',tvp= '".$tot_tvp."',tvh= '".$tot_tvh."',total = '".$gtotal."', transport = '".$transport."',discount='".$coupon_amount."' WHERE id = '". $inserted_id ."'" ;
        if ($dw3_conn->query($sql_head) === TRUE) {
            $sql_head="UPDATE invoice_head SET stotal= '".$stotal."',tps= '".$tot_tps."',tvp= '".$tot_tvp."',tvh= '".$tot_tvh."',total = '".$gtotal."', transport = '".$transport."',discount='".$coupon_amount."' WHERE id = '". $inserted_id2 ."'" ;
            if ($dw3_conn->query($sql_head) === TRUE) {
               echo "";
            } else {
                //$dw3_conn->close();
                die("ERR ".$sql_head);
            }
        } else {
            //$dw3_conn->close();
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

    //ajout évènement
    $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id) 
        VALUES('INVOICE','Nouvelle facture par le panier','No de Facture: ".$inserted_id2."\nCréée par: ".dw3_crypt($USER_FULLNAME) ."','". $datetime ."','".$USER."')";
    $result_task = $dw3_conn->query($sql_task); 

    echo $inserted_id2;
    $dw3_conn->close();
    ?>


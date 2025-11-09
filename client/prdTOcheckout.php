<?php
//subscription checkout process
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dompdf/autoload.inc.php';
use Dompdf\Dompdf; 
use Dompdf\Options;
require_once($_SERVER['DOCUMENT_ROOT'] . '/api/stripe/init.php');
if ($CIE_STRIPE_MODE == "" || $CIE_STRIPE_MODE == "DEV"){
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_TKEY);
} else if ($CIE_STRIPE_MODE == "PROD"){
    $stripe = new \Stripe\StripeClient($CIE_STRIPE_KEY);
}

if(isset($_COOKIE["SUBSCRIBE"])) {
    $sub_prd_id = $_COOKIE["SUBSCRIBE"];
} else {
    $sub_prd_id = "";
}

$province_tx = $CIE_PROV;

if ($USER_COMPANY != ""){
    $head_bill_to = $USER_COMPANY;
} else {
    $head_bill_to = $USER_NAME;
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

$stotal = 0.00;
$taxable = 0;
$non_taxable = 0;
$gtotal = 0.00;
$ggtotal = 0.00;
$tot_tps = 0.00;
$tot_tvp = 0.00;
$tot_tvh = 0.00;
$html_PDF = "";

        //créér lentete de commande
        $sql_head="INSERT INTO order_head (location_id,customer_id,stat,name,company,eml,tel,adr1,adr2,city,prov,country,postal_code,adr1_sh,adr2_sh,city_sh,province_sh,country_sh,postal_code_sh,date_created,date_modified,date_due) " 
        . " VALUES ('".$USER_LOC. "','".$USER."','1','".dw3_crypt($USER_FULLNAME)."','".$USER_COMPANY."','".dw3_crypt($USER_EML1)."','".dw3_crypt($USER_TEL1)."','".dw3_crypt($USER_ADR1)."','".dw3_crypt($USER_ADR2)."','".$USER_VILLE."','".$USER_PROV."','".$USER_PAYS."','".$USER_CP."','".dw3_crypt($USER_ADR1_SH)."','".dw3_crypt($USER_ADR2_SH)."','".$USER_VILLE_SH."','".$USER_PROV_SH."','".$USER_PAYS_SH."','".$USER_CP_SH."','".$datetime."','".$datetime."','".$datetime."')" ;
        if ($dw3_conn->query($sql_head) === TRUE) {
            $order_id = $dw3_conn->insert_id;
            $sql_head2="INSERT INTO invoice_head (line_source,order_id,location_id,stat,customer_id,name,company,eml,tel,adr1,adr2,city,prov,country,postal_code,adr1_sh,adr2_sh,city_sh,province_sh,country_sh,postal_code_sh,date_created,date_modified,date_due)"
            . " VALUES ('product',".$order_id.",'".$USER_LOC. "','1','".$USER."','".dw3_crypt($USER_FULLNAME)."','".$USER_COMPANY."','".dw3_crypt($USER_EML1)."','".dw3_crypt($USER_TEL1)."','".dw3_crypt($USER_ADR1)."','".dw3_crypt($USER_ADR2)."','".$USER_VILLE."','".$USER_PROV."','".$USER_PAYS."','".$USER_CP."','".dw3_crypt($USER_ADR1_SH)."','".dw3_crypt($USER_ADR2_SH)."','".$USER_VILLE_SH."','".$USER_PROV_SH."','".$USER_PAYS_SH."','".$USER_CP_SH."','".$datetime."','".$datetime."','".$datetime."')" ;
            $result4 = mysqli_query($dw3_conn, $sql_head2);
            $invoice_id = $dw3_conn->insert_id;
            $html_PDF = "<!DOCTYPE html><html><head><meta charset='utf-8'>
                <title>" . $CIE_NOM . "</title><meta http-equiv=\"Content-Type\" content=\"text/html\">
                <style>
                body { margin: 150px 30px 50px 30px; }
                @page {margin: 0cm 0cm;}
                header {position: fixed;top: 0px;left: 0px;right: 0px;height: 140px;}
                footer {position: fixed; bottom: 0px; left: 0px; right: 0px;height: 50px; }
                footer .page-number:after { content: counter(page);}
                </style></head>
                <body style='text-align:left;'>";
                $html_PDF .= "<header><table style='width:100%;'><tr><td style='text-align:left;padding:20px;'><img src='https://" . $_SERVER["SERVER_NAME"] . "/pub/img/".$CIE_LOGO2."' style='height:100px;width:auto;max-width:500px;'><br>
                    <div style='width:100%;text-align:center;'>
                    " . $CIE_EML1 . " <b> " . $CIE_TEL2 . " </b> " . $CIE_TEL1 .  "
                    </div></td>
                        <td style='text-align:right;padding:10px;'><b style='font-size:20px;'>Facture </b>#<br>Commande #<br>Compte #<br>Date de facture<br>Date due<br></td>
                        <td style='text-align:right;padding:25px;'><b style='font-size:20px;'>" .$invoice_id . "</b><br>" . $order_id. "<br>" . $USER. "<br>" . $datetime . "<br><b>" . $datetime . "</b></td></tr>
                        </table>
                </header><main><table style='width:100%;'><tr>
                                <td width='*' style='vertical-align:top;padding:20px;'><b>Facturé à:</b><br>" . $head_bill_to . "<br>" . $USER_ADR1 . "<br>"; if($USER_ADR2 != ""){ $html_PDF .= $USER_ADR2 . "<br>";} $html_PDF .= $USER_VILLE. " " . $USER_PROV . "<br>" . $USER_PAYS . ", " . $USER_CP . "</td>
                                <td width='*' style='vertical-align:top;padding:20px;'><b>Payer à:</b><br>" . $CIE_NOM . "<br>" . $CIE_ADR1; if (trim($CIE_ADR2) != ""){ $html_PDF .= "<br>" . $CIE_ADR2;} $html_PDF .= "<br>".$CIE_VILLE.", " . $CIE_PROV . "<br>" .$CIE_PAYS . ", " . $CIE_CP . "</td>
                            </tr>
                        </tr></table>
                        <table cellspacing=0 style='width:100%;border-collapse: collapse;border-left: none;border-right: none;'>
                        <tr style='background:#555;color:#EEE;text-align:left;'>
                            <th style='text-align:left;'>
                            </th><th style='text-align:left;'>Description</th><th style='text-align:center;'>Quantité</th><th style='text-align:right;'>Prix unitaire</th><th style='text-align:right;'>Avant taxes</th></tr>";
        } else {
            //$dw3_conn->close();
            die("ERR".$sql_head);
            //die("ERR".$sql_head);
        }
       
        //aller chercher les infos du produit
        $sql = "SELECT * FROM product WHERE id = '" . $sub_prd_id . "' LIMIT 1";
        //die($sql);
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            //echo ($sql );
            while($row = $result->fetch_assoc()) {
                $is_tx_fed = false;
                $is_tx_prov = false;
                $line_tvp = 0.00;
                $line_tps = 0.00;
                $line_qty = 1;
                $line_price = $row["price1"];
                $stripe_price_id = $row["stripe_price_id"];

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
                /* $sql2 = "SELECT * FROM cart_option WHERE line_id = '".$row_cart["id"]."';";
                $result2 = $dw3_conn->query($sql2);
                if ($result2->num_rows > 0) {
                    while($row2 = $result2->fetch_assoc()) { 
                        $line_price = $line_price + $row2["price"];
                    }
                } */
                
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
                $stotal = $stotal + (floatval($line_price)*$line_qty);
                $ltotal = (floatval($line_price)*$line_qty) + $line_tps + $line_tvp;

                if ($USER_LANG == "FR"){
                    $prod_desc = $row["name_fr"];
                } else {
                    $prod_desc = $row["name_en"];
                }

                    $sql_lines = "INSERT INTO order_line (head_id,product_id,product_desc,qty_order,price,tps,tvp,date_created,date_modified)"
                    . " VALUES ('".$order_id."','".$row["id"]."','".$prod_desc."','".$line_qty."','".$line_price."','".round(floatval($line_tps),2)."','".round(floatval($line_tvp),2)."','".$datetime."','".$datetime."') ; ";
                    $result2 = mysqli_query($dw3_conn, $sql_lines);
                    $sql_lines2 = "INSERT INTO invoice_line (head_id,product_id,product_desc,qty_order,price,tps,tvp,date_created,date_modified)"
                    . " VALUES ('".$invoice_id."','".$row["id"]."','".$prod_desc."','".$line_qty."','".$line_price."','".round(floatval($line_tps),2)."','".round(floatval($line_tvp),2)."','".$datetime."','".$datetime."') ; ";
                    $result3 = mysqli_query($dw3_conn, $sql_lines2);

                //die ($sql_lines);
                $sqlX = "INSERT INTO transfer (kind,product_id,order_id,quantity,date_created) VALUES ('EXPORT','" . $row["id"] . "','".$order_id."','-".$line_qty."','".$datetime."')";
                $resultX = mysqli_query($dw3_conn, $sqlX);
                    /* $sqlX = "UPDATE product SET purchase_qty = purchase_qty + 1 WHERE id = '" . $row["id"] . "' LIMIT 1";
                $resultX = mysqli_query($dw3_conn, $sqlX); */

                //PDF PART
                $filename= $row["url_img"];
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                    $filename = "/img/nd.png";
                } else {
                    if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                        $filename = "/img/nd.png";
                    }else{
                        $filename = "/fs/product/" . $row["id"] . "/" . $filename;
                    }
                }

                $html_PDF.= "<tr>";
                $html_PDF.= "<td style='border-bottom:1px solid gold;'><img src='https://" . $_SERVER["SERVER_NAME"] .  $filename . "' style='height:40px;width:auto;max-width:60px;'></td>";
                $html_PDF.= "<td style='border-bottom:1px solid gold;'>" . $prod_desc . "</td>";
                $html_PDF.= "<td style='border-bottom:1px solid gold;text-align:center;'>" . number_format($line_qty,2,'.',',') . "</td>";
                $html_PDF.= "<td style='border-bottom:1px solid gold;text-align:right;'>" . number_format($line_price,2,'.',',') . "$</td>";
                $html_PDF.= "<td style='border-bottom:1px solid gold;text-align:right;'>" . number_format($line_price*$line_qty,2,'.',',') . "$</td>";
                $html_PDF.= "</tr>";
            }
        } else {
            //echo "Erreur le produit #" . ltrim($cookie_key,"CART_") . " n'est plus disponible.";
        }
    
        $tot_tvp = round(($taxable/100)*$PTVP,2);
        $tot_tvh = round(($taxable/100)*$PTVH,2);
        $tot_tps = round(($taxable/100)*$PTPS,2);
        $gtotal = $stotal + $tot_tvp + $tot_tps + $tot_tvh;
        //update order head with totals
        $sql_head="UPDATE order_head SET stotal= '".$stotal."',tps= '".$tot_tps."',tvp= '".$tot_tvp."',tvh= '".$tot_tvh."',total = '".$gtotal."' WHERE id = '". $order_id ."'" ;
        if ($dw3_conn->query($sql_head) === TRUE) {
            $sql_head="UPDATE invoice_head  SET stotal= '".$stotal."',tps= '".$tot_tps."',tvp= '".$tot_tvp."',tvh= '".$tot_tvh."',total = '".$gtotal."' WHERE id = '". $invoice_id ."'" ;
            if ($dw3_conn->query($sql_head) === TRUE) {
               //echo "";
            } else {
                //$dw3_conn->close();
                die("ERR ".$sql_head);
            }
        } else {
            //$dw3_conn->close();
            die("ERR ". $sql_head);
        }
    
//OUTPUT INVOICE PDF
$html_PDF.= "</table>";
    $html_PDF.= "<table cellspacing=0 style='width:100%;'><tr><td width='90%'></td><td style='width:150px;'>Sous-total</td><td style='text-align:right;'><u>" . number_format($stotal,2,'.',',') . "</u>$</td></tr>";
    if ($tot_tps > 0){$html_PDF.= "<tr><td width='90%'></td><td>TPS ".$PTPS."%</td><td style='text-align:right;color:#444;'>" . number_format($tot_tps,2,'.',',') . "$</td></tr>";}
    if ($tot_tvp > 0){$html_PDF.= "<tr><td width='90%'></td><td>TVP ".$PTVP."%</td><td style='text-align:right;color:#444;'>" . number_format($tot_tvp,2,'.',',') . "$</td></tr>";}
    if ($tot_tvh > 0){$html_PDF.= "<tr><td width='90%'></td><td>TVH ".$PTVH."%</td><td style='text-align:right;color:#444;'>" . number_format($tot_tvh,2,'.',',') . "$</td></tr>";}
    $html_PDF.= "<tr><td width='90%'></td><td style='border-top:1px solid goldenrod;border-bottom:1px solid goldenrod;'>Total CA$</td><td style='text-align:right;border-bottom:1px solid goldenrod;border-top:1px solid goldenrod;'>" . number_format($gtotal,2,'.',',') . "$</td></tr>";
    $html_PDF.= "<tr><td width='90%'></td><td>Paiements</td><td style='text-align:right;'>0.00$</td></tr>";
    $html_PDF.= "<tr><td width='90%'></td><td>Balance à payer</td><td style='text-align:right;font-size:1.2em;border-bottom:1px solid goldenrod;'>" . number_format($gtotal,2,'.',',') . "$</td></tr>";
    $html_PDF.= "</table>#TPS:<b> ".$CIE_TPS."</b> | #TVQ:<b> ".$CIE_TVQ."</b><br style='margin:0px;line-height:1px;'>
    ".$CIE_INVOICE_NOTE."
    </main>";
    $html_PDF .= "<footer><hr><table style='width:100%;'><tr><th style='width:50px;border: 0px solid #333;'>&#160;&#160;</th><th style='border:0px solid grey;'>" . $CIE_NOM . "</th><th style='width:50px;border: 0px solid #333;'></th></tr></table></footer>";
    $html_PDF .= "</body></html>";
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isJavascriptEnabled', true);
    $dompdf = new Dompdf($options);
    $dompdf->set_option('defaultMediaType', 'all');
    $dompdf->set_option('isFontSubsettingEnabled', true);
    $dompdf->loadHtml($html_PDF, 'UTF-8'); 
    $dompdf->setPaper('letter', 'portrait'); 
    $dompdf->render(); 
    $font = $dompdf->getFontMetrics()->get_font("Verdana", "");
    $dompdf->get_canvas()->page_text(577, 770, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0,0,0));
    $fileatt = $dompdf->output();
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/fs/invoice/". $invoice_id. ".pdf", $fileatt);

//CLEANUP COOKIES
    /* foreach ($_COOKIE as $cookie_key=>$val) {
        if (substr($cookie_key, 0, 5) == "CART_"){
            setcookie($cookie_key,0,time() - 3600,"/");
            unset($_COOKIE[$cookie_key]); 
        }
    }
    setcookie("COUPON","",time() - 3600,"/");
    if (isset($_COOKIE["COUPON"])){unset($_COOKIE["COUPON"]);} */
    //setcookie("SUBSCRIBE","",time() - 3600,"/");
    

//CREATE PAIEMENT
$invoice_name = "Facture #" . $invoice_id;
//data from customer
$sql = "SELECT * FROM customer WHERE id = '" .  $USER . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$stripe_customer_id= $data["stripe_id"];

$checkout_session = $stripe->checkout->sessions->create([
  'line_items' => [[
    'price' => $stripe_price_id,
    'quantity' => 1,
  ]],
  'subscription_data' => [
    'billing_mode' => [
      'type' => 'flexible',
    ],
  ],
  'client_reference_id' => $order_id,
  'mode' => 'subscription',
  'customer' => $stripe_customer_id,
  'success_url' => 'https://' . $_SERVER["SERVER_NAME"] . '/client/stripe-success.php?KEY='. $KEY. '&FCT='. $invoice_id.'&FROM=subscription',
  'cancel_url' => 'https://' . $_SERVER["SERVER_NAME"] . '/client/stripe-cancel.php',
]);
$new_stripe_id = $checkout_session->id;
$new_stripe_status = $checkout_session->payment_status;
//data from customer
$sql = "INSERT INTO transaction (invoice_id,stripe_checkout_session_id,payment_status,payment_type,created,modified) VALUES('" . $invoice_id . "','" .  $new_stripe_id . "','" .  $new_stripe_status . "','Stripe','".$datetime."','".$datetime."')";
$result = mysqli_query($dw3_conn, $sql);
$sql = "UPDATE invoice_head SET stripe_checkout_session_id ='" .  $new_stripe_id . "' WHERE id = '" . $invoice_id  . "'";
$result = mysqli_query($dw3_conn, $sql);

    //ajout évènement
    $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id) 
        VALUES('INVOICE','Nouvelle facture par le checkout','No de Facture: ".$invoice_id."\nCréée par: ".dw3_crypt($USER_FULLNAME) ."','". $datetime ."','".$USER."')";
    $result_task = $dw3_conn->query($sql_task); 

$dw3_conn->close();
header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
?>


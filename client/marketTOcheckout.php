<?php
//cart to order to invoice
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

$ad_id = $_GET['ID']??'';
$ad_qty = $_GET['Q']??'';

if ($USER_COMPANY != ""){
    $head_bill_to = $USER_COMPANY;
} else {
    $head_bill_to = $USER_NAME;
}

//ad infos
$sql = "SELECT * FROM classified WHERE id = '".$ad_id."' LIMIT 1;";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$gtotal = round($data["price"]*$ad_qty,2);
//location infos
$sql2 = "SELECT * FROM customer WHERE id = '".$data["customer_id"]."' LIMIT 1;";
$result2 = mysqli_query($dw3_conn, $sql2);
$data2 = mysqli_fetch_assoc($result2);
$location_id= $data2["retailer_loc_id"];
if ($data2["company"]!= ""){$location_name= $data2["company"];}else{$location_name= $data2["last_name"];}
$location_adr= dw3_decrypt($data2["adr1"]);if ($data2["adr2"] != ""){$location_adr .= "<br>".dw3_decrypt($data2["adr2"]);} $location_adr .= "<br>".$data2["city"].", ".$data2["province"]."<br>".$data2["country"].", ".$data2["postal_code"];

$sql_head="INSERT INTO order_head (stotal,total,location_id,customer_id,stat,ship_type,name,company,eml,tel,adr1,adr2,city,prov,country,postal_code,adr1_sh,adr2_sh,city_sh,province_sh,country_sh,postal_code_sh,date_created,date_modified,date_due) " 
. " VALUES ('".$gtotal."','".$gtotal."','".$location_id. "','".$USER."','1','PICKUP','".dw3_crypt($USER_FULLNAME)."','".$USER_COMPANY."','".dw3_crypt($USER_EML1)."','".dw3_crypt($USER_TEL1)."','".dw3_crypt($USER_ADR1)."','".dw3_crypt($USER_ADR2)."','".$USER_VILLE."','".$USER_PROV."','".$USER_PAYS."','".$USER_CP."','".dw3_crypt($USER_ADR1_SH)."','".dw3_crypt($USER_ADR2_SH)."','".$USER_VILLE_SH."','".$USER_PROV_SH."','".$USER_PAYS_SH."','".$USER_CP_SH."','".$datetime."','".$datetime."','".$datetime."')" ;
if ($dw3_conn->query($sql_head) === TRUE) {
    $order_id = $dw3_conn->insert_id;
    $sql_head2="INSERT INTO invoice_head (line_source,stotal,total,order_id,location_id,stat,ship_type,customer_id,name,company,eml,tel,adr1,adr2,city,prov,country,postal_code,adr1_sh,adr2_sh,city_sh,province_sh,country_sh,postal_code_sh,date_created,date_modified,date_due)"
    . " VALUES ('classified','".$gtotal."','".$gtotal."',".$order_id.",'".$location_id. "','1','PICKUP','".$USER."','".dw3_crypt($USER_FULLNAME)."','".$USER_COMPANY."','".dw3_crypt($USER_EML1)."','".dw3_crypt($USER_TEL1)."','".dw3_crypt($USER_ADR1)."','".dw3_crypt($USER_ADR2)."','".$USER_VILLE."','".$USER_PROV."','".$USER_PAYS."','".$USER_CP."','".dw3_crypt($USER_ADR1_SH)."','".dw3_crypt($USER_ADR2_SH)."','".$USER_VILLE_SH."','".$USER_PROV_SH."','".$USER_PAYS_SH."','".$USER_CP_SH."','".$datetime."','".$datetime."','".$datetime."')" ;
    $result4 = mysqli_query($dw3_conn, $sql_head2);
    $invoice_id = $dw3_conn->insert_id;
}

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
                            <td width='*' style='vertical-align:top;padding:20px;'><b>Facturé à:</b><br>" . $head_bill_to . "<br>" . $USER_ADR1 . "<br>"; if($USER_ADR2 != ""){ $html_PDF .= $USER_ADR2 . "<br>";} $html_PDF .= $USER_VILLE. ", " . $USER_PROV . "<br>" . $USER_PAYS . ", " . $USER_CP . "</td>
                            <td width='*' style='vertical-align:top;padding:20px;'><b>Payer à:</b><br>" . $CIE_NOM . "<br>" . $CIE_ADR1; if (trim($CIE_ADR2) != ""){ $html_PDF .= "<br>" . $CIE_ADR2;} $html_PDF .= "<br>".$CIE_VILLE.", " . $CIE_PROV . "<br>" .$CIE_PAYS . ", " . $CIE_CP . "</td>
                            <td width='*' style='vertical-align:top;padding:20px;'><b>Ramasser à:</b><br>" .$location_name."<br>". $location_adr . "</td>
                        </tr>
                    </tr></table>
                    <table cellspacing=0 style='width:100%;border-collapse: collapse;border-left: none;border-right: none;'>
                    <tr style='background:#555;color:#EEE;text-align:left;'><th style='text-align:left;'></th><th style='text-align:left;'>Produit</th><th style='text-align:left;'>Description</th><th style='text-align:right;'>Quantité</th><th style='text-align:right;'>Prix avec taxes</th></tr>";



        $RNDSEQ=rand(100,100000);
        $filename= $data["img_link"];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $data["customer_id"] . "/" . $filename)){
            $filename = "/pub/img/dw3/nd.png";
        } else {
            if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $data["customer_id"] . "/" . $filename)){
                $filename = "/pub/img/dw3/nd.png";
            }else{
                $filename = "/fs/customer/" . $data["customer_id"] . "/" . $filename;
            }
        }

        $sql_lines = "INSERT INTO order_line (head_id,classified_id,product_desc,qty_order,price,tps,tvp,date_created,date_modified)"
        . " VALUES ('".$order_id."','".$ad_id."','".$data["name_fr"]."','".$ad_qty."','".$gtotal."','0','0','".$datetime."','".$datetime."') ; ";
        $result2 = mysqli_query($dw3_conn, $sql_lines);
        $sql_lines2 = "INSERT INTO invoice_line (head_id,classified_id,product_desc,qty_order,price,tps,tvp,date_created,date_modified)"
        . " VALUES ('".$invoice_id."','".$ad_id."','".$data["name_fr"]."','".$ad_qty."','".$gtotal."','0','0','".$datetime."','".$datetime."') ; ";
        $result3 = mysqli_query($dw3_conn, $sql_lines2);

        $html_PDF.= "<tr>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;'><img src='https://" . $_SERVER["SERVER_NAME"] .  $filename . "' style='height:40px;width:auto;max-width:60px;'></td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;'>" . $data["name_fr"] . "</td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;text-align:center;'>" . substr($data["description_fr"],0,30) . "</td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;text-align:center;'>" . $ad_qty . "</td>";
        $html_PDF.= "<td style='border-bottom:1px solid gold;text-align:right;'>" . number_format($gtotal,2,'.',',') . "$</td>";
        $html_PDF.= "</tr>";

//OUTPUT INVOICE PDF
$html_PDF.= "</table>";
    $html_PDF.= "<div style='width:100%;margin-top:150px;'>#TPS:<b> ".$CIE_TPS."</b> | #TVQ:<b> ".$CIE_TVQ."</b></div><br style='margin:0px;line-height:1px;'>
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
    foreach ($_COOKIE as $cookie_key=>$val) {
        if (substr($cookie_key, 0, 5) == "AD_"){
            setcookie($cookie_key,0,time() - 3600,"/");
            unset($_COOKIE[$cookie_key]); 
        }
    }

//CREATE PAIEMENT
$invoice_name = "Facture #" . $invoice_id;
//data from customer
$sql = "SELECT * FROM customer WHERE id = '" .  $USER . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$stripe_customer_id= $data["stripe_id"];

$checkout_session = $stripe->checkout->sessions->create([
  'line_items' => [[
    'price_data' => [
      'currency' => 'cad',
      'product_data' => [
        'name' => $invoice_name,
      ],
      'unit_amount' => number_format($gtotal,2,'',''),
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'customer' => $stripe_customer_id,
  'success_url' => 'https://' . $_SERVER["SERVER_NAME"] . '/client/stripe-success.php?KEY='. $KEY. '&FCT='. $invoice_id.'&FROM=market',
  'cancel_url' => 'https://' . $_SERVER["SERVER_NAME"] . '/client/stripe-cancel.php',
]);
$new_stripe_id = $checkout_session->id;
$new_stripe_status = $checkout_session->payment_status;
//updater la commande dans le systeme avec checkout session id
//data from customer
$sql = "INSERT INTO transaction (invoice_id,stripe_checkout_session_id,payment_status,payment_type,created,modified) VALUES('" . $invoice_id . "','" .  $new_stripe_id . "','" .  $new_stripe_status . "','Stripe','".$datetime."','".$datetime."')";
$result = mysqli_query($dw3_conn, $sql);
$sql = "UPDATE invoice_head SET stripe_checkout_session_id ='" .  $new_stripe_id . "' WHERE id = '" . $invoice_id  . "'";
$result = mysqli_query($dw3_conn, $sql);
$sql = "UPDATE classified SET qty_available = qty_available - ".$ad_qty." WHERE id = '" . $ad_id  . "'";
$result = mysqli_query($dw3_conn, $sql);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
$dw3_conn->close();
?>


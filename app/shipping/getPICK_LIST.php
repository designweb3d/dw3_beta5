<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dompdf/autoload.inc.php';

$head_id  = $_GET['ID'];

use Dompdf\Dompdf; 
use Dompdf\Options;

//data from shipment_head
$sqls = "SELECT * FROM shipment_head WHERE id = '" . $head_id . "' LIMIT 1";
$results = mysqli_query($dw3_conn, $sqls);
$datas = mysqli_fetch_assoc($results);
$order_id = $datas['order_id'];
$shipment_id = $datas['shipment_id'];
$tracking_number = $datas['tracking_number'];
$tracking_url = $datas['tracking_url'];
$label_link = $datas['label_link'];
$stat = $datas['stat'];
$weight = $datas['weight'];
$length = $datas['length'];
$width = $datas['width'];
$height = $datas['height'];
$size = round(($datas['height']*$datas['width']*$datas['length']),2);
$transport_price = round($datas['transport_price'],2);
$ship_type = $datas['ship_type'];
$ship_code = $datas['ship_code'];

//data from order_head
$sql = "SELECT * FROM order_head WHERE id = '" . $order_id . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
/* $transport = round($data['transport'],2);
$ship_type = $data['ship_type'];
$ship_code = $data['ship_code']; */
$location_id = $data['location_id'];
$customer_id = $data['customer_id'];
/* $stat = $data['stat'];
$weight = $data['weight'];
$length = $data['length'];
$width = $data['width'];
$height = $data['height'];
$size = round(($data['height']*$data['width']*$data['length']),2); */
//$sh_so = $data['sh_so'];
//$sh_pa18 = $data['sh_pa18'];
$sh_drop = $data['sh_drop'];
/* $shipment_id = $data['shipment_id'];
$tracking_number = $data['tracking_number'];
$tracking_url = $data['tracking_url'];
$label_link = $data['label_link']; */
$notif_sh = $data['notif_shipment'];
$notif_ex = $data['notif_exception'];
$notif_de = $data['notif_delivery'];
$name = dw3_decrypt($data['name']);
$order_created = $data['date_created'];
$order_due = $data['date_due'];
$company = $data['company'];
$eml = dw3_decrypt($data['eml']);
$tel = dw3_decrypt($data['tel']);
$adr1 = dw3_decrypt($data['adr1_sh']);
$adr2 = dw3_decrypt($data['adr2_sh']);
$city = $data['city_sh'];
$province = $data['province_sh'];
$country = $data['country_sh'];
$cp = $data['postal_code_sh'];

//data from location
$sql = "SELECT * FROM location WHERE id = '" . $location_id . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$loc_name = $data['name'];
$loc_adr1 = $data['adr1'];
$loc_adr2 = $data['adr2'];
$loc_city = $data['city'];
$loc_province = $data['province'];
$loc_country = $data['country'];
$loc_cp = $data['postal_code'];

$html_PDF = "<!DOCTYPE html><html><head><meta charset='utf-8'>
    <title>Pick List for " . $name . "</title><meta http-equiv=\"Content-Type\" content=\"text/html\"><link rel=\"shortcut icon\" href=\"/pub/img/favicon.ico\">
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
        <td style='text-align:right;padding:10px;'><b style='font-size:20px;'>Expédition </b>#<br>Commande #<br>Compte #<br>Date de commande<br>Date due<br></td>
        <td style='text-align:right;padding:25px;'><b style='font-size:20px;'>" . $head_id . "</b><br>" . $order_id . "<br>" . $customer_id . "<br>" . substr($order_created,0,10) . "<br><b>" . substr($order_due,0,10) . "</b></td></tr>
        </table>
    </header><main><table style='width:100%;'><tr>
            <td width='*' style='vertical-align:top;padding:20px;'><b>Expédier à:</b><br>" . $name . "<br>" . $adr1 . "<br>"; if($adr2 != ""){ $html_PDF .= $adr2 . "<br>";} $html_PDF .= $city . " " . $province . "<br>" . $country . " " . $cp . "</td>
            <td width='*' style='vertical-align:top;padding:20px;'><b>Expédier de:</b><br>" . $loc_name . "<br>" . $loc_adr1; if (trim($loc_adr2) != ""){ $html_PDF .= "<br>" . $loc_adr2;} $html_PDF .= "<br>".$loc_city." " . $loc_province . "<br>" .$loc_country . " " . $loc_cp . "</td>
            <td>
                Commande<br><img src='https://" . $_SERVER["SERVER_NAME"] . "/fs/order/". $order_id .".svg' style='height:30px;width:auto;max-width:200px;'>
                <br>Expédition<br><img src='https://" . $_SERVER["SERVER_NAME"] . "/fs/order/". $order_id . "_".$head_id.".svg' style='height:30px;width:auto;max-width:200px;'>
            </td>
        </tr>
    </tr></table>";
//$html_PDF .= "<h2 style='text-align:center;'>Feuillet de ramassage</h2>";
$html_PDF .= "<div style='max-width:100%;overflow-x:auto;'><table class='tblSIMPLE' style='width:100%;max-width:100%;white-space:normal;'>
        <thead style='border-bottom:2px solid #444;'>
            <tr>
                <th style='width:10%;'></th>
                <th style='white-space:nowrap;width:50%;text-align:left;'></th>
                <th style='white-space:nowrap;width:10%;border-right:1px solid #444;font-size:smaller;'> Commandé </th>
                <th style='white-space:nowrap;width:10%;border-right:1px solid #444;font-size:smaller;'> Déjà expédié </th>
                <th style='white-space:nowrap;width:10%;border-right:1px solid #444;font-size:smaller;'> À expédier </th>
                <th style='white-space:nowrap;width:5%;border-right:1px solid #444;font-size:smaller;'> Kg unit. </th>
                <th style='white-space:nowrap;width:5%;font-size:smaller;'> Kg total </th>
            </tr>
        </thead>
        <tbody>";
        $sql = "SELECT A.id as sh_line_id, A.qty_shipped as qty_to_ship, B.name_fr, B.kg, B.upc as product_upc, B.ship_type, B.url_img as url_img, C.qty_order as qty_order, C.qty_shipped as qty_shipped, C.product_id as product_id
                FROM shipment_line A
                LEFT JOIN (select id, qty_order, qty_shipped, product_id FROM order_line) C ON A.line_id = C.id 
                LEFT JOIN (select id, name_fr, kg, upc, ship_type, url_img FROM product) B ON C.product_id = B.id 
                WHERE head_id = '".$head_id."' 
                ORDER BY A.id ASC;";
                //die ($sql);
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($row["product_upc"] != ""){
                    $product_no = "UPC: ".$row["product_upc"];
                } else {
                    $product_no = "ID: ".$row["product_id"];
                }
                //format data to remove decimals if not needed
                if (floor($row["kg"]) == $row["kg"]) { $row["kg"] = number_format($row["kg"], 0, '.', ','); } else {$row["kg"] = number_format($row["kg"], 2, '.', ',');}
                if (floor($row["qty_order"]) == $row["qty_order"]) {
                    $qty_order = number_format($row["qty_order"], 0, '.', ',');
                } else {
                    $qty_order = number_format($row["qty_order"], 2, '.', ',');
                }
                if (floor($row["qty_shipped"]) == $row["qty_shipped"]) {
                    $qty_shipped = number_format($row["qty_shipped"], 0, '.', ',');
                } else {
                    $qty_shipped = number_format($row["qty_shipped"], 2, '.', ',');
                }
                $qty_to_ship =  $row["qty_to_ship"];
                if (floor($qty_to_ship) == $qty_to_ship) {
                    $qty_to_ship = number_format($qty_to_ship, 0, '.', ',');
                } else {
                    $qty_to_ship = number_format($qty_to_ship, 2, '.', ',');
                }
                $html_PDF .= "<tr>
                        <td style='white-space:nowrap;border-bottom:1px solid #777;'>" . $product_no . "</span></td>
                        <td style='border-bottom:1px solid #333;'>" . $row["name_fr"] . "</td>
                        <td style='text-align:center;color:grey;border-bottom:1px solid #777;'>" . $qty_order . "</td>
                        <td style='text-align:center;color:grey;border-bottom:1px solid #777;'>" . $qty_shipped . "</td>
                        <td style='text-align:center;border-bottom:1px solid #333;'><b>" . $qty_to_ship . "</b></td>
                        <td style='text-align:center;color:grey;border-bottom:1px solid #777;'>" . $row["kg"] . "</td>
                        <td style='text-align:center;border-bottom:1px solid #333;'><b>" . $row["kg"]*$qty_to_ship . "</b></td>
                    </tr>";
            }
        }

$html_PDF .= "</main>";
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

$dw3_conn->close();
$filename = "Pick_List_".$head_id.".pdf";
$dompdf->stream($filename);
?>
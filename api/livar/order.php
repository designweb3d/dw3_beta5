<?php
header("X-Robots-Tag: noindex, nofollow", true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$shID  = $_GET['shID'];
//data from shipment_head
$sqls = "SELECT * FROM shipment_head WHERE id = '" . $shID . "' LIMIT 1";
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

//data from head
$sql = "SELECT * FROM order_head WHERE id = '" . $order_id . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$location_id = $data['location_id'];
//$transport = $data['transport'];
/* $weight = $data['weight'];
$length = $data['length'];
$width = $data['width'];
$height = $data['height']; */
$sh_drop = $data['sh_drop'];
/* $ship_type = $data['ship_type'];
$ship_code = $data['ship_code']; */
$notif_sh = $data['notif_shipment'];
$notif_ex = $data['notif_exception'];
$notif_de = $data['notif_delivery'];
$to_name = dw3_decrypt($data['name']);
$to_company = $data['company'];
$to_eml = dw3_decrypt($data['eml']);
$to_tel = dw3_decrypt($data['tel']);
$to_adr1 = dw3_decrypt($data['adr1_sh']);
$to_adr2 = dw3_decrypt($data['adr2_sh']);
$to_city = $data['city_sh'];
$to_province = $data['province_sh'];
$to_country = $data['country_sh'];
$to_postalCode = $data['postal_code_sh'];
//data from location
$sql = "SELECT * FROM location WHERE id = '" . $location_id. "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$from_adr1 = $data['adr1'];
$from_adr2 = $data['adr2'];
$from_city = $data['city'];
$from_province = $data['province'];
$from_country = $data['country'];
$from_postalCode = $data['postal_code'];

if ($sh_drop == 'SO'){
    $signature = true;
} else {
    $signature = false;
}

if ($ship_type == 'ICS'){
    if ($ship_code == "REGULAR"){
        $ship_code = "GROUND";
    } else if ($ship_code == "EXPRESS"){
        $ship_code = "NEXTDAY";
    } else {
        $ship_code = "GROUND";
    }
} else if ($ship_type == 'PUROLATOR'){
    if ($ship_code == "REGULAR"){
        $ship_code = "GROUND";
    } else if ($ship_code == "EXPRESS"){
        $ship_code = "EXPRESS";
    } else {
        $ship_code = "GROUND";
    }
} else if ($ship_type == 'NATIONEX'){
    if ($ship_code == "REGULAR"){
        $ship_code = "REGULAR";
    } else if ($ship_code == "EXPRESS"){
        $ship_code = "REGULAR";
    } else {
        $ship_code = "REGULAR";
    }
} else if ($ship_type == 'DICOM'){
    if ($ship_code == "REGULAR"){
        $ship_code = "REGULAR";
    } else if ($ship_code == "EXPRESS"){
        $ship_code = "REGULAR";
    } else {
        $ship_code = "REGULAR";
    }
} else if ($ship_type == 'CANADAPOST'){
    if ($ship_code == "REGULAR"){
        $ship_code = "EXPEDITED";
    } else if ($ship_code == "EXPRESS"){
        $ship_code = "XPRESS";
    } else {
        $ship_code = "EXPEDITED";
    }
}

if ($length == '' || $length == '0'){
    $length = '3';
} else {
    $length = round(floatval($length) * 0.393701,1);
}
if ($width == '' || $width == '0'){
    $width = '3';
} else {
    $width = round(floatval($width) * 0.393701,1);
}
if ($height == '' || $height == '0'){
    $height = '3';
} else {
    $height = round(floatval($height) * 0.393701,1);
}
if ($weight == '' || $weight == '0'){
    $weight = '1';
} else {
    $weight = round(floatval($weight) * 2.2,1);
}

if($CIE_LIVAR_MODE =="PROD"){
    $base_url = 'https://api.montrealdropship.com/v1/';
    $service_url = $base_url . 'order?apiKey='.$CIE_LIVAR_KEY;
} else {
    $base_url = 'https://apidev.montrealdropship.com/v1/';
    $service_url = $base_url . 'order?apiKey='.$CIE_LIVAR_DEV;
}

//build items array
$items = array();
$sql = "SELECT A.*, B.ship_type ,B.upc as product_upc
        FROM order_line A 
        LEFT JOIN (select id, ship_type, upc FROM product) B ON A.product_id = B.id 
        WHERE head_id = '".$enID."' AND B.ship_type = 'CARRIER';";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row["product_upc"] != ""){
            $product_no = "UPC: ".$row["product_upc"];
        } else {
            $product_no = "ID: ".$row["product_id"];
        }

        $items[] = array("partNo" => $product_no, "name" => $row["product_desc"], "qty" => $row["qty_order"]);
    }
}

$data = ["order" => array(
    "orderType" => "label",
    "items" => $items,
    "insurance" => 0,
    "signature" => $signature,
    "dangerous"=> false,
    "deliveryCost"=> $transport_price,
    "language"=> "FR",
    "carrierNotes"=> "",
    "carrierCode"=> $ship_type,
    "carrierServiceCode"=> $ship_code,
    "reference1"=> "Order #".$enID,
    "reference2"=> null,
    "reference3"=> null,
    "shipFrom" => array(
        "name" => $CIE_NOM,
        "address1" => $from_adr1,
        "address2" => $from_adr2,
        "postalcode" => str_replace(" ","",$from_postalCode),
        "phone1" =>  str_replace(" ","",str_replace("-","",str_replace("(","",str_replace(")","",str_replace(".","",$CIE_TEL1))))),
        "city" => $from_city,
        "sendEmailNotification" => true,
        "sendEmailShipment" => true,
        "email" => $CIE_EML1
    ),
    "deliverTo" => array(
        "name" => $to_name,
        "address1" => $to_adr1,
        "address2" => $to_adr2,
        "postalcode" => str_replace(" ","",$to_postalCode),
        "phone1" => str_replace(" ","",str_replace("-","",str_replace("(","",str_replace(")","",str_replace(".","",$to_tel))))),
        "city" => $to_city,
        "sendEmailNotification" => true,
        "email" => $to_eml
    ),
    "packages" => array (array(
        "width" => $width,
        "length" => $length,
        "height" => $height,
        "weight" => $weight
    )),
)];

$ch = curl_init( $service_url );
$payload = json_encode( $data );
//die($payload);

curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$result = curl_exec($ch);
curl_close($ch);

//die($result);
$response = json_decode($result);
//die($response->carriers[1]->carrierCode);
if (isset($response->errDetails)){
    die ($response->errDetails[0]->errDetail);
}
$orderNumber = $response->orderNumber;
$trackingNumber = $response->trackingNumber;
$trackingUrl = $response->trackingUrl;

#exemple de réponse
/* 
{ 
"carrierName": "Dicom", 
"orderNumber": 72, 
"trackingNumber": "P00207336", 
"trackingUrl": "https://www.dicom.com/fr/dicomexpress/suivi/detailssuivi/P00207336?Division=DicomExpress" 
} 
*/

//$label_link = file_get_contents($base_url.'order/documents/'.$orderNumber);
//$data = ["order" => array(
$service_url = $base_url . 'order/documents/'.$orderNumber.'?apiKey='.$CIE_LIVAR_KEY;
    $ch = curl_init( $service_url );
    $payload = json_encode( $data );
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
    //curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $result = curl_exec($ch);
    curl_close($ch);
    
    //echo($result);
    $response = json_decode($result);
    $label_link = $response->documentURL[0];

$sql = "UPDATE shipment_head SET    
stat = '1',
shipment_id = '" . $orderNumber. "',
tracking_url = '".$trackingUrl."',
tracking_number = '".$trackingNumber."',
label_link = '".$label_link."'
WHERE id = '" . $shID . "' LIMIT 1";
if ($dw3_conn->query($sql) === TRUE) {
    echo "Requête d'expédition réussi.<br>Imprimez l'étiquette et placez la sur la boite.<br>Ensuite vous devez faire une <u><a style='color:var(--dw3_msg_color);' href='https://client.livraisonsarabais.com/dashboards/default' target='_blank'>demande de ramassage</a></u> pour que le transporteur vienne chercher les commandes.";
} else {
 echo $dw3_conn->error;
}
$dw3_conn->close();
?>
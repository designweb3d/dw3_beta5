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
/* $tracking_number = $datas['tracking_number'];
$tracking_url = $datas['tracking_url'];
$label_link = $datas['label_link'];
$stat = $datas['stat']; */
$weight = $datas['weight'];
$length = $datas['length'];
$width = $datas['width'];
$height = $datas['height'];
$size = round(($datas['height']*$datas['width']*$datas['length']),2);
$transport_price = round($datas['transport_price'],2);
$carrierCode = $data['ship_type'];
$serviceCode = $data['ship_code'];

//data from head
$sql = "SELECT * FROM order_head WHERE id = '" . $order_id . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$location_id = $data['location_id'];
/* $transport = $data['transport'];
$weight = $data['weight'];
$length = $data['length'];
$width = $data['width'];
$height = $data['height']; */
/* $carrierCode = $data['ship_type'];
$serviceCode = $data['ship_code']; */
$postalCode = $data['postal_code_sh'];
//data from location
$sql = "SELECT * FROM location WHERE id = '" . $location_id. "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$originPostalCode = $data['postal_code'];

if ($carrierCode == 'ICS'){
    if ($serviceCode == "REGULAR"){
        $serviceCode = "GROUND";
    } else if ($serviceCode == "EXPRESS"){
        $serviceCode = "NEXTDAY";
    } else {
        $serviceCode = "GROUND";
    }
} else if ($carrierCode == 'PUROLATOR'){
    if ($serviceCode == "REGULAR"){
        $serviceCode = "GROUND";
    } else if ($serviceCode == "EXPRESS"){
        $serviceCode = "EXPRESS";
    } else {
        $serviceCode = "GROUND";
    }
} else if ($carrierCode == 'NATIONEX'){
    if ($serviceCode == "REGULAR"){
        $serviceCode = "REGULAR";
    } else if ($serviceCode == "EXPRESS"){
        $serviceCode = "REGULAR";
    } else {
        $serviceCode = "REGULAR";
    }
} else if ($carrierCode == 'DICOM'){
    if ($serviceCode == "REGULAR"){
        $serviceCode = "REGULAR";
    } else if ($serviceCode == "EXPRESS"){
        $serviceCode = "REGULAR";
    } else {
        $serviceCode = "REGULAR";
    }
} else if ($carrierCode == 'CANADAPOST'){
    if ($serviceCode == "REGULAR"){
        $serviceCode = "EXPEDITED";
    } else if ($serviceCode == "EXPRESS"){
        $serviceCode = "XPRESS";
    } else {
        $serviceCode = "EXPEDITED";
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
    $weight = round(floatval($weight) * 2.20462,1);
}
if ($originPostalCode == ''){
    $originPostalCode = str_replace(" ","",$CIE_CP);
}
if ($postalCode == ''){
    die("69.99");
}

if($CIE_LIVAR_MODE =="PROD"){
    $service_url = 'https://api.montrealdropship.com/v1/carrier/quote?apiKey='.$CIE_LIVAR_KEY;
} else {
    $service_url = 'https://apidev.montrealdropship.com/v1/carrier/quote?apiKey='.$CIE_LIVAR_DEV ;
}

$data = array(
    "packages" => array (array(
        "width" => $width,
        "length" => $length,
        "height" => $height,
        "weight" => $weight
    )),
    "signature" => false,
    "insurance" => 0,
    "dangerous"=> false,
    "postalcode"=> $postalCode,
    "postalcodeFrom"=> $originPostalCode
);

$ch = curl_init( $service_url );
$payload = json_encode( $data );

curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$result = curl_exec($ch);
curl_close($ch);
$response = json_decode($result);
//error_log($result);
foreach($response->carriers as $mycarrier)    {
    if ($mycarrier->carrierCode == $carrierCode){
        foreach($mycarrier->prices as $carrierprices)    {
            if ($carrierprices->serviceCode == $serviceCode){
                $dw3_conn->close();
                die($carrierprices->cost);
            } 
        }
    }
} 

$dw3_conn->close();
die("NA");
?>
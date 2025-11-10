<?php
header("X-Robots-Tag: noindex, nofollow", true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 

$serviceCode = mysqli_real_escape_string($dw3_conn,$_GET['S']);
$originPostalCode = mysqli_real_escape_string($dw3_conn,$_GET['CP1']);
$postalCode = mysqli_real_escape_string($dw3_conn,$_GET['CP2']);
$height = mysqli_real_escape_string($dw3_conn,$_GET['H']);
$width = mysqli_real_escape_string($dw3_conn,$_GET['W']);
$length = mysqli_real_escape_string($dw3_conn,$_GET['L']);
$weight = mysqli_real_escape_string($dw3_conn,$_GET['LB']);

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
    die("Erreur de CP");
}

if($CIE_LIVAR_MODE =="PROD"){
    $service_url = 'https://api.montrealdropship.com/v1/carrier/quote?apiKey='.$CIE_LIVAR_KEY;
} else {
    $service_url = 'https://apidev.montrealdropship.com/v1/carrier/quote?apiKey='.$CIE_LIVAR_DEV;
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
//die($payload);

curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$result = curl_exec($ch);
curl_close($ch);

//die($result);
$response = json_decode($result);
//die($response->carriers[1]->carrierCode);
$best_price_r = 50000;
$selected_carrier_r = "NA";
$selected_service_r = "ND";
$selected_date_r = "";
$best_price_r = 50000000;
$best_price_x = 50000000;
$selected_carrier_x = "NA";
$selected_service_x = "ND";
$selected_date_x = "";

//find best regular price
    foreach($response->carriers as $mycarrier)    {
        if ($mycarrier->carrierCode == "DICOM"){
            if ($mycarrier->pickupService == true){
                foreach($mycarrier->prices as $carrierprices)    {
                    if ($carrierprices->cost < $best_price_r && $carrierprices->serviceCode == "REGULAR"){
                        $best_price_r = $carrierprices->cost;
                        $selected_carrier_r = "DICOM";
                        $selected_service_r = $carrierprices->serviceCode;
                        $selected_date_r = $carrierprices->deliveryDate;
                    } 
                }
            } 
        }
        if ($mycarrier->carrierCode == "ICS"){
            if ($mycarrier->pickupService == true){
                foreach($mycarrier->prices as $carrierprices)    {
                    if ($carrierprices->cost < $best_price_r && $carrierprices->serviceCode == "GROUND"){
                        $best_price_r = $carrierprices->cost;
                        $selected_carrier_r = "ICS";
                        $selected_service_r = $carrierprices->serviceCode;
                        $selected_date_r = $carrierprices->deliveryDate;
                    } 
                }
            } 
        }
        if ($mycarrier->carrierCode == "NATIONEX"){
            if ($mycarrier->pickupService == true){
                foreach($mycarrier->prices as $carrierprices)    {
                    if ($carrierprices->cost < $best_price_r && $carrierprices->serviceCode == "REGULAR"){
                        $best_price_r = $carrierprices->cost;
                        $selected_carrier_r = "NATIONEX";
                        $selected_service_r = $carrierprices->serviceCode;
                        $selected_date_r = $carrierprices->deliveryDate;
                    } 
                }
            } 
        }
        if ($mycarrier->carrierCode == "CANADAPOST"){
            if ($mycarrier->pickupService == true){
                foreach($mycarrier->prices as $carrierprices)    {
                    if ($carrierprices->cost < $best_price_r && $carrierprices->serviceCode == "EXPEDITED"){
                        $best_price_r = $carrierprices->cost;
                        $selected_carrier_r = "CANADAPOST";
                        $selected_service_r = $carrierprices->serviceCode;
                        $selected_date_r = $carrierprices->deliveryDate;
                    } 
                }
            } 
        }
        if ($mycarrier->carrierCode == "PUROLATOR"){
            if ($mycarrier->pickupService == true){
                foreach($mycarrier->prices as $carrierprices)    {
                    if ($carrierprices->cost < $best_price_r && $carrierprices->serviceCode == "GROUND"){
                        $best_price_r = $carrierprices->cost;
                        $selected_carrier_r = "PUROLATOR";
                        $selected_service_r = $carrierprices->serviceCode;
                        $selected_date_r = $carrierprices->deliveryDate;
                    } 
                }
            } 
        }
    } 
//find best express price
    foreach($response->carriers as $mycarrier) {
        if ($mycarrier->carrierCode == "ICS"){
            if ($mycarrier->pickupService == true){
                foreach($mycarrier->prices as $carrierprices)    {
                    if ($carrierprices->cost < $best_price_x && $carrierprices->serviceCode == "NEXTDAY"){
                        $best_price_x = $carrierprices->cost;
                        $selected_carrier_x = "ICS";
                        $selected_service_x = $carrierprices->serviceCode;
                        $selected_date_x = $carrierprices->deliveryDate;
                    } 
                }
            } 
        }
        if ($mycarrier->carrierCode == "CANADAPOST"){
            if ($mycarrier->pickupService == true){
                foreach($mycarrier->prices as $carrierprices)    {
                    if ($carrierprices->cost < $best_price_x && $carrierprices->serviceCode == "XPRESS"){
                        $best_price_x = $carrierprices->cost;
                        $selected_carrier_x = "CANADAPOST";
                        $selected_service_x = $carrierprices->serviceCode;
                        $selected_date_x = $carrierprices->deliveryDate;
                    } 
                }
            } 
        }
        if ($mycarrier->carrierCode == "PUROLATOR"){
            if ($mycarrier->pickupService == true){
                foreach($mycarrier->prices as $carrierprices)    {
                    if ($carrierprices->cost < $best_price_x && $carrierprices->serviceCode == "EXPRESS" || $carrierprices->cost < $best_price && $carrierprices->serviceCode == "EXPRESS9" || $carrierprices->cost < $best_price && $carrierprices->serviceCode == "EXPRESS1030"){
                        $best_price_x = $carrierprices->cost;
                        $selected_carrier_x = "CANADAPOST";
                        $selected_service_x = $carrierprices->serviceCode;
                        $selected_date_x = $carrierprices->deliveryDate;
                    } 
                }
            } 
        }
    } 

if ($best_price_r == 50000000){
    $best_price_r = 0;
}
if ($best_price_x == 50000000){
    $best_price_x = 0;
}

echo '{"carrier_r":"'.$selected_carrier_r.'", "date_r":"' . $selected_date_r . '", "price_r":"' . $best_price_r . '", "service_r":"' . $selected_service_r . '","carrier_x":"'.$selected_carrier_x.'", "date_x":"' . $selected_date_x . '", "price_x":"' . $best_price_x . '", "service_x":"' . $selected_service_x . '"} ';
$dw3_conn->close();
#exemples de réponses
#{"warnDetails":[],"ValidationResult":[{"InputCarrier":1,"Valid":true},{"InputCarrier":3,"Valid":true},{"InputCarrier":5,"Valid":true},{"InputCarrier":2,"Valid":true}],"carriers":[{"carrierCode":"NATIONEX","carrierName":"Nationex","pickupService":false,"prices":[{"cost":12.26,"deliveryDate":"2024-07-19","serviceCode":"REGULAR","serviceName":"Régulier"}]},{"carrierCode":"DICOM","carrierName":"Dicom","pickupService":true,"prices":[{"cost":14.2,"deliveryDate":"2024-07-19","serviceCode":"REGULAR","serviceName":"Régulier"}]},{"carrierCode":"CANADAPOST","carrierName":"Poste Canada","pickupService":false,"prices":[{"cost":24.26,"deliveryDate":"2024-07-22","serviceCode":"EXPEDITED","serviceName":" Accéléré"},{"cost":37.24,"deliveryDate":"2024-07-19","serviceCode":"PRIORITY","serviceName":"_Priorité"},{"cost":25.74,"deliveryDate":"2024-07-19","serviceCode":"XPRESS","serviceName":"_Xpresspost"}]},{"carrierCode":"PUROLATOR","carrierName":"Purolator","pickupService":false,"prices":[{"cost":64.89,"deliveryDate":"2024-07-19","serviceCode":"EXPRESS","serviceName":" Régulier"}]}],"id":4556}
/* {
    "warnDetails":[],
    "ValidationResult":[{"InputCarrier":1,"Valid":true},
                        {"InputCarrier":3,"Valid":true},
                        {"InputCarrier":5,"Valid":true},
                        {"InputCarrier":2,"Valid":true}],
    "carriers":[
        {"carrierCode":"NATIONEX","carrierName":"Nationex","pickupService":false,"prices":[{"cost":23.99,"deliveryDate":"2024-09-03","serviceCode":"REGULAR","serviceName":"Régulier"}]},
        {"carrierCode":"DICOM","carrierName":"Dicom","pickupService":true,"prices":[{"cost":14.03,"deliveryDate":"2024-08-29","serviceCode":"REGULAR","serviceName":"Régulier"}]},
        {"carrierCode":"CANADAPOST","carrierName":"Poste Canada","pickupService":false,"prices":[{"cost":23.98,"deliveryDate":"2024-09-04","serviceCode":"EXPEDITED","serviceName":" Accéléré"},{"cost":36.79,"deliveryDate":"2024-09-03","serviceCode":"PRIORITY","serviceName":"_Priorité"},{"cost":25.43,"deliveryDate":"2024-09-03","serviceCode":"XPRESS","serviceName":"_Xpresspost"}]},
        {"carrierCode":"PUROLATOR","carrierName":"Purolator","pickupService":false,"prices":[{"cost":63.7,"deliveryDate":"2024-09-03","serviceCode":null,"serviceName":"Routier"}]}
    ],"id":4903} */
?>
<?php
header("X-Robots-Tag: noindex, nofollow", true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$shID  = $_GET['shID'];
//data from head
$sql = "SELECT * FROM shipment_head WHERE id = '" . $shID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$shipment_id = $data['shipment_id'];

if($CIE_LIVAR_MODE =="PROD"){
    $base_url = 'https://api.montrealdropship.com/v1/';
    $service_url = $base_url . 'order/'.$shipment_id.'?apiKey='.$CIE_LIVAR_KEY;
} else {
    $base_url = 'https://apidev.montrealdropship.com/v1/';
    $service_url = $base_url . 'order/'.$shipment_id.'?apiKey='.$CIE_LIVAR_DEV;
}

    $ch = curl_init( $service_url );
    $payload = json_encode( $data );
    curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
    //curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $result = curl_exec($ch);
    curl_close($ch);
    
    //die($result);
    $response = json_decode($result);
    //die($response->order->details[0]->CarrierDeliveryStatusDesc);
    if ($response->order->details[0]->CarrierDeliveryStatusDesc){
        $shipment_status = "Status: ".$response->order->details[0]->CarrierDeliveryStatusDesc;
    } else {
        $shipment_status = "Status: non-définit.";
    }
$dw3_conn->close();
die($shipment_status);

//exemple de réponse
/* {"order":
    {"carrierCode":"DICOM","carrierName":"GLS","carrierServiceCode":"REGULAR",
        "deliverTo":{"address1":"xxx rue du Canada","address2":"App 67","city":"city","email":"xxx@gmail.com","name":"Julien","phone1":"514-555-5555","phone2":"","postalcode":"h0h0h0",
            "sendEmailNotification":true,
            "sendEmailShipment":false,
            "statecode":"Québec"},
        "details":[{"ShippedDate":"1\/12\/2025 12:07:01 PM","carrierCode":"DICOM","carrierName":"GLS","carrierServiceCode":"REGULAR",
            "items":[{"id":573,"line":1,"orderId":463,"orderQty":2,"partName":"test GPX","partNo":"ID: 1079","shippedQty":2}],
            "qtyPackages":1,"shippingId":397,"tracking":"P01116076","trackingUrl":"https:\/\/transition.gls-canada.com\/fr\/express\/tracking\/load-tracking\/P01116076?Division=DicomExpress"}],
            "orderDate":"1\/12\/2025 12:00:00 AM","orderNumber":"463","reference1":"Order #1071","reference2":"","reference3":""}} */
?>
<?php
header("X-Robots-Tag: noindex, nofollow", true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$shID  = $_GET['ID'];

//verify if invoice exists
$sql = "SELECT COUNT(id) as rowCount FROM invoice_head WHERE shipment_id = '" . $shID . "'";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if ($data['rowCount'] >= 1) {
    die ("Erreur: Seul le status peut être modifié après avoir entré une facture associé à cette expédition.");
}

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
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    //curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $result = curl_exec($ch);
    curl_close($ch);
    
    //echo($result);
    $response = json_decode($result);
    $livar_response = $response->result;

if ($livar_response != "success"){
    die("<b>".$livar_response . "</b><br>Suppression de l'expédition a échoué. Contactez l'expéditeur pour plus de renseignements.");
}

//DELETE HEAD
	$sql = "DELETE FROM shipment_head
	 WHERE id = '" . $shID . "' LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}	

//DELETE LINES
	$sql = "DELETE FROM shipment_line
	 WHERE head_id = '" . $shID ."' ";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}	

/* $sql = "UPDATE shipment_head SET    
shipment_id = '',
tracking_url = '',
tracking_number = '',
label_link = ''
WHERE id = '" . $shID . "' LIMIT 1";
if ($dw3_conn->query($sql) === TRUE) {
    echo "Suppression de l'expédition réussi.";
} else {
 echo $dw3_conn->error;
} */
$dw3_conn->close();


?>
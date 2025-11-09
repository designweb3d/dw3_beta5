<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
	$origins  = $_GET['origins'];
	$destinations  = $_GET['destinations'];
	$url = 'https://maps.googleapis.com/maps/api/distancematrix/json'
			. '?origins=' . $origins 
			. '&destinations=' . $destinations 
			. '&key=' . $CIE_GMAP_KEY;
			
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	  CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json'
	  ),
	));

	$response = curl_exec($curl);
	curl_close($curl);
	echo $response;
?>
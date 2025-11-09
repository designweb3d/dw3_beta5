<?php
    $curl = curl_init();
    $token = "apikey:K83883785388957";
    $query = "https://api.ocr.space/Parse/Image";
    $post_fields = '{
        "file": "@screenshot.jpg",
        "language": "eng",
        "isOverlayRequired": true
    }';
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl, CURLOPT_POSTFIELDS,1);

    $header[0] = "$token";
    curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
    curl_setopt($curl, CURLOPT_URL, $query);

    $result = curl_exec($curl);

    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($http_status != 200) {
        echo "[!] Error: " . $http_status . " returned\n";
    } else {
        $json = json_decode($result);
        echo $result;
        foreach ($json->{'data'}->{'acct'} as $userdetails) {
            echo "\t" . $userdetails->{'user'} . "\n";
        }
    }

    curl_close($curl);

    
?>
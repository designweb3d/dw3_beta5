<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';$dw3_conn->close();
//require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$upload_path  = $_GET['P'];
$prompt  = $_GET['Q'];

if($prompt == ""){$prompt = "A cat in a tree";}
if($upload_path == ""){$upload_path = '/pub/upload/';}

$request_body = '{
  "prompt": "'.$prompt.'",
  "model": "grok-2-image",
  "response_format": "url",
  "n":1
}';

//$request_body = json_encode($data);

$headers = array(
  "Content-type: application/json",
  "Authorization: Bearer ".$CIE_GROK_KEY
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.x.ai/v1/images/generations");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

$response = json_decode($result);
if (isset($response->data)){
    $image_url = $response->data[0]->url;
    $time_stamp = time();
    $image_name = $time_stamp . '.jpg';
    $img_path = $upload_path . $image_name;
    file_put_contents($_SERVER['DOCUMENT_ROOT'].$img_path, file_get_contents($image_url));
    $check = getimagesize($_SERVER['DOCUMENT_ROOT'].$img_path);
    $image_width = "".$check[0];
    if ($image_width > 1200){
        $image = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].$img_path);
        $imgResized = imagescale($image , 1200, -1);
        imagejpeg($imgResized,  $image_path,80);   
    }
    die($image_name);  
} else {
    die("Erreur, aucune image générée. ".$result);
}

//Response exemple
/*  {
    "data":[
        {
            "url":"https://imgen.x.ai/xai-imgen/",
            "revised_prompt":"A high-resolution photograph of a vintage car race featuring a Ford Mustang, a Porsche 911, and a Chevrolet Corvette on a historic racetrack during a sunny day. The Ford Mustang is slightly ahead, with the Porsche 911 and Chevrolet Corvette closely following. The cars are depicted from a side view, highlighting their classic designs and vibrant colors. The background shows a clear sky with a few clouds and a cheering crowd, adding to the race's atmosphere without distracting from the main subjects. The track is surrounded by trees, contributing to a scenic yet focused composition. The image captures the dynamic movement of the race with a slight motion blur, enhancing the sense of speed and excitement."
        }
    ]
} */

?>
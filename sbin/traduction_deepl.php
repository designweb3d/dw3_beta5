<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$target_lang = $_GET['t'];
$message = $_GET['m'];

if (trim($message) == "") {die ("");}

$data = '{"text": ["'.html_entity_decode(str_replace("'","’",$message),ENT_NOQUOTES,'UTF-8').'"],"target_lang": "'.$target_lang.'"}';
$data = str_replace(array("\n", "\r"), '<br>', $data);

  $headers = array(
    "Content-type: application/json",
    "Authorization: DeepL-Auth-Key ".$CIE_DEEPL_KEY
  );

$ch = curl_init('https://api-free.deepl.com/v2/translate');
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$translatedWords = json_decode($result, true); 
$result2 = $translatedWords['translations'][0]['text']; 
if($result2 == ""){$result2 = $result;}
echo str_replace("’","'",$result2); 
$dw3_conn->close();
?>
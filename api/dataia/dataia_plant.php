<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 

    $DATAIA_KEY = $_GET['k']??"";
    $OUTPUT = $_GET['o']??"";
    $PLANT_ID = $_GET['i']??"";
    $FIND = $_GET['s']??"";
    $FAMILY = $_GET['f']??"";
    $LIMIT = $_GET['l']??"10";

    $headers = array(
        "Content-type: application/json",
        "Authorization: ".$DATAIA_KEY
      );
      $request_body = '{
  "k": "'.$DATAIA_KEY.'",
  "s": "'.$FIND.'",
  "f": "'.$FAMILY.'",
  "i": "'.$PLANT_ID.'",
  "l": "'.$LIMIT.'"
}';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://dataia.ca/plant.php");
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);

      $dw3_conn->close();
      die($result);
?>
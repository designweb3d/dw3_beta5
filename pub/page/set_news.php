<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$EML = $_GET['eml']??'';
$action = $_GET['act']??'OK';
if ($action == "OK"){
    $news_stat = "1";
} else {
    $news_stat = "0";
}
/* $cookie_domain = $_SERVER["SERVER_NAME"];

//cookie
    setcookie("NEWS", $action, [
        'expires' => time() + 86400,
        'path' => '/',
        'domain' => $cookie_domain,
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None',
    ]); */

//find or create customer account with email
$sql = "SELECT id FROM customer WHERE eml1 = '" . dw3_crypt(trim(strtolower($EML))) . "' LIMIT 1";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $sql = "UPDATE customer SET news_stat = '" . trim($news_stat) . "' WHERE id='" . $row["id"] . "' ";
    if ($dw3_conn->query($sql) === TRUE) {
      echo "cf";
    } 
  }
} else {
    $sql = "SELECT id FROM user WHERE eml1 = '" .trim(strtolower($EML)) . "' OR eml2 = '" .trim(strtolower($EML)) . "' OR eml3 = '" . trim(strtolower($EML)) . "' LIMIT 1";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $sql = "UPDATE user SET news_stat = '" . trim($news_stat) . "' WHERE id='" . $row["id"] . "' ";
        if ($dw3_conn->query($sql) === TRUE) {
            echo "uf";
        } 
      }
    } else {
        $sql = "INSERT INTO customer (eml1,news_stat) VALUES('" . dw3_crypt(trim(strtolower($EML))) . "','1')";
            if ($dw3_conn->query($sql) === TRUE) {
            $CL = $dw3_conn->insert_id;
            if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/fs/customer/" . $CL)){
                mkdir($_SERVER['DOCUMENT_ROOT'] . "/fs/customer/" . $CL);
            }
            echo "cc";
        } 
    }
}

?>
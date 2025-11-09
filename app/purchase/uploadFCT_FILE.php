<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/fs/purchase/";
$fct_id   = $_GET['id']??'';
$filename = $_FILES['fileUpload']['name'];
$location = $target_dir.$filename;

if ( move_uploaded_file($_FILES['fileUpload']['tmp_name'], $location) ) { 
    echo 'Success'; 
    $sql = "UPDATE purchase_head SET    
    document    = '" . basename($filename)    . "'
    WHERE id = '" . $fct_id . "' LIMIT 1 ;";
    if ($dw3_conn->query($sql) === TRUE) {
    //echo "";
    } else {
    echo $dw3_conn->error;
    }
} else { 
  echo 'Failure asti de marde'.$_FILES['fileUpload']['tmp_name']; 
}
$dw3_conn->close();
?>
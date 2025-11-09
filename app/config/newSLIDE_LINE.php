<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$sid   = mysqli_real_escape_string($dw3_conn,$_GET['sid']);
$fn   = mysqli_real_escape_string($dw3_conn,$_GET['fn']);

$sql = "INSERT INTO `slideshow` (`index_id`, `name_fr`, `name_en`, `media_type`, `media_link`) VALUES
        (".$sid.",'". $fn."','". $fn."','image','/pub/upload/". $fn."');";
        if ($dw3_conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo $dw3_conn->error;
        }
        $dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$dw3_conn->set_charset('utf8mb4');

$INDEX_FACEBOOK   = mysqli_real_escape_string($dw3_conn,$_GET['RS1']);
$INDEX_TWITTER    = mysqli_real_escape_string($dw3_conn,$_GET['RS2']);
$INDEX_INSTAGRAM  = mysqli_real_escape_string($dw3_conn,$_GET['RS3']);
$INDEX_LINKEDIN   = mysqli_real_escape_string($dw3_conn,$_GET['RS4']);
$INDEX_TIKTOK     = mysqli_real_escape_string($dw3_conn,$_GET['RS5']);
$INDEX_YOUTUBE    = mysqli_real_escape_string($dw3_conn,$_GET['RS6']);
$INDEX_PINTEREST  = mysqli_real_escape_string($dw3_conn,$_GET['RS7']);
$INDEX_SNAPCHAT   = mysqli_real_escape_string($dw3_conn,$_GET['RS8']);

	$sql = "INSERT INTO config
    (kind, code,text1,text2)
    VALUES 
        ('INDEX', 'FACEBOOK', '" . $INDEX_FACEBOOK    . "',''),
        ('INDEX', 'TWITTER', '" . $INDEX_TWITTER    . "',''),
        ('INDEX', 'INSTAGRAM', '" . $INDEX_INSTAGRAM    . "',''),
        ('INDEX', 'LINKEDIN', '" . $INDEX_LINKEDIN    . "',''),
        ('INDEX', 'TIKTOK', '" . $INDEX_TIKTOK    . "',''),
        ('INDEX', 'YOUTUBE', '" . $INDEX_YOUTUBE    . "',''),
        ('INDEX', 'SNAPCHAT', '" . $INDEX_SNAPCHAT    . "',''),
        ('INDEX', 'PINTEREST', '" . $INDEX_PINTEREST    . "','')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2);";
           
    if ($dw3_conn->query($sql) === TRUE) {
	  //echo "L'index a été mise &#224; jour";
	  echo "";
	} else {
        $dw3_conn->close();
	    die($dw3_conn->error);
	}

$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$FN= $_GET['FN']??'';
$DEG= $_GET['DEG']??'0';
$filename = $_SERVER['DOCUMENT_ROOT'] . $FN;
$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));

if ($DEG == "0" || $FN == ""){
    $dw3_conn->close();
    exit;
}

// Load
if($imageFileType == "jpg" || $imageFileType == "jpeg"){
    $source = imagecreatefromjpeg($filename);
} else  if ($imageFileType == "png"){
    $source = imagecreatefrompng($filename);
}
// Rotate
$rotate = imagerotate($source, $DEG, 0);

// Output
if($imageFileType == "jpg" || $imageFileType == "jpeg"){
    imagejpeg($rotate,  $filename);
} else if ($imageFileType == "png"){
    imagepng($rotate,  $filename);
}
echo "Rotation complété.";
$dw3_conn->close();
?>

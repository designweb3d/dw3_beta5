<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$PRD_ID = $_GET['prID'];
$FN= $_GET['FN'];
$filename = $_SERVER['DOCUMENT_ROOT'] . "/fs/product/"  . $PRD_ID . "/".$FN;
$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
$degrees = 90;

// Load
if($imageFileType == "jpg" || $imageFileType == "jpeg"){
    $source = imagecreatefromjpeg($filename);
} else  if ($imageFileType == "png"){
    $source = imagecreatefrompng($filename);
}
// Rotate
$rotate = imagerotate($source, $degrees, 0);

// Output
if($imageFileType == "jpg" || $imageFileType == "jpeg"){
    imagejpeg($rotate,  $filename);
} else if ($imageFileType == "png"){
    imagepng($rotate,  $filename);
}
echo "Rotation complété.";
$dw3_conn->close();
?>

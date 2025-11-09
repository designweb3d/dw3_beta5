<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$dw3_conn->close();

$file_replace = $_GET["REPLACE"]??"unknow";
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/pub/upload/";
$source_file = basename($_FILES["fileToOpt"]["name"]);
$imageFileType = strtolower(pathinfo($source_file,PATHINFO_EXTENSION));
$target_file = $target_dir . $source_file ;
$tmp_name = $_FILES["fileToOpt"]["tmp_name"];
$dng_name = "";

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "gif" && $imageFileType != "svg" && $imageFileType != "avif" && $imageFileType != "webp" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "dng") {
    die("Seulement les fichiers RAW DATA, JPG/JPEG, SVG, GIF, WEBP & PNG files sont acceptés.");
}
  
// Check if file already exists
if (file_exists($target_file)) {
    if ($file_replace == "yes"){
        unlink($target_file);
    } else {
        //die("Sorry, file already exists.".$target_file ."<br>");
        die ("ErrX");
    } 
}
  
// Check file size
if ($_FILES["fileToOpt"]["size"] > 100000000) {
    die("Le fichier est trop volumineux (>100MB)");
}
  
//convert RAW DATA to jpg
if ($imageFileType == "dng"){
    $dng_name = basename(strtolower($source_file), ".dng").'.jpg';
    $im = new Imagick($tmp_name);
    $im->setImageFormat( 'jpg' );
    $im->writeImage($dng_name);
    $im->clear();
    $source_file = $dng_name;
}

$check = getimagesize($tmp_name);
$image_width = "".$check[0];

//RESIZE
if ($image_width > 400){
    // dng
    if($imageFileType == "dng"){
        $image = imagecreatefromjpeg($dng_name);
        //SCALE
        $imgResized = imagescale($image , 400, -1);
        //WRITE 
        $source_file = basename($dng_name);
        $target_file = $target_dir . $source_file ;
        imagejpeg($imgResized,  $target_file); 
        //die("The file ". htmlspecialchars( $source_file ). " has been resized & uploaded.");
        die(basename( $_FILES["fileToOpt"]["name"]));
    } 
    //webp
    if($imageFileType == "webp"){
        $image = imagecreatefromwebp($_FILES["fileToOpt"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 400, -1);
        //WRITE
        imagewebp($imgResized,  $target_file);
        imagedestroy($image);
        die(basename( $_FILES["fileToOpt"]["name"]) );
    }  
    // jpeg
    if($imageFileType == "jpg" || $imageFileType == "jpeg"){
        $image = imagecreatefromjpeg($_FILES["fileToOpt"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 400, -1);
        //WRITE 
        imagejpeg($imgResized,  $target_file); 
        //die("The file ". htmlspecialchars( basename( $_FILES["fileToUpload7"]["name"])). " has been resized & uploaded.");
        die(basename( $_FILES["fileToOpt"]["name"]) );
    } 
    // png
    if($imageFileType == "png"){
        $image = imagecreatefrompng($_FILES["fileToOpt"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 400, -1);
        imagealphablending($imgResized, false);
        imagesavealpha($imgResized, true);
        //WRITE
        imagepng($imgResized,  $target_file);
        //die("The file ". htmlspecialchars( basename( $_FILES["fileToUpload7"]["name"])). " has been resized & uploaded.");
        die(basename( $_FILES["fileToOpt"]["name"]));
    }

} 

if (move_uploaded_file($_FILES["fileToOpt"]["tmp_name"], $target_file)) {
    die(basename( $_FILES["fileToOpt"]["name"]));
} else {
    die ("Error: Sorry, there was an error uploading your file.. Error #".$_FILES["fileToOpt"]["error"]);
}
?>
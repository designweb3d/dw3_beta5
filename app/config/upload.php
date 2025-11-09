<?php
//SCRIPT USED FOR UPLOADS TO /pub/upload/
//used in config_7_index and..
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$file_replace = $_GET["REPLACE"]??"unknow";
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/pub/upload/";
$source_file = str_replace("#","",basename($_FILES["fileToUpload"]["name"]));
$imageFileType = strtolower(pathinfo($source_file,PATHINFO_EXTENSION));
$target_file = $target_dir . $source_file ;
$tmp_name = $_FILES["fileToUpload"]["tmp_name"];
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
        die ("ErrX");
    } 
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 100000000) {
    die("Le fichier est trop volumineux (>100MB)");
}

//convert RAW DATA to jpg
if ($imageFileType == "dng"){
    $dng_name = basename(strtolower($source_file), ".dng").'.jpg';
    $im = new Imagick($tmp_name);
    $im->setImageFormat( 'jpg' );
    $im->writeImage($dng_name);
    $im->clear();
}

$check = getimagesize($tmp_name);
$image_width = "".$check[0];


//RESIZE
if ($image_width > 1200){
    // dng
    if($imageFileType == "dng"){
        $image = imagecreatefromjpeg($dng_name);
        //SCALE
        $imgResized = imagescale($image , 1200, -1);
        //WRITE 
        $source_file = basename($dng_name);
        $target_file = $target_dir . $source_file ;
        imagejpeg($imgResized,  $target_file); 
        imagedestroy($image);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    }
    //webp
    if($imageFileType == "webp"){
        $image = imagecreatefromwebp($_FILES["fileToUpload"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 400, -1);
        //WRITE
        imagewebp($imgResized,  $target_file);
        imagedestroy($image);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    }  
    // jpeg
    if($imageFileType == "jpg" || $imageFileType == "jpeg"){
        $image = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 1200, -1);
        //WRITE 
        imagejpeg($imgResized,  $target_file); 
        imagedestroy($image);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    } 
    // png
    if($imageFileType == "png"){
        $image = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 1200, -1);
        imagealphablending($imgResized, false);
        imagesavealpha($imgResized, true);
        //WRITE
        imagepng($imgResized,  $target_file);
        imagedestroy($image);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    }
}

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé.");
} else {
    die ("Erreur le fichier n'a pas pu être téléchargé. Erreur#: ".$_FILES["fileToUpload"]["error"]);
}
?>
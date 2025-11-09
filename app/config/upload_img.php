<?php
//SCRIPT USED FOR UPLOADS TO /pub/img/
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$dw3_conn->close();
$file_replace = $_GET["REPLACE"]??"unknow";
$tmp_name = $_FILES["fileToImg"]["tmp_name"];
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/pub/img/";
$source_file = str_replace("#","",basename($_FILES["fileToImg"]["name"]));
$imageFileType = strtolower(pathinfo($source_file,PATHINFO_EXTENSION));
$target_file = $target_dir . $source_file ;
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
        die("ErrX");
    } 
}
  
// Check file size
if ($_FILES["fileToImg"]["size"] > 100000000) {
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
if ($image_width > 1280){
    // dng
    if($imageFileType == "dng"){
        $image = imagecreatefromjpeg($dng_name);
        //SCALE
        $imgResized = imagescale($image , 900, -1);
        //WRITE 
        $source_file = basename($dng_name);
        $target_file = $target_dir . $source_file ;
        imagejpeg($imgResized,  $target_file,90); 
        imagedestroy($image);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    } 
    // jpeg
    if($imageFileType == "jpg" || $imageFileType == "jpeg"){
        $image = imagecreatefromjpeg($_FILES["fileToImg"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 900, -1);
        //WRITE 
        imagejpeg($imgResized,  $target_file,90); 
        imagedestroy($image);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    } 
    // png
    if($imageFileType == "png"){
        $image = imagecreatefrompng($_FILES["fileToImg"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 900, -1);
        imagealphablending($imgResized, false);
        imagesavealpha($imgResized, true);
        //WRITE
        imagepng($imgResized,  $target_file,9);
        imagedestroy($image);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    }
}

// Check file size to lower it below 1MB
if ($_FILES["fileToImg"]["size"] > 1000000) {
    if($imageFileType == "dng"){
        $source_file = basename($dng_name);
        $target_file = $target_dir . $source_file ;
        imagejpeg($source_file,  $target_file,75);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et la qualité a été diminué à 75%.");
    }
    if($imageFileType == "jpg" || $imageFileType == "jpeg"){
        imagejpeg($source_file,  $target_file,75); 
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et la qualité a été diminué à 75%.");
    }
    if($imageFileType == "png"){
        imagepng($source_file,  $target_file,9);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et la qualité a été diminué à 75%.");
    }
}

if (move_uploaded_file($_FILES["fileToImg"]["tmp_name"], $target_file)) {
    die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé.");
} else {
    die ("Erreur le fichier ".htmlspecialchars( $source_file )." n'a pas pu être téléchargé. Erreur#: ".$_FILES["fileToImg"]["error"]);
}

?>
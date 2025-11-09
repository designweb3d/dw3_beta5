<?php
//SCRIPT USED FOR SLIDESHOWS
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$section_id   = $_GET['sid']??'';
if(!isset($_FILES['fileToSlide'])){
    die ("false");
}

$file_replace = $_GET["REPLACE"]??"unknow";
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/pub/upload/";
$source_file = str_replace("#","",basename($_FILES["fileToSlide"]["name"]));
$imageFileType = strtolower(pathinfo($source_file,PATHINFO_EXTENSION));
$target_file = $target_dir . $source_file;
$tmp_name = $_FILES["fileToSlide"]["tmp_name"];
$converted_name = "";

$fileType = 'unknow';
$fileExt = strtolower(pathinfo($source_file,PATHINFO_EXTENSION));
$img_file_types = ['image/png', 'image/apng', 'image/gif', 'image/jpg', 'image/jpeg', 'image/avif', 'image/webp', 'image/tiff', 'image/svg'];
if ((in_array($_FILES['fileToSlide']['type'], $img_file_types))) {
    $fileType = 'image';
}


// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "gif" && $imageFileType != "svg" && $imageFileType != "avif" && $imageFileType != "webp" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "dng") {
    die("Seulement les fichiers RAW DATA, JPG/JPEG, SVG, GIF, WEBP & PNG files sont acceptés.");
}


// Check file size
if ($_FILES["fileToSlide"]["size"] > 100000000) {
    die("Le fichier est trop volumineux (>100MB)");
}
  
//convert RAW DATA to jpg
if ($imageFileType == "dng"){
    $converted_name = basename(strtolower($source_file), ".dng").'.jpg';
    $im = new Imagick($tmp_name);
    $im->setImageFormat( 'jpg' );
    $im->writeImage($converted_name);
    $im->clear();
    $source_file = $converted_name;
}

//update slideshow
if ($section_id !=""){
    $sql = "INSERT INTO `slideshow` (`index_id`, `name_fr`, `name_en`, `media_type`, `media_link`) VALUES
    (".$section_id.",'". $source_file."','". $source_file."','". $fileType."','/pub/upload/". $source_file."');";
    if ($dw3_conn->query($sql) === TRUE) {
       $last_insert_id = $dw3_conn->insert_id;
    } else {
        die($dw3_conn->error);
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    //if ($file_replace == "yes"){
        //unlink($target_file);
    //} else {
        die("Le fichier ".$target_file ." était déjà sur le serveur.");
        //die ("ErrX");
    //} 
}

$check = getimagesize($tmp_name);
$image_width = "".$check[0];

//RESIZE
if ($image_width > 900){
    // dng
    if($imageFileType == "dng"){
        $image = imagecreatefromjpeg($converted_name);
        //SCALE
        $imgResized = imagescale($image , 900, -1);
        //WRITE 
        $source_file = basename($converted_name);
        $target_file = $target_dir . $source_file ;
        imagejpeg($imgResized,  $target_file); 
        imagedestroy($image);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été converti en .jpg et redimensionné.");
    } 
    // webp
    if($imageFileType == "webp"){
        //convert WEBP to jpg
/*         $converted_name = basename(strtolower($source_file), ".webp").'.png';
        $im = new Imagick($tmp_name);
        $im->setImageFormat( 'png' );
        $im->writeImage($converted_name);
        $im->clear();
        $source_file = $converted_name;
            //update db with new file ext
            $sql = "UPDATE `slideshow` SET `name_fr` = '".$source_file."', `name_en` = '".$source_file."', `media_link` = '/pub/upload/". $source_file."' WHERE id = '".$last_insert_id."'";
            if ($dw3_conn->query($sql) !== TRUE) {
                die($dw3_conn->error);
            } */

        $image = imagecreatefromwebp($_FILES["fileToSlide"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 900, -1);
/*         imagealphablending($imgResized, false);
        imagesavealpha($imgResized, true); */
        //WRITE
        imagewebp($imgResized,  $target_file);
        imagedestroy($image);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    } 
    // jpeg
    if($imageFileType == "jpg" || $imageFileType == "jpeg"){
        $image = imagecreatefromjpeg($_FILES["fileToSlide"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 900, -1);
        //WRITE 
        imagejpeg($imgResized,  $target_file);
        imagedestroy($image); 
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    } 
    // png
    if($imageFileType == "png"){
        $image = imagecreatefrompng($_FILES["fileToSlide"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 900, -1);
        imagealphablending($imgResized, false);
        imagesavealpha($imgResized, true);
        //WRITE
        imagepng($imgResized,  $target_file);
        imagedestroy($image);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    }
}

$dw3_conn->close();

if (move_uploaded_file($_FILES["fileToSlide"]["tmp_name"], $target_file)) {
    die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé.");
} else {
    die ("Erreur le fichier ".htmlspecialchars( $source_file )." n'a pas pu être téléchargé. Erreur#: ".$_FILES["fileToSlide"]["error"]);
}

?>
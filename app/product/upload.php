<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
//ini_set('memory_limit', '16M');
//error_reporting(E_ALL);
$file_replace = $_GET["REPLACE"]??"unknow";
$product_id = trim($_POST['fileNamePrd']);
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/fs/product/"  . $product_id . "/";
$source_file = basename($_FILES["fileToPrd"]["name"]);
$imageFileType = strtolower(pathinfo($source_file,PATHINFO_EXTENSION));
$target_file = $target_dir . $source_file ;
$tmp_name = $_FILES["fileToPrd"]["tmp_name"];
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
if ($_FILES["fileToPrd"]["size"] > 100000000) {
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
 
//update product if no img_link set
$sql = "SELECT url_img FROM product WHERE id = '" . $product_id  . "' LIMIT 1;";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

if ($data["url_img"] == ""){
    if($imageFileType == "dng"){
        $sql = "UPDATE product SET url_img = '" . basename($dng_name) . "' WHERE id = '" . $product_id . "'  LIMIT 1";
    } else {
        $sql = "UPDATE product SET url_img = '" . $source_file . "' WHERE id = '" . $product_id . "'  LIMIT 1";
    }
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo "ok";
	} else {
	  echo "Erreur: ".$dw3_conn->error;
	}
}
$dw3_conn->close();

//RESIZE
if ($image_width > 700){
    // dng
    if($imageFileType == "dng"){
        $image = imagecreatefromjpeg($dng_name);
        //SCALE
        $imgResized = imagescale($image , 700, -1);
        //WRITE 
        $source_file = basename($dng_name);
        $target_file = $target_dir . $source_file ;
        imagejpeg($imgResized,  $target_file); 
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    } 
    //webp
    if($imageFileType == "webp"){
        $image = imagecreatefromwebp($_FILES["fileToPrd"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 700, -1);
        //WRITE
        imagewebp($imgResized,  $target_file);
        imagedestroy($image);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    } 
    // jpeg
    if($imageFileType == "jpg" || $imageFileType == "jpeg"){
        $image = imagecreatefromjpeg($_FILES["fileToPrd"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 700, -1);
        //WRITE 
        imagejpeg($imgResized,  $target_file); 
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    } 
    // png
    if($imageFileType == "png"){
        $image = imagecreatefrompng($_FILES["fileToPrd"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 700, -1);
        imagealphablending($imgResized, false);
        imagesavealpha($imgResized, true);
        //WRITE
        imagepng($imgResized,  $target_file);
        die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé et redimensionné.");
    }
}

if (move_uploaded_file($_FILES["fileToPrd"]["tmp_name"], $target_file)) {
    die("Le fichier ". htmlspecialchars( $source_file ). " a été téléchargé.");
} else {
    die ("Erreur le fichier n,a pas pu être téléchargé. Erreur#: ".$_FILES["fileToPrd"]["error"]);
}
?>
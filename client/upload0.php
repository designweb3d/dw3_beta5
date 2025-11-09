<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php';
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/fs/customer/"  . $USER . "/";
$source_file = basename($_FILES["fileToUpload0"]["name"]);
$imageFileType = strtolower(pathinfo($source_file,PATHINFO_EXTENSION));
$target_file = $target_dir . $source_file;
//$target_file = $target_dir . $source_file;
$tmp_name = $_FILES["fileToUpload0"]["tmp_name"];

// Check if image file is a actual image or fake image
//if(isset($_POST["submit"])) {
  //$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  //if($check !== false) {
   // echo "File is an image - " . $check["mime"] . ".";
  //  $uploadOk = 1;
  //} else {
 //   echo "File is not an image.";
 //   $uploadOk = 0;
 // }
//}
$dw3_conn->close();

// Check file size
if ($_FILES["fileToUpload7"]["size"] > 10000000) {
  die("ERROR: Veuillez réduire la taille du fichier. Maximum 10 MB par fichier.");
}

// Check if file already exists
if (file_exists($target_file)) {
    $delete_status=unlink($target_file);  
 // $delete_jpg_status=unlink($target_dir . $_POST['fileName'] . ".jpg");  
}
// Allow certain file formats
//if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  //$uploadOk = 0;
//}

//convert RAW DATA to jpg
if ($imageFileType == "dng"){
    $dng_name = basename(strtolower($source_file), ".dng").'.jpg';
    $im = new Imagick($tmp_name);
    $im->setImageFormat( 'jpg' );
    $im->writeImage($target_dir.$dng_name);
    $im->clear();
    exit();
}

// Check if $uploadOk is set to 0 by an error

  if (move_uploaded_file($_FILES["fileToUpload0"]["tmp_name"], $target_file)) {
    //die($_POST['fileName0'] . "." . $imageFileType);
    //die($source_file);
  } else {
    die ("ERROR: Sorry, there was an error uploading your file.");
  }

?>
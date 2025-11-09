<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/fs/user/";
$source_file = basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($source_file,PATHINFO_EXTENSION));
//$target_file = $target_dir . $source_file ;
$target_file = $target_dir . $USER . ".png" ;
$uploadOk = 1;
  
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

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  //$uploadOk = 0;
  //$delete_png_status=unlink($target_dir . $_POST['fileName'] . ".png");  
 // $delete_jpg_status=unlink($target_dir . $_POST['fileName'] . ".jpg");  
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
//if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  //$uploadOk = 0;
//}

$dw3_conn->close();
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  die("Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    die("The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.");
  } else {
    die ("Sorry, there was an error uploading your file.");
  }
}
?>
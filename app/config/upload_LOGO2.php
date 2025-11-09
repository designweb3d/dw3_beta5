<?php
$sFILE   = "logo2.png";
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/pub/img/";
$target_file = $target_dir . $sFILE;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

if ($_FILES["fileToUpload2"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}
if($imageFileType != "png") {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
} else {
	if (file_exists($target_file)) {
	   unlink($target_file);
	}
	if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
		echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload2"]["name"])). " has been uploaded.";
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
}
?>
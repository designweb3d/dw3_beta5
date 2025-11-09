<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/pub/upload/";
$source_file = str_replace("'","’",basename($_FILES["imgToUpload"]["name"]));
$imageFileType = strtolower(pathinfo($source_file,PATHINFO_EXTENSION));
$target_file = $target_dir . $source_file ;

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "dng" && $imageFileType != "webp") {
//http_response_code(400);
  die("Sorry, only RAW DATA, WEBP, JPG, JPEG & PNG files are allowed. (not ".$imageFileType.")");
}

// Check if file already exists
if (file_exists($target_file)) {
    //http_response_code(400);
    die("Sorry, file already exists.".$target_file ."<br>");
    //$uploadOk = 0;
    //$delete_png_status=unlink($target_dir . $_POST['fileName'] . ".png");  
    // $delete_jpg_status=unlink($target_dir . $_POST['fileName'] . ".jpg");  
}

// Check file size
if ($_FILES["imgToUpload"]["size"] > 100000000) {
    //http_response_code(400);
    die("Sorry, your file is too large.");
}

$tmp_name = $_FILES["imgToUpload"]["tmp_name"];
$dng_name = "";
if ($imageFileType == "dng"){
    $im = new Imagick($tmp_name);
    $im->setImageFormat( 'jpg' );
    $im->writeImage( basename($source_file, ".DNG").'.jpg' );
    $im->clear();
    $dng_name = basename($source_file, ".DNG").'.jpg';
}

//die($tmp_name);
//die ($_POST["MAX_FILE_SIZE"]);
//die ($tmp_name);
// Check if image file is a actual image or fake image
//if(isset($_POST["submit"])) {
  $check = getimagesize($tmp_name);
  //die ("width:".$check[0]." height:".$check[1]." width:".$check[2]." width:".$check[3]);
  $image_width = "".$check[0];
  //$image_width = array_values($check)[0];
  //die ($image_width);
  //if($check == false) {
   // echo "File is an image - " . $check["mime"] . ".";
  //  $uploadOk = 1;
  //} else {
    //echo "File is not an image.";
 //   $uploadOk = 0;
 // }
  //}
/*   $imageTypeArray = array
  (
      0=>'UNKNOWN',
      1=>'GIF',
      2=>'JPEG',
      3=>'PNG',
      4=>'SWF',
      5=>'PSD',
      6=>'BMP',
      7=>'TIFF_II',
      8=>'TIFF_MM',
      9=>'JPC',
      10=>'JP2',
      11=>'JPX',
      12=>'JB2',
      13=>'SWC',
      14=>'IFF',
      15=>'WBMP',
      16=>'XBM',
      17=>'ICO',
      18=>'COUNT'  
  ); */

  //$image_type = $imageTypeArray[$check[2]];


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
        //die("The file ". htmlspecialchars( $source_file ). " has been resized & uploaded.");
        die($source_file);
    } 
    // jpeg
    if($imageFileType == "jpg" || $imageFileType == "jpeg"){
        $image = imagecreatefromjpeg($_FILES["imgToUpload"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 700, -1);
        //WRITE 
        imagejpeg($imgResized,  $target_file); 
        //die("The file ". htmlspecialchars( basename( $_FILES["imgToUpload"]["name"])). " has been resized & uploaded.");
        die($source_file);
    } 
    // png
    if($imageFileType == "png"){
        $image = imagecreatefrompng($_FILES["imgToUpload"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 700, -1);
        //WRITE
        imagepng($imgResized,  $target_file);
        //die("The file ". htmlspecialchars( basename( $_FILES["imgToUpload"]["name"])). " has been resized & uploaded.");
        die($source_file);
    }
    // png
    if($imageFileType == "webp"){
        $image = imagecreatefromwebp($_FILES["imgToUpload"]["tmp_name"]);
        //SCALE
        $imgResized = imagescale($image , 700, -1);
        //WRITE
        imagewebp($imgResized,  $target_file);
        //die("The file ". htmlspecialchars( basename( $_FILES["imgToUpload"]["name"])). " has been resized & uploaded.");
        die($source_file);
    }
    //http_response_code(400);
    //die("Sorry, only JPG, JPEG & PNG files are allowed.");
} else {
    if (move_uploaded_file($_FILES["imgToUpload"]["tmp_name"], $target_file)) {
        //die("The file ". htmlspecialchars( basename( $_FILES["imgToUpload"]["name"])). " has been uploaded.");
        die($source_file);
      } else {
        //http_response_code(400);
        die ("Sorry, there was an error uploading your file.. Error #".$_FILES["imgToUpload"]["error"]);
      }
}
// Allow certain file formats
//if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  //$uploadOk = 0;
//}


// Check if $uploadOk is set to 0 by an error

?>
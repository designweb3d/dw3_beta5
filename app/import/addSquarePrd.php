<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$SQ_OPTS  = htmlspecialchars($_GET['SQ_OPTS']);
$SQ_ID  = htmlspecialchars($_GET['SQ_ID']);
$SQ_DESC  = str_replace("'","’",$_GET['SQ_DESC']);
$SQ_NAME   = str_replace("'","’",$_GET['SQ_NAME']);
$SQ_IMG   = str_replace("'","’",$_GET['SQ_IMG']);
$SQ_IMG2   = str_replace("'","’",$_GET['SQ_IMG2']);
$SQ_IMG3   = str_replace("'","’",$_GET['SQ_IMG3']);
$SQ_IMG4   = str_replace("'","’",$_GET['SQ_IMG4']);
$SQ_IMG5   = str_replace("'","’",$_GET['SQ_IMG5']);
$SQ_PRICE   = str_replace("'","’",$_GET['SQ_PRICE']);
$SQ_CAT   = str_replace("'","’",$_GET['SQ_CAT']);
$SQ_CAT2   = str_replace("'","’",$_GET['SQ_CAT2']);

//$FPRICE = floatval($SQ_PRICE)/100;
$FPRICE = floatval($SQ_PRICE);

//get category_id
$sql = "SELECT * FROM product_category WHERE square_id = '" . $SQ_CAT . "' && square_id <> '' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
if ($result->num_rows > 0) {
    $data = mysqli_fetch_assoc($result);
    $category_id = $data["id"];
} else {
    $category_id = "0";    
}
//get category2_id
$sql = "SELECT * FROM product_category WHERE square_id = '" . $SQ_CAT2 . "' && square_id <> '' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
if ($result->num_rows > 0) {
    $data = mysqli_fetch_assoc($result);
    $category2_id = $data["id"];
} else {
    $category2_id = "0";    
}

//insert
	$sql = "INSERT INTO product
    (square_id,category_id,category2_id,description_fr,name_fr,price1,url_img,date_created,date_modified,user_created,user_modified)
    VALUES 
        ('".$SQ_ID."',
         '" . $category_id  . "',
         '" . $category2_id  . "',
         '" . $SQ_DESC  . "',
         '" . $SQ_NAME  . "',
         '" . $FPRICE  . "',
         '" . basename($SQ_IMG) . "',
         '" . $datetime  . "',
         '" . $datetime  . "',
         '" . $USER . "',
         '" . $USER . "')";
		//die("Erreur: ".$sql);
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        echo "Produit #".$inserted_id." créé.";
        if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id)){
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id);
        }
        //IMAGE

        if ($SQ_IMG !=''){
            $savePath = $_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id."/".basename($SQ_IMG); // Replace with your desired save path
            $ch = curl_init($SQ_IMG);
            $fp = fopen($savePath, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp); 
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch,CURLOPT_USERAGENT,'curl/'.(curl_version()['version']));
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $imageFileType = strtolower(pathinfo($savePath,PATHINFO_EXTENSION));
            $check = getimagesize($savePath);
            $image_width = "".$check[0];
            //RESIZE
            if ($image_width > 700){
                //webp
                if($imageFileType == "webp"){
                    $image = imagecreatefromwebp($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    //WRITE
                    imagewebp($imgResized,  $savePath);
                    imagedestroy($image);
                } 
                // jpeg
                if($imageFileType == "jpg" || $imageFileType == "jpeg"){
                    $image = imagecreatefromjpeg($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    //WRITE 
                    imagejpeg($imgResized,  $savePath); 
                } 
                // png
                if($imageFileType == "png"){
                    $image = imagecreatefrompng($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    imagealphablending($imgResized, false);
                    imagesavealpha($imgResized, true);
                    //WRITE
                    imagepng($imgResized,  $savePath);
                }
            }
        }
        if ($SQ_IMG2 !=''){
            $savePath = $_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id."/".basename($SQ_IMG2); // Replace with your desired save path
            $ch = curl_init($SQ_IMG2);
            $fp = fopen($savePath, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp); 
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch,CURLOPT_USERAGENT,'curl/'.(curl_version()['version']));
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $imageFileType = strtolower(pathinfo($savePath,PATHINFO_EXTENSION));
            $check = getimagesize($savePath);
            $image_width = "".$check[0];
            //RESIZE
            if ($image_width > 700){
                //webp
                if($imageFileType == "webp"){
                    $image = imagecreatefromwebp($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    //WRITE
                    imagewebp($imgResized,  $savePath);
                    imagedestroy($image);
                } 
                // jpeg
                if($imageFileType == "jpg" || $imageFileType == "jpeg"){
                    $image = imagecreatefromjpeg($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    //WRITE 
                    imagejpeg($imgResized,  $savePath); 
                } 
                // png
                if($imageFileType == "png"){
                    $image = imagecreatefrompng($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    imagealphablending($imgResized, false);
                    imagesavealpha($imgResized, true);
                    //WRITE
                    imagepng($imgResized,  $savePath);
                }
            }
        }
        if ($SQ_IMG3 !=''){
            $savePath = $_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id."/".basename($SQ_IMG3); // Replace with your desired save path
            $ch = curl_init($SQ_IMG3);
            $fp = fopen($savePath, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp); 
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch,CURLOPT_USERAGENT,'curl/'.(curl_version()['version']));
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $imageFileType = strtolower(pathinfo($savePath,PATHINFO_EXTENSION));
            $check = getimagesize($savePath);
            $image_width = "".$check[0];
            //RESIZE
            if ($image_width > 700){
                //webp
                if($imageFileType == "webp"){
                    $image = imagecreatefromwebp($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    //WRITE
                    imagewebp($imgResized,  $savePath);
                    imagedestroy($image);
                } 
                // jpeg
                if($imageFileType == "jpg" || $imageFileType == "jpeg"){
                    $image = imagecreatefromjpeg($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    //WRITE 
                    imagejpeg($imgResized,  $savePath); 
                } 
                // png
                if($imageFileType == "png"){
                    $image = imagecreatefrompng($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    imagealphablending($imgResized, false);
                    imagesavealpha($imgResized, true);
                    //WRITE
                    imagepng($imgResized,  $savePath);
                }
            }
        }
        if ($SQ_IMG4 !=''){
            $savePath = $_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id."/".basename($SQ_IMG4); // Replace with your desired save path
            $ch = curl_init($SQ_IMG4);
            $fp = fopen($savePath, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp); 
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch,CURLOPT_USERAGENT,'curl/'.(curl_version()['version']));
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $imageFileType = strtolower(pathinfo($savePath,PATHINFO_EXTENSION));
            $check = getimagesize($savePath);
            $image_width = "".$check[0];
            //RESIZE
            if ($image_width > 700){
                //webp
                if($imageFileType == "webp"){
                    $image = imagecreatefromwebp($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    //WRITE
                    imagewebp($imgResized,  $savePath);
                    imagedestroy($image);
                } 
                // jpeg
                if($imageFileType == "jpg" || $imageFileType == "jpeg"){
                    $image = imagecreatefromjpeg($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    //WRITE 
                    imagejpeg($imgResized,  $savePath); 
                } 
                // png
                if($imageFileType == "png"){
                    $image = imagecreatefrompng($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    imagealphablending($imgResized, false);
                    imagesavealpha($imgResized, true);
                    //WRITE
                    imagepng($imgResized,  $savePath);
                }
            }
        }
        if ($SQ_IMG5 !=''){
            $savePath = $_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id."/".basename($SQ_IMG5); // Replace with your desired save path
            $ch = curl_init($SQ_IMG5);
            $fp = fopen($savePath, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp); 
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch,CURLOPT_USERAGENT,'curl/'.(curl_version()['version']));
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $imageFileType = strtolower(pathinfo($savePath,PATHINFO_EXTENSION));
            $check = getimagesize($savePath);
            $image_width = "".$check[0];
            //RESIZE
            if ($image_width > 700){
                //webp
                if($imageFileType == "webp"){
                    $image = imagecreatefromwebp($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    //WRITE
                    imagewebp($imgResized,  $savePath);
                    imagedestroy($image);
                } 
                // jpeg
                if($imageFileType == "jpg" || $imageFileType == "jpeg"){
                    $image = imagecreatefromjpeg($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    //WRITE 
                    imagejpeg($imgResized,  $savePath); 
                } 
                // png
                if($imageFileType == "png"){
                    $image = imagecreatefrompng($savePath);
                    //SCALE
                    $imgResized = imagescale($image , 700, -1);
                    imagealphablending($imgResized, false);
                    imagesavealpha($imgResized, true);
                    //WRITE
                    imagepng($imgResized,  $savePath);
                }
            }
        }
        //IMAGES
        //set_time_limit(0);
/*         $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER ,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_URL, $SQ_IMG);
        $imageContent = curl_exec($ch);
        curl_close($ch);
        sleep(2);
        if (!$imageContent){
            $options = [
                'http' => [
                    'header' => 'Accept: image/png' // Or 'image/png', 'image/gif', etc.
                ]
            ];
            $context = stream_context_create($options);
            $imageContent = file_get_contents($SQ_IMG, false, $context);
            sleep(3);
        }
        if (!$imageContent){
            copy($SQ_IMG, $_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id."/".basename($SQ_IMG));
            echo "copy";
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/fs/product/" . $inserted_id."/".basename($SQ_IMG), $imageContent);
        } */

        //OPTIONS
        if ($SQ_OPTS != ""){
            $headers = array(
            "Square-Version: 2025-06-18",
            "Content-Type: application/json",
            "Authorization: Bearer ".$CIE_SQUARE_KEY
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://connect.squareup.com/v2/catalog/list?types=ITEM_OPTION");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $response = json_decode($result,true);
            if (isset($response["objects"])){
                foreach ( $response["objects"] as $item ) {  	
                    if (trim($item["type"]) == "ITEM_OPTION" && $item["id"] == $SQ_OPTS && $item["is_deleted"] == false){
                        //insert option head
                        $sql = "INSERT INTO product_option (product_id,name_fr)
                        VALUES ('".$inserted_id."','" . $item["item_option_data"]["name"] . "')";
                        if ($dw3_conn->query($sql) === TRUE) {
                            $option_id = $dw3_conn->insert_id;
                            foreach ( $item["item_option_data"]["values"] as $options ) {
                                if ($options["is_deleted"] == false){
                                    //insert option line
                                    $sql = "INSERT INTO product_option_line (option_id,name_fr)
                                    VALUES ('".$option_id."','" . $options["item_option_value_data"]["name"] . "')";
                                    if ($dw3_conn->query($sql) !== TRUE) {
                                        //error
                                    }
                                }
                            }
                        }   
                    }
                }
            }
        }
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

$dw3_conn->close();
?>
<!-- {"type":"ITEM_OPTION",
            "id":"GYYLHKDO45TOWVPIHWH5UR56",
            "updated_at":"2025-06-29T20:55:59.065Z",
            "created_at":"2025-06-29T20:55:59.111Z",
            "version":1751230559065,
            "is_deleted":false,
            "present_at_all_locations":true,
            "item_option_data":{
                "name":"Couleur",
                "display_name":"Couleur",
                "show_colors":false,
                "values":[
                    {
                        "type":"ITEM_OPTION_VAL",
                        "id":"VTF3VN2FMHGZQMWW2NXXRU5T",
                        "updated_at":"2025-06-29T20:55:59.065Z",
                        "created_at":"2025-06-29T20:55:59.111Z",
                        "version":1751230559065,
                        "is_deleted":false,
                        "present_at_all_locations":true,
                        "item_option_value_data":{
                            "item_option_id":"GYYLHKDO45TOWVPIHWH5UR56",
                            "name":"Noir",
                            "ordinal":0
                        }
                    },
                    {"type":"ITEM_OPTION_VAL",
                        "id":"WA6Q4FD5J4XECAN3QNMJFY6M",
                        "updated_at":"2025-06-29T20:55:59.065Z",
                        "created_at":"2025-06-29T20:55:59.111Z",
                        "version":1751230559065,
                        "is_deleted":false,
                        "present_at_all_locations":true,
                        "item_option_value_data":{
                            "item_option_id":"GYYLHKDO45TOWVPIHWH5UR56",
                            "name":"Blanc",
                            "ordinal":1
                        }
                    }
                    ]
                }
            }
            ]
        } -->

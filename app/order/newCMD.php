<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/picqer/vendor/autoload.php';
$CLI   = $_GET['CLI'];

//get cli data before insert 
	$sql = "SELECT * FROM customer WHERE id = '" .  $CLI . "'";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
    $location_id = $data["location_id"];
//calcul date livraison
$livtime = strtotime($today);
if (isset($CIE_LV_F1) && $CIE_LV_F1 != ""){ 
    $livfinal = date("Y-m-d", strtotime("+".$CIE_LV_F1. " ".$CIE_LV_F2, $livtime));
} else {
    $livfinal = date("Y-m-d", strtotime("+1 month", $livtime));   
}

//verif si location toujours bonne
$sql2 = "SELECT * FROM location WHERE id = '" .  $data["location_id"] . "'";
$result2 = mysqli_query($dw3_conn, $sql2);
$numrows2 = $result2->num_rows;
if ($numrows2 == 0) {	
    $location_id = $CIE_DFT_ADR2;
}

//insert
	$sql = "INSERT INTO order_head
    (customer_id,location_id,ship_type,name,company,eml,tel,adr1,adr2,city,prov,country,postal_code,adr1_sh,adr2_sh,city_sh,province_sh,country_sh,postal_code_sh,date_created,date_delivery,date_modified)
    VALUES 
        ('" . $data['id']  . "',
         '" . $location_id   . "',
         '" . $CIE_TRANSPORT . "',
         '" . str_replace("'","’",trim($data['first_name']  . " " . trim($data['middle_name'])  . " " . $data['last_name']))  . "',
         '" . str_replace("'","’",$data['company'])   . "',
         '" . $data['eml1']   . "',
         '" . $data['tel1']   . "',
         '" . $data['adr1']   . "',
         '" . $data['adr2']  . "',
         '" . str_replace("'","’",$data['city'])  . "',
         '" . $data['province']  . "',
         '" . $data['country'] . "',
         '" . $data['postal_code']  . "',
         '" . $data['adr1_sh']   . "',
         '" . $data['adr2_sh']  . "',
         '" . $data['city_sh']  . "',
         '" . $data['province_sh']  . "',
         '" . $data['country_sh'] . "',
         '" . $data['postal_code_sh']  . "',
         '" . $datetime  . "',
         '" . $livfinal  . "',
         '" . $datetime  . "')";
//die($sql);
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        echo $inserted_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

    // Generate the barcode image
    $CBgenerator = new Picqer\Barcode\BarcodeGeneratorSVG();
    $barcodeData = $inserted_id; // The data to encode in the barcode
    $barcodeType = $CBgenerator::TYPE_CODE_128; // The type of barcode (e.g., Code 128)
    $widthFactor = 2; // Width factor for the bars
    $height = 30; // Height of the barcode in pixels
    $foregroundColor = 'black'; // Color of the barcode bars
    $addText = true; // Whether to display the text under the barcode
    $barcodeImage = $CBgenerator->getBarcode($barcodeData, $barcodeType, $widthFactor, $height, $foregroundColor, $addText);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/fs/order/". $inserted_id .".svg", $barcodeImage);

    //ajout évènement
    $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
        VALUES('ORDER','Création de commande','No de commande: ".$inserted_id."\nCréée par: ".$USER_FULLNAME ."','". $datetime ."','".$data['id']."','".$USER."')";
    $result_task = $dw3_conn->query($sql_task);  

$dw3_conn->close();
?>

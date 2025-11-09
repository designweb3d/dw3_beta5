<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/picqer/vendor/autoload.php';

$CMD   = $_GET['CMD'];
$SHIP_TYPE   = $_GET['SHIP_TYPE'];

	/* $sql = "SELECT COUNT(id) as rowCount FROM order_line WHERE head_id = '" . $CMD . "' AND product_id IN (SELECT id FROM product WHERE ship_type= 'CARRIER' OR ship_type= 'INTERNAL')";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] <= 0) {
		die ("Erreur: Aucune article nécessitant une expédition n'a été trouvée pour cette commande.");
	} */
	$sql = "SELECT COUNT(id) as rowCount FROM order_line WHERE head_id = '" . $CMD . "' AND qty_order > qty_shipped AND product_id IN (SELECT id FROM product WHERE ship_type= 'CARRIER' OR ship_type= 'INTERNAL')";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] <= 0) {
        $dw3_conn->close();
		die ("Erreur: Aucune article nécessitant une expédition n'a été trouvée pour cette commande.");
	}

//get cli data before insert 
	$sql = "SELECT * FROM order_head WHERE id = '" .  $CMD . "'";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);

if ($data['ship_type'] ==  "" && $SHIP_TYPE == "") {
    $dw3_conn->close();
    die ("Err1");
}

if ($data['ship_type'] == "") {
    $data['ship_type'] = $SHIP_TYPE;
}
//insert
	$sql = "INSERT INTO shipment_head
    (order_id,weight,width,height,length,ship_code,ship_type,date_created,date_estimated)
    VALUES 
        ('" . $data['id']  . "',
         '" . $data['weight']  . "',
         '" . $data['width']  . "',
         '" . $data['height']  . "',
         '" . $data['length']  . "',
         '" . $data['ship_code']  . "',
         '" . $data['ship_type']  . "',
         '" . $datetime . "',
         '" . $data['date_delivery'] . "')";
//die ($sql);
	if ($dw3_conn->query($sql) === TRUE) {
        $inserted_id = $dw3_conn->insert_id;
        echo $inserted_id;

        //insert lines 
        $sql = "INSERT INTO shipment_line (head_id,line_id,qty_shipped)
                SELECT '" . $inserted_id . "',id,qty_order - qty_shipped
                FROM order_line WHERE head_id = ". $CMD
                ." AND product_id IN (SELECT id FROM product WHERE ship_type= 'CARRIER' OR ship_type= 'INTERNAL')";
        if ($dw3_conn->query($sql) === TRUE) {
        } else {
          echo "Erreur: " . $dw3_conn->error;
        }


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
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/fs/order/". $data['id'] . "_".$inserted_id.".svg", $barcodeImage);


    //ajout évènement
    $sql_task = "INSERT INTO event (event_type,name,description,date_start,customer_id,user_id) 
        VALUES('ORDER','Expédition de commande','No de commande: ".$CMD."\nNo expédition: ".$inserted_id."\nCréée par: ".$USER_FULLNAME ."','". $datetime ."','".$data['id']."','".$USER."')";
    $result_task = $dw3_conn->query($sql_task);  

$dw3_conn->close();
?>

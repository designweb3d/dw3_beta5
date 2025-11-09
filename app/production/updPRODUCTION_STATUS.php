  <?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID             = $_GET['ID'];
$STATUS         = $_GET['STATUS'];
$QTY_NEEDED          = $_GET['QTY_NEEDED'];
$QTY_PRODUCED           = $_GET['QTY_PRODUCED'];
$LOT              = str_replace("'","’",$_GET['LOT']);
$ORDER              = $_GET['ORDER'];
$STORAGE              = $_GET['STORAGE'];
$QUALITY_1              = str_replace("'","’",$_GET['QUALITY_1']);
$QUALITY_2              = str_replace("'","’",$_GET['QUALITY_2']);
$QUALITY_3              = str_replace("'","’",$_GET['QUALITY_3']);
$QUALITY_4              = str_replace("'","’",$_GET['QUALITY_4']);
$START  			= str_replace("'","’",$_GET['START']);
$END  			= str_replace("'","’",$_GET['END']);


//UPDATE DU FICHIER DE PRODUCTION
     $sql = "UPDATE production SET    
	 status = '" . $STATUS . "',
	 qty_needed = '" . $QTY_NEEDED . "',
	 qty_produced = '" . $QTY_PRODUCED . "',
	 lot_no = '" . $LOT . "',
	 order_id = '" . $ORDER . "',
	 storage_id = '" . $STORAGE . "',
	 quality_val1 = '" . $QUALITY_1 . "',
	 quality_val2 = '" . $QUALITY_2 . "',
	 quality_val3 = '" . $QUALITY_3 . "',
	 quality_val4 = '" . $QUALITY_4 . "',
	 date_start = '" . $START . "',
	 date_end = '" . $END . "'
	 WHERE id = '" . $ID . "' 
	 LIMIT 1";

    if ($dw3_conn->query($sql) === TRUE) {
        //UPDATE DES STOCKS SI COMPLETED
        if($STATUS=='COMPLETED'){
            //GET HEAD INFO
            $sql = "SELECT A.*, B.import_storage_id
            FROM procedure_head A
            LEFT JOIN (SELECT id, import_storage_id FROM product) B ON A.product_id = B.id 
            WHERE A.id = (SELECT procedure_id FROM production WHERE id = '" . $ID . "' LIMIT 1)";
            $result = mysqli_query($dw3_conn, $sql);
            $data = mysqli_fetch_assoc($result);;
            //INSERT STOCK MOVEMENT
            $sqlH = "INSERT INTO transfer (kind, product_id, order_id, storage_id, quantity, date_created, user_created) VALUES (
                'PROD',
                '" . $data['product_id'] . "',
                '" . $ORDER . "',
                '" . $STORAGE . "',
                '" . $QTY_PRODUCED . "',
                '".$datetime."',
                '".$USER."'
            )";
            $dw3_conn->query($sqlH);
        } else if ($STATUS=='IN_PRODUCTION') {
            //GET PROCEDURE LINES
            $sqlPL = "SELECT A.*, IFNULL(B.import_storage_id,0) AS import_storage_id
            FROM procedure_line A
            LEFT JOIN (SELECT id, import_storage_id FROM product) B ON A.product_id = B.id 
            WHERE A.procedure_id = (SELECT procedure_id FROM production WHERE id = '" . $ID . "' LIMIT 1)";
            $resultPL = $dw3_conn->query($sqlPL);
            if ($resultPL->num_rows > 0) {		
                while($rowPL = $resultPL->fetch_assoc()) {
                    //INSERT STOCK MOVEMENT
                    $sqlSM = "INSERT INTO transfer (kind, product_id, order_id, storage_id, quantity, date_created, user_created) VALUES (
                        'PROD',
                        '" . $rowPL["product_id"] . "',
                        '" . $ORDER . "',
                        '" . $rowPL["import_storage_id"] . "',
                        '-" . ($rowPL["qty_by_unit"] * $QTY_PRODUCED) . "',
                        '".$datetime."',
                        '".$USER."'
                    )";
                    $dw3_conn->query($sqlSM);
                }
            }
        } 
	} else {
	    echo $dw3_conn->error;
	}
$dw3_conn->close();
die();
?>
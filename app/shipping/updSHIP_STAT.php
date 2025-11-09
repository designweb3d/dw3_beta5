<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID     = $_GET['ID'];
$order_status     = $_GET['S'];

    if ($order_status == "1") {
        $sql = "UPDATE shipment_head SET stat = '" . $order_status    . "', date_packed='".$datetime."'	WHERE id = '" . $ID . "' LIMIT 1";
    } else if ($order_status == "2") {
        $sql = "UPDATE shipment_head SET stat = '" . $order_status    . "', date_shipped='".$datetime."'	WHERE id = '" . $ID . "' LIMIT 1";
    } else if ($order_status == "3") {
        $sql = "UPDATE shipment_head SET stat = '" . $order_status    . "', date_routed='".$datetime."'	WHERE id = '" . $ID . "' LIMIT 1";
    } else if ($order_status == "4") {
        $sql = "UPDATE shipment_head SET stat = '" . $order_status    . "', date_delivery='".$datetime."'	WHERE id = '" . $ID . "' LIMIT 1";
    } else if ($order_status == "5") {
        $sql = "UPDATE shipment_head SET stat = '" . $order_status    . "' WHERE id = '" . $ID . "' LIMIT 1";
    } else if ($order_status == "0") {
        $sql = "UPDATE shipment_head SET stat = '" . $order_status    . "' WHERE id = '" . $ID . "' LIMIT 1";
    }
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo "";
	} else {
	  echo $dw3_conn->error;
	}

	//get shipment lines
	$sql = "SELECT * FROM shipment_line WHERE head_id = '" . $ID . "'";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$lineID = $row['line_id'];
			$qtyShipped = $row['qty_shipped'];

            //get infos from order line
            $sql2 = "SELECT * FROM order_line WHERE id = '" . $lineID . "' LIMIT 1";
            $result2 = mysqli_query($dw3_conn, $sql2);
            $data2 = mysqli_fetch_assoc($result2);
            $productID = $data2['product_id'];
            $orderID = $data2['head_id'];
            $qtyTO_SHIP = $data2['qty_order'] - $data2['qty_shipped'];
            //get product info 
            $sql2 = "SELECT * FROM product WHERE id = '" . $productID . "' LIMIT 1";
            $result2 = mysqli_query($dw3_conn, $sql2);
            $data2 = mysqli_fetch_assoc($result2);
            $storage_id = $data2['import_storage_id'];

            //if delivered, update order line shipped qty
            if ($order_status == "4") {
                $sql4 = "UPDATE order_line SET qty_shipped = qty_shipped + '" . $qtyShipped  . "' WHERE id = '" . $lineID . "' LIMIT 1";
                mysqli_query($dw3_conn, $sql4);
                /* $sql4 = "UPDATE shipment_line SET qty_shipped = '" . $qtyTO_SHIP . "' WHERE line_id = '" . $lineID . "' LIMIT 1";
                mysqli_query($dw3_conn, $sql4); */
            }
            //if cancelled, update inventory stock back
            if ($order_status == "5") {
                //set back qty shipped in shipment line
                $sql2 = "UPDATE shipment_line SET qty_shipped = '" . $qtyTO_SHIP . "' WHERE line_id = '" . $lineID . "' LIMIT 1";
                $result2 = mysqli_query($dw3_conn, $sql2);

                if ($qtyShipped > 0) {
                    //update inventory stock
                    $sql3 = "INSERT INTO transfer (product_id,kind,storage_id,order_id,quantity) VALUES ('" . $productID  . "', 'RETURN', '" . $storage_id  . "', '" . $orderID  . "', '" . $qtyShipped  . "')";
                    if ($dw3_conn->query($sql3) === TRUE) {
                        //echo "";
                    } else {
                    echo $dw3_conn->error;
                    }
                }
            }
	    }
    }

$dw3_conn->close();
?>

<?php
header("X-Robots-Tag: noindex, nofollow", true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$shipmentID  = $_GET['shID'];

//data from shipment head
$sqls = "SELECT * FROM shipment_head WHERE id = '" . $shipmentID . "' LIMIT 1";
$results = mysqli_query($dw3_conn, $sqls);
$datas = mysqli_fetch_assoc($results);
$orderID = $datas['order_id'];
$tracking_number = $datas['tracking_number'];

//data from order head
$sql = "SELECT * FROM order_head WHERE id = '" . $orderID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

//update order status to shipped
$sql = "UPDATE order_head SET stat = '3' WHERE id = '" . $orderID . "' LIMIT 1";
if ($dw3_conn->query($sql) === TRUE) {
    //echo "";
} else {
   echo $dw3_conn->error;
}

//update inventory stock
$sql = "SELECT * FROM shipment_line WHERE head_id = '" . $shipmentID . "'";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $lineID = $row['line_id'];
        $qtyShipped = $row['qty_shipped'];
        if ($qtyShipped > 0) {
            //get product id from order line
            $sql2 = "SELECT * FROM order_line WHERE id = '" . $lineID . "' LIMIT 1";
            $result2 = mysqli_query($dw3_conn, $sql2);
            $data2 = mysqli_fetch_assoc($result2);
            $productID = $data2['product_id'];
            $orderID = $data2['head_id'];
            //get product info 
            $sql2 = "SELECT * FROM product WHERE id = '" . $productID . "' LIMIT 1";
            $result2 = mysqli_query($dw3_conn, $sql2);
            $data2 = mysqli_fetch_assoc($result2);
            $storage_id = $data2['import_storage_id'];

            //update inventory stock
            $sql3 = "INSERT INTO transfer (product_id,kind,storage_id,order_id,quantity) VALUES ('" . $productID  . "', 'EXPORT', '" . $storage_id  . "', '" . $orderID  . "', '-" . $qtyShipped  . "')";
            if ($dw3_conn->query($sql3) === TRUE) {
                //echo "";
            } else {
            echo $dw3_conn->error;
            }
            //update order line shipped qty
            //changed to when delivered
            /* $sql4 = "UPDATE order_line SET qty_shipped = qty_shipped + '" . $qtyShipped  . "' WHERE id = '" . $lineID . "' LIMIT 1";
            if ($dw3_conn->query($sql4) === TRUE) {
                //echo "";
            } else {
            echo $dw3_conn->error;
            } */
            /* //update shipment line shipped qty
            $sql4 = "UPDATE shipment_line SET qty_shipped = qty_shipped + '" . $qtyShipped  . "' WHERE id = '" . $lineID . "' LIMIT 1";
            if ($dw3_conn->query($sql4) === TRUE) {
                //echo "";
            } else {
            echo $dw3_conn->error;
            } */
        } else {
            /* //get product id from order line
            $sql2 = "SELECT * FROM order_line WHERE id = '" . $lineID . "' LIMIT 1";
            $result2 = mysqli_query($dw3_conn, $sql2);
            $data2 = mysqli_fetch_assoc($result2);
            //update shipment line shipped qty
            $sql4 = "UPDATE shipment_line SET qty_shipped = '" . $data2['qty_order'] - $data2['qty_shipped']  . "' WHERE id = '" . $row['id'] . "' LIMIT 1";
            if ($dw3_conn->query($sql4) === TRUE) {
                //echo "";
            } else {
            echo $dw3_conn->error;
            } */
        }

    }
}

if ($tracking_number == ""){
    $tracking_number = dw3_make_tracking_number(12);
    for ($i=0; $i < 100; $i++) {
        $sql2 = "SELECT count(*) as count FROM shipment_head WHERE tracking_number = '" . $tracking_number . "'";
        $result2 = mysqli_query($dw3_conn, $sql2);
        $data2 = mysqli_fetch_assoc($result2);
        $track_count = $data2['count'];
        if ($track_count == "0") {
            break;
        } else {
            $tracking_number = dw3_make_tracking_number(20);
        }
    }
}
$tracking_url="https://".$_SERVER["SERVER_NAME"]."/pub/page/tracking/tracking.php?TRN=" . $tracking_number . "";
//update shipment status to shipped
$sql = "UPDATE shipment_head SET stat = '1', shipment_id = 'INTERNAL', tracking_number = '" . $tracking_number . "', tracking_url = '" . $tracking_url . "' WHERE id = '" . $shipmentID . "' LIMIT 1";
if ($dw3_conn->query($sql) === TRUE) {
    echo "Mise à jour de l'inventaire, du status de la commande et de l'expédition réussie.<br>Imprimez l'étiquette et placez la sur la boite.";
} else {
 echo $dw3_conn->error;
}
$dw3_conn->close();
?>
<?php
//cart to order to invoice
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 

$sql_cart = "SELECT  * FROM cart_line WHERE device_id ='" . $USER_DEVICE . "';";
$result_cart = $dw3_conn->query($sql_cart);
    $qty_lines = $result_cart->num_rows??0;
    if ($qty_lines > 0) {
        while($row_cart = $result_cart->fetch_assoc()) { 
            $sql = "DELETE FROM cart_option WHERE line_id = '" . $row_cart["id"] . "';";
            $result = $dw3_conn->query($sql);
        }
    $sql = "DELETE FROM cart_line WHERE device_id ='" . $USER_DEVICE . "';";
    $result = $dw3_conn->query($sql);
    }
$dw3_conn->close();
?>

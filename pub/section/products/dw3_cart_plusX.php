<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$ID = $_GET['ID'];
$MAX = $_GET['MAX'];

    $sql = "SELECT * FROM cart_line WHERE id = '" . $ID . "';";
    $result = mysqli_query($dw3_conn, $sql);
        if ($result->num_rows > 0) {
            $data = mysqli_fetch_assoc($result);

            //get product info
            $sql2 = "SELECT * FROM product WHERE id = '" . $data["product_id"] . "' LIMIT 1";
            $result2 = mysqli_query($dw3_conn, $sql2);
            $data2 = mysqli_fetch_assoc($result2);

            if ($MAX == "" || $data["quantity"]+($data2["qty_step"]*10) <= $MAX || $data2["qty_max_by_inv"] == "0"){
                $sql = "UPDATE cart_line SET quantity = quantity + ".($data2["qty_step"]*10)." WHERE id = '".$ID."';";
                $result = mysqli_query($dw3_conn, $sql);
            }
        }
$dw3_conn->close();
?>
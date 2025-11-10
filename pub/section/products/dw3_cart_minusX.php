<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$ID = $_GET['ID'];
$MIN = $_GET['MIN'];

//get cart count
$sql1 = "SELECT COUNT(id) AS cart_count FROM cart_line WHERE device_id = '" . $USER_DEVICE . "'";
$result1 = mysqli_query($dw3_conn, $sql1);
$data = mysqli_fetch_assoc($result1);
$cart_count = $data["cart_count"];

//get line info
$sql1 = "SELECT * FROM cart_line WHERE id = '" . $ID . "' LIMIT 1";
$result1 = mysqli_query($dw3_conn, $sql1);
$data1 = mysqli_fetch_assoc($result1);

//get product info
$sql2 = "SELECT * FROM product WHERE id = '" . $data1["product_id"] . "' LIMIT 1";
$result2 = mysqli_query($dw3_conn, $sql2);
$data2 = mysqli_fetch_assoc($result2);

if ($data1["quantity"] == $data2["qty_step"]){
    /* $sql = "DELETE FROM cart_line WHERE id = '".$ID."';";
    $result = mysqli_query($dw3_conn, $sql);
    $sql = "DELETE FROM cart_option WHERE line_id = '".$ID."';";
    $result = mysqli_query($dw3_conn, $sql);
    $cart_count = $cart_count -1; */
    echo $cart_count;
} else if ($data1["quantity"]-($data2["qty_step"]*10) >= $MIN){
    $sql = "UPDATE cart_line SET quantity = quantity-".($data2["qty_step"]*10)." WHERE id = '".$ID."';";
    $result = mysqli_query($dw3_conn, $sql);
    echo $cart_count;
} else {
    echo $cart_count;
}

$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$ID = $_GET['ID'];
$MIN = $_GET['MIN'];
$MAX = $_GET['MAX'];
$QTY = floor($_GET['QTY']);

function isMultiple(int $number, int $divisor): bool {
    if ($divisor === 0) {
        return false;
    }
    return ($number % $divisor === 0);
}

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

$response_text = "La quantité a été mise à jour.";

if ($QTY == "" || $QTY == "0" || round($QTY) == 0){
    $response_text = "La quantité minimum par achat est de ".round($data2["qty_min_sold"]).".";
    $sql = "UPDATE cart_line SET quantity = " . $data2["qty_min_sold"] . " WHERE id = '".$ID."';";
    $result = mysqli_query($dw3_conn, $sql);
    $dw3_conn->close();
    die('{"line_qty":"'.$data2["qty_min_sold"].'","cart_count":"'.$cart_count.'","response_text":"'.$response_text.'"}');
}

if ($QTY < $data2["qty_min_sold"]){
    $response_text = "La quantité minimum par achat est de ".round($data2["qty_min_sold"]).".";
    $sql = "UPDATE cart_line SET quantity = " . $data2["qty_min_sold"] . " WHERE id = '".$ID."';";
    $result = mysqli_query($dw3_conn, $sql);
    $dw3_conn->close();
    die('{"line_qty":"'.$data2["qty_min_sold"].'","cart_count":"'.$cart_count.'","response_text":"'.$response_text.'"}');
}

if ($MAX != "" && $QTY < $MAX && $data2["qty_max_by_inv"] == "1"){
    $response_text = "La quantité désiré dépasse la quantité en inventaire qui est de ".round($MAX).".";
    $sql = "UPDATE cart_line SET quantity = " . $MAX . " WHERE id = '".$ID."';";
    $result = mysqli_query($dw3_conn, $sql);
    $dw3_conn->close();
    die('{"line_qty":"'.$MAX.'","cart_count":"'.$cart_count.'","response_text":"'.$response_text.'"}');
}

if (!isMultiple($QTY,$data2["qty_step"])){
    $response_text = "La quantité doit être un multiple de ".$data2["qty_step"].".";
    $sql = "UPDATE cart_line SET quantity = " . $data2["qty_step"] . " WHERE id = '".$ID."';";
    $result = mysqli_query($dw3_conn, $sql);
    $dw3_conn->close();
    die('{"line_qty":"'.$data2["qty_step"].'","cart_count":"'.$cart_count.'","response_text":"'.$response_text.'"}');
}

$sql = "UPDATE cart_line SET quantity = ".$QTY." WHERE id = '".$ID."';";
$result = mysqli_query($dw3_conn, $sql);
echo '{"line_qty":"'.$QTY.'","cart_count":"'.$cart_count.'","response_text":"'.$response_text.'"}';
$dw3_conn->close();
?>
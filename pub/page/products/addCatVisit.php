<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$catID = $_GET['C']??'';
if ($catID != "" && $catID != "all" && $catID != "promo"){
    $sqlx = "UPDATE product_category SET qty_visited = qty_visited +1  WHERE id = '" . $catID . "' LIMIT 1";
    $resultx = mysqli_query($dw3_conn, $sqlx);
}
die("");
?>
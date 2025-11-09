<?php
//include file
//requiremnents:
//$product_id = xxx;
//$product_qty = xxx;
//$customer_id = xxx;

$product_price = 0.0000;

	$sql_inc = "SELECT * FROM product WHERE id = '".$product_id."' LIMIT 1;";
    $result_inc = mysqli_query($dw3_conn, $sql_inc);
    $data_inc = mysqli_fetch_assoc($result_inc);

    //prix1
    $product_price = $data_inc["price1"];

    //prix2 replaced by product_pack
/*     if ($data_inc["price2"] != 0 && $data_inc["qty_min_price2"] > 1 && $product_qty >= $data_inc["qty_min_price2"] && $product_price > $data_inc["price2"]){
        $product_price = $data_inc["price2"];
    } */

    //prix promo
    $date_promo = new DateTime($data_inc["promo_expire"]);
    $now = new DateTime();
    if($date_promo > $now && $product_price > $row["promo_price"] && $product_price > $data_inc["promo_price"] && $data_inc["promo_price"] >= 0) {
        $product_price = $data_inc["promo_price"];
    }

    //prix product_pack
    $sql_inc_z = "SELECT  * FROM product_pack WHERE product_id ='" . $product_id . "' ORDER BY pack_qty ASC";
    $result_inc_z = $dw3_conn->query($sql_inc_z);
    if ($result_inc_z->num_rows> 0) { 
        while($row_inc_z = $result_inc_z->fetch_assoc()) {
            //echo "packqty=".$row_inc_z["pack_qty"] ;
            //echo "packprice=".$row_inc_z["pack_price"] ;
            //if ($product_qty >= $row_inc_z["pack_qty"] && $product_price > $row_inc_z["pack_price"] && $row_inc_z["pack_price"] >=0){
            if ($product_qty >= $row_inc_z["pack_qty"]){
                $product_price = $row_inc_z["pack_price"];
            }
        }
    }

    //escompte client / fournisseur
    $sql_inc_x = "SELECT * FROM customer_discount WHERE customer_id =  '".$customer_id."' AND supplier_id = '" . $data_inc["supplier_id"] . "' AND supplier_id <> 0 LIMIT 1";
    $result_inc_x = mysqli_query($dw3_conn, $sql_inc_x);
    $data_inc_x = mysqli_fetch_assoc($result_inc_x);
    if (isset($data_inc_x["escount_pourcent"]) && $data_inc_x["escount_pourcent"] != 0){
        $discount_price = $product_price - (round($product_price*($data_inc_x["escount_pourcent"]/100),2));
    } else {$discount_price = 0;}
    if ($discount_price < $product_price && $discount_price > 0 && $product_price > $discount_price && $discount_price >= 0){
        $product_price = $discount_price;
    }

?>

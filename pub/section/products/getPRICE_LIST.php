<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$product_id = $_GET['prID'];
$customer_id = $_GET['clID'];
$line_id = $_GET['lnID'];

    $sql = "SELECT  * FROM product WHERE id = '" . $product_id . "' LIMIT 1;";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) {
            if ($USER_LANG == "FR" || $USER_LANG == ""){
                echo "<b>".$row["name_fr"]."</b><br>";
                echo "<div style='text-align:left;'><table class='tblDATA'><tr><th>Quantité miminum par achat:</th><td style='border-radius:0px;text-align:center;'><b>". round($row["qty_min_sold"],2) . "</b></td></tr>";
                echo "<th>Prix unitaire:</th><td style='text-align:center;'><b>". $line_price = number_format($row["price1"],2,"."," ") . "</b>$</td></tr>";
            } else {
                echo "<b>".$row["name_en"]."</b><br>";
                echo "<div style='text-align:left;'><table class='tblDATA'><tr><th>Minimum quantity per purchase:</th><td style='border-radius:0px;text-align:center;'><b>". round($row["qty_min_sold"],2) . "</b></td></tr>";
                echo "<th>Unit Price:</th><td style='text-align:center;'><b>". $line_price = number_format($row["price1"],2,"."," ") . "</b>$</td></tr>";
            }
                //prix promo
                $date_promo = new DateTime($row["promo_expire"]);
                $now = new DateTime();
                if($date_promo > $now && $row["promo_price"] >= 0) {
                    if ($USER_LANG == "FR" || $USER_LANG == ""){
                        echo "<th>Prix en promotion:</th><td style='text-align:center;'><b>".number_format($row["promo_price"],2,"."," ") . "</b>$</td></tr>";
                    } else {
                        echo "<th>Promotion price:</th><td style='text-align:center;'><b>".number_format($row["promo_price"],2,"."," ") . "</b>$</td></tr>";
                    }
                }
            echo "</table>";
            //product_pack
            $sql2 = "SELECT  * FROM product_pack WHERE product_id ='" . $row["id"] . "' ORDER BY pack_qty ASC;";
            $result2 = $dw3_conn->query($sql2);
            if ($result2->num_rows > 0) { 
                if ($USER_LANG == "FR" || $USER_LANG == ""){
                    echo "<br><h3 style='text-align:left;'><span class='dw3_font'>£</span> Liste de prix par quantité</h3>";
                    echo "<table class='tblSEL'><tr><th style='text-align:center;'>Quantité</th><th style='text-align:center;'>Prix Unitaire</th><th style='text-align:center;'>Total</th></tr>";
                } else {
                    echo "<br><h3 style='text-align:left;'><span class='dw3_font'>£</span> Price list by quantity</h3>";
                    echo "<table class='tblSEL'><tr><th style='text-align:center;'>Quantity</th><th style='text-align:center;'>Unit Price</th><th style='text-align:center;'>Total</th></tr>";
                }
                while($row2 = $result2->fetch_assoc()) {
                    echo "<tr onclick='dw3_set_item_qty(".$line_id.",".round($row2["pack_qty"],2).")'><td style='text-align:center;'>".round($row2["pack_qty"],2)."</td><td style='text-align:center;'>".number_format($row2["pack_price"],2,"."," ")."$</td><td style='text-align:center;'>".number_format($row2["pack_price"]*$row2["pack_qty"],2,"."," ")."$</td></tr>";
                }
                echo "</table>";
            }
                //escompte client / fournisseur
                if ($customer_id != "0" && $customer_id != ""){
                    $sql_inc_x = "SELECT * FROM customer_discount WHERE customer_id =  '".$customer_id."' AND supplier_id = '" . $row["supplier_id"] . "' AND supplier_id <> 0 LIMIT 1";
                    $result_inc_x = mysqli_query($dw3_conn, $sql_inc_x);
                    if ($result_inc_x->num_rows > 0) {
                        $data_inc_x = mysqli_fetch_assoc($result_inc_x);
                        if ($USER_LANG == "FR" || $USER_LANG == ""){
                            echo "<table class='tblDATA'><tr><th>Votre escompte pour ce fournisseur:</th><td style='text-align:center;'>". $data_inc_x["escount_pourcent"] . "%</td></tr>";
                        } else {
                            echo "<table class='tblDATA'><tr><th>Your discount for this supplier:</th><td style='text-align:center;'>". $data_inc_x["escount_pourcent"] . "%</td></tr>";    
                        }
                    }
                }
            echo "</div>";
        }
    }

$dw3_conn->close();
die();
?>
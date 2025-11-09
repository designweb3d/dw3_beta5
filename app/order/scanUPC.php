<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$UPC  = $_GET['UPC'];
$QTE  = $_GET['QTE'];
$enID  = $_GET['enID'];
$html = "";
	$sql = "SELECT COUNT(upc) as rowCount FROM product WHERE upc = '" . $UPC . "' AND upc <> ''";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);
	if ($data['rowCount'] == "0" || $UPC == "0" || $UPC == "") {
        $sql = "SELECT A.*, IFNULL(B.tot_inv,0) AS tot_inv 
        FROM product A
        LEFT JOIN (SELECT product_id,SUM(quantity) AS tot_inv FROM transfer GROUP BY product_id) B ON B.product_id = id
        WHERE CONCAT(id, upc, sku, UCASE(name_fr), UCASE(description_fr)) LIKE '%" . strtoupper($UPC) . "%' AND stat = 0
        ORDER BY name_fr ASC LIMIT 100";

        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {	
            $html .= "<table class='tblSEL'>";
            while($row = $result->fetch_assoc()) {
                $filename= $row["url_img"];
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                    $filename = "/pub/img/dw3/nd.png";
                } else {
                    if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                        $filename = "/pub/img/dw3/nd.png";
                    }else{
                        $filename = "/fs/product/" . $row["id"] . "/" . $filename;
                    }
                }

                $line_price = $row["price1"];
                //verif si promo
                    $date_promo = new DateTime($row["promo_expire"]);
                    $now = new DateTime();
                    if($date_promo > $now && $line_price > $row["promo_price"]) {
                        $line_price = $row["promo_price"];
                    }
                //verif si escompte produit du fournisseur pour ce client
                    $sqlx = "SELECT * FROM customer_discount WHERE customer_id = (SELECT customer_id FROM order_head WHERE id = '".$enID."') AND supplier_id = '" . $row["supplier_id"] . "' AND supplier_id <> 0 LIMIT 1";
                    $resultx = mysqli_query($dw3_conn, $sqlx);
                    $datax = mysqli_fetch_assoc($resultx);
                    if (isset($datax["escount_pourcent"]) && $datax["escount_pourcent"] != 0){
                        $discount_price = $line_price - (round($line_price*($datax["escount_pourcent"]/100),2));
                    } else {$discount_price = 0;}
                    if ($discount_price < $line_price && $discount_price > 0){
                        $line_price = $discount_price;
                    }
                $tax = "";
                //$tax_prov = "";
                if ($row['tax_fed']==true || $row['tax_prov']==true){$tax ="<span style='font-size:0.5em;'>+tx</span>";}
                //if ($row['tax_prov']==true){$tax_prov ="<span style='font-size:0.5em;'>+tvq</span>";}
                if ($APREAD_ONLY == false) { 
                    $html .= "<tr onclick=\"document.getElementById('newPRD').value='';addNEW_by_ID(" . $row['id'] . ");\">";
                    $html .= "<td style='width:32px;'><button style=\"margin:0px 2px 0px 2px;padding:3px;\"><span class=\"material-icons\">add</span></button></td>";
                } else {
                    $html .= "<tr>";
                }
                $html .= "<td style='width:50px;text-align:center;'><img src='" . $filename . "' style='height:30px;width:auto;max-width:40px;'></td>
                <td style='width:50px;font-size:14px;text-align:center;'><b>" . $row['upc'] . "</b></td>
                <td style='text-align:left;' width='*'><b>" . $row['name_fr'] ."</b></td>
                <td style='text-align:left;'><b>" . $row["qty_min_sold"] . $row["pack_desc"] . " / ". $row['tot_inv'] .  "</b></td>                
                <td style='text-align:right;'><b>" . number_format($line_price,2,',','.') ."</b><sup>$</sup>".$tax."</td>
                </tr>";
            }
            $html .= "</table>";
        } else {
            $html .= "Aucun résultat trouvé";
        }
    }
echo $html;
$dw3_conn->close();
?>

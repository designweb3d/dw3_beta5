<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$pack_id  = $_GET['PACK'];
$html = "";

    $sql2 = "SELECT * FROM product_pack WHERE id = '".$pack_id."';";
    $result2 = $dw3_conn->query($sql2);
    if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
            $html .= "<div class='divBOX'>Description FR: <input id='pack_name_fr' type='text' value='".$row2["pack_name_fr"]."'></div><br>";
            $html .= "<div class='divBOX'>Description EN: <input id='pack_name_en' type='text' value='".$row2["pack_name_en"]."'></div><br>";
            $html .= "<div class='divBOX'>Qté. min. pour ce prix: <input id='pack_qty' type='number' value='".$row2["pack_qty"]."'></div><br>";
            $html .= "<div class='divBOX'>Prix unitaire: <input id='pack_price' type='number' value='".$row2["pack_price"]."' style='background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #ddd;'></div>";
        }
    }
    
$dw3_conn->close();
header('Status: 200');
die($html);
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$product_id  = $_GET['PRD'];
if ($APREAD_ONLY == false) { 
    $html = "<table class='tblSEL'>";
} else {
    $html = "<table class='tblDATA'>";
}

    $sql2 = "SELECT * FROM product_pack WHERE product_id = '".$product_id."' ORDER BY pack_qty ASC;";
    $result2 = $dw3_conn->query($sql2);
    if ($result2->num_rows > 0) {
        $html .= "<tr><th>Description</th><th>Quantité</th><th>Prix</th></tr>";
        while($row2 = $result2->fetch_assoc()) {
            if ($APREAD_ONLY == false) { 
                $html .= "<tr onclick=\"editPACK('". $product_id . "','". $row2["id"] . "');\" style='cursor:pointer;'><td>". $row2["pack_name_fr"] . "</td><td>". $row2["pack_qty"] . "</td><td>". $row2["pack_price"] . "$</td></tr>";		
            } else {
                $html .= "<tr><td>". $row2["pack_name_fr"] . "</td><td>". $row2["pack_qty"] . "</td><td>". $row2["pack_price"] . "$</td></tr>";		
            }
        }
    } else {
        $html .= "<tr><td colspan='3'>Aucune liste de prix de définit.</td></tr>";
    }
        $html .= "<tr><th colspan='3'></th></tr>";
$html .= "</table>";
$dw3_conn->close();
header('Status: 200');
die($html);
?>

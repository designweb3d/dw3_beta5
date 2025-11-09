<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php';
$head_id = $_GET['ID']??NULL; 
$sql = "SELECT A.product_id AS product_id , B.name_fr AS name_fr, B.ship_type AS ship_type , A.qty_order AS qty_order, A.qty_shipped AS qty_shipped 
FROM order_line A LEFT JOIN (SELECT id, name_fr, ship_type FROM product) B ON B.id = A.product_id 
WHERE A.head_id = '" . $head_id . "' ORDER BY B.name_fr ASC";
    $result = $dw3_conn->query($sql);
    echo "<div>Commande #" . $head_id . "</div>";
    if ($result->num_rows > 0) {
        echo "<table class='tblDATA'><tr><th>Item</th><th>Commandé</th><th>Expédié</th></tr>";
        while($row = $result->fetch_assoc()) {
            if ($row["ship_type"] == "CARRIER" || $row["ship_type"] == "INTERNAL") {
                $shipped_txt = "<b>".floor($row["qty_shipped"])."</b>";
            } else {
                $shipped_txt = "<span style='font-size:0.8em;'>N/A</span>";
            }
            echo "<tr><td>" . $row["name_fr"] . "</td><td style='text-align:center;'>". floor($row["qty_order"]) . "</td><td style='text-align:center;'>". $shipped_txt . "</td></tr>" ;					
        }
        echo "</table>";
    } else {
        echo "<h3>La commande n'a pas été complétée.</h3>";
    }

$dw3_conn->close();
?>
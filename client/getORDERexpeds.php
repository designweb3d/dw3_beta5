<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php';
$head_id = $_GET['ID']??NULL; 
$sql = "SELECT A.*
FROM shipment_head A 
LEFT JOIN (SELECT id FROM order_head) B ON B.id = A.order_id 
WHERE A.order_id = '" . $head_id . "' ORDER BY A.date_delivery DESC";
    $result = $dw3_conn->query($sql);
    echo "<div>Commande #" . $head_id . "</div>";
    if ($result->num_rows > 0) {
        echo "<table class='tblDATA'><tr><th>Date</th><th>Status</th><th>Tracking#</th></tr>";
        while($row = $result->fetch_assoc()) {
            if ($row["date_delivery"] == "0000-00-00 00:00:00"){
                $date_deliv = substr($row["date_estimated"], 0, 10);
            } else {
                $date_deliv = substr($row["date_delivery"], 0, 10);
            }
            if ($row["stat"] == "0") { $stat = "<b style='font-size:0.8em;background-color:black;padding:2px 4px; border-radius:10px;color:white;'>En préparation</b>"; } 
            else if ($row["stat"] == "1") { $stat = "<b style='font-size:0.8em;background-color:blue;padding:2px 4px; border-radius:10px;color:white;'>Prêt à expédier</b>"; } 
            else if ($row["stat"] == "2") { $stat = "<b style='font-size:0.8em;background-color:darkred;padding:2px 4px; border-radius:10px;color:white;'>Expédié</b>"; } 
            else if ($row["stat"] == "3") { $stat = "<b style='font-size:0.8em;background-color:orange;padding:2px 4px; border-radius:10px;color:white;'>Vers la destination</b>"; } 
            else if ($row["stat"] == "4") { $stat = "<b style='font-size:0.8em;background-color:green;padding:2px 4px; border-radius:10px;color:white;'>Livré</b>"; } 
            else if ($row["stat"] == "5") { $stat = "<b style='font-size:0.8em;background-color:gray;padding:2px 4px; border-radius:10px;color:white;'>Annulé</b>"; }
            echo "<tr><td>" . $date_deliv . "</td><td style='text-align:center;'>". $stat . "</td><td style='text-align:center;'><a href='" . $row["tracking_url"] . "' target='_blank'><span class='material-icons' style='vertical-align:middle;'>local_shipping</span></a></td></tr>" ;					
        }
        echo "</table>";
    } else {
        echo "<h3>La commande n'a pas été expédiée.</h3>";
    }

$dw3_conn->close();
?>
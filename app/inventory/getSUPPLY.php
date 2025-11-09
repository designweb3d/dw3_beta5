<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$sql = "SELECT * FROM supply ";
$result = $dw3_conn->query($sql);
echo "<table class='tblSEL' style='font-size:0.7em;'><tr><th>Nom</th><th>Type</th><th>Largeur</th><th>Hauteur</th><th>Profondeur</th><th>Poid</th></tr>";
if ($result->num_rows > 0) {		
    while($row = $result->fetch_assoc()) {
        echo "<tr onclick='modSUPPLY(".$row["id"].")'>
        <td>".$row["name_fr"]."</td>
        <td>".$row["supply_type"]."</td>
        <td>".$row["depth"]."</td>
        <td>".$row["width"]."</td>
        <td>".$row["height"]."</td>
        <td>".$row["weight"]."</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan=6>Aucun record trouvé</td></tr>";
}
echo "</table>";
$dw3_conn->close();
?>
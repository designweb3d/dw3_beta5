<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$sql = "SELECT * FROM storage ";
$result = $dw3_conn->query($sql);
echo "<table class='tblSEL' style='font-size:0.7em;'><tr><th>Adresse</th><th>Étage</th><th>Local</th><th>Allée</th><th>Étagère</th><th>Section</th></tr>";
if ($result->num_rows > 0) {		
    while($row = $result->fetch_assoc()) {
        echo "<tr onclick='modSTORAGE(".$row["id"].")'>
        <td>".$row["location_id"]."</td>
        <td>".$row["level"]."</td>
        <td>".$row["local"]."</td>
        <td>".$row["row"]."</td>
        <td>".$row["shelf"]."</td>
        <td>".$row["section"]."</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan=6>Aucun enregistrement trouvé</td></tr>";
}
echo "</table>";
$dw3_conn->close();
?>
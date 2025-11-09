<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SQ_LINE   = str_replace("'","’",$_GET['LINE_NO']);

echo "Choisir une catégorie parent:<br><table class='tblSEL'><tr><th>Catégorie</th><th>Catégorie parent</th></tr>";
echo "<tr onclick=\"addSquareCat('".$SQ_LINE."','');\"><td colspan=2><b>Catégorie principale</b></td></tr>";

$sql = "SELECT * FROM product_category ORDER BY parent_name ASC;";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
        while($row = $result->fetch_assoc()) {
            echo "<tr onclick=\"addSquareCat('".$SQ_LINE."','".$row["name_fr"]."');\"><td>".$row["name_fr"] ."</td><td>".$row["parent_name"] ."</td></tr>";
        }
    }

echo "</table>";
$dw3_conn->close();
?>
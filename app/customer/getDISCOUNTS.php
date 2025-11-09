<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$clID  = $_GET['CID'];
$sql = "SELECT A.*, IFNULL(B.company_name,'-') AS company_name FROM customer_discount A
LEFT JOIN (SELECT id AS sid, company_name FROM supplier) B ON A.supplier_id = B.sid 
WHERE customer_id='".$clID ."' ORDER BY escount_pourcent DESC";
$result = $dw3_conn->query($sql);
echo " <table class='tblSEL'>";
if ($result->num_rows > 0) {	
    //echo "<tr><th>%</th><th style='font-size:10px;'>ID Fournisseur</th><th style='font-size:10px;'>ID Produit</th><th style='font-size:10px;'>ID Catégorie</th></tr>";
    echo "<tr><th>%</th><th style='font-size:10px;'>Fournisseur</th></tr>";
    while($row = $result->fetch_assoc()) {
        //if ($row["supplier_id"] == "0"){$supplier_id = "-";} else {$supplier_id = "wtf";} 
        //if ($row["supplier_id"] == "0"){$supplier_id = "-";} else {$supplier_id = $row["supplier_id"];} 
        //if ($row["category_id"] == "0"){$category_id = "-";} else {$category_id = $row["category_id"];}
        //if ($row["product_id"] == "0"){$product_id = "-";} else {$product_id = $row["product_id"];}
        //echo "<tr onclick=\"getDISCOUNT('". $row["id"] . "','".$clID."')\"><td>"	. $row["escount_pourcent"] . "%</td><td>"	. $supplier_id . "</td><td>"	. $product_id . "</td><td>"	. $category_id . "</td></tr>";
        echo "<tr onclick=\"getDISCOUNT('". $row["id"] . "','".$clID."')\"><td>"	. $row["escount_pourcent"] . "%</td><td>"	. $row["company_name"] . "</td></tr>";
    }
} else {
    echo "<tr><td style='font-size:12px;'>Aucune escompte trouvée pour ce client</td></tr>";
}
echo " </table>";
$dw3_conn->close();
?>

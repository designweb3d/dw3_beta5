<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$discountID  = $_GET['DID'];
$clID  = $_GET['CID'];
$sql = "SELECT * FROM customer_discount WHERE id='".$discountID."' LIMIT 1";
$result = $dw3_conn->query($sql);
//echo "<option disabled>Administrateurs</option>";
if ($result->num_rows > 0) {	
    while($row = $result->fetch_assoc()) {
        echo "<div class='divBOX'>ID Fournisseur<input onclick='openSEL_SUPPLIER()' id='discount_SUPPLIER' type='text' value='"	. $row["supplier_id"] . "'></div>";
        //echo "<div class='divBOX'>ID Produit<input onclick='openSEL_PRODUCT()' id='discount_PRODUCT' type='text' value='"	. $row["product_id"] . "'></div>";
        //echo "<div class='divBOX'>ID Categorie<input onclick='openSEL_CATEGORY()' id='discount_CATEGORY' type='text' value='"	. $row["category_id"] . "'></div>";
        echo "<div class='divBOX'>% Escompte<input id='discount_POURCENT' type='text' value='"	. $row["escount_pourcent"] . "'></div>";
    }
} 
echo "<div class='dw3_form_foot'><button class='red' onclick='delDISCOUNT(".$discountID.",".$clID.")'><span class='material-icons'>cancel</span> Effacer</button> <button class='green' onclick=\"updDISCOUNT(".$discountID.",".$clID.")\"><span class='material-icons'>save</span> Enregistrer</button></div>";
$dw3_conn->close();
?>

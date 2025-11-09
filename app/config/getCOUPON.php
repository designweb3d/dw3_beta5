<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
    $sql = "SELECT * FROM coupon ORDER BY date_start DESC ";
    echo "<button onclick='newCOUPON();'><span class='material-icons'>add</span> Ajouter un nouveau coupon ou code de promotion</button>
    <table class='tblDATA' style='max-width:none;'><tr><th>Code</th><th>Commence le</th><th>Se termine le</th><th>Pourcentage*</th><th>Valeur $*</th><th>Produit associé**</th><th>Nom FR</th><th>Nom EN</th><th>Description FR</th><th>Description EN</th><th>Lien**</th><th>Image**</th><th></th></tr>";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                <td style='min-width:100px;'><input type='text' value='".$row["code"]."' onchange=\"updCOUPON('".$row["id"]."','code',this.value);\"></td>
                <td ><input type='datetime-local' value='".$row["date_start"]."' onchange=\"updCOUPON('".$row["id"]."','date_start',this.value);\"></td>
                <td ><input type='datetime-local' value='".$row["date_end"]."' onchange=\"updCOUPON('".$row["id"]."','date_end',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["pourcent_val"]."' onchange=\"updCOUPON('".$row["id"]."','pourcent_val',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["amount_val"]."' onchange=\"updCOUPON('".$row["id"]."','amount_val',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["product_id"]."' onchange=\"updCOUPON('".$row["id"]."','product_id',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["name_fr"]."' onchange=\"updCOUPON('".$row["id"]."','name_fr',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["name_en"]."' onchange=\"updCOUPON('".$row["id"]."','name_en',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["description_fr"]."' onchange=\"updCOUPON('".$row["id"]."','description_fr',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["description_en"]."' onchange=\"updCOUPON('".$row["id"]."','description_en',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["href"]."' onchange=\"updCOUPON('".$row["id"]."','href',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["img_link"]."' onchange=\"updCOUPON('".$row["id"]."','img_link',this.value);\"></td>
                <td><button style='background-color:DarkRed;padding:4px;' onclick=\"delCOUPON('".$row["id"]."');\"><span class='material-icons'>delete_forever</span></button></td>
                </tr>";
            }
        }
    echo "</table><hr>*Le coupon peut être en pourcentage ou un montant ou les deux.<br>**Champs facultatifs";
    $dw3_conn->close();
?>
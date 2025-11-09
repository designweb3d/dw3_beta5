<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
    $sql = "SELECT * FROM affiliate ORDER BY id DESC";
    echo "<button onclick='newAFFILIATE();'><span class='material-icons'>add</span> Ajouter une nouvelle affiliation</button>
    <table class='tblDATA'><tr><th>Nom FR</th><th>Nom EN</th><th>Description FR</th><th>Description EN</th><th>Lien</th><th>Image</th><th></th></tr>";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                <td style='min-width:100px;'><input type='text' value='".$row["name_fr"]."' onchange=\"updAFFILIATE('".$row["id"]."','name_fr',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["name_en"]."' onchange=\"updAFFILIATE('".$row["id"]."','name_en',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["description_fr"]."' onchange=\"updAFFILIATE('".$row["id"]."','description_fr',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["description_en"]."' onchange=\"updAFFILIATE('".$row["id"]."','description_en',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["href"]."' onchange=\"updAFFILIATE('".$row["id"]."','href',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["img_link"]."' onchange=\"updAFFILIATE('".$row["id"]."','img_link',this.value);\"></td>
                <td><button style='background-color:DarkRed;padding:4px;' onclick=\"delAFFILIATE('".$row["id"]."');\"><span class='material-icons'>delete_forever</span></button></td>
                </tr>";
            }
        }
    echo "</table>";
    $dw3_conn->close();
?>
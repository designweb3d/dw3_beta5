<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
    $sql = "SELECT * FROM realisation ORDER BY sort_number DESC";
    echo "<button onclick='newREALISATION();'><span class='material-icons'>add</span> Ajouter une nouvelle réalisation</button>
    <table class='tblDATA'>";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
/*                 echo "<tr>
                <td style='min-width:100px;'><input type='text' value='".$row["sort_number"]."' onchange=\"updREALISATION('".$row["id"]."','sort_number',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["name_fr"]."' onchange=\"updREALISATION('".$row["id"]."','name_fr',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["name_en"]."' onchange=\"updREALISATION('".$row["id"]."','name_en',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["description_fr"]."' onchange=\"updREALISATION('".$row["id"]."','description_fr',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["description_en"]."' onchange=\"updREALISATION('".$row["id"]."','description_en',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["href"]."' onchange=\"updREALISATION('".$row["id"]."','href',this.value);\"></td>
                <td style='min-width:100px;'><input type='text' value='".$row["img_link"]."' onchange=\"updREALISATION('".$row["id"]."','img_link',this.value);\"></td>
                <td><button style='background-color:DarkRed;padding:4px;' onclick=\"delREALISATION('".$row["id"]."');\"><span class='material-icons'>delete_forever</span></button></td>
                </tr>"; */
                echo "<tr>
                <td rowspan=3 style='width:50px;'><input style='text-align:center;margin:0px;' type='text' value='".$row["sort_number"]."' onchange=\"updREALISATION('".$row["id"]."','sort_number',this.value);\"><br>
                <button style='background-color:DarkRed;padding:4px;border-radius:4px;margin:7px;' onclick=\"delREALISATION('".$row["id"]."');\"><span class='material-icons'>delete_forever</span></button></td>
                <td style='padding:0px;'><input placeholder='Mois / Année' style='font-weight:bold;margin:0px;text-align:center;' type='text' value='".$row["name_fr"]."' onchange=\"updREALISATION('".$row["id"]."','name_fr',this.value);\"></td>
                <td style='padding:0px;'><input placeholder='Month / Year' style='font-weight:bold;margin:0px;text-align:center;' type='text' value='".$row["name_en"]."' onchange=\"updREALISATION('".$row["id"]."','name_en',this.value);\"></td>
                </tr><tr><td style='padding:0px;'><input placeholder='Description FR' style='font-weight:normal;margin:0px;' type='text' value='".$row["description_fr"]."' onchange=\"updREALISATION('".$row["id"]."','description_fr',this.value);\"></td>
                <td style='padding:0px;'><input placeholder='Description EN' style='font-weight:normal;margin:0px;' type='text' value='".$row["description_en"]."' onchange=\"updREALISATION('".$row["id"]."','description_en',this.value);\"></td>
                </tr><tr><td style='padding:0px;'><input placeholder='Lien / Link' style='font-weight:normal;margin:0px;' type='text' value='".$row["href"]."' onchange=\"updREALISATION('".$row["id"]."','href',this.value);\"></td>
                <td style='padding:0px;'><input placeholder='Lien / Link Image' style='font-weight:normal;margin:0px;' type='text' value='".$row["img_link"]."' onchange=\"updREALISATION('".$row["id"]."','img_link',this.value);\"></td>
                </tr>";
            }
        }
    echo "</table>";
    $dw3_conn->close();
?>
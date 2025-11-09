<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
    $sql = "SELECT * FROM faq ORDER BY sort_index ASC";
    echo "<button onclick='newFAQ();'><span class='material-icons'>add</span> Ajouter une nouvelle question/réponse</button>
    <table class='tblDATA'><tr><th>Ordre</th><th>Question FR</th><th>Question EN</th><th></th></tr>";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                <td style='width:50px;'><input style='background: #ddd;padding: 5px;text-align:center;' type='text' value='".$row["sort_index"]."' onchange=\"updFAQ('".$row["id"]."','sort_index',this.value);\"></td>
                <td width='50%'><input type='text' value='".$row["q_fr"]."' onchange=\"updFAQ('".$row["id"]."','q_fr',this.value);\"></td>
                <td width='50%'><input type='text' value='".$row["q_en"]."' onchange=\"updFAQ('".$row["id"]."','q_en',this.value);\"></td>
                <td rowspan='2' style='width:30px;'><button class='red' style='padding:4px;' onclick=\"delFAQ('".$row["id"]."');\"><span class='material-icons'>delete_forever</span></button></td></tr>
                <tr><td colspan='3'><textarea style='height:75px;' onchange=\"updFAQ('".$row["id"]."','r_fr',this.value);\">".$row["r_fr"]."</textarea>
                <br><textarea style='height:75px;' onchange=\"updFAQ('".$row["id"]."','r_en',this.value);\">".$row["r_en"]."</textarea></td>
                </tr>";
            }
        }
    echo "</table>";
    $dw3_conn->close();
?>
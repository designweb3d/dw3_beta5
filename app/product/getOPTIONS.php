<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$product_id  = $_GET['PRD'];
$html = "<table class='tblSEL'>";

    $sql2 = "SELECT * FROM product_option WHERE product_id = '".$product_id."' ORDER BY name_fr ASC;";
    $result2 = $dw3_conn->query($sql2);
    if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
            $html .= "<tr><th style='text-align:left;cursor:pointer;' onclick=\"editOPTION('". $product_id . "','". $row2["id"] . "');\">". $row2["name_fr"] . " <span class='material-icons'>edit</span></th><th></th><th style='text-align:right;'><button onclick=\"addOPTION_LINE('". $product_id . "','". $row2["id"] . "')\" class='blue'><span class='material-icons'>add</span> Ajouter une ligne d'option</button></th></tr>";		
                $sql3 = "SELECT * FROM product_option_line WHERE option_id = '".$row2["id"]."' ORDER BY amount ASC;";
                $result3 = $dw3_conn->query($sql3);
                if ($result3->num_rows > 0) {
                    while($row3 = $result3->fetch_assoc()) {
                        if ($row3["default_selection"] == "1"){
                            $is_dft = "<span class='material-icons'>star</span>";
                        } else {
                            $is_dft = "";
                        }
                        $html .= "<tr onclick=\"editOPTION_LINE('". $product_id . "','". $row3["id"] . "');\"><td>". $row3["name_fr"] . "</td><td style='width:24px;'>".$is_dft."</td><td style='text-align:right;'>+". $row3["amount"] . "$</td></tr>";		
                    }
                }
        }
    }
$html .= "<tr><th colspan='3'></th></tr>";
$html .= "</table>";
$dw3_conn->close();
header('Status: 200');
die($html);
?>

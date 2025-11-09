<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$line_id  = $_GET['LNG'];
$html = "";

    $sql2 = "SELECT * FROM product_option_line WHERE id = '".$line_id."';";
    $result2 = $dw3_conn->query($sql2);
    if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
            if ($row2["default_selection"] == "1"){
                $is_dft = " checked";
            } else {
                $is_dft = "";
            }

            $html .= "<h3>Modifier la ligne d'option</h3><div class='divBOX'>Titre français: <input id='opt_name_fr' style='width:190px;float:right;' type='text' value='".$row2["name_fr"]."'></div>";
            $html .= "<div class='divBOX'>Titre anglais: <input id='opt_name_en' style='width:190px;float:right;' type='text' value='".$row2["name_en"]."'></div><br>";
            $html .= "<div class='divBOX'>Montant ajouté au produit: <input id='opt_amount' style='width:100px;float:right;' type='number' value='".$row2["amount"]."'></div>";
            $html .= "<div class='divBOX' style='display:none;'>Litres ajoutés: <input style='width:100px;float:right;' id='opt_liter' type='number' value='".$row2["liter"]."'></div>";
            $html .= "<div class='divBOX'>KG ajoutés: <input style='width:100px;float:right;' id='opt_kg' type='number' value='".$row2["kg"]."'></div>";
            $html .= "<div class='divBOX'>Hauteur ajoutée: <input style='width:100px;float:right;' id='opt_height' type='number' value='".$row2["height"]."'></div>";
            $html .= "<div class='divBOX'>Largeur ajoutée: <input style='width:100px;float:right;' id='opt_width' type='number' value='".$row2["width"]."'></div>";
            $html .= "<div class='divBOX'>Profondeur ajoutée: <input style='width:100px;float:right;' id='opt_depth' type='number' value='".$row2["depth"]."'></div>";
            $html .= "<div class='divBOX' style='padding:10px 3px;'><label style='padding-top:0px;' for='opt_dft'>Option par défaut:</label> <input id='opt_dft' type='checkbox' ".$is_dft." style='float:right;'></div><br><br>";
        }
    }
    
$dw3_conn->close();
header('Status: 200');
die($html);
?>

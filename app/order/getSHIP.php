<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$head_id  = trim($_GET['enID']);

//data from head
$sql = "SELECT * FROM order_head WHERE id = '" . $head_id . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$transport = round($data['transport'],2);
$ship_type = $data['ship_type'];
$ship_code = $data['ship_code'];
$location_id = $data['location_id'];
$stat = $data['stat'];
$weight = $data['weight'];
$length = $data['length'];
$width = $data['width'];
$height = $data['height'];
$size = round(($data['height']*$data['width']*$data['length']),2);
//$sh_so = $data['sh_so'];
//$sh_pa18 = $data['sh_pa18'];
$sh_drop = $data['sh_drop'];
$shipment_id = $data['shipment_id'];
$tracking_number = $data['tracking_number'];;
$tracking_url = $data['tracking_url'];;
$label_link = $data['label_link'];
$notif_sh = $data['notif_shipment'];
$notif_ex = $data['notif_exception'];
$notif_de = $data['notif_delivery'];
$name = dw3_decrypt($data['name']);
$company = $data['company'];
$eml = dw3_decrypt($data['eml']);
$tel = dw3_decrypt($data['tel']);
$adr1 = dw3_decrypt($data['adr1_sh']);
$adr2 = dw3_decrypt($data['adr2_sh']);
$city = $data['city_sh'];
$province = $data['province_sh'];
$country = $data['country_sh'];
$cp = $data['postal_code_sh'];

//data from lines
$sql = "SELECT IFNULL(SUM(B.kg*(A.qty_order)),0) as total_weight,IFNULL(SUM((B.height*B.width*B.depth)*(A.qty_order)),0) as total_size
FROM order_line A LEFT JOIN (SELECT * FROM product WHERE ship_type= 'CARRIER') B ON A.product_id = B.id
WHERE head_id = '" . $head_id . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$box_weight = $data['total_weight'];
$total_size = $data['total_size'];

/* if (floatval($weight)==0){
    $weight = $total_weight;
	$sql = "UPDATE order_head SET weight = '" . $weight . "' WHERE id='".$head_id."';";
    $dw3_conn->query($sql);
} */
if (floatval($size)==0){$size = $total_size;}

//find appropriate box
$sql = "SELECT *, ROUND((depth*width*height),2) as size FROM supply WHERE supply_type = 'BOX' ORDER BY size ASC";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($size <= $row["size"]){
            $selected_box_id = $row["id"];
            $selected_box = $row["name_fr"];
            $box_width = $row["width"];
            $box_height = $row["height"];
            $box_length = $row["depth"];
            $box_weight = $box_weight+$row['weight'];
            $total_size = $row["size"];
            break;
        }
    }
}

/* $sql = "UPDATE order_head SET width = '" . $width . "',length = '" . $length . "',height = '" . $height . "' WHERE id='".$head_id."';";
$dw3_conn->query($sql); */

$ship_name = "Non déterminé";
$ship_API = "Non déterminé";
if($ship_type == "PICKUP"){$ship_name = "Pickup";}
if($ship_type == "DOM.RP"){$ship_name = "Poste Canada Régulier";$ship_API = "Poste Canada";}
if($ship_type == "DOM.EP"){$ship_name = "Poste Canada Accéléré";$ship_API = "Poste Canada";}
if($ship_type == "DOM.XP"){$ship_name = "Poste Canada Express";$ship_API = "Poste Canada";}
if($ship_type == "ICS"){$ship_name = "ICS Courrier";$ship_API = "Montreal Dropship";}
if($ship_type == "DICOM"){$ship_name = "Dicom (GLS)";$ship_API = "Montreal Dropship";}
if($ship_type == "NATIONEX"){$ship_name = "Nationex";$ship_API = "Montreal Dropship";}
if($ship_type == "PUROLATOR"){$ship_name = "Purolator";$ship_API = "Montreal Dropship";}
if($ship_type == "UPS"){$ship_name = "UPS";$ship_API = "Montreal Dropship";}
if($ship_type == "POSTE"){$ship_name = "Poste Canada";$ship_API = "Montreal Dropship";}

echo "<div id='divSHIP_HEADER' style='font-weight:bold;padding:10px;background: rgba(100, 100, 100, 0.7);cursor:move;width:100%;text-align:left;'>
    Expédition de la commande #".$head_id."
    <button onclick='closeSHIP();' class='dw3_form_close' style='margin:5px;'><span class='material-icons'>close</span></button>
    </div>";
echo "<div style='position:absolute;top:48px;left:0px;width:100%;bottom:0px;overflow-x:hidden;overflow-y:auto;'>";

    echo "<div style='font-size:0.7em;'>Vérifiez si toutes les informations sont exactes avant de faire une demande d'expédition.</div>
        <br>";
    if ($shipment_id == ""){
        echo "<button id='updShipmentbtn' disabled onclick='updSHIP(".$head_id.");'><span class='material-icons'>save</span> Enregistrer les modifications</button>";
        if ($CIE_TRANSPORT == "INTERNAL") {
            echo "<button id='createShipmentbtn' onclick=\"getShipSlip(".$head_id.");\"><span class='material-icons'>local_shipping</span> Feuillet d'expédition </button>";
        } else {
            echo "<button id='createShipmentbtn' onclick=\"createShipment(".$head_id.",'".$ship_type."');\"><span class='material-icons'>local_shipping</span> Demande d'expédition ".$ship_API."</button>";
            echo "<button id='quoteShipmentbtn' onclick=\"getQuote('".$head_id."','".$transport."');\"><span class='material-icons'>paid</span> Recalculer montant transport </button>";
        }
    } else{
        if ($ship_API == "Poste Canada"){
            echo "<button onclick='getTracking(".$head_id.");'><span class='material-icons'>departure_board</span> Suivi d'expédition </button>";
        }else if ($ship_API == "Montreal Dropship"){
            echo "<button onclick='getShipingStatus(".$head_id.");'><span class='material-icons'>departure_board</span> Suivi d'expédition </button>";
            echo "<button onclick=\"window.open('https://client.livraisonsarabais.com/ship/pickup','_blank')\"><span class='material-icons'>open_in_new</span> Demande de cueillette </button>";
        }
        if ($ship_API == "Poste Canada"){
            echo "<button onclick=\"delShipment(".$head_id.");\"><span class='material-icons'>remove_road</span> Annuler l'expédition </button>";
        }else if ($ship_API == "Montreal Dropship"){
            echo "<button onclick=\"delShipment2(".$head_id.");\"><span class='material-icons'>remove_road</span> Annuler l'expédition </button>";
        }
    }
    echo "<br><div class='divBOX' style='max-width:none;'>Expédier de:
        <select id='shLOC' onchange='disableExped();'>";
        $sql = "SELECT * FROM location WHERE stat = '0' ORDER BY name ASC";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='".$row["id"]."'"; if ($row["id"]==$location_id){ echo " selected"; } echo ">".$row["name"]." ".$row["adr1"]." ".$row["city"]." ".$row["postal_code"]."</option>";
            }
        } 
    echo "</select><span style='font-size:0.6em;font-weight:normal;margin:5px 5px -5px 5px;'>Le montant de transport peut différer si une location d'expédition différente est choisie.</span></div>";         
    echo "<hr><div class='divBOX'>Transporteur:
            <input disabled type='text' style='width:40%;float:right;' value='" . $ship_name . "'>
        </div>";
    echo "<div class='divBOX'>Code de service:
            <input disabled type='text' style='width:40%;float:right;' value='" . $ship_code . "'>
        </div>";
    echo "<div class='divBOX'>#Expédition:
        <input id='shID' disabled type='text' value='" . $shipment_id . "'>
    </div>"; 
    echo "<div class='divBOX'>Numéro de tracking: <input disabled type='text' value='" . $tracking_number . "'></div>";
    echo "<div class='divBOX'>Lien de tracking: <div style='display:inline-block;max-width:320px;margin:0px 5px;line-height:1em;font-size:0.7em;word-break: break-all;'><a href='" . $tracking_url . "' target='_blank'>" . $tracking_url . "</a></div></div>";
    echo "<div class='divBOX'>Lien de l'étiquette: <div style='display:inline-block;max-width:320px;margin:0px 5px;line-height:1em;font-size:0.7em;word-break: break-all;'><a href='" . $label_link . "' target='_blank'>" . $label_link . "</a></div></div>";
    echo "<div class='divBOX'>Montant du transport:<input"; if ($stat != "0"){echo " disabled";} echo " id='shAMOUNT' style='width:30%;float:right;' type='text' oninput='disableExped();' value='" . $transport . "'>
    <br><span style='font-size:0.6em;font-weight:normal;margin:5px 5px -5px 5px;'>Le montant du transport chargé au client peut être différent de celui qui vous sera chargé lors de la demande d'expédition</span></div>";

    echo "<hr><div class='divBOX'>Boite calculée selon volume:
    <select id='shBOX' onchange='getSHIP_BOX()'>";
        $sql = "SELECT * FROM supply WHERE supply_type = 'BOX' ORDER BY width ASC";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='".$row["id"]."'"; if ($row["id"]==$selected_box_id){ echo " selected"; } echo ">".$row["name_fr"]." (".round($row["height"])."x".round($row["width"])."x".round($row["depth"]).")</option>";
            }
        } 
            echo "</select></div><h4>Poid et dimensions suggérés selon la boite sélectionnée</h4>";
            echo "<div class='divBOX'>Poid en KG:<input disabled id='boxWEIGHT' style='width:30%;float:right;' type='text' value='" . round($box_weight,2) . "'></div>";
            echo "<div class='divBOX'>Largeur en CM:<input disabled id='boxLENGTH' style='width:30%;float:right;' type='text' value='" . round($box_length) . "'></div>";
            echo "<div class='divBOX'>Hauteur en CM:<input disabled id='boxHEIGHT' style='width:30%;float:right;' type='text' value='" . round($box_height) . "'></div>";
            echo "<div class='divBOX'>Profondeur en CM:<input disabled id='boxWIDTH' style='width:30%;float:right;' type='text' value='" . round($box_width) . "'></div>";
            echo "<br>Dimensions totales: <span id='span_box_total'> ".$total_size."</span> cm<sup>2</sup> <br><button onclick='applyBoxToOrder(".$head_id.")'><span class='material-icons'>arrow_downward</span> Appliquer ces mesures à la commande</button>";
    echo "<hr><h4>Poid et dimensions actuellements inscrits dans la commande</h4><div class='divBOX'>Poid en KG:<input id='shWEIGHT' style='width:30%;float:right;' oninput='disableExped();' type='text' value='" . round($weight,2) . "'></div>";
    echo "<div class='divBOX'>Largeur en CM:<input oninput='disableExped();' id='shLENGTH' style='width:30%;float:right;' type='text' value='" . round($length) . "'></div>";
    echo "<div class='divBOX'>Hauteur en CM:<input oninput='disableExped();' id='shHEIGHT' style='width:30%;float:right;' type='text' value='" . round($height) . "'></div>";
    echo "<div class='divBOX'>Profondeur en CM:<input oninput='disableExped();' id='shWIDTH' style='width:30%;float:right;' type='text' value='" . round($width) . "'></div>";
    echo "<div class='divBOX'>Options:<select oninput='disableExped();' style='width:60%;float:right;' id='shDROP'><option disabled>Choisir une option</option>
                                        <option value='SO' "; if ($sh_drop == "SO"){echo "selected";} echo">Signature requise</option>
                                        <option value='LAD' "; if ($sh_drop == "LAD"){echo "selected";} echo">Laisser à la porte</option>
                                    </select></div>";
    echo "<div class='divBOX' style='display:none;'>Notifications:<br>
                        <input id='shNOTIF_SHIP' type='checkbox' "; if ($notif_sh == true){echo "checked";} echo"><label for='shNOTIF_SHIP'> En livraison</label><br>
                        <input id='shNOTIF_EXCEPT' type='checkbox' "; if ($notif_ex == true){echo "checked";} echo"><label for='shNOTIF_EXCEPT'> Exception</label><br>
                        <input id='shNOTIF_DELIV' type='checkbox' "; if ($notif_de == true){echo "checked";} echo"><label for='shNOTIF_DELIV'> Livré</label></div>";

    echo "<hr><div class='divBOX'>Nom:<input oninput='disableExped();' id='shNAME' type='text' value='" . $name . "'></div>";
    echo "<div class='divBOX'>Compagnie:<input oninput='disableExped();' id='shCOMPANY' type='text' value='" . $company . "'></div>";
    echo "<div class='divBOX'>Adresse ligne 1:<input oninput='disableExped();' id='shADR1' type='text' value='" . $adr1 . "'></div>";
    echo "<div class='divBOX'>Adresse ligne 2:<input oninput='disableExped();' id='shADR2' type='text' value='" . $adr2 . "'></div>";
    echo "<div class='divBOX'>Ville:<input oninput='disableExped();' id='shCITY' type='text' value='" . $city . "'></div>";
    echo "<div class='divBOX'>Province:<input oninput='disableExped();' id='shPROVINCE' type='text' value='" . $province . "'></div>";
    echo "<div class='divBOX'>Pays:<input oninput='disableExped();' id='shCOUNTRY' type='text' value='" . $country . "'></div>";
    if ($cp == ""){
        echo "<div class='divBOX'>Code Postal:<input style='box-shadow:0px 0px 4px 1px red;' oninput='disableExped();' id='shCP' type='text' value='" . $cp . "'></div>";
    } else {
        echo "<div class='divBOX'>Code Postal:<input oninput='disableExped();' id='shCP' type='text' value='" . $cp . "'></div>";
    }
    echo "<div class='divBOX'>Courriel:<input oninput='disableExped();' id='shEML' type='text' value='" . $eml . "'></div>";
    if ($tel == ""){
        echo "<div class='divBOX'>Téléphone:<input style='box-shadow:0px 0px 4px 1px red;' oninput='disableExped();' id='shTEL' type='text' value='" . $tel . "'></div>";
    } else {
        echo "<div class='divBOX'>Téléphone:<input oninput='disableExped();' id='shTEL' type='text' value='" . $tel . "'></div>";
    }

    //echo "<div class='divBOX'>Adresse:<input id='shADR' type='text' value='" . $adr . "'></div>";

echo "</div>";
$dw3_conn->close();
?>
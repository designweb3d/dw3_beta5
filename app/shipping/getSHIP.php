<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$head_id  = trim($_GET['shID']);

//data from shipment_head
$sqls = "SELECT * FROM shipment_head WHERE id = '" . $head_id . "' LIMIT 1";
$results = mysqli_query($dw3_conn, $sqls);
$datas = mysqli_fetch_assoc($results);
$order_id = $datas['order_id'];
$shipment_id = $datas['shipment_id'];
$tracking_number = $datas['tracking_number'];
$tracking_url = $datas['tracking_url'];
$label_link = $datas['label_link'];
$stat = $datas['stat'];
if (floor($datas['weight']) == $datas['weight']) { $datas["weight"] = number_format($datas["weight"], 0, '.', ''); } else {$datas["weight"] = number_format($datas["weight"], 2, '.', '');}
$weight = $datas['weight'];
if (floor($datas['length']) == $datas['length']) { $datas["length"] = number_format($datas["length"], 0, '.', ''); } else {$datas["length"] = number_format($datas["length"], 2, '.', '');}
$length = $datas['length'];
if (floor($datas['width']) == $datas['width']) { $datas["width"] = number_format($datas["width"], 0, '.', ''); } else {$datas["width"] = number_format($datas["width"], 2, '.', '');}
$width = $datas['width'];
if (floor($datas['height']) == $datas['height']) { $datas["height"] = number_format($datas["height"], 0, '.', ''); } else {$datas["height"] = number_format($datas["height"], 2, '.', '');}
$height = $datas['height'];
$size = $datas['height']*$datas['width']*$datas['length'];
$transport_price = round($datas['transport_price'],2);
$ship_type = $datas['ship_type'];
$ship_code = $datas['ship_code'];

//data from order_head
$sql = "SELECT * FROM order_head WHERE id = '" . $order_id . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
/* $transport = round($data['transport'],2);
$ship_type = $data['ship_type'];
$ship_code = $data['ship_code']; */
$location_id = $data['location_id'];
//$stat = $data['stat'];
/* $weight = $data['weight'];
$length = $data['length'];
$width = $data['width'];
$height = $data['height'];
$size = round(($data['height']*$data['width']*$data['length']),2); */
//$sh_so = $data['sh_so'];
//$sh_pa18 = $data['sh_pa18'];
$sh_drop = $data['sh_drop'];
/* $shipment_id = $data['shipment_id'];
$tracking_number = $data['tracking_number'];
$tracking_url = $data['tracking_url'];
$label_link = $data['label_link']; */
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
$sql = "SELECT IFNULL(SUM(B.kg*(C.qty_shipped)),0) as total_weight,
                IFNULL(SUM((B.height*B.width*B.depth)*(C.qty_shipped)),0) as total_size,
                SUM(A.qty_shipped) as total_shipped
FROM order_line A 
LEFT JOIN (SELECT * FROM product WHERE ship_type= 'CARRIER' OR ship_type= 'INTERNAL') B ON A.product_id = B.id
LEFT JOIN (select id, line_id, qty_shipped FROM shipment_line) C ON A.id = C.line_id 
WHERE head_id = '" . $order_id . "' 
AND A.id IN (SELECT line_id FROM shipment_line WHERE head_id = '" . $head_id . "');";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
if (floor($data['total_weight']) == $data['total_weight']) { $data["total_weight"] = number_format($data["total_weight"], 0, '.', ''); } else {$data["total_weight"] = number_format($data["total_weight"], 2, '.', '');}
$sh_weight = $data['total_weight'];
if (floor($data['total_size']) == $data['total_size']) { $data["total_size"] = number_format($data["total_size"], 0, '.', ''); } else {$data["total_size"] = number_format($data["total_size"], 2, '.', '');}
$sh_size = $data['total_size'];
$box_weight = $data['total_weight'];
$total_size = $data['total_size'];
if (floor($data['total_shipped']) == $data['total_shipped']) { $data["total_shipped"] = number_format($data["total_shipped"], 0, '.', ''); } else {$data["total_shipped"] = number_format($data["total_shipped"], 2, '.', '');}
$total_shipped = $data['total_shipped'];

if (floatval($size)==0){$size = $total_size;}

//find appropriate box
$sql = "SELECT *, (depth*width*height) as size FROM supply WHERE supply_type = 'BOX' ORDER BY size ASC";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($size <= $row["size"]){
            $selected_box_id = $row["id"];
            $selected_box = $row["name_fr"];
            if (floor($row['weight']) == $row['weight']) { $row["weight"] = number_format($row["weight"], 0, '.', ''); } else {$row["weight"] = number_format($row["weight"], 2, '.', '');}
            if (floor($row['width']) == $row['width']) { $row["width"] = number_format($row["width"], 0, '.', ''); } else {$row["width"] = number_format($row["width"], 2, '.', '');}
            if (floor($row['height']) == $row['height']) { $row["height"] = number_format($row["height"], 0, '.', ''); } else {$row["height"] = number_format($row["height"], 2, '.', '');}
            if (floor($row['depth']) == $row['depth']) { $row["depth"] = number_format($row["depth"], 0, '.', ''); } else {$row["depth"] = number_format($row["depth"], 2, '.', '');}
            if (floor($row['size']) == $row['size']) { $row["size"] = number_format($row["size"], 0, '.', ''); } else {$row["size"] = number_format($row["size"], 2, '.', '');}
            $box_width = $row["width"];
            $box_height = $row["height"];
            $box_length = $row["depth"];
            $box_weight = $box_weight+$row['weight'];
            $total_size = $row["size"];
            break;
        }
    }
}

$ship_name = "Non déterminé";
$ship_API = "Non déterminé";
if($ship_type == "INTERNAL"){$ship_name = "Transport interne";$ship_API = "Transport interne";}
if($ship_type == "PICKUP"){$ship_name = "Pickup";$ship_API = "Pickup";}
if($ship_type == "DOM.RP"){$ship_name = "Poste Canada Régulier";$ship_API = "Poste Canada";}
if($ship_type == "DOM.EP"){$ship_name = "Poste Canada Accéléré";$ship_API = "Poste Canada";}
if($ship_type == "DOM.XP"){$ship_name = "Poste Canada Express";$ship_API = "Poste Canada";}
if($ship_type == "ICS"){$ship_name = "ICS Courrier";$ship_API = "Montreal Dropship";}
if($ship_type == "DICOM"){$ship_name = "Dicom (GLS)";$ship_API = "Montreal Dropship";}
if($ship_type == "NATIONEX"){$ship_name = "Nationex";$ship_API = "Montreal Dropship";}
if($ship_type == "PUROLATOR"){$ship_name = "Purolator";$ship_API = "Montreal Dropship";}
if($ship_type == "UPS"){$ship_name = "UPS";$ship_API = "Montreal Dropship";}
if($ship_type == "POSTE"){$ship_name = "Poste Canada";$ship_API = "Montreal Dropship";}

echo "<div id='divSHIP_HEADER' class='dw3_form_head'><h3>Expédition commande #".$order_id."</h3>
    <button onclick='infoSHIP();' class='dw3_form_close' style='margin:5px;right:auto;left:0px;'><span class='material-icons'>info</span></button>
    <button onclick='closeSHIP();' class='dw3_form_close' style='margin:5px;'><span class='material-icons'>close</span></button>
    </div>";
echo "<div class='dw3_form_data'>";

//EXPÉDITIONS SUPPLÉMENTAIRES
if ($total_shipped > 0){
    echo "<div class='divBOX' style='background-color:var(--dw3_alert_background);border:1px solid var(--dw3_alert_border);color:var(--dw3_alert_text);'>
        <span class='material-icons' style='vertical-align:middle;color:var(--dw3_alert_icon);'>warning</span>
        <strong>Attention:</strong> Des expéditions partielles ont déjà été effectuées pour cette commande. Veuillez vérifier les quantités à expédier avant de faire une nouvelle demande d'expédition.
    </div><br>";
}
echo "<div class='divBOX'>Status: ";
                    if ($stat == "0") { echo "<b style='color:black;'>En préparation</b>"; } 
                    else if ($stat == "1") { echo "<b style='color:blue;'>Prêt à expédier</b>"; } 
                    else if ($stat == "2") { echo "<b style='color:darkred;'>Expédié</b>"; } 
                    else if ($stat == "3") { echo "<b style='color:orange;'>Vers la destination</b>"; } 
                    else if ($stat == "4") { echo "<b style='color:green;'>Livré</b>"; } 
                    else if ($stat == "5") { echo "<b style='color:gray;'>Annulé</b>"; }
    echo"</div>";
//LIGNES DE COMMANDE À EXPÉDIER
echo "<h3>Articles de la commande necessitant une expédition</h3>";
echo "<div style='max-width:100%;overflow-x:auto;'><table class='tblDATA' style='width:100%;max-width:none;white-space:normal;'>
        <thead>
            <tr>
                <th style='white-space:nowrap;width:5%;'></th>
                <th style='white-space:nowrap;width:10%;'>Image</th>
                <th style='white-space:nowrap;width:45%;'>Produit</th>
                <th style='white-space:nowrap;width:10%;'>Commandé</th>
                <th style='white-space:nowrap;width:10%;'>Expédié</th>";
                 if ($stat != "4") {echo "<th style='white-space:nowrap;width:10%;'>A expédier</th>";} else {echo "<th style='white-space:nowrap;width:10%;'>Expédition</th>";}
                echo "<th style='white-space:nowrap;width:10%;'>Un.(kg)</th>
                <th style='white-space:nowrap;width:10%;'>x Qté.</th>
            </tr>
        </thead>
        <tbody>";
        $sql = "SELECT A.id as sh_line_id, A.qty_shipped as qty_to_ship, B.name_fr, B.kg, B.upc as product_upc, B.ship_type, B.url_img as url_img, C.qty_order as qty_order, C.qty_shipped as qty_shipped, C.product_id as product_id
                FROM shipment_line A
                LEFT JOIN (select id, qty_order, qty_shipped, product_id FROM order_line) C ON A.line_id = C.id 
                LEFT JOIN (select id, name_fr, kg, upc, ship_type, url_img FROM product) B ON C.product_id = B.id 
                WHERE head_id = '".$head_id."' 
                ORDER BY A.id ASC;";
                //die ($sql);
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($row["product_upc"] != ""){
                    $product_no = "UPC: ".$row["product_upc"];
                } else {
                    $product_no = "ID: ".$row["product_id"];
                }
                if ($row["url_img"] != "" && file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["product_id"] . "/" . $row["url_img"])){
                    $img = "<img style='max-width:100%;max-height:50px;' src='/fs/product/" . $row["product_id"] . "/" . $row["url_img"] . "'>";
                } else {
                    $img = "<span class='material-icons' style='font-size:48px;color:var(--dw3_icon_color);'>image_not_supported</span>";
                }
                //format data to remove decimals if not needed
                if (floor($row["kg"]) == $row["kg"]) { $row["kg"] = number_format($row["kg"], 0, '.', ''); } else {$row["kg"] = number_format($row["kg"], 2, '.', '');}
                if (floor($row["qty_order"]) == $row["qty_order"]) {
                    // If it's an integer (no decimal part), format without decimals
                    $qty_order = number_format($row["qty_order"], 0, '.', '');
                } else {
                    // If it has a decimal part, format with a reasonable number of decimals
                    // You can adjust '2' to the desired precision
                    $qty_order = number_format($row["qty_order"], 2, '.', '');
                }
                if (floor($row["qty_shipped"]) == $row["qty_shipped"]) {
                    // If it's an integer (no decimal part), format without decimals
                    $qty_shipped = number_format($row["qty_shipped"], 0, '.', '');
                } else {
                    // If it has a decimal part, format with a reasonable number of decimals
                    // You can adjust '2' to the desired precision
                    $qty_shipped = number_format($row["qty_shipped"], 2, '.', '');
                }
                $qty_to_ship = $row["qty_order"] - $row["qty_shipped"];
                if (floor($qty_to_ship) == $qty_to_ship) {
                    // If it's an integer (no decimal part), format without decimals
                    $qty_to_ship = number_format($qty_to_ship, 0, '.', '');
                } else {
                    // If it has a decimal part, format with a reasonable number of decimals
                    // You can adjust '2' to the desired precision
                    $qty_to_ship = number_format($qty_to_ship, 2, '.', '');
                }
                echo "<tr>
                        <td style='text-align:center;padding:0px 7px;'><input type='checkbox' checked onclick=\"if (this.checked) { getElementById('qty_to_ship_" . $row["sh_line_id"] . "').value = '" . $qty_to_ship . "'; } else { getElementById('qty_to_ship_" . $row["sh_line_id"] . "').value = '0'; }\" ></td>
                        <td style='text-align:center;'>" .  $img . "</td>
                        <td>" . $row["name_fr"] . "<br><span style='font-size:0.8em;color:gray;'>" . $product_no . "</span></td>
                        <td style='text-align:center;'>" . $qty_order . "</td>
                        <td style='text-align:center;'>" . $qty_shipped . "</td>";
                        if ($stat == "0"){ 
                            echo "<td style='text-align:center;'><input type='number' onchange=\"updLGN_QTY_SHIPPED(" . $head_id . "," . $row["sh_line_id"] . ", this.value)\" id='qty_to_ship_" . $row["sh_line_id"] . "' value='" .  number_format($row["qty_to_ship"], 0, '.', '') . "'></td>";
                        } else {
                            echo "<td style='text-align:center;font-weight:bold;'>" . $qty_to_ship. "</td>";
                        }
                        echo "<td style='text-align:right;'>" . $row["kg"] . "</td>
                        <td style='text-align:right;'>" .$row["kg"]*$row["qty_to_ship"] . "</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Aucun article dans cette commande</td></tr>";
        }
        echo "  </tbody> </table></div><br>";

    echo "<div style='font-size:0.7em;'>Vérifiez si toutes les informations sont exactes avant de faire une demande d'expédition.</div>
        <br>";
//FORMULAIRE D'EXPÉDITION
//BOUTONS D'ACTION SELON LE STATUT DE L'EXPÉDITION
    //STAT 0 = EN TRAITEMENT
    if ($shipment_id == "" || $stat == "0") {        
            echo "<button id='createPicklistbtn' onclick=\"getPickList(".$head_id.");\"><span class='material-icons'>print</span> Feuillet de ramassage </button>";
        if ($ship_type == "INTERNAL") {
            echo "<button id='createShipSlipbtn' onclick=\"getShipSlip(".$head_id.");\"><span class='material-icons'>print</span> Feuillet d'expédition </button>";
            if($APREAD_ONLY == false) { echo "<br><button class='blue' id='createShipmentbtn' onclick=\"updateShippingStatus(".$head_id.",'1','".$ship_type."');\"><span class='material-icons'>local_shipping</span> Prêt à expédier ".$ship_API."</button>";}
        } else {
            echo "<button id='quoteShipmentbtn' onclick=\"getQuote('".$head_id."','".$transport_price."');\"><span class='material-icons'>paid</span> Recalculer montant transport </button>";
            if($APREAD_ONLY == false) {echo "<br><button class='blue' id='createShipmentbtn' onclick=\"createShipment(".$head_id.",'".$ship_type."');\"><span class='material-icons'>local_shipping</span> Demande d'expédition ".$ship_API."</button>";}
        }        
    //STAT 1 = PRET A EXPÉDIER
    } else if ($stat == "1") {
            echo "<button id='createPicklistbtn' onclick=\"getPickList(".$head_id.");\"><span class='material-icons'>print</span> Feuillet de ramassage </button>";
        if ($ship_type == "INTERNAL") {
            echo "<button id='createShipSlipbtn' onclick=\"getShipSlip(".$head_id.");\"><span class='material-icons'>print</span> Feuillet d'expédition </button>";
            if($APREAD_ONLY == false) {echo "<br><button class='blue' id='createShipmentbtn' onclick=\"updateShippingStatus(".$head_id.",'2','".$ship_type."');\"><span class='material-icons'>local_shipping</span> Départ du centre de tri</button>";}
        } else if ($ship_API == "Poste Canada"){
            echo "<button onclick='getTracking(".$head_id.");'><span class='material-icons'>departure_board</span> Suivi d'expédition </button>";
        } else if ($ship_API == "Montreal Dropship"){
            echo "<button onclick='getShipingStatus(".$head_id.");'><span class='material-icons'>departure_board</span> Suivi d'expédition </button>";
            echo "<button onclick=\"window.open('https://client.livraisonsarabais.com/ship/pickup','_blank')\"><span class='material-icons'>open_in_new</span> Demande de cueillette </button>";
        }
        if($APREAD_ONLY == false) {echo "<br><button class='red' onclick=\"updateShippingStatus(".$head_id.",'5','".$ship_type."');\"><span class='material-icons'>delete</span> Annuler l'expédition</button>";}
    //STAT 2 = SUR LA ROUTE
    } else if ($stat == "2"){
            echo "<button id='createPicklistbtn' onclick=\"getPickList(".$head_id.");\"><span class='material-icons'>print</span> Feuillet de ramassage </button>";
        if ($ship_type == "INTERNAL") {
            echo "<button id='createShipSlipbtn' onclick=\"getShipSlip(".$head_id.");\"><span class='material-icons'>print</span> Feuillet d'expédition </button>";
            if($APREAD_ONLY == false) {echo "<br><button class='blue' id='createShipmentbtn' onclick=\"updateShippingStatus(".$head_id.",'3','".$ship_type."');\"><span class='material-icons'>local_shipping</span> Vers la destination</button>";}
        }
        if($APREAD_ONLY == false) {echo "<br><button class='red' onclick=\"updateShippingStatus(".$head_id.",'5','".$ship_type."');\"><span class='material-icons'>delete</span> Annuler l'expédition</button>";}
    //STAT 3 = VERS LA DESTINATION
    } else if ($stat == "3"){
            echo "<button id='createPicklistbtn' onclick=\"getPickList(".$head_id.");\"><span class='material-icons'>print</span> Feuillet de ramassage </button>";
        if ($ship_type == "INTERNAL") {
            echo "<button id='createShipSlipbtn' onclick=\"getShipSlip(".$head_id.");\"><span class='material-icons'>print</span> Feuillet d'expédition </button>";
            if($APREAD_ONLY == false) {echo "<br><button class='blue' id='createShipmentbtn' onclick=\"updateShippingStatus(".$head_id.",'4','".$ship_type."');\"><span class='material-icons'>local_shipping</span> Livré</button>";}
        }
        if($APREAD_ONLY == false) {echo "<br><button class='red' onclick=\"updateShippingStatus(".$head_id.",'5','".$ship_type."');\"><span class='material-icons'>delete</span> Annuler l'expédition</button>";}
    //STAT 4 = LIVRÉ
    } else if ($stat == "4"){
            echo "<button id='createPicklistbtn' onclick=\"getPickList(".$head_id.");\"><span class='material-icons'>print</span> Feuillet de ramassage </button>";
        if ($ship_type == "INTERNAL") {
            echo "<button id='createShipSlipbtn' onclick=\"getShipSlip(".$head_id.");\"><span class='material-icons'>print</span> Feuillet d'expédition </button>";
        }
    //STAT 5 = ANNULÉ
    } else if ($stat == "5"){
        if ($ship_type == "INTERNAL") {
            if($APREAD_ONLY == false) { echo "<br><button class='blue' onclick=\"updateShippingStatus(".$head_id.",'0','".$ship_type."');\"><span class='material-icons'>local_shipping</span> Replacer en traitement</button>";}
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
            <input disabled type='text' style='width:60%;float:right;' value='" . $ship_name . "'>
        </div>";
    echo "<div class='divBOX'>Code de service:
            <input disabled type='text' style='width:50%;float:right;' value='" . $ship_code . "'>
        </div>";
    echo "<div class='divBOX'>#Expédition:
        <input id='shID' disabled type='text' value='" . $shipment_id . "'>
    </div>"; 
    echo "<div class='divBOX'>Numéro de tracking: <input disabled type='text' value='" . $tracking_number . "'></div>";
    echo "<div class='divBOX'>Lien de tracking: <div style='display:inline-block;max-width:320px;margin:0px 5px;line-height:1em;font-size:0.7em;word-break: break-all;'><a href='" . $tracking_url . "' target='_blank'>" . $tracking_url . "</a></div></div>";
    echo "<div class='divBOX'>Lien de l'étiquette: <div style='display:inline-block;max-width:320px;margin:0px 5px;line-height:1em;font-size:0.7em;word-break: break-all;'><a href='" . $label_link . "' target='_blank'>" . $label_link . "</a></div></div>";
    echo "<div class='divBOX'>Montant du transport:<input id='shAMOUNT' style='width:30%;float:right;' type='text' oninput='disableExped();' value='" . $transport_price . "'>
    <br><span style='font-size:0.6em;font-weight:normal;margin:5px 5px -5px 5px;'>Le montant du transport chargé au client peut être différent de celui qui vous sera chargé lors de la demande d'expédition</span></div>";
    echo "<div class='divBOX'>Options:<select oninput='disableExped();' style='width:60%;float:right;' id='shDROP'><option disabled>Choisir une option</option>
                                        <option value='SO' "; if ($sh_drop == "SO"){echo "selected";} echo">Signature requise</option>
                                        <option value='LAD' "; if ($sh_drop == "LAD"){echo "selected";} echo">Laisser à la porte</option>
                                    </select></div>";
    echo "<div class='divBOX' style='display:none;'>Notifications:<br>
                        <input id='shNOTIF_SHIP' type='checkbox' "; if ($notif_sh == true){echo "checked";} echo"><label for='shNOTIF_SHIP'> En livraison</label><br>
                        <input id='shNOTIF_EXCEPT' type='checkbox' "; if ($notif_ex == true){echo "checked";} echo"><label for='shNOTIF_EXCEPT'> Exception</label><br>
                        <input id='shNOTIF_DELIV' type='checkbox' "; if ($notif_de == true){echo "checked";} echo"><label for='shNOTIF_DELIV'> Livré</label></div>";

//POIDS ET DIMENSIONS ACTUELS
    echo "<hr><h4>Poid et dimensions des quantités à expédier</h4>";
    echo "<div class='divBOX'>Poid en KG:<input id='calcWEIGHT' style='width:30%;float:right;' disabled type='text' value='" . $sh_weight . "'></div>";
    echo "<div class='divBOX'>Volume en CM<sup>3</sup>:<input disabled style='width:30%;float:right;' type='text' value='" . $sh_size . "'></div>";

//BOITE SUGGÉRÉE SELON LE VOLUME
    echo "<hr><div class='divBOX'>Boite calculée selon volume:
    <select id='shBOX' onchange='getSHIP_BOX()'>";
        $sql = "SELECT * FROM supply WHERE supply_type = 'BOX' ORDER BY width ASC";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if (floor($row['weight']) == $row['weight']) { $row["weight"] = number_format($row["weight"], 0, '.', ''); } else {$row["weight"] = number_format($row["weight"], 2, '.', '');}
            if (floor($row['width']) == $row['width']) { $row["width"] = number_format($row["width"], 0, '.', ''); } else {$row["width"] = number_format($row["width"], 2, '.', '');}
            if (floor($row['height']) == $row['height']) { $row["height"] = number_format($row["height"], 0, '.', ''); } else {$row["height"] = number_format($row["height"], 2, '.', '');}
            if (floor($row['depth']) == $row['depth']) { $row["depth"] = number_format($row["depth"], 0, '.', ''); } else {$row["depth"] = number_format($row["depth"], 2, '.', '');}
            echo "<option value='".$row["id"]."'"; if ($row["id"]==$selected_box_id){ echo " selected"; } echo ">".$row["name_fr"]." (".$row["height"]."x".$row["width"]."x".$row["depth"].")</option>";
            }
        } 
            echo "</select></div><h4>Poid et dimensions suggérés selon la boite sélectionnée</h4>";
//POIDS ET DIMENSIONS SUGGÉRÉS
            echo "<div class='divBOX'>Poid en KG:<input disabled id='boxWEIGHT' style='width:30%;float:right;' type='text' value='" . $box_weight . "'></div>";
            echo "<div class='divBOX'>Largeur en CM:<input disabled id='boxLENGTH' style='width:30%;float:right;' type='text' value='" . $box_length . "'></div>";
            echo "<div class='divBOX'>Hauteur en CM:<input disabled id='boxHEIGHT' style='width:30%;float:right;' type='text' value='" . $box_height . "'></div>";
            echo "<div class='divBOX'>Profondeur en CM:<input disabled id='boxWIDTH' style='width:30%;float:right;' type='text' value='" . $box_width . "'></div>";
            echo "<br>Dimensions totales: <span id='span_box_total'> ".$total_size."</span> CM<sup>3</sup> <br><button onclick='applyBoxToShipment(".$head_id.")'><span class='material-icons'>arrow_downward</span> Appliquer ces mesures à la commande</button>";
//POIDS ET DIMENSIONS INSCRITS SUR LA COMMANDE
    echo "<hr><h4>Poid et dimensions actuellements inscrits sur l'expédition</h4><div class='divBOX'>Poid en KG:<input id='shWEIGHT' style='width:30%;float:right;' oninput='disableExped();' type='text' value='" . $weight . "'></div>";
    echo "<div class='divBOX'>Largeur en CM:<input oninput='disableExped();' id='shLENGTH' style='width:30%;float:right;' type='text' value='" . $length . "'></div>";
    echo "<div class='divBOX'>Hauteur en CM:<input oninput='disableExped();' id='shHEIGHT' style='width:30%;float:right;' type='text' value='" . $height . "'></div>";
    echo "<div class='divBOX'>Profondeur en CM:<input oninput='disableExped();' id='shWIDTH' style='width:30%;float:right;' type='text' value='" . $width . "'></div>";
//EXPEDIER A
    echo "<hr><h3>Expédier à:</h3><div class='divBOX'>Nom:<input oninput='disableExped();' id='shNAME' type='text' value='" . $name . "'></div>";
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

echo "<div class='dw3_form_foot' style='height:44px;'>";
    if ($stat == "0" && $APREAD_ONLY == false){
        if ($ship_API == "Poste Canada"){
            echo "<button class='red' onclick=\"delShipment(".$head_id.");\"><span class='material-icons'>remove_road</span></button>";
        }else if ($ship_API == "Montreal Dropship"){
            echo "<button class='red' onclick=\"delShipment2(".$head_id.");\"><span class='material-icons'>remove_road</span></button>";
        }else if ($ship_API == "Transport interne" || $ship_type == ""){
            echo "<button class='red' onclick='deleteSHIP(".$head_id.");'><span class='material-icons'>remove_road</span></button>";
        }
    }
echo "<button class='grey' onclick='closeSHIP();'><span class='material-icons'>close</span> Fermer</button>";
    if($APREAD_ONLY == false) {echo "<button class='green' id='updShipmentbtn' onclick='updSHIP(".$head_id.");'><span class='material-icons'>save</span> Enregistrer</button>";}
echo "</div>";

$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$adID  = $_GET['ID'];

	$sql = "SELECT * FROM classified WHERE id = " . $adID . " LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
			echo "<div id='divEDIT_AD_HEADER' style='cursor:move;position:absolute;top:0px;right:0px;left:0px;height:40px;background:rgba(207, 205, 205, 0.9);'>
                        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>Annonce # " . $row["id"] . "</div></h3>
                         <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
                </div>
                <div style='position:absolute;top:40px;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>";
                //image 1 
                        $filename= $row["img_link"];
                        if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $USER . "/" . $filename)){
                            $filename = "/pub/img/dw3/nd.png";
                        } else {
                            if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $USER . "/" . $filename)){
                                $filename = "/pub/img/dw3/nd.png";
                            } else {
                                $filename = "/fs/customer/" . $USER . "/" . $filename;
                            }
                        }
                echo "<img id='adIMG' src='".$filename."?t=" . rand(100,100000)."' style='width:250px;height:250px;box-shadow:0px 0px 3px 1px #222;border-radius:4px;margin:5px;cursor:pointer;' onclick=\"document.getElementById('fileToUpload7').click();\">
                    <input id='adIMG_LINK' type='text' value='" . $row["img_link"] . "' style='display:none;'>";
                //image 2
                        $filename= $row["img_link2"];
                        if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $USER . "/" . $filename)){
                            $filename = "/pub/img/dw3/nd.png";
                        } else {
                            if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $USER . "/" . $filename)){
                                $filename = "/pub/img/dw3/nd.png";
                            } else {
                                $filename = "/fs/customer/" . $USER . "/" . $filename;
                            }
                        }
                echo "<img id='adIMG2' src='".$filename."?t=" . rand(100,100000)."' style='width:250px;height:250px;box-shadow:0px 0px 3px 1px #222;border-radius:4px;margin:5px;cursor:pointer;' onclick=\"document.getElementById('fileToUpload8').click();\">
                    <input id='adIMG_LINK2' type='text' value='" . $row["img_link2"] . "' style='display:none;'>";
                //image 3 
                        $filename= $row["img_link3"];
                        if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $USER . "/" . $filename)){
                            $filename = "/pub/img/dw3/nd.png";
                        } else {
                            if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $USER . "/" . $filename)){
                                $filename = "/pub/img/dw3/nd.png";
                            } else {
                                $filename = "/fs/customer/" . $USER . "/" . $filename;
                            }
                        }
                echo "<img id='adIMG3' src='".$filename."?t=" . rand(100,100000)."' style='width:250px;height:250px;box-shadow:0px 0px 3px 1px #222;border-radius:4px;margin:5px;cursor:pointer;' onclick=\"document.getElementById('fileToUpload9').click();\">
                    <br><input id='adIMG_LINK3' type='text' value='" . $row["img_link3"] . "' style='display:none;'>";
                echo "<div class='divBOX'><br><label for='adACTIVE' style='width:80%;'>Active:</label>
                        <input id='adACTIVE' type='checkbox' style='float:right;margin:5px;'"; if ($row["active"] == true){ echo " checked"; } echo ">
                    </div>
                     <div class='divBOX'>Catégorie:
                    <select id='adCAT'>";
                        $sql2 = "SELECT * FROM product_category ORDER BY name_fr";
                        $result2 = $dw3_conn->query($sql2);
                        if ($result2->num_rows > 0) {	
                            while($row2 = $result2->fetch_assoc()) {
                                if ($row2["id"] == $row["category_id"]){ $strTMP = " selected"; } else {$strTMP = ""; }
                                echo "<option value='". $row2["id"] . "' " . $strTMP . ">"	. $row2["name_fr"] . "</option>";
                            }
                        }
                    echo "</select></div>                
                    <div class='divBOX'><br>Nom français:
                        <input id='adNAME_FR' type='text' value='" . $row["name_fr"] . "'>
                    </div>				
                    <div class='divBOX'><br>Nom anglais:
                        <input id='adNAME_EN' type='text' value='" . $row["name_en"] . "'>
                    </div>				
                    <div class='divBOX'><br>Description français (HTML):
                        <textarea id='adDESC_FR' style='width:100%;' rows='4'>" . $row["description_fr"] . "</textarea>
                    </div>				
                    <div class='divBOX'><br>Description anglais (HTML):
                        <textarea id='adDESC_EN' style='width:100%;' rows='4'>" . $row["description_en"] . "</textarea>
                    </div>				
                    <div class='divBOX'><br>Quantité disponible:
                        <input id='adQTY' type='number' value='" . round($row["qty_available"]) . "' inputmode='decimal'>
                    </div>	 
                    <div class='divBOX'><br><label for='adDROP' style='width:80%;'>Stocké chez Montreal Dropship:</label>
                        <input id='adDROP' type='checkbox' style='float:right;margin:5px;'"; if ($row["drop_shipped"] == true){ echo " checked"; } echo ">
                    </div>";	 
                    echo "<div class='divBOX'><b>Type de livraison</b>:
                            <select id='adSHIP'>";
                    echo "<option "; if ($row["ship_type"] == "" ){ echo "selected "; } echo "value=''>Non applicable</option>";
                    echo "<option "; if ($row["ship_type"] == "INTERNAL"){ echo "selected "; } echo "value='INTERNAL'>Livraison interne gratuite</option>";
                    echo "<option "; if ($row["ship_type"] == "CARRIER"){ echo "selected ";  } echo "value='CARRIER'>Transporteur</option>";
                    echo "</select></div>";
                    echo "<div class='divBOX'><br>Prix (avec les taxes comprises):
                        <input id='adPRICE' type='number' value='" . number_format($row["price"], 2,'.',''). "' inputmode='decimal'>
                    </div>	 
                    <div class='divBOX'><br><label for='adTX_FED' style='width:80%;'>Taxe fédérale:</label>
                        <input id='adTX_FED' type='checkbox' style='float:right;margin:5px;'"; if ($row["tax_fed"] == true){ echo " checked"; } echo ">
                    </div>	 
                    <div class='divBOX'><br><label for='adTX_PROV' style='width:80%;'>Taxe provinciale:</label>
                        <input id='adTX_PROV' type='checkbox' style='float:right;margin:5px;'"; if ($row["tax_prov"] == true){ echo " checked"; } echo ">
                    </div>	 
                    <div class='divBOX'><br>Poid en KG (0.1 = 100g):
                        <input id='adKG' type='number' value='" . $row["kg"] . "'>
                    </div>
                    <div class='divBOX'><br>Hauteur en CM:
                        <input id='adHEIGHT' type='number' value='" . $row["height"] . "'>
                    </div>
                    <div class='divBOX'><br>Largeur en CM:
                        <input id='adWIDTH' type='number' value='" . $row["width"] . "'>
                    </div>
                    <div class='divBOX'><br>Profondeur en CM:
                        <input id='adDEPTH' type='number' value='" . $row["depth"] . "'>
                    </div>
                    <div class='divBOX'><br>Fabriquant:
                        <input id='adBRAND' type='text' value='" . $row["brand"] . "'>
                    </div>
                    <div class='divBOX'><br>Modele:
                        <input id='adMODEL' type='text' value='" . $row["model"] . "'>
                    </div>
                    <div class='divBOX'><br>Année:
                        <input id='adYEAR' type='text' value='" . $row["year_production"] . "'>
                    </div>";
                  //etat
                  echo "<div class='divBOX'><br>État du produit: <select id='adETAT'>";
                    echo "<option value = '1' "; if ($row["etat"] == "1"){echo " selected ";} echo ">Neuf</option>";
                    echo "<option value = '2' "; if ($row["etat"] == "2"){echo " selected ";} echo ">Presque neuf</option>";
                    echo "<option value = '3' "; if ($row["etat"] == "3"){echo " selected ";} echo ">Usagé</option>";
                    echo "<option value = '4' "; if ($row["etat"] == "4"){echo " selected ";} echo ">Remis à neuf</option>";
                    echo "</select></div>
                    <div class='divBOX'><br>Produits recommendés (liste de #annonces séparés par une virgule):
                        <input id='adRECOMMENDED' type='text' value='" . $row["recommended"] . "'>
                    </div>

				<br><br></div><div class='dw3_form_foot'>
                    <button class='red' onclick='deleteAD(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span></button>
                    <button class='grey' onclick='closeEDITOR();'><span class='material-icons'>cancel</span> " . $dw3_lbl["CANCEL"] . "</button>
                    <button class='green' onclick='updAD(\"" . $row["id"] . "\");'><span class='material-icons'>save</span>" . $dw3_lbl["SAVE"] . "</button>
				</div>";
		}
	}
$dw3_conn->close();
?>
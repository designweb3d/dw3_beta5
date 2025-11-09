<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$addID  = $_GET['ID'];

	$sql = "SELECT * FROM classified WHERE id = " . $addID . " LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
			echo "<div id='divEDIT_ADD_HEADER' style='cursor:move;position:absolute;top:0px;right:0px;left:0px;height:40px;background:rgba(207, 205, 205, 0.9);'>
                        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>Annonce # " . $row["id"] . "</div></h3>
                         <button style='background:#555555;top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
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
                echo "<img id='addIMG' src='".$filename."' style='width:250px;height:250px;box-shadow:0px 0px 3px 1px #222;border-radius:4px;margin:5px;cursor:pointer;' onclick=\"document.getElementById('fileToUpload7').click();\">
                    <input id='addIMG_LINK' type='text' value='" . $row["img_link"] . "' style='display:none;'>";
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
                echo "<img id='addIMG2' src='".$filename."' style='width:250px;height:250px;box-shadow:0px 0px 3px 1px #222;border-radius:4px;margin:5px;cursor:pointer;' onclick=\"document.getElementById('fileToUpload8').click();\">
                    <input id='addIMG_LINK2' type='text' value='" . $row["img_link2"] . "' style='display:none;'>";
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
                echo "<img id='addIMG3' src='".$filename."' style='width:250px;height:250px;box-shadow:0px 0px 3px 1px #222;border-radius:4px;margin:5px;cursor:pointer;' onclick=\"document.getElementById('fileToUpload9').click();\">
                    <br><input id='addIMG_LINK3' type='text' value='" . $row["img_link3"] . "' style='display:none;'>";
                echo "<div class='divBOX'><br><label for='addACTIVE' style='width:80%;'>Active:</lable>
                        <input id='addACTIVE' type='checkbox' style='float:right;margin:5px;'"; if ($row["active"] == true){ echo " checked"; } echo ">
                    </div>
                     <div class='divBOX'>Catégorie:
                    <select id='addCAT'>";
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
                        <input id='addNAME_FR' type='text' value='" . $row["name_fr"] . "'>
                    </div>				
                    <div class='divBOX'><br>Nom anglais:
                        <input id='addNAME_EN' type='text' value='" . $row["name_en"] . "'>
                    </div>				
                    <div class='divBOX'><br>Description français (HTML):
                        <textarea id='addDESC_FR' style='width:100%;' rows='4'>" . $row["description_fr"] . "</textarea>
                    </div>				
                    <div class='divBOX'><br>Description anglais (HTML):
                        <textarea id='addDESC_EN' style='width:100%;' rows='4'>" . $row["description_en"] . "</textarea>
                    </div>				
                    <div class='divBOX'><br>Quantité disponible:
                        <input id='addQTY' type='number' value='" . $row["qty_available"] . "'>
                    </div>	 
                    <div class='divBOX'><br>Prix:
                        <input id='addPRICE' type='number' value='" . $row["price"] . "'>
                    </div>	 
                    <div class='divBOX'><br><label for='addTX' style='width:80%;'>Taxable:</lable>
                        <input id='addTX' type='checkbox' style='float:right;margin:5px;'"; if ($row["taxable"] == true){ echo " checked"; } echo ">
                    </div>	 
                    <div class='divBOX'><br>Fabriquant:
                        <input id='addBRAND' type='text' value='" . $row["brand"] . "'>
                    </div>
                    <div class='divBOX'><br>Modele:
                        <input id='addMODEL' type='text' value='" . $row["model"] . "'>
                    </div>
                    <div class='divBOX'><br>Année:
                        <input id='addYEAR' type='text' value='" . $row["year_production"] . "'>
                    </div>
                    <div class='divBOX'><br>Produits recommendés (liste de #annonces séparés par une virgule):
                        <input id='addRECOMMENDED' type='text' value='" . $row["recommended"] . "'>
                    </div>

				<br><br></div><div class='dw3_form_foot'>
                    <button style='background:red;' onclick='deleteADD(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span></button>
                    <button style='background:#555555;' onclick='closeEDITOR();'><span class='material-icons'>cancel</span> " . $dw3_lbl["CANCEL"] . "</button>
                    <button onclick='updADD(\"" . $row["id"] . "\");'><span class='material-icons'>save</span>" . $dw3_lbl["SAVE"] . "</button>
				</div>";
		}
	}
$dw3_conn->close();
?>
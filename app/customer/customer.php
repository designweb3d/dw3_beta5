<?php /**
 +---------------------------------------------------------------------------------+
 | Design Web 3D Morpheus BETA                                                     |
 | Version 4                                                                       |
 |                                                                                 | 
 |  The MIT License                                                                |
 |  Copyright © 2024 Design Web 3D                                                 | 
 |                                                                                 |
 |  Permission is hereby granted, free of charge, to any person obtaining a copy   |
 |   of this software and associated documentation files (the "Software"), to deal |
 |   in the Software without restriction, including without limitation the rights  |
 |   to use, copy, modify, merge, publish, distribute, sublicense, and/or sell     |
 |   copies of the Software, and to permit persons to whom the Software is         |
 |   furnished to do so, subject to the following conditions:                      | 
 |                                                                                 |
 |   The above copyright notice and this permission notice shall be included in    | 
 |   all copies or substantial portions of the Software.                           |
 |                                                                                 | 
 |   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR    |
 |   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,      |
 |   FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE   | 
 |   AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER        |
 |   LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, | 
 |   OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN     |
 |   THE SOFTWARE.                                                                 |
 |                                                                                 |
 +---------------------------------------------------------------------------------+
 | Author: Julien Béliveau <info@dw3.ca>                                           |
 +---------------------------------------------------------------------------------+*/
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php'; 
?>
<div id='divHEAD'>
	<table style="width:100%;margin:0px;white-space:nowrap;">
		<tr style="margin:0px;padding:0px;">
			<td width="40"><button style="margin:0px 2px 0px 2px;padding:8px;font-size:0.8em;" onclick="openFILTRE();"><span class="material-icons">filter_alt</span></button></td>
			<td width="*" style="margin:0px;padding:0px;">
				<input type="search" onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" oninput="getCLIS('','',LIMIT);" placeholder="<?php echo $APNAME; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
			</td>
			<td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
				<?php if($APREAD_ONLY == false) { ?><button class='blue' style="margin:0px 2px 0px 2px;padding:8px;" onclick="openNEWCLI();"><span class="material-icons">add</span></button> <?php } ?>
				<button class='grey' style="margin:0px 2px 0px 2px;padding:8px;" onclick="openPARAM();"><span class="material-icons">settings</span></button>
			 </td>
		</tr>
	</table>
</div>
<div id='divMAIN' class='divMAIN' style="padding-top:50px;">
    <img src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>
</div>
<div id="divEDIT" class="divEDITOR">
    <div id='googleMap' style='<?php if ($CIE_GMAP_KEY==""){ echo "display:none;";} ?>width:100%;height:200px;margin-top:40px;'></div>
	<div id="divEDIT_MAIN"></div>
</div>
<div id="divDISCOUNT" class="divEDITOR" style='max-width:350px;max-height:300px;min-height:300px;height:300px;bottom:auto;'>
    <div id="divDISCOUNT_HEADER" style='vertical-align:middle;cursor:move;position:absolute;top:0px;right:0px;left:0px;height:40px;background:rgba(207, 205, 205, 0.9);'>
        <h3 style='width:100%;position:absolute;top:50%;-ms-transform:translateY(-50%);transform:translateY(-50%);'>Escompte</h3>
        <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeDISCOUNT();'><span class='material-icons'>cancel</span></button>
    </div>  
	<div id="divDISCOUNT_DATA" style='position:absolute;top:40px;bottom:0px;left:0px;right:0px;'></div>
</div>

<!-- sélection de fournisseur pour les escomptes -->
<div id="divSEL_SUPPLIER" class="divSELECT" style='min-width:330px;min-height:90%;'><input id='whySEL_SUPPLIER' type='text' value='DISCOUNT' style='display:none;'>
    <div id="divSEL_SUPPLIER_HEADER" class='dw3_form_head'><h3> Fournisseurs </h3>
        <button onclick='closeSEL_SUPPLIER();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'> 
            <div style="margin:10px;max-height:75%;">	
			<table class='tblSEL'>
			<?php
				$sql = "SELECT * FROM supplier ORDER BY company_name LIMIT 1000";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<tr onclick=\"setDISCOUNT_SUP('" . $row["id"]  . "')\"><td>". $row["id"]."</td><td>". $row["company_name"]."</td></tr>";
					}
				}
			?>
            </table></div>
    </div>
	<div class='dw3_form_foot'>
		<button class='grey' onclick="closeSEL_SUPPLIER();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>
<!-- sélection de produit pour les escomptes -->
<div id="divSEL_PRODUCT" class="divSELECT" style='min-width:330px;min-height:90%;'><input id='whySEL_PRODUCT' type='text' value='DISCOUNT' style='display:none;'>
    <div id="divSEL_PRODUCT_HEADER" class='dw3_form_head'><h3> Catégories </h3>
        <button onclick='closeSEL_PRODUCT();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
            <div style="margin:10px;max-height:75%;">	
			<table class='tblSEL'>
			<?php
				$sql = "SELECT * FROM product ORDER BY name_fr LIMIT 1000";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<tr onclick=\"setDISCOUNT_PRD('" . $row["id"]  . "')\"><td>". $row["id"]."</td><td>". $row["name_fr"]."</td></tr>";
					}
				}
			?>
            </table></div>
    </div>
	<div class='dw3_form_foot'>
		<button class='grey' onclick="closeSEL_PRODUCT();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>
<!-- sélection de catégorie pour les escomptes -->
<div id="divSEL_CATEGORY" class="divSELECT" style='min-width:330px;min-height:90%;'><input id='whySEL_CATEGORY' type='text' value='DISCOUNT' style='display:none;'>
    <div id="divSEL_CATEGORY_HEADER" class='dw3_form_head'><h3> Catégories </h3>
        <button onclick='closeSEL_CATEGORY();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
            <div style="margin:10px;max-height:75%;">	
			<table class='tblSEL'>
			<?php
				$sql = "SELECT * FROM product_category ORDER BY name_fr LIMIT 1000";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<tr onclick=\"setDISCOUNT_CAT('" . $row["id"]  . "')\"><td>". $row["id"]."</td><td>". $row["name_fr"]."</td></tr>";
					}
				}
			?>
            </table></div>
    </div>
	<div class='dw3_form_foot'>
		<button class='grey' onclick="closeSEL_CATEGORY();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<!-- éditeur d'évènements -->
<div id="divEVENT" class="divSELECT" style='min-width:330px;min-height:90%;width:800px;max-width:95%;'>
    <div id="divEVENT_HEADER" class='dw3_form_head'><h3> Évènement </h3>
        <button onclick='closeEVENT();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div id='divEVENT_MAIN'></div>
</div>

<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;">
    <div id='divPARAM_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);'>Paramètres de l'application</h2>
        <button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div>
    <div class='dw3_form_data' id="divPARAM_DATA"></div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,1));'>
        <button class='blue' onclick='resetPRM()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>restart_alt</span> Réinitialiser</button>
        <button class='grey' onclick='closeEDITOR()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Annuler</button>
        <button class='green' onclick='updPRM();' style='margin:0px 10px 0px 2px;'><span class='material-icons'>save</span> Enregistrer</button>
    </div>
</div>
<div id="divMSG"></div>
<div id="divOPT"></div>
<div id="divNEW" class="divEDITOR">
    <div id='divNEW_HEADER' class='dw3_form_head'>
        <b><?php echo $dw3_lbl["NEW_CLI"]; ?></b>
		<button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div>
	<div class='dw3_form_data'>
		<span style="color:orange;font-size:13px;position:absolute;top:0px;right:5px;"><b><sup>*Champs requis pour la création.</sup></b></span>    
		<div class='divBOX'><br>Type de facturation:
						<select name='newTYPE' id='newTYPE'>
                        <option selected value='PARTICULAR'>Particuliers</option>
                        <option value='COMPANY'>Compagnie</option>
                        <option value='RETAILER'>Détaillant / Succursale / Franchise</option>
                        <option value='INTERNAL'>Interne (table, caisse, pos..)</option>
						</select>
					</div>
		<div class="divBOX">Langue:
			<select id="newLANG">
				<option value="FR">Français</option>
				<option value="EN">Anglais</option>
			</select>
		</div>
		<div class="divBOX" style='display:none;'><?php echo $dw3_lbl["SEXE"]; ?>:
			<select name="newSEXE" id="newSEXE">
				<option value="M"><?php echo $dw3_lbl["MALE"]; ?></option>
				<option value="F"><?php echo $dw3_lbl["FEMALE"]; ?></option>
				<option selected value=""><?php echo $dw3_lbl["UNDEFINED"]; ?></option>
			</select>
		</div>
		<div class="divBOX">Associer à Stripe:
            <label class='switch'><input id='newToStripe' type='checkbox'><span class='slider round'></span></label>
		</div>
		<div class="divBOX" style='display:none;'><?php echo $dw3_lbl["PREFIX"]; ?>:
			<input placeholder="" id="newPREFIX" type="text" value="" onclick="detectCLICK(event,this);">
		</div>
		<div class="divBOX" style='display:none;'><?php echo $dw3_lbl["PRENOM"]; ?>:
			<input placeholder="" id="newPRENOM" type="text" value="" onclick="detectCLICK(event,this);">
		</div>
		<div class="divBOX" style='display:none;'><?php echo $dw3_lbl["PRENOM2"]; ?>:
			<input placeholder="" id="newPRENOM2" type="text" value="" onclick="detectCLICK(event,this);">
		</div>
		<div class="divBOX">Nom du contact</b>:
			<input placeholder="" id="newNOM" type="text" value="" onclick="detectCLICK(event,this);" style="box-shadow:2px 5px 7px orange;">
		</div>
		<div class="divBOX">Compagnie</b>:
			<input placeholder="" id="newCIE" type="text" value="" onclick="detectCLICK(event,this);">
		</div>
		<div class="divBOX" style='display:none;'><?php echo $dw3_lbl["SUFFIX"]; ?>:
			<input placeholder="" id="newSUFFIX" type="text" value="" onclick="detectCLICK(event,this);">
		</div>
		<div class="divBOX"><?php echo $dw3_lbl["TEL1"]; ?>:
			<input placeholder="" id="newTEL1" type="text" value="" onclick="detectCLICK(event,this);" style="float:right;">
		</div>	
		<div class="divBOX"><?php echo $dw3_lbl["EML1"]; ?>:
			<input placeholder="@" id="newEML1" type="text" value="" onclick="detectCLICK(event,this);">
		</div>	
		<div class="divBOX">Site Web:
			<input placeholder="https://" id="newWEB" type="text" value="" onclick="detectCLICK(event,this);">
		</div>	
		<div class='divBOX'><?php echo $dw3_lbl["ADR1"]; ?>:
			<input placeholder="" id='newADR1' type='text' value="" onclick='detectCLICK(event,this);'>
		</div>
		<div class='divBOX'><?php echo $dw3_lbl["ADR2"]; ?>:
			<input placeholder="" id='newADR2' type='text' value="" onclick='detectCLICK(event,this);'>
		</div>
		<div class='divBOX'><?php echo $dw3_lbl["VILLE"]; ?>:
<!-- 			<select id="newVILLE">
			</select>	 -->
            <input placeholder="" id='newVILLE' type='text' value="" onclick='detectCLICK(event,this);'>
		</div>
		<div class='divBOX'><?php echo $dw3_lbl["PROV"]; ?>:
			<!-- <select id="newPROV" onchange="getLOC(this.value,'City','newVILLE');"> -->
            <!-- <input placeholder="" id='newPROV' type='text' value="Québec" onclick='detectCLICK(event,this);'> -->
            <select id="newPROV">
				<option value="AB">Alberta</option>
				<option value="BC">Colombie-Britannique</option>
				<option value="PE">Île-du-Prince-Édouard.</option>
				<option value="MB">Manitoba</option>
				<option value="NB">Nouveau-Brunswick</option>
				<option value="NS">Nouvelle-Écosse</option>
				<option value="NU">Nunavut</option>
				<option value="ON">Ontario</option>
				<option selected value="QC">Québec</option>
				<option value="SK">Saskatchewan</option>
				<option value="NL">Terre-Neuve-et-Labrador</option>
				<option value="NT">Territoires du Nord-Ouest</option>
				<option value="YT">Yukon</option>
			</select>
		</div>
		<div class='divBOX'><?php echo $dw3_lbl["PAYS"]; ?>:
			<!-- <select id="newPAYS" onchange="getLOC(this.value,'State','newPROV');"> -->
            <input placeholder="" disabled id='newPAYS' type='text' value="Canada" onclick='detectCLICK(event,this);'>
			<!-- </select>	 -->
		</div>
		<div class='divBOX'><?php echo $dw3_lbl["CP"]; ?>:
			<input placeholder="" id='newCP' type='text' value="" onclick='detectCLICK(event,this);'>
		</div>
        <br>
		<div class='divBOX'><?php echo $dw3_lbl["LNG"]; ?>: <span onclick='getLngLat()' class='material-icons' style='color:blue;cursor:pointer;'>share_location</span>
			<input placeholder="" id='newLNG' type='number' value="" onclick='detectCLICK(event,this);' style="float:right;">
		</div>
		<div class='divBOX'><?php echo $dw3_lbl["LAT"]; ?>:
			<input placeholder="" id='newLAT' type='number' value="" onclick='detectCLICK(event,this);' style="float:right;">
		</div>

		<br>    <br>
		<i style='font-size:12px;color:darkgrey;'>Il sera possible d'entrer plus d'informations lors de modification de la fiche client.</i><br> 
</div>
    <div class='dw3_form_foot'>
        <button class="grey" onclick="closeNEW();"><span class="material-icons">cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>
        <button class="green" onclick="newCLI();"><span class="material-icons">add</span><?php echo $dw3_lbl["CREATE"]; ?></button>
    </div>
</div>
<div id='divFILTRE'>
<h3><?php echo $dw3_lbl["FILTER"]; ?></h3>
		<table style='width:100%'>
		<tr><td><?php echo $dw3_lbl["STAT"]; ?></td><td width='*'>
		<select id='selSTAT'>
			<option value='0'><?php echo $dw3_lbl["STAT0"]??'Actif'; ?></option>
			<option value='1'><?php echo $dw3_lbl["STAT1"]??'Inactif'; ?></option>
			<option value='2'><?php echo $dw3_lbl["STAT2"]??'Suspendu'; ?></option>
			<option value='3'><?php echo $dw3_lbl["STAT3"]??'Banni'; ?></option>
			<option selected value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr>
		<tr><td>Type</td><td width='*'>
		<select id='selTYPE'>
			<option value='PARTICULAR'>Particulier</option>
			<option value='COMPANY'>Compagnie</option>
			<option value='RETAILER'>Détaillant</option>
			<option value='INTERNAL'>Interne (table,caisse..)</option>
			<option selected value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["LANG"]; ?></td><td>
		<select id='selLANG'>
			<?php
				$sql = "SELECT DISTINCT(lang)
						FROM customer 
						WHERE lang <> ''
						ORDER  BY lang
						LIMIT 100";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["lang"]  . "'>" . $row["lang"]  . "</option>";
					}
				}
			?>
			<option selected  value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["PAYS"]; ?></td><td>
		<select id='selPAYS'>
			<?php
/* 				$sql = "SELECT DISTINCT(country)
						FROM customer 
						WHERE country <> ''
						ORDER  BY country
						LIMIT 100";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["country"]  . "'>" . $row["country"]  . "</option>";
					}
				} */
                echo "<option value='Canada'>Canada</option>";
			?>
			<option selected  value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["PROV"]; ?></td><td>
		<select id='selPROV'>
			<?php
				$sql = "SELECT DISTINCT(province)
						FROM customer 
						WHERE province <> ''
						ORDER  BY province
						LIMIT 100";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["province"]  . "'>" . $row["province"]  . "</option>";
					}
				}
			?>
			<option selected  value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr>
		<tr><td><?php echo $dw3_lbl["VILLE"]; ?></td><td>
		<select id='selVILLE'>
			<?php
				$sql = "SELECT DISTINCT(city)
						FROM customer 
						WHERE city <> ''
						ORDER  BY city
						LIMIT 100";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["city"]  . "'>" . $row["city"]  . "</option>";
					}
				}
			?>
			<option selected value=''><?php echo $dw3_lbl["ALL"]; ?></option>
		</select></td></tr></table><br>
		<div style='width:100%;text-align:center;'><button class='grey' onclick="closeFILTRE();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button><button onclick="closeFILTRE();getCLIS('','',LIMIT);"><span class="material-icons">filter_alt</span> <?php echo $dw3_lbl["FILTER"]; ?></button></div>
</div>
<div style='display:none;'>
    <form id='frmUPLOAD0' action="upload0.php?KEY=<?php echo $KEY;?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload0" id="fileToUpload0" oninput="document.getElementById('submitUPLOAD0').click();">    
    <input type="submit" value="Upload Image" name="submit" id='submitUPLOAD0'>
    </form>
</div>
<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script>
var bREADY = false;
var CIE_PAYS_ID = '<?php echo $CIE_PAYS_ID; ?>';
var CIE_PROV_ID = '<?php echo $CIE_PROV_ID; ?>';
var CIE_VILLE_ID = '<?php echo $CIE_VILLE_ID; ?>';
var KEY = '<?php echo($_GET['KEY']); ?>';
var map;
var LIMIT = '12';

$(document).ready(function ()
    {
		var body = document.body,
		html = document.documentElement;
		var height = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );
        const windowWidth = window.innerWidth;
		if (windowWidth >= 900){
            LIMIT = Math.floor((height-176)/36);
        } else {
            LIMIT = Math.floor((height-176)/31);
        }			   
		getCLIS('','',LIMIT);
        //getLOC(5,'Country','newPAYS');
        //getLOC(47,'State','newPROV');
        //getLOC(738,'City','newVILLE');
        //getLOC(47,'State','newPROV');
		document.getElementsByTagName("BODY")[0].onresize = function() {bodyResize()};
		dragElement(document.getElementById('divNEW'));
		dragElement(document.getElementById('divDISCOUNT'));
		dragElement(document.getElementById('divSEL_SUPPLIER'));
		dragElement(document.getElementById('divSEL_PRODUCT'));
		dragElement(document.getElementById('divSEL_CATEGORY'));
		dragElement(document.getElementById('divPARAM'));
	});

function toggleFolder(sub,up){
	if(document.getElementById(sub).style.height=="0px"){
		document.getElementById(up).innerHTML="folder_open";
		document.getElementById(sub).style.height="auto";
		document.getElementById(sub).style.display="inline-block";
	} else {
		document.getElementById(up).innerHTML="folder";
		document.getElementById(sub).style.height="0px";
		document.getElementById(sub).style.display="none";
	}
}
	
function getLOC_test(parent,type,output){
    $("#"+output).empty();
    let find = "";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        const result = JSON.parse(this.responseText);
        var x = document.getElementById(output);
            if (result.result == "ok" && result.row_count != "0"){
                locs = result.data;       
                    //var option = document.createElement("option");
                    //option.text = "Select a " + type;
                    //option.value = "";
                    //option.disabled = true;
                    //option.selected = true;
                    //x.add(option);
                locs.forEach(function(obj){
                    var option = document.createElement("option");
                    option.text = obj["5"];
                    option.value = obj["0"];
                    if (obj["0"] == CIE_PAYS_ID || obj["0"] == CIE_PROV_ID || obj["0"] == CIE_VILLE_ID){option.selected = true;}
                    x.add(option);
                })
            } else {
                var option = document.createElement("option");
                    option.text = "Select a " + type;
                    option.value = "";
                    option.disabled = true;
                    option.selected = true;
                    x.add(option);
            }
	  }
	};
	xmlhttp.open('GET', '/api/dataia/dataia_loc.php?KEY=' + KEY + "&f=" + find + "&t=" + type + "&o=" + output + "&p=" + parent , true);
	xmlhttp.send();
}
function getLOC(parent,type,output){
    //var endpoint = 'https://<?php echo $_SERVER['SERVER_NAME']; ?>/api/dataia/dataia_loc.php';
    var endpoint = '/api/dataia/dataia_loc.php';
    //let find = document.getElementById("locFind").value;
    let find = "";
    $("#"+output).empty();
    $.ajax({
        url: endpoint + "?KEY=" + KEY + "&f=" + find + "&t=" + type + "&o=" + output + "&p=" + parent,
        contentType: "application/json",
        dataType: 'json',
        success: function(result){
            var x = document.getElementById(output);
            if (result.result == "ok" && result.row_count != "0"){
                locs = result.data;       
                    //var option = document.createElement("option");
                    //option.text = "Select a " + type;
                    //option.value = "";
                    //option.disabled = true;
                    //option.selected = true;
                    //x.add(option);
                locs.forEach(function(obj){
                    var option = document.createElement("option");
                    option.text = obj["5"];
                    option.value = obj["0"];
                    if (obj["0"] == CIE_PAYS_ID || obj["0"] == CIE_PROV_ID || obj["0"] == CIE_VILLE_ID){option.selected = true;}
                    x.add(option);
                })
            } else {
                var option = document.createElement("option");
                    option.text = "Select a " + type;
                    option.value = "";
                    option.disabled = true;
                    option.selected = true;
                    x.add(option);
            }
        }
    })
}


function bodyResize() {
	var max_width = Math.max(window.innerWidth, document.documentElement.clientWidth, document.body.clientWidth)/100*95;
	var text_width = Math.floor(max_width/335)*335;
		if (text_width=='0'){text_width='335'} 
	if (document.getElementById("clNOTE")) {
		document.getElementById("clNOTE").style.width = text_width + "px";
	}
}

	
//_	

function initMap() {
	//navigator.geolocation.getCurrentPosition(function(position) {
		var pos = {
			lat: <?php echo $CIE_LAT; ?>,
			lng: <?php echo $CIE_LNG; ?>
		};
		window.pos = pos;
		//directionsService = new google.maps.DirectionsService;
		//directionsDisplay = new google.maps.DirectionsRenderer;
		//directionsRenderer = new google.maps.DirectionsRenderer();
		map = new google.maps.Map(document.getElementById("googleMap"), {
			zoom: 8,
			  panControl: true,
			  zoomControl: true,
			  mapTypeControl: true,
			  scaleControl: true,
			  streetViewControl: true,
			  overviewMapControl: true,
			  rotateControl: true,
			center: {lat: pos.lat, lng: pos.lng},
		});
		//directionsDisplay.setMap(map);
		//directionsRenderer.setMap(map);
		var me = new google.maps.LatLng(pos.lat, pos.lng);
		myloc = new google.maps.Marker({
			clickable: false,
			icon: new google.maps.MarkerImage('//maps.gstatic.com/mapfiles/mobile/mobileimgs2.png',
															new google.maps.Size(22,22),
															new google.maps.Point(0,18),
															new google.maps.Point(11,11)),
			shadow: null,
			zIndex: 999,
			map: map
		});	
		myloc.setPosition(me);
		
	//});
}
function setMapPos(clID) {
    if (bREADY == false || document.getElementById("clLAT").value == "" || document.getElementById("clLAT").value == "0"){return;}
	var pos = {
				lat: parseFloat(document.getElementById("clLAT").value),
				lng: parseFloat(document.getElementById("clLNG").value)
		};
		
	window.pos = pos;
		map = new google.maps.Map(document.getElementById("googleMap"), {
			zoom: 18,
			center: {lat: pos.lat, lng: pos.lng},
			mapId: '<?php echo $CIE_GMAP_MAP; ?>',
			mapTypeId: 'hybrid',
			heading:0,
			tilt:45	
		});
		var me = new google.maps.LatLng(pos.lat, pos.lng);
		var marker = new google.maps.Marker({
			position: me,
			map: map,
            icon: {
				path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
				fillColor: 'red',
				fillOpacity: 1,
				strokeColor: '#FFF',
				strokeWeight: 1,
				scale: 1.2,
				shadow: true,
				labelOrigin: new google.maps.Point(0, -31),				
			},
			label: {
			  text: '↔',
			  fontSize: '17px',
			  color: 'white',
			  fontWeight: 'bold',

			},
			draggable: true
			});
		marker.setPosition(me);
		google.maps.event.addListener(marker, 'dragend', function() {
		  //alert (marker.getPosition());
		  //updGPS(clID, marker.getPosition().lng(), marker.getPosition().lat())
		document.getElementById("clLNG").value = marker.getPosition().lng();
      document.getElementById("clLAT").value = marker.getPosition().lat();
	  });
}
function getLngLat() {
var address = document.getElementById("newADR1").value;
//var GRPBOX = document.getElementById("newVILLE");
//var ville_id = GRPBOX.options[GRPBOX.selectedIndex].value;	
var ville = document.getElementById("newVILLE").value;	
var GRPBOX = document.getElementById("newPROV");
var prov = GRPBOX.options[GRPBOX.selectedIndex].value;		
//var GRPBOX = document.getElementById("newPAYS");	
var pays = document.getElementById("newPAYS").value;	

    if (address == ""){
		document.getElementById("newADR1").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newADR1").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newADR1").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
    if (ville == ""){
		document.getElementById("newVILLE").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newVILLE").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newVILLE").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
    var address = address + " " + ville + " " + prov + " " + pays
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': address}, function(results, status) {
  if (status == google.maps.GeocoderStatus.OK)
  {
    addNotif("La coordonée GPS a été mise &#224; jour.");
      document.getElementById("newLNG").value = results[0].geometry.location.lng();
      document.getElementById("newLAT").value = results[0].geometry.location.lat();
  }
});
}	
function getLngLat2() {
var geocoder = new google.maps.Geocoder();
var address = document.getElementById("clADR1").value
				+ " " + document.getElementById("clADR2").value
				+ ", " + document.getElementById("clVILLE").value
				+ " " + document.getElementById("clCP").value
				+ " " + document.getElementById("clPROV").value
				+ " " + document.getElementById("clPAYS").value;
geocoder.geocode( { 'address': address}, function(results, status) {
  if (status == google.maps.GeocoderStatus.OK)
  {
      document.getElementById("clLNG").value = results[0].geometry.location.lng();
      document.getElementById("clLAT").value = results[0].geometry.location.lat();
      bREADY = true;
	  setMapPos(document.getElementById("clID").value);
      addNotif("La coordonée GPS a été mise &#224; jour.");
  }
});
}


function openPARAM() {
    closeBatch();
	document.getElementById('divPARAM').style.display = "inline-block";
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 var sOBJ = this.responseText;
		 if (sOBJ != ""){
			 document.getElementById('divPARAM_DATA').innerHTML = sOBJ;
		 }
	  }
	};
	xmlhttp.open('GET', 'getPARAM.php?KEY=' + KEY  , true);
	xmlhttp.send();
}
function detectSEARCH(event,that){
	var x = event.offsetX;
	if (x > (that.offsetWidth-25)){
		that.setSelectionRange(0, that.value.length);
		
	}
}

//UPDATE GPS 1IER ETAPE 
function updateGPS() {
	closeBatch();
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.6";
	var frmCLI  = document.getElementById("frmCLI");

	if (frmCLI.elements.length == 0 || !frmCLI.elements){
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["ERR_SEL1"]; ?><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	}
	for (var i = 0; i < frmCLI.elements.length; i++ ) 
	{
		if (frmCLI.elements[i].type == 'checkbox')
		{
			if (frmCLI.elements[i].checked == true)
			{
				var sCLI = frmCLI.elements[i].value;
				var sOBJ = "CLADR" + sCLI;
				var sADR  = document.getElementById(sOBJ).value;
				getLngLat3(sCLI,sADR);
			}
		}
	}	
	//document.getElementById("divFADE").style.width = "100%";
    addNotif("La coordonée GPS a été mises &#224; jour.");
    getCLIS('','',LIMIT);
}
//UPDATE GPS 2IEM ETAPE
function getLngLat3(clID,address) {
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode( { 'address': address}, function(results, status) {
	  if (status == google.maps.GeocoderStatus.OK)
	  {
		  var rlng = results[0].geometry.location.lng();
		  var rlat = results[0].geometry.location.lat();
		  updGPS(clID,rlng,rlat);
	  }
	});
}
//UPDATE GPS 3IEM ET DERNIERE ETAPE
function updGPS(clID,rlng,rlat){	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				//document.getElementById("divFADE").style.width = "100%";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Mise a jour réussi.<br><br><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				
		  } else {
				//document.getElementById("divFADE").style.width = "100%";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'updGPS.php?KEY=' + KEY + '&clID=' + clID + '&LNG=' + encodeURIComponent(rlng) + '&LAT=' + encodeURIComponent(rlat) , true);
		xmlhttp.send();
	
}


function deleteCLI(clID) {
	if (clID  == "0") {
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.6";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ERR0"]; ?><div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
	} else {
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.6";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='red' onclick='delCLI(" + clID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button>";
	}
}

function initPW(clID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.trim() == ""){
			  	//closeEDITOR();
			  	closeMSG();
                //getCLIS('','',LIMIT);
                addNotif("Un courriel a été envoyé pour initialiser le mot de passe.");
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'initPW.php?KEY=' + KEY + '&clID=' + clID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
		//document.getElementById("divFADE2").style.opacity = "0.4";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}
function resetPW(clID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.trim() == ""){
			  	//closeEDITOR();
			  	closeMSG();
                //getCLIS('','',LIMIT);
                addNotif("Un courriel a été envoyé pour initialiser le mot de passe.");
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'reinitPW.php?KEY=' + KEY + '&clID=' + clID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
		//document.getElementById("divFADE2").style.opacity = "0.4";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}
function delCLI(clID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.trim() == ""){
			  	closeEDITOR();
			  	closeMSG();
				getCLIS('','',LIMIT);
                addNotif("Le dossier client #" + clID + " a été supprimé.");
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delCLI.php?KEY=' + KEY + '&clID=' + clID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}
function deleteCLIS() {
	closeBatch();
	var selectedId = -1;
	var selectedCount = 0;
    var frmCLI  = document.getElementById("frmCLI");
	for (var i = 0; i < frmCLI.elements.length; i++ ) 
	{
		if (frmCLI.elements[i].type == 'checkbox' && frmCLI.elements[i].checked == true)
		{
			selectedCount++;
			selectedID = frmCLI.elements[i].value;
		}
	}
	if(selectedCount == 1 && selectedID > 0){
		deleteCLI(selectedID);
		return;
	}
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.6";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button> <button class='red' onclick='delCLIS();'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button> ";
}
function delCLIS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.6";
	var sLST = "";

	var frmCLI  = document.getElementById("frmCLI");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmCLI.elements.length; i++ ) 
	{
		if (frmCLI.elements[i].type == 'checkbox')
		{
			if (frmCLI.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","} else { sLST = "("; }
				sLST += sVIRGULE + frmCLI.elements[i].value ;
			}
		}
	}	
	if (sLST == ""){
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["ERR_SEL1"]; ?><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	} else { sLST += ")"; }
	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
			  	getCLIS('','',LIMIT);
                closeMSG();
                addNotif("Clients efface.");
          } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delCLIS.php?KEY=' + KEY + '&LST=' + encodeURIComponent(sLST) , true);
		xmlhttp.send();
		
}

function sendCreditPayment(clID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Un courriel a été envoyé pour indiquer qu'un paiement de "+document.getElementById("balanceSpan").innerHTML+" sera effectué.<br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        document.getElementById("balanceBefore").innerHTML = document.getElementById("balanceSpan").innerHTML;
        document.getElementById("balanceSpan").innerHTML = "$0.00";
        document.getElementById("balanceButton").disabled = true;
	  }
	};
	xmlhttp.open('GET', 'sendCreditPayment.php?KEY=' + KEY + '&ID=' + clID, true);
	xmlhttp.send();
}
function resetPRM() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        openPARAM();
	  }
	};
	xmlhttp.open('GET', '../resetPRM.php?KEY=' + KEY + '&APP=' + <?php echo $APID; ?> , true);
	xmlhttp.send();
}

function copyADR_TO_SH() {
    document.getElementById("clADR1_SH").value =  document.getElementById("clADR1").value ;
    document.getElementById("clADR2_SH").value =  document.getElementById("clADR2").value ;
    document.getElementById("clVILLE_SH").value =  document.getElementById("clVILLE").value ;
    document.getElementById("clPROV_SH").value =  document.getElementById("clPROV").value ;
    document.getElementById("clPAYS_SH").value =  document.getElementById("clPAYS").value ;
    document.getElementById("clCP_SH").value =  document.getElementById("clCP").value ;
}
function getCLI(clID) {
    closeBatch();
	var max_width = Math.max(window.innerWidth, document.documentElement.clientWidth, document.body.clientWidth)/100*95;
	var text_width = Math.floor(max_width/335)*335;
	if (text_width=='0'){text_width='335'} 
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divEDIT_MAIN").innerHTML = this.responseText;
		 document.getElementById("divEDIT").style.display = "inline-block";
		 //window.scrollTo(0, 0);
         dragElement(document.getElementById('divEDIT'));
		 document.getElementById("divEDIT").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
         getEVENTS(clID);
            bREADY = true;
		    <?php if ($CIE_GMAP_KEY!=""){ echo "setMapPos(clID)";} ?>
	  }
	};
	document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
		xmlhttp.open('GET', 'getCLI.php?KEY=' + KEY + '&clID=' + clID + '&tw=' + text_width , true);
		xmlhttp.send();
		
}

function getCLIS(clSTAT,sOFFSET,sLIMIT,sORDERBY="") {
	var sS = document.getElementById("inputSEARCH").value;
	
	//STAT
	if (clSTAT.trim() == ""){
		var GRPBOX = document.getElementById("selSTAT");
		clSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;		
	}
	//TYPE
	var GRPBOX = document.getElementById("selTYPE");
	var clTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//LANG
	var GRPBOX = document.getElementById("selLANG");
	var clLANG = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//PAYS
	var GRPBOX = document.getElementById("selPAYS");
	var clPAYS = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//PROV
	var GRPBOX = document.getElementById("selPROV");
	var clPROV = GRPBOX.options[GRPBOX.selectedIndex].value;	
	//VILLE
	var GRPBOX = document.getElementById("selVILLE");
	var clVILLE = GRPBOX.options[GRPBOX.selectedIndex].value;	


	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getCLIS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim())
									+ '&clSTAT=' + clSTAT
									+ '&clTYPE=' + clTYPE
									+ '&clLANG=' + clLANG
									+ '&clPAYS=' + clPAYS
									+ '&clPROV=' + clPROV
									+ '&clVILLE=' + clVILLE
									+ '&OFFSET=' + sOFFSET 
									+ '&LIMIT=' + sLIMIT  
									+ '&ORDERBY=' + sORDERBY  
									, true);
		xmlhttp.send();
		
}
function openNEWCLI(){
    document.getElementById("newToStripe").checked = false;
	document.getElementById("newPREFIX").value = "";
	document.getElementById("newPRENOM").value = "";
	document.getElementById("newPRENOM2").value = "";
	document.getElementById("newCIE").value = "";
	document.getElementById("newNOM").value = "";
	document.getElementById("newSUFFIX").value = "";
	document.getElementById("newTEL1").value = "";
	document.getElementById("newEML1").value = "";
	document.getElementById("newWEB").value = "";
    document.getElementById("newADR1").value = "";
	document.getElementById("newADR2").value = "";
	document.getElementById("newVILLE").value = "";	
	document.getElementById("newCP").value = "";
	document.getElementById("newLNG").value = "";
	document.getElementById("newLAT").value = "";
    document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.5";
	document.getElementById("divNEW").style.zIndex = "1101";
	document.getElementById("divNEW").style.display = "inline-block";
	window.scrollTo(0, 0);
	document.getElementById('divNEW').scrollTop = 0;
    closeBatch();
}
function newCLI(){
    var sSTRIPE = document.getElementById("newToStripe").checked;
	var GRPBOX = document.getElementById("newTYPE");
	var sTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("newLANG");
	var sLANG = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sPREFIX  = document.getElementById("newPREFIX").value;
	var sPRENOM  = document.getElementById("newPRENOM").value;
	var sPRENOM2  = document.getElementById("newPRENOM2").value;
	var sCIE  = document.getElementById("newCIE").value;
	var sNOM  = document.getElementById("newNOM").value;
	var sSUFFIX  = document.getElementById("newSUFFIX").value;
	var sTEL1  = document.getElementById("newTEL1").value;
	var sEML1  = document.getElementById("newEML1").value;
	var sWEB  = document.getElementById("newWEB").value;
	var sADR1  = document.getElementById("newADR1").value;
	var sADR2  = document.getElementById("newADR2").value;
        //var GRPBOX = document.getElementById("newVILLE");
	var sVILLE  = document.getElementById("newVILLE").value;	
	var GRPBOX = document.getElementById("newPROV");
	var sPROV = GRPBOX.options[GRPBOX.selectedIndex].value;	    
        //var GRPBOX = document.getElementById("newPAYS");
	//var sPAYS  = document.getElementById("newPAYS").value;	
	var sCP  = document.getElementById("newCP").value;
	var sLNG  = document.getElementById("newLNG").value;
	var sLAT  = document.getElementById("newLAT").value;

	
    if (sTYPE == "PARTICULAR"){
        if (sNOM == ""){
            document.getElementById("newNOM").style.boxShadow = "5px 10px 15px red";
            document.getElementById("newNOM").focus();
            //document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
            return;
        } else {
            document.getElementById("newNOM").style.boxShadow = "5px 10px 15px goldenrod";
            //document.getElementById("lblPRD").innerHTML = "";
        }	
    }
    if (sTYPE == "COMPANY" && sCIE == ""){
            document.getElementById("newCIE").style.boxShadow = "5px 10px 15px red";
            document.getElementById("newCIE").focus();
            //document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
            return;
    } else {
            document.getElementById("newCIE").style.boxShadow = "5px 10px 15px goldenrod";
            //document.getElementById("lblPRD").innerHTML = "";    
    }
/* 	if (sADR1 == ""){
		document.getElementById("newADR1").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newADR1").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newADR1").style.boxShadow = "5px 10px 15px goldenrod";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	if (sVILLE == ""){
		document.getElementById("newVILLE").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newVILLE").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newVILLE").style.boxShadow = "5px 10px 15px goldenrod";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	if (sPROV == ""){
		document.getElementById("newPROV").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newPROV").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newPROV").style.boxShadow = "5px 10px 15px goldenrod";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
 */

    document.getElementById("divFADE").style.display = "inline-block";
	document.getElementById("divFADE").style.opacity = "0.6";
    //addNotif("Nouveau client en processus de validation..");
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  const response = JSON.parse(this.responseText);
		  if (response.status == "ok"){
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["CREATED"]; ?><div style='height:20px;'> </div>"
													+ "<button style='width:100px;height:75px;' onclick='closeMSG();closeNEW();'><span class='material-icons' style='vertical-align:middle;'>done</span><br><?php echo $dw3_lbl["DONE"]; ?></button>"
													+ "<button style='width:100px;height:75px;'  onclick='closeMSG();openNEWCLI();'><span class='material-icons' style='vertical-align:middle;'>add</span><br><?php echo $dw3_lbl["ANOTHER"]; ?></button>"
													+ "<button style='width:100px;height:75px;'  onclick=\"closeMSG();closeNEW();getCLI('" + response.data.trim() + "')\"><span class='material-icons' style='vertical-align:middle;'>edit</span><?php echo $dw3_lbl["REMOD"]; ?></button>";
                if (sSTRIPE){
                    addToSTRIPE(response.data.trim());
                }
                newREPORTS(response.data.trim());
                getCLIS('','',LIMIT);
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = response.data + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  } else if (this.readyState == 4 && this.status >= 400) {
		const response = this.responseText;
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = response + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	  }
	};
		xmlhttp.open('GET', 'newCLI.php?KEY=' + KEY    
										+ '&TYPE=' + encodeURIComponent(sTYPE)   
										+ '&LANG=' + encodeURIComponent(sLANG)   
										+ '&CIE=' + encodeURIComponent(sCIE)   
										+ '&NOM=' + encodeURIComponent(sNOM)   
										+ '&PREFIX=' + encodeURIComponent(sPREFIX)   
										+ '&PRENOM=' + encodeURIComponent(sPRENOM)   
										+ '&PRENOM2=' + encodeURIComponent(sPRENOM2)   
										+ '&SUFFIX=' + encodeURIComponent(sSUFFIX)      
										+ '&ADR1=' + encodeURIComponent(sADR1)   
										+ '&ADR2=' + encodeURIComponent(sADR2)   
										+ '&VILLE=' + encodeURIComponent(sVILLE)   
										+ '&PROV=' + encodeURIComponent(sPROV)     
										+ '&CP=' + encodeURIComponent(sCP)   
										+ '&EML1=' + encodeURIComponent(sEML1)      
										+ '&TEL1='  + encodeURIComponent(sTEL1)  
										+ '&WEB=' + encodeURIComponent(sWEB)   
										+ '&LNG=' + encodeURIComponent(sLNG)   
										+ '&LAT=' + encodeURIComponent(sLAT) ,   
										true);
		xmlhttp.send();
}

//events
function getEVENTS(clID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divEVENTS").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getEVENTS.php?KEY=' + KEY + '&clID=' + clID , true);
		xmlhttp.send();
		
}

function getEVENT(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divEVENT_MAIN").innerHTML = this.responseText;
		 document.getElementById("divEVENT").style.display = "inline-block";
		 dragElement(document.getElementById('divEVENT'));
		 document.getElementById("divEVENT").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"})
		 //setMapPos();
	  }
	};
		document.getElementById("divFADE").style.width = "100%";
		xmlhttp.open('GET', 'getEVENT.php?KEY=' + KEY + '&ID=' + ID , true);
		xmlhttp.send();
		
}

function deleteEVENT(ID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button class='red' onclick='delEVENT(" + ID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}

function delEVENT(ID) {
	var clID  = document.getElementById("customer_id").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
                addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
                getEVENTS(clID);
                closeMSG();
                closeEVENT();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delEVENT.php?KEY=' + KEY + '&ID=' + ID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}
function newEVENT(sTYPE){
    var clID  = document.getElementById("customer_id").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				addNotif("<?php echo $dw3_lbl["CREATED"]; ?>");
                getEVENTS(clID);
                getEVENT(this.responseText);

		  } else {
            document.getElementById("divFADE2").style.display = "inline-block";
		    document.getElementById("divFADE2").style.opacity = "0.4";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newEVENT.php?KEY=' + KEY  
										+ '&TYPE=' + encodeURIComponent(sTYPE)+ '&clID=' + encodeURIComponent(clID),   
										true);
		xmlhttp.send();

}
function updEVENT(sID){
	var clID  = document.getElementById("customer_id").value;
	
    var GRPBOX = document.getElementById("evTYPE");
	var sTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("evPRIORITY");
	var sPRIORITY = GRPBOX.options[GRPBOX.selectedIndex].value;	
    var GRPBOX = document.getElementById("evSTATUS");
    sSTATUS = GRPBOX.options[GRPBOX.selectedIndex].value;	

	var sNAME  = document.getElementById("evNAME").value;
	var sDATE  = document.getElementById("evDATE").value;
	var sDATE_START  = sDATE + " " + document.getElementById("evDATE_START").value;
	var sDATE_END  = sDATE + " " + document.getElementById("evDATE_END").value;
	var sDESC  = document.getElementById("evDESC_FR").value;
	//var sDESC  = document.getElementById("evDESC_FR").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
	var sHREF  = document.getElementById("evHREF").value;
	var sIMG  = document.getElementById("evIMG").value;
	
	if (sNAME == ""){
		document.getElementById("evNAME").style.boxShadow = "5px 10px 15px red";
		document.getElementById("evNAME").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("evNAME").style.boxShadow = "5px 10px 15px #333";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText.trim() == ""){
				getEVENTS(clID);
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
                closeMSG();closeEVENT();
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updEVENT.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)    
										+ '&TYPE=' + encodeURIComponent(sTYPE)    
										+ '&STATUS=' + encodeURIComponent(sSTATUS)    
										+ '&PRIORITY=' + encodeURIComponent(sPRIORITY)    
										+ '&NAME=' + encodeURIComponent(sNAME)     
										+ '&DESC=' + encodeURIComponent(sDESC)        
										+ '&START=' + encodeURIComponent(sDATE_START)   
										+ '&END=' + encodeURIComponent(sDATE_END)   
										+ '&IMG=' + encodeURIComponent(sIMG)   
										+ '&HREF=' + encodeURIComponent(sHREF),                 
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}

function closeEVENT() {
 		document.getElementById("divEVENT").style.display = "none";  
}

//addToSTRIPE
function addToSTRIPE(clID){	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText != ""){
            document.getElementById("divFADE").style.width = "100%";
            if (document.getElementById("clSTRIPE_ID")!=undefined){
                document.getElementById("clSTRIPE_ID").value = this.responseText;
            }
            addNotif("Réponse de Stripe (no de client ou erreur):" + this.responseText);
        }
	  }
	};
		xmlhttp.open('GET', 'addToSTRIPE.php?KEY=' + KEY + '&clID=' + clID, true);
		xmlhttp.send();
	
}
//new auto add reports
function newREPORTS(clID){	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "0"){
        } else if (this.responseText == "1"){
            addNotif("Un nouveau document a été ajouté dans son espace-client");
        } else {
            addNotif(this.responseText + " nouveaux documents ont été créés dans son espace-client");
        }
	  }
	};
		xmlhttp.open('GET', '/app/quiz/newREPORT_TO_ID.php?KEY=' + KEY + '&UID=' + clID + '&DB=customer', true);
		xmlhttp.send();
	
}

//DISCOUNTS
function setDISCOUNT_SUP(sup_id){
	document.getElementById("discount_SUPPLIER").value = sup_id;
	closeSEL_SUPPLIER();
}
function setDISCOUNT_PRD(prd_id){
	document.getElementById("discount_PRODUCT").value = prd_id;
	closeSEL_PRODUCT();
}
function setDISCOUNT_CAT(cat_id){
	document.getElementById("discount_CATEGORY").value = cat_id;
	closeSEL_CATEGORY();
}
function closeDISCOUNT(){
    document.getElementById("divDISCOUNT").style.display = "none";
}
function closeSEL_SUPPLIER(){
    document.getElementById("divSEL_SUPPLIER").style.display = "none";
}
function closeSEL_PRODUCT(){
    document.getElementById("divSEL_PRODUCT").style.display = "none";
}
function closeSEL_CATEGORY(){
    document.getElementById("divSEL_CATEGORY").style.display = "none";
}
function openSEL_SUPPLIER(){
    document.getElementById("divSEL_SUPPLIER").style.display = "inline-block";
}
function openSEL_PRODUCT(){
    document.getElementById("divSEL_PRODUCT").style.display = "inline-block";
}
function openSEL_CATEGORY(){
    document.getElementById("divSEL_CATEGORY").style.display = "inline-block";
}
function newDISCOUNT(clID){	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            addNotif("Une nouvelle escompte a été ajouté pour ce client.");
            getDISCOUNT(this.responseText,clID);
            getDISCOUNTS(clID);
	  }
	};
		xmlhttp.open('GET', 'newDISCOUNT.php?KEY=' + KEY + '&CID=' + clID, true);
		xmlhttp.send();
}
function delDISCOUNT(discountID,clID){	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            addNotif("L'escompte a été supprimée.");
            document.getElementById("divDISCOUNT").style.display = "none";
            getDISCOUNTS(clID);
	  }
	};
		xmlhttp.open('GET', 'delDISCOUNT.php?KEY=' + KEY + '&DID=' + discountID, true);
		xmlhttp.send();
}
function updDISCOUNT(discountID,clID){	
    var DS = document.getElementById("discount_SUPPLIER").value;
    //var DP = document.getElementById("discount_PRODUCT").value;
    //var DC = document.getElementById("discount_CATEGORY").value;
    var D1 = document.getElementById("discount_POURCENT").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            addNotif("L'escompte a été mis à jour.");
            getDISCOUNTS(clID);
	  }
	};
		//xmlhttp.open('GET', 'updDISCOUNT.php?KEY=' + KEY + '&DID=' + discountID+ '&DS=' + DS+ '&DP=' + DP+ '&DC=' + DC+ '&D1=' + D1, true);
		xmlhttp.open('GET', 'updDISCOUNT.php?KEY=' + KEY + '&DID=' + discountID+ '&DS=' + DS+ '&D1=' + D1, true);
		xmlhttp.send();
        closeDISCOUNT();
}
function getDISCOUNTS(clID){	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divCUSTOMER_DISCOUNT").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getDISCOUNTS.php?KEY=' + KEY + '&CID=' + clID , true);
		xmlhttp.send();
}
function getDISCOUNT(discountID,clID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divDISCOUNT").style.display = "inline-block";
        document.getElementById("divDISCOUNT_DATA").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getDISCOUNT.php?KEY=' + KEY + '&DID=' + discountID + '&CID=' + clID , true);
		xmlhttp.send();
}

function updCLI(sID){
	var GRPBOX = document.getElementById("clSTAT");
	var sSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("clTYPE");
	var sTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sLOC  = document.getElementById("clLOC").value;
	var sPREFIX  = document.getElementById("clPREFIX").value;
	var sPRENOM  = document.getElementById("clPRENOM").value;
	var sPRENOM2  = document.getElementById("clPRENOM2").value;
	var sSUFFIX  = document.getElementById("clSUFFIX").value;
	var sNOM     = document.getElementById("clNOM").value;
	var sCIE     = document.getElementById("clCIE").value;
	var sTEL1    = document.getElementById("clTEL1").value;
	var sTEL2    = document.getElementById("clTEL2").value;
	var sADR1    = document.getElementById("clADR1").value;
	var sADR2    = document.getElementById("clADR2").value;
	var sVILLE   = document.getElementById("clVILLE").value;
	var GRPBOX = document.getElementById("clPROV");
	var sPROV = GRPBOX.options[GRPBOX.selectedIndex].value;
	//var sPAYS    = document.getElementById("clPAYS").value;
	var sCP      = document.getElementById("clCP").value;
	var sADR1s    = document.getElementById("clADR1_SH").value;
	var sADR2s    = document.getElementById("clADR2_SH").value;
	var sVILLEs   = document.getElementById("clVILLE_SH").value;
	var sPROVs    = document.getElementById("clPROV_SH").value;
	var sPAYSs    = document.getElementById("clPAYS_SH").value;
	var sCPs      = document.getElementById("clCP_SH").value;
	var sEML1    = document.getElementById("clEML1").value;
	var sEML2    = document.getElementById("clEML2").value;
	var sWEB    = document.getElementById("clWEB").value;
	var GRPBOX = document.getElementById("clLANG");
	var sLANG = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX = document.getElementById("clSEXE");
	var sSEXE = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sNOTE    = document.getElementById("clNOTE").value;
	var sLNG     = document.getElementById("clLNG").value;
	var sLAT     = document.getElementById("clLAT").value;

	var sNEWS = document.getElementById("clNEWS").checked;
	var sSMS = document.getElementById("clSMS").checked;
	var sTWO_FAC = document.getElementById("clTWO_FAC").checked;

/* 	if (sNOM == ""){document.getElementById("clNOM").focus();return;}
	if (sADR1 == ""){document.getElementById("clADR1").focus();return;}
	if (sVILLE == ""){document.getElementById("clVILLE").focus();return;}
	if (sPROV == ""){document.getElementById("clPROV").focus();return;}
	if (sCP == ""){document.getElementById("clCP").focus();return;}
	if (sADR1s == ""){document.getElementById("clADR1_SH").focus();return;}
	if (sVILLEs == ""){document.getElementById("clVILLE_SH").focus();return;}
	if (sPROVs == ""){document.getElementById("clPROV_SH").focus();return;}
	if (sCPs == ""){document.getElementById("clCP_SH").focus();return;} */
	
	document.getElementById("dw3_updcl_btn").disable = true;
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.4";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				closeMSG();
                closeEDITOR();
                getCLIS('','',LIMIT);
                addNotif("La fiche client de " + sPRENOM + " " + sNOM +  " a été mise &#224; jour.");
		  } else {
                document.getElementById("dw3_updcl_btn").disable = false;
                document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updCLI.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)  
										+ '&TYPE=' + encodeURIComponent(sTYPE)     
										+ '&LOC=' + encodeURIComponent(sLOC)
										+ '&STAT=' + encodeURIComponent(sSTAT)     
										+ '&LANG=' + encodeURIComponent(sLANG)       
										+ '&SEXE=' + encodeURIComponent(sSEXE)   
										+ '&PREFIX=' + encodeURIComponent(sPREFIX)   
										+ '&PRENOM=' + encodeURIComponent(sPRENOM)   
										+ '&PRENOM2=' + encodeURIComponent(sPRENOM2)   
										+ '&NOM=' + encodeURIComponent(sNOM)   
										+ '&CIE=' + encodeURIComponent(sCIE)   
										+ '&SUFFIX=' + encodeURIComponent(sSUFFIX)   
										+ '&TEL1=' + encodeURIComponent(sTEL1)   
										+ '&TEL2=' + encodeURIComponent(sTEL2)   
										+ '&ADR1=' + encodeURIComponent(sADR1)   
										+ '&ADR2=' + encodeURIComponent(sADR2)   
										+ '&VILLE=' + encodeURIComponent(sVILLE)   
										+ '&PROV=' + encodeURIComponent(sPROV)     
										+ '&CP=' + encodeURIComponent(sCP)   
										+ '&ADR1s=' + encodeURIComponent(sADR1s)   
										+ '&ADR2s=' + encodeURIComponent(sADR2s)   
										+ '&VILLEs=' + encodeURIComponent(sVILLEs)   
										+ '&PROVs=' + encodeURIComponent(sPROVs)   
										+ '&PAYSs=' + encodeURIComponent(sPAYSs)   
										+ '&CPs=' + encodeURIComponent(sCPs)   
										+ '&EML1=' + encodeURIComponent(sEML1)   
										+ '&EML2=' + encodeURIComponent(sEML2)   
										+ '&WEB=' + encodeURIComponent(sWEB)   
										+ '&NOTE=' + encodeURIComponent(sNOTE)   
										+ '&NEWS=' + encodeURIComponent(sNEWS)   
										+ '&SMS=' + encodeURIComponent(sSMS)   
										+ '&TWO_FAC=' + encodeURIComponent(sTWO_FAC)   
										+ '&LNG=' + encodeURIComponent(sLNG)   
										+ '&LAT=' + sLAT ,                 
										true);
		xmlhttp.send();
}

function updPRM(){
	var GRPBOX = document.getElementById("prmLIMIT");
	var prmLIMIT = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("prmORDERBY");
	var prmORDERBY = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX = document.getElementById("prmORDERWAY");
	var prmORDERWAY = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	if (document.getElementById("DSP_COL_ID").checked == false){ var dspID = 0; } else { var dspID = 1; }
	if (document.getElementById("DSP_COL_FULLNAME").checked == false){ var dspFULLNAME = 0; } else { var dspFULLNAME = 1; }
	if (document.getElementById("DSP_COL_ADR").checked == false){ var dspADR = 0; } else { var dspADR = 1; }
	if (document.getElementById("DSP_COL_LANG").checked == false){ var dspLANG = 0; } else { var dspLANG = 1; }
	if (document.getElementById("DSP_COL_STAT").checked == false){ var dspSTAT = 0; } else { var dspSTAT = 1; }
	if (document.getElementById("DSP_COL_TYPE").checked == false){ var dspTYPE = 0; } else { var dspTYPE = 1; }
	if (document.getElementById("DSP_COL_PRENOM").checked == false){ var dspPRENOM = 0; } else { var dspPRENOM = 1; }
	if (document.getElementById("DSP_COL_NOM").checked == false){ var dspNOM = 0; } else { var dspNOM = 1; }
	if (document.getElementById("DSP_COL_CIE").checked == false){ var dspCIE = 0; } else { var dspCIE = 1; }
	if (document.getElementById("DSP_COL_ADR1").checked == false){ var dspADR1 = 0; } else { var dspADR1 = 1; }
	if (document.getElementById("DSP_COL_ADR2").checked == false){ var dspADR2 = 0; } else { var dspADR2 = 1; }
	if (document.getElementById("DSP_COL_VILLE").checked == false){ var dspVILLE = 0; } else { var dspVILLE = 1; }
	if (document.getElementById("DSP_COL_PROV").checked == false){ var dspPROV = 0; } else { var dspPROV = 1; }
	if (document.getElementById("DSP_COL_PAYS").checked == false){ var dspPAYS = 0; } else { var dspPAYS = 1; }
	if (document.getElementById("DSP_COL_CP").checked == false){ var dspCP = 0; } else { var dspCP = 1; }
	if (document.getElementById("DSP_COL_TEL1").checked == false){ var dspTEL1 = 0; } else { var dspTEL1 = 1; }
	if (document.getElementById("DSP_COL_TEL2").checked == false){ var dspTEL2 = 0; } else { var dspTEL2 = 1; }
	if (document.getElementById("DSP_COL_EML1").checked == false){ var dspEML1 = 0; } else { var dspEML1 = 1; }
	if (document.getElementById("DSP_COL_EML2").checked == false){ var dspEML2 = 0; } else { var dspEML2 = 1; }
	if (document.getElementById("DSP_COL_LNG").checked == false){ var dspLNG = 0; } else { var dspLNG = 1; }
	if (document.getElementById("DSP_COL_LAT").checked == false){ var dspLAT = 0; } else { var dspLAT = 1; }
	if (document.getElementById("DSP_COL_NOTE").checked == false){ var dspNOTE = 0; } else { var dspNOTE = 1; }
	if (document.getElementById("DSP_COL_DTAD").checked == false){ var dspDTAD = 0; } else { var dspDTAD = 1; }
	if (document.getElementById("DSP_COL_DTMD").checked == false){ var dspDTMD = 0; } else { var dspDTMD = 1; }
	if (document.getElementById("DSP_COL_BALANCE").checked == false){ var dspBALANCE = 0; } else { var dspBALANCE = 1; }
	if (document.getElementById("DSP_COL_FACTURED").checked == false){ var dspFACTURED = 0; } else { var dspFACTURED = 1; }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
            closeMSG();
            closeEDITOR();
            getCLIS('','',LIMIT);
            addNotif("Les paramètres ont été mis &#224; jour.");
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};

		xmlhttp.open('GET', 'updPRM.php?KEY=' + KEY 
										+ '&LIMIT=' 	+ prmLIMIT
										+ '&ORDW='	+ prmORDERWAY
										+ '&ORDB='	+ prmORDERBY
										+ '&ID=' 		+ dspID
										+ '&FNAME='		+ dspFULLNAME
										+ '&ADR='		+ dspADR
										+ '&ID=' 		+ dspID
										+ '&LANG=' 		+ dspLANG
										+ '&STAT='		+ dspSTAT 
										+ '&TYPE='		+ dspTYPE
										+ '&PRENOM=' 	+ dspPRENOM
										+ '&NOM='		+ dspNOM  
										+ '&CIE='		+ dspCIE  
										+ '&ADR1=' 		+ dspADR1
										+ '&ADR2=' 		+ dspADR2
										+ '&VILLE=' 	+ dspVILLE
										+ '&PROV=' 		+ dspPROV
										+ '&PAYS=' 		+ dspPAYS
										+ '&CP=' 		+ dspCP 
										+ '&TEL1=' 		+ dspTEL1
										+ '&TEL2=' 		+ dspTEL2
										+ '&EML1=' 		+ dspEML1
										+ '&EML2=' 		+ dspEML2
										+ '&LNG=' 		+ dspLNG
										+ '&LAT=' 		+ dspLAT
										+ '&DTAD=' 		+ dspDTAD
										+ '&DTMD=' 		+ dspDTMD
										+ '&BALANCE=' 	+ dspBALANCE
										+ '&FACTURED=' 	+ dspFACTURED
										+ '&NOTE=' 		+ dspNOTE,
										true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}

/* upload fichiers section mes documents */
    $('#frmUPLOAD0').on('submit',function(e){
		var customer_id = document.getElementById("customer_id").value;
        var file = $('#fileToUpload0')[0].files[0];
            if (!file){return;}
            if (file.size > 10000000){
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = "Veuillez réduire la taille du fichier. Maximum 10MB par image.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                e.preventDefault();
                return false;
            }
            //var iPRD = document.getElementById("prID").value;
            e.preventDefault(); //prevent default form submition
            data = new FormData();
            data.append('fileToUpload0', file);
            //data.append('fileName0', document.getElementById("fileName0").value); //filename without .&extention
            //var output = document.getElementById('imgPRD');
            //output.src = URL.createObjectURL($('#fileToUpload')[0].files[0]);
            if (data){
                $.ajax({
                    type : 'post',
                    url : 'upload0.php?KEY=<?php echo $KEY;?>&clID='+customer_id,
                    data : data,
                    dataTYpe : 'multipart/form-data',
                    processData: false,
                    contentType: false, 
                    beforeSend : function(){
                        document.getElementById("divFADE").style.display = "inline-block";
                        document.getElementById("divFADE").style.opacity = "0.6";
                        document.getElementById("divMSG").style.display = "inline-block";
                        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:70px;height:auto;border-radius:7px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
                    },
                    success : function(response){

                        //response = JSON.parse(response);

                        if(response.substr(0,5) != "ERROR"){
                            //closeMSG();
                            //getFILES(document.getElementById("fileName7").value);
                            //adID = document.getElementById("fileName0").value;
                            //addNotif(response);
                            //var sFN = document.getElementById("fileToUpload0").value.replace(/^.*[\\/]/, '');
                            //sFN = adID + "." + sFN.split('.').pop();
                            //updAD_IMG(adID.substr(0, adID.lastIndexOf('.')),sFN,'1');
                            //document.getElementById("adIMG").src = "/fs/customer/"+USER+"/"+response+"?t="+Math.floor(Math.random()*1000000);
                            //document.getElementById("imgPRD").src = "";
                            //document.getElementById("fileToUpload0").value = "";
                            document.getElementById("divMSG").innerHTML = "Le fichier a été téléversé! <br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        }else{
                            //addNotif("Erreur avec l'image..");
                            document.getElementById("divMSG").style.display = "inline-block";
                            document.getElementById("divMSG").innerHTML = response + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        }

                    }

                }); 
            }
        });
function deleteFILE(fn,clID) {
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.6";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button class='red' onclick=\"delFILE('" + fn + "','" + clID + "');\"><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>";
}
function delFILE(fn,clID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            document.getElementById("divMSG").innerHTML = "Le fichier a été effacé.<br><br><button class='grey' onclick='closeMSG();'><span class='material-icons'>done</span> Ok</button>";
	  }
	};
		xmlhttp.open('GET', 'deleteFILE.php?KEY=' + KEY + '&fn=' + encodeURIComponent(fn) + '&clID=' + clID , true);
		xmlhttp.send();
}

</script>
<?php if ($CIE_GMAP_KEY!=""){ ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $CIE_GMAP_KEY; ?>&callback=initMap"></script>
<?php } ?>
</body></html><?php $dw3_conn->close(); die(); ?>
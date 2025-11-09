<?php /**
 +---------------------------------------------------------------------------------+
 | DW3 PME Kit BETA                                                                |
 | Version 0.1                                                                     |
 |                                                                                 | 
 |  The MIT License                                                                |
 |  Copyright © 2023 Design Web 3D                                                 | 
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
$APNAME = "Structure de l'entreprise";
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';
?>
<div id="divHEAD">
	<table style="width:100%;margin:0px;white-space:nowrap;margin-top:5px;">
		<tr style="margin:0px;padding:0px;">
			<td width="*">
                <select id="config_select" onchange="window.open(this.value+'?KEY='+KEY,'_self')">
                    <option value="/app/config/config.php"> Tableau de Bord </option>
                    <option value="/app/config/config_1_info.php"> Infos générales & Facturation </option>
                    <option value="/app/config/config_2_location.php"> Adresses et Divisions </option>
                    <option selected value="/app/config/config_3_structure.php"> Structure de l'entreprise </option>
                    <option value="/app/config/config_4_gouv.php"> Renseignements Gouvernementaux </option>
                    <option value="/app/config/config_5_plan.php"> Plan d'affaire </option>
                    <option value="/app/config/config_6_display.php"> Affichage </option>
                    <option value="/app/config/config_7_index.php"> Index & Pages Web </option>
                    <option value="/app/config/config_8_api.php"> API's, IA's et Réseaux Sociaux</option>
                    <option value="/app/config/config_9_update.php"> Mises à jour & Sécurité </option>
                    <option value="/app/config/config_10_license.php"> Licenses, politiques, conditions et sitemap </option>
                </select>
            </td>
		</tr>
	</table>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>

<div class='divMAIN' style="margin-top:50px;">  
    <h2>Hiérarchie des ressources humaines</h2>
    <div class='divSECTION'><div id="chart_div" style='display:inline-block;'></div>
        <br>
        <div class='divBOX'><span style='font-size:0.7em;width:45px;float:right;margin-top:-5px;padding:2px 5px;border-radius:5px;border:1px solid #777;background:#DDD;color:#444;'>id: <span id='txtPOSITION_ID'></span></span>
            Poste à ajouter/modifier/supprimer:
            <input id='txtPOSITION_FROM' type='text' style='display:none;'>
            <input id='txtPOSITION' type='text'>
            Description du poste
            <textarea id='txtPOSITION_DESC' rows='6'></textarea>
            Authorisations:
            <select id="selPOSITION_AUTH">
                <option disabled selected>Choisir un niveau</option>
                <option value="GES">Gestionnaire (GES)</option>
                <option value="ADM">Administrateur (ADM)</option>
                <option value="USR">Utilisateur (USR)</option>
                <option value="MIA">Master IA (MIA)</option>
                <option value="BOT">Robot (BOT)</option>
                <option value="AUD">Auditeur (AUD)</option>
                <option value="VST">Visiteur (VST)</option>
            </select>
            Supérieur hiérarchique:
            <select id="selPOSITION_PARENT">
                <option disabled selected>Choisir un supérieur</option>
                <?php
                    $sql = "SELECT *
                            FROM position				
                            ORDER BY auth,name";

                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["name"] . "'>" . $row["name"] . "</option>";
                        }
                    }
                    ?>
            </select>
            <div style='width:100%;display:inline-block;text-align:center;margin-top:10px;'>
                <button style='background-color:red;' onclick="delPOSITION();"><span class="material-icons">delete</span></button>
                <button onclick="updPOSITION();"><span class="material-icons">save</span></button>
                <button style='background-color:green;' onclick="newPOSITION();"><span class="material-icons">add</span></button>
                <button style='background-color:green;' onclick="setPOSITION();" title='Ouvertures'><span class="material-icons">assignment_ind</span></button>
            </div>
        </div>
    </div><br>
    <hr>
    <div class='divSECTION'>
        <h2>Variables d'environement</h2>
        <select id="selGENR" onchange="selectCONFIG();">
            <option selected>Choisir une configuration</option>
            <?php
                $sql = "SELECT DISTINCT kind
                        FROM config				
                        ORDER BY kind";

                $result = $dw3_conn->query($sql);
                if ($result->num_rows > 0) {	
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["kind"] . "'>" . $row["kind"] . "</option>";
                    }
                }
                ?>
        </select>
        <div id="selCODE" style="height:250px;overflow-y:scroll;overflow-x:none;">
        </div><hr>
        Code de configuration:
        <input id='txtCODE' type='text'>
        Valeur 1:
        <input id='txtDSC1' type='text'>
        Valeur 2:
        <input id='txtDSC2' type='text'>
        Valeur 3:
        <input id='txtDSC3' type='text'>
        Valeur 4:
        <input id='txtDSC4' type='text'>
        <br><br>
        <button style='background-color:red;' onclick="delCODE();"><span class="material-icons">delete</span></button>
        <button style='background-color:green;' onclick="addCODE();"><span class="material-icons">add</span></button>  
        <button onclick="updCODE();"><span class="material-icons">save</span></button>  
        <br><br>
    </div>
    <hr>
    <div class='divSECTION' style='max-width:600px;'>
        <h2>Applications</h2>
        <select id="selAPP" onchange="getAPP();">
            <option selected>Choisir une application</option>
            <?php
                $sql = "SELECT * FROM app WHERE id <> 29 ORDER BY name_fr ASC";
                $result = $dw3_conn->query($sql);
                if ($result->num_rows > 0) {	
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='". $row["id"] . "'>".$row["name_fr"] . "</option>";
                    }
                }
                ?>
        </select>
        <hr>
        Nom français:
        <input id='appNAME_FR' type='text'>
        Nom anglais:
        <input id='appNAME_EN' type='text'>
        Autorisation minimal (lors de la création d'un utilisateur):
        <select id='appAUTH'> 
            <option disabled value='' selected>Choisir une autorisation</option>
            <option value='GES'>Gestionnaire</option>
            <option value='ADM'>Administrateur</option>
            <option value='USR'>Utilisateur</option>
        </select>
        Ordre d'affichage:
        <input id='appSORT_NUMBER' type='text'>
        Icone:
        <input id='appICON' type='text'>
        Couleur:
        <input id='appCOLOR' type='color'>
        <br><br>
        <button onclick="updAPP();"><span class="material-icons">save</span></button>  
        <br><br>
    </div>
    <hr>
    <h2>Catégories de produits</h2> <i>Double-cliquez pour ouvrir/fermer</i>
    <div class='divSECTION' style=''>
        <div id="chart_div3" style='display:inline-block;max-width:100%;overflow-x:auto;'></div>
        <br>
        <div class='divBOX' style='box-shadow:none;vertical-align:top;'><span style='font-size:0.7em;width:45px;float:right;margin-top:-5px;padding:2px 5px;border-radius:5px;border:1px solid #777;background:#DDD;color:#444;'>id: <span id='txtCATEGORY_ID'></span></span>
            Nom Français:
            <input id='txtCATEGORY_FROM' type='text' style='display:none;'>
            <input id='txtCATEGORY' type='text'>
            Nom Anglais:
            <input id='txtCATEGORY_EN' type='text'>
            Lien Image:
            <input id='txtCATEGORY_IMG' type='text'>
            <img id='imgCATEGORY_IMG' style='width:100%;height:auto;'>
            <button onclick="rotate_cat_img('90');"><span class="material-icons">rotate_90_degrees_ccw</span></button>
            <button onclick="rotate_cat_img('-90');"><span class="material-icons">rotate_90_degrees_cw</span></button>
            <button class='blue' onclick="selCatImg();"><span class="material-icons">add_a_photo</span></button>
        </div>
        <div class='divBOX' style='box-shadow:none;vertical-align:top;'>
            Description Française:
            <textarea id='txtCATEGORY_DESC' rows='7'></textarea>
            Description Anglaise:
            <textarea id='txtCATEGORY_DESC_EN' rows='7'></textarea>
            Catégorie Parent:
            <select id="selCATEGORY_PARENT">
                <option disabled selected>Choisir une catégorie parent</option>
                <option value="">Catégorie premier niveau</option>
                <?php
                    $sql = "SELECT *
                            FROM product_category		
                            WHERE name_fr <> ''		
                            ORDER BY name_fr ;";
                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='". $row["name_fr"] . "'>" . $row["name_fr"] . "</option>";
                        }
                    }
                ?>
            </select> 
            <div style='width:100%;display:inline-block;text-align:center;margin-top:10px;'>
                <button class='red' onclick="delCATEGORY();"><span class="material-icons">delete</span></button>
                <button class='green' onclick="updCATEGORY();"><span class="material-icons">save</span></button>
                <button class='blue' onclick="newCATEGORY();"><span class="material-icons">add</span></button> 
            </div>
        </div>
    </div><br>
</div>

<div id='divUPLOAD_CAT' style='display:none;'>
    <form id='frmUPLOAD_CAT' method="post" enctype="multipart/form-data">
    <input type="file" name="fileToCat" id="fileToCat" onchange="document.getElementById('submitCAT').click();">    
    <input type="text" name="fileNameCat" id="fileNameCat" value='0'>
    <input type="submit" value="Upload Image" name="submit" id='submitCAT'>
    </form>
</div>

<div id="divEDIT" class="divEDITOR"></div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var POSITION_LIST = [<?php
                        $sql = "SELECT *
                                FROM position				
                                ORDER BY name";

                        $result = $dw3_conn->query($sql);
                        if ($result->num_rows > 0) {	
                            while($row = $result->fetch_assoc()) {
                                echo '["'. $row['name'] .'","' . $row['parent_name'] .'","' .$row['description'] . '","' .$row['id'] . '","' .$row['auth'] . '"],';
                            }
                        }
                    ?>];
var CATEGORY_LIST = [<?php
                        $sql = "SELECT *
                                FROM product_category				
                                ORDER BY name_fr";

                        $result = $dw3_conn->query($sql);
                        if ($result->num_rows > 0) {	
                            while($row = $result->fetch_assoc()) {
                                echo '["'. str_replace('&quot;','\"',$row['name_fr']) .'","' . $row['parent_name'] .'","' .str_replace('&quot;','\"',$row['description_fr']) . '","' .$row['img_url'] . '","'. str_replace('&quot;','\"',$row['name_en']) .'","'. str_replace('&quot;','\"',$row['description_en']) .'","'. $row['id'] .'"],';
                            }
                        }
                    ?>];
var dw3_file_replace = "unknow";
$(document).ready(function (){
    document.getElementById('config_select').value="/app/config/config_3_structure.php";
    google.charts.load('current', {packages:["orgchart"]});
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawChart3);
});

window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    window.location.reload();
  }
});

function selCatImg() {	
    dw3_file_replace = "unknow";
    var xmlhttp = new XMLHttpRequest();	
    xmlhttp.onreadystatechange = function() {	  
        if (this.readyState == 4 && this.status == 200) {			
            document.getElementById("divFADE").style.width = "100%";			
            document.getElementById("divMSG").style.display = "inline-block";			
            document.getElementById("divMSG").innerHTML = this.responseText;	  
        }	
    };		
    xmlhttp.open('GET', 'getCAT_IMG.php?KEY=' + KEY, true);				
    xmlhttp.send();	
}
function setIMG(img) {
    document.getElementById("txtCATEGORY_IMG").value = "/pub/upload/" + img;
    var irnd_num = Math.floor(Math.random() * 1000000);
    document.getElementById("imgCATEGORY_IMG").src = "/pub/upload/" + img +"?t="+irnd_num;
}


//CATEGORIES
function getCATEGORIES(){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        CATEGORY_LIST = JSON.parse(this.responseText);
        drawChart3();
	  }
	};
		xmlhttp.open('GET', 'getCATEGORIES.php?KEY=' + KEY , true);
		xmlhttp.send();
}
function updCAREER(careerID){
    var sSALARY_MIN = document.getElementById("carSALARY_MIN").value;
    var sRESP = document.getElementById("carRESP").value;
    var sHABI = document.getElementById("carHABI").value;
    var sQUAL = document.getElementById("carQUAL").value;
    var sEDUC = document.getElementById("carEDUC").value;
    var sEXPE = document.getElementById("carEXPE").value;
    var sEND = document.getElementById("carEND").value;
    
    var GRPBOX  = document.getElementById("carDOC");
    if (GRPBOX.selectedIndex != -1){
        var sDOC = GRPBOX.options[GRPBOX.selectedIndex].value;
    } else {
        var sDOC = "-1";
    }
    var GRPBOX  = document.getElementById("carACTIVE");
    var sACTIVE = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX  = document.getElementById("carSALARY_TYPE");
    var sSALARY_TYPE = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX  = document.getElementById("carTELECOMMUTE");
    var sTELECOMMUTE = GRPBOX.options[GRPBOX.selectedIndex].value;

    var sFULL_TIME = document.getElementById("carFULL_TIME").checked;
    var sPART_TIME = document.getElementById("carPART_TIME").checked;
    var sCONTRACTOR = document.getElementById("carCONTRACTOR").checked;
    var sTEMPORARY = document.getElementById("carTEMPORARY").checked;
    var sINTERN = document.getElementById("carINTERN").checked;
    var sVOLUNTEER = document.getElementById("carVOLUNTEER").checked;
    var sPER_DIEM = document.getElementById("carPER_DIEM").checked;
    var sOTHER = document.getElementById("carOTHER").checked;

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "" || this.responseText == "0"){
            closeEDITOR();
            addNotif("Mise à jour complétée.");
        } else {
            document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
        }
	  }
	};
		xmlhttp.open('GET', 'updCAREER.php?KEY=' + KEY 
                                        + '&ID=' + encodeURIComponent(careerID) 
                                        + '&v1=' + encodeURIComponent(sSALARY_MIN) 
                                        + '&v2=' + encodeURIComponent(sRESP)
                                        + '&v3=' + encodeURIComponent(sHABI)
                                        + '&v4=' + encodeURIComponent(sQUAL) 
                                        + '&v5=' + encodeURIComponent(sEDUC) 
                                        + '&v6=' + encodeURIComponent(sEXPE) 
                                        + '&v7=' + encodeURIComponent(sACTIVE) 
                                        + '&v8=' + encodeURIComponent(sSALARY_TYPE) 
                                        + '&v9=' + encodeURIComponent(sTELECOMMUTE) 
                                        + '&v10=' + encodeURIComponent(sFULL_TIME) 
                                        + '&v11='+ encodeURIComponent(sPART_TIME) 
                                        + '&v12='+ encodeURIComponent(sCONTRACTOR) 
                                        + '&v13='+ encodeURIComponent(sTEMPORARY) 
                                        + '&v14='+ encodeURIComponent(sINTERN) 
                                        + '&v15='+ encodeURIComponent(sVOLUNTEER) 
                                        + '&v16='+ encodeURIComponent(sPER_DIEM) 
                                        + '&v17='+ encodeURIComponent(sOTHER) 
                                        + '&v18='+ encodeURIComponent(sEND)
                                        + '&v19='+ encodeURIComponent(sDOC)
                                        , true);
		xmlhttp.send();
}
function updCATEGORY(){
    var sCAT_ID = document.getElementById("txtCATEGORY_ID").innerHTML.trim();
    var sCATEGORY_FROM = document.getElementById("txtCATEGORY_FROM").value;
    var sCATEGORY_TO = document.getElementById("txtCATEGORY").value;
    var sCATEGORY_IMG = document.getElementById("txtCATEGORY_IMG").value;
    var sDESC = document.getElementById("txtCATEGORY_DESC").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    var sDESC_EN = document.getElementById("txtCATEGORY_DESC_EN").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    var sNAME_EN = document.getElementById("txtCATEGORY_EN").value;
	var GRPBOX  = document.getElementById("selCATEGORY_PARENT");
    if (GRPBOX.selectedIndex > 0){
	    var sPARENT = GRPBOX.options[GRPBOX.selectedIndex].value;
    } else {
        var sPARENT = "";
    }

    if (sCATEGORY_TO == ""){
		addMsg("Veuillez entrer une nom de catégorie.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		return false;
    }

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "" || this.responseText == "0"){
            getCATEGORIES();
            addNotif("Mise à jour complétée.");
        } else {
            document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        }
	  }
	};
		xmlhttp.open('GET', 'updCATEGORY.php?KEY=' + KEY 
                                        + '&ID=' + encodeURIComponent(sCAT_ID) 
                                        + '&FROM=' + encodeURIComponent(sCATEGORY_FROM) 
                                        + "&TO=" + encodeURIComponent(sCATEGORY_TO) 
                                        + "&IMG=" + encodeURIComponent(sCATEGORY_IMG) 
                                        + "&PARENT=" + encodeURIComponent(sPARENT)
                                        + "&DESC=" + encodeURIComponent(sDESC)
                                        + "&DESC_EN=" + encodeURIComponent(sDESC_EN)
                                        + "&NAME_EN=" + encodeURIComponent(sNAME_EN)
                                        , true);
		xmlhttp.send();
}

function newCATEGORY(){
    var sCATEGORY = document.getElementById("txtCATEGORY").value;
    var sDESC = document.getElementById("txtCATEGORY_DESC").value;
    var sIMG = document.getElementById("txtCATEGORY_IMG").value;
    var sNAME_EN = document.getElementById("txtCATEGORY_EN").value;
    var sDESC_EN = document.getElementById("txtCATEGORY_DESC_EN").value;
	var GRPBOX  = document.getElementById("selCATEGORY_PARENT");
    if (GRPBOX.selectedIndex > 0){
	    var sPARENT = GRPBOX.options[GRPBOX.selectedIndex].value;
    } else {
        var sPARENT = "";
    }

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "" || this.responseText == "0"){
            getCATEGORIES();
            addNotif("Nouvelle catégorie ajoutée.");
        } else {
            document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        }

	  }
	};
		xmlhttp.open('GET', 'newCATEGORY.php?KEY=' + KEY 
                                        + "&CATEGORY=" + encodeURIComponent(sCATEGORY)
                                        + "&PARENT=" + encodeURIComponent(sPARENT)
                                        + "&DESC=" + encodeURIComponent(sDESC)
                                        + "&DESC_EN=" + encodeURIComponent(sDESC_EN)
                                        + "&NAME_EN=" + encodeURIComponent(sNAME_EN)
                                        + "&IMG=" + encodeURIComponent(sIMG)
                                        , true);
		xmlhttp.send();
}

function delCATEGORY(){
    var sCATEGORY = document.getElementById("txtCATEGORY").value;

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "" || this.responseText == "0"){
            getCATEGORIES();
            addNotif("Catégorie supprimée.");
        } else {
            document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        }
	  }
	};
		xmlhttp.open('GET', 'delCATEGORY.php?KEY=' + KEY 
                                        + "&CATEGORY=" + encodeURIComponent(sCATEGORY)
                                        , true);
		xmlhttp.send();
}

function rotate_cat_img(sDEG) {
    var sFN = document.getElementById("txtCATEGORY_IMG").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        var irnd_num = Math.floor(Math.random() * 1000000);
            document.getElementById("imgCATEGORY_IMG").src = sFN+"?t="+irnd_num;
            addNotif( this.responseText);
	  }
	};
		xmlhttp.open('GET', 'rotate_picture.php?KEY=' + KEY + '&FN=' + encodeURIComponent(sFN) + '&DEG=' + sDEG , true);
		xmlhttp.send();	
}

//POSITION
function drawChart() {
    document.getElementById('chart_div').innerHTML = "";
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Name');
	data.addColumn('string', 'Manager');
	data.addColumn('string', 'ToolTip');
	data.addColumn('string', 'id');
	data.addColumn('string', 'auth');

	// For each orgchart box, provide the name, manager, and tooltip to show.
	data.addRows(POSITION_LIST);

	// Create the chart.
	var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
	// Draw the chart, setting the allowHtml option to true for the tooltips.
	chart.draw(data, {allowHtml:true});
    google.visualization.events.addListener(chart, 'select', toggleDisplay);
    function toggleDisplay() {
        var selection = chart.getSelection();
        if (selection.length > 0) {
            //var position_id = data.getFormattedValue(selection[0].row, 3);
            var position_name = data.getFormattedValue(selection[0].row, 0);
            var position_parent = data.getFormattedValue(selection[0].row, 1);
            var position_description = data.getFormattedValue(selection[0].row, 2);
            var position_id = data.getFormattedValue(selection[0].row, 3);
            var position_auth = data.getFormattedValue(selection[0].row, 4);
            //var position_parent = data.getFormattedValue(selection[0].row,2);
            //var position_description = data.getFormattedValue(selection[0].row, 4);
            document.getElementById("txtPOSITION_FROM").value = position_name;
            document.getElementById("txtPOSITION").value = position_name;
            document.getElementById("txtPOSITION_DESC").value = position_description;
            document.getElementById("selPOSITION_PARENT").value = position_parent;
            document.getElementById("selPOSITION_AUTH").value = position_auth;
            document.getElementById("txtPOSITION_ID").innerHTML = position_id;
        } else {
            document.getElementById("txtPOSITION_FROM").value = "";
            document.getElementById("txtPOSITION").value = "";
            document.getElementById("txtPOSITION_DESC").value = "";
            document.getElementById('selPOSITION_PARENT').value = "";
            document.getElementById('selPOSITION_AUTH').value = "VIS";
            document.getElementById("txtPOSITION_ID").innerHTML = "";
        }

    }
}
function getPOSITIONS(){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        POSITION_LIST = JSON.parse(this.responseText);
        drawChart();
	  }
	};
		xmlhttp.open('GET', 'getPOSITIONS.php?KEY=' + KEY , true);
		xmlhttp.send();
}
function updPOSITION(){
    var sPOSTE_ID = document.getElementById("txtPOSITION_ID").innerHTML.trim();
    var sPOSTE_FROM = document.getElementById("txtPOSITION_FROM").value;
    var sPOSTE_TO = document.getElementById("txtPOSITION").value;
    var sDESC = document.getElementById("txtPOSITION_DESC").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
	var GRPBOX  = document.getElementById("selPOSITION_PARENT");
    if (GRPBOX.selectedIndex > 0){
	    var sPARENT = GRPBOX.options[GRPBOX.selectedIndex].value;
    } else {
        var sPARENT = "";
    }
	var GRPBOX  = document.getElementById("selPOSITION_AUTH");
    if (GRPBOX.selectedIndex > 0){
	    var sAUTH = GRPBOX.options[GRPBOX.selectedIndex].value;
    } else {
        var sAUTH = "VIS";
    }

    if (sPOSTE_TO == ""){
		addMsg("Veuillez entrer un titre de poste.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		return false;
    }

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "" || this.responseText == "0"){
            getPOSITIONS();
            addNotif("Le poste a été mis à jours.");
        } else {
            document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        }
	  }
	};
		xmlhttp.open('GET', 'updPOSITION.php?KEY=' + KEY 
                                        + '&ID=' + encodeURIComponent(sPOSTE_ID) 
                                        + '&FROM=' + encodeURIComponent(sPOSTE_FROM) 
                                        + "&TO=" + encodeURIComponent(sPOSTE_TO) 
                                        + "&PARENT=" + encodeURIComponent(sPARENT)
                                        + "&AUTH=" + encodeURIComponent(sAUTH)
                                        + "&DESC=" + encodeURIComponent(sDESC)
                                        , true);
		xmlhttp.send();
}
function setPOSITION(){
    var sPOSTE_ID = document.getElementById("txtPOSITION_ID").innerHTML.trim();
    if (sPOSTE_ID == ""){
		addMsg("Veuillez choisir un poste à configurer.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		//document.getElementById("txtCATEGORY_ID").style.boxShadow = "5px 10px 15px red";
		return false;
    }
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divEDIT").style.display = "inline-block";
        document.getElementById("divEDIT").innerHTML = this.responseText;
        dragElement(document.getElementById('divEDIT'));
        closeMSG();
        document.getElementById("divFADE").style.width = "100%";
        document.getElementById("divFADE").style.opacity = "0.6";
        document.getElementById("divFADE").style.display = "inline-block";	

	  }
	};
	xmlhttp.open('GET', 'setPOSITION.php?KEY=' + KEY + "&ID=" + sPOSTE_ID, true);
	xmlhttp.send();
    document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";	
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}
function newPOSITION(){
    var sPOSTE = document.getElementById("txtPOSITION").value;
    var sDESC = document.getElementById("txtPOSITION_DESC").value;
	var GRPBOX  = document.getElementById("selPOSITION_PARENT");
    if (GRPBOX.selectedIndex > 0){
	    var sPARENT = GRPBOX.options[GRPBOX.selectedIndex].value;
    } else {
        var sPARENT = "";
    }
	var GRPBOX  = document.getElementById("selPOSITION_AUTH");
    if (GRPBOX.selectedIndex > 0){
	    var sAUTH = GRPBOX.options[GRPBOX.selectedIndex].value;
    } else {
        var sAUTH = "";
    }

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) { 
        if (this.responseText == "" || this.responseText == "0"){
            getPOSITIONS();
            addNotif("Nouveau poste ajouté.");
        } else {
            document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        }
	  }
	};
		xmlhttp.open('GET', 'newPOSITION.php?KEY=' + KEY 
                                        + "&POSTE=" + encodeURIComponent(sPOSTE)
                                        + "&PARENT=" + encodeURIComponent(sPARENT)
                                        + "&AUTH=" + encodeURIComponent(sAUTH)
                                        + "&DESC=" + encodeURIComponent(sDESC)
                                        , true);
		xmlhttp.send();
}
function delPOSITION(){
    var sPOSTE = document.getElementById("txtPOSITION").value;

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getPOSITIONS();
	  }
	};
		xmlhttp.open('GET', 'delPOSITION.php?KEY=' + KEY 
                                        + "&POSTE=" + encodeURIComponent(sPOSTE)
                                        , true);
		xmlhttp.send();
}
//CATEGORIES
function drawChart3() {
    document.getElementById('chart_div3').innerHTML = "";
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Name_fr');
	data.addColumn('string', 'Parent');
	data.addColumn('string', 'Desc_fr');
	data.addColumn('string', 'Img');
	data.addColumn('string', 'Name_en');
	data.addColumn('string', 'Desc_en');
	data.addColumn('string', 'id');
	data.addRows(CATEGORY_LIST);

    //draw chart
	var chart3 = new google.visualization.OrgChart(document.getElementById('chart_div3'));
	chart3.draw(data, {allowHtml:true, allowCollapse:true});
    //collapse all
/*     for (var i = data.getNumberOfRows() - 1; i >= 0; i--) {
      // determine if node has children
      if (chart3.getChildrenIndexes(i).length > 0) {
        // collapse row
        chart3.collapse(i, true);
      }
    } */
    //click event
    google.visualization.events.addListener(chart3, 'select', toggleDisplay3);
    function toggleDisplay3() {
        var selection = chart3.getSelection();
        if (selection.length > 0) {
            var category_name = data.getFormattedValue(selection[0].row, 0);
            var category_parent = data.getFormattedValue(selection[0].row, 1);
            var category_description = data.getFormattedValue(selection[0].row, 2);
            var category_img = data.getFormattedValue(selection[0].row, 3);
            var category_name_en = data.getFormattedValue(selection[0].row, 4);
            var category_description_en = data.getFormattedValue(selection[0].row, 5);
            var category_id = data.getFormattedValue(selection[0].row, 6);
            document.getElementById("txtCATEGORY_FROM").value = category_name;
            document.getElementById("txtCATEGORY").value = category_name;
            document.getElementById("txtCATEGORY_EN").value = category_name_en;
            document.getElementById("txtCATEGORY_IMG").value = category_img;
            var irnd_num = Math.floor(Math.random() * 1000000);
            document.getElementById("imgCATEGORY_IMG").src = category_img+"?t="+irnd_num;
            document.getElementById("txtCATEGORY_DESC").value = category_description.replaceAll("<br>","\n");
            document.getElementById("txtCATEGORY_DESC_EN").value = category_description_en.replaceAll("<br>","\n");
            document.getElementById("selCATEGORY_PARENT").value = category_parent;
            document.getElementById("txtCATEGORY_ID").innerHTML = category_id;
        } else {
            document.getElementById("txtCATEGORY_FROM").value = "";
            document.getElementById("txtCATEGORY").value = "";
            document.getElementById("txtCATEGORY_EN").value = "";
            document.getElementById("txtCATEGORY_DESC").value = "";
            document.getElementById("txtCATEGORY_DESC_EN").value = "";
            document.getElementById("txtCATEGORY_IMG").value = "";
            document.getElementById('selCATEGORY_PARENT').value = "";
            document.getElementById('txtCATEGORY_ID').innerHTML = "";
        }

    }
}



//ajout dun code de configuration
function addCODE(){
	var GRPBOX  = document.getElementById("selGENR");
	var sGENR  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sCODE = document.getElementById("txtCODE").value;
	var sDSC1 = document.getElementById("txtDSC1").value;
	var sDSC2 = document.getElementById("txtDSC2").value;
	var sDSC3 = document.getElementById("txtDSC3").value;
	var sDSC4 = document.getElementById("txtDSC4").value;

	//verifier si une config est choisi
	if(GRPBOX.selectedIndex <= 0){
		addMsg("Veuillez choisir un type de configuration à ajouter.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		document.getElementById("selGENR").style.boxShadow = "5px 10px 15px red";
		return false;
	}
	document.getElementById("selGENR").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";

	//verifier si un code est entré
	if(sCODE.trim() == ""){
		addMsg("Veuillez entrer un code de configuration.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		document.getElementById("txtCODE").style.boxShadow = "5px 10px 15px red";
		return false;
	}
	document.getElementById("txtCODE").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";


	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		addNotif(this.responseText);
		selectCONFIG();
	  }
	};

		xmlhttp.open('GET', 'addCODE.php?KEY=' + KEY 
										+ '&GENR=' 	+ sGENR
										+ '&CODE=' 	+ encodeURIComponent(sCODE)
										+ '&DSC1=' 	+ encodeURIComponent(sDSC1)
										+ '&DSC2=' 	+ encodeURIComponent(sDSC2)
										+ '&DSC3=' 	+ encodeURIComponent(sDSC3)
										+ '&DSC4=' 	+ encodeURIComponent(sDSC4),
										true);
		xmlhttp.send();
        //document.getElementById("txtCODE").value = "";
        //document.getElementById("txtDSC1").value = "";
        //document.getElementById("txtDSC2").value = "";
}


//maj app params
function updAPP(){
	var GRPBOX  = document.getElementById("selAPP");
	var sID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("appAUTH");
	var sAUTH  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sNAME_FR = document.getElementById("appNAME_FR").value;
	var sNAME_EN = document.getElementById("appNAME_EN").value;
	var sSORT = document.getElementById("appSORT_NUMBER").value;
	var sICON = document.getElementById("appICON").value;
	var sCOLOR = document.getElementById("appCOLOR").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		addNotif("Mise à jour complété.");
        document.getElementById("divFADE2").style.opacity = "0";
        document.getElementById("divFADE2").style.display = "none";	
        document.getElementById("divMSG").style.display = "none";
	  }
	};

    xmlhttp.open('GET', 'updAPP.php?KEY=' + KEY 
                                    + '&ID=' + sID
                                    + '&AUTH=' + sAUTH
                                    + '&NAME_FR=' + encodeURIComponent(sNAME_FR)
                                    + '&NAME_EN=' + encodeURIComponent(sNAME_EN)
                                    + '&SORT=' + encodeURIComponent(sSORT)
                                    + '&ICON=' + encodeURIComponent(sICON)
                                    + '&COLOR=' + encodeURIComponent(sCOLOR),
                                    true);
    xmlhttp.send();
    document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";	
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}
function getAPP(){
    var GRPBOX  = document.getElementById("selAPP");
	var sID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        const response = JSON.parse(this.responseText);
        document.getElementById("appAUTH").value = response.auth;
        document.getElementById("appNAME_FR").value = response.name_fr;
        document.getElementById("appNAME_EN").value= response.name_en;
        document.getElementById("appSORT_NUMBER").value= response.sort_number;
        document.getElementById("appICON").value= response.icon;
        document.getElementById("appCOLOR").value= response.color;
        document.getElementById("divFADE").style.opacity = "0";
        document.getElementById("divFADE").style.display = "none";	
        document.getElementById("divMSG").style.display = "none";
	  }
	};
    xmlhttp.open('GET', 'getAPP.php?KEY=' + KEY + '&ID=' 	+ sID, true);
    xmlhttp.send();
    document.getElementById("divFADE").style.opacity = "0.6";
    document.getElementById("divFADE").style.display = "inline-block";	
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}

//ajout dun code de configuration
function updCODE(){
	var GRPBOX  = document.getElementById("selGENR");
	var sGENR  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sCODE = document.getElementById("txtCODE").value;
	var sDSC1 = document.getElementById("txtDSC1").value;
	var sDSC2 = document.getElementById("txtDSC2").value;
	var sDSC3 = document.getElementById("txtDSC3").value;
	var sDSC4 = document.getElementById("txtDSC4").value;

	//verifier si une config est choisi
	if(GRPBOX.selectedIndex <= 0){
		addMsg("Veuillez choisir un type de configuration à modifier.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		document.getElementById("selGENR").style.boxShadow = "5px 10px 15px red";
		return false;
	}
	document.getElementById("selGENR").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";

	//verifier si un code est entré
	if(sCODE.trim() == ""){
		addMsg("Veuillez entrer un code de configuration.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		document.getElementById("txtCODE").style.boxShadow = "5px 10px 15px red";
		return false;
	}
	document.getElementById("txtCODE").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";


	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		addNotif(this.responseText);
		selectCONFIG();
	  }
	};

		xmlhttp.open('GET', 'updCODE.php?KEY=' + KEY 
										+ '&GENR=' 	+ sGENR
										+ '&CODE=' 	+ encodeURIComponent(sCODE)
										+ '&DSC1=' 	+ encodeURIComponent(sDSC1)
										+ '&DSC2=' 	+ encodeURIComponent(sDSC2)
										+ '&DSC3=' 	+ encodeURIComponent(sDSC3)
										+ '&DSC4=' 	+ encodeURIComponent(sDSC4),
										true);
		xmlhttp.send();
        //document.getElementById("txtCODE").value = "";
        //document.getElementById("txtDSC1").value = "";
        //document.getElementById("txtDSC2").value = "";
}
//suppression dun code de configuration
function delCODE(){
	var GRPBOX  = document.getElementById("selGENR");
	var sGENR  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sCODE = document.getElementById("txtCODE").value;

	//verifier si une config est choisi
	if(GRPBOX.selectedIndex <= 0){
		addMsg("Suppression invalide.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		document.getElementById("selGENR").style.boxShadow = "5px 10px 15px red";
		return false;
	}
	document.getElementById("selGENR").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";

	//verifier si un code est entré
	if(sCODE.trim() == ""){
		addMsg("Suppression invalide.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		document.getElementById("txtCODE").style.boxShadow = "5px 10px 15px red";
		return false;
	}
	document.getElementById("txtCODE").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		addNotif(this.responseText);
		selectCONFIG();
	  }
	};

		xmlhttp.open('GET', 'delCODE.php?KEY=' + KEY 
										+ '&GENR=' 	+ sGENR
										+ '&CODE=' 	+ sCODE,
										true);
		xmlhttp.send();
        document.getElementById("txtCODE").value = "";
        document.getElementById("txtDSC1").value = "";
        document.getElementById("txtDSC2").value = "";
}
//selection dune configuration pour modification
function selectCONFIG(){
	var GRPBOX  = document.getElementById("selGENR");
	var sGENR  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("selCODE").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'selGENR.php?KEY=' + KEY 
										+ '&GENR=' 	+ sGENR,
										true);
		xmlhttp.send();
        document.getElementById("txtCODE").value = "";
        document.getElementById("txtDSC1").value = "";
        document.getElementById("txtDSC2").value = "";
        document.getElementById("txtDSC3").value = "";
        document.getElementById("txtDSC4").value = "";
}

//selection dun code de configuration pour modification
function selectCODE(sCODE){
	var GRPBOX  = document.getElementById("selGENR");
	var sGENR  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        const obj = JSON.parse(this.responseText);
        document.getElementById("txtCODE").value = obj.CODE;
        document.getElementById("txtDSC1").value = obj.DSC1;
        document.getElementById("txtDSC2").value = obj.DSC2;
        document.getElementById("txtDSC3").value = obj.DSC3;
        document.getElementById("txtDSC4").value = obj.DSC4;
	  }
	};

		xmlhttp.open('GET', 'selCODE.php?KEY=' + KEY 
										+ '&CODE=' 	+ sCODE
                                        + '&GENR=' 	+ sGENR,
										true);
		xmlhttp.send();
}

$('#frmUPLOAD_CAT').on('submit',function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    if ($('#fileToCat')[0].files[0] == ""){return;}
    sendUPLOAD_CAT();
});

function sendUPLOAD_CAT(){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
    data = new FormData();
    data.append('fileToCat', $('#fileToCat')[0].files[0]);
    data.append('fileNameCat', document.getElementById("fileNameCat").value);
    var fileInput = document.getElementById('fileToCat');
    $.ajax({
        type : 'post',
        url : 'upload_cat_img.php?KEY=<?php echo $KEY;?>&REPLACE='+dw3_file_replace,
        data : data,
        dataTYpe : 'multipart/form-data',
        processData: false,
        contentType: false, 
        beforeSend : function(){
            //document.getElementById("divFADE").style.display = "inline-block";
            //document.getElementById("divFADE").style.opacity = "0.6";
        },
        success : function(response){
                if (response.substring(0, 7) == "Erreur:"){
                    document.getElementById("divMSG").innerHTML = response + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                    fileInput.value = null;
                } else if (response == "ErrX"){
                    document.getElementById("divMSG").style.display = "inline-block";
                    document.getElementById("divMSG").innerHTML = "Le fichier est déjà existant, voulez-vous le conserver ou le remplacer?<div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>undo</span> Conserver</button> <button onclick=\"closeMSG();dw3_file_replace='yes';sendUPLOAD_CAT();\"><span class='material-icons' style='vertical-align:middle;'>published_with_changes</span> Remplacer</button>";
                    var filename = document.getElementById("fileToCat").value.replace(/^.*[\\/]/, '');
                    document.getElementById("txtCATEGORY_IMG").value = "/pub/upload/"+filename;
                    var irnd_num = Math.floor(Math.random() * 1000000);
                    document.getElementById("imgCATEGORY_IMG").src = "/pub/upload/"+filename+"?t="+irnd_num;
                } else {
                    addNotif("Image transférée.");
                    closeMSG();
                    document.getElementById("txtCATEGORY_IMG").value = "/pub/upload/" + response;
                    document.getElementById("imgCATEGORY_IMG").src = "/pub/upload/"+response;
                    fileInput.value = null;
                }
        }
    });

}



</script>
</body>
</html>
<?php $dw3_conn->close();exit(); ?>
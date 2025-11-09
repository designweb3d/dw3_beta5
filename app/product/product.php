<?php /**
 +---------------------------------------------------------------------------------+
 | DW3 PME Kit BETA                                                                |
 | Version 0.6                                                                    |
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
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php'; 
?>

<div id='divHEAD'>
    <table style="width:100%;margin:0px;white-space:nowrap;">
		<tr style="margin:0px;padding:0px;">
			<td width="40"><button style="margin:0px 2px 0px 2px;padding:8px;font-size:0.8em;" onclick="openFILTRE();"><span class="material-icons">filter_alt</span></button></td>
			<td width="*" style="margin:0px;padding:0px;">
				<input type="search" onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" oninput="getPRDS('',LIMIT);" placeholder="<?php echo $APNAME; ?>.." title="<?php echo $dw3_lbl["RECH"];?>">
			</td>
			<td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
				<?php if($APREAD_ONLY == false) { ?><button class='blue' style="margin:0px 2px 0px 2px;padding:8px;" onclick="clearNEW();openNEW();"><span class="material-icons">add</span></button> <?php } ?>
				<button class='grey' style="margin:0px 2px 0px 2px;padding:8px;" class='grey' onclick="openPARAM();"><span class="material-icons">settings</span></button>
			</td>
		</tr>
	</table>
</div>
<div id='product_loading' style='box-shadow:0px 0px 5px 5px rgba(0,0,0,0.2);margin:90px 0px;display:inline-block;border-radius:10px;background:#FFF;'><img src='/pub/img/load/<?php echo $CIE_LOAD; ?>' style='border-radius:10px;max-width:75px;height:auto;margin:10px;'></div>
<div id="divNEW" class="divEDITOR" style='max-width:400px;'>
	<div id='divNEW_HEADER' class='dw3_form_head'>
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'><?php echo $dw3_lbl["NEW_PRD"];?></div></h3>
		<button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div> <div style='position:absolute;top:40px;left:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>
	    <img id='imgNEW_PRD' style='display:none;width:300px;height:auto;' src='/pub/img/dw3/nd.png'><br>
        <div class="divBOX">Nom français:
            <input id="newNOM_FR" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Nom anglais:
            <input id="newNOM_EN" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Code barre / UPC:
            <input id="newUPC" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX"><?php echo $dw3_lbl["CAT"];?>:
            <select id='newCAT'>
            <option selected disabled>Choisir la catégorie principale</option>
                <?php
                    $sql = "SELECT *
                            FROM product_category 
                            ORDER BY name_fr
                            LIMIT 100";
                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id"]  . "'>" . $row["name_fr"]  . "</option>";
                        }
                    }
                ?>
                <option value=''><?php echo $dw3_lbl["NONE"];?></option>
            </select>
        </div>
        <div class='divBOX'><b>Type de facturation</b>:
            <select id='newBILLING'>
                <option disabled style="text-align:center;">Produit avec inventaire</option>
                <option selected value="">Non défini</option>
                <option value="FINAL">Facturé une fois, livré une fois le paiment reçu.</option>
                <option value="LOCATION">Location (Produit unique avec no de série)</option>
                <option disabled style="text-align:center;">Service ou produit numérique</option>
                <option value="SERVICE">Service divers</option>
                <option value="ACCES">Droit d'accès permanent (ou jusqu'à résiliation du contrat)</option>
                <option disabled style='text-align:center;'>Abonnements</option>
                <option value="HEBDO">Abonnement et paiements hebdomadaires</option>
                <option value="MENSUEL">Abonnement et paiements mensuel</option>
                <option value="ANNUEL">Abonnement et paiments annuel</option>
                <option disabled style='text-align:center;'>Financement</option>
                <option value="DECOMPTE">Droit d'accès quantifié</option>
                <option value="FINANCE1">Livré et payé en 1 mois</option>
                <option value="FINANCE3">Livré et payé en 3 mois</option>
                <option value="FINANCE6">Livré et payé en 6 mois</option>
                <option value="FINANCE12">Livré et payé en 12 mois</option>
                <option value="FINANCE24">Livré et payé en 24 mois</option>
                <option value="FINANCE36">Livré et payé en 36 mois</option>
                <option value="FINANCE48">Livré et payé en 48 mois  (4 ans)</option>
                <option value="FINANCE60">Livré et payé en 60 mois (5 ans)</option>
                <option value="FINANCE72">Livré et payé en 72 mois (6 ans)</option>
            </select>
        </div>
        <div class="divBOX" style='min-height:25px;'>
            <div style='padding:5px;position:absolute;width:100%;display:inline-block;cursor:pointer;vertical-align:middle;' onclick='document.getElementById("newTO_STRIPE").focus();document.getElementById("newTO_STRIPE").click();'>
                Associer à Stripe:</div>
            <div style='float:right;padding-right:5px;vertical-align:middle;'>
                <input id='newTO_STRIPE' type='checkbox' style='margin-top:5px;'></div>
        </div>	
	</div><div id='divNEW_FOOT'>
		<button class="grey" onclick="closeNEW();"><span class="material-icons">cancel</span><?php echo $dw3_lbl["CANCEL"];?></button>
		<button class="blue" onclick="newPRD();"><span class="material-icons">add</span><?php echo $dw3_lbl["CREATE"].' & '.$dw3_lbl["MODIFY"];?></button>
	</div>
</div>

<div id='divUPLOAD_PRD' style='display:none;'>
    <form id='frmUPLOAD_PRD' action="upload.php?KEY=<?php echo $KEY;?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToPrd" id="fileToPrd" onchange="document.getElementById('submitPRD').click();">    
    <input type="text" name="fileNamePrd" id="fileNamePrd" value='0'>
    <input type="submit" value="Upload Image" name="submit" id='submitPRD'>
    </form>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>
<div id='divMAIN' class='divMAIN' style="margin:50px 0px 40px 0px;"></div>
<div id='divEDIT' class='divEDITOR'></div>

<div id="divSEL_STORAGE" class="divSELECT" style='min-width:330px;min-height:90%;'><input id='whySEL_STORAGE' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_STORAGE_HEADER" class='dw3_form_head'><h3>
	    Sélection ID </h3>
        <button onclick='closeSEL_STORAGE();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selSTORAGE" oninput="getSEL_STORAGE('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_STORAGE_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un fournisseur.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class="grey" onclick="closeSEL_STORAGE();getElementById('divSEL_STORAGE_DATA').innerHTML='Inscrire votre recherche pour trouver un fournisseur.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>
<div id="divSEL_SUPPLIER" class="divSELECT" style='min-width:330px;min-height:90%;'>
    <div id="divSEL_SUPPLIER_HEADER" class='dw3_form_head'><h3>
	    Sélection ID </h3>
        <button onclick='closeSEL_SUPPLIER();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selSUPPLIER" oninput="getSEL_SUPPLIER('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_SUPPLIER_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un fournisseur.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class='grey' onclick="closeSEL_SUPPLIER();getElementById('divSEL_SUPPLIER_DATA').innerHTML='Inscrire votre recherche pour trouver un fournisseur.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id='divFILTRE'>
<h3><?php echo $dw3_lbl["FILTER"];?></h3>
		<table style='width:100%'>
		<tr><td><?php echo $dw3_lbl["STAT"];?> </td><td width='*'>
		<select id='selSTAT'>
            <option selected value=''>Tous</option>
			<option value='0'>Disponible</option>
			<option value='1'>Inactif temporairement</option>
			<option value='2'>En rappel</option>
			<option value='3'>BETA Test</option>
			<option value='4'>À venir bientôt</option>
			<option value='5'>Discontinué</option>
			<option value='6'>En production</option>
		</select></td></tr>
		<tr><td style='vertical-align:top;'><?php echo $dw3_lbl["FRN1"];?> </td><td>
		<select id='selFRN1' size="7" style="background:#ddd;">
        <option selected  value=''><?php echo $dw3_lbl["ALL"];?></option>
			<?php
				$sql = "SELECT DISTINCT(supplier_id), B.company_name as frNOM, B.id as frID
						FROM product A
                        LEFT JOIN supplier B ON A.supplier_id = B.id
						WHERE B.stat = 0
						ORDER BY frNOM
						LIMIT 100";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["frID"]  . "'>" . $row["frNOM"]  . "</option>";
					}
				}
			?>
		</select></td></tr>
		<tr><td style='vertical-align:top;'>Catégories utilisés </td><td>
		<select id='selCAT' size="7" style="background:#ddd;">
        <option selected value=''><?php echo $dw3_lbl["ALL"];?></option>
			<?php
				$sql = "SELECT DISTINCT(category_id), B.name_fr AS catNAME, B.id AS catID
						FROM product A
						LEFT JOIN product_category B ON A.category_id = B.id
                        WHERE  B.name_fr <> ''
						ORDER  BY catNAME
						LIMIT 100";
				$result = $dw3_conn->query($sql);
				if ($result->num_rows > 0) {	
					while($row = $result->fetch_assoc()) {
						echo "<option value='" . $row["catID"]  . "'>" . $row["catNAME"]  . "</option>";
					}
				}
			?>
		</select></td></tr>
        </table><br>
		<div style='width:100%;text-align:center;'><button class='grey' onclick="closeFILTRE();"><span class="material-icons">cancel</span> Annuler</button><button onclick="closeFILTRE();getPRDS('',LIMIT);"><span class="material-icons">filter_alt</span> Filtrer</button></div>
</div>

<div id="gal2_modal" class="gal2_modal" onclick='dw3_gal2_close()'>
  <div id="gal2_caption"></div>
  <span class="gal2_close" onclick='dw3_gal2_close()'>&times;</span>
  <img class="gal2_modal-content" id="gal2_model_img">
</div>


<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;">
    <div id='divPARAM_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);color:white;'>Paramètres de l'application</h2>
        <button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div>
    <div class='dw3_form_data' id="divPARAM_DATA"></div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,1));'>
        <button class='blue' onclick='resetPRM()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>restart_alt</span></button>
        <button class='grey' onclick='closeEDITOR()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Annuler</button>
        <button class='green' onclick='updPRM();' style='margin:0px 10px 0px 2px;'><span class='material-icons'>save</span> Enregistrer</button>
    </div>
</div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
LIMIT = '12';
var dw3_file_replace = "unknow";

$(document).ready(function ()
    {
		var body = document.body,
		html = document.documentElement;
		var height = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );
		LIMIT = Math.floor((height-176)/51);				   
        //setTimeout(function () {
                getPRDS("",LIMIT);
            //}, 1500);
		
        dragElement(document.getElementById('divPARAM'));
        dragElement(document.getElementById('divNEW'));
        dragElement(document.getElementById('divSEL_STORAGE'));
        dragElement(document.getElementById('divSEL_SUPPLIER'));
        
        $('#frmUPLOAD_PRD').on('submit',function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            if ($('#fileToPrd')[0].files[0] == ""){return;}
            sendUPLOAD_PRD();
        });
});

function sendUPLOAD_PRD(){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
    data = new FormData();
    var fileInput = document.getElementById('fileToPrd'); 
    data.append('fileToPrd', $('#fileToPrd')[0].files[0]);
    data.append('fileNamePrd', document.getElementById("fileNamePrd").value); //filename without .&extention
    $.ajax({
        type : 'post',
        url : 'upload.php?KEY=<?php echo $KEY;?>&REPLACE='+dw3_file_replace,
        data : data,
        dataTYpe : 'multipart/form-data',
        processData: false,
        contentType: false, 
        beforeSend : function(){
            document.getElementById("divFADE").style.display = "inline-block";
            document.getElementById("divFADE").style.opacity = "0.6";
        },
        success : function(response){
            if(response== "ErrX"){
                document.getElementById("divMSG").style.display = "inline-block";
                document.getElementById("divMSG").innerHTML = "Le fichier est déjà existant, voulez-vous le conserver ou le remplacer?<div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>undo</span> Conserver</button> <button class='blue' onclick=\"closeMSG();dw3_file_replace='yes';sendUPLOAD_PRD();\"><span class='material-icons' style='vertical-align:middle;'>published_with_changes</span> Remplacer</button>";
            } else {
                closeMSG();
                getFILES(document.getElementById("fileNamePrd").value);
                addNotif(response);
                fileInput.value = null;
                closeMSG();
            }
        }
    });
}

var active_input;
function addChar(char){
	if (active_input!=""){
		var textarea = document.getElementById(active_input);
		var start = textarea.selectionStart;
    	var finish = textarea.selectionEnd;
    	//var sel = textarea.value.substring(start, finish);
		textarea.value = textarea.value.substring(0, start) + char.replace(/<br\s*[\/]?>/gi, "\n") + textarea.value.substring(finish,textarea.value.length);
		textarea.focus();
		//alert(textarea.value);
		if (char == "<br>"){
			textarea.selectionStart = start + 1;
		}else{
			textarea.selectionStart = start + char.toString().length;
		}
		textarea.selectionEnd = textarea.selectionStart;
		//textarea.blur()
        //textarea.focus()
	}
}

//SELECTION STORAGE
function getSEL_STORAGE(sS) {
	if(sS==""){sS = document.getElementById("selSTORAGE").value.trim();}
    why = document.getElementById("whySEL_STORAGE").value.trim();
    selprod = document.getElementById("currentPRD").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_STORAGE_DATA").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getSEL_STORAGE.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) + "&why=" + why+ "&SP=" + selprod, true);
    xmlhttp.send();
}
function openSEL_STORAGE(why) {
    document.getElementById('divSEL_STORAGE').style.display = "inline-block";
    document.getElementById('whySEL_STORAGE').value = why;
    getSEL_STORAGE('');
}
function closeSEL_STORAGE() {
    document.getElementById('divSEL_STORAGE').style.display = "none";
}
function validateSTORAGE(sID,why) {
    //var elNEW =  document.getElementById('newSTORAGE_ID');
    //if (typeof(elNEW) != 'undefined' && elNEW != null && why == "NEW") {elNEW.value = sID;}
    //var elUPD =  document.getElementById('rPRODUCT_ID');
    //if (typeof(elUPD) != 'undefined' && elUPD != null && why == "UPD") {elUPD.value = prID;}
    if (why =="EXPORT"){
        document.getElementById('prSTORAGE_EXPORT').value = sID;
    } else if (why =="IMPORT"){
        document.getElementById('prSTORAGE_IMPORT').value = sID; 
    } 
    closeSEL_STORAGE();
}
//SELECTION SUPPLIER
function getSEL_SUPPLIER(sS) {
	if(sS==""){sS = document.getElementById("selSUPPLIER").value.trim();}
    selprod = document.getElementById("currentPRD").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_SUPPLIER_DATA").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getSEL_SUPPLIER.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) + "&SP=" + selprod, true);
    xmlhttp.send();
}
function openSEL_SUPPLIER() {
    document.getElementById('divSEL_SUPPLIER').style.display = "inline-block";
    getSEL_SUPPLIER('');
}
function closeSEL_SUPPLIER() {
    document.getElementById('divSEL_SUPPLIER').style.display = "none";
}
function validateSUPPLIER(sID, sNAME) {
    document.getElementById('prFRN1').value = sID; 
    document.getElementById('prFRN_NAME').value = sNAME; 
    closeSEL_SUPPLIER();
}

function clearNEW() {
    document.getElementById('newNOM_FR').value = "";
    document.getElementById('newNOM_EN').value = "";
    document.getElementById('newUPC').value = "";
    document.getElementById('newBILLING').value = "";
}
function openPARAM() {
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

function deletePRD(prID) {
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "1";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"];?><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"];?></button> <button class='red' onclick='delPRD(" + prID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"];?></button>";
}
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

function makePDF() {
	var sLST = "";
	var frmPRD  = document.getElementById("frmPRD");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmPRD.elements.length; i++ ) 
	{
		if (frmPRD.elements[i].type == 'checkbox')
		{
			if (frmPRD.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","} else { sLST = "("; }
				sLST += sVIRGULE + frmPRD.elements[i].value ;
			}
		}
	}	
	if (sLST == ""){
        document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "1";
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["ERR_SEL1"];?><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	} else { sLST += ")"; }

    window.open('makePDF.php?KEY=' + KEY + '&LST='  + sLST ,'_blank'); 
}

function calcPR_TX(){
    var sTAX_PROV = 0;
    var sTAX_PROV2 = 0;
    var sTAX_PROV3 = 0;
    var sTAX_FED = 0;
    var sTAX_FED2 = 0;
    var sTAX_FED3 = 0;
    var sPRICE_TX = 0;
    var sPRICE = document.getElementById("prPRIX_VTE").value;
    var sPRICE2 = document.getElementById("prPRIX_VTE2").value;
    var sPRICE3 = document.getElementById("prPROMO_PRIX").value;

    if (document.getElementById("prTAX_FED").checked == true){
        sTAX_FED = sPRICE  * (5/100);
        sTAX_FED = sTAX_FED.toFixed(2);
        sTAX_FED2 = sPRICE2  * (5/100);
        sTAX_FED2 = sTAX_FED2.toFixed(2);
        sTAX_FED3 = sPRICE3  * (5/100);
        sTAX_FED3 = sTAX_FED3.toFixed(2);
    }
    if (document.getElementById("prTAX_PROV").checked == true){
        sTAX_PROV = sPRICE  * (9.975/100);
        sTAX_PROV = sTAX_PROV.toFixed(2);
        sTAX_PROV2 = sPRICE2  * (9.975/100);
        sTAX_PROV2 = sTAX_PROV2.toFixed(2);
        sTAX_PROV3 = sPRICE3  * (9.975/100);
        sTAX_PROV3 = sTAX_PROV3.toFixed(2);
    }
    sPRICE_TX = Number(sPRICE) + Number(sTAX_FED) + Number(sTAX_PROV);
    sPRICE_TX2 = Number(sPRICE2) + Number(sTAX_FED2) + Number(sTAX_PROV2);
    sPRICE_TX3 = Number(sPRICE3) + Number(sTAX_FED3) + Number(sTAX_PROV3);
    document.getElementById("PR_TX").innerHTML = "<span style='font-size:12px;'> +tx=" + sPRICE_TX.toFixed(2) + "$</span>" ;
    document.getElementById("PR_TX2").innerHTML = "<span style='font-size:12px;'> +tx=" + sPRICE_TX2.toFixed(2) + "$</span>" ;
    document.getElementById("PR_TX3").innerHTML = "<span style='font-size:12px;'> +tx=" + sPRICE_TX3.toFixed(2) + "$</span>" ;
}

function getFILE_INFO(prID,sFILE) {
	document.getElementById("prURL_IMG").value = sFILE;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				document.getElementById("divFILE_INFO").innerHTML = this.responseText;
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'getFILE_INFO.php?KEY=' + KEY + '&ID=' + prID + '&file=' + encodeURIComponent(sFILE) , true);
		xmlhttp.send();	
}
function renameFILE(prID) {
    if (!document.getElementById("txtURL_IMG")){
        addMsg("Choisissez d'abbord un fichier à renommer.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		return;
    }
	sFROM = document.getElementById("txtURL_IMG").value;
	sFILE = document.getElementById("prURL_IMG").value;
	if (sFILE.trim() == ""){
		addMsg("Le nom de fichier ne peut pas être vide.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		return;
	}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				//document.getElementById("divFADE").style.width = "100%";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Suppression réussi.<div style='height:20px;'> </div><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getFILES(prID);
                //closeEDITOR();
                //closeMSG();
                if (this.responseText == "1"){
                    addNotif("Fichier renommé.");
                } else {
                    addNotif("Erreur lors de la modification du nom de fichier.");
                }
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'renameFILE.php?KEY=' + KEY + '&ID=' + prID + '&FROM=' + encodeURIComponent(sFROM) + '&TO=' + encodeURIComponent(sFILE) , true);
		xmlhttp.send();	
}

function updFILE_URL(prID) {
    if (!document.getElementById("txtURL_IMG")){
		addMsg("Choisissez d'abbord un fichier.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		return;      
    }
	sFILE = document.getElementById("txtURL_IMG").value;
	if (sFILE.trim() == ""){
		addMsg("Choisissez d'abbord un fichier.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		return;
	}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				//document.getElementById("divFADE").style.width = "100%";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Suppression réussi.<div style='height:20px;'> </div><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getFILES(prID);
                //closeEDITOR();
                //closeMSG();
                addNotif("Changement de l'image par défaut pour ce produit terminé");
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'updFILE_LINK.php?KEY=' + KEY + '&ID=' + prID + '&LINK=' + encodeURIComponent(sFILE) , true);
		xmlhttp.send();	
}
function deleteFILE(prID) {
    sFILE = document.getElementById("prURL_IMG").value;
	if (sFILE.trim() == ""){
		addMsg("Choisissez d'abbord un fichier à effacer.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		return;
	}
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment effacer l'image nommé: <br>"+sFILE+"<div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"];?></button> <button class='red' onclick='delFILE(" + prID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"];?></button>";
}
function delFILE(prID) {
	sFILE = document.getElementById("prURL_IMG").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				//document.getElementById("divFADE").style.width = "100%";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Suppression réussi.<div style='height:20px;'> </div><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getFILES(prID);
                document.getElementById("prURL_IMG").value = "";
                document.getElementById("divFILE_INFO").innerHTML="<u>File</u>:<br><u>Extension</u>:<br><u>Size</u>:<br><u>Width</u>:<br><u>Height</u>:<br><u>Last modified</u>:<br><u>Last accessed</u>:<br>";
                closeMSG();
                addNotif("Suppression du fichier " + sFILE + " terminée");
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delFILE.php?KEY=' + KEY + '&ID=' + prID + '&FILE=' + encodeURIComponent(sFILE) , true);
		xmlhttp.send();	
}
function rotate_picture(prID,sFN) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
				getFILES(prID);
                addNotif( this.responseText);
	  }
	};
		xmlhttp.open('GET', 'rotate_picture.php?KEY=' + KEY + '&prID=' + prID + '&FN=' + encodeURIComponent(sFN) , true);
		xmlhttp.send();	
}
function getFILES(prID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
			document.getElementById("divFILES").innerHTML =this.responseText;
		  } else {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'getFILES.php?KEY=' + KEY + '&prID=' + prID  , true);
		xmlhttp.send();	
}
function delPRD(prID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				//document.getElementById("divFADE").style.width = "100%";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "Suppression réussi.<div style='height:20px;'> </div><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				getPRDS("",LIMIT);
                closeEDITOR();
				document.getElementById("divMSG").innerHTML = "Le produit a été supprimé de la base de données mais pas le dossier /fs/product/"+prID+"/. Il devra être supprimé manuellement.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                //closeMSG();
                //addNotif("Suppression du produit #" + prID + " terminée");
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delPRD.php?KEY=' + KEY + '&prID=' + prID , true);
		xmlhttp.send();	
}

function deletePRDS() {
	closeBatch();
    if (isSelection('frmPRD')==true) {
        document.getElementById("divFADE2").style.display = "inline-block";
    	document.getElementById("divFADE2").style.opacity = "1";
    	document.getElementById("divMSG").style.display = "inline-block";
    	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"];?><div style='height:20px;'> </div><button class='red' onclick='delPRDS();'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button> <button style='background:#555555;' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button>";
    } else {
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divFADE2").style.opacity = "1";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ERR1"];?><div style='height:20px;'> </div><button style='background:#555555;' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button>";
    }
}

function delPRDS() {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	var sLST = "";

	var frmPRD  = document.getElementById("frmPRD");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmPRD.elements.length; i++ ) 
	{
		if (frmPRD.elements[i].type == 'checkbox')
		{
			if (frmPRD.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","} else { sLST = "("; }
				sLST += sVIRGULE + frmPRD.elements[i].value ;
			}
		}
	}	
	if (sLST == ""){
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["ERR_SEL1"];?><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	} else { sLST += ")"; }
	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
			  	getPRDS('','',LIMIT);
                closeMSG();
          } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delPRDS.php?KEY=' + KEY + '&LST=' + encodeURIComponent(sLST) , true);
		xmlhttp.send();
		
}


function getPRD(prID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		//const elmnt = document.createElement("div");
		//elmnt.setAttribute("id", "divEDIT");
		//elmnt.classList.add('divEDITOR');
		//elmnt.style.height="95%";
		//elmnt.innerHTML = this.responseText;
		//document.body.appendChild(elmnt);
  		document.getElementById("divEDIT").style.height = "95%";
		document.getElementById("divEDIT").innerHTML = this.responseText;
		document.getElementById("divEDIT").style.display = "inline-block";
/* 		window.scrollTo({
		  top: 0,
		  left: 0,
		  behavior: 'smooth'
		}); */
        dragElement(document.getElementById('divEDIT'));
        calcPR_TX();
        getOPTIONS(prID);
        getPACKS(prID);
        
        //BARCODE
        var prdUPC = document.getElementById("prUPC").value;
        if (validateUPC(prdUPC.trim()) == true) {
            JsBarcode("#prdBARCODE",prdUPC,{
                format:"upc",
                lineColor:"#000",
                width:2,
                height:50,
                textMargin:0,
                displayValue:true
            });
        }
	  }
	};
	document.getElementById("divFADE").style.opacity = "0.3";
	document.getElementById("divFADE").style.display = "inline-block";
		xmlhttp.open('GET', 'getPRD.php?KEY=' + KEY + '&prID=' + prID , true);
		xmlhttp.send();
		
}
function validateUPC(sVALUE) {
    if (sVALUE.trim().length != 12) { 
        document.getElementById('prdUPCerror').innerHTML='Le code UPC doit contenir 12 chiffres.';
        document.getElementById('prdBARCODE').src='';
        return false;
    } else {
        document.getElementById('prdUPCerror').innerHTML='';
    }

    if (!/^\d{12}$/.test(sVALUE)) {
        document.getElementById('prdUPCerror').innerHTML='Le code UPC doit contenir uniquement des chiffres.';
        document.getElementById('prdBARCODE').src='';
        return false;
    } else {
        document.getElementById('prdUPCerror').innerHTML='';
    }

    let odds = parseInt(sVALUE.charAt(0)) + parseInt(sVALUE.charAt(2)) + parseInt(sVALUE.charAt(4)) + parseInt(sVALUE.charAt(6)) + parseInt(sVALUE.charAt(8)) + parseInt(sVALUE.charAt(10));
    let evens = parseInt(sVALUE.charAt(1)) + parseInt(sVALUE.charAt(3)) + parseInt(sVALUE.charAt(5)) + parseInt(sVALUE.charAt(7)) + parseInt(sVALUE.charAt(9));
    let sum_odds = odds * 3;
    let total = parseInt(sum_odds) + parseInt(evens);
    let mod = total % 10;
    let check_digit = (10 - mod) % 10;
    if (check_digit != sVALUE.charAt(11)) {
        document.getElementById('prdUPCerror').innerHTML='Le code UPC est invalide.';
        document.getElementById('prdBARCODE').src='';
        return false;
    } else {
        document.getElementById('prdUPCerror').innerHTML='';
    }

return true;
}
function showBARCODE(sVALUE) {
    if (validateUPC(sVALUE.trim()) == true) { 
        JsBarcode("#prdBARCODE",sVALUE,{
            format:"upc",
            lineColor:"#000",
            width:2,
            height:50,
            textMargin:0,
            displayValue:true
        }); 
    }
}
function getPRDS(sOFFSET,sLIMIT) {
    if (document.getElementById("inputSEARCH")){
        var sS = document.getElementById("inputSEARCH").value;
    } else {
        var sS = ""; 
    }
    if (document.getElementById("selCAT")){
        var GRPBOX  = document.getElementById("selCAT");
        var sCAT  = GRPBOX.options[GRPBOX.selectedIndex].value;
    } else {
        var sCAT = ""; 
    }
    if (document.getElementById("selSTAT")){
        var GRPBOX  = document.getElementById("selSTAT");
        var sSTAT  = GRPBOX.options[GRPBOX.selectedIndex].value;
    } else {
        var sSTAT = ""; 
    }
    if (document.getElementById("selFRN1")){
        var GRPBOX  = document.getElementById("selFRN1");
        var sFRN1  = GRPBOX.options[GRPBOX.selectedIndex].value;
    } else {
        var sFRN1 = ""; 
    }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById('product_loading').style.display="none";
		document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getPRDS.php?KEY=' + KEY + '&CAT='  + sCAT 
												+ '&FRN1=' + sFRN1
												+ '&SS=' + sS 
												+ '&STAT=' + sSTAT 
												+ '&OFFSET=' + sOFFSET 
												+ '&LIMIT=' + sLIMIT 
												, true);
		xmlhttp.send();
		
}

function newPRD(){
	/* var sDESC_FR  			= document.getElementById("newDESC_FR").value;
	var sDESC_EN  			= document.getElementById("newDESC_EN").value; */
	var sNOM_FR  			= document.getElementById("newNOM_FR").value;
	var sNOM_EN  			= document.getElementById("newNOM_EN").value;
	var sUPC  			= document.getElementById("newUPC").value;
    //var sFRN1  			= document.getElementById("newFRN1").value;
	var GRPBOX  = document.getElementById("newCAT");
	var sCAT  = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX  = document.getElementById("newBILLING");
	var sBILLING  = GRPBOX.options[GRPBOX.selectedIndex].value;	

	if (sNOM_FR == ""){
		document.getElementById("newNOM_FR").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newNOM_FR").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newNOM_FR").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.substr(0, 3) != "Err"){
            closeMSG();
            closeEDITOR();
            getPRDS("",LIMIT);
            if (document.getElementById("newTO_STRIPE").checked){
                addToSTRIPE(this.responseText.trim());
            }
            getPRD(this.responseText.trim());
            addNotif("Le produit #"+ this.responseText.trim() +" a été créé.");
		  } else {
            if (this.responseText.substr(0,12) == "Erreur: #UPC"){
                document.getElementById("newUPC").style.boxShadow = "5px 10px 15px red";
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();document.getElementById('newUPC').focus();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
            } else{
                document.getElementById("newUPC").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
            }
		  } 
	  }
	};
		xmlhttp.open('GET', 'newPRD.php?KEY=' + KEY 
										+ '&BILLING=' 		+ encodeURIComponent(sBILLING)      
										+ '&NOM_FR=' 		+ encodeURIComponent(sNOM_FR)   
										+ '&NOM_EN=' 		+ encodeURIComponent(sNOM_EN)   
										+ '&UPC=' 		+ encodeURIComponent(sUPC)   
										+ '&CAT=' 	+ encodeURIComponent(sCAT),                			
										true);
		xmlhttp.send();
}
//addToSTRIPE
function addToSTRIPE(ID){
var is_stripe_key = '<?php echo substr($CIE_STRIPE_KEY,0,1); ?>';
if(is_stripe_key.trim() == ""){
    //document.getElementById("divFADE").style.width = "100%";
	//document.getElementById("divMSG").style.display = "inline-block";
	//document.getElementById("divMSG").innerHTML = "La clé pour l'API Stripe introuvable. Veuillez contacter info@dw3.ca pour plus d'informations<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	addNotif("La clé pour l'API Stripe introuvable. Veuillez contacter info@dw3.ca pour plus d'informations");
    return;
}	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
				//document.getElementById("divFADE").style.width = "100%";
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				if (document.getElementById("prSTRIPE") != undefined){
                    document.getElementById("prSTRIPE").value = this.responseText;
                    document.getElementById("btnAddToStripe").innerHTML = "Associé à Stripe";
                }
				addNotif("Réponse de Stripe:" + this.responseText);
	  }
	};
		xmlhttp.open('GET', 'addToSTRIPE.php?KEY=' + KEY + '&ID=' + ID, true);
		xmlhttp.send();
	
}

function copyPRD(sID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
				addNotif("Le produit a été copié. Le voici..");
                getPRDS("",LIMIT);
                getPRD(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'copyPRD.php?KEY=' + KEY + '&ID=' + sID, true);
		xmlhttp.send();
}
function duplicatePRD(sID){
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Si vous avez fait des modifications sur ce produit, vous devriez d'abord le sauvegarder..<div style='height:20px;'> </div><button class='green' onclick='copyPRD(" + sID + ");closeMSG();'><span class='material-icons' style='vertical-align:middle;'>delete</span> Continuer</button> <button onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"];?></button>";
}

function updPRD(sID){
	var sIMPORT  			= document.getElementById("prSTORAGE_IMPORT").value;
	var sEXPORT  			= document.getElementById("prSTORAGE_EXPORT").value;
	var sFRN1  			= document.getElementById("prFRN1").value;
	var sNOM  			= document.getElementById("prNOM").value;
	var sNOM_EN  			= document.getElementById("prNOM_EN").value;
	var sSKU  			= document.getElementById("prSKU").value;
	var sUPC  			= document.getElementById("prUPC").value;
	var sPACK  			= document.getElementById("prPACK").value;
	var sSTEP  			= document.getElementById("prSTEP").value;
	var sBRAND  			= document.getElementById("prBRAND").value;
	var sMODEL  			= document.getElementById("prMODEL").value;
	var sMODEL_YEAR  			= document.getElementById("prMODEL_YEAR").value;
	var sTAX_VERTE  		= document.getElementById("prTAX_VERTE").value;
	var sTAX_FED 		= document.getElementById("prTAX_FED").checked;
	var sTAX_PROV 		= document.getElementById("prTAX_PROV").checked;
	var sPRIX_ACH  		= document.getElementById("prPRIX_ACH").value;
	var sPRIX_VTE  		= document.getElementById("prPRIX_VTE").value;
	var sPRIX_VTE2  		= document.getElementById("prPRIX_VTE2").value;
	var sPRIX_TRP  		= document.getElementById("prPRIX_TRP").value;
	var sPRIX_MIN2  		= document.getElementById("prMIN_P2").value;
	var sPROMO_PRIX  		= document.getElementById("prPROMO_PRIX").value;
	var sPROMO_EXPIRE  		= document.getElementById("prPROMO_EXPIRE").value;
	var sCONSIGNE  		= document.getElementById("prCONSIGNE").value;
	var sPACK_DESC  		= document.getElementById("prPACK_DESC").value;
	var sPRIX_TEXT  	= document.getElementById("prPRIX_TEXT").value;
	var sPRIX_TEXT_EN  	= document.getElementById("prPRIX_TEXT_EN").value;
	var sPRIX_SUFFIX  	= document.getElementById("prPRIX_SUFFIX").value;
	var sPRIX_SUFFIX_EN = document.getElementById("prPRIX_SUFFIX_EN").value;
	var sJOURS_CONSERV  = document.getElementById("prJOURS_CONSERV").value;
	var sSERV_LEN  = document.getElementById("prSERV_LEN").value;
	var sINTER_LEN  = document.getElementById("prINTER_LEN").value;
	var sIS_BIO  		  	= document.getElementById("prIS_BIO").value;
	var sKG  		  	= document.getElementById("prKG").value;
	var sLT  		  	= document.getElementById("prLITER").value;
	var sHEIGHT  		= document.getElementById("prHEIGHT").value;
	var sWIDTH  		= document.getElementById("prWIDTH").value;
	var sDEPTH  		= document.getElementById("prDEPTH").value;
	var sURL_ACTION1  	= document.getElementById("prURL_ACTION1").value;
	var sURL_ACTION2 	= document.getElementById("prURL_ACTION2").value;
	var sQTY_MIN_SOLD 	= document.getElementById("prQTY_MIN_SOLD").value;
	var sQTY_MAX_SOLD 	= document.getElementById("prQTY_MAX_SOLD").value;
	var sQTY_MAX_BY_INV = document.getElementById("prQTY_MAX_BY_INV").checked;
	var sMAG_DSP 		= document.getElementById("prMAG_DSP").checked;
	var sWEB_DSP 		= document.getElementById("prWEB_DSP").checked;
	var sWEB_BTN_FR		= document.getElementById("prWEB_BTN_FR").value;
	var sWEB_BTN_EN		= document.getElementById("prWEB_BTN_EN").value;
	var sWEB_BTN2_FR		= document.getElementById("prWEB_BTN2_FR").value;
	var sWEB_BTN2_EN		= document.getElementById("prWEB_BTN2_EN").value;
	var sWEB_BTN_ICON		= document.getElementById("prWEB_BTN_ICON").value;
	var sWEB_BTN2_ICON		= document.getElementById("prWEB_BTN2_ICON").value;
	var sDSP_STATUS 	= document.getElementById("prDSP_STATUS").checked;
	var sDSP_UPC 		= document.getElementById("prDSP_UPC").checked;
	var sDSP_OPT		= document.getElementById("prDSP_OPT").checked;
	var sDSP_INV 		= document.getElementById("prDSP_INV").checked;
	var sDSP_MESURE  			= document.getElementById("prDSP_MESURE").checked;
	var sDSP_BRAND  			= document.getElementById("prDSP_BRAND").checked;
	var sDSP_EXPORT  			= document.getElementById("prDSP_EXPORT").checked;
	var sIS_SCHEDULED 		= document.getElementById("prIS_SCHEDULED").checked;

	var GRPBOX  = document.getElementById("prSHIP");
	var sSHIP = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sPICKUP 	= document.getElementById("prPICKUP").checked;

	var GRPBOX  = document.getElementById("prBTN_ACTION1");
	var sBTN_ACTION1 = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("prBTN_ACTION2");
	var sBTN_ACTION2 = GRPBOX.options[GRPBOX.selectedIndex].value;

	var GRPBOX  = document.getElementById("prSTAT");
	var sSTAT = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var GRPBOX  = document.getElementById("prBILLING");
	var sBILLING = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	var GRPBOX  = document.getElementById("prCAT");
	var sCAT = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("prCAT2");
	var sCAT2 = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("prCAT3");
	var sCAT3 = GRPBOX.options[GRPBOX.selectedIndex].value;

	if (sNOM == ""){
		document.getElementById("prNOM").style.boxShadow = "5px 10px 15px red";
		document.getElementById("prNOM").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("prNOM").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}

    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rgba(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:40px;height:auto;border-radius:20px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				//addNotif("La fiche " + sNOM + " a été mise &#224; jour");
				//closeMSG();
                //closeEDITOR();
                updDESC(sID);
				//document.getElementById("div"+ sID).style.display = "none";
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updPRD.php?KEY=' + KEY
										+ '&ID=' 		+ encodeURIComponent(sID)  
										+ '&NOM=' 		+ encodeURIComponent(sNOM)   
										+ '&NOM_EN=' 		+ encodeURIComponent(sNOM_EN)   
										+ '&UPC=' 		+ encodeURIComponent(sUPC)     
										+ '&SKU=' 		+ encodeURIComponent(sSKU)   
										+ '&PACK=' 		+ encodeURIComponent(sPACK)   
										+ '&STEP=' 		+ encodeURIComponent(sSTEP)   
										+ '&STAT=' 		+ encodeURIComponent(sSTAT)   
										+ '&BILLING=' 		+ encodeURIComponent(sBILLING)     
										+ '&DEPTH=' 		+ encodeURIComponent(sDEPTH)   
										+ '&TAX_FED=' 		+ encodeURIComponent(sTAX_FED)   
										+ '&TAX_PROV=' 		+ encodeURIComponent(sTAX_PROV)   
										+ '&TAX_VERTE=' 	+ encodeURIComponent(sTAX_VERTE)   
										+ '&MAG_DSP=' 		+ encodeURIComponent(sMAG_DSP)   
										+ '&WEB_DSP=' 		+ encodeURIComponent(sWEB_DSP)   
										+ '&WEB_BTN_FR=' 		+ encodeURIComponent(sWEB_BTN_FR)   
										+ '&WEB_BTN_EN=' 		+ encodeURIComponent(sWEB_BTN_EN)   
										+ '&WEB_BTN2_FR=' 		+ encodeURIComponent(sWEB_BTN2_FR)   
										+ '&WEB_BTN2_EN=' 		+ encodeURIComponent(sWEB_BTN2_EN)   
										+ '&WEB_BTN_ICON=' 		+ encodeURIComponent(sWEB_BTN_ICON)   
										+ '&WEB_BTN2_ICON='		+ encodeURIComponent(sWEB_BTN2_ICON)     
										+ '&DSP_UPC=' 		+ encodeURIComponent(sDSP_UPC)   
										+ '&DSP_INV=' 		+ encodeURIComponent(sDSP_INV)   
										+ '&IS_SCHEDULED=' 		+ encodeURIComponent(sIS_SCHEDULED)   
										+ '&URL_ACTION1='	+ encodeURIComponent(sURL_ACTION1)     
										+ '&URL_ACTION2='	+ encodeURIComponent(sURL_ACTION2)     
										+ '&BTN_ACTION1='	+ encodeURIComponent(sBTN_ACTION1)     
										+ '&BTN_ACTION2='	+ encodeURIComponent(sBTN_ACTION2)     
										+ '&QTY_MIN_SOLD='	+ encodeURIComponent(sQTY_MIN_SOLD)     
										+ '&QTY_MAX_SOLD='	+ encodeURIComponent(sQTY_MAX_SOLD)     
										+ '&QTY_MAX_BY_INV='+ encodeURIComponent(sQTY_MAX_BY_INV)    
										+ '&PRIX_ACH=' 	+ encodeURIComponent(sPRIX_ACH)   
										+ '&SHIP=' 	+ encodeURIComponent(sSHIP)   
										+ '&PICKUP=' 	+ encodeURIComponent(sPICKUP)   
										+ '&PRIX_VTE=' 	+ encodeURIComponent(sPRIX_VTE)   
										+ '&PRIX_TRP=' 	+ encodeURIComponent(sPRIX_TRP)   
										+ '&PRIX_TEXT=' 	+ encodeURIComponent(sPRIX_TEXT)   
										+ '&PRIX_TEXT_EN=' 	+ encodeURIComponent(sPRIX_TEXT_EN)   
										+ '&PRIX_SUFFIX=' 	+ encodeURIComponent(sPRIX_SUFFIX)   
										+ '&PRIX_SUFFIX_EN='+ encodeURIComponent(sPRIX_SUFFIX_EN)    
										+ '&JRS_CNSRV=' + encodeURIComponent(sJOURS_CONSERV)     
										+ '&SERV_LEN=' + encodeURIComponent(sSERV_LEN)     
										+ '&INTER_LEN=' + encodeURIComponent(sINTER_LEN)     
										+ '&BIO=' + encodeURIComponent(sIS_BIO)     
										+ '&KG=' 	+ encodeURIComponent(sKG)   
										+ '&HEIGHT=' 	+ encodeURIComponent(sHEIGHT)   
										+ '&WIDTH=' 	+ encodeURIComponent(sWIDTH)   
										+ '&FRN1=' 	+ encodeURIComponent(sFRN1)     
										+ '&VTE2=' 	+ encodeURIComponent(sPRIX_VTE2)     
										+ '&MIN2=' 	+ encodeURIComponent(sPRIX_MIN2)     
										+ '&PROM_PRX=' 	+ encodeURIComponent(sPROMO_PRIX)     
										+ '&PROM_EXP=' 	+ encodeURIComponent(sPROMO_EXPIRE)     
										+ '&CNS=' 	+ encodeURIComponent(sCONSIGNE)     
										+ '&PACK_DSC=' 	+ encodeURIComponent(sPACK_DESC)     
										+ '&DSP_EXPORT=' 	+ encodeURIComponent(sDSP_EXPORT)     
										+ '&EXPORT=' 	+ encodeURIComponent(sEXPORT)     
										+ '&IMPORT=' 	+ encodeURIComponent(sIMPORT)     
										+ '&LT=' 	+ encodeURIComponent(sLT)  
										+ '&FAB=' 		+ encodeURIComponent(sBRAND)   
										+ '&MOD=' 		+ encodeURIComponent(sMODEL)   
										+ '&MOD_Y=' 		+ encodeURIComponent(sMODEL_YEAR)  
										+ '&DSP_MESURE=' 		+ encodeURIComponent(sDSP_MESURE) 
										+ '&DSP_BRAND=' 		+ encodeURIComponent(sDSP_BRAND)     
										+ '&CAT=' + sCAT
										+ '&CAT2=' + sCAT2
										+ '&CAT3=' + sCAT3 ,    
										true);
		xmlhttp.send();
}
function updDESC(sID){
    var sNOM  			= document.getElementById("prNOM").value;
    var sDESC_FR		= document.getElementById("prDESC").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    var sDESC_EN  		= document.getElementById("prDESC_EN").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    var sDATAIA_DESC 		= document.getElementById("prDESC_IA_FR").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "updDESC.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onload = function() {
        if (this.responseText == ""){
				addNotif("La fiche " + sNOM + " a été mise &#224; jour");
                closeEDITOR();
                getPRDS("",LIMIT);
                closeMSG();
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  }
    }
  xhttp.send("KEY="+KEY+"&ID="+sID+"&DESC_FR="+encodeURIComponent(sDESC_FR)+"&DESC_EN="+encodeURIComponent(sDESC_EN)+"&DIA="+encodeURIComponent(sDATAIA_DESC));
}

function updPRM(){
	var GRPBOX = document.getElementById("prmLIMIT");
	var prmLIMIT = GRPBOX.options[GRPBOX.selectedIndex].value;
	//var GRPBOX = document.getElementById("prmRECH_COL");
	//var prmRECH_COL = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("prmORDERBY");
	var prmORDERBY = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX = document.getElementById("prmORDERWAY");
	var prmORDERWAY = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX = document.getElementById("prmDOC_TYPE");
	var prmDOC_TYPE = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	if (document.getElementById("DSP_COL_ID").checked == false){            var dspID = 0; } else {             var dspID = 1; }
	if (document.getElementById("DSP_COL_STAT").checked == false){          var dspSTAT = 0; } else {           var dspSTAT = 1; }
	if (document.getElementById("DSP_COL_NOM").checked == false){           var dspNOM  = 0; } else {           var dspNOM  = 1; }
	if (document.getElementById("DSP_COL_DESC").checked == false){          var dspDESC = 0; } else {           var dspDESC = 1; }
	if (document.getElementById("DSP_COL_CAT").checked == false){           var dspCAT  = 0; } else {           var dspCAT  = 1; }
	if (document.getElementById("DSP_COL_FRN1").checked == false){          var dspFRN1 = 0; } else {           var dspFRN1 = 1; }
	if (document.getElementById("DSP_COL_PACK").checked == false){          var dspPACK = 0; } else {           var dspPACK = 1; }
	if (document.getElementById("DSP_COL_KG").checked == false){            var dspKG = 0; } else {             var dspKG = 1; }
	if (document.getElementById("DSP_COL_WIDTH").checked == false){         var dspWIDTH = 0; } else {          var dspWIDTH = 1; }
	if (document.getElementById("DSP_COL_HEIGHT").checked == false){        var dspHEIGHT = 0; } else {         var dspHEIGHT = 1; }
	if (document.getElementById("DSP_COL_DEPTH").checked == false){         var dspDEPTH = 0; } else {          var dspDEPTH = 1; }
	if (document.getElementById("DSP_COL_TOTAL").checked == false){      	var dspTOTAL = 0; } else {       	var dspTOTAL = 1; }
	if (document.getElementById("DSP_COL_PRIX_VTE").checked == false){      var dspPRIX_VTE = 0; } else {       var dspPRIX_VTE = 1; }
	if (document.getElementById("DSP_COL_PRIX_ACH").checked == false){      var dspPRIX_ACH = 0; } else {       var dspPRIX_ACH = 1; }
	if (document.getElementById("DSP_COL_DTAD").checked == false){          var dspDTAD = 0; } else {           var dspDTAD = 1; }
	if (document.getElementById("DSP_COL_DTMD").checked == false){          var dspDTMD = 0; } else {           var dspDTMD = 1; }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		   //alert (this.responseText);
		  if (this.responseText == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				//document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["MODIFIED"];?><div style='height:20px;'> </div><button onclick='closeMSG();closeEDITOR();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				closeMSG();
				closeEDITOR();
				getPRDS('',LIMIT);
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};

		xmlhttp.open('GET', 'updPRM.php?KEY=' + KEY 
										+ '&DOC_TYPE=' 	+ prmDOC_TYPE
										+ '&LIMIT=' 	+ prmLIMIT
										+ '&ORDW='	+ prmORDERWAY
										+ '&ORDB='	+ prmORDERBY
										+ '&ID=' 	+ dspID
										+ '&STAT='	+ dspSTAT 
										+ '&NOM='	+ dspNOM  
										+ '&DESC=' 	+ dspDESC
										+ '&CAT=' 	+ dspCAT
										+ '&FRN1=' 	+ dspFRN1
										+ '&PACK=' 	+ dspPACK
										+ '&KG=' 	+ dspKG 
										+ '&WIDTH=' + dspWIDTH
										+ '&HEIGHT='+ dspHEIGHT
										+ '&DEPTH=' + dspDEPTH
										+ '&TOTAL=' + dspTOTAL
										+ '&PRIXV=' + dspPRIX_VTE
										+ '&PRIXA=' + dspPRIX_ACH
										+ '&DTAD=' 	+ dspDTAD
										+ '&DTMD=' 	+ dspDTMD,
										true);
		xmlhttp.send();
		document.getElementById("divFADE").style.display = "inline-block";
		document.getElementById("divFADE").style.opacity = "0.4";
}

//PRODUCT OPTIONS
function saveOPTION(product_id,option_id) {
    var name_fr = document.getElementById("opt_name_fr").value;
    var name_en = document.getElementById("opt_name_en").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getOPTIONS(product_id);
        closeMSG();
	  }
	};
	xmlhttp.open('GET', 'saveOPTION.php?KEY=' + KEY + '&OPT=' + option_id  + '&FR=' + encodeURIComponent(name_fr) + '&EN=' + encodeURIComponent(name_en), true);
	xmlhttp.send();
}
function saveOPTION_LINE(product_id,line_id) {
    var name_fr = document.getElementById("opt_name_fr").value;
    var name_en = document.getElementById("opt_name_en").value;
    var amount = document.getElementById("opt_amount").value;
    var liter = document.getElementById("opt_liter").value;
    var kg = document.getElementById("opt_kg").value;
    var height = document.getElementById("opt_height").value;
    var width = document.getElementById("opt_width").value;
    var depth = document.getElementById("opt_depth").value;
    var is_dft = document.getElementById("opt_dft").checked;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getOPTIONS(product_id);
        closeMSG();
	  }
	};
	xmlhttp.open('GET', 'saveOPTION_LINE.php?KEY=' + KEY 
    + '&LNG=' + line_id 
    + '&DFT=' + is_dft  
    + '&FR=' + encodeURIComponent(name_fr)
    + '&EN=' + encodeURIComponent(name_en) 
    + '&MNT=' + encodeURIComponent(amount) 
    + '&LT=' + encodeURIComponent(liter) 
    + '&KG=' + encodeURIComponent(kg) 
    + '&HT=' + encodeURIComponent(height) 
    + '&WD=' + encodeURIComponent(width) 
    + '&DP=' + encodeURIComponent(depth) 
    , true);
	xmlhttp.send();
}
function editOPTION(product_id,option_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText
        +"<br><button onclick='deleteOPTION("+product_id+","+option_id+");' class='red'><span class='material-icons' style='vertical-align:middle;'>delete</span></button>"
        +"<button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Fermer</button>"
        +"<button onclick='saveOPTION("+product_id+","+option_id+");' class='green'><span class='material-icons' style='vertical-align:middle;'>save</span> Enregistrer</button>");
	  }
	};
	xmlhttp.open('GET', 'editOPTION.php?KEY=' + KEY + '&OPT=' + option_id , true);
	xmlhttp.send();
}
function editOPTION_LINE(product_id,line_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText
        +"<button onclick='deleteOPTION_LINE("+product_id+","+line_id+");' class='red'><span class='material-icons' style='vertical-align:middle;'>delete</span></button>"
        +"<button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Fermer</button>"
        +"<button onclick='saveOPTION_LINE("+product_id+","+line_id+");' class='green'><span class='material-icons' style='vertical-align:middle;'>save</span> Enregistrer</button>");
	  }
	};
	xmlhttp.open('GET', 'editOPTION_LINE.php?KEY=' + KEY + '&LNG=' + line_id , true);
	xmlhttp.send();
}
function getOPTIONS(product_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divPrdOpt").innerHTML =this.responseText;
	  }
	};
	xmlhttp.open('GET', 'getOPTIONS.php?KEY=' + KEY + '&PRD=' + product_id , true);
	xmlhttp.send();
}
function getOPTS_LST() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = this.responseText+"<br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button>";

	  }
	};
	xmlhttp.open('GET', 'getOPTS_LST.php?KEY=' + KEY, true);
	xmlhttp.send();
    closeBatch();
}
function setOPT_PRDS(opt_id) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	var sLST = "";

	var frmPRD  = document.getElementById("frmPRD");
	var sVIRGULE = "";
	
	for (var i = 0; i < frmPRD.elements.length; i++ ) 
	{
		if (frmPRD.elements[i].type == 'checkbox')
		{
			if (frmPRD.elements[i].checked == true)
			{
				if(sLST != ""){sVIRGULE = ","} else { sLST = "("; }
				sLST += sVIRGULE + frmPRD.elements[i].value ;
			}
		}
	}	
	if (sLST == ""){
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["ERR_SEL1"];?><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		return;
	} else { sLST += ")"; }

   	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.trim() == ""){
                closeMSG();
                if (frmPRD.elements.length == 1){
                    addNotif("L'option a été appliquée au produit.");
                } else {
                    addNotif("L'option a été appliquée aux produits.");
                }
                selNONE('frmPRD','checkbox');
          } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  }
        }
	};
	xmlhttp.open('GET', 'setOPT_PRDS.php?KEY=' + KEY + '&LST=' + sLST + '&OPT=' + opt_id , true);
	xmlhttp.send(); 
}
function addOPTION(product_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getOPTIONS(product_id);
        editOPTION(product_id,this.responseText);
	  }
	};
	xmlhttp.open('GET', 'addOPTION.php?KEY=' + KEY + '&PRD=' + product_id , true);
	xmlhttp.send();
}
function addOPTION_LINE(product_id,option_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getOPTIONS(product_id);
        editOPTION_LINE(product_id,this.responseText);
	  }
	};
	xmlhttp.open('GET', 'addOPTION_LINE.php?KEY=' + KEY + '&OPT=' + option_id , true);
	xmlhttp.send();
}
function delOPTION(product_id,option_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getOPTIONS(product_id);
        closeMSG();
	  }
	};
	xmlhttp.open('GET', 'delOPTION.php?KEY=' + KEY + '&OPT=' + option_id , true);
	xmlhttp.send();
}
function deleteOPTION(product_id,option_id) {
        document.getElementById("divFADE2").style.display = "inline-block";
    	document.getElementById("divFADE2").style.opacity = "1";
    	document.getElementById("divMSG").style.display = "inline-block";
    	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"];?><div style='height:20px;'> </div><button class='red' onclick='delOPTION("+product_id+","+option_id+");'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button> <button style='background:#555555;' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button>";
}
function delOPTION_LINE(product_id,line_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getOPTIONS(product_id);
        closeMSG();
	  }
	};
	xmlhttp.open('GET', 'delOPTION_LINE.php?KEY=' + KEY + '&LNG=' + line_id , true);
	xmlhttp.send();
}
function deleteOPTION_LINE(product_id,line_id) {
        document.getElementById("divFADE2").style.display = "inline-block";
    	document.getElementById("divFADE2").style.opacity = "1";
    	document.getElementById("divMSG").style.display = "inline-block";
    	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"];?><div style='height:20px;'> </div><button class='red' onclick='delOPTION_LINE("+product_id+","+line_id+");'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button> <button style='background:#555555;' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button>";
}
//PRODUCT PACK
function savePACK(product_id,pack_id) {
    var name_fr = document.getElementById("pack_name_fr").value;
    var name_en = document.getElementById("pack_name_en").value;
    var pack_qty = document.getElementById("pack_qty").value;
    var pack_price = document.getElementById("pack_price").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getPACKS(product_id);
        closeMSG();
	  }
	};
	xmlhttp.open('GET', 'savePACK.php?KEY=' + KEY + '&PACK=' + pack_id + '&QTY=' + pack_qty + '&PRICE=' + encodeURIComponent(pack_price)  + '&FR=' + encodeURIComponent(name_fr) + '&EN=' + encodeURIComponent(name_en), true);
	xmlhttp.send();
}

function editPACK(product_id,pack_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText
        +"<br><button onclick='deletePACK("+product_id+","+pack_id+");' class='red'><span class='material-icons' style='vertical-align:middle;'>delete</span></button>"
        +"<button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Fermer</button>"
        +"<button class='gold' onclick='dw3_tool_calc()'><span class='material-icons' style='vertical-align:middle;'>calculate</span> Calc.</button>"
        +"<button onclick='savePACK("+product_id+","+pack_id+");' class='green'><span class='material-icons' style='vertical-align:middle;'>save</span></button>");
	  }
	};
	xmlhttp.open('GET', 'editPACK.php?KEY=' + KEY + '&PACK=' + pack_id , true);
	xmlhttp.send();
}

function getPACKS(product_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divPrdPack").innerHTML =this.responseText;
	  }
	};
	xmlhttp.open('GET', 'getPACKS.php?KEY=' + KEY + '&PRD=' + product_id , true);
	xmlhttp.send();
}
function addPACK(product_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getPACKS(product_id);
        editPACK(product_id,this.responseText);
	  }
	};
	xmlhttp.open('GET', 'addPACK.php?KEY=' + KEY + '&PRD=' + product_id , true);
	xmlhttp.send();
}
function delPACK(product_id,pack_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getPACKS(product_id);
        closeMSG();
	  }
	};
	xmlhttp.open('GET', 'delPACK.php?KEY=' + KEY + '&PACK=' + pack_id , true);
	xmlhttp.send();
}
function deletePACK(product_id,pack_id) {
        document.getElementById("divFADE2").style.display = "inline-block";
    	document.getElementById("divFADE2").style.opacity = "1";
    	document.getElementById("divMSG").style.display = "inline-block";
    	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"];?><div style='height:20px;'> </div><button class='red' onclick='delPACK("+product_id+","+pack_id+");'><span class='material-icons' style='vertical-align:middle;'>delete</span>Delete</button> <button style='background:#555555;' onclick='closeMSG();'><span class='material-icons'>cancel</span>Annuler</button>";
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

function dw3_gal2_show(that_src){
  var modal = document.getElementById("gal2_modal");
  var modalImg = document.getElementById("gal2_model_img");
  var captionText = document.getElementById("gal2_caption");
  document.body.style.overflowY = 'hidden';
  modal.style.display = "block";
  modalImg.src = that_src;
}

function dw3_gal2_close(){
  document.body.style.overflowY = 'auto';
  var modal = document.getElementById("gal2_modal");
  modal.style.display = "none";
}


function selICON(){
	addMsg("<br>"
		  +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#33;</span>"
		  +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#34;</span>"
		  +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#35;</span>"
		  +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#36;</span>"
		  +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#37;</span>"
		  +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#38;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#39;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#40;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#41;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#42;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#43;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#44;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#45;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#46;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#47;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#48;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#49;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#51;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#52;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#53;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#54;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#55;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#56;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#57;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#58;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#59;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#60;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#61;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#62;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#63;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#64;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#65;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#66;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#67;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#68;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#69;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#70;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#71;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#72;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#73;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#74;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#75;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#76;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#77;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#78;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#79;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#80;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#81;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#82;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#83;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#84;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#85;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#86;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#87;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#88;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#89;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#90;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#91;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#92;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#93;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#94;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#95;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#96;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#97;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#98;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#99;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#101;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#102;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#103;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#104;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#105;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#106;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#107;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#108;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#109;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#110;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#111;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#112;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#113;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#114;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#115;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#116;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#117;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#118;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#119;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#120;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#121;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#122;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#123;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#124;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#125;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#126;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#167;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#168;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#169;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#170;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#171;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#172;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#173;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#174;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#175;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#176;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#177;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#178;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#179;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#180;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#181;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#182;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#183;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#184;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#185;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#194;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#195;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#196;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#197;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#198;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#199;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#201;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#202;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#203;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#204;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#205;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#206;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#207;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#208;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#209;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#210;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#211;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#212;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#213;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#214;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#215;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#216;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#217;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#218;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#219;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#220;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#221;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#222;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#223;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#224;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#228;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#229;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#230;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#231;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#232;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#233;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#234;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#235;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#236;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#237;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#238;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#239;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#266;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#267;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#268;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#269;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#270;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#271;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#272;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#273;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#274;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#275;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#304;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#305;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#306;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#307;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#308;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#309;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#310;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#311;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#312;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#313;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#314;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#315;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#316;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#317;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#318;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#319;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#320;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#321;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#322;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#323;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#324;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#325;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#326;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#327;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#328;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#329;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#329;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#342;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#343;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#380;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#381;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#382;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#383;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#384;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#385;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#386;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#387;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#388;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#389;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#390;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#391;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#392;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#418;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#419;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#420;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#421;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#422;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#423;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#424;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#425;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#426;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#427;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#428;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#429;</span>"
		  +"<br><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>done</span>Annuler</button>");
}
function selICON2(){
	addMsg("<br>"
		  +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#33;</span>"
		  +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#34;</span>"
		  +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#35;</span>"
		  +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#36;</span>"
		  +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#37;</span>"
		  +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#38;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#39;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#40;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#41;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#42;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#43;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#44;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#45;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#46;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#47;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#48;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#49;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#51;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#52;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#53;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#54;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#55;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#56;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#57;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#58;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#59;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#60;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#61;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#62;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#63;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#64;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#65;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#66;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#67;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#68;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#69;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#70;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#71;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#72;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#73;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#74;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#75;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#76;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#77;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#78;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#79;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#80;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#81;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#82;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#83;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#84;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#85;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#86;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#87;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#88;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#89;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#90;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#91;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#92;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#93;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#94;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#95;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#96;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#97;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#98;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#99;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#101;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#102;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#103;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#104;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#105;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#106;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#107;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#108;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#109;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#110;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#111;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#112;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#113;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#114;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#115;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#116;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#117;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#118;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#119;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#120;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#121;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#122;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#123;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#124;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#125;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#126;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#167;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#168;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#169;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#170;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#171;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#172;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#173;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#174;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#175;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#176;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#177;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#178;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#179;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#180;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#181;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#182;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#183;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#184;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#185;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#194;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#195;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#196;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#197;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#198;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#199;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#201;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#202;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#203;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#204;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#205;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#206;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#207;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#208;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#209;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#210;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#211;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#212;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#213;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#214;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#215;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#216;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#217;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#218;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#219;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#220;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#221;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#222;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#223;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#224;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#228;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#229;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#230;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#231;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#232;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#233;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#234;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#235;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#236;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#237;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#238;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#239;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#266;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#267;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#268;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#269;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#270;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#271;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#272;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#273;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#274;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#275;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#304;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#305;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#306;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#307;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#308;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#309;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#310;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#311;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#312;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#313;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#314;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#315;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#316;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#317;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#318;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#319;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#320;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#321;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#322;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#323;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#324;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#325;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#326;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#327;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#328;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#329;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#329;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#342;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#343;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#380;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#381;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#382;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#383;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#384;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#385;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#386;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#387;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#388;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#389;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#390;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#391;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#392;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#418;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#419;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#420;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#421;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#422;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#423;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#424;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#425;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#426;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#427;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#428;</span>"
	      +"<span class='dw3_font' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON2(this.innerText);closeMSG();\">&#429;</span>"
		  +"<br><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>done</span>Annuler</button>");
}
function setICON(name){
	document.getElementById("prWEB_BTN_ICON").value=name;
    document.getElementById("idhICON_SPAN").innerText=name;
}
function setICON2(name){
	document.getElementById("prWEB_BTN2_ICON").value=name;
    document.getElementById("idhICON2_SPAN").innerText=name;
}

</script>
</body>
</html>
<?php $dw3_conn->close(); ?>
<?php 
/**
 +---------------------------------------------------------------------------------+
 | DW3 PME Kit BETA                                                                |
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
			<td width="*" style="margin:0px;padding:0px;">
                <h2>Prototypes de documents</h2>
            </td>
			<td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
				<?php if($APREAD_ONLY == false) { ?><button style="margin:0px 2px 0px 2px;padding:8px;" onclick="openNEW();"><span class="material-icons">add</span></button> <?php } ?>
			 </td>
		</tr>
	</table>
</div>

<div id='divMAIN' class='divMAIN' style="padding-top:50px;">
<img src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>
</div>
<div id="divEDIT" class="divEDITOR">
</div>
<div id="divEDIT_LINE" class="divEDITOR">
</div>
<div id="divNEW" class="divEDITOR" style='max-width:450px;'>
    <div id='divNEW_HEADER' class='dw3_form_head'>
		<h2>Nouveau document</h2>
		<button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div> 
    <div style='position:absolute;top:40px;left:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>
        <div class="divBOX">Titre:
            <input id="newNAME" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Description:
            <input id="newDESC" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class='divBOX'>Destinataire:
            <select id='newPARENT'>
                <option value='customer'>Client</option>
                <option value='user'>Employé</option>
            </select>
        </div>
        <div class='divBOX'>Type de total:
            <select id='newTYPE'>
                <option value='NONE'>Aucun</option>
                <option value='CASH'>Argent</option>
                <option value='POINTS'>Points</option>
                <option value='POURCENT'>Pourcentage</option>
            </select>
        </div>
        <div class="divBOX">Total maximum:
            <input id="newMAX" type="number" value="0" onclick="detectCLICK(event,this);">
            <i style='font-size:0.8em;'>0 ou vide = aucun maximum</i>
        </div>
        <br><br>
	</div>
    <div id='divNEW_FOOT' style='padding:3px;background:rgba(200, 200, 200, 0.7);'>
        <button class='grey' onclick="closeNEW();"><span class="material-icons">cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>
        <button class='blue' onclick="newQUIZ();"><span class="material-icons">add</span>Créer</button>
	</div>
</div>

<div id="divSEL_USER" class="divSELECT" style='min-width:330px;min-height:90%;'><input id='whySEL_USER' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_USER_HEADER" class='dw3_form_head'><h3>
	    Sélection d'utilisateur</h3>
        <button onclick='closeSEL_USER();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selUSER" oninput="getSEL_USER('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_USER_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un employé.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class='grey' onclick="closeSEL_USER();getElementById('divSEL_USER_DATA').innerHTML='Inscrire votre recherche pour trouver un employé.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divSEL_CUSTOMER" class="divSELECT" style='min-width:330px;min-height:90%;'><input id='whySEL_CUSTOMER' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_CUSTOMER_HEADER" class='dw3_form_head'><h3>
	    Sélection d'utilisateur</h3>
        <button onclick='closeSEL_CUSTOMER();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selCUSTOMER" oninput="getSEL_CUSTOMER('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_CUSTOMER_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un employé.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class='grey' onclick="closeSEL_CUSTOMER();getElementById('divSEL_CUSTOMER_DATA').innerHTML='Inscrire votre recherche pour trouver un employé.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>


<div id="divSEL_PRD" class="divSELECT" style='min-width:330px;max-width:100%;width:80%;min-height:90%;'><input id='whySEL_PRD' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_PRD_HEADER" class='dw3_form_head'>
        <h2>Sélection ID <?php echo $dw3_lbl["PRD"]; ?></h2>
        <button onclick='closeSEL_PRD();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selPRD" oninput="getSEL_PRD('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_PRD_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un fournisseur.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class='grey' onclick="closeSEL_PRD();getElementById('divSEL_PRD_DATA').innerHTML='Inscrire votre recherche pour trouver un fournisseur.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;"></div>

<div id='divUPLOAD_IMG' style='display:none;'>
    <form id='frmUPLOAD_IMG' action="/upload_img.php?KEY=<?php echo $KEY;?>" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="imgToUpload" id="imgToUpload" onchange="document.getElementById('submitUPLOAD_IMG').click();">    
    <input type="text" name="fileNameImg" id="fileNameImg" value='0'>
    <input type="submit" value="Upload Image" name="submit_img" id='submitUPLOAD_IMG'>
    </form>
</div>

<div id="divMSG"></div>
<div id="divMSG2" class='divMSG'>Adresse courriel au compte: <input type='text' id='txtPDF_EML' disabled style='text-align:center;max-width:500px;'><span style='font-size:0.7em;'>Assurez-vous aussi d'avoir enregistré les modifications avant d'envoyer le document.</span><div style='height:20px;'> </div>Type de document: <br><span style='margin:5px;border:1px solid lightgrey;border-radius:5px;padding:0px 5px;'><label for='eml_doc_type_pdf'>PDF</label> <input type='radio' name='eml_doc_type' id='eml_doc_type_pdf' value='PDF' checked></span><br><span style='margin:5px;border:1px solid lightgrey;border-radius:5px;padding:0px 5px;'><label for='eml_doc_type_link'>Lien</label> <input type='radio' name='eml_doc_type' id='eml_doc_type_link' value='LINK'></span><div style='height:20px;'> </div><div id="divMSG2_DATA"></div></div>
<div id="divOPT"></div>
<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
//jQ
$(document).ready(function (){
        dragElement(document.getElementById('divNEW'));
        getQUIZS();

		$("#frmUPLOAD_IMG").submit(function (e)
			{
				e.preventDefault();
				var file_data = $('#imgToUpload').prop('files')[0];   
				var form_data = new FormData();                  
				form_data.append('imgToUpload', file_data);
				$.ajax({
					url: 'upload_img.php?KEY='+KEY, 
					dataType: 'text',
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'post',
					success: function (response)
						{
							document.getElementById("lnIMG"+active_target).value = response;
							document.getElementById("imgIMG"+active_target).src = "/pub/upload/"+response;
							closeMSG(); 
							//document.getElementById("divFADE2").style.opacity = "1";
							//document.getElementById("divFADE2").style.display = "inline-block";
							//document.getElementById("divMSG").style.display = "inline-block";
							//document.getElementById("divMSG").innerHTML = response + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
						},
					error: function (xhr, status, error)
						{
							document.getElementById("divFADE2").style.opacity = "1";
							document.getElementById("divFADE2").style.display = "inline-block";
							document.getElementById("divMSG").style.display = "inline-block";
							document.getElementById("divMSG").innerHTML = error + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";

						}
				});
			});


});

	
//_	
var KEY = '<?php echo($_GET['KEY']); ?>';
//*********************************************************
//                  DOCUMENT PROTOTYPES
//*********************************************************
var currentQUIZ;
function getQUIZS() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getQUIZS.php?KEY=' + KEY , true);
		xmlhttp.send();
		
}
function optQUIZ(ID,name,parent_table) {
    document.getElementById("divMSG").style.display = "inline-block";
    if (parent_table == "user"){ 
        var parent_dest_name = "employé";
    
    } else if (parent_table == "customer"){
        var parent_dest_name = "client";
    }
    <?php if($APREAD_ONLY == false) { ?>
    document.getElementById("divMSG").innerHTML = "<button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeMSG();'><span class='material-icons'>cancel</span></button>" 
    + name + "<br><button onclick=\"getQUIZ('"+ID+"');\"><span class='material-icons' style='vertical-align:middle;'>auto_fix_high</span>Modifier le document</button>"
    +"<br><button onclick=\"copyQUIZ('"+ID+"');\"><span class='material-icons' style='vertical-align:middle;'>content_copy</span>Copier le document</button>"
    +"<br><button onclick=\"sendQUIZ('"+ID+"','"+parent_table+"');\"><span class='material-icons' style='vertical-align:middle;'>send</span>Assigner à un "+parent_dest_name+"</button>"
    +"<br><button onclick=\"getFILLED_QUIZ('"+ID+"');\"><span class='material-icons' style='vertical-align:middle;'>preview</span>Voir les documents complétés</button>";
    <?php } else { ?>
        getFILLED_QUIZ(ID);
    <?php } ?>

}

function copyQUIZ(ID) {
	currentQUIZ = ID;
    closeMSG();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        getQUIZ(this.responseText);
        getQUIZS();
        closeMSG();
	  }
	};
		xmlhttp.open('GET', 'copyQUIZ.php?KEY=' + KEY + '&ID=' + ID  , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}
//assigner un quiz a un utilisateur (client ou user), crée un report et demande a qui l'assigner
var newREPORT_ID = "";
function sendQUIZ(ID,parent_table) {
    currentQUIZ = ID;
    closeMSG();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if(parent_table == "user"){
            linkToUser(this.responseText);
        } else if (parent_table == "customer"){
            linkToCustomer(this.responseText);
            //console.log(this.responseText);
        }
        newREPORT_ID =this.responseText;
	  }
      closeMSG();
	};
		xmlhttp.open('GET', 'newREPORT.php?KEY=' + KEY + '&ID=' + ID  , true);
		xmlhttp.send();
        document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

}
function getQUIZ(ID) {
	currentQUIZ = ID;
    closeMSG();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divEDIT").innerHTML = this.responseText;
		document.getElementById("divEDIT").style.display = "inline-block";
		dragElement(document.getElementById('divEDIT'));
		getLINES(ID);
        closeMSG();
        document.getElementById("divFADE").style.display = "inline-block";
		document.getElementById("divFADE").style.opacity = "0.4";
        document.getElementById("divFADE").style.width = "100%";
	  }
	};
		xmlhttp.open('GET', 'getQUIZ.php?KEY=' + KEY + '&ID=' + ID  , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}
function getLINES(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("DIV_LINES").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getLINES.php?KEY=' + KEY + '&ID=' + ID  , true);
		xmlhttp.send();
		
}

function getLINE(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divEDIT_LINE").innerHTML = this.responseText;
		 document.getElementById("divEDIT_LINE").style.display = "inline-block";
		 dragElement(document.getElementById('divEDIT_LINE'));
		 document.getElementById("lnNAME").focus();
	  }
	};
		xmlhttp.open('GET', 'getLINE.php?KEY=' + KEY + '&ID=' + ID  , true);
		xmlhttp.send();
		
}

function newQUIZ(){
	var GRPBOX = document.getElementById("newTYPE");
	var sTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("newPARENT");
	var sPARENT = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sNAME    = document.getElementById("newNAME").value;
	var sDESC     = document.getElementById("newDESC").value;
	var sMAX     = document.getElementById("newMAX").value;
	
	if (sNAME == ""){
		document.getElementById("newNAME").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newNAME").focus();
		return;
	} else {
		document.getElementById("newNAME").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
	}	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.substr(0, 3) != "Err"){
                closeNEW();
                getQUIZ(this.responseText.trim());
                getQUIZS();
                closeMSG();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newQUIZ.php?KEY=' + KEY 
            + '&TYPE=' + encodeURIComponent(sTYPE)     
            + '&PARENT=' + encodeURIComponent(sPARENT)     
            + '&NAME=' + encodeURIComponent(sNAME)   
            + '&DESC=' + encodeURIComponent(sDESC)   
            + '&MAX=' + encodeURIComponent(sMAX) 
            ,true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}

function newLINE(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
                getLINE(this.responseText.trim());
				getLINES(currentQUIZ);
                closeMSG();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newLINE.php?KEY=' + KEY+ '&ID=' + encodeURIComponent(currentQUIZ)  ,true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}

function closeEDIT_LINE(){
	document.getElementById("divEDIT_LINE").style.display="none";
}
function updLINE(sID){
    if (document.getElementById("lnREQ").checked == false){ var sREQ = "0"; } else { var sREQ = "1"; }
    if (document.getElementById("lnMULT").checked == false){ var sMULT = "0"; } else { var sMULT = "1"; }
    if (document.getElementById("lnTOT").checked == false){ var sTOT = "0"; } else { var sTOT = "1"; }
    if (document.getElementById("lnEXCLUDE").checked == false){ var sEXCLUDE = "0"; } else { var sEXCLUDE = "1"; }
    if (document.getElementById("lnLAST").checked == false){ var sLAST = "0"; } else { var sLAST = "1"; }
	var GRPBOX = document.getElementById("lnREC"); //mandatory
	var sREC = GRPBOX.options[GRPBOX.selectedIndex].value;	//record associer
	var GRPBOX = document.getElementById("lnTYPE"); 
	var sTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("lnSIZE");
	var sSIZE = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("lnALIGN");
	var sALIGN = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var sMULT_L    = document.getElementById("lnMULT_L").value;
	var sPOS    = document.getElementById("lnPOS").value;
	var sNAME    = document.getElementById("lnNAME").value;
	var sDESC     = document.getElementById("lnDESC").value;
	var sNAME_EN    = document.getElementById("lnNAME_EN").value;
	var sDESC_EN     = document.getElementById("lnDESC_EN").value;
	var sPRD     = document.getElementById("lnPRD").value;
	var sCH1     = document.getElementById("lnCHOICE1").value;
	var sCH1_EN     = document.getElementById("lnCHOICE1_EN").value;
	var sVAL1     = document.getElementById("lnVALUE1").value;
	var sIMG1     = document.getElementById("lnIMG1").value;
	var sCH2     = document.getElementById("lnCHOICE2").value;
	var sCH2_EN     = document.getElementById("lnCHOICE2_EN").value;
	var sVAL2     = document.getElementById("lnVALUE2").value;
	var sIMG2     = document.getElementById("lnIMG2").value;
	var sCH3     = document.getElementById("lnCHOICE3").value;
	var sCH3_EN     = document.getElementById("lnCHOICE3_EN").value;
	var sVAL3     = document.getElementById("lnVALUE3").value;
	var sIMG3     = document.getElementById("lnIMG3").value;
	var sCH4     = document.getElementById("lnCHOICE4").value;
	var sCH4_EN     = document.getElementById("lnCHOICE4_EN").value;
	var sVAL4     = document.getElementById("lnVALUE4").value;
	var sIMG4     = document.getElementById("lnIMG4").value;
	var sCH5     = document.getElementById("lnCHOICE5").value;
	var sCH5_EN     = document.getElementById("lnCHOICE5_EN").value;
	var sVAL5     = document.getElementById("lnVALUE5").value;
	var sIMG5     = document.getElementById("lnIMG5").value;
	var sCH6     = document.getElementById("lnCHOICE6").value;
	var sCH6_EN     = document.getElementById("lnCHOICE6_EN").value;
	var sVAL6     = document.getElementById("lnVALUE6").value;
	var sIMG6     = document.getElementById("lnIMG6").value;
	var sCH7     = document.getElementById("lnCHOICE7").value;
	var sCH7_EN     = document.getElementById("lnCHOICE7_EN").value;
	var sVAL7     = document.getElementById("lnVALUE7").value;
	var sIMG7     = document.getElementById("lnIMG7").value;
	var sCH8     = document.getElementById("lnCHOICE8").value;
	var sCH8_EN     = document.getElementById("lnCHOICE8_EN").value;
	var sVAL8     = document.getElementById("lnVALUE8").value;
	var sIMG8     = document.getElementById("lnIMG8").value;
	var sCH9     = document.getElementById("lnCHOICE9").value;
	var sCH9_EN     = document.getElementById("lnCHOICE9_EN").value;
	var sVAL9     = document.getElementById("lnVALUE9").value;
	var sIMG9     = document.getElementById("lnIMG9").value;
	var sCH0     = document.getElementById("lnCHOICE0").value;
	var sCH0_EN     = document.getElementById("lnCHOICE0_EN").value;
	var sVAL0     = document.getElementById("lnVALUE0").value;
	var sIMG0     = document.getElementById("lnIMG0").value;
	
/* 	if (sNAME == ""){
		document.getElementById("lnNAME").style.boxShadow = "5px 10px 15px red";
		document.getElementById("lnNAME").focus();
		return;
	} else {
		document.getElementById("lnNAME").style.boxShadow = "5px 10px 15px #333";
	} */
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				getLINES(currentQUIZ);
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
				closeEDIT_LINE();
                closeMSG();
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updLINE.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)
										+ '&REQ=' + encodeURIComponent(sREQ)
										+ '&T=' + encodeURIComponent(sTOT)
										+ '&M=' + encodeURIComponent(sMULT)
										+ '&ML=' + encodeURIComponent(sMULT_L)
										+ '&REC=' + encodeURIComponent(sREC)
										+ '&SIZE=' + encodeURIComponent(sSIZE)
										+ '&POS=' + encodeURIComponent(sPOS) 
										+ '&TYPE=' + encodeURIComponent(sTYPE)
										+ '&ALIGN=' + encodeURIComponent(sALIGN)
										+ '&NAME=' + encodeURIComponent(sNAME)
										+ '&DESC_EN=' + encodeURIComponent(sDESC_EN)
										+ '&NAME_EN=' + encodeURIComponent(sNAME_EN)
										+ '&DESC=' + encodeURIComponent(sDESC)
										+ '&PRD=' + sPRD
										+ '&EX=' + sEXCLUDE
										+ '&LS=' + sLAST
										+ '&C1=' + encodeURIComponent(sCH1)
										+ '&C1_EN=' + encodeURIComponent(sCH1_EN)
										+ '&V1=' + encodeURIComponent(sVAL1)
										+ '&I1=' + encodeURIComponent(sIMG1)
										+ '&C2=' + encodeURIComponent(sCH2)
										+ '&C2_EN=' + encodeURIComponent(sCH2_EN)
										+ '&V2=' + encodeURIComponent(sVAL2)
										+ '&I2=' + encodeURIComponent(sIMG2)
										+ '&C3=' + encodeURIComponent(sCH3)
										+ '&C3_EN=' + encodeURIComponent(sCH3_EN)
										+ '&V3=' + encodeURIComponent(sVAL3)
										+ '&I3=' + encodeURIComponent(sIMG3)
										+ '&C4=' + encodeURIComponent(sCH4)
										+ '&C4_EN=' + encodeURIComponent(sCH4_EN)
										+ '&V4=' + encodeURIComponent(sVAL4)   
										+ '&I4=' + encodeURIComponent(sIMG4)
										+ '&C5=' + encodeURIComponent(sCH5)
										+ '&C5_EN=' + encodeURIComponent(sCH5_EN)
										+ '&V5=' + encodeURIComponent(sVAL5)
										+ '&I5=' + encodeURIComponent(sIMG5)
										+ '&C6=' + encodeURIComponent(sCH6) 
										+ '&C6_EN=' + encodeURIComponent(sCH6_EN) 
										+ '&V6=' + encodeURIComponent(sVAL6)
										+ '&I6=' + encodeURIComponent(sIMG6)
										+ '&C7=' + encodeURIComponent(sCH7) 
										+ '&C7_EN=' + encodeURIComponent(sCH7_EN) 
										+ '&V7=' + encodeURIComponent(sVAL7)
										+ '&I7=' + encodeURIComponent(sIMG7)
										+ '&C8=' + encodeURIComponent(sCH8) 
										+ '&C8_EN=' + encodeURIComponent(sCH8_EN) 
										+ '&V8=' + encodeURIComponent(sVAL8)
										+ '&I8=' + encodeURIComponent(sIMG8)
										+ '&C9=' + encodeURIComponent(sCH9) 
										+ '&C9_EN=' + encodeURIComponent(sCH9_EN) 
										+ '&V9=' + encodeURIComponent(sVAL9)
										+ '&I9=' + encodeURIComponent(sIMG9)
										+ '&C0=' + encodeURIComponent(sCH0) 
										+ '&C0_EN=' + encodeURIComponent(sCH0_EN) 
										+ '&V0=' + encodeURIComponent(sVAL0)
										+ '&I0=' + encodeURIComponent(sIMG0)
                                        ,true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}

var active_target = 0;
function selIMG_UPLOAD(target,img) {
	active_target = target;
	document.getElementById("lnIMG"+target).value = img;
	document.getElementById("imgIMG"+target).src = "/pub/upload/"+img;
}

function setMULT_LINE(target) {
    document.getElementById("lnMULT_L").value = target;
    closeMSG();
}
function selMULT_LINE(head_id,line_id) {
	var xmlhttp = new XMLHttpRequest();	
	xmlhttp.onreadystatechange = function() {	  
		if (this.readyState == 4 && this.status == 200) {			
            document.getElementById("divFADE2").style.display = "inline-block";
            document.getElementById("divFADE2").style.opacity = "0.4";			
			document.getElementById("divMSG").style.display = "inline-block";			
			document.getElementById("divMSG").innerHTML = this.responseText;	  
		}	
	};		
	xmlhttp.open('GET', 'selMULT_LINE.php?KEY=' + KEY + "&HEAD=" + head_id + "&ID=" + line_id, true);		
	xmlhttp.send();	
}

function selIMG(target) {
	active_target = target;
	var xmlhttp = new XMLHttpRequest();	
	xmlhttp.onreadystatechange = function() {	  
		if (this.readyState == 4 && this.status == 200) {			
			document.getElementById("divFADE").style.width = "100%";			
			document.getElementById("divMSG").style.display = "inline-block";			
			document.getElementById("divMSG").innerHTML = this.responseText;	  
		}	
	};		
	xmlhttp.open('GET', 'getIMG.php?KEY=' + KEY + "&TARGET=" + target, true);		
	xmlhttp.send();	
}

function updQUIZ(sID){
	var GRPBOX = document.getElementById("qzTYPE");
	var sTYPE = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("qzPARENT");
	var sPARENT = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sNAME    = document.getElementById("qzNAME").value;
	var sDESC     = document.getElementById("qzDESC").value;
	var sNAME_EN    = document.getElementById("qzNAME_EN").value;
	var sDESC_EN     = document.getElementById("qzDESC_EN").value;
	var sMAX     = document.getElementById("qzMAX").value;
	var sNEXT     = document.getElementById("qzNEXT").value;
    if (document.getElementById("qzLINK_TO").checked == false){ var sLINK_TO = "0"; } else { var sLINK_TO = "1"; }
    if (document.getElementById("qzCAPTCHA").checked == false){ var sCAPTCHA = "0"; } else { var sCAPTCHA = "1"; }
    if (document.getElementById("qzREEDIT").checked == false){ var sREEDIT = "0"; } else { var sREEDIT = "1"; }
    if (document.getElementById("qzVIEW").checked == false){ var sVIEW = "0"; } else { var sVIEW = "1"; }
    if (document.getElementById("qzAUTO_ADD").checked == false){ var sAUTO_ADD = "0"; } else { var sAUTO_ADD = "1"; }

	if (sNAME == ""){
		document.getElementById("qzNAME").style.boxShadow = "5px 10px 15px red";
		document.getElementById("qzNAME").focus();
		return;
	} else {
		document.getElementById("qzNAME").style.boxShadow = "5px 10px 15px #333";
	}
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				getQUIZS();
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
                closeMSG();
                closeEDITOR();
		  } else {
			  	document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updQUIZ.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)  
										+ '&TYPE=' + encodeURIComponent(sTYPE)     
										+ '&PARENT=' + encodeURIComponent(sPARENT)     
										+ '&NAME=' + encodeURIComponent(sNAME)   
										+ '&DESC=' + encodeURIComponent(sDESC)   
										+ '&NAME_EN=' + encodeURIComponent(sNAME_EN)   
										+ '&DESC_EN=' + encodeURIComponent(sDESC_EN)   
										+ '&MAX=' + encodeURIComponent(sMAX)   
										+ '&NEXT=' + encodeURIComponent(sNEXT)   
										+ '&REEDIT=' + encodeURIComponent(sREEDIT)   
										+ '&CAPTCHA=' + encodeURIComponent(sCAPTCHA)   
										+ '&LINK_TO=' + encodeURIComponent(sLINK_TO)   
										+ '&VIEW=' + encodeURIComponent(sVIEW)   
										+ '&AUTO_ADD=' + encodeURIComponent(sAUTO_ADD)   
                                        ,true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}

function pubQUIZ(sID){
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Les documents publiés ne peuvent être modifiés, seulement copiés sous un autre nom.<div style='height:20px;'> </div><button onclick=\"closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button> <button onclick=\"closeMSG();publishQUIZ('"+sID+"');\"><span class='material-icons' style='vertical-align:middle;'>send</span> Publier</button>";

}

function publishQUIZ(sID){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Document publié.");
        closeMSG();
        closeEDITOR();
		getQUIZS();
		addMsg("Lien pour remplir le document:<br><a href='https://<?php echo $_SERVER["SERVER_NAME"];?>/pub/page/quiz/index.php?ID="+sID+"' target='_blank'>https://<?php echo $_SERVER["SERVER_NAME"];?>/pub/page/quiz/index.php?ID="+sID+"</a><div style='height:20px;'> </div><button onclick=\"closeMSG();\"><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>");
    }
	};
		xmlhttp.open('GET', 'pubQUIZ.php?KEY=' + KEY + '&ID=' + encodeURIComponent(sID)  
                                        ,true);
		xmlhttp.send();
}

function deleteQUIZ(ID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='red' onclick='delQUIZ(" + ID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button>";
}

function updDB(ROW,DB,UID,VAL) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				addNotif("Record mis à jour");
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'updDB.php?KEY=' + KEY + '&ROW=' + ROW+ '&DB=' + DB+ '&VAL=' + VAL+ '&ID=' + UID , true);
		xmlhttp.send();
}

function delQUIZ(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				closeMSG();
				addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
			    closeEDITOR();
				getQUIZS();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delQUIZ.php?KEY=' + KEY + '&ID=' + ID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}

function deleteLINE(ID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='red' onclick='delLINE(" + ID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button>";
}

function delLINE(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
				closeEDIT_LINE();
				getLINES(currentQUIZ);
				closeMSG();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delLINE.php?KEY=' + KEY + '&ID=' + ID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}

//*********************************************************
//                       REPORTS
//*********************************************************
var currentREPORT;
function getFILLED_QUIZ(ID) {
	currentQUIZ = ID;
    closeMSG();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divEDIT").innerHTML = this.responseText;
		document.getElementById("divEDIT").style.display = "inline-block";
		dragElement(document.getElementById('divEDIT'));
        closeMSG();
        document.getElementById("divFADE").style.display = "inline-block";
		document.getElementById("divFADE").style.opacity = "0.4";
        document.getElementById("divFADE").style.width = "100%";
	  }
	};
		xmlhttp.open('GET', 'getFILLED_QUIZ.php?KEY=' + KEY + '&ID=' + ID  , true);
		xmlhttp.send();	
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";			
}

function getREPORT(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("divEDIT_LINE").innerHTML = this.responseText;
            document.getElementById("divEDIT_LINE").style.display = "inline-block";
            dragElement(document.getElementById('divEDIT_LINE'));
            closeMSG();
            document.getElementById("divFADE").style.display = "inline-block";
            document.getElementById("divFADE").style.opacity = "0.4";
            document.getElementById("divFADE").style.width = "100%";	  
        }
	};
    xmlhttp.open('GET', 'getREPORT.php?KEY=' + KEY + '&ID=' + ID  , true);
    xmlhttp.send();
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "0.4";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";		
}
function calculTotal(sID) {
    if (Number.isNaN(parseFloat(document.getElementById("lnVAL1_"+sID).value.replace("$", "")))){
    	document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divFADE2").style.opacity = "1";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Nombre invalide.<div style='height:20px;'> </div> <button class='grey' onclick=\"closeMSG();document.getElementById('lnVAL1_"+sID+"').focus();\"><span class='material-icons'>done</span> Ok</button>";
        document.getElementById("lnVAL1_"+sID).style.boxShadow = "0px 0px 4px 2px red";
        return false;   
    }
    document.getElementById("lnVAL1_"+sID).style.boxShadow = "rgba(0, 0, 0, 0.35) 0px 5px 5px 0px";
    var iSubTot = parseFloat(document.getElementById("lnVAL1_"+sID).value.replace("$", ""));
    var actualTps = parseFloat(<?php echo $TPS_QC; ?>);
    var actualTvp = parseFloat(<?php echo $TVP_QC; ?>);
    var iTps = (iSubTot/100) * actualTps;
    var iTvp = (iSubTot/100) * actualTvp;
    var iTot = iSubTot + iTps + iTvp;
    //document.getElementById("lnVAL1_"+sID).value = iSubTot.toFixed(2).toString() + "$";
    document.getElementById("lnVAL2_"+sID).value = iTps.toFixed(2).toString() + "$";
    document.getElementById("lnVAL3_"+sID).value = iTvp.toFixed(2).toString() + "$";
    document.getElementById("lnVAL4_"+sID).value = iTot.toFixed(2).toString() + "$";
    return false;
}
function copy_report_url(ID) {
    navigator.clipboard.writeText('https://<?php echo $_SERVER["SERVER_NAME"]; ?>/pub/page/quiz/index.php?ID='+ ID);
    document.getElementById("btn_copy_url").innerHTML="<span class='material-icons' style='color:green;font-size:10px;'>assignment_turned_in</span>";
	addNotif("Adresse copiée dans le presse-papier.");
} 
function deleteREPORT(ID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><div style='height:20px;'> </div> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='red' onclick='delREPORT(" + ID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button>";
}
function delREPORT(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				closeMSG();
				addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
			    closeEDIT_LINE();
				getFILLED_QUIZ(currentQUIZ);
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'delREPORT.php?KEY=' + KEY + '&ID=' + ID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}
function closeMSG2() {
	document.getElementById("divFADE2").style.display = "none";
	document.getElementById("divFADE2").style.opacity = "0";
	document.getElementById("divMSG2").style.display = "none";
}
function pdfREPORT(ID,EML,ACCOUNT_ID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG2").style.display = "inline-block";
	document.getElementById("txtPDF_EML").value = EML;
	document.getElementById("divMSG2_DATA").innerHTML = "<button class='grey' onclick='closeMSG2();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='blue' onclick='sendPDF_REPORT(" + ID + ","+ACCOUNT_ID+");'><span class='material-icons' style='vertical-align:middle;'>send</span> Envoyer</button>";
}
function openPDF_REPORT(ID) {
    window.open('sendPDF.php?KEY=' + KEY + '&ID=' + ID+ '&EML=','_blank');
}

function sendPDF_REPORT(ID,ACCOUNT_ID) {
    closeMSG2();
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
    var sPDF_EML = document.getElementById("txtPDF_EML").value;
    if (document.getElementById("eml_doc_type_pdf").checked ==true){
        sSCRIPT_NAME = "sendPDF";
    } else {
        sSCRIPT_NAME = "sendLINK";
    }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				closeMSG();
				addNotif("Courriel envoyé.");
			    closeEDIT_LINE();
				getFILLED_QUIZ(currentQUIZ);
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  } else if (this.readyState == 4 && this.status >= 400){
		document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Une erreur système s'est produite, veuillez contacter votre administrateur web.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	  }
	};
		xmlhttp.open('GET', sSCRIPT_NAME+'.php?KEY=' + KEY + '&ID=' + ID + '&EML=' + sPDF_EML + '&UID=' + ACCOUNT_ID, true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}

function updPARENT_ID(sRID,sUID,sDB) {
    currentREPORT = sRID;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("L'utilisateur a été mis à jour.");
        //getFILLED_QUIZ(currentQUIZ);
        getREPORT(sRID);
	  }
	};
    xmlhttp.open('GET', 'updPARENT_ID.php?KEY=' + KEY + '&RID=' + sRID + "&UID=" + sUID + "&DB=" + sDB, true);
    xmlhttp.send();
}


//SELECTION PRODUIT
function getSEL_PRD(sS) {
	if(sS==""){sS = document.getElementById("selPRD").value.trim();}
    why = document.getElementById("whySEL_PRD").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_PRD_DATA").innerHTML = this.responseText;
         dragElement(document.getElementById('divSEL_PRD'));
	  }
	};
    xmlhttp.open('GET', 'getSEL_PRD.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) + "&why=" + why, true);
    xmlhttp.send();
}
function openSEL_PRD(why) {
    document.getElementById('divSEL_PRD').style.display = "inline-block";
    document.getElementById('whySEL_PRD').value = why;
    getSEL_PRD('');
}
function closeSEL_PRD() {
    document.getElementById('divSEL_PRD').style.display = "none";
}
function validatePRD(prID,why) {
    //var elNEW =  document.getElementById('newPRD');
    //if (typeof(elNEW) != 'undefined' && elNEW != null && why == "NEW") {elNEW.value = prID;}
    //getPRD_INFO(prID);
    //var elUPD =  document.getElementById('rPRODUCT_ID');
    //if (typeof(elUPD) != 'undefined' && elUPD != null && why == "UPD") {elUPD.value = prID;}
    document.getElementById('lnPRD').value = prID;
    closeSEL_PRD();
}

//SELECTION USER
function linkToUser(RID) {
    currentREPORT = RID;
    openSEL_USER("",RID);
}
function getSEL_USER(sS,RID) {
	if(sS==""){sS = document.getElementById("selUSER").value.trim();}
    why = document.getElementById("whySEL_USER").value.trim();
    //seluser = document.getElementById("newUSER").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_USER_DATA").innerHTML = this.responseText;
         dragElement(document.getElementById('divSEL_USER'));
	  }
	};
    xmlhttp.open('GET', 'getSEL_USER.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) + "&why=" + why+ "&RID=" + RID, true);
    xmlhttp.send();
}
function openSEL_USER(why,RID) {
    document.getElementById('divSEL_USER').style.display = "inline-block";
    //document.getElementById('whySEL_USER').value = why;
    getSEL_USER('',RID);
}
function closeSEL_USER() {
    document.getElementById('divSEL_USER').style.display = "none";
    if (newREPORT_ID!=""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            newREPORT_ID = "";
        }
        };
            xmlhttp.open('GET', 'delREPORT.php?KEY=' + KEY + '&ID=' + newREPORT_ID , true);
            xmlhttp.send();
    }
}
function validateUSER(sID,why) {
    //document.getElementById('newUSER').value = sID;
    updPARENT_ID(currentREPORT,sID,"user");
    newREPORT_ID = "";
    closeSEL_USER();
}

//SELECTION CUSTOMER
function linkToCustomer(RID) {
    currentREPORT = RID;
    console.log(currentREPORT);
    openSEL_CUSTOMER("",RID);
}
function getSEL_CUSTOMER(sS,RID) {
	if(sS==""){sS = document.getElementById("selCUSTOMER").value.trim();}
    why = document.getElementById("whySEL_CUSTOMER").value.trim();
    //seluser = document.getElementById("newUSER").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_CUSTOMER_DATA").innerHTML = this.responseText;
         dragElement(document.getElementById('divSEL_CUSTOMER'));
	  }
	};
    xmlhttp.open('GET', 'getSEL_CUSTOMER.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) + "&why=" + why+ "&RID=" + RID, true);
    xmlhttp.send();
}
function openSEL_CUSTOMER(why,RID) {
    document.getElementById('divSEL_CUSTOMER').style.display = "inline-block";
    //document.getElementById('whySEL_USER').value = why;
    getSEL_CUSTOMER('',RID);
}
function closeSEL_CUSTOMER() {
    document.getElementById('divSEL_CUSTOMER').style.display = "none";
    if (newREPORT_ID!=""){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            newREPORT_ID = "";
        }
        };
            xmlhttp.open('GET', 'delREPORT.php?KEY=' + KEY + '&ID=' + newREPORT_ID , true);
            xmlhttp.send();
    }
}
function validateCUSTOMER(sID,why) {
    //document.getElementById('newUSER').value = sID;
    updPARENT_ID(currentREPORT,sID,"customer");
    newREPORT_ID = "";
    closeSEL_CUSTOMER();
}
function updREPORT(RID) { 
    //const forms = document.getElementById('report_editor');
    const form = document.getElementById('report_editor');
    var urlDATA = "updREPORT.php?KEY="+KEY+"&RID="+RID;
    var cLN = 0;
    var BreakException = {};
    try {
        Array.from(form.elements).forEach((input) => {
            cLN++;
            var qID = input.id.substr(5);
            if (input.type == "text"||input.type == "color"||input.type == "password"||input.type == "date"||input.type == "time"){
                var qVAL = input.value;
            } else if (input.type == "checkbox"){
                if (input.checked == false){ 
                    var qVAL = "0"; 
                } else { 
                    var qVAL = "1"; 
                }
            } else if (input.nodeName == "SELECT" || input.type == "select-one"){
                var GRPBOX = document.getElementById(input.id);
                var qVAL = GRPBOX.options[GRPBOX.selectedIndex].value;	
            }
            urlDATA += "&"+qID+"="+encodeURIComponent(qVAL);
        });
    } catch (e) {
        if (e !== BreakException) throw e;
        return;
    }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText != ""){
            document.getElementById("dw3_msg").style.display = "inline-block";
            document.getElementById("dw3_body_fade").style.display = "inline-block";
            document.getElementById("dw3_body_fade").style.opacity = "0.6";
            document.getElementById("dw3_msg").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick=\"dw3_msg_close();\"><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
        } else {
            addNotif("Mise à jour terminée."); 
            closeMSG();
            closeEDITOR();        
        }
	  }
	};
    xmlhttp.open('GET', urlDATA,true);
	xmlhttp.send();
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "0.4";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;border-radius:10px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
}
</script>
</body>
</html><?php $dw3_conn->close();?>
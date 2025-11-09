<?php 
/**
 +---------------------------------------------------------------------------------+
 | DW3 BETA                                                                        |
 | Version 1                                                                       |
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
				<input type="search" onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" onkeyup="getARTS('','',LIMIT);" placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
			</td>
			<td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
				<?php if($APREAD_ONLY == false) { ?><button class='blue' style="margin:0px 2px 0px 2px;padding:8px;" onclick="openNEW();"><span class="material-icons">add</span></button><?php } ?>
				<button class='grey' style="margin:0px 2px 0px 2px;padding:8px;" onclick="openPARAM();"><span class="material-icons">settings</span></button>
			 </td>
		</tr>
	</table>
</div>

<div id='divFILTRE'>
<h3><?php echo $dw3_lbl["FILTER"]; ?></h3>
		<table style='width:100%'>
            <tr><td>Actif</td><td>
            <select id='selACTIVE'>
               <option selected value=''><?php echo $dw3_lbl["ALL"]; ?></option>
               <option value='1'>Actif</option>
               <option value='0'>Inactif</option>
            </select></td></tr>
            <tr><td>Auteur</td><td>
            <select id='selAUTHOR'>
                <option selected value=''><?php echo $dw3_lbl["ALL"]; ?></option>
                <?php
                        $sql = "SELECT DISTINCT(author_name) as author_name
                                FROM article ";
                        $result = $dw3_conn->query($sql);
                        if ($result->num_rows > 0) {	
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["author_name"]  . "'>" . $row["author_name"]  . "</option>";
                            }
                        }
                ?>
            </select></td></tr>
        </table><br>
		<div style='width:100%;text-align:center;'><button class='grey' onclick="closeFILTRE();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button><button onclick="closeFILTRE();getARTS('','',LIMIT);"><span class="material-icons">filter_alt</span> <?php echo $dw3_lbl["FILTER"]; ?></button></div>
</div>

<div id='divMAIN' class='divMAIN' style="padding-top:50px;min-height:100vh;">
<img src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>
</div>
<div id="divEDIT" class="divEDITOR">
	<div id="divEDIT_MAIN"></div>
</div>

<div id="divNEW" class="divEDITOR" style='width:336px;min-height:320px;max-height:320px;'>
    <div id='divNEW_HEADER' style='cursor:move;position:absolute;top:0px;right:0px;left:0px;height:40px;background:rgba(207, 205, 205, 0.9);'>
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'><?php if ($USER_LANG == "FR"){echo "Nouvel article";}else{echo "New article";} ?></div></h3>
		<button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div> 
    <div style='position:absolute;top:40px;left:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>
        <div class="divBOX">Nom de l'article en français:
            <input id="newNAME_FR" type="text" value="">
        </div>
        <div class="divBOX">Nom de l'article en anglais:
            <input id="newNAME_EN" type="text" value="">
        </div>
	</div>
    <div id='divNEW_FOOT' style='padding:3px;background:rgba(200, 200, 200, 0.7);'>
        <button class='grey' onclick="closeNEW();"><span class="material-icons">cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button>
        <button class='blue' onclick="newART();"><span class="material-icons">add</span><?php echo $dw3_lbl["CREATE"] . " & " . $dw3_lbl["MODIFY"]; ?></button>
	</div>
</div>

<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;overflow-y:auto;">
    <div id='divNEW_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);'>Paramètres de l'application</h2>
        <button class='dw3_form_close' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
    </div>
    <div class='dw3_form_data' id="divPARAM_DATA" style="background: rgba(255, 255, 255, 0.95);color:#111;"></div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,1));'>
        <button class='grey' onclick='resetPRM()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>restart_alt</span> Réinitialiser</button>
        <button class='grey' onclick='closeEDITOR()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Annuler</button>
        <button class='green' onclick='updPRM();' style='margin:0px 10px 0px 2px;'><span class='material-icons'>save</span> Enregistrer</button>
    </div>
</div>

<div id="divCLI_LST"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.85);color:white;z-index:1115;"><input type='text' id='dw3_lst_id'>
    <div id='divCLI_LST_HEADER' class='dw3_form_head'>
        <h2 style='background: rgba(44, 44, 44, 0.9);'>À qui envoyer l'Infolettre</h2>
        <button class='dw3_form_close' onclick='closeCLI_LST();'><span class='material-icons'>cancel</span></button>
    </div>
    <div class='dw3_form_data' id="divCLI_LST_DATA"></div>
    <div class='EDIT_FOOT' style='text-align:right;padding:3px;background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(44,44,44,0.9));'>
        <button class='grey' onclick='closeCLI_LST()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Annuler</button>
        <button class='green' onclick='sendART2();' style='margin:0px 10px 0px 2px;'><span class="material-icons">newspaper</span> Envoyer</button>
    </div>
</div>

<div id="divWYG"  class="divEDITOR" style="z-index:1111;">
    <div id='divWYG_HEADER' class='dw3_form_head'>
        <h2>Article et Infolettre WYSIWYG</h2>
        <button class='dw3_form_close' onclick='closeWYG();'><span class='material-icons'>cancel</span></button>
    </div>
    <div class='dw3_form_data' id="divWYG_DATA" style='background:#fff;color:#000;'><iframe id='iWYG' style='border:0px;width:100%;min-height:99%;'></iframe></div>
    <div class='dw3_form_foot' style='padding-top:5px;'>
        <button class='grey' onclick='closeWYG()' style='margin:0px 2px 0px 2px;'><span class='material-icons'>cancel</span> Fermer</button>
    </div>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>

<div id='divUPLOAD_CAT' style='display:none;'>
    <form id='frmUPLOAD_CAT' method="post" enctype="multipart/form-data">
    <input type="file" name="fileToCat" id="fileToCat" onchange="document.getElementById('submitCAT').click();">    
    <input type="text" name="fileNameCat" id="fileNameCat" value='0'>
    <input type="text" name="fileTarget" id="fileTarget" value='TOP'>
    <input type="submit" value="Upload Image" name="submit" id='submitCAT'>
    </form>
</div>

<script><?php require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/js/main.js.php'; ?></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
//jQ
$(document).ready(function ()
    {
		var body = document.body,
		html = document.documentElement;

		var height = Math.max( body.scrollHeight, body.offsetHeight, 
						   html.clientHeight, html.scrollHeight, html.offsetHeight );
		LIMIT = Math.floor(height/53);				   
		getARTS('','',LIMIT);

        dragElement(document.getElementById('divNEW'));
        dragElement(document.getElementById('divPARAM'));
        dragElement(document.getElementById('divCLI_LST'));
        dragElement(document.getElementById('divWYG'));

		document.getElementById('divMAIN').scrollIntoView({
			behavior: 'smooth'
		});

	});
	
//_	
var KEY = '<?php echo($_GET['KEY']); ?>';
var active_input;
var LIMIT = '12';

function closeCLI_LST() {
    document.getElementById("divFADE").style.opacity = "0";
	setTimeout(function () {
		document.getElementById("divFADE").style.display = "none";
	}, 500);
    document.getElementById("divCLI_LST").style.display = "none";
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

//fonction ajouter un caractere special au input/textarea actif
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
        textarea.blur();
        textarea.focus();
		if (active_input == "artHTML_FR"){wygART_FR();}else{wygART_EN();}
	}
}
function toggleBOLD(){
	if (active_input!=""){
		var textarea = document.getElementById(active_input);
		var start = textarea.selectionStart;
    	var finish = textarea.selectionEnd;
    	var sel = textarea.value.substring(start, finish);
        if (sel.substring(0,3) == "<b>" && sel.substring(sel.length - 4) == "</b>"){
            textarea.value = textarea.value.substring(0, start) + sel.substring(3,sel.length - 4)  + textarea.value.substring(finish,textarea.value.length);
            //textarea.focus();
            textarea.selectionStart = start;
            textarea.selectionEnd = finish-7;
            textarea.blur();
            textarea.focus();
        } else {
            textarea.value = textarea.value.substring(0, start) + "<b>" + sel + "</b>" + textarea.value.substring(finish,textarea.value.length);
            //textarea.focus();
            textarea.selectionStart = start;
            textarea.selectionEnd = finish+7;
            textarea.blur();
            textarea.focus();
        }
		if (active_input == "artHTML_FR"){wygART_FR();}else{wygART_EN();}
	}
}
function toggleITALIC(){
	if (active_input!=""){
		var textarea = document.getElementById(active_input);
		var start = textarea.selectionStart;
    	var finish = textarea.selectionEnd;
    	var sel = textarea.value.substring(start, finish);
        if (sel.substring(0,3) == "<i>" && sel.substring(sel.length - 4) == "</i>"){
            textarea.value = textarea.value.substring(0, start) + sel.substring(3,sel.length - 4)  + textarea.value.substring(finish,textarea.value.length);
            //textarea.focus();
            textarea.selectionStart = start;
            textarea.selectionEnd = finish-7;
            textarea.blur();
            textarea.focus();
        } else {
            textarea.value = textarea.value.substring(0, start) + "<i>" + sel + "</i>" + textarea.value.substring(finish,textarea.value.length);
            //textarea.focus();
            textarea.selectionStart = start;
            textarea.selectionEnd = finish+7;
            textarea.blur();
            textarea.focus();
        }
		if (active_input == "artHTML_FR"){wygART_FR();}else{wygART_EN();}
	}
}
function toggleUNDERLINE(){
	if (active_input!=""){
		var textarea = document.getElementById(active_input);
		var start = textarea.selectionStart;
    	var finish = textarea.selectionEnd;
    	var sel = textarea.value.substring(start, finish);
        if (sel.substring(0,3) == "<u>" && sel.substring(sel.length - 4) == "</u>"){
            textarea.value = textarea.value.substring(0, start) + sel.substring(3,sel.length - 4)  + textarea.value.substring(finish,textarea.value.length);
            //textarea.focus();
            textarea.selectionStart = start;
            textarea.selectionEnd = finish-7;
            textarea.blur();
            textarea.focus();
        } else {
            textarea.value = textarea.value.substring(0, start) + "<u>" + sel + "</u>" + textarea.value.substring(finish,textarea.value.length);
            //textarea.focus();
            textarea.selectionStart = start;
            textarea.selectionEnd = finish+7;
            textarea.blur();
            textarea.focus();
        }
		if (active_input == "artHTML_FR"){wygART_FR();}else{wygART_EN();}
	}
}
function toggleH3(){
	if (active_input!=""){
		var textarea = document.getElementById(active_input);
		var start = textarea.selectionStart;
    	var finish = textarea.selectionEnd;
    	var sel = textarea.value.substring(start, finish);
        if (sel.substring(0,4) == "<h3>" && sel.substring(sel.length - 5) == "</h3>"){
            textarea.value = textarea.value.substring(0, start) + sel.substring(4,sel.length - 5)  + textarea.value.substring(finish,textarea.value.length);
            //textarea.focus();
            textarea.selectionStart = start;
            textarea.selectionEnd = finish-9;
            textarea.blur();
            textarea.focus();
        } else {
            textarea.value = textarea.value.substring(0, start) + "<h3>" + sel + "</h3>" + textarea.value.substring(finish,textarea.value.length);
            //textarea.focus();
            textarea.selectionStart = start;
            textarea.selectionEnd = finish+9;
            textarea.blur();
            textarea.focus();
        }
		if (active_input == "artHTML_FR"){wygART_FR();}else{wygART_EN();}
	}
}
function toggleH4(){
	if (active_input!=""){
		var textarea = document.getElementById(active_input);
		var start = textarea.selectionStart;
    	var finish = textarea.selectionEnd;
    	var sel = textarea.value.substring(start, finish);
        if (sel.substring(0,4) == "<h4>" && sel.substring(sel.length - 5) == "</h4>"){
            textarea.value = textarea.value.substring(0, start) + sel.substring(4,sel.length - 5)  + textarea.value.substring(finish,textarea.value.length);
            //textarea.focus();
            textarea.selectionStart = start;
            textarea.selectionEnd = finish-9;
            textarea.blur();
            textarea.focus();
        } else {
            textarea.value = textarea.value.substring(0, start) + "<h4>" + sel + "</h4>" + textarea.value.substring(finish,textarea.value.length);
            //textarea.focus();
            textarea.selectionStart = start;
            textarea.selectionEnd = finish+9;
            textarea.blur();
            textarea.focus();
        }
		if (active_input == "artHTML_FR"){wygART_FR();}else{wygART_EN();}
	}
}

function deleteART(ID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br> <button class='grey' onclick='closeMSG();'><span class='material-icons'>cancel</span><?php echo $dw3_lbl["CANCEL"]; ?></button> <button class='red' onclick='delART(" + ID + ");'><span class='material-icons' style='vertical-align:middle;'>delete</span><?php echo $dw3_lbl["DEL"]; ?></button>";
}

function delART(ID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
                addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
                getARTS('','',LIMIT);
                closeMSG();
                closeEDITOR();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delART.php?KEY=' + KEY + '&ID=' + ID , true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.4";
}
let art_updated = false;
function closeART() {
    if(art_updated){
        document.getElementById("divFADE2").style.opacity = "1";
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment fermer sans sauvegarder les données ?<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons'>close</span>Annuler</button> <button onclick='closeART2();closeMSG();' class='red'><span class='material-icons'>delete</span> Fermer sans sauvegarder</button><br>";
    } else {
        closeART2();
    }
}
function closeART2() {
    document.getElementById("divFADE").style.opacity = "0";
	setTimeout(function () {
		document.getElementById("divFADE").style.display = "none";
	}, 500);
    document.getElementById('divEDIT').style.display = "none";
    art_updated = false;
    closeWYG();
}

function closeWYG() {
    document.getElementById('divWYG').style.display = "none";
}
function wygART_FR() {
    var doc = document.getElementById('iWYG').contentWindow.document;
    doc.open();
    doc.write('<h1 style="margin:20px 10px;">'+document.getElementById('artTITLE_FR').value+'</h1>');
    doc.write('<img src="/pub/upload/'+document.getElementById('artIMG').value+'" style="width:100%;height:auto;"><br>');
    doc.write('<div style="display:flex;width:100%;"><span style="width:50%;padding-left:5px;">Par <b>'+document.getElementById('artAUTHOR').value+'</b></span><span style="width:50%;text-align:right;padding-right:5px;"><b>'+document.getElementById('artCREATED').value.substring(0,10)+'</b></span></div>');
    doc.write('<h2 style="text-align:left;margin:20px 5px;">'+document.getElementById('artDESC_FR').value+'</h2>');
    doc.write('<div style="padding:0px 10px;">'+document.getElementById('artHTML_FR').value.replace(/(?:\r\n|\r|\n)/g, '<br>')+'</div>');
    doc.close();
    document.getElementById('divWYG').style.display = "inline-block";
    document.getElementById('divWYG').style.left = "10px";
    document.getElementById('divWYG').style.transform = "translateX(0%)";
    document.getElementById('divEDIT').style.left = "auto";
    document.getElementById('divEDIT').style.right = "10px";
    document.getElementById('divEDIT').style.transform = "translateX(0%)";
		var textarea = document.getElementById("artHTML_FR");
		var start = textarea.selectionStart;
    	var finish = textarea.selectionEnd;
		//textarea.focus();
		textarea.selectionStart = start;
		textarea.selectionEnd = finish;
		textarea.blur();
		textarea.focus();
}
function wygART_EN() {
    var doc = document.getElementById('iWYG').contentWindow.document;
    doc.open();
    doc.write('<h1 style="margin:20px 10px;">'+document.getElementById('artTITLE_EN').value+'</h1>');
    doc.write('<img src="/pub/upload/'+document.getElementById('artIMG').value+'" style="width:100%;height:auto;"><br>');
    doc.write('<div style="display:flex;width:100%;"><span style="width:50%;padding-left:5px;">By <b>'+document.getElementById('artAUTHOR').value+'</b></span><span style="width:50%;text-align:right;padding-right:5px;"><b>'+document.getElementById('artCREATED').value.substring(0,10)+'</b></span></div>');
    doc.write('<h2 style="text-align:left;margin:20px 5px;">'+document.getElementById('artDESC_EN').value+'</h2>');
    doc.write('<div style="padding:0px 10px;">'+document.getElementById('artHTML_EN').value.replace(/(?:\r\n|\r|\n)/g, '<br>')+'</div>');
    doc.close();
    document.getElementById('divWYG').style.display = "inline-block";
    document.getElementById('divWYG').style.left = "10px";
    document.getElementById('divWYG').style.transform = "translateX(0%)";
    document.getElementById('divEDIT').style.left = "auto";
    document.getElementById('divEDIT').style.right = "10px";
    document.getElementById('divEDIT').style.transform = "translateX(0%)";
    	var textarea = document.getElementById("artHTML_EN");
		var start = textarea.selectionStart;
    	var finish = textarea.selectionEnd;
		//textarea.focus();
		textarea.selectionStart = start;
		textarea.selectionEnd = finish;
		textarea.blur();
		textarea.focus();
}
function getART(ID) {
    closeBatch();
	var max_width = Math.max(window.innerWidth, document.documentElement.clientWidth, document.body.clientWidth)/100*95;
	var text_width = Math.floor(max_width/335)*335;
	if (text_width=='0'){text_width='335'} 
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		document.getElementById("divEDIT_MAIN").innerHTML = this.responseText;
		document.getElementById("divEDIT").style.display = "inline-block";
		dragElement(document.getElementById('divEDIT'));
		document.getElementById("divEDIT").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"})
		document.getElementById("divFADE").style.display = "inline-block";
    	document.getElementById("divFADE").style.background = "rbga(0,0,0,0.5)";
    	document.getElementById("divFADE").style.width = "100%";
    	document.getElementById("divFADE").style.opacity = "0.5";
	  }
	};
		document.getElementById("divFADE").style.width = "100%";
		xmlhttp.open('GET', 'getART.php?KEY=' + KEY + '&ID=' + ID + '&tw=' + text_width , true);
		xmlhttp.send();
		
}
function sendART(artID,LOOK_FOR) {
    document.getElementById("dw3_lst_id").value = artID;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
                document.getElementById("divCLI_LST_DATA").innerHTML = this.responseText;
                document.getElementById("divCLI_LST").style.display = "inline-block";
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'getCLI_LST.php?KEY=' + KEY + '&ART=' + artID + '&LOOK_FOR=' + encodeURIComponent(LOOK_FOR), true);
		xmlhttp.send();
        document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divFADE").style.opacity = "0.5";
        //document.getElementById("divCLI_LST").style.zIndex = "1101";
        document.getElementById("divCLI_LST").style.display = "inline-block";
        window.scrollTo(0, 0);
        document.getElementById('divCLI_LST').scrollTop = 0;
        closeBatch();
}

function sendART2() {
    var sLST_CLI = "";
    var sLST_USR = "";
    var artID  = document.getElementById("dw3_lst_id").value;
    var frmCLI  = document.getElementById("frmCLI_LST");
    var frmUSR  = document.getElementById("frmUSR_LST");
    var sVIRGULE = "";
    
    //clients
    for (var i = 0; i < frmCLI.elements.length; i++ ) 
    {
        if (frmCLI.elements[i].type == 'checkbox')
        {
            if (frmCLI.elements[i].checked == true)
            {
                if(sLST_CLI != ""){sVIRGULE = ","} else { sLST_CLI = "("; }
                sLST_CLI += sVIRGULE + frmCLI.elements[i].value ;
            }
        }
    }	
    if (sLST_CLI == ""){
        sLST_CLI = "()";
        //document.getElementById("divMSG").style.display = "inline-block";
        //document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["ERR_SEL1"]; ?><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        //return;
    } else { sLST_CLI += ")"; }
    
    //employés
    for (var i = 0; i < frmUSR.elements.length; i++ ) 
    {
        if (frmUSR.elements[i].type == 'checkbox')
        {
            if (frmUSR.elements[i].checked == true)
            {
                if(sLST_USR != ""){sVIRGULE = ","} else { sLST_USR = "("; }
                sLST_USR += sVIRGULE + frmUSR.elements[i].value ;
            }
        }
    }	
    if (sLST_USR == ""){
        sLST_USR = "()";
        //document.getElementById("divMSG").style.display = "inline-block";
        //document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["ERR_SEL1"]; ?><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        //return;
    } else { sLST_USR += ")"; }

    if (sLST_USR == "()" && sLST_CLI == "()"){
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["ERR_SEL1"]; ?><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        return;
    } 

    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'><br>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
        if (this.responseText){
            document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'><br>" + this.responseText;
        }
        if (this.readyState == 4 && this.status == 200) {
            closeMSG();
			closeCLI_LST();
            addNotif("Lettre envoyée à tout les clients inscrits.");
        }
	};
    xmlhttp.open('GET', 'sendART.php?KEY=' + KEY + '&ID=' + artID + '&CLI=' + encodeURIComponent(sLST_CLI)+ '&USR=' + encodeURIComponent(sLST_USR), true);
    xmlhttp.send();
		
}

function getARTS(sACTIVE,sOFFSET,sLIMIT) {
	var sS = document.getElementById("inputSEARCH").value;
	//STAT
	if (sACTIVE.trim() == ""){
		var GRPBOX = document.getElementById("selACTIVE");
		sACTIVE = GRPBOX.options[GRPBOX.selectedIndex].value;		
	}
    var GRPBOX = document.getElementById("selAUTHOR");
    sAUTHOR = GRPBOX.options[GRPBOX.selectedIndex].value;		

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getARTS.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim())
									+ '&AUTHOR=' + sAUTHOR
									+ '&ACTIVE=' + sACTIVE
									+ '&OFFSET=' + sOFFSET 
									+ '&LIMIT=' + sLIMIT  
									, true);
		xmlhttp.send();
		
}
function newART(){
	var sNAME_FR  = document.getElementById("newNAME_FR").value;
	var sNAME_EN  = document.getElementById("newNAME_EN").value;

	
	if (sNAME_FR == ""){
		document.getElementById("newNAME_FR").style.boxShadow = "5px 10px 15px red";
		document.getElementById("newNAME_FR").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newNAME_FR").style.boxShadow = "0px 5px 5px rgba(0, 0, 0, 0.35)";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				addNotif("<?php echo $dw3_lbl["CREATED"]; ?>");
                getARTS('','',LIMIT);
                getART(this.responseText);
                closeNEW();
		  } else {
            document.getElementById("divFADE2").style.display = "inline-block";
		    document.getElementById("divFADE2").style.opacity = "0.4";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newART.php?KEY=' + KEY  
										+ '&FR=' + encodeURIComponent(sNAME_FR)    
										+ '&EN=' + encodeURIComponent(sNAME_EN),   
										true);
		xmlhttp.send();

}

function updART(sID){
    var sTITLE_FR		= document.getElementById("artTITLE_FR").value;
    var sTITLE_EN		= document.getElementById("artTITLE_EN").value;
    var sCAT_FR		= document.getElementById("artCATEGORY_FR").value;
    var sCAT_EN		= document.getElementById("artCATEGORY_EN").value;
    var sDESC_FR		= document.getElementById("artDESC_FR").value;
    var sDESC_EN		= document.getElementById("artDESC_EN").value;
    var sAUTHOR		= document.getElementById("artAUTHOR").value;
    var sIMG		= document.getElementById("artIMG").value;
    var sCREATED		= document.getElementById("artCREATED").value;
    var sMODIFIED		= document.getElementById("artMODIFIED").value;
    var sHTML_FR		= document.getElementById("artHTML_FR").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    var sHTML_EN  		= document.getElementById("artHTML_EN").value.replace(/(?:\r\n|\r|\n)/g, '<br>');

    var GRPBOX  = document.getElementById("artACTIVE");
	var sACTIVE = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX  = document.getElementById("artCOMMENT");
	var sCOMMENT = GRPBOX.options[GRPBOX.selectedIndex].value;

    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "updART.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onload = function() {
        if (this.responseText == ""){
				addNotif("L'article a été mise &#224; jour");
                closeMSG();
                //closeEDITOR();
                getARTS("","",LIMIT);
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  }
    }
  xhttp.send("KEY="+KEY
                    +"&ID="+sID
                    +"&TITLE_FR="+encodeURIComponent(sTITLE_FR)
                    +"&TITLE_EN="+encodeURIComponent(sTITLE_EN)
                    +"&DESC_FR="+encodeURIComponent(sDESC_FR)
                    +"&DESC_EN="+encodeURIComponent(sDESC_EN)
                    +"&CAT_FR="+encodeURIComponent(sCAT_FR)
                    +"&CAT_EN="+encodeURIComponent(sCAT_EN)
                    +"&HTML_FR="+encodeURIComponent(sHTML_FR)
                    +"&HTML_EN="+encodeURIComponent(sHTML_EN)
                    +"&AUTHOR="+encodeURIComponent(sAUTHOR)
                    +"&ACTIVE="+encodeURIComponent(sACTIVE)
                    +"&COMMENT="+encodeURIComponent(sCOMMENT)
                    +"&IMG="+encodeURIComponent(sIMG)
                    +"&CREATED="+encodeURIComponent(sCREATED)
                    +"&MODIFIED="+encodeURIComponent(sMODIFIED));
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.background = "rbga(0,0,0,0.5)";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:60px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";
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


function updPRM(){
	var GRPBOX = document.getElementById("prmLIMIT");
	var prmLIMIT = GRPBOX.options[GRPBOX.selectedIndex].value;	
	var GRPBOX = document.getElementById("prmORDERBY");
	var prmORDERBY = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX = document.getElementById("prmORDERWAY");
	var prmORDERWAY = GRPBOX.options[GRPBOX.selectedIndex].value;
	
	if (document.getElementById("DSP_COL_ID").checked == false){ var dspID = 0; } else { var dspID = 1; }
	if (document.getElementById("DSP_COL_NAME").checked == false){ var dspNAME = 0; } else { var dspNAME = 1; }
	if (document.getElementById("DSP_COL_TYPE").checked == false){ var dspTYPE = 0; } else { var dspTYPE = 1; }
	if (document.getElementById("DSP_COL_DESC").checked == false){ var dspDESC = 0; } else { var dspDESC = 1; }
	if (document.getElementById("DSP_COL_DTMD").checked == false){ var dspDTMD = 0; } else { var dspDTMD = 1; }

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
            closeMSG();
            closeEDITOR();
            getARTS('','',LIMIT);
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
                                    + '&NAME='		+ dspNAME
                                    + '&TYPE=' 		+ dspTYPE
                                    + '&DESC=' 		+ dspDESC
                                    + '&DTMD=' 		+ dspDTMD,true);
    xmlhttp.send();
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divFADE2").style.opacity = "0.4";
}

function rotate_art_img(sDEG) {
    var sFN = document.getElementById("artIMG").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        var irnd_num = Math.floor(Math.random() * 1000000);
            document.getElementById("imgART_IMG").src = "/pub/upload/"+sFN+"?t="+irnd_num;
            addNotif( this.responseText);
	  }
	};
		xmlhttp.open('GET', 'rotate_picture.php?KEY=' + KEY + '&FN=' + encodeURIComponent(sFN) + '&DEG=' + sDEG , true);
		xmlhttp.send();	
}

var dw3_file_replace = "unknow";
function selTOP_IMG() {	
    dw3_file_replace = "unknow";
    var xmlhttp = new XMLHttpRequest();	
    xmlhttp.onreadystatechange = function() {	  
        if (this.readyState == 4 && this.status == 200) {			
            document.getElementById("divFADE").style.width = "100%";			
            document.getElementById("divMSG").style.display = "inline-block";			
            document.getElementById("divMSG").innerHTML = this.responseText;	  
        }	
    };		
    xmlhttp.open('GET', 'getART_IMG.php?KEY=' + KEY + "&TARGET=TOP", true);				
    xmlhttp.send();	
	document.getElementById('fileTarget').value = "TOP";
}
function selINLINE_IMG() {	
    dw3_file_replace = "unknow";
    var xmlhttp = new XMLHttpRequest();	
    xmlhttp.onreadystatechange = function() {	  
        if (this.readyState == 4 && this.status == 200) {			
            document.getElementById("divFADE").style.width = "100%";			
            document.getElementById("divMSG").style.display = "inline-block";			
            document.getElementById("divMSG").innerHTML = this.responseText;	  
        }	
    };		
    xmlhttp.open('GET', 'getART_IMG.php?KEY=' + KEY + "&TARGET=INLINE", true);				
    xmlhttp.send();	
	document.getElementById('fileTarget').value = "INLINE";
}
function setTOP_IMG(img) {
    document.getElementById("artIMG").value = img;
    var irnd_num = Math.floor(Math.random() * 1000000);
    document.getElementById("imgART_IMG").src = "/pub/upload/" + img +"?t="+irnd_num;
}
function setINLINE_IMG(img) {
	if (active_input!=""){
		var textarea = document.getElementById(active_input);
		var start = textarea.selectionStart;
    	var finish = textarea.selectionEnd;
    	//var sel = textarea.value.substring(start, finish);
            textarea.value = textarea.value.substring(0, start) + "<img src='https://<?php echo $_SERVER["SERVER_NAME"];?>/pub/upload/"+img+"'>"  + textarea.value.substring(finish,textarea.value.length);
            textarea.focus();
            textarea.selectionStart = start;
            textarea.selectionEnd = finish+img.length+24;
            textarea.blur();
            textarea.focus();
			if (active_input == "artHTML_FR"){wygART_FR();}else{wygART_EN();}
		}
}

$('#frmUPLOAD_CAT').on('submit',function(e){
    e.preventDefault();
    e.stopImmediatePropagation();
    if ($('#fileToCat')[0].files[0] == ""){return;}
    sendUPLOAD_ART();
});

function sendUPLOAD_ART(){
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
        url : 'upload_art_img.php?KEY=<?php echo $KEY;?>&REPLACE='+dw3_file_replace,
        data : data,
        dataTYpe : 'multipart/form-data',
        processData: false,
        contentType: false, 
        beforeSend : function(){
            //document.getElementById("divFADE").style.display = "inline-block";
            //document.getElementById("divFADE").style.opacity = "0.6";
        },
        success : function(response){
				var what_target = document.getElementById('fileTarget').value;
                if (response.substring(0, 7) == "Erreur:"){
                    document.getElementById("divMSG").innerHTML = response + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                    fileInput.value = null;
                } else if (response == "ErrX"){
                    document.getElementById("divMSG").style.display = "inline-block";
                    document.getElementById("divMSG").innerHTML = "Le fichier est déjà existant, voulez-vous le conserver ou le remplacer?<div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>undo</span> Conserver</button> <button onclick=\"closeMSG();dw3_file_replace='yes';sendUPLOAD_ART();\"><span class='material-icons' style='vertical-align:middle;'>published_with_changes</span> Remplacer</button>";
                    var filename = document.getElementById("fileToCat").value.replace(/^.*[\\/]/, '');
					if (what_target == "TOP"){
						document.getElementById("artIMG").value = "/pub/upload/"+filename;
						var irnd_num = Math.floor(Math.random() * 1000000);
						document.getElementById("imgART_IMG").src = "/pub/upload/"+filename+"?t="+irnd_num;
					} else {
						setINLINE_IMG(filename);
					}
                } else {
                    addNotif("Image transférée.");
                    closeMSG();
					if (what_target == "TOP"){
						document.getElementById("artIMG").value = "/pub/upload/" + response;
						document.getElementById("imgART_IMG").src = "/pub/upload/"+response;
					} else {
						setINLINE_IMG(response);
					}
                    fileInput.value = null;
                }
        }
    });

}

function showCharAdd(){
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<div id='divCharEvent' style='overflow-y:auto;overflow-x:hidden;height:150px;width:100%;vertical-align:middle;text-align:center;'>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('<br>');closeMSG();\">&#9166;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#8592;');closeMSG();\">&#8592;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#8593;');closeMSG();\">&#8593;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#8594;');closeMSG();\">&#8594;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#8595;');closeMSG();\">&#8595;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#9824;');closeMSG();\">&#9824;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#9827;');closeMSG();\">&#9827;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#9829;');closeMSG();\">&#9829;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#9830;');closeMSG();\">&#9830;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#129496;');closeMSG();\">&#129496;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#x2022; ');closeMSG();\">&#x2022;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#171;');closeMSG();\">&#171;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#187;');closeMSG();\">&#187;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#169;');closeMSG();\">&#169;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#174;');closeMSG();\">&#174;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick=\"addChar('&#8482;');closeMSG();\">&#8482;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#163;');closeMSG();\">&#163;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#165;');closeMSG();\">&#165;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#162;');closeMSG();\">&#162;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8364;');closeMSG();\">&#8364;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8721;');closeMSG();\">&#8721;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8719;');closeMSG();\">&#8719;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8715;');closeMSG();\">&#8715;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8713;');closeMSG();\">&#8713;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8712;');closeMSG();\">&#8712;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8711;');closeMSG();\">&#8711;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8709;');closeMSG();\">&#8709;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8707;');closeMSG();\">&#8707;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8706;');closeMSG();\">&#8706;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#8704;');closeMSG();\">&#8704;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128512;');closeMSG();\">&#128512;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128513;');closeMSG();\">&#128513;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128514;');closeMSG();\">&#128514;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128515;');closeMSG();\">&#128515;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128516;');closeMSG();\">&#128516;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128517;');closeMSG();\">&#128517;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128518;');closeMSG();\">&#128518;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128519;');closeMSG();\">&#128519;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128520;');closeMSG();\">&#128520;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128521;');closeMSG();\">&#128521;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128522;');closeMSG();\">&#128522;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128523;');closeMSG();\">&#128523;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128524;');closeMSG();\">&#128524;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128525;');closeMSG();\">&#128525;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128526;');closeMSG();\">&#128526;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128527;');closeMSG();\">&#128527;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128528;');closeMSG();\">&#128528;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128529;');closeMSG();\">&#128529;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128530;');closeMSG();\">&#128530;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128531;');closeMSG();\">&#128531;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128532;');closeMSG();\">&#128532;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128533;');closeMSG();\">&#128533;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128534;');closeMSG();\">&#128534;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128535;');closeMSG();\">&#128535;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128536;');closeMSG();\">&#128536;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128537;');closeMSG();\">&#128537;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128538;');closeMSG();\">&#128538;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128539;');closeMSG();\">&#128539;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128540;');closeMSG();\">&#128540;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128541;');closeMSG();\">&#128541;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128542;');closeMSG();\">&#128542;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128543;');closeMSG();\">&#128543;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128544;');closeMSG();\">&#128544;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128545;');closeMSG();\">&#128545;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128546;');closeMSG();\">&#128546;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128547;');closeMSG();\">&#128547;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128548;');closeMSG();\">&#128548;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128549;');closeMSG();\">&#128549;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128550;');closeMSG();\">&#128550;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128551;');closeMSG();\">&#128551;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128552;');closeMSG();\">&#128552;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128553;');closeMSG();\">&#128553;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128554;');closeMSG();\">&#128554;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128555;');closeMSG();\">&#128555;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128556;');closeMSG();\">&#128556;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128557;');closeMSG();\">&#128557;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128558;');closeMSG();\">&#128558;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128559;');closeMSG();\">&#128559;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128560;');closeMSG();\">&#128560;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128561;');closeMSG();\">&#128561;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128562;');closeMSG();\">&#128562;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128563;');closeMSG();\">&#128563;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128564;');closeMSG();\">&#128564;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128565;');closeMSG();\">&#128565;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128566;');closeMSG();\">&#128566;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128567;');closeMSG();\">&#128567;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128568;');closeMSG();\">&#128568;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128569;');closeMSG();\">&#128569;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128570;');closeMSG();\">&#128570;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128571;');closeMSG();\">&#128571;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128572;');closeMSG();\">&#128572;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128573;');closeMSG();\">&#128573;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128574;');closeMSG();\">&#128574;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128575;');closeMSG();\">&#128575;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128576;');closeMSG();\">&#128576;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128577;');closeMSG();\">&#128577;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128578;');closeMSG();\">&#128578;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128579;');closeMSG();\">&#128579;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128580;');closeMSG();\">&#128580;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128581;');closeMSG();\">&#128581;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128582;');closeMSG();\">&#128582;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128583;');closeMSG();\">&#128583;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128584;');closeMSG();\">&#128584;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128585;');closeMSG();\">&#128585;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128586;');closeMSG();\">&#128586;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128587;');closeMSG();\">&#128587;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128588;');closeMSG();\">&#128588;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128589;');closeMSG();\">&#128589;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128590;');closeMSG();\">&#128590;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128591;');closeMSG();\">&#128591;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128640;');closeMSG();\">&#128640;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128641;');closeMSG();\">&#128641;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128642;');closeMSG();\">&#128642;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128643;');closeMSG();\">&#128643;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128644;');closeMSG();\">&#128644;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128645;');closeMSG();\">&#128645;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128646;');closeMSG();\">&#128646;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128647;');closeMSG();\">&#128647;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128648;');closeMSG();\">&#128648;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128649;');closeMSG();\">&#128649;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128650;');closeMSG();\">&#128650;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128651;');closeMSG();\">&#128651;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128652;');closeMSG();\">&#128652;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128653;');closeMSG();\">&#128653;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128654;');closeMSG();\">&#128654;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128655;');closeMSG();\">&#128655;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128656;');closeMSG();\">&#128656;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128657;');closeMSG();\">&#128657;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128658;');closeMSG();\">&#128658;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128659;');closeMSG();\">&#128659;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128660;');closeMSG();\">&#128660;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128661;');closeMSG();\">&#128661;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128662;');closeMSG();\">&#128662;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128663;');closeMSG();\">&#128663;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128664;');closeMSG();\">&#128664;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128665;');closeMSG();\">&#128665;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128666;');closeMSG();\">&#128666;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128667;');closeMSG();\">&#128667;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128668;');closeMSG();\">&#128668;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128669;');closeMSG();\">&#128669;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128670;');closeMSG();\">&#128670;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128671;');closeMSG();\">&#128671;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128672;');closeMSG();\">&#128672;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128673;');closeMSG();\">&#128673;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128674;');closeMSG();\">&#128674;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128675;');closeMSG();\">&#128675;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128676;');closeMSG();\">&#128676;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128677;');closeMSG();\">&#128677;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128678;');closeMSG();\">&#128678;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128679;');closeMSG();\">&#128679;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128680;');closeMSG();\">&#128680;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128681;');closeMSG();\">&#128681;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128682;');closeMSG();\">&#128682;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128683;');closeMSG();\">&#128683;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128684;');closeMSG();\">&#128684;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128685;');closeMSG();\">&#128685;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128686;');closeMSG();\">&#128686;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128687;');closeMSG();\">&#128687;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128688;');closeMSG();\">&#128688;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128689;');closeMSG();\">&#128689;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128690;');closeMSG();\">&#128690;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128691;');closeMSG();\">&#128691;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128692;');closeMSG();\">&#128692;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128693;');closeMSG();\">&#128693;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128694;');closeMSG();\">&#128694;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128695;');closeMSG();\">&#128695;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128696;');closeMSG();\">&#128696;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128697;');closeMSG();\">&#128697;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128698;');closeMSG();\">&#128698;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128699;');closeMSG();\">&#128699;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128700;');closeMSG();\">&#128700;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128701;');closeMSG();\">&#128701;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128702;');closeMSG();\">&#128702;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128703;');closeMSG();\">&#128703;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128704;');closeMSG();\">&#128704;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128705;');closeMSG();\">&#128705;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128706;');closeMSG();\">&#128706;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128707;');closeMSG();\">&#128707;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128708;');closeMSG();\">&#128708;</button>"
					+"<button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick=\"addChar('&#128709;');closeMSG();\">&#128709;</button>"
					+"</div><div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button>"
}

</script>

</body>
</html>
<?php 
$dw3_conn->close();
exit();
?>
<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';
?>
<div id='divHEAD'>
    <table><tr style="margin:0px;padding:0px;">
        <td width="100" style="margin:0px;padding:0px;text-align:right;">
            <button onclick="openGL();"><span class="material-icons">book</span><span>Index GL</span></button>
        </td>
        <td width="*" style="margin:0px;padding:0px;">
            <input type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" id="inputSEARCH" onkeyup="filterTable()" placeholder="Recherche" title="Entrez votre recherche">
        </td>
        <td style="width:0;min-width:fit-content;margin:0px;padding:0px 0px 0px 5px;text-align:right;">
            <?php if($APREAD_ONLY == false) { ?><button class='blue' onclick="openNEW();"><span class="material-icons">add</span></button><?php } ?>
        </td>
    </tr></table>
</div>
<div style='margin-top:46px;'>
    <div class='divBOX' style=''><b>À partir de</b>:<br>
        <select id='selYEAR_FROM' style='width:49%;'>
            <option <?php if(date("Y")=="2023"){echo "selected";} ?> value='2023'>2023</option>
            <option <?php if(date("Y")=="2024"){echo "selected";} ?> value='2024'>2024</option>
            <option <?php if(date("Y")=="2025"){echo "selected";} ?> value='2025'>2025</option>
            <option <?php if(date("Y")=="2026"){echo "selected";} ?> value='2026'>2026</option>
            <option <?php if(date("Y")=="2027"){echo "selected";} ?> value='2027'>2027</option>
            <option <?php if(date("Y")=="2028"){echo "selected";} ?> value='2028'>2028</option>
            <option <?php if(date("Y")=="2029"){echo "selected";} ?> value='2029'>2029</option>
            <option <?php if(date("Y")=="2030"){echo "selected";} ?> value='2030'>2030</option>
            <option <?php if(date("Y")=="2031"){echo "selected";} ?> value='2031'>2031</option>
            <option <?php if(date("Y")=="2032"){echo "selected";} ?> value='2032'>2032</option>
            <option <?php if(date("Y")=="2033"){echo "selected";} ?> value='2033'>2033</option>
            <option <?php if(date("Y")=="2034"){echo "selected";} ?> value='2034'>2034</option>
            <option <?php if(date("Y")=="2035"){echo "selected";} ?> value='2035'>2035</option>
            <option <?php if(date("Y")=="2036"){echo "selected";} ?> value='2036'>2036</option>
            <option <?php if(date("Y")=="2037"){echo "selected";} ?> value='2037'>2037</option>
            <option <?php if(date("Y")=="2038"){echo "selected";} ?> value='2038'>2038</option>
            <option <?php if(date("Y")=="2039"){echo "selected";} ?> value='2039'>2039</option>
            <option <?php if(date("Y")=="2040"){echo "selected";} ?> value='2040'>2040</option>
        </select>
        <select id='selPERIOD_FROM' style='width:49%;'>
            <option value='1'>1 - Janvier</option>
            <option value='2'>2 - Février</option>
            <option value='3'>3 - Mars</option>
            <option value='4'>4 - Avril</option>
            <option value='5'>5 - Mai</option>
            <option value='6'>6 - Juin</option>
            <option value='7'>7 - Juillet</option>
            <option value='8'>8 - Aout</option>
            <option value='9'>9 - Septembre</option>
            <option value='10'>10 - Octobre</option>
            <option value='11'>11 - Novembre</option>
            <option value='12'>12 - Décembre</option>
        </select>
    </div>
    <div class='divBOX' style=''><b>Jusqu'à, inclusivement</b>:<br>
        <select id='selYEAR_TO' style='width:49%;'>
            <option <?php if(date("Y")=="2023"){echo "selected";} ?> value='2023'>2023</option>
            <option <?php if(date("Y")=="2024"){echo "selected";} ?> value='2024'>2024</option>
            <option <?php if(date("Y")=="2025"){echo "selected";} ?> value='2025'>2025</option>
            <option <?php if(date("Y")=="2026"){echo "selected";} ?> value='2026'>2026</option>
            <option <?php if(date("Y")=="2027"){echo "selected";} ?> value='2027'>2027</option>
            <option <?php if(date("Y")=="2028"){echo "selected";} ?> value='2028'>2028</option>
            <option <?php if(date("Y")=="2029"){echo "selected";} ?> value='2029'>2029</option>
            <option <?php if(date("Y")=="2030"){echo "selected";} ?> value='2030'>2030</option>
            <option <?php if(date("Y")=="2031"){echo "selected";} ?> value='2031'>2031</option>
            <option <?php if(date("Y")=="2032"){echo "selected";} ?> value='2032'>2032</option>
            <option <?php if(date("Y")=="2033"){echo "selected";} ?> value='2033'>2033</option>
            <option <?php if(date("Y")=="2034"){echo "selected";} ?> value='2034'>2034</option>
            <option <?php if(date("Y")=="2035"){echo "selected";} ?> value='2035'>2035</option>
            <option <?php if(date("Y")=="2036"){echo "selected";} ?> value='2036'>2036</option>
            <option <?php if(date("Y")=="2037"){echo "selected";} ?> value='2037'>2037</option>
            <option <?php if(date("Y")=="2038"){echo "selected";} ?> value='2038'>2038</option>
            <option <?php if(date("Y")=="2039"){echo "selected";} ?> value='2039'>2039</option>
            <option <?php if(date("Y")=="2040"){echo "selected";} ?> value='2040'>2040</option>
        </select>
        <select id='selPERIOD_TO' style='width:49%;'>
            <option value='1'>1 - Janvier</option>
            <option value='2'>2 - Février</option>
            <option value='3'>3 - Mars</option>
            <option value='4'>4 - Avril</option>
            <option value='5'>5 - Mai</option>
            <option value='6'>6 - Juin</option>
            <option value='7'>7 - Juillet</option>
            <option value='8'>8 - Aout</option>
            <option value='9'>9 - Septembre</option>
            <option value='10'>10 - Octobre</option>
            <option value='11'>11 - Novembre</option>
            <option selected value='12'>12 - Décembre</option>
        </select>
    </div>
    <div class='divBOX' style='vertical-align:top;'>
        <b>Type de bilan</b>: 
        <div style='float:right;'>
            <label for='selSOM'> Sommaire: </label>
            <input type='radio' checked id='selSOM' name='selDETSOM' value='SOM'>
            <label for='selDET'> Détail: </label>
            <input type='radio' id='selDET' name='selDETSOM' value='DET'>
        </div>
        <div style='width:100%;text-align:center;margin-top:6px;'>
            <button onclick='getRECORDS();'><span class="material-icons">save_alt</span> Générer</button>
            <button onclick="ExportToPDF('dataTABLE','GL');"><span class='material-icons'>picture_as_pdf</span></button>
            <button onclick="ExportToExcel('dataTABLE','xlsx','GL');"><span class='material-icons'>table_view</span></button>
        </div>
    </div>
    <div class='divBOX'>
        <button style='width:100%;' onclick='getTAXES();'><span class="material-icons">save_alt</span> Taxes à payer pour cette période</button>
    </div>
</div>
<div id='divMAIN' class='divMAIN'></div>
<div id="divEDIT" class="divEDITOR"></div>

<div id="dw3_form_gl" class="dw3_form">
    <div id='dw3_form_gl_HEADER' class='dw3_form_head'>
		<br><h2>Grand Livre - Structure</h2>
		<button class='dw3_form_close' onclick='closeGL();'><span class='material-icons'>close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div id='dw3_form_gl_kind' class='dw3_page'></div>
        <div id='dw3_form_gl_data' class='dw3_page'></div>
    </div>
    <div class='dw3_form_foot'>
        <button class='grey' onclick="closeGL();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
        <button class='blue' onclick="openNEW_CODE();"><span class="material-icons">add</span> <?php echo $dw3_lbl["CREATE"]; ?></button>
	</div>
</div>

<div id="divNEW" class="divEDITOR">
    <div id='divNEW_HEADER' class='dw3_form_head'>
		<br><b><?php echo $dw3_lbl["NEW_ECR"];?></b>
		<button class='dw3_form_close' onclick='closeNEW();'><span class='material-icons'>close</span></button>
    </div>
    <div id='divNEW_DATA' class='dw3_form_data'>
        <div class="divBOX">DEBIT/CREDIT:
            <select id='ecrKIND'>
                <option value='DEBIT' selected>Débit</option>
                <option value='CREDIT'>Crédit</option>
            </select>
        </div>
        <div class="divBOX"><?php echo $dw3_lbl["GL_CODE"];?>:
            <select id='ecrGL_CODE'>
                <?php
                    $sql = "SELECT * FROM gl ORDER BY code";
                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows > 0) {	
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["code"]  . "'>" . $row["code"]. " " . $row["name_fr"]. "</option>";
                        }
                    }
                ?>
            </select>
        </div>
        <div class="divBOX"><?php echo $dw3_lbl["YEAR"];?>:
            <select id='ecrYEAR'>
                <option <?php if(date("Y")=="2023"){echo "selected";} ?> value='2023'>2023</option>
                <option <?php if(date("Y")=="2024"){echo "selected";} ?> value='2024'>2024</option>
                <option <?php if(date("Y")=="2025"){echo "selected";} ?> value='2025'>2025</option>
                <option <?php if(date("Y")=="2026"){echo "selected";} ?> value='2026'>2026</option>
                <option <?php if(date("Y")=="2027"){echo "selected";} ?> value='2027'>2027</option>
                <option <?php if(date("Y")=="2028"){echo "selected";} ?> value='2028'>2028</option>
                <option <?php if(date("Y")=="2029"){echo "selected";} ?> value='2029'>2029</option>
                <option <?php if(date("Y")=="2030"){echo "selected";} ?> value='2030'>2030</option>
                <option <?php if(date("Y")=="2031"){echo "selected";} ?> value='2031'>2031</option>
                <option <?php if(date("Y")=="2032"){echo "selected";} ?> value='2032'>2032</option>
                <option <?php if(date("Y")=="2033"){echo "selected";} ?> value='2033'>2033</option>
                <option <?php if(date("Y")=="2034"){echo "selected";} ?> value='2034'>2034</option>
                <option <?php if(date("Y")=="2035"){echo "selected";} ?> value='2035'>2035</option>
                <option <?php if(date("Y")=="2036"){echo "selected";} ?> value='2036'>2036</option>
                <option <?php if(date("Y")=="2037"){echo "selected";} ?> value='2037'>2037</option>
                <option <?php if(date("Y")=="2038"){echo "selected";} ?> value='2038'>2038</option>
                <option <?php if(date("Y")=="2039"){echo "selected";} ?> value='2039'>2039</option>
                <option <?php if(date("Y")=="2040"){echo "selected";} ?> value='2040'>2040</option>
            </select>
        </div>
        <div class="divBOX"><?php echo $dw3_lbl["PERIOD"];?>:
            <select id='ecrPERIOD'>
                <option value='1'>1 - Janvier</option>
                <option value='1'>1 - Janvier</option>
                <option value='2'>2 - Février</option>
                <option value='3'>3 - Mars</option>
                <option value='4'>4 - Avril</option>
                <option value='5'>5 - Mai</option>
                <option value='6'>6 - Juin</option>
                <option value='7'>7 - Juillet</option>
                <option value='8'>8 - Aout</option>
                <option value='9'>9 - Septembre</option>
                <option value='10'>10 - Octobre</option>
                <option value='11'>11 - Novembre</option>
                <option value='12'>12 - Décembre</option>
            </select>
        </div>
        <div class="divBOX"><?php echo $dw3_lbl["AMOUNT"];?>:
            <input id="ecrAMOUNT" type="text" class='money' value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX"><?php echo $dw3_lbl["SOURCE"];?>:
            <input id="ecrSOURCE" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX"><?php echo $dw3_lbl["CUSTOMER_ID"];?>:
            <input id="ecrCUSTOMER_ID" type="number" value="" style='width:280px;' onclick="detectCLICK(event,this);">
            <button onclick="openSEL_CLI('NEW');"><span class="material-icons" style='font-size:14px;'>search</span></button>
        </div>
        <div class="divBOX"><?php echo $dw3_lbl["SUPPLIER_ID"];?>:
            <input id="ecrSUPPLIER_ID" type="number"  value="" style='width:280px;' onclick="detectCLICK(event,this);">
            <button onclick="openSEL_FRN('NEW');"><span class="material-icons" style='font-size:14px;'>search</span></button>
        </div>
        <div class="divBOX"><?php echo $dw3_lbl["PRODUCT_ID"];?>:
            <input id="ecrPRODUCT_ID" type="number" value="" style='width:280px;' onclick="detectCLICK(event,this);">
            <button onclick="openSEL_PRD('NEW');"><span class="material-icons" style='font-size:14px;'>search</span></button>
        </div>
        <div class="divBOX"><?php echo $dw3_lbl["USER_ID"];?>:
            <input id="ecrUSER_ID" type="number" value="" style='width:280px;' onclick="detectCLICK(event,this);">
            <button onclick="openSEL_USR('NEW');"><span class="material-icons" style='font-size:14px;'>search</span></button>
        </div>
        <div class="divBOX"><?php echo $dw3_lbl["DOCUMENT"];?>:
            <input id="ecrDOCUMENT" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
    </div>
    <div class='dw3_form_foot'>
        <button class='grey' onclick="closeEDITOR();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
        <button class='green' onclick="newRECORD();"><span class="material-icons">save</span> <?php echo $dw3_lbl["CREATE"]; ?></button>
	</div>
</div>

<div id="edtGL" class="divEDITOR" style='max-width:400px;'></div>
<div id="newGL" class="divEDITOR" style='max-width:400px;'>
    <div id='newGL_HEADER' class='dw3_form_head'>
		<b>Nouveau poste de GL</b>
		<button class='dw3_form_close' onclick='closeNEW_GL();'><span class='material-icons'>close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">Poste/Code GL:
            <input id="newCODE" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Catégorie:
            <input id="newKIND" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Nom du poste FR:
            <input id="newNAME_FR" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Nom du poste EN:
            <input id="newNAME_EN" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Description du poste FR:
            <input id="newDESC_FR" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Description du poste EN:
            <input id="newDESC_EN" type="text" value="" onclick="detectCLICK(event,this);">
        </div>
    </div>
    <div class='dw3_form_foot'>
        <button class='grey' onclick="closeNEW_GL();"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
        <button class='green' onclick="newGL();"><span class="material-icons">save</span> <?php echo $dw3_lbl["CREATE"]; ?></button>
	</div>
</div>

<div id="divSEL_CLI" class="divSELECT" style='min-width:300px;'><input id='whySEL_CLI' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_CLI_HEADER" class='dw3_form_head'><b>
	    Sélection ID <?php echo $dw3_lbl["CLI"]; ?></b>
        <button onclick='closeSEL_CLI();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selCLI" onkeyup="getSEL_CLI('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
        <div id="divSEL_CLI_DATA" style="margin:10px;max-height:75%;">		
            Inscrire votre recherche pour trouver un client.
        </div>
    </div>    
	<div class='dw3_form_foot'>
		<input style="display:none;" id="newCLI" type="text">
		<button class='grey' onclick="closeSEL_CLI();getElementById('divSEL_CLI_DATA').innerHTML='Inscrire votre recherche pour trouver un client.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divSEL_FRN" class="divSELECT" style='min-width:300px;'><input id='whySEL_FRN' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_FRN_HEADER" class='dw3_form_head'><b>
	    Sélection ID <?php echo $dw3_lbl["FRN"]; ?></b>
        <button onclick='closeSEL_FRN();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selFRN" onkeyup="getSEL_FRN('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
        <div id="divSEL_FRN_DATA" style="margin:10px;max-height:75%;">		
            Inscrire votre recherche pour trouver un fournisseur.
        </div>
    </div>
	<div class='dw3_form_foot'>
		<input style="display:none;" id="newFRN" type="text">
		<button class='grey' onclick="closeSEL_FRN();getElementById('divSEL_FRN_DATA').innerHTML='Inscrire votre recherche pour trouver un fournisseur.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divSEL_PRD" class="divSELECT" style='min-width:300px;'><input id='whySEL_PRD' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_PRD_HEADER" class='dw3_form_head'><b>
	    Sélection ID <?php echo $dw3_lbl["PRD"]; ?></b>
        <button onclick='closeSEL_PRD();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selPRD" onkeyup="getSEL_PRD('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_PRD_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver un fournisseur.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<input style="display:none;" id="newPRD" type="text">
		<button class='grey' onclick="closeSEL_PRD();getElementById('divSEL_PRD_DATA').innerHTML='Inscrire votre recherche pour trouver un fournisseur.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divSEL_USR" class="divSELECT" style='min-width:300px;'><input id='whySEL_USR' type='text' value='NEW' style='display:none;'>
    <div id="divSEL_USR_HEADER" class='dw3_form_head'><b>
	    Sélection ID <?php echo $dw3_lbl["USR"]; ?></b>
        <button onclick='closeSEL_USR();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selUSR" onkeyup="getSEL_USR('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
        <div id="divSEL_USR_DATA" style="margin:10px;max-height:75%;">		
            Inscrire votre recherche pour trouver un fournisseur.
        </div>
    </div>
	<div class='dw3_form_foot'>
		<input style="display:none;" id="newUSR" type="text">
		<button class='grey' onclick="closeSEL_USR();getElementById('divSEL_USR_DATA').innerHTML='Inscrire votre recherche pour trouver un fournisseur.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>
<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;"></div>
<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
$(document).ready(function ()
    {
		getRECORDS();
        dragElement(document.getElementById('dw3_form_gl'));
        dragElement(document.getElementById('divNEW'));
        dragElement(document.getElementById('newGL'));
	});

//SELECTION CLIENT
function getSEL_CLI(sS) {
	if(sS==""){sS = document.getElementById("selCLI").value.trim();}
    why = document.getElementById("whySEL_CLI").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_CLI_DATA").innerHTML = this.responseText;
         dragElement(document.getElementById('divSEL_CLI'));
	  }
	};
		xmlhttp.open('GET', 'getSEL_CLI.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) + "&why=" + why, true);
		xmlhttp.send();
}
function openSEL_CLI(why) {
    document.getElementById('divSEL_CLI').style.display = "inline-block";
    document.getElementById('whySEL_CLI').value = why;
    getSEL_CLI('');
}
function closeSEL_CLI() {
    document.getElementById('divSEL_CLI').style.display = "none";
}
function validateCLI(clID,why) {
    var elNEW =  document.getElementById('ecrCUSTOMER_ID');
    if (typeof(elNEW) != 'undefined' && elNEW != null && why == "NEW") {elNEW.value = clID;}
    var elUPD =  document.getElementById('rCUSTOMER_ID');
    if (typeof(elUPD) != 'undefined' && elUPD != null && why == "UPD") {elUPD.value = clID;}
    closeSEL_CLI();
}
//SELECTION FOURNISSEUR
function getSEL_FRN(sS) {
	if(sS==""){sS = document.getElementById("selFRN").value.trim();}
    why = document.getElementById("whySEL_FRN").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_FRN_DATA").innerHTML = this.responseText;
         dragElement(document.getElementById('divSEL_FRN'));
	  }
	};
    xmlhttp.open('GET', 'getSEL_FRN.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) + "&why=" + why, true);
    xmlhttp.send();
}
function openSEL_FRN(why) {
    document.getElementById('divSEL_FRN').style.display = "inline-block";
    document.getElementById('whySEL_FRN').value = why;
    getSEL_FRN('');
}
function closeSEL_FRN() {
    document.getElementById('divSEL_FRN').style.display = "none";
}
function validateFRN(frID,why) {
    var elNEW =  document.getElementById('ecrSUPPLIER_ID');
    if (typeof(elNEW) != 'undefined' && elNEW != null && why == "NEW") {elNEW.value = frID;}
    var elUPD =  document.getElementById('rSUPPLIER_ID');
    if (typeof(elUPD) != 'undefined' && elUPD != null && why == "UPD") {elUPD.value = frID;}
    closeSEL_FRN();
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
    var elNEW =  document.getElementById('ecrPRODUCT_ID');
    if (typeof(elNEW) != 'undefined' && elNEW != null && why == "NEW") {elNEW.value = prID;}
    var elUPD =  document.getElementById('rPRODUCT_ID');
    if (typeof(elUPD) != 'undefined' && elUPD != null && why == "UPD") {elUPD.value = prID;}
    closeSEL_PRD();
}
//SELECTION USER
function getSEL_USR(sS) {
	if(sS==""){sS = document.getElementById("selUSR").value.trim();}
    why = document.getElementById("whySEL_USR").value.trim();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_USR_DATA").innerHTML = this.responseText;
         dragElement(document.getElementById('divSEL_USR'));
	  }
	};
    xmlhttp.open('GET', 'getSEL_USR.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()) + "&why=" + why, true);
    xmlhttp.send();
}
function openSEL_USR(why) {
    document.getElementById('divSEL_USR').style.display = "inline-block";
    document.getElementById('whySEL_USR').value = why;
    getSEL_USR('');
}
function closeSEL_USR() {
    document.getElementById('divSEL_USR').style.display = "none";
}
function validateUSR(usID,why) {
    var elNEW =  document.getElementById('ecrUSER_ID');
    if (typeof(elNEW) != 'undefined' && elNEW != null && why == "NEW") {elNEW.value = usID;}
    var elUPD =  document.getElementById('rUSER_ID');
    if (typeof(elUPD) != 'undefined' && elUPD != null && why == "UPD") {elUPD.value = usID;}
    closeSEL_USR();
}
//STRUCTURE DU GL
function openGL() {
	//var GRPBOX  = document.getElementById("rtID");
	//var srtID  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 var sOBJ = this.responseText;
            document.getElementById('dw3_form_gl').style.display = "inline-block";
			 document.getElementById('dw3_form_gl_kind').innerHTML = sOBJ;
             getKIND();
	}
	};
    xmlhttp.open('GET', 'getGL.php?KEY=' + KEY, true);
    xmlhttp.send();
}
function closeGL() {
	document.getElementById('dw3_form_gl').style.display = "none";
	//document.getElementById('divFADE2').style.display = "none";
}
function closeNEW_GL() {
	document.getElementById('newGL').style.display = "none";
	//document.getElementById('divFADE2').style.display = "none";
}
function getKIND() {
    var GRPBOX  = document.getElementById("selKIND");
    if (GRPBOX.selectedIndex<0){return;}
    var glKIND  = GRPBOX.options[GRPBOX.selectedIndex].value;
	//document.getElementById("divFADE").style.display = "inline-block";
	//document.getElementById("divFADE").style.opacity = "0.5";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("dw3_form_gl_data").innerHTML = this.responseText;
	  }
	};
		//document.getElementById("divFADE").style.width = "100%";
    xmlhttp.open('GET', 'getKIND.php?KEY=' + KEY + '&KIND=' + encodeURIComponent(glKIND) , true);
    xmlhttp.send();
		
}
function updGL(sOLD_CODE) {
	var sNEW_CODE  = document.getElementById("glCODE").value;
	var sKIND  = document.getElementById("glKIND").value;
	var sNAME_FR  = document.getElementById("glNAME_FR").value;
	var sNAME_EN  = document.getElementById("glNAME_EN").value;
	var sDESC_FR  = document.getElementById("glDESC_FR").value;
	var sDESC_EN  = document.getElementById("glDESC_EN").value;

	if (sNEW_CODE == ""){
		document.getElementById("glCODE").style.borderColor = "red";
		document.getElementById("glCODE").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("glCODE").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	

    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load.gif'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){	
                addNotif("<?php echo $dw3_lbl["UPDATED"]; ?>");
                getKIND();
                closeMSG();
                closeEDT_GL();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updGL.php?KEY=' + KEY 
										+ '&KIND=' + encodeURIComponent(sKIND)
										+ '&OLD_CODE=' + encodeURIComponent(sOLD_CODE)
										+ '&NEW_CODE=' + encodeURIComponent(sNEW_CODE)
										+ '&NAME_FR=' + encodeURIComponent(sNAME_FR)
										+ '&NAME_EN=' + encodeURIComponent(sNAME_EN)
										+ '&DESC_FR=' + encodeURIComponent(sDESC_FR)
										+ '&DESC_EN=' + encodeURIComponent(sDESC_EN)
                                        ,true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.5";
}
function newGL() {
	var sCODE  = document.getElementById("newCODE").value;
	var sKIND  = document.getElementById("newKIND").value;
	var sNAME_FR  = document.getElementById("newNAME_FR").value;
	var sNAME_EN  = document.getElementById("newNAME_EN").value;
	var sDESC_FR  = document.getElementById("newDESC_FR").value;
	var sDESC_EN  = document.getElementById("newDESC_EN").value;

	if (sCODE == ""){
		document.getElementById("newCODE").style.borderColor = "red";
		document.getElementById("newCODE").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("newCODE").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	

    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load.gif'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){	
                addNotif("<?php echo $dw3_lbl["CREATED"]; ?>");
                getKIND();
                closeMSG();
                closeNEW_CODE();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newGL.php?KEY=' + KEY 
										+ '&KIND=' + encodeURIComponent(sKIND)
										+ '&CODE=' + encodeURIComponent(sCODE)
										+ '&NAME_FR=' + encodeURIComponent(sNAME_FR)
										+ '&NAME_EN=' + encodeURIComponent(sNAME_EN)
										+ '&DESC_FR=' + encodeURIComponent(sDESC_FR)
										+ '&DESC_EN=' + encodeURIComponent(sDESC_EN)
                                        ,true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.5";
}
function getCODE(sCODE) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("edtGL").innerHTML = this.responseText;
		 document.getElementById("edtGL").style.display = "inline-block";
         dragElement(document.getElementById('edtGL'));
	  }
	};
    xmlhttp.open('GET', 'getCODE.php?KEY=' + KEY + '&CODE=' + sCODE , true);
    xmlhttp.send();	
}
function openNEW_CODE() {
    document.getElementById('newGL').style.display = "inline-block";
}
function closeNEW_CODE() {
    document.getElementById('newGL').style.display = "none";
}
function closeEDT_GL() {
    document.getElementById('edtGL').style.display = "none";
}
function getRECORD(sID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divEDIT").innerHTML = this.responseText;
		 document.getElementById("divEDIT").style.display = "inline-block";
         dragElement(document.getElementById('divEDIT'));
	  }
	};
		//document.getElementById("divFADE").style.width = "100%";
		xmlhttp.open('GET', 'getRECORD.php?KEY=' + KEY + '&ID=' + sID , true);
		xmlhttp.send();	
		document.getElementById("divFADE").style.display = "inline-block";
		document.getElementById("divFADE").style.opacity = "0.5";
}
function getTAXES() {
var GRPBOX  = document.getElementById("selYEAR_FROM"); 
var glYEAR_FROM  = GRPBOX.options[GRPBOX.selectedIndex].value;
var GRPBOX  = document.getElementById("selPERIOD_FROM"); 
var glPERIOD_FROM  = GRPBOX.options[GRPBOX.selectedIndex].value;
var GRPBOX  = document.getElementById("selYEAR_TO"); 
var glYEAR_TO  = GRPBOX.options[GRPBOX.selectedIndex].value;
var GRPBOX  = document.getElementById("selPERIOD_TO"); 
var glPERIOD_TO  = GRPBOX.options[GRPBOX.selectedIndex].value;
var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	  }
	};
		xmlhttp.open('GET', 'getTAXES.php?KEY=' + KEY + '&YF=' + glYEAR_FROM + '&PF=' + glPERIOD_FROM + '&YT=' + glYEAR_TO + '&PT=' + glPERIOD_TO, true);
		xmlhttp.send();
}

function getRECORDS() {
var GRPBOX  = document.getElementById("selYEAR_FROM"); 
var glYEAR_FROM  = GRPBOX.options[GRPBOX.selectedIndex].value;
var GRPBOX  = document.getElementById("selPERIOD_FROM"); 
var glPERIOD_FROM  = GRPBOX.options[GRPBOX.selectedIndex].value;
var GRPBOX  = document.getElementById("selYEAR_TO"); 
var glYEAR_TO  = GRPBOX.options[GRPBOX.selectedIndex].value;
var GRPBOX  = document.getElementById("selPERIOD_TO"); 
var glPERIOD_TO  = GRPBOX.options[GRPBOX.selectedIndex].value;
var glSOMMAIRE  = document.getElementById("selSOM").checked;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getRECORDS.php?KEY=' + KEY + '&YF=' + glYEAR_FROM + '&PF=' + glPERIOD_FROM + '&YT=' + glYEAR_TO + '&PT=' + glPERIOD_TO + '&T=' + glSOMMAIRE, true);
		xmlhttp.send();
}

function newRECORD(){
    var GRPBOX  = document.getElementById("ecrKIND");
	var sKIND  = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX  = document.getElementById("ecrYEAR");
	var sYEAR  = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX  = document.getElementById("ecrPERIOD");
	var sPERIOD  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sAMOUNT  = document.getElementById("ecrAMOUNT").value;
    var GRPBOX  = document.getElementById("ecrGL_CODE");
	var sGL_CODE  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sSOURCE  = document.getElementById("ecrSOURCE").value;
	var sCUSTOMER_ID  = document.getElementById("ecrCUSTOMER_ID").value;
	var sSUPPLIER_ID  = document.getElementById("ecrSUPPLIER_ID").value;
	var sPRODUCT_ID  = document.getElementById("ecrPRODUCT_ID").value;
	var sUSER_ID  = document.getElementById("ecrUSER_ID").value;
	var sDOCUMENT  = document.getElementById("ecrDOCUMENT").value;


	
	if (sAMOUNT == ""){
		document.getElementById("ecrAMOUNT").style.borderColor = "red";
		document.getElementById("ecrAMOUNT").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("ecrAMOUNT").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	if (sYEAR == ""){
		document.getElementById("ecrYEAR").style.borderColor = "red";
		document.getElementById("ecrYEAR").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("ecrYEAR").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	if (sPERIOD == ""){
		document.getElementById("ecrPERIOD").style.borderColor = "red";
		document.getElementById("ecrPERIOD").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("ecrPERIOD").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	if (sSOURCE == ""){
		document.getElementById("ecrSOURCE").style.borderColor = "red";
		document.getElementById("ecrSOURCE").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("ecrSOURCE").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	

    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load.gif'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){	
                addNotif("<?php echo $dw3_lbl["CREATED"]; ?>");
                getRECORDS();
                closeMSG();
                closeEDITOR();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'newRECORD.php?KEY=' + KEY 
										+ '&K=' + encodeURIComponent(sKIND)
										+ '&YR=' + encodeURIComponent(sYEAR)
										+ '&PER=' + encodeURIComponent(sPERIOD)
										+ '&MNT=' + encodeURIComponent(sAMOUNT)
										+ '&GL=' + encodeURIComponent(sGL_CODE)
										+ '&SOURCE=' + encodeURIComponent(sSOURCE)
										+ '&CLI=' + encodeURIComponent(sCUSTOMER_ID)
										+ '&SUP=' + encodeURIComponent(sSUPPLIER_ID)
										+ '&USR=' + encodeURIComponent(sUSER_ID)
										+ '&DOC=' + encodeURIComponent(sDOCUMENT)
                                        ,true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.5";
}

function updRECORD(sID){
    var GRPBOX  = document.getElementById("rKIND");
	var sKIND  = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX  = document.getElementById("rYEAR");
	var sYEAR  = GRPBOX.options[GRPBOX.selectedIndex].value;
    var GRPBOX  = document.getElementById("rPERIOD");
	var sPERIOD  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sAMOUNT  = document.getElementById("rAMOUNT").value;
    var GRPBOX  = document.getElementById("rGL_CODE");
	var sGL_CODE  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var sSOURCE  = document.getElementById("rSOURCE").value;
	var sCUSTOMER_ID  = document.getElementById("rCUSTOMER_ID").value;
	var sSUPPLIER_ID  = document.getElementById("rSUPPLIER_ID").value;
	var sPRODUCT_ID  = document.getElementById("rPRODUCT_ID").value;
	var sUSER_ID  = document.getElementById("rUSER_ID").value;
	var sDOCUMENT  = document.getElementById("rDOCUMENT").value;

	if (sAMOUNT == ""){
		document.getElementById("rAMOUNT").style.borderColor = "red";
		document.getElementById("rAMOUNT").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("rAMOUNT").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	if (sYEAR == ""){
		document.getElementById("rYEAR").style.borderColor = "red";
		document.getElementById("rYEAR").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("rYEAR").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	if (sPERIOD == ""){
		document.getElementById("rPERIOD").style.borderColor = "red";
		document.getElementById("rPERIOD").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("rPERIOD").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	
	if (sSOURCE == ""){
		document.getElementById("rSOURCE").style.borderColor = "red";
		document.getElementById("rSOURCE").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("rSOURCE").style.borderColor = "lightgrey";
		//document.getElementById("lblPRD").innerHTML = "";
	}	

    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='width:100px;height:auto;' src='/pub/img/load.gif'>";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){	
                addNotif("<?php echo $dw3_lbl["MODIFIED"]; ?>");
                getRECORDS();
                closeMSG();
                closeEDITOR();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updRECORD.php?KEY=' + KEY 
										+ '&ID=' + encodeURIComponent(sID)
										+ '&K=' + encodeURIComponent(sKIND)
										+ '&YR=' + encodeURIComponent(sYEAR)
										+ '&PER=' + encodeURIComponent(sPERIOD)
										+ '&MNT=' + encodeURIComponent(sAMOUNT)
										+ '&GL=' + encodeURIComponent(sGL_CODE)
										+ '&SOURCE=' + encodeURIComponent(sSOURCE)
										+ '&CLI=' + encodeURIComponent(sCUSTOMER_ID)
										+ '&SUP=' + encodeURIComponent(sSUPPLIER_ID)
										+ '&USR=' + encodeURIComponent(sUSER_ID)
										+ '&DOC=' + encodeURIComponent(sDOCUMENT)
                                        ,true);
		xmlhttp.send();
		document.getElementById("divFADE2").style.display = "inline-block";
		document.getElementById("divFADE2").style.opacity = "0.5";
}

function deleteRECORD(ID) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.5";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button onclick='closeMSG();' style='background:#555;'><span class='material-icons'>cancel</span> Annuler</button> <button onclick='delRECORD(" + ID + ");' style='background:red;'><span class='material-icons' style='vertical-align:middle;'>delete</span> Delete</button>";
}
function delRECORD(ID) {
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
				//document.getElementById("divMSG").style.display = "inline-block";
				addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
				getRECORDS();
                closeEDITOR();
                closeMSG();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delRECORD.php?KEY=' + KEY + '&ID=' + ID , true);
		xmlhttp.send();
		
}

function deleteGL(CODE) {
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.5";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<?php echo $dw3_lbl["DEL_ASK"]; ?><br><br><button onclick='closeMSG();' style='background:#555;'><span class='material-icons'>cancel</span> Annuler</button> <button onclick='delGL(" + CODE + ");' style='background:red;'><span class='material-icons' style='vertical-align:middle;'>delete</span> Delete</button>";
}
function delGL(CODE) {
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.trim() == ""){
				//document.getElementById("divMSG").style.display = "inline-block";
				addNotif("<?php echo $dw3_lbl["DEL_OK"]; ?>");
				getRECORDS();
                closeEDITOR();
                closeMSG();
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>";
		  } 
	  
	  }
	};
		xmlhttp.open('GET', 'delGL.php?KEY=' + KEY + '&CODE=' + CODE , true);
		xmlhttp.send();
		
}


</script>
</body>
</html>
<?php $dw3_conn->close(); ?>

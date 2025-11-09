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
$APNAME = "Mises à jour & Sécurité";
$DW3_VERSION = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/VERSION');
if ($_SERVER["SERVER_NAME"] == "dw3.ca" ||
    $_SERVER["SERVER_NAME"] == "dev.ww7.ca"){
    $DW3_UPDATE_VERSION = file_get_contents('https://ww7.ca/dw3/VERSION_DEV');
}else{
    $DW3_UPDATE_VERSION = file_get_contents('https://ww7.ca/dw3/VERSION');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';
?>
<div id="divHEAD">
	<table style="width:100%;margin:0px;white-space:nowrap;">
		<tr style="margin:0px;padding:0px;">
			<td width="*">
                <select id="config_select" onchange="window.open(this.value+'?KEY='+KEY,'_self')">
                    <option value="/app/config/config.php"> Tableau de Bord </option>
                    <option value="/app/config/config_1_info.php"> Infos générales & Facturation </option>
                    <option value="/app/config/config_2_location.php"> Adresses et Divisions </option>
                    <option value="/app/config/config_3_structure.php"> Structure de l'entreprise </option>
                    <option value="/app/config/config_4_gouv.php"> Renseignements Gouvernementaux </option>
                    <option value="/app/config/config_5_plan.php"> Plan d'affaire </option>
                    <option value="/app/config/config_6_display.php"> Affichage </option>
                    <option value="/app/config/config_7_index.php"> Index & Pages Web </option>
                    <option value="/app/config/config_8_api.php"> API's, IA's et Réseaux Sociaux</option>
                    <option selected value="/app/config/config_9_update.php"> Mises à jour & Sécurité </option>
                    <option value="/app/config/config_10_license.php"> Licenses, politiques, conditions et sitemap </option>
                </select>
            </td>
			<td style="width:50px;margin:0px;padding:0px;text-align: right; text-justify: inter-word;">
				<button style="margin:0px 2px 0px 2px;padding:8px;" class='orange' onclick="openBLACKLIST();"><span class="material-icons">gpp_bad</span></button>
			 </td>
			<td style="width:50px;margin:0px;padding:0px;text-align: right; text-justify: inter-word;">
				<button style="margin:0px 2px 0px 2px;padding:8px;" class='grey' onclick="openSECURITY();"><span class="material-icons">security</span></button>
			 </td>
		</tr>
	</table>
</div>
<div class='divMAIN' style="padding-top:50px;">
    <div class='divPAGE'>	
        <div class="divBOX">Votre version:
            <h1><?php echo $DW3_VERSION; ?></h1>
        </div>	<br>
        <div class="divBOX">Nouvelle version:
            <h1><?php 
                    echo $DW3_UPDATE_VERSION; 
                    if ($_SERVER["SERVER_NAME"] == "dev.ww7.ca"){
                        echo " (dev)";
                    } 
                ?>
            </h1>
        </div>	<br>
        <div class="divBOX" id='dw3_update_box' style='max-width:99%;max-height:250px;height:250px;overflow-y:scroll;overflow-x:hidden;'><div style='position:sticky;top:-14px;width:100%;background:var(--dw3_form_background);'>Détails de la dernière mise à jour:</div>
            <pre id='update_output' style='background:#eee;color:#555;min-height:200px;font-size:10px;'><?php echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/sbin/update.txt'); ?></pre>
        </div>
        Veuillez noter que lors des mises à jour certains fichiers sources de DW3 seront remplacés. Si vous y avez apporté des modifications n'oubliez pas de faire une copie de ceux ci. Vous permettant ainsi de réappliquer les modifications, si toujours necessaires.
        <br><br><button id='dw3_upd_btn' class='blue' <?php if ($DW3_UPDATE_VERSION==$DW3_VERSION){echo" disabled ";}?> onclick="update_dw3();"><span class="material-icons">save</span> Mettre à jour</button>
    </div>
    <div class='divPAGE' style='display:none;'>	
        <div class="divBOX">Dernier backup:
            <h2>Aucun backup trouvé</h2>
        </div><br>
        <div class="divBOX">Détails du dernier backup:
            <div id='backup_output' style='background:#eee;color:#555;min-height:200px;'></div>
        </div>
        <br><br><button onclick="restore_dw3();"><span class="material-icons">cloud_upload</span> Restore</button>
        <button onclick="backup_dw3();"><span class="material-icons">cloud_download</span> Backup</button>
    </div>
    <div class='divPAGE' style='display:none;'>	
        <div class="divBOX" style='max-width:99%;'>Logs:
            <pre id='logs_output' style='background:#eee;color:#555;min-height:200px;overflow:auto;'>
            </pre>
        </div>
        <br><br><button onclick="clean_dw3();"><span class="material-icons">delete_sweep</span>Effacer les logs</button>
    </div>
</div>

<div id="divMSG"></div>

<div id="divSEC_CFG" class="divEDITOR" style='max-width:100%;'>
    <div id="divSEC_CFG_HEADER" class='dw3_form_head'> 
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'><?php if ($USER_LANG == "FR"){echo "Fichiers journaux système";}else{echo "System log files";} ?></div></h3>
		<button class='dw3_form_close' onclick='getElementById("divSEC_CFG").style.display="none";closeMSG();'><span class='material-icons'>close</span></button></div>
    <div class='dw3_form_data'>
        <select id="cfgLOG_DIR" onchange='getLOG();'>
            <option value="root">Root</option>
            <option value="client">Tableau de bord Client</option>
            <option value="sbin">/sbin</option>
            <option value="api/callbacks">API callbacks</option>
            <option value="api/Grok">API xAI Grok</option>
            <option value="api/chatGPT">API chatGPT</option>
            <option value="api/DoorDash">API DoorDash</option>
            <option value="api/google">API Google</option>
            <option value="api/livar">API Livraison à Rabais</option>
            <option value="api/paypal">API PayPal</option>
            <option value="api/Square">API Square</option>
            <option value="pub/js">/pub/js</option>
            <option value="pub/css">/pub/css</option>
            <option value="pub/page">/pub/page</option>
            <option value="pub/page/agenda">Page - Agenda public</option>
            <option value="pub/page/article">Page - Articles et Infolettres</option>
            <option value="pub/page/classifieds">Page - Catégories annonces classés</option>
            <option value="pub/page/classifieds2">Page - Annonces classés</option>
            <option value="pub/page/calendar">Page - Calendrier mensuel public</option>
            <option value="pub/page/calendar2">Page - Calendrier annuel public</option>
            <option value="pub/page/contact1">Page - Contact1</option>
            <option value="pub/page/contact2">Page - Contact2</option>
            <option value="pub/page/contact3">Page - Contact3</option>
            <option value="pub/page/location">Page - Selection magasin</option>
            <option value="pub/page/profil">Page - Profil</option>
            <option value="pub/page/jobs">Page - Emplois</option>
            <option value="pub/page/home">Page - Personnalisée</option>
            <option value="pub/page/product">Page - Produit</option>
            <option value="pub/page/products">Page - Produits</option>
            <option value="pub/page/quiz">Page - Questionnaire</option>
            <option value="pub/page/submit">Page - Soumission</option>
            <option value="pub/page/tracking">Page - Tracking</option>
            <option value="pub/section">/pub/section</option>
            <option value="pub/section/affiliate">Section - Affiliés</option>
            <option value="pub/section/calendar">Section - Calendrier mensuel public</option>
            <option value="pub/section/calendar2">Section - Calendrier annuel public</option>
            <option value="pub/section/category">Section - Catégories produits</option>
            <option value="pub/section/category_ad">Section - Catégories annonces classés</option>
            <option value="pub/section/contact3">Section - Contact3</option>
            <option value="pub/section/counter3">Section - Counter3</option>
            <option value="pub/section/gallery1">Section - Gallerie 1</option>
            <option value="pub/section/gallery2">Section - Gallerie 2</option>
            <option value="pub/section/historic">Section - Historic</option>
            <option value="pub/section/perso1">Section - Perso</option>
            <option value="pub/section/navigation">Section - Navigation</option>
            <option value="pub/section/product">Section - Produit</option>
            <option value="pub/section/products">Section - Produits</option>
            <option value="pub/section/classifieds">Section - Annonces classés</option>
            <option value="pub/section/realisation">Section - Realisation</option>
            <option value="pub/section/slideshow1">Section - Slideshow1</option>
            <option value="pub/section/slideshow2">Section - Slideshow2</option>
            <option value="pub/section/slideshow3">Section - Slideshow3</option>
            <option value="pub/section/slideshow4">Section - Slideshow4</option>
            <option value="app/">Scripts communs à toutes les applications</option>
            <option value="app/purchase">Application - Achats</option>
            <option value="app/article">Application - Articles et Infolettre</option>
            <option value="app/budget">Application - Budget</option>
            <option value="app/calendar">Application - Calendrier</option>
            <option value="app/customer">Application - Client</option>
            <option value="app/order">Application - Commande client</option>
            <option value="app/config">Application - Configuration</option>
            <option value="app/email">Application - Courriel</option>
            <option value="app/quiz">Application - Document</option>
            <option value="app/event">Application - Évènements</option>
            <option value="app/shipping">Application - Expéditions</option>
            <option value="app/export">Application - Exportations de données</option>
            <option value="app/invoice">Application - Facture client</option>
            <option value="app/timesheet">Application - Feuille de temps</option>
            <option value="app/supplier">Application - Fournisseur</option>
            <option value="app/road_manager">Application - Gestion des routes</option>
            <option value="app/gl">Application - Grand Livre</option>
            <option value="app/import">Application - Importations de données</option>
            <option value="app/inventory">Application - Inventaire</option>
            <option value="app/road">Application - Livre de route</option>
            <option value="app/message">Application - Messagerie Interne</option>
            <option value="app/production">Application - Production</option>
            <option value="app/product">Application - Produit</option>
            <option value="app/project">Application - Projet</option>
            <option value="app/statistic">Application - Statistiques</option>
            <option value="app/task">Application - Tâches</option>
            <option value="app/transaction">Application - Transactions</option>
            <option value="app/user">Application - Utilisateurs</option>
        </select>
        <div id='divSECU_DATA' style='font-size:13px;text-align:left;font-family:Roboto;'></div>
    </div>
    <div class='dw3_form_foot' style='height:43px;'><button class='dw3_form_close' style='width:auto;' onclick='clearLOG();'><span class='material-icons' style='vertical-align:middle;'>delete</span> Effacer le LOG</button></div>
</div>
<div id="divBL" class="divEDITOR" style='max-width:100%;'>
    <div id="divBL_HEADER" class='dw3_form_head'> 
        <h3 style='vertical-align:middle;height:40px;'><div style='display: grid;align-items: center;height:40px;'>IP Blacklist</div></h3>
		<button class='dw3_form_close' onclick='getElementById("divBL").style.display="none";closeMSG();'><span class='material-icons'>close</span></button></div>
    <div class='dw3_form_data'>
         <div id='divBL_DATA' style='font-size:13px;text-align:left;font-family:Roboto;'></div>
    </div>
    <div class='dw3_form_foot' style='height:43px;'><button class='dw3_form_close' onclick='clearBL();'><span class='material-icons' style='vertical-align:middle;'>delete</span> Effacer la blacklist</button></div>
</div>
<div id="divOPT"></div>


<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var DW3_UPDATE_VERSION = '<?php echo $DW3_UPDATE_VERSION; ?>';
var DW3_VERSION = '<?php echo $DW3_VERSION; ?>';

$(document).ready(function (){
    if (DW3_UPDATE_VERSION != DW3_VERSION && DW3_UPDATE_VERSION!=""){
            //document.getElementById("divFADE2").style.opacity = "1";
            //document.getElementById("divFADE2").style.display = "inline-block";
            //document.getElementById("divMSG").style.display = "inline-block";
            addNotif("<span style='text-align:left;'>Mise à jour disponible! <br class='small'>Votre version:" + DW3_VERSION + "<br class='small'>Nouvelle version:" + DW3_UPDATE_VERSION+"</span>");
    }
    dragElement(document.getElementById('divSEC_CFG'));
    dragElement(document.getElementById('divBL'));
    document.getElementById('config_select').value="/app/config/config_9_update.php";
});

window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    window.location.reload();
  }
});

function update_dw3(){
    document.getElementById("dw3_upd_btn").disabled = true;

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
        var objDiv = document.getElementById("update_output");
        var objBox = document.getElementById("dw3_update_box");
        objDiv.innerHTML = this.responseText;
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("dw3_upd_btn").disabled = false;
            addNotif("Mise à jour terminée.");
        }
        //objDiv.scroll(0,objDiv.scrollHeight);
        //objDiv.scrollTop = objDiv.scrollHeight;
        objBox.scrollTo({top: objBox.scrollHeight,behavior: 'instant'});
        //objDiv.scrollIntoView(false);
/*         if (this.readyState == 4 && this.status == 200) {
            document.getElementById("divFADE2").style.opacity = "1";
            document.getElementById("divFADE2").style.display = "inline-block";
            document.getElementById("divMSG").style.display = "inline-block";
            document.getElementById("divMSG").innerHTML = "Mise à jour terminée<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
        } */
	};
		xmlhttp.open('GET', '/sbin/update_dw3.php?KEY=' + KEY, true);
		xmlhttp.send();
}

function openBLACKLIST() {
	document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divBL_DATA").innerHTML = this.responseText;
		 document.getElementById("divBL").style.display = "inline-block";
		 window.scrollTo(0, 0);
         closeMSG(); 
	  }
	};
		xmlhttp.open('GET', 'getBLACKLIST.php?KEY=' + KEY , true);
		xmlhttp.send();
}
function clearBL() {
	document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divBL_DATA").innerHTML = "";
         closeMSG();
	  }
	};
		xmlhttp.open('GET', 'delBLACKLIST.php?KEY=' + KEY , true);
		xmlhttp.send();
}

function delBL_IP(sIP) {
	document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        openBLACKLIST();
        closeMSG();
	  }
	};
		xmlhttp.open('GET', 'delBL_IP.php?KEY=' + KEY + "&IP=" + sIP, true);
		xmlhttp.send();
}

function openSECURITY() {
    getLOG('root');
    document.getElementById("divSEC_CFG").style.display = "inline-block";
	document.getElementById("cfgLOG_DIR").selectedIndex = 0;
}
function clearLOG(sLOG) {
    if (sLOG == "" || sLOG == undefined){
        var GRPBOX  = document.getElementById("cfgLOG_DIR");
	    var sLOG  = GRPBOX.options[GRPBOX.selectedIndex].value;
    }
	document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSECU_DATA").innerHTML = this.responseText;
		//document.getElementById("divSEC_CFG").style.display = "inline-block";
		 //window.scrollTo(0, 0);
         closeMSG();
         //dragElement(document.getElementById('divSEC_CFG'));
         document.getElementById("cfgLOG_DIR").focus();
	  }
	};
		xmlhttp.open('GET', 'clearLOG.php?KEY=' + KEY + "&L=" + encodeURIComponent(sLOG), true);
		xmlhttp.send();
}
function getLOG(sLOG) {
    if (sLOG == "" || sLOG == undefined){
        var GRPBOX  = document.getElementById("cfgLOG_DIR");
	    var sLOG  = GRPBOX.options[GRPBOX.selectedIndex].value;
    }
	document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:100px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSECU_DATA").innerHTML = this.responseText;
		 document.getElementById("divSEC_CFG").style.display = "inline-block";
		 window.scrollTo(0, 0);
         closeMSG();
         dragElement(document.getElementById('divSEC_CFG'));
	  }
	};
		xmlhttp.open('GET', 'getLOG.php?KEY=' + KEY + "&L=" + encodeURIComponent(sLOG), true);
		xmlhttp.send();
}

</script>
</body>
</html>
<?php $dw3_conn->close();exit(); ?>
<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';  
?>

<div id='divHEAD'><table style="width:100%;margin:0px;white-space:nowrap;"><tr style="margin:0px;padding:0px;"><td width="*" style="margin:0px;padding:0px;">
	Importation de données
	  </td><td width="80" style="margin:0px;padding:0px;text-align:right;">
		<button style="display:none;margin:0px 2px 0px 2px;padding:8px;"  onclick="openMENU_POPUP();"><span class="material-icons">add</span></button>
	  </td></tr></table>
</div>
<div class='divMAIN' style="padding-top:50px;">
    <h2 style='text-align:left;'>Importer des données à partir de l'API Square:</h2>
    	<div class="divBOX">Produits:
            <button onclick="getSQ_PRD_LIST();">Lister</button>
        </div><br>
    	<div class="divBOX">Catégories de produits:
            <button onclick="getSQ_CAT_LIST();">Lister</button>
        </div><br>
    <h2 style='text-align:left;'>Importer des données à partir d'un fichier Excel:</h2>
    <h3 style='text-align:left;width:100%;padding:5px;'>Bases de données</h3>
        <div class="divBOX">Utilisateurs:
        <a href="TEMPLATE_USERS.xlsx" download><button>Modèle</button></a>
            <button onclick="getIMPORT('USER');">Importer</button>
        </div><br>
        <div class="divBOX">Fournisseurs:
        <a href="TEMPLATE_SUPPLIERS.xlsx" download><button>Modèle</button></a>
            <button onclick="getIMPORT('BDFRN');">Importer</button>
        </div><br>
        <div class="divBOX">Clients:
            <a href="TEMPLATE_CUSTOMERS.xlsx" download><button>Modèle</button></a>
            <button onclick="getIMPORT('BDCLNT');">Importer</button>
        </div><br>
        <div class="divBOX" style='max-width:600px;'>Produits:
        <div style='float:right;'><a href="TEMPLATE_PRODUCTS.xlsx" download><button><span class="material-icons">plagiarism</span> Modèle</button></a>
            <button onclick="getIMPORT('BDPROD');"><span class="material-icons">upload_file</span> Importer</button></div>
            <table class='tblDATA' style='font-size:0.7em;white-space:wrap;'><tr><th colspan=2>Détails sur chaques colonnes</th></tr>
                <tr><td>ID</td><td>#Identification du produit. Si vide un nouveau produit sera créé.</td></tr>	
                <tr><td>STAT</td><td>Status. 0=Disponible, 1=Inactif, 2=Rappel, 3=Bêta, 4=À venir bientôt, 5=Discontinué, 6=En production. <br>Seul le status 0 peut être mis en vente. Les status de produits peuvent être modifiés dans l'application Configuration; section: Variables d'environement; champ: PRODUCT_STAT.</td></tr>
                <tr><td>CATEGORY_ID</td><td>#Identification de la catégorie principale. Qui peuvent être créées/modifiées dans l'application Configuration; section: Catégories de produits.</td></tr>	
                <tr><td>CATEGORY2_ID</td><td>#Identification de la deuxième catégorie.</td></tr>	
                <tr><td>CATEGORY3_ID</td><td>#Identification de la troisième catégorie.</td></tr>	
                <tr><td>SUPPLIER_ID</td><td>#Identification du fournisseur principal.</td></tr>	
                <tr><td>UPC</td><td>Code barre du produit</td></tr>	
                <tr><td>SKU</td><td>#Identification interne ou du fournisseur. Peut être le même que le code UPC.</td></tr>	
                <tr><td>NAME_FR</td><td>Nom du produit en français.</td></tr>	
                <tr><td>NAME_EN</td><td>Nom du produit en anglais.</td></tr>	
                <tr><td>DESCRIPTION_FR</td><td>Description du produit en français.</td></tr>	
                <tr><td>DESCRIPTION_EN</td><td>Description du produit en anglais.</td></tr>	
                <tr><td>URL_IMG</td><td>Nom de l'image principale du produit. Les images de chaque produit se trouvent dans un dossier distinct; soit /fs/product/[id]/.</td></tr>	
                <tr><td>PRICE1</td><td>Prix courant.</td></tr>	
                <tr><td>PRICE2</td><td>Prix avec un achat minimum de [qty_min_price2], qui est définit par la fiche produit.</td></tr>	
                <tr><td>TAX_PROV</td><td>Ajouter les taxes provinciales au prix. 0=non, 1=oui.</td></tr>	
                <tr><td>TAX_FED</td><td>Ajouter les taxes fédérales au prix. 0=non, 1=oui.</td></tr>	
                <tr><td>KG</td><td>Poid en kilogrammes.</td></tr>	
                <tr><td>HEIGHT</td><td>Hauteur en centimètres.</td></tr>	
                <tr><td>WIDTH</td><td>Largeur en centimètres.</td></tr>	
                <tr><td>DEPTH</td><td>Profondeur en centimètres.</td></tr>	
                <tr><td>BRAND</td><td>Marque ou fabriquant du produit.</td></tr>	
                <tr><td>MODEL</td><td>Modèle du produit.</td></tr>	
                <tr><td>MODEL_YEAR</td><td>Année de fabrication.</td></tr>  
                <tr><td>ALLOW_PICKUP</td><td>Permettre le rammassage en boutique.</td></tr>  
                <tr><td>WEB_AVAILABLE</td><td>Afficher le produit dans la boutique.</td></tr>  
                <tr><td>BTN_ACTION1</td><td>Action du bouton 1 (soit; DOWNLOAD,SUBMIT,CART,LINK,BUY_EMAIL ou NONE).</td></tr>  
                <tr><td>WEB_BTN_ICON</td><td>Nom de l'icone de Google Materials.</td></tr>  
                <tr><td>WEB_BTN_FR</td><td>Nom sur le bouton 1 en français.</td></tr>  
                <tr><td>WEB_BTN_EN</td><td>Nom sur le bouton 1 en anglais.</td></tr>  
                <tr><td>URL_ACTION1</td><td>Url du bouton 1.</td></tr>  
                <tr><td>BTN_ACTION2</td><td>Action du bouton 2.</td></tr>  
                <tr><td>WEB_BTN2_ICON</td><td>Nom de l'icone du bouton 2.</td></tr>  
                <tr><td>WEB_BTN2_FR</td><td>Nom sur le bouton 1 en français.</td></tr>  
                <tr><td>WEB_BTN2_EN</td><td>Nom sur le bouton 1 en anglais.</td></tr>  
                <tr><td>URL_ACTION2</td><td>Url du bouton 2.</td></tr>  
                <tr><td>PRICE_TEXT_FR</td><td>Texte qui remplace le prix en français.</td></tr>  
                <tr><td>PRICE_TEXT_EN</td><td>Texte qui remplace le prix en anglais.</td></tr>  
                <tr><td>PRICE_SUFFIX_FR</td><td>Texte après le prix en français.</td></tr>  
                <tr><td>PRICE_SUFFIX_EN</td><td>Texte après le prix en anglais.</td></tr>  
                <tr><td>SHIP_TYPE</td><td>Type d'expédition du produit (INTERNAL, CARRIER ou NONE).</td></tr>  
                <tr><td>DSP_INV</td><td>Afficher l'inventaire dans les détails du produit de la boutique.</td></tr>  
                <tr><td>DSP_UPC</td><td>Afficher le code UPC dans les détails du produit de la boutique.</td></tr>  
                <tr><td>DSP_MESURE</td><td>Afficher la hauteur, la largeur, la profondeur et le poid dans les détails du produit de la boutique.</td></tr>  
                <tr><td>DSP_MODEL</td><td>Afficher la marque, le modèle et l'année du fabrication dans les détails du produit de la boutique. (Seulement les valeurs qui ne sont pas vides seront affichés)</td></tr>  
            </table>
        </div>
</div>        
    <h2 style='text-align:left;'>Importer des données à partir d'une image:</h2>
        <div class="divBOX">
            <button onclick="getOCR();">Test OCR</button>
        </div>
<div class='divMAIN'>
    <h3 style='text-align:left;width:100%;padding:5px;'>Images</h3>

	<div class="divBOX"><br>Photos de produits:

	</div>	
	<div class="divBOX"><br>Photos de l'entreprise:

	</div>
	<div class="divBOX"><br>Photos de plans:

	</div>
</div>
<div id="divMSG"></div>

<div id="divIMPORT_SELECT" class="divEDITOR">
    <div id="divIMPORT_SELECT_HEADER" class='dw3_form_head'>
        <h3 style='vertical-align:middle;height:40px;'><div id='divIMPORT_SELECT_TITLE' style='display: grid;align-items: center;height:40px;'>Catalogue Square</div></h3>       
        <button class='dw3_form_close' onclick='closeIMPORT_SELECT();closeMSG();'><span class='material-icons'>close</span></button>
    </div>
    <div class='dw3_form_data' id="divIMPORT_SELECT_MAIN" style='overflow:auto;'></div>
    <div class='dw3_form_foot'>
        <button class='grey' onclick='closeIMPORT_SELECT();closeMSG();'><span class='material-icons' style='vertical-align:middle;'>close</span> Fermer</button>
    </div>
</div>

<form enctype="multipart/form-data" style='display:none;'>
  <input id="updBDCLNT" type=file name="fileBDCLNT[]">
</form>
<form enctype="multipart/form-data" style='display:none;'>
  <input id="updBDPROD" type=file name="fileBDPROD[]">
</form>

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>

<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var date_time = '<?php echo($datetime); ?>';
$(document).ready(function ()
    {
		  document.getElementById('updBDCLNT').addEventListener('change', handleBDCLNT, false);
		  document.getElementById('updBDPROD').addEventListener('change', handleBDPROD, false);
	});

function getIMPORT(sDB){
	var sInput = "upd" + sDB;
	document.getElementById(sInput).click();
}

function dw3_crypt($str) {
    $dw3_decryptk = "0123456789abcdef";
    $dw3_cryptk = "<?php echo $dw3_crypt_ini["cryptk"]; ?>";
    if (str.length >= 1){
        //hstr = "0xF1" + str.charCodeAt(0).toString(16)
        //hstr = ascii_to_hexa(str);
        hstr = bytesToHex(stringToUTF8Bytes(str));
        strl = hstr.length;
        keyl = dw3_cryptk.length;
        crypted = '';
        for (i = 0; i < strl; i++) {
            for (ii = 0; ii < keyl; ii++) {
                if (hstr.substr(i,1)==dw3_decryptk.substr(ii,1)){
                    crypted += dw3_cryptk.substr(ii,1);
                }
            }
        }
        return crypted;
    } else {
        return str;
    }
}
function ascii_to_hexa(str){
	var arr1 = [];
	for (var n = 0, l = str.length; n < l; n ++) {
		var hex = Number(str.charCodeAt(n)).toString(16);
		arr1.push(hex);
	 }
	return arr1.join('');
}
function bytesToHex(bytes) {
  return Array.from(
    bytes,
    byte => byte.toString(16).padStart(2, "0")
  ).join("");
}
function stringToUTF8Bytes(string) {
  return new TextEncoder().encode(string);
}
function sq_msg_done() {
    addMsg("Cet item a déjà été importé.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>")
}
function closeIMPORT_SELECT() {
    document.getElementById("divIMPORT_SELECT").style.display = "none";
    document.getElementById("divFADE").style.opacity = "0";
    document.getElementById("divFADE").style.display = "none";	
}
//-----------------------
//        SQUARE
//-----------------------
function getSQ_PRD_LIST(){
    document.getElementById("divFADE").style.opacity = "0.6";
    document.getElementById("divFADE").style.display = "inline-block";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divIMPORT_SELECT").style.display = "inline-block";
        document.getElementById("divIMPORT_SELECT_MAIN").innerHTML = this.responseText ;
	  }
	};
		xmlhttp.open('GET', '/api/Square/catalog_list.php?KEY=' + KEY, true);
		xmlhttp.send();
}
function getSQ_CAT_LIST(){
    document.getElementById("divFADE").style.opacity = "0.6";
    document.getElementById("divFADE").style.display = "inline-block";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divIMPORT_SELECT").style.display = "inline-block";
        document.getElementById("divIMPORT_SELECT_MAIN").innerHTML = this.responseText ;
	  }
	};
		xmlhttp.open('GET', '/api/Square/category_list.php?KEY=' + KEY, true);
		xmlhttp.send();
}
function addSquarePrd(line_no){
    document.getElementById("sq_btn"+line_no).style.display="none";
    document.getElementById("sq_btn_ok"+line_no).style.display="inline-block";
    var sSQ_OPTS = document.getElementById("sq_opts"+line_no).innerHTML;
    var sSQ_ID = document.getElementById("sq_id"+line_no).innerHTML;
    var sSQ_NAME = document.getElementById("sq_name"+line_no).innerHTML;
    var sSQ_DESC = document.getElementById("sq_desc"+line_no).innerHTML;
    var sSQ_IMG = document.getElementById("sq_img"+line_no).innerHTML;
    var sSQ_IMG2 = document.getElementById("sq_img2_"+line_no).innerHTML;
    var sSQ_IMG3 = document.getElementById("sq_img3_"+line_no).innerHTML;
    var sSQ_IMG4 = document.getElementById("sq_img4_"+line_no).innerHTML;
    var sSQ_IMG5 = document.getElementById("sq_img5_"+line_no).innerHTML;
    var sSQ_PRICE = document.getElementById("sq_price"+line_no).innerHTML;
    var sSQ_CAT = document.getElementById("sq_cat"+line_no).innerHTML;
    var sSQ_CAT2 = document.getElementById("sq_cat2_"+line_no).innerHTML;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'addSquarePrd.php?KEY=' + KEY 
            + '&SQ_OPTS=' + encodeURIComponent(sSQ_OPTS)
            + '&SQ_ID=' + encodeURIComponent(sSQ_ID)
            + '&SQ_NAME=' + encodeURIComponent(sSQ_NAME)
            + '&SQ_DESC=' + encodeURIComponent(sSQ_DESC)
            + '&SQ_IMG=' + encodeURIComponent(sSQ_IMG)
            + '&SQ_IMG2=' + encodeURIComponent(sSQ_IMG2)
            + '&SQ_IMG3=' + encodeURIComponent(sSQ_IMG3)
            + '&SQ_IMG4=' + encodeURIComponent(sSQ_IMG4)
            + '&SQ_IMG5=' + encodeURIComponent(sSQ_IMG5)
            + '&SQ_PRICE=' + encodeURIComponent(sSQ_PRICE)
            + '&SQ_CAT=' + encodeURIComponent(sSQ_CAT)
            + '&SQ_CAT2=' + encodeURIComponent(sSQ_CAT2)
            , true);
		xmlhttp.send();
}
function selSquareCat(line_no){
    var sSQ_NAME = document.getElementById("sq_name"+line_no).innerHTML;
    var sSQ_ID = document.getElementById("sq_id"+line_no).innerHTML;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addMsg(this.responseText+ "<br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button>");
	  }
	};
		xmlhttp.open('GET', 'getCats.php?KEY=' + KEY 
            + '&LINE_NO=' + encodeURIComponent(line_no)
            + '&SQ_NAME=' + encodeURIComponent(sSQ_NAME)
            + '&SQ_ID=' + encodeURIComponent(sSQ_ID)
            , true);
		xmlhttp.send();    
}
function addSquareCat(line_no,parent_name){
    document.getElementById("sq_btn"+line_no).style.display="none";
    document.getElementById("sq_btn_ok"+line_no).style.display="inline-block";
    var sSQ_NAME = document.getElementById("sq_name"+line_no).innerHTML;
    var sSQ_ID = document.getElementById("sq_id"+line_no).innerHTML;
    if (parent_name == sSQ_NAME){
        addMsg("Une catégorie ne peut pas porter le même nom que sa catégorie parente.<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>");
        return;
    }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
        closeMSG();
	  }
	};
		xmlhttp.open('GET', 'addSquareCat.php?KEY=' + KEY 
            + '&SQ_PARENT=' + encodeURIComponent(parent_name)
            + '&SQ_NAME=' + encodeURIComponent(sSQ_NAME)
            + '&SQ_ID=' + encodeURIComponent(sSQ_ID)
            , true);
		xmlhttp.send();
}
//-----------------------
//         OCR
//-----------------------
function getOCR(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	  }
	};
		xmlhttp.open('GET', 'getOCR.php?KEY=' + KEY, true);
		xmlhttp.send();
}
//-----------------------
//        EXCEL
//-----------------------
function updateBDCLNT(sLST,sLSTCount){
	document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "1";
	if (sLST == ""){
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = "Aucun record pour l'importation..<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	return;
	}
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "Mise a jour réussie.<br>" + sLSTCount + " records ajoutés/modifiés.<br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'BDCLNT.php?KEY=' + KEY + '&LST=' + encodeURIComponent(sLST), true);
		xmlhttp.send();
}
// CLIENTS - BDCLNT
  function handleBDCLNT(evt) {
    var files = evt.target.files;
    var xl2json = new xBDCLNT();
    xl2json.parseExcel(files[0]);
  }
  var xBDCLNT = function() {
    this.parseExcel = function(file) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var data = e.target.result;
        var workbook = XLSX.read(data, {
          type: 'binary'
        });
        workbook.SheetNames.forEach(function(sheetName) {
          var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
          var json_object = JSON.stringify(XL_row_object);
		  var jobj = JSON.parse(json_object);
          //console.log(JSON.parse(json_object));
          //jQuery('#xlx_json').val(json_object);
			var sLST = "";
			var iLST = 0;
			for (let x in jobj) {
			   if (sLST != ""){
				   sLST += ",";
				}
				if(jobj[x].ID    ){sID    = jobj[x].ID    ;} else { sID    = "";}
				if(jobj[x].LANG  ){sLANG  = jobj[x].LANG  ;} else { sLANG  = "";}
				if(jobj[x].TYPE  ){sTYPE  = jobj[x].TYPE  ;} else { sTYPE  = "";}
				if(jobj[x].TITRE ){sTITRE = jobj[x].TITRE ;} else { sTITRE = "";}
				if(jobj[x].SEXE  ){sSEXE  = jobj[x].SEXE  ;} else { sSEXE  = "";}
				if(jobj[x].PRENOM){sPRENOM= dw3_crypt(jobj[x].PRENOM);} else { sPRENOM= "";}
				if(jobj[x].NOM   ){sNOM   = dw3_crypt(jobj[x].NOM)   ;} else { sNOM   = "";}
				if(jobj[x].TEL1  ){sTEL1  = dw3_crypt(jobj[x].TEL1)  ;} else { sTEL1  = "";}
				if(jobj[x].TEL2  ){sTEL2  = dw3_crypt(jobj[x].TEL2)  ;} else { sTEL2  = "";}
				if(jobj[x].ADR1  ){sADR1  = dw3_crypt(jobj[x].ADR1)  ;} else { sADR1  = "";}
				if(jobj[x].ADR2  ){sADR2  = dw3_crypt(jobj[x].ADR2)  ;} else { sADR2  = "";}
				if(jobj[x].VILLE ){sVILLE = jobj[x].VILLE ;} else { sVILLE = "";}
				if(jobj[x].PROV  ){sPROV  = jobj[x].PROV  ;} else { sPROV  = "";}
				if(jobj[x].PAYS  ){sPAYS  = jobj[x].PAYS  ;} else { sPAYS  = "";}
				if(jobj[x].CP    ){sCP    = jobj[x].CP    ;} else { sCP    = "";}
				if(jobj[x].EML1  ){sEML1  = dw3_crypt(jobj[x].EML1)  ;} else { sEML1  = "";}
				if(jobj[x].EML2  ){sEML2  = dw3_crypt(jobj[x].EML2)  ;} else { sEML2  = "";}
				if(jobj[x].NOTE  ){sNOTE  = jobj[x].NOTE  ;} else { sNOTE  = "";}			
				
				sLST += "('" 	+ sID + "','1','" 
								+ sLANG + "','" 
								+ sTYPE + "','" 
								+ sTITRE + "','" 
								+ sSEXE + "','" 
								+ sPRENOM + "','" 
								+ sNOM + "','" 
								+ sTEL1 + "','" 
								+ sTEL2 + "','" 
								+ sADR1 + "','" 
								+ sADR2 + "','" 
								+ sVILLE + "','" 
								+ sPROV + "','" 
								+ sPAYS + "','" 
								+ sCP + "','" 
								+ sEML1 + "','" 
								+ sEML2 + "','" 
								+ sNOTE + "')";
				iLST = iLST + 1;
			}
			updateBDCLNT(sLST,iLST.toString());
			console.log(iLST.toString() + "-" + sLST);
        })
      };

      reader.onerror = function(ex) {
        console.log(ex);
      };

      reader.readAsBinaryString(file);
    };
  };


// PRODUITS - BDPROD
  function handleBDPROD(evt) {
    var files = evt.target.files;
    var xl2json = new xBDPROD();
    xl2json.parseExcel(files[0]);
  }
  var xBDPROD_PROG = 0;
  var xBDPROD = function() {
    xBDPROD_PROG = 0;
    document.getElementById("divFADE2").style.display = "inline-block";
	document.getElementById("divFADE2").style.opacity = "0.6";
    this.parseExcel = function(file) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var data = e.target.result;
        var workbook = XLSX.read(data, {
          type: 'binary'
        });
        workbook.SheetNames.forEach(function(sheetName) {
          var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
          var json_object = JSON.stringify(XL_row_object);
		  var jobj = JSON.parse(json_object);
		  var lst_length = jobj.length;
          //console.log(JSON.parse(json_object));
          //jQuery('#xlx_json').val(json_object);
			var sLST = "";
			var iLST = 0;
			for (let x in jobj) {
/* 			   if (sLST != ""){
				   sLST += ",";
				} */
				if(typeof jobj[x].ID !== 'undefined')			{if(jobj[x].ID!="") {sID = jobj[x].ID;} else {sID = "NULL";}} else {sID = "NULL";}
				if(typeof jobj[x].STAT !== 'undefined')			{sSTAT  = jobj[x].STAT  ;} else 				{sSTAT  = "4";}
				if(typeof jobj[x].CATEGORY_ID !== 'undefined')	{sCATEGORY_ID  = jobj[x].CATEGORY_ID  ;} else 	{sCATEGORY_ID  = "0";}
				if(typeof jobj[x].CATEGORY2_ID !== 'undefined')	{sCATEGORY2_ID = jobj[x].CATEGORY2_ID ;} else 	{sCATEGORY2_ID = "0";}
				if(typeof jobj[x].CATEGORY3_ID !== 'undefined')	{sCATEGORY3_ID = jobj[x].CATEGORY3_ID ;} else 	{sCATEGORY3_ID = "0";}
				if(typeof jobj[x].SUPPLIER_ID !== 'undefined')	{sSUPPLIER_ID  = jobj[x].SUPPLIER_ID  ;} else 	{sSUPPLIER_ID  = "0";}
				if(typeof jobj[x].UPC !== 'undefined')			{sUPC = jobj[x].UPC ;} else 					{sUPC = "";}
				if(typeof jobj[x].SKU !== 'undefined')			{sSKU  = jobj[x].SKU  ;} else					{sSKU  = "";}
				if(typeof jobj[x].NAME_FR !== 'undefined')		{sNAME_FR  = jobj[x].NAME_FR  ;} else 			{sNAME_FR  = "Nom à définir";}
				if(typeof jobj[x].NAME_EN !== 'undefined')		{sNAME_EN    = jobj[x].NAME_EN    ;} else 		{sNAME_EN    = "Undefined name";}
				if(typeof jobj[x].DESCRIPTION_FR !== 'undefined'){sDESCRIPTION_FR  = jobj[x].DESCRIPTION_FR  ;} else {sDESCRIPTION_FR  = "";}
				if(typeof jobj[x].DESCRIPTION_EN  !== 'undefined'){sDESCRIPTION_EN  = jobj[x].DESCRIPTION_EN  ;} else {sDESCRIPTION_EN  = "";}
				if(typeof jobj[x].PRICE1 !== 'undefined')		{sPRICE1  = jobj[x].PRICE1  ;} else 			{sPRICE1  = "0";}
				if(typeof jobj[x].PRICE2 !== 'undefined')		{sPRICE2  = jobj[x].PRICE2  ;} else 			{sPRICE2  = "0";}
				if(typeof jobj[x].TAX_PROV !== 'undefined')		{sTAX_PROV  = jobj[x].TAX_PROV  ;} else 		{sTAX_PROV  = "0";}
				if(typeof jobj[x].TAX_FED !== 'undefined')		{sTAX_FED  = jobj[x].TAX_FED  ;} else 			{sTAX_FED  = "0";}
				if(typeof jobj[x].KG !== 'undefined')			{sKG  = jobj[x].KG  ;} else 					{sKG  = "0";}
				if(typeof jobj[x].HEIGHT !== 'undefined')		{sHEIGHT  = jobj[x].HEIGHT  ;} else 			{sHEIGHT  = "0";}
				if(typeof jobj[x].WIDTH  !== 'undefined')		{sWIDTH  = jobj[x].WIDTH  ;} else 				{sWIDTH  = "0";}
				if(typeof jobj[x].DEPTH  !== 'undefined')		{sDEPTH  = jobj[x].DEPTH  ;} else 				{sDEPTH  = "0";}
				if(typeof jobj[x].BRAND  !== 'undefined')		{sBRAND  = jobj[x].BRAND  ;} else 				{sBRAND  = "";}
				if(typeof jobj[x].MODEL !== 'undefined')		{sMODEL  = jobj[x].MODEL  ;} else 				{sMODEL  = "";}
				if(typeof jobj[x].MODEL_YEAR  !== 'undefined')	{sMODEL_YEAR  = jobj[x].MODEL_YEAR  ;} else 	{sMODEL_YEAR  = "";}
				if(typeof jobj[x].ALLOW_PICKUP  !== 'undefined'){sALLOW_PICKUP  = jobj[x].ALLOW_PICKUP  ;} else 	{sALLOW_PICKUP  = "0";}
				if(typeof jobj[x].WEB_AVAILABLE  !== 'undefined'){sWEB_AVAILABLE  = jobj[x].MODEL_YEAR  ;} else 	{sWEB_AVAILABLE  = "";}
				if(typeof jobj[x].BTN_ACTION1  !== 'undefined')	{sBTN_ACTION1  = jobj[x].BTN_ACTION1  ;} else 	{sBTN_ACTION1  = "";}
				if(typeof jobj[x].WEB_BTN_ICON  !== 'undefined'){sWEB_BTN_ICON = jobj[x].WEB_BTN_ICON  ;} else 	{sWEB_BTN_ICON  = "";}
				if(typeof jobj[x].WEB_BTN_FR  !== 'undefined')	{sWEB_BTN_FR  = jobj[x].WEB_BTN_FR  ;} else 	{sWEB_BTN_FR  = "";}
				if(typeof jobj[x].WEB_BTN_FR  !== 'undefined')	{sWEB_BTN_EN  = jobj[x].WEB_BTN_EN  ;} else 	{sWEB_BTN_EN  = "";}
				if(typeof jobj[x].URL_ACTION1  !== 'undefined')	{sURL_ACTION1  = jobj[x].URL_ACTION1  ;} else 	{sURL_ACTION1  = "";}
				if(typeof jobj[x].BTN_ACTION2  !== 'undefined')	{sBTN_ACTION2  = jobj[x].BTN_ACTION2  ;} else 	{sBTN_ACTION2  = "";}
				if(typeof jobj[x].WEB_BTN2_ICON  !== 'undefined'){sWEB_BTN2_ICON = jobj[x].WEB_BTN2_ICON  ;} else 	{sWEB_BTN2_ICON  = "";}
				if(typeof jobj[x].WEB_BTN2_FR  !== 'undefined')	{sWEB_BTN2_FR  = jobj[x].WEB_BTN2_FR  ;} else 	{sWEB_BTN2_FR  = "";}
				if(typeof jobj[x].WEB_BTN2_FR  !== 'undefined')	{sWEB_BTN2_EN  = jobj[x].WEB_BTN2_EN  ;} else 	{sWEB_BTN2_EN  = "";}
				if(typeof jobj[x].URL_ACTION2  !== 'undefined')	{sURL_ACTION2  = jobj[x].URL_ACTION2  ;} else 	{sURL_ACTION2  = "";}
				if(typeof jobj[x].PRICE_TEXT_FR !== 'undefined'){sPRICE_TEXT_FR = jobj[x].PRICE_TEXT_FR ;} else 	{sPRICE_TEXT_FR    = "";}
				if(typeof jobj[x].PRICE_TEXT_EN !== 'undefined' ){sPRICE_TEXT_EN = jobj[x].PRICE_TEXT_EN    ;} else 	{sPRICE_TEXT_EN    = "";}
				if(typeof jobj[x].PRICE_SUFFIX_FR !== 'undefined'){sPRICE_SUFFIX_FR = jobj[x].PRICE_SUFFIX_FR  ;} else 	{sPRICE_SUFFIX_FR  = "";}
				if(typeof jobj[x].PRICE_SUFFIX_EN !== 'undefined'){sPRICE_SUFFIX_EN = jobj[x].PRICE_SUFFIX_EN  ;} else 	{sPRICE_SUFFIX_EN  = "";}
				if(typeof jobj[x].SHIP_TYPE !== 'undefined' )	{sSHIP_TYPE        = jobj[x].SHIP_TYPE        ;} else 	{sSHIP_TYPE        = "";}
				if(typeof jobj[x].DSP_INV !== 'undefined' )	    {sDSP_INV          = jobj[x].DSP_INV          ;} else 	{sDSP_INV          = "";}
				if(typeof jobj[x].DSP_UPC !== 'undefined' )	    {sDSP_UPC          = jobj[x].DSP_UPC          ;} else 	{sDSP_UPC          = "";}
				if(typeof jobj[x].DSP_MESURE !== 'undefined' )	{sDSP_MESURE       = jobj[x].DSP_MESURE       ;} else 	{sDSP_MESURE       = "";}
				if(typeof jobj[x].DSP_MODEL!== 'undefined' )	{sDSP_MODEL        = jobj[x].DSP_MODEL        ;} else 	{sDSP_MODEL        = "";}

				sLST = "('" 	+ sID + "','" 
								+ sSTAT + "','" 
								+ sCATEGORY_ID + "','" 
								+ sCATEGORY2_ID  + "','" 
								+ sCATEGORY3_ID  + "','" 
								+ sSUPPLIER_ID + "','" 
								+ sUPC + "','" 
								+ sSKU + "','" 
								+ sNAME_FR + "','" 
								+ sNAME_EN + "','" 
								+ sDESCRIPTION_FR + "','" 
								+ sDESCRIPTION_EN + "','" 
								+ sPRICE1 + "','" 
								+ sPRICE2 + "','" 
								+ sTAX_PROV + "','" 
								+ sTAX_FED + "','" 
								+ sKG + "','" 
								+ sHEIGHT + "','" 
								+ sWIDTH + "','" 
								+ sDEPTH + "','" 
								+ sBRAND + "','" 
								+ sMODEL + "','"  
								+ sMODEL_YEAR + "','"
								+ sALLOW_PICKUP + "','"
								+ sWEB_AVAILABLE + "','"
								+ sBTN_ACTION1 + "','"
								+ sWEB_BTN_ICON + "','"
								+ sWEB_BTN_FR + "','"
								+ sWEB_BTN_EN + "','"
								+ sURL_ACTION1 + "','"
								+ sBTN_ACTION2 + "','"
								+ sWEB_BTN2_ICON + "','"
								+ sWEB_BTN2_FR + "','"
								+ sWEB_BTN2_EN + "','"
								+ sURL_ACTION2 + "','"
								+ sPRICE_TEXT_FR + "','"
								+ sPRICE_TEXT_EN + "','"
								+ sPRICE_SUFFIX_FR + "','"
								+ sPRICE_SUFFIX_EN + "','"
								+ sSHIP_TYPE + "','"
								+ sDSP_INV + "','"
								+ sDSP_UPC + "','"
								+ sDSP_MESURE + "','"
								+ sDSP_MODEL     
                                + "','"+date_time+"')";
                                iLST = iLST + 1;
                updateBDPROD(sID,sLST,iLST,lst_length);
			}
			//updateBDPROD(sLST,iLST.toString());
			//console.log(iLST.toString() + "-" + sLST);
			//console.log(json_object);
        })
      };
    
      reader.onerror = function(ex) {
        console.log(ex);
      };

      reader.readAsBinaryString(file);
    };
  };
function updateBDPROD(sID,sLST,sLSTCount,sLSTLength){
    document.getElementById("divMSG").style.display = "inline-block";
	if (sLSTLength == 0){
			document.getElementById("divMSG").innerHTML = "Aucun record pour l'importation..<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
	return;
	}
    //iProgress = Math.round((sLSTCount * 100)/sLSTLength);

/* 	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "Mise a jour réussie.<br>" + sLSTCount + " records ajoutés/modifiés.<br><button onclick='closeMSG();location.reload();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } else {
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();location.reload();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'BDPROD.php?KEY=' + KEY + '&LST=' + encodeURIComponent(sLST), true);
		xmlhttp.send(); */
	const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "BDPROD.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onload = function() {
        if (this.readyState == 4 && this.status == 200) {
            xBDPROD_PROG++;
            iProgress = Math.round((xBDPROD_PROG * 100)/sLSTLength);
        }
		if (this.responseText.substring(0,3) != "Err" && xBDPROD_PROG >= sLSTLength){
			document.getElementById("divMSG").innerHTML = "Mise a jour réussie.<br>" + sLSTCount + " records ajoutés/modifiés.<br><button onclick='closeMSG();location.reload();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } else if(this.responseText.substring(0,3) != "Err" && xBDPROD_PROG < sLSTLength){
	        document.getElementById("divMSG").innerHTML = "Mise a jour:<br><progress style='background: linear-gradient(to right, #ffbf00 0%, #ff007f 100%);' value='"+iProgress.toString()+"' max='100' id='progressBar'></progress>"+iProgress.toString()+"%<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } else if(this.responseText.substring(0,3) == "Err"){
			document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();location.reload();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
    }
  xhttp.send("KEY="+KEY+"&LST=" + encodeURIComponent(sLST));
}

</script>
</body>
</html>

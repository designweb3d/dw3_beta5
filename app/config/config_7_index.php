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
$APNAME = "Index & Pages Web";
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';

//STRUCTURE DU DASHBOARD CLIENT
$sql = "SELECT * FROM config WHERE kind = 'INDEX' AND code = 'DASHBOARD_DSP';";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $DASH_PROFIL    = trim(substr($row["text1"],0,1));				
        $DASH_MARKET    = trim(substr($row["text1"],1,1));				
        $DASH_CART      = trim(substr($row["text1"],2,1));				
        $DASH_INVOICE   = trim(substr($row["text1"],3,1));				
        $DASH_ORDER     = trim(substr($row["text1"],4,1));				
        $DASH_RDV       = trim(substr($row["text1"],5,1));				
        $DASH_HIST      = trim(substr($row["text1"],6,1));				
        $DASH_DOC       = trim(substr($row["text1"],7,1));				
        $DASH_PROMO     = trim(substr($row["text1"],8,1));				
        $DASH_COOKIES   = trim(substr($row["text1"],9,1));				
        $DASH_PHONE     = trim(substr($row["text1"],10,1));				
        $DASH_EML       = trim(substr($row["text1"],11,1));				
        $DASH_PRIVACY   = trim(substr($row["text1"],12,1));				
        $DASH_LICENSE   = trim(substr($row["text1"],13,1));				
        $DASH_COMPLAINT = trim(substr($row["text1"],14,1));				
        $DASH_END       = trim(substr($row["text1"],15,1));				
        $DASH_RETURN    = trim(substr($row["text1"],16,1));				
        $DASH_SUBSCRIBE = trim(substr($row["text1"],17,1));				
    }
} else {
	$DASH_PROFIL = "1";				
	$DASH_MARKET = "0";				
	$DASH_CART = "0";				
	$DASH_INVOICE = "1";				
	$DASH_ORDER = "1";				
	$DASH_RDV = "1";				
	$DASH_HIST = "1";				
	$DASH_DOC = "0";				
	$DASH_PROMO = "0";				
	$DASH_COOKIES = "1";				
	$DASH_PHONE = "1";				
	$DASH_EML = "1";				
	$DASH_PRIVACY = "1";				
	$DASH_LICENSE = "1";				
	$DASH_COMPLAINT = "0";				
	$DASH_END = "0";
	$DASH_RETURN = "0";
    $DASH_SUBSCRIBE = "0";
}

?>
<div id="divHEAD">
	<table style="width:100%;margin:0px;white-space:nowrap;margin-top:5px;">
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
                    <option selected value="/app/config/config_7_index.php"> Index & Pages Web </option>
                    <option value="/app/config/config_8_api.php"> API's, IA's et Réseaux Sociaux</option>
                    <option value="/app/config/config_9_update.php"> Mises à jour & Sécurité </option>
                    <option value="/app/config/config_10_license.php"> Licenses, politiques, conditions et sitemap </option>
                </select>
            </td>
            <td style="width:50px;margin:0px;padding:0px;text-align: right; text-justify: inter-word;">
				<button style="margin:0px 2px 0px 2px;padding:6px;" class='green' onclick="openFILES_MANAGER();"><span class="material-icons">image</span></button>
			</td>
		</tr>
	</table>
</div>

<div id="divMSG"></div>
<div id="divMSG2"><input style='display:none;' id='txtUPLOAD_FN'>
    <div style='height:240px;'>
        <img id='imgUPLOAD' src='' style='height:240px;cursor:pointer;width:auto;' onclick='viewUPLOAD()'>
        <video id='videoUPLOAD' width="320" height="240" controls>
            <source id='mp4UPLOAD' src="" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <audio id='audioUPLOAD' controls style='margin-top:100px;'>
            <source id='mp3UPLOAD' src="" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
    <br><input type='text' id='txtUPLOAD_RENAME'><br>
    <button class='grey' onclick='closeMSG2()'><span class="material-icons">close</span> Fermer</button>
    <button class='gold' onclick='renameUPLOAD()'><span class="material-icons">image</span> Renommer</button>
    <button class='red' onclick='delUPLOAD()'><span class="material-icons">delete_forever</span></button>
    <button class='blue' onclick='rotateUPLOAD()'><span class="material-icons">rotate_90_degrees_ccw</span></button>
</div>
<div id="divOPT"></div>

<div id="gal2_modal" class="gal2_modal" onclick='dw3_gal2_close()'>
  <div id="gal2_caption"></div>
  <span class="gal2_close" onclick='dw3_gal2_close()'>&times;</span>
  <img class="gal2_modal-content" id="gal2_model_img">
</div>

<div class='divMAIN' style="padding:50px 0px;">
    <h4>Total des visites de l'index: <u><?php echo $INDEX_VISITED ; ?></u></h4>
    <div class="divPAGE" style='max-width:100%;' id='divSECTIONS'>
    </div>
    <div class="divPAGE" style='max-width:100%;padding-top:10px;'>
    <button onclick='openLANDING()'><span class="material-icons">flight_land</span> Landing</button>
    <button onclick='openFAQ()'><span class="material-icons">quiz</span> FAQ</button>
    <button onclick='openAFFILIATE()'><span class="material-icons">local_atm</span> Affiliés</button>
    <button onclick='openATTRIB()'><span class="material-icons">attribution</span> Attributions</button>
    <button onclick='openCOUPONS()'><span class="material-icons">card_giftcard</span> Coupons</button>
    <button onclick='openHISTORIC()'><span class="material-icons">history</span> Historique</button>
    <button onclick='openREALISATION()'><span class="material-icons">verified</span> Réalisations</button>
    </div>
    <div class='divPAGE'>
        <div class="divBOX">Entête de page de l'index:
            <select name='INDEX_HEADER' id='INDEX_HEADER'>
                <option <?php if ($INDEX_HEADER == "/pub/section/header0.php") {echo "selected";} ?> value="/pub/section/header0.php">00 Minimal</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header9.php") {echo "selected";} ?> value="/pub/section/header9.php">09 Minimal (Flex)</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header6.php") {echo "selected";} ?> value="/pub/section/header6.php">06 Transparent épuré</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header13.php") {echo "selected";} ?> value="/pub/section/header13.php">13 Transparent minimal (Flex)</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header22.php") {echo "selected";} ?> value="/pub/section/header22.php">22 Transparent (Flex)</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header23.php") {echo "selected";} ?> value="/pub/section/header23.php">23 Transparent</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header1.php") {echo "selected";} ?> value="/pub/section/header1.php">01 Avec entête +contact</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header17.php") {echo "selected";} ?> value="/pub/section/header17.php">17 Avec entête défilante (Flex)</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header2.php") {echo "selected";} ?> value="/pub/section/header2.php">02 Haut sans entête</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header7.php") {echo "selected";} ?> value="/pub/section/header7.php">07 Haut sans entête 2</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header10.php") {echo "selected";} ?> value="/pub/section/header10.php">10 Haut semi-transparent (Flex)</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header11.php") {echo "selected";} ?> value="/pub/section/header11.php">11 Haut semi-transparent 2 (Flex)</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header14.php") {echo "selected";} ?> value="/pub/section/header14.php">14 Minimal Haut avec redimension</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header19.php") {echo "selected";} ?> value="/pub/section/header19.php">19 Minimal Haut avec redimension (Flex)</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header3.php") {echo "selected";} ?> value="/pub/section/header3.php">03 Haut avec redimension +contacts</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header20.php") {echo "selected";} ?> value="/pub/section/header20.php">20 Haut avec redimension +contact (Flex)</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header16.php") {echo "selected";} ?> value="/pub/section/header16.php">16 Avec redimension texte bas +contacts</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header18.php") {echo "selected";} ?> value="/pub/section/header18.php">18 Avec redimension texte haut</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header4.php") {echo "selected";} ?> value="/pub/section/header4.php">04 Sans redimension +contacts</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header5.php") {echo "selected";} ?> value="/pub/section/header5.php">05 Haut avec entête</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header21.php") {echo "selected";} ?> value="/pub/section/header21.php">21 Haut avec entête transparent</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header8.php") {echo "selected";} ?> value="/pub/section/header8.php">08 Haut avec logo surdimensionné</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header12.php") {echo "selected";} ?> value="/pub/section/header12.php">12 Entete de choix de location</option>
                <option <?php if ($INDEX_HEADER == "/pub/section/header15.php") {echo "selected";} ?> value="/pub/section/header15.php">15 Dualité logo sans menu</option>
            </select>
        </div>
        <div class="divBOX">Bas de page:
            <select name='INDEX_FOOTER' id='INDEX_FOOTER'>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer0.php") {echo "selected";} ?> value="/pub/section/footer0.php">Minimal</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer12.php") {echo "selected";} ?> value="/pub/section/footer12.php">Minimal 2</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer14.php") {echo "selected";} ?> value="/pub/section/footer14.php">Minimal +Secured by Sectigo</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer15.php") {echo "selected";} ?> value="/pub/section/footer15.php">Minimal +Trustpilot</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer4.php") {echo "selected";} ?> value="/pub/section/footer4.php">Minimal fixe</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer1.php") {echo "selected";} ?> value="/pub/section/footer1.php">+Nav</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer19.php") {echo "selected";} ?> value="/pub/section/footer19.php">+Nav+Adr</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer2.php") {echo "selected";} ?> value="/pub/section/footer2.php">+Nav+Heures</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer3.php") {echo "selected";} ?> value="/pub/section/footer3.php">+Nav+Heures+Adr</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer18.php") {echo "selected";} ?> value="/pub/section/footer18.php">+Nav+Contact+Adr</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer5.php") {echo "selected";} ?> value="/pub/section/footer5.php">+Nav+Heures+Adr+Carte</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer6.php") {echo "selected";} ?> value="/pub/section/footer6.php">+Heures</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer7.php") {echo "selected";} ?> value="/pub/section/footer7.php">+Heures+Adr</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer8.php") {echo "selected";} ?> value="/pub/section/footer8.php">+Heures+Adr+Carte</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer9.php") {echo "selected";} ?> value="/pub/section/footer9.php">+Heures+Carte</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer17.php") {echo "selected";} ?> value="/pub/section/footer17.php">+Heures+#RBQ</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer16.php") {echo "selected";} ?> value="/pub/section/footer16.php">+Carte</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer11.php") {echo "selected";} ?> value="/pub/section/footer11.php">Épuré</option>
                <option <?php if ($INDEX_FOOTER == "/pub/section/footer10.php") {echo "selected";} ?> value="/pub/section/footer10.php">Fixe épuré</option>
            </select>
        </div>
        <div class="divBOX">Titre Index FR:
            <?php if ($CIE_DEEPL_KEY != ""){ ?> <button style='float:right;padding:4px 8px;' onclick="dw3_translate('INDEX_TITLE_FR','fr','en','INDEX_TITLE_EN');"><span class="material-icons" style='font-size:12px;'>translate</span> fr->en</button><?php } ?>
            <input type='text' id='INDEX_TITLE_FR' value="<?php echo $INDEX_TITLE_FR ; ?>">
        </div>
        <div class="divBOX">Titre Index EN:
            <?php if ($CIE_DEEPL_KEY != ""){ ?> <button style='float:right;padding:4px 8px;' onclick="dw3_translate('INDEX_TITLE_EN','en','fr','INDEX_TITLE_FR');"><span class="material-icons" style='font-size:12px;'>translate</span> en->fr</button><?php } ?>
            <input type='text' id='INDEX_TITLE_EN' value="<?php echo $INDEX_TITLE_EN ; ?>">
        </div>
        <div class="divBOX">META Description:
            <input type='text' id='INDEX_META_DESC' value="<?php echo $INDEX_META_DESC ; ?>">
        </div>
        <div class="divBOX">META Keywords:
            <input type='text' id='INDEX_META_KEYW' value="<?php echo $INDEX_META_KEYW ; ?>">
        </div>
        <hr>
        <div class="divBOX">Langue par défault:
            <select name='INDEX_LANG' id='INDEX_LANG'>
                <option <?php if ($INDEX_LANG == "FR") {echo "selected";} ?> value="FR">Français</option>
                <option <?php if ($INDEX_LANG == "EN") {echo "selected";} ?> value="EN">Anglais</option>
            </select>
        </div>
        <div class='divBOX'><label for='INDEX_SEARCH'>Afficher le bouton recherche au menu:</label>
            <input id='INDEX_SEARCH' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($INDEX_SEARCH == "true"){echo " checked ";} ?>>
        </div>
        <div class='divBOX'><label for='INDEX_DSP_LANG'>Afficher le choix de langue au menu:</label>
            <input id='INDEX_DSP_LANG' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($INDEX_DSP_LANG == "true"){echo " checked ";} ?>>
        </div>
        <div class='divBOX'><label for='INDEX_CART'>Afficher le panier au menu:</label>
            <input id='INDEX_CART' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($INDEX_CART == "true"){echo " checked ";} ?>>
        </div>
        <div class='divBOX'><label for='INDEX_WISH'>Afficher les favoris au menu:</label>
            <input id='INDEX_WISH' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($INDEX_WISH == "true"){echo " checked ";} ?>>
        </div>
        <div class='divBOX'><label for='INDEX_NEWS'>Afficher la fenêtre pour l'infolettre:</label>
            <input id='INDEX_NEWS' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($INDEX_NEWS == "true"){echo " checked ";} ?>>
        </div>
        <div class='divBOX'><label for='INDEX_DSP_SIGNIN'>Afficher le boutton signin dans la page de connexion:</label>
            <input id='INDEX_DSP_SIGNIN' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($INDEX_DSP_SIGNIN == "true"){echo " checked ";} ?>>
        </div>
        <div class='divBOX'><label for='INDEX_DSP_SIGNIN'>Afficher le fournisseur dans la fiche des produits:</label>
            <input id='INDEX_DSP_SUPPLIER' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($INDEX_DSP_SUPPLIER == "true"){echo " checked ";} ?>>
        </div>
        <div class='divBOX'><label for='INDEX_BLOCK_DEBUG'>Bloquer le dédugger et le menu contextuel:</label>
            <input id='INDEX_BLOCK_DEBUG' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($INDEX_BLOCK_DEBUG == "true"){echo " checked ";} ?>>
        </div>
        <div class="divBOX">Style du bouton login, signin et accepter les cookies:
            <select id='LOGIN_BTN_CLASS'>
                <option <?php if ($LOGIN_BTN_CLASS == "") {echo "selected";} ?> value="">Même que les autres boutons</option>
                <option <?php if ($LOGIN_BTN_CLASS == "red") {echo "selected";} ?> value="red">Rouge</option>
                <option <?php if ($LOGIN_BTN_CLASS == "green") {echo "selected";} ?> value="green">Vert</option>
                <option <?php if ($LOGIN_BTN_CLASS == "blue") {echo "selected";} ?> value="blue">Bleu</option>
                <option <?php if ($LOGIN_BTN_CLASS == "gold") {echo "selected";} ?> value="gold">Or</option>
                <option <?php if ($LOGIN_BTN_CLASS == "white") {echo "selected";} ?> value="white">Blanc</option>
                <option <?php if ($LOGIN_BTN_CLASS == "grey") {echo "selected";} ?> value="grey">Gris foncé</option>
                <option <?php if ($LOGIN_BTN_CLASS == "clear1") {echo "selected";} ?> value="clear1">Semi transparent 1</option>
                <option <?php if ($LOGIN_BTN_CLASS == "clear2") {echo "selected";} ?> value="clear2">Semi transparent 2</option>
            </select>
        </div>
        <div class="divBOX">Arrière scène de l'index (3D WebGL):
            <select name='INDEX_SCENE' id='INDEX_SCENE'>
            <?php 
                echo "<option value=''"; if ($INDEX_SCENE == '') {echo "selected";} echo ">Aucune arrière scene</option>";
                $path = $_SERVER['DOCUMENT_ROOT'] . "/pub/scene";
                $dirHandle = opendir($path);
                while($item = readdir($dirHandle)) {
                    $newPath = $path."/".$item;
                    if(is_dir($newPath) && $item != '.' && $item != '..') {
                        echo "<option value='".$item."'"; if ($INDEX_SCENE == $item) {echo "selected";} echo ">".$item."</option>";
                    }
                }
            ?>
            </select>
        </div>
        <div class="divBOX">Protecteur des données:
            <select id='CIE_PROTECTOR'>
            <?php 
            echo "<option value='-1'>Ne pas afficher sur la page contact</option>";
            $sql = "SELECT * FROM user WHERE stat = '0';";
            $result = $dw3_conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='".$row["id"]."'"; if ($CIE_PROTECTOR == $row["id"]) {echo "selected";} echo ">".$row["first_name"]. " " . $row["last_name"] . "</option>";
                }
            }     
            ?>
            </select>
        </div>
        <div class="divBOX" style='display:none;'>Marge du haut du bas de page (en pixels):
            <input type='text' id='FOOT_MARGIN' value="<?php echo $FOOT_MARGIN ; ?>">
        </div><hr>
        <div class="dw3_page">
            HTML Sur-Entête FR:
            <?php if ($CIE_DEEPL_KEY != ""){ ?> <button style='float:right;padding:4px 8px;' onclick="dw3_translate(encodeURIComponent('INDEX_TOP_FR'),'fr','en','INDEX_TOP_EN');"><span class="material-icons" style='font-size:12px;'>translate</span> fr->en</button><?php } ?>
            <textarea style='width:100%;height:150px;' id='INDEX_TOP_FR'><?php echo $INDEX_TOP_FR ?></textarea>
            HTML Sur-Entête EN:
            <?php if ($CIE_DEEPL_KEY != ""){ ?> <button style='float:right;padding:4px 8px;' onclick="dw3_translate(encodeURIComponent('INDEX_TOP_EN'),'en','fr','INDEX_TOP_FR');"><span class="material-icons" style='font-size:12px;'>translate</span> en->fr</button><?php } ?>
            <textarea style='width:100%;height:150px;' id='INDEX_TOP_EN'><?php echo $INDEX_TOP_EN ?></textarea>
        </div><hr>
        <div class="dw3_page">
            HTML Popup sur l'index FR:
            <?php if ($CIE_DEEPL_KEY != ""){ ?> <button style='float:right;padding:4px 8px;' onclick="dw3_translate(encodeURIComponent('INDEX_POPUP_FR'),'fr','en','INDEX_POPUP_EN');"><span class="material-icons" style='font-size:12px;'>translate</span> fr->en</button><?php } ?>
            <textarea style='width:100%;height:150px;' id='INDEX_POPUP_FR'><?php echo $INDEX_POPUP_FR ?></textarea>
            HTML Popup sur l'index EN:
            <?php if ($CIE_DEEPL_KEY != ""){ ?> <button style='float:right;padding:4px 8px;' onclick="dw3_translate(encodeURIComponent('INDEX_POPUP_EN'),'en','fr','INDEX_POPUP_FR');"><span class="material-icons" style='font-size:12px;'>translate</span> en->fr</button><?php } ?>
            <textarea style='width:100%;height:150px;' id='INDEX_POPUP_EN'><?php echo $INDEX_POPUP_EN ?></textarea>
        </div><hr>
        <div class="dw3_page">Message pour les cookies FR:
            <?php if ($CIE_DEEPL_KEY != ""){ ?> <button style='float:right;padding:4px 8px;' onclick="dw3_translate(encodeURIComponent('INDEX_COOKIE'),'fr','en','INDEX_COOKIE_EN');"><span class="material-icons" style='font-size:12px;'>translate</span> fr->en</button><?php } ?>
            <textarea style='width:100%;height:150px;' name='INDEX_COOKIE' id='INDEX_COOKIE'><?php
                    $msg_cookies_en = "";
                    $sql = "SELECT * FROM config WHERE kind = 'CIE' AND code='COOKIE_MSG'";
                    $result = $dw3_conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { 
                                echo trim($row["text1"]);
                                $msg_cookies_en = trim($row["text2"]);
                        }
                    }
                ?></textarea>
                Message pour les cookies EN:
                <?php if ($CIE_DEEPL_KEY != ""){ ?> <button style='float:right;padding:4px 8px;' onclick="dw3_translate(encodeURIComponent('INDEX_COOKIE_EN'),'en','fr','INDEX_COOKIE');"><span class="material-icons" style='font-size:12px;'>translate</span> en->fr</button><?php } ?>
            <textarea style='width:100%;height:150px;' name='INDEX_COOKIE_EN' id='INDEX_COOKIE_EN'><?php echo $msg_cookies_en; ?></textarea>
			<hr>
			<h2>Quoi afficher dans l'espace-client</h2>
		<div class='divBOX'><label for='DASH_PROFIL'>Profil</label><input id='DASH_PROFIL' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_PROFIL == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_MARKET'>Marché publique</label><input id='DASH_MARKET' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_MARKET == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_CART'>Panier</label><input id='DASH_CART' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_CART == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_SUBSCRIBE'>Abonnements</label><input id='DASH_SUBSCRIBE' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_SUBSCRIBE == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_INVOICE'>Factures</label><input id='DASH_INVOICE' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_INVOICE == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_ORDER'>Commandes</label><input id='DASH_ORDER' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_ORDER == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_RDV'>Rendez-vous</label><input id='DASH_RDV' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_RDV == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_HIST'>Historique de facture</label><input id='DASH_HIST' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_HIST == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_DOC'>Documents</label><input id='DASH_DOC' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_DOC == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_PROMO'>Produits en promotion</label><input id='DASH_PROMO' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_PROMO == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_COOKIES'>Cookies & Notifications</label><input id='DASH_COOKIES' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_COOKIES == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_PHONE'>Bouton Appeler</label><input id='DASH_PHONE' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_PHONE == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_EML'>Bouton Email</label><input id='DASH_EML' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_EML == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_PRIVACY'>Politiques de confidentialité</label><input id='DASH_PRIVACY' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_PRIVACY == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_LICENSE'>Licences</label><input id='DASH_LICENSE' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_LICENSE == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_RETURN'>Politique de retour</label><input id='DASH_RETURN' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_RETURN == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_COMPLAINT'>Plaintes</label><input id='DASH_COMPLAINT' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_COMPLAINT == "1"){echo " checked ";} ?>></div>
		<div class='divBOX'><label for='DASH_END'>Fermer le compte</label><input id='DASH_END' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($DASH_END == "1"){echo " checked ";} ?>></div>
        </div>
        <br>
        <br>
    </div>
    <div class='dw3_main_foot'><button onclick="updINDEX();" class="green"><span class="material-icons">save</span>Sauvegarder</button></div>
</div>
    
<div id="divFILES_MANAGER" class="divEDITOR">
    <div id="divFILES_MANAGER_HEADER" class='dw3_form_head'>
        <h3 style='vertical-align:middle;height:40px;'><div id='divFILES_MANAGER_TITLE' style='display: grid;align-items: center;height:40px;'><?php if ($USER_LANG == "FR"){echo "Gestionnaire de fichiers";}else{echo "Files Manager";} ?></div></h3>       
        <button class='dw3_form_close' onclick='closeFILES_MANAGER();closeMSG();'><span class='material-icons'>close</span></button>
    </div>
    <div id="divFILES_MANAGER_MAIN" class='dw3_form_data' style='overflow-x:auto;bottom:0px;'></div>
</div>
<div id="divSECTION" class="divEDITOR">
    <div id="divSECTION_HEADER" class='dw3_form_head'>
        <h3 style='vertical-align:middle;height:40px;'><div id='divSECTION_TITLE' style='display: grid;align-items: center;height:40px;'><?php if ($USER_LANG == "FR"){echo "Page / Section Modif.";}else{echo "Page / Section Modif.";} ?></div></h3>       
        <button class='dw3_form_close' onclick='closeSECTION();'><span class='material-icons'>close</span></button>
    </div>
    <div id="divSECTION_MAIN"></div>
</div>
<div id="divSUB_SECTION" class="divEDITOR">
    <div id="divSUB_SECTION_HEADER" class='dw3_form_head'>
        <h3 style='vertical-align:middle;height:40px;'><div id='divSUB_SECTION_TITLE' style='display: grid;align-items: center;height:40px;'>Sous-Section</div></h3>       
        <button class='dw3_form_close' onclick='closeSUB_SECTION();closeMSG();'><span class='material-icons'>close</span></button>
    </div>
    <div id="divSUB_SECTION_MAIN"></div>
</div>

<div id="divMORE" class="divEDITOR" style='z-index:2501;'>
    <div id="divMORE_HEADER" class='dw3_form_head'>
        <h3 style='vertical-align:middle;height:40px;'><div id='hMORE_TITLE' style='display: grid;align-items: center;height:40px;'><?php if ($USER_LANG == "FR"){echo "Éditeur";}else{echo "Editor";} ?></div></h3>       
        <button class='dw3_form_close' onclick='closeMORE();closeMSG();'><span class='material-icons'>close</span></button>
    </div>
        <div id="divMORE_MAIN" class='dw3_form_data' style='overflow-x:auto;bottom:0px;'></div>
</div>

<div id="divLANDING" class="divEDITOR">
    <div id="divLANDING_HEADER" class='dw3_form_head'>
        <h3 style='vertical-align:middle;height:40px;'><div id='divLANDING_TITLE' style='display: grid;align-items: center;height:40px;'><?php if ($USER_LANG == "FR"){echo "Modif. du Landing";}else{echo "Landing Modif.";} ?></div></h3>       
        <button class='dw3_form_close' onclick='closeLANDING();closeMSG();'><span class='material-icons'>close</span></button>
    </div>
    <div id="divLANDING_MAIN" class='dw3_form_data' style='background: var(--dw3_head_background);'>
        <form method="POST" action="updLANDING.php<?php echo "?KEY=".$KEY;?>">
        <textarea id='divLANDING_DATA' name="landing_txt" rows=15 id='dw3_LANDING' style='max-width:97.5%; padding:3px;margin:0px 0px 10px 0px;text-align:left;overflow-wrap: break-word;white-space: pre-wrap; display:inline-block;font-size:0.7em;font-family:Roboto;'></textarea>
        <br>
    </div>
    <div id="divLANDING_VIEW" class='dw3_form_data' style='background: var(--dw3_head_background);'><iframe id='divLANDING_HTML' src='' style='width:99%;height:97.5%;border:0;'></iframe></div>
    <div class='dw3_form_foot'>
        <input style='margin-top:10px;' class='green' type="submit" value="Sauvegarder" onclick="addNotif('Sauvegarde en cours..');" />
        <button style='margin-top:10px;' class='blue' id='btnLANDING_VIEW' onclick='toggleLANDING_VIEW()'> Éditer</button>
        <button style='margin-top:10px;' class='grey' onclick='closeLANDING()'> Fermer</button>
    </form>
    </div>
</div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var dw3_file_replace = "unknow";

$(document).ready(function (){
    getSECTIONS();
    dragElement(document.getElementById('divMORE'));
    dragElement(document.getElementById('divLANDING'));
    dragElement(document.getElementById('divFILES_MANAGER'));
    dragElement(document.getElementById('divSUB_SECTION'));
    document.getElementById('config_select').value="/app/config/config_7_index.php";
    //set landing editor height
    var body = document.body,
    html = document.documentElement;
    var height = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );
    document.getElementById('divLANDING_DATA').rows = Math.floor(height/68);
    document.getElementById("divLANDING_DATA").style.display = "none";
});

window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    window.location.reload();
  }
});

function selIMG_TYPE(input_type){
 if (input_type == "gradiant"){
    document.getElementById('btnSECTION_GRAD').style.display="inline-block";
    document.getElementById('btnSECTION_IMG').style.display="none";
    selGRADIANT();
 }else {
    document.getElementById('btnSECTION_GRAD').style.display="none";
    document.getElementById('btnSECTION_IMG').style.display="inline-block";
 }
}
function setGRADIANT(grad){
    document.getElementById('idhIMG').value=grad;
    document.getElementById('btnSECTION_GRAD').style.backgroundImage=grad;
    closeMSG();
}
function selGRADIANT(){
addMsg(
    "<button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button><br><div style='max-height:50vh;'><button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image:linear-gradient(to right, #36D1DC 0%, #5B86E5  51%, #36D1DC  100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to right, #314755 0%, #26a0da 51%, #314755 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to right, #16A085 0%, #F4D03F 51%, #16A085 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to right, #603813 0%, #b29f94  51%, #603813  100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to right, #EDE574 0%, #E1F5C4  51%, #EDE574  100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to right, #02AAB0 0%, #00CDAC  51%, #02AAB0  100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to right, #F09819 0%, #EDDE5D  51%, #F09819  100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to right, #FF512F 0%, #DD2476  51%, #FF512F  100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(43deg, rgb(65, 88, 208) 0%, rgb(200, 80, 192) 46%, rgb(255, 204, 112) 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(160deg, rgb(0, 147, 233) 0%, rgb(128, 208, 199) 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(90deg, rgb(0, 219, 222) 0%, rgb(252, 0, 255) 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(62deg, rgb(251, 171, 126) 0%, rgb(247, 206, 104) 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(45deg, rgb(250, 139, 255) 0%, rgb(43, 210, 255) 52%, rgb(43, 255, 136) 90%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(45deg, rgb(250, 139, 255) 0%, rgb(43, 210, 255) 52%, rgb(43, 255, 136) 90%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(0deg, rgb(255, 222, 233) 0%, rgb(181, 255, 252) 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(rgb(82, 172, 255) 25%, rgb(255, 227, 44) 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(19deg, rgb(33, 212, 253) 0%, rgb(183, 33, 255) 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(132deg, rgb(244, 208, 63) 0%, rgb(22, 160, 133) 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(225deg, rgb(255, 60, 172) 0%, rgb(120, 75, 160) 50%, rgb(43, 134, 197) 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to right, rgb(31, 28, 44), rgb(146, 141, 171));width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to right, rgb(31, 28, 44), rgb(146, 141, 171));width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to bottom, rgb(255, 255, 255) 0%, rgb(50, 50, 50) 90%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to right, rgb(170, 7, 107), rgb(97, 4, 95));width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to right, rgb(20, 136, 204), rgb(43, 50, 178));width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(to right, rgb(7, 101, 133), rgb(255, 255, 255));width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: radial-gradient( circle farthest-corner at 48.4% 47.5%,  rgba(122,183,255,1) 0%, rgba(21,83,161,1) 90% );width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: radial-gradient( circle farthest-corner at 10% 20%,  rgba(2,37,78,1) 0%, rgba(4,56,126,1) 19.7%, rgba(85,245,221,1) 100.2% );width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient( 68.1deg,  rgba(196,69,69,1) 9.2%, rgba(255,167,73,0.82) 25%, rgba(253,217,82,0.82) 43.4%, rgba(107,225,108,0.82) 58.2%, rgba(107,169,225,0.82) 75.1%, rgba(153,41,243,0.82) 87.3% );width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient( 91.2deg,  rgba(136,80,226,1) 4%, rgba(16,13,91,1) 96.5% );width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: radial-gradient( circle farthest-corner at 10% 20%,  rgba(14,174,87,1) 0%, rgba(12,116,117,1) 90% );width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: radial-gradient( circle farthest-corner at 7.2% 13.6%,  rgba(37,249,245,1) 0%, rgba(8,70,218,1) 90% );width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: radial-gradient( circle farthest-corner at 32.7% 82.7%,  rgba(173,0,171,1) 8.3%, rgba(15,51,92,1) 79.4% );width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background-image: linear-gradient(87.4deg, rgb(255, 241, 165) 1.9%, rgb(200, 125, 76) 49.7%, rgb(83, 54, 54) 100.5%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background: linear-gradient(to top, #c4c5c7 0%, #dcdddf 52%, #ebebeb 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background: linear-gradient(to right, #868f96 0%, #596164 100%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background: linear-gradient(111.1deg, rgb(0, 40, 70) -4.8%, rgb(255, 115, 115) 82.7%, rgb(255, 175, 123) 97.2%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background: linear-gradient(89.9deg, rgb(208, 246, 255) 0.1%, rgb(255, 237, 237) 47.9%, rgb(255, 255, 231) 100.2%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background: linear-gradient(109.6deg, rgb(9, 9, 121) 11.2%, rgb(144, 6, 161) 53.7%, rgb(0, 212, 255) 100.2%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background: linear-gradient(109.6deg, rgb(223, 234, 247) 11.2%, rgb(244, 248, 252) 91.1%);width:150px;height:40px;'> </button>"
    +"<button onclick='setGRADIANT(this.style.backgroundImage);' style='background: linear-gradient(179.2deg, rgb(21, 21, 212) 0.9%, rgb(53, 220, 243) 95.5%);width:150px;height:40px;'> </button></div>"
    );
}
         
         
function selICON(){
	addMsg("<br>"
		  +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#33;</span>"
		  +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#35;</span>"
		  +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#36;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#40;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#41;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#42;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#43;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#45;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#46;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#47;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#48;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#49;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#50;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#51;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#52;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#53;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#54;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#55;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#56;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#57;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#58;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#59;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#60;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#61;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#62;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#63;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#64;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#65;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#66;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#67;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#68;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#69;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#70;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#71;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#72;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#73;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#74;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#75;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#76;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#77;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#78;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#79;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#80;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#81;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#82;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#83;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#84;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#85;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#86;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#87;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#88;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#89;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#90;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#91;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#92;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#93;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#94;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#95;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#96;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#97;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#98;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#99;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#101;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#102;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#103;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#104;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#105;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#106;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#107;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#108;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#109;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#110;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#111;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#112;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#113;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#114;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#115;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#116;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#117;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#118;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#119;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#120;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#121;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#122;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#123;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#124;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#125;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#126;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#161;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#162;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#163;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#164;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#165;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#166;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#167;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#168;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#169;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#170;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#171;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#172;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#173;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#174;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#175;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#176;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#177;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#178;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#179;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#180;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#181;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#182;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#183;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#184;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#185;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#194;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#195;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#196;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#197;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#198;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#199;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#201;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#202;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#203;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#204;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#205;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#206;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#207;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#208;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#209;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#210;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#211;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#212;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#213;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#214;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#215;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#216;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#217;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#218;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#219;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#220;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#221;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#222;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#223;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#224;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#228;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#229;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#230;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#231;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#232;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#233;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#234;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#235;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#236;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#237;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#238;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#239;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#253;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#254;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#255;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#256;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#257;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#258;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#259;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#260;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#261;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#262;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#263;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#264;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#265;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#266;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#267;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#268;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#269;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#270;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#271;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#272;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#273;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#274;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#275;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#276;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#277;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#278;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#279;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#280;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#281;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#282;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#283;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#304;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#305;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#306;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#307;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#308;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#309;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#310;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#311;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#312;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#313;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#314;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#315;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#316;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#317;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#318;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#319;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#320;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#321;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#322;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#323;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#324;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#325;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#326;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#327;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#328;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#329;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#342;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#343;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#380;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#381;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#382;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#383;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#384;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#385;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#386;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#387;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#388;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#389;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#390;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#391;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#392;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#393;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#394;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#395;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#396;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#397;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#398;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#399;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#400;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#418;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#419;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#420;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#421;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#422;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#423;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#424;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#425;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#426;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#427;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#428;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#429;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#430;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#431;</span>"
	      +"<span class='dw3_font hover_gold' style='vertical-align:middle;cursor:pointer;margin:2px;' onclick=\"setICON(this.innerText);closeMSG();\">&#432;</span>"
		  +"<br><button onclick='closeMSG();' class='grey'><span class='material-icons' style='vertical-align:middle;'>done</span>Annuler</button>");
}
function setICON(name){
	document.getElementById("idhICON_SPAN").innerText=name;
	document.getElementById("idhICON").value=name;
}

function selSECTION_IMG(target,img) {
	document.getElementById(target).value = img;
	document.getElementById("idhIMG_IMG").src = "/pub/upload/"+img;
    document.getElementById("divFADE").style.width = "0px";
    document.getElementById("divMSG").style.display = "none";
    document.getElementById("divMSG").innerHTML = "";
}

function selUPLOAD(target) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getUPLOADS.php?KEY=' + KEY + "&TARGET=" + target, true);
    xmlhttp.send();	
}


function updINDEX(){
    //var sPERSO1_TITLE = document.getElementById("txtPERSO1_TITLE").value;

    var sINDEX_POPUP_FR = document.getElementById("INDEX_POPUP_FR").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    var sINDEX_POPUP_EN = document.getElementById("INDEX_POPUP_EN").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    var sCOOKIE = document.getElementById("INDEX_COOKIE").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    var sCOOKIE_EN = document.getElementById("INDEX_COOKIE_EN").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
	var GRPBOX  = document.getElementById("INDEX_HEADER");
	var sINDEX_HEADER = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("CIE_PROTECTOR");
	var sCIE_PROTECTOR = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("INDEX_FOOTER");
	var sINDEX_FOOTER = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("INDEX_LANG");
	var sINDEX_LANG = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("LOGIN_BTN_CLASS");
	var sLOGIN_BTN_CLASS = GRPBOX.options[GRPBOX.selectedIndex].value;
    var sFOOT_MARGIN = document.getElementById("FOOT_MARGIN").value;
    var sINDEX_SCENE = document.getElementById("INDEX_SCENE").value;
    var sINDEX_TITLE_FR = document.getElementById("INDEX_TITLE_FR").value;
    var sINDEX_TITLE_EN = document.getElementById("INDEX_TITLE_EN").value;
    var sINDEX_TOP_FR = document.getElementById("INDEX_TOP_FR").value;
    var sINDEX_TOP_EN = document.getElementById("INDEX_TOP_EN").value;
    var sINDEX_META_DESC = document.getElementById("INDEX_META_DESC").value;
    var sINDEX_META_KEYW = document.getElementById("INDEX_META_KEYW").value;
	if (document.getElementById("INDEX_NEWS").checked == true){var sINDEX_NEWS = "true"; } else { var sINDEX_NEWS ="false"; }
	if (document.getElementById("INDEX_SEARCH").checked == true){var sINDEX_SEARCH = "true"; } else { var sINDEX_SEARCH ="false"; }
	if (document.getElementById("INDEX_CART").checked == true){var sINDEX_CART = "true"; } else { var sINDEX_CART ="false"; }
	if (document.getElementById("INDEX_WISH").checked == true){var sINDEX_WISH = "true"; } else { var sINDEX_WISH ="false"; }
	if (document.getElementById("INDEX_DSP_LANG").checked == true){var sINDEX_DSP_LANG = "true"; } else { var sINDEX_DSP_LANG ="false"; }
	if (document.getElementById("INDEX_DSP_SIGNIN").checked == true){var sINDEX_DSP_SIGNIN = "true"; } else { var sINDEX_DSP_SIGNIN ="false"; }
	if (document.getElementById("INDEX_DSP_SUPPLIER").checked == true){var sINDEX_DSP_SUPPLIER = "true"; } else { var sINDEX_DSP_SUPPLIER ="false"; }
	if (document.getElementById("INDEX_BLOCK_DEBUG").checked == true){var sINDEX_BLOCK_DEBUG = "true"; } else { var sINDEX_BLOCK_DEBUG ="false"; }
	if (document.getElementById("DASH_PROFIL").checked == true){var sDASH = "1"; } else { var sDASH ="0"; }
	if (document.getElementById("DASH_MARKET").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_CART").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_INVOICE").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_ORDER").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_RDV").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_HIST").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_DOC").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_PROMO").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_COOKIES").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_PHONE").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_EML").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_PRIVACY").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_LICENSE").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_COMPLAINT").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_END").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_RETURN").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }
	if (document.getElementById("DASH_SUBSCRIBE").checked == true){sDASH = sDASH + "1"; } else {sDASH = sDASH + "0"; }

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim() == ""){
            addNotif("Sauvegarde de l'index terminée.");
        } else {
            addMsg(this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        }     
	  }
	};
    xmlhttp.open('GET', 'updINDEX.php?KEY=' + KEY 
                                    + "&N=" + encodeURIComponent(sINDEX_NEWS)
                                    + "&H=" + encodeURIComponent(sINDEX_HEADER)
                                    + "&F=" + encodeURIComponent(sINDEX_FOOTER)
                                    + "&S=" + encodeURIComponent(sINDEX_SCENE)
                                    + "&PR=" + encodeURIComponent(sCIE_PROTECTOR)
                                    + "&C=" + encodeURIComponent(sCOOKIE)
                                    + "&CE=" + encodeURIComponent(sCOOKIE_EN)
                                    + "&SS=" + encodeURIComponent(sINDEX_SEARCH)
                                    + "&K=" + encodeURIComponent(sINDEX_CART)
                                    + "&W=" + encodeURIComponent(sINDEX_WISH)
                                    + "&M=" + encodeURIComponent(sFOOT_MARGIN)
                                    + "&DL=" + encodeURIComponent(sINDEX_DSP_LANG)
                                    + "&DS=" + encodeURIComponent(sINDEX_DSP_LANG)
                                    + "&L=" + encodeURIComponent(sINDEX_LANG)
                                    + "&SI=" + encodeURIComponent(sINDEX_DSP_SIGNIN)
                                    + "&BC=" + encodeURIComponent(sLOGIN_BTN_CLASS)
                                    + "&BD=" + encodeURIComponent(sINDEX_BLOCK_DEBUG)
                                    + "&TF=" + encodeURIComponent(sINDEX_TITLE_FR)
                                    + "&TE=" + encodeURIComponent(sINDEX_TITLE_EN)
                                    + "&OF=" + encodeURIComponent(sINDEX_TOP_FR)
                                    + "&OE=" + encodeURIComponent(sINDEX_TOP_EN)
                                    + "&PF=" + encodeURIComponent(sINDEX_POPUP_FR)
                                    + "&PE=" + encodeURIComponent(sINDEX_POPUP_EN)
                                    + "&MD=" + encodeURIComponent(sINDEX_META_DESC)
                                    + "&MK=" + encodeURIComponent(sINDEX_META_KEYW)
                                    + "&DASH=" + sDASH
                                    , true);
    xmlhttp.send();
}

function dw3_up_to_slide(section_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getUPLOADS_SL.php?KEY=' + KEY + "&sid=" + section_id, true);
    xmlhttp.send();	
}

function newSLIDE(section_id,fn) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim()  == ""){
            addNotif("Média ajouté à la gallerie");
            get_section_gallery(section_id);
        } else {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
        }
	  }
	};
    xmlhttp.open('GET', 'newSLIDE_LINE.php?KEY=' + KEY + "&sid=" + section_id + "&fn=" + fn, true);
    xmlhttp.send();	
}

function updSL_SORT(slide_id,that) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim() == ""){
            addNotif("L'ordre du diapo a été modifié.");
            //get_section_gallery(section_id);
        } else {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
        }
	  }
	};
    xmlhttp.open('GET', 'updSL_SORT.php?KEY=' + KEY + "&sid=" + slide_id + "&sort=" + encodeURIComponent(that.value), true);
    xmlhttp.send();	
}
function updSL_NAME(slide_id,that) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim()  == ""){
            addNotif("Le titre français du diapo a été modifié.");
            //get_section_gallery(section_id);
        } else {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
        }
	  }
	};
    xmlhttp.open('GET', 'updSL_NAME.php?KEY=' + KEY + "&sid=" + slide_id + "&name=" + encodeURIComponent(that.value), true);
    xmlhttp.send();	
}
function updSL_NAME_EN(slide_id,that) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim()  == ""){
            addNotif("Le titre anglais du diapo a été modifié.");
            //get_section_gallery(section_id);
        } else {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
        }
	  }
	};
    xmlhttp.open('GET', 'updSL_NAME_EN.php?KEY=' + KEY + "&sid=" + slide_id + "&name=" + encodeURIComponent(that.value), true);
    xmlhttp.send();	
}
function updSL_URL(slide_id,that) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim()  == ""){
            addNotif("Le lien du diapo a été modifié");
            //get_section_gallery(section_id);
        } else {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
        }
	  }
	};
    xmlhttp.open('GET', 'updSL_URL.php?KEY=' + KEY + "&sid=" + slide_id + "&url=" + encodeURIComponent(that.value), true);
    xmlhttp.send();	
}
function delSLIDE(slide_id,section_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.trim()  == ""){
            addNotif("Média enlevé à la gallerie");
            get_section_gallery(section_id);
        } else {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
        }
	  }
	};
    xmlhttp.open('GET', 'delSLIDE_LINE.php?KEY=' + KEY + "&sid=" + slide_id, true);
    xmlhttp.send();	
}
function delFILE_SL(fn,section_id) {
	document.getElementById("divFADE").style.width = "100%";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Êtes-vous certain de vouloir supprimer le fichier du serveur ? <br> Cette action est irréversible.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button> <button class='red' onclick=\"closeMSG();deleteFILE_SL('"+fn+"','"+section_id+"')\"><span class='material-icons' style='vertical-align:middle;'>done</span> Supprimer définitivement </button>";
}
function deleteFILE_SL(fn,section_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "1"){
            addNotif("Média supprimé du dossier /pub/upload");
            dw3_up_to_slide(section_id);
        } else {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok </button>";
        }
	  }
	};
    xmlhttp.open('GET', 'delFILE_SL.php?KEY=' + KEY + "&fn=" + fn, true);
    xmlhttp.send();	
}

function showFile(){
  let fileType = drop_file.type; //getting selected file type
  let validExtensions = ["image/jpeg", "image/jpg", "image/png"]; //adding some valid image extensions in array
  if(validExtensions.includes(fileType)){ //if user selected file is an image file
    let fileReader = new FileReader(); //creating new FileReader object
    fileReader.onload = ()=>{
      let fileURL = fileReader.result; //passing user file source in fileURL variable
      let imgTag = `<img src="${fileURL}" alt="">`; //creating an img tag and passing user selected file source inside src attribute
      dropArea.innerHTML = imgTag; //adding that created img tag inside dropArea container
    }
    fileReader.readAsDataURL(drop_file);
  }else{
    alert("This is not an Image File!");
    dropArea.classList.remove("dw3_drop_active");
    dragText.textContent = "Glissez des documents ici pour les afficher dans la gallerie";
  }
}


function dw3_upload_file(e,section_id) {
    e.preventDefault();
	//for each..files[0]
    const upfiles = e.dataTransfer.files;
    var is_last = false;
    for (i = 0; i < upfiles.length; i++) {
        //console.log(numbers[i]);
        fileobj = upfiles[i];
        if (i==upfiles.length-1){is_last=true;}
        js_file_upload(fileobj,section_id,is_last);
    } 
}

function file_browse(section_id) {
  document.getElementById('dw3_file').onchange = function() {
    const upfiles = document.getElementById('dw3_file').files;
    var is_last = false;
    for (i = 0; i < upfiles.length; i++) {
        //console.log(numbers[i]);
        fileobj = upfiles[i];
        if (i==upfiles.length-1){is_last=true;}
        js_file_upload(fileobj,section_id,is_last);
    }
      //fileobj = document.getElementById('dw3_file').files[0];
      //js_file_upload(fileobj,section_id);
  };
}


function js_file_upload(file_obj,section_id,is_last) {
    if(file_obj != undefined) {
        var form_data = new FormData();                  
        form_data.append('fileToSlide', file_obj);
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "upload_file.php?KEY=" + KEY + "&sid="+section_id, true);
        xhttp.onload = function(event) {
            addNotif(xhttp.responseText);
            if (is_last==true){
                get_section_gallery(section_id);
            }
        }
 
        xhttp.send(form_data);
    }
}

function toggleLANDING_VIEW(){
    if (document.getElementById("divLANDING_DATA").style.display == "none"){
        document.getElementById("divLANDING_DATA").style.display = "inline-block";
        document.getElementById("divLANDING_VIEW").style.display = "none";
        document.getElementById("btnLANDING_VIEW").innerHTML = "Voir";
    } else {
        document.getElementById("divLANDING_DATA").style.display = "none";
        document.getElementById("divLANDING_VIEW").style.display = "inline-block";
        document.getElementById("divLANDING_HTML").src = "/landing";
        document.getElementById("btnLANDING_VIEW").innerHTML = "Éditer";
    }
}
function closeMSG2(){
    document.getElementById("divMSG2").style.display = "none";
    document.getElementById("divFADE").style.opacity = "0";
    document.getElementById("divFADE").style.display = "none";	
    closeAudioVideo();
}
function delUPLOAD(fn) {
    if (fn == undefined){
       fn = document.getElementById("txtUPLOAD_FN").value;
    }
	document.getElementById("divFADE").style.width = "100%";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Êtes-vous certain de vouloir supprimer le fichier du serveur? <br>Le fichier peur-être utilisé dans une des pages ou sections du site. <br> Cette action est irréversible.<div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button> <button class='red' onclick=\"closeMSG();deleteUPLOAD('"+fn+"')\"><span class='material-icons' style='vertical-align:middle;'>done</span> Supprimer définitivement </button>";
}
function deleteUPLOAD(fn) {
    closeAudioVideo();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "1"){
            addNotif("Média supprimé du dossier /pub/upload");
            openFILES_MANAGER();
            closeMSG2();
        } else {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok </button>";
        }
	  }
	};
    xmlhttp.open('GET', 'delFILE.php?KEY=' + KEY + "&fn=" + encodeURIComponent(fn) + "&d=upload", true);
    xmlhttp.send();
}
function renameUPLOAD() {
    fn = document.getElementById("txtUPLOAD_FN").value;
    nn = document.getElementById("txtUPLOAD_RENAME").value;
    if (nn.trim() == ""){
       		document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = "Veuillez entrer un nom de fichier valide.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok </button>";
    }
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "1"){
            addNotif("Média renommé.");

        } else {
			document.getElementById("divFADE").style.width = "100%";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok </button>";
        }
	  }
	};
    xmlhttp.open('GET', 'renameFILE.php?KEY=' + KEY + "&FROM=" + encodeURIComponent(fn) + "&TO=" + encodeURIComponent(nn), true);
    xmlhttp.send();
}
function viewUPLOAD(){
  that_src =  document.getElementById("imgUPLOAD").src;
  var modal = document.getElementById("gal2_modal");
  var modalImg = document.getElementById("gal2_model_img");
  document.body.style.overflowY = 'hidden';
  modal.style.display = "block";
  modalImg.src = that_src;
}

function dw3_gal2_close(){
  document.body.style.overflowY = 'auto';
  var modal = document.getElementById("gal2_modal");
  modal.style.display = "none";
}
function closeAudioVideo() {
    var audio = document.getElementById('audioUPLOAD');
    audio.pause();
    var video = document.getElementById('videoUPLOAD');
    video.pause();
}
function getFILE_OPT(fn) {
    var fileExt = fn.split('.').pop().toLowerCase();
    document.getElementById("divFADE").style.width = "100%";
    document.getElementById("divFADE").style.opacity = "0.6";
    document.getElementById("divMSG2").style.display = "inline-block";
    if (fileExt == "mp4"){
        document.getElementById("imgUPLOAD").style.display = "none";
        document.getElementById("audioUPLOAD").style.display = "none";
        document.getElementById("videoUPLOAD").style.display = "inline-block";
        var video = document.getElementById('videoUPLOAD');
        video.src = "/pub/upload/"+fn;
    } else if (fileExt == "mp3"){
        document.getElementById("imgUPLOAD").style.display = "none";
        document.getElementById("videoUPLOAD").style.display = "none";
        document.getElementById("audioUPLOAD").style.display = "inline-block";
        var audio = document.getElementById('audioUPLOAD');
        audio.src = "/pub/upload/"+fn;
    } else  if (fileExt == "jpg" || fileExt == "jpeg" || fileExt == "png"|| fileExt == "gif"|| fileExt == "webp" || fileExt == "svg" || fileExt == "avif"){
        document.getElementById("imgUPLOAD").style.display = "inline-block";
        document.getElementById("videoUPLOAD").style.display = "none";
        document.getElementById("audioUPLOAD").style.display = "none";
        document.getElementById("imgUPLOAD").src = "/pub/upload/"+fn;
    }
    document.getElementById("imgUPLOAD").src = "/pub/upload/"+fn;
    document.getElementById("txtUPLOAD_FN").value = fn;
    document.getElementById("txtUPLOAD_RENAME").value = fn;
}
function closeFILES_MANAGER() {
    document.getElementById("divFILES_MANAGER").style.display = "none";
    document.getElementById("divFADE").style.opacity = "0";
    document.getElementById("divFADE").style.display = "none";	
}
function openFILES_MANAGER() { 
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        closeMSG();
        document.getElementById("divFILES_MANAGER").style.display = "inline-block";
		document.getElementById("divFILES_MANAGER_MAIN").innerHTML = this.responseText.trim();
        document.getElementById("divFADE").style.display = "inline-block";
		document.getElementById("divFADE").style.opacity = "0.4";
        document.getElementById("divFADE").style.width = "100%";
	  }
	};
    xmlhttp.open('GET', 'getFILES.php?KEY=' + KEY + "&DIR=upload", true);
    xmlhttp.send();
}
function closeLANDING() {
    document.getElementById("divLANDING").style.display = "none";
    document.getElementById("divFADE").style.opacity = "0";
    document.getElementById("divFADE").style.display = "none";	
}
function openLANDING() { 
    document.getElementById("divLANDING_HTML").src = "/landing";
    document.getElementById("divFADE").style.opacity = "0.6";
    document.getElementById("divFADE").style.display = "inline-block";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divLANDING").style.display = "inline-block";
		 document.getElementById("divLANDING_DATA").innerHTML = this.responseText.trim();
	  }
	};
		xmlhttp.open('GET', 'getLANDING.php?KEY=' + KEY , true);
		xmlhttp.send();
}
let section_updated = false;
function closeSECTION() {
    if(section_updated){
        document.getElementById("divFADE2").style.opacity = "1";
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment fermer sans sauvegarder les données ?<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons'>close</span>Annuler</button> <button onclick='closeSECTION2();closeMSG();' class='red'><span class='material-icons'>delete</span> Fermer sans sauvegarder</button><br>";
    } else {
        closeSECTION2();
    }
}
function closeSECTION2() {
    document.getElementById("divSECTION").style.display = "none";
    document.getElementById("divFADE").style.opacity = "0";
    document.getElementById("divFADE").style.display = "none";
    section_updated = false;	
}
function closeSUB_SECTION() {
    document.getElementById("divSUB_SECTION").style.display = "none";
    document.getElementById("divFADE").style.opacity = "0";
    document.getElementById("divFADE").style.display = "none";	
}
function getSECTIONS() { 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSECTIONS").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getSECTIONS.php?KEY=' + KEY , true);
		xmlhttp.send();
}

let drop_file; //this is a global variable and we'll use it inside multiple functions
var fileobj;
let dropArea;
let drop_button;
let drop_input;
let dragText;
function getSECTION(ID,target) {
	document.getElementById("divFADE").style.opacity = "0.6";
    document.getElementById("divFADE").style.display = "inline-block";	 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSECTION_MAIN").innerHTML = this.responseText;
		 document.getElementById("divSECTION").style.display = "inline-block";
		 document.getElementById("divSECTION_TITLE").innerHTML = target.charAt(0).toUpperCase() + target.slice(1) + " - Modification";
         dragElement(document.getElementById('divSECTION'));
         if (document.querySelector(".dw3_drop_area")){
            dropArea = document.querySelector(".dw3_drop_area");
            drop_button = document.getElementById("dw3_btn_upload");
            drop_input = document.getElementById("dw3_file");
            dragText = document.getElementById("drop_header");

            drop_button.onclick = ()=>{
            drop_input.click(); //if user click on the button then the input also clicked
            file_browse(ID);
            }

            //drop_input.addEventListener("change", function(){
            //getting user select file and [0] this means if user select multiple files then we'll select only the first one
            //drop_file = this.files[0];
            //dropArea.classList.add("dw3_drop_active");
            //showFile(); //calling function
            //});


            //If user Drag File Over DropArea
            dropArea.addEventListener("dragover", (event)=>{
            event.preventDefault(); //preventing from default behaviour
            //dropArea.classList.add("dw3_drop_active");
            //dragText.textContent = "Relâchez pour déposer les fichiers";
            });

            //If user leave dragged File from DropArea
            //dropArea.addEventListener("dragleave", ()=>{
            //dropArea.classList.remove("dw3_drop_active");
            //dragText.textContent = "Glissez des documents ici pour les afficher dans la gallerie";
            //});

            //If user drop File on DropArea
            //dropArea.addEventListener("drop", (event)=>{
            //event.preventDefault(); //preventing from default behaviour
            //getting user select file and [0] this means if user select multiple files then we'll select only the first one
            //drop_file = event.dataTransfer.files[0];
            //showFile(); //calling function
            //});
            get_section_gallery(ID);
        }
        
	  }
	};
    xmlhttp.open('GET', 'getSECTION.php?KEY=' + KEY + '&ID=' + ID , true);
    xmlhttp.send();
}
function getSUB_SECTION(ID,target) {
	document.getElementById("divFADE").style.opacity = "0.6";
    document.getElementById("divFADE").style.display = "inline-block";	 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSUB_SECTION_MAIN").innerHTML = this.responseText;
		 document.getElementById("divSUB_SECTION").style.display = "inline-block";
		 document.getElementById("divSUB_SECTION_TITLE").innerHTML = target.charAt(0).toUpperCase() + target.slice(1) + " - Modification";
	  }
	};
    xmlhttp.open('GET', 'getSUB_SECTION.php?KEY=' + KEY + '&ID=' + ID , true);
    xmlhttp.send();
}
function get_section_gallery(ID) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("section_gallery").innerHTML = this.responseText
	  }
	};
		xmlhttp.open('GET', 'getSection_gallery.php?KEY=' + KEY + '&ID=' + ID , true);
		xmlhttp.send();  
}
function deleteSECTION(ID) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 addNotif(this.responseText);
         closeSECTION();
         getSECTIONS();
	  }
	};
    xmlhttp.open('GET', 'delSECTION.php?KEY=' + KEY + '&ID=' + ID , true);
    xmlhttp.send();
}
function delSECTION(ID) {
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
    document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment supprimer ces données ?<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons'>close</span>Annuler</button> <button onclick='closeMSG();deleteSECTION("+ID+");' class='red'><span class='material-icons'>delete</span> Effacer</button><br>";
}
function deleteSUB_SECTION(ID) {
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 addNotif(this.responseText);
         closeSUB_SECTION();
         getSUB_SECTIONS();
	  }
	};
    xmlhttp.open('GET', 'delSUB_SECTION.php?KEY=' + KEY + '&ID=' + ID , true);
    xmlhttp.send();
}
function delSUB_SECTION(ID) {
    document.getElementById("divFADE2").style.opacity = "1";
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "Voulez-vous vraiment supprimer ces données ?<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons'>close</span>Annuler</button> <button onclick='closeMSG();deleteSUB_SECTION("+ID+");' class='red'><span class='material-icons'>delete</span> Effacer</button><br>";
}
function newSECTION(div_type,parent_id) {
	  if (div_type == 'page') {
        document.getElementById("divFADE2").style.opacity = "1";
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<h3>Pages</h3><div style='max-height:300px;overflow-y:auto;'><button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_home','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>home</span>Accueil</button>"
                                                    + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_article','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>newspaper</span><b>Articles</b></button>"
                                                    + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_perso','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>dashboard</span><b>Personnalisée</b></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_calendar','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>email</span>Calendrier mensuel</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_calendar2','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>email</span>Calendrier annuel</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_contact1','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>email</span>Contact 1</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_contact2','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>phone</span>Contact 2</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_contact3','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>map</span>Contact 3</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_retailer','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>map</span>Détaillants</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_location','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>map</span>Sélection de location</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_client','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>account_circle</span>Connexion</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_jobs','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>work</span>Carrières</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_profil','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>face</span>Profil</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_submit','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>history_edu</span>Soumission</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_agenda','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>calendar_month</span>Agenda</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_classifieds','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>inventory_2</span>Petites Annonces</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_category','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>inventory_2</span>Catégories de produits</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_products','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>inventory_2</span>Produits</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_product','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>inventory</span>Produit</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('page_tracking','"+parent_id+"','page')\"><span class='material-icons' style='vertical-align:middle;'>local_shipping</span> Repérer un envoi</button>"
                                                    + "</div><div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='color:white;'>close</span>Annuler</button><br>";               
	  } else if (div_type == 'section'){
        document.getElementById("divFADE2").style.opacity = "1";
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<h3>Sections</h3>"
                                                    + "<div style='max-height:300px;overflow-y:auto;'>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_article','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>newspaper</span><b>Articles</b></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_chatbot','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>smart_toy</span><b>Chatbot</b></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_infolettre','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>mail</span><b>Inscription infolettre</b></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_perso1','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>dashboard</span><b>Personnalisée</b></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_navigation','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>dashboard</span><b>Navigation</b></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_sub','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>+</span><b>Sub-section</b></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_sub2','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>signal_cellular_alt_2_bar</span><b>2 Sections</b></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_sub3','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>equalizer</span><b>3 Sections</b></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_tabs2','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>dashboard</span><b>2 Tabs</b></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_tabs3','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>dashboard</span><b>3 Tabs</b></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_tabs4','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>dashboard</span><b>4 Tabs</b></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_faq','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>quiz</span><b>FAQ</b></button>"
                                                    + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_audio','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>face</span>Audio</button>"
                                                    + "<button style='display:none;padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_audio3d','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>face</span>Audio3D</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_carte','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>map</span>Carte Google Maps</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_contact3','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>contact_page</span>Contact</button>"
		                                            + "<button style='display:none;padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_link_form','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>dashboard</span>Lien vers formulaire</button>"
		                                            + "<button style='display:none;padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_social_networks','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>dashboard</span>Réseaux sociaux</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_retailer','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>store</span>Détaillants</button>"
                                                    + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_category','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>inventory</span>Catégories</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_category_ad','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>inventory_2</span>Catégories Annonces</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_products','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>inventory_2</span>Products</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_classifieds','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>inventory_2</span>Petites Annonces</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_product','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>inventory</span>Product</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_counter1','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>looks_one</span>Counter visiteurs</button>"
		                                            + "<button style='display:none;padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_counter2','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>filter_2</span>Counter 2</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_counter3','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>3mp</span>Counter 3</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_attribution','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>account_balance</span>Attribution</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_affiliate','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>work</span>Affilié</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_calendar','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>calendar_month</span>Calendrier mensuel</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_calendar2','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>calendar_month</span>Calendrier annuel</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_gallery1','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>theaters</span>Gallerie 1</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_gallery2','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>theaters</span>Gallerie 2</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_gallery3','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>theaters</span>Gallerie 3</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_slideshow2','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>theaters</span>Slideshow</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_slideshow1','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>theaters</span>Slideshow +Dots</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_slideshow3','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>theaters</span>Flip Cards</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_slideshow4','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>theaters</span>Fading Slide</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_position','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>textsms</span>Job Positions</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_historic','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>timeline</span>Historique</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_realisation','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>youtube_searched_for</span>Réalisations</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_historic2','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>timeline</span>Historique 2</button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_realisation2','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>youtube_searched_for</span>Réalisations 2</button>"
		                                            + "<button style='display:none;padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('section_pwa','"+parent_id+"','section')\"><span class='material-icons' style='vertical-align:middle;'>app_registration</span>Application Web</button>"
                                                    + "</div><div style='height:20px;'> </div><button onclick='closeMSG();' class='grey'><span class='material-icons' style='color:white;'>close</span>Annuler</button><br>";               
	  } else if (div_type == 'button'){
        document.getElementById("divFADE2").style.opacity = "1";
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<h3>Bouttons</h3><br><button onclick=\"closeMSG();crtSECTION('button_tel1','"+parent_id+"','button')\"><span class='material-icons' style='vertical-align:middle;'>phone</span> <?php echo $CIE_TEL1; ?></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('button_tel2','"+parent_id+"','button')\"><span class='material-icons' style='vertical-align:middle;'>call</span> <?php echo $CIE_TEL2; ?></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('button_eml1','"+parent_id+"','button')\"><span class='material-icons' style='vertical-align:middle;'>mail</span> <?php echo $CIE_EML1; ?></button>"
		                                            + "<button style='padding:2px;border-radius:2px;width:175px;' onclick=\"closeMSG();crtSECTION('button_logout','"+parent_id+"','button')\"><span class='material-icons' style='vertical-align:middle;'>login</span> Déconnexion</button>"
                                                    + "<div style='height:20px;'> </div><button onclick='closeMSG();' style='background-color:red;'><span class='material-icons' style='color:white;'>close</span>Annuler</button><br>";               
      } else if (div_type == 'sub'){
        document.getElementById("divFADE2").style.opacity = "1";
        document.getElementById("divFADE2").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
		document.getElementById("divMSG").innerHTML = "<h3>Sous-menu</h3><br><button onclick=\"closeMSG();crtSECTION('sub','"+parent_id+"','sub')\"><span class='material-icons' style='vertical-align:middle;'>phone</span> Menu déroulant</button>"
                                                    + "<div style='height:20px;'> </div><button onclick='closeMSG();' style='background-color:red;'><span class='material-icons' style='color:white;'>close</span>Annuler</button><br>";               
      }

}
function crtSECTION(div_name,parent_id,target) {
	document.getElementById("divFADE").style.opacity = "0.6";
    document.getElementById("divFADE").style.display = "inline-block";	 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            getSECTION(this.responseText,target) ;
            getSECTIONS();
	  }
	};
		xmlhttp.open('GET', 'newSECTION.php?KEY=' + KEY + '&N=' + div_name+ '&P=' + parent_id , true);
		xmlhttp.send();
}


function copySECTIONto(sID,sPARENT){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divFADE").style.opacity = "0.6";
        document.getElementById("divFADE").style.display = "inline-block";
        document.getElementById("divMSG").style.display = "inline-block";
        document.getElementById("divMSG").innerHTML = this.responseText ;
	  }
	};
		xmlhttp.open('GET', 'getPageToCopy.php?KEY=' + KEY
										+ '&ID=' + encodeURIComponent(sID)
										+ '&PAGE=' + encodeURIComponent(sPARENT)
                                        , true);
		xmlhttp.send();
}
function copySECTION(sID,sPARENT){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        //getSECTION(this.responseText,target) ;
        getSECTIONS(); 
        closeMSG();
        addNotif("Une copie de cette section a été ajoutée. Ordre de séquence #"+this.responseText);
	  }
	};
		xmlhttp.open('GET', 'copySECTION.php?KEY=' + KEY
										+ '&ID=' + encodeURIComponent(sID)
										+ '&PARENT=' + encodeURIComponent(sPARENT)
                                        , true);
		xmlhttp.send();
}
function copyPAGE(sID){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        //getSECTION(this.responseText,target) ;
        getSECTIONS(); 
        closeMSG();
        addNotif("Une copie de cette page a été ajoutée. Ordre de séquence #"+this.responseText);
	  }
	};
		xmlhttp.open('GET', 'copyPAGE.php?KEY=' + KEY
										+ '&ID=' + encodeURIComponent(sID), true);
		xmlhttp.send();
}

function updHTML(sID){
    var sHTML_FR		= document.getElementById("idhHTML_FR").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    var sHTML_EN  		= document.getElementById("idhHTML_EN").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    const xhttp = new XMLHttpRequest();
    xhttp.open("POST", "updSECTION_HTML.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onload = function() {
        if (this.responseText == ""){
                addNotif("Mise à jour complétée.");
                getSECTIONS();
                closeSECTION();
                closeMSG();
                section_updated = false;
		  } else {
				document.getElementById("divFADE").style.width = "100%";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  }
    }
  xhttp.send("KEY="+KEY+"&ID="+sID+"&FR="+encodeURIComponent(sHTML_FR)+"&EN="+encodeURIComponent(sHTML_EN));
}

function updSECTION(sID){
	var sTITLE   = document.getElementById("idhTITLE").value;
	var sTITLE_EN   = document.getElementById("idhTITLE_EN").value;
    if (document.getElementById("idhMETA_DESC")){
        var sMETAD  = document.getElementById("idhMETA_DESC").value;
    } else {
        var sMETAD = "";
    }
    if (document.getElementById("idhMETA_KEYW")){
        var sMETAK   = document.getElementById("idhMETA_KEYW").value
    } else {
        var sMETAK = "";
    }
	if (document.getElementById("idhHEADER")){
		var GRPBOX = document.getElementById("idhHEADER");
		var sHEADER = GRPBOX.options[GRPBOX.selectedIndex].value;
	} else {
		var sHEADER = "";
	}
	var GRPBOX = document.getElementById("idhSCENE");
    if (GRPBOX){
	    var sSCENE = GRPBOX.options[GRPBOX.selectedIndex].value;
    }else{
        var sSCENE = "";
    }
    var GRPBOX  = document.getElementById("idhFONT");
	var sFONT  = GRPBOX.options[GRPBOX.selectedIndex].value;
	//var sSCENE  = document.getElementById("idhSCENE").value;
	var sANIM  = document.getElementById("idhANIM").value;
	var sURL  = document.getElementById("idhURL").value;
	var sICON  = document.getElementById("idhICON").value;
	if (document.getElementById("idhMENU").checked == false){var sMENU = "false"; } else { var sMENU ="true"; }
	var sORDER  = document.getElementById("idhORDER").value;
	var sLIST  = document.getElementById("idhLIST").value;
	var sIMG  = document.getElementById("idhIMG").value;
	var sIMG_ANIM  = document.getElementById("idhIMG_ANIM").value;
	var sIMG_ANIM_TIME  = document.getElementById("idhIMG_ANIM_TIME").value;
	var sTITLE_DSP = document.getElementById("idhTITLE_DSP").value;
	var sICON_DSP  = document.getElementById("idhICON_DSP").value;
	var sICON_COLOR  = document.getElementById("idhICON_COLOR").value;
	var sICON_TS  = document.getElementById("idhICON_TS").value;
	var sIMG_DSP  = document.getElementById("idhIMG_DSP").value;
	var sOPACITY  = document.getElementById("idhOPACITY").value;
	var sBG  = document.getElementById("idhBG").value;
	var sFG  = document.getElementById("idhFG").value;
	var sMAXW  = document.getElementById("idhMAXW").value;
	var sRADIUS  = document.getElementById("idhRADIUS").value;
	var sMARGIN  = document.getElementById("idhMARGIN").value;
	var sSHADOW  = document.getElementById("idhSHADOW").value;
    /* var sHTML_FR = document.getElementById("idhHTML_FR").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    var sHTML_EN = document.getElementById("idhHTML_EN").value.replace(/(?:\r\n|\r|\n)/g, '<br>'); */

	if (sTITLE == ""){
		document.getElementById("idhTITLE").style.borderColor = "red";
		document.getElementById("idhTITLE").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("idhTITLE").style.borderColor = "grey";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	
/* 	if (sTARGET == ""){
		document.getElementById("idhURL").style.borderColor = "red";
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("idhURL").style.borderColor = "grey";
		//document.getElementById("lblPRD").innerHTML = "";
	} */

    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == "0"){
                updHTML(sID);
		  } else {
				document.getElementById("divFADE").style.opacity = "0.6";
                document.getElementById("divFADE").style.display = "inline-block";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updSECTION.php?KEY=' + KEY
										+ '&ID=' + encodeURIComponent(sID)
										+ '&SCENE=' + encodeURIComponent(sSCENE)
										+ '&HEADER=' + encodeURIComponent(sHEADER)
										+ '&TITLE=' + encodeURIComponent(sTITLE)
										+ '&TITLE_EN=' + encodeURIComponent(sTITLE_EN)
										+ '&METAD=' + encodeURIComponent(sMETAD)
										+ '&METAK=' + encodeURIComponent(sMETAK)
										+ '&FONT=' + encodeURIComponent(sFONT)
										+ '&URL=' + encodeURIComponent(sURL)
										+ '&MENU=' + encodeURIComponent(sMENU)  
										+ '&ORDER=' + encodeURIComponent(sORDER)  
										+ '&LIST=' + encodeURIComponent(sLIST)  
										+ '&IMG=' + encodeURIComponent(sIMG)  
										+ '&IMG_ANIM=' + encodeURIComponent(sIMG_ANIM)  
										+ '&IMG_ANIM_TIME=' + encodeURIComponent(sIMG_ANIM_TIME)  
										+ '&IMG_DSP=' + encodeURIComponent(sIMG_DSP)  
										+ '&TITLE_DSP=' + encodeURIComponent(sTITLE_DSP)  
										+ '&ICON_DSP=' + encodeURIComponent(sICON_DSP)  
										+ '&ICON_COLOR=' + encodeURIComponent(sICON_COLOR)  
										+ '&ICON_TS=' + encodeURIComponent(sICON_TS)  
										+ '&OPACITY=' + encodeURIComponent(sOPACITY)  
										+ '&BG=' + encodeURIComponent(sBG)  
										+ '&FG=' + encodeURIComponent(sFG)  
										+ '&MAXW=' + encodeURIComponent(sMAXW)  
										+ '&RADIUS=' + encodeURIComponent(sRADIUS)  
										+ '&MARGIN=' + encodeURIComponent(sMARGIN)  
										+ '&SHADOW=' + encodeURIComponent(sSHADOW)  
										+ '&ICON=' + encodeURIComponent(sICON)
										+ '&ANIM=' + encodeURIComponent(sANIM)
                                        , true);
		xmlhttp.send();
}
function updSUB_SECTION(sID){
	var sORDER   = document.getElementById("subORDER").value;
	var sTITLE   = document.getElementById("subTITLE").value;
	var sTITLE_EN   = document.getElementById("subTITLE_EN").value;
    var sHTML_FR = document.getElementById("subHTML_FR").value.replace(/(?:\r\n|\r|\n)/g, '<br>');
    var sHTML_EN = document.getElementById("subHTML_EN").value.replace(/(?:\r\n|\r|\n)/g, '<br>');

/* 	if (sTITLE == ""){
		document.getElementById("subTITLE").style.borderColor = "red";
		document.getElementById("subTITLE").focus();
		return;
	} else {
		document.getElementById("subTITLE").style.borderColor = "grey";
	} */
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == "0"){
                addNotif("Mise à jour complétée.");
                closeSUB_SECTION();
		  } else {
				document.getElementById("divFADE").style.opacity = "0.6";
                document.getElementById("divFADE").style.display = "inline-block";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
    xmlhttp.open('GET', 'updSUB_SECTION.php?KEY=' + KEY
                                    + '&ID=' + encodeURIComponent(sID)
                                    + '&ORDER=' + encodeURIComponent(sORDER)
                                    + '&TITLE_FR=' + encodeURIComponent(sTITLE)
                                    + '&TITLE_EN=' + encodeURIComponent(sTITLE_EN)
                                    + "&FR=" + encodeURIComponent(sHTML_FR)
                                    + "&EN=" + encodeURIComponent(sHTML_EN)
                                    , true);
    xmlhttp.send();
}

//AFFILIATE
function newAFFILIATE() {
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Ajout d'une nouvelle affiliation.");
		getAFFILIATE();
	  }
	};
    xmlhttp.open('GET', 'newAFFILIATE.php?KEY=' + KEY, true);
    xmlhttp.send();
}
function getAFFILIATE() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divMORE_MAIN").innerHTML = this.responseText;
        //closeMSG();
	  }
	};
    xmlhttp.open('GET', 'getAFFILIATE.php?KEY=' + KEY, true);
    xmlhttp.send();
}
function delAFFILIATE(row_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Données supprimés.");
		getAFFILIATE();
	  }
	};
    xmlhttp.open('GET', 'delAFFILIATE.php?KEY=' + KEY + '&ID=' + row_id, true);
    xmlhttp.send();
}
function updAFFILIATE(row_id,col_name,new_value) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Mise à jour terminée.");
	  }
	};
    xmlhttp.open('GET', 'updAFFILIATE.php?KEY=' + KEY
                                    + '&ID=' + row_id
                                    + '&COL=' + col_name
                                    + '&V=' + encodeURIComponent(new_value)
                                    , true);
    xmlhttp.send();
}
function openAFFILIATE() {
    getAFFILIATE();
    document.getElementById("divMORE").style.display = "inline-block";
    document.getElementById("hMORE_TITLE").innerHTML = "Affiliations";
	document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";
}
//ATTRIBUTIONS
function newATTRIB() {
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Ajout d'une nouvelle attribution.");
		getATTRIB();
        closeMSG();
	  }
	};
    xmlhttp.open('GET', 'newATTRIB.php?KEY=' + KEY, true);
    xmlhttp.send();
}
function getATTRIB() {
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divMORE_MAIN").innerHTML = this.responseText;
        closeMSG();
	  }
	};
    xmlhttp.open('GET', 'getATTRIB.php?KEY=' + KEY, true);
    xmlhttp.send();
}
function delATTRIB(row_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Données supprimés.");
		getATTRIB();
	  }
	};
    xmlhttp.open('GET', 'delATTRIB.php?KEY=' + KEY + '&ID=' + row_id, true);
    xmlhttp.send();
}
function updATTRIB(row_id,col_name,new_value) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Mise à jour terminée.");
	  }
	};
		xmlhttp.open('GET', 'updATTRIB.php?KEY=' + KEY
										+ '&ID=' + row_id
										+ '&COL=' + col_name
										+ '&V=' + encodeURIComponent(new_value)
										, true);
		xmlhttp.send();
}
function openATTRIB() {
    getATTRIB();
    document.getElementById("divMORE").style.display = "inline-block";
    document.getElementById("hMORE_TITLE").innerHTML = "Attributions";
	document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";
}
//FAQ
function newFAQ() {
    document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Ajout d'une nouvelle question/réponse.");
		getFAQ();
        closeMSG();
	  }
	};
    xmlhttp.open('GET', 'newFAQ.php?KEY=' + KEY, true);
    xmlhttp.send();
}
function getFAQ() {
    document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divMORE_MAIN").innerHTML = this.responseText;
        closeMSG();
	  }
	};
    xmlhttp.open('GET', 'getFAQ.php?KEY=' + KEY, true);
    xmlhttp.send();
}
function delFAQ(row_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Données supprimés.");
		getFAQ();
	  }
	};
		xmlhttp.open('GET', 'delFAQ.php?KEY=' + KEY + '&ID=' + row_id, true);
		xmlhttp.send();
}
function updFAQ(row_id,col_name,new_value) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Mise à jour terminée.");
	  }
	};
    xmlhttp.open('GET', 'updFAQ.php?KEY=' + KEY
                                    + '&ID=' + row_id
                                    + '&COL=' + col_name
                                    + '&V=' + encodeURIComponent(new_value)
                                    , true);
    xmlhttp.send();
}
function openFAQ() {
    getFAQ();
    document.getElementById("divMORE").style.display = "inline-block";
    document.getElementById("hMORE_TITLE").innerHTML = "FAQ";
}
//HISTORIC
function newHISTORIC() {
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Ajout d'un nouvel historique.");
		getHISTORIC();
	  }
	};
    xmlhttp.open('GET', 'newHISTORIC.php?KEY=' + KEY, true);
    xmlhttp.send();
}
function getHISTORIC() {
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divMORE_MAIN").innerHTML = this.responseText;
        closeMSG();
	  }
	};
    xmlhttp.open('GET', 'getHISTORIC.php?KEY=' + KEY, true);
    xmlhttp.send();
}
function delHISTORIC(row_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Données supprimés.");
		getHISTORIC();
	  }
	};
		xmlhttp.open('GET', 'delHISTORIC.php?KEY=' + KEY
										+ '&ID=' + row_id
										, true);
		xmlhttp.send();
}
function updHISTORIC(row_id,col_name,new_value) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText){
            addMsg(this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
        } else{
            addNotif("Mise à jour terminée.");
        }
	  }
	};
		xmlhttp.open('GET', 'updHISTORIC.php?KEY=' + KEY
										+ '&ID=' + row_id
										+ '&COL=' + col_name
										+ '&V=' + encodeURIComponent(new_value)
										, true);
		xmlhttp.send();
}
function openHISTORIC() {
    getHISTORIC();
    document.getElementById("divMORE").style.display = "inline-block";
    document.getElementById("hMORE_TITLE").innerHTML = "Historique";
	document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";
}
//REALISATION
function newREALISATION() {
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Ajout d'une nouvelle réalisation.");
		getREALISATION();
        closeMSG();
	  }
	};
		xmlhttp.open('GET', 'newREALISATION.php?KEY=' + KEY, true);
		xmlhttp.send();
}
function getREALISATION() {
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divMORE_MAIN").innerHTML = this.responseText;
        closeMSG();
	  }
	};
		xmlhttp.open('GET', 'getREALISATION.php?KEY=' + KEY, true);
		xmlhttp.send();
}
function delREALISATION(row_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Données supprimés.");
		getREALISATION();
	  }
	};
		xmlhttp.open('GET', 'delREALISATION.php?KEY=' + KEY
										+ '&ID=' + row_id
										, true);
		xmlhttp.send();
}
function updREALISATION(row_id,col_name,new_value) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Mise à jour terminée.");
	  }
	};
		xmlhttp.open('GET', 'updREALISATION.php?KEY=' + KEY
										+ '&ID=' + row_id
										+ '&COL=' + col_name
										+ '&V=' + encodeURIComponent(new_value)
										, true);
		xmlhttp.send();
}
function openREALISATION() {
    getREALISATION();
    document.getElementById("divMORE").style.display = "inline-block";
    document.getElementById("hMORE_TITLE").innerHTML = "Réalisations";
	document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";
}
//COUPONS
function newCOUPON() {
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Ajout d'un nouveau coupon.");
		getCOUPONS();
	  }
	};
		xmlhttp.open('GET', 'newCOUPON.php?KEY=' + KEY, true);
		xmlhttp.send();
}
function getCOUPONS() {
    document.getElementById("divFADE2").style.opacity = "1";
    document.getElementById("divFADE2").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Veuillez patienter..<br><img style='border-radius:10px;width:50px;height:auto;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'>";

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        document.getElementById("divMORE_MAIN").innerHTML = this.responseText;
        closeMSG();
	  }
	};
		xmlhttp.open('GET', 'getCOUPON.php?KEY=' + KEY, true);
		xmlhttp.send();
}
function delCOUPON(row_id) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Données supprimés.");
		getCOUPONS();
	  }
	};
		xmlhttp.open('GET', 'delCOUPON.php?KEY=' + KEY
										+ '&ID=' + row_id
										, true);
		xmlhttp.send();
}
function updCOUPON(row_id,col_name,new_value) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif("Mise à jour terminée.");
	  }
	};
		xmlhttp.open('GET', 'updCOUPON.php?KEY=' + KEY
										+ '&ID=' + row_id
										+ '&COL=' + col_name
										+ '&V=' + encodeURIComponent(new_value)
										, true);
		xmlhttp.send();
}
function openCOUPONS() {
    getCOUPONS();
    document.getElementById("divMORE").style.display = "inline-block";
    document.getElementById("hMORE_TITLE").innerHTML = "Coupons";
	document.getElementById("divFADE2").style.opacity = "0.6";
    document.getElementById("divFADE2").style.display = "inline-block";
}
function closeMORE() {
    document.getElementById("divMORE").style.display = "none";
}

$('#frmUPLOAD').on('submit',function(e){
  e.preventDefault();
  e.stopImmediatePropagation();
  if ($('#fileToUpload')[0].files[0] == ""){return;}
  sendUPLOAD();
});

function sendUPLOAD(){
    var fileInput = document.getElementById('fileToUpload'); 
    var filename = fileInput.files[0].name;
    data = new FormData();
    data.append('fileToUpload', $('#fileToUpload')[0].files[0]);
    data.append('fileNameUpload', document.getElementById("fileNameUpload").value);
    $.ajax({
        type : 'post',
        url : 'upload.php?KEY='+KEY + '&REPLACE='+dw3_file_replace,
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
                document.getElementById("divMSG").innerHTML = "Le fichier est déjà existant, voulez-vous le conserver ou le remplacer?<div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>undo</span> Conserver</button> <button class='blue' onclick=\"closeMSG();dw3_file_replace='yes';sendUPLOAD();\"><span class='material-icons' style='vertical-align:middle;'>published_with_changes</span> Remplacer</button>";
            } else {
                if (document.getElementById("btnSECTION_IMG")){
                    document.getElementById("idhIMG").value = filename;
                    document.getElementById("btnSECTION_IMG").innerHTML = "<img src='/pub/upload/" + filename+ "'  style='width:250px;height:auto;'><br>Modifier";
                } 
                closeMSG();
                addNotif(response);
                fileInput.value = null;
            }
        }
    });
}

</script>
</body>
</html>
<?php $dw3_conn->close();exit(); ?>
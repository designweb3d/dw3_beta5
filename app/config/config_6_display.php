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
$APNAME = "Affichage";
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
                    <option value="/app/config/config_3_structure.php"> Structure de l'entreprise </option>
                    <option value="/app/config/config_4_gouv.php"> Renseignements Gouvernementaux </option>
                    <option value="/app/config/config_5_plan.php"> Plan d'affaire </option>
                    <option selected value="/app/config/config_6_display.php"> Affichage </option>
                    <option value="/app/config/config_7_index.php"> Index & Pages Web </option>
                    <option value="/app/config/config_8_api.php"> API's et Réseaux Sociaux</option>
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
    <button class='red' onclick='delIMG()'><span class="material-icons">delete_forever</span></button>
    <button class='blue' onclick='rotateUPLOAD()'><span class="material-icons">rotate_90_degrees_ccw</span></button>
</div>
<div id="divOPT"></div>

<div id="divFILES_MANAGER" class="divEDITOR">
    <div id="divFILES_MANAGER_HEADER" class='dw3_form_head'>
        <h3 style='vertical-align:middle;height:40px;'><div id='divFILES_MANAGER_TITLE' style='display: grid;align-items: center;height:40px;'><?php if ($USER_LANG == "FR"){echo "Gestionnaire de fichiers";}else{echo "Files Manager";} ?></div></h3>       
        <button class='dw3_form_close' onclick='closeFILES_MANAGER();closeMSG2();'><span class='material-icons'>close</span></button>
    </div>
    <div id="divFILES_MANAGER_MAIN" class='dw3_form_data' style='overflow-x:auto;bottom:0px;'></div>
</div>

<div class="divMAIN" style="margin-top:50px;">
    <div class="divPAGE">		
        <div class="divBOX">Logo courriels:<br>
                <?php 
                if ($CIE_GROK_KEY != ""){ echo "<button onclick=\"dw3_prompt_grok_image('imgLOGO1','txtLOGO1','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                if ($CIE_GPT_KEY != ""){ echo "<button onclick=\"dw3_prompt_gpt_image('imgLOGO1','txtLOGO1','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec ChatGPT AI' class='material-icons'>auto_awesome</span> ChatGPT</button>";}
                ?>
            <input id="txtLOGO1" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_LOGO1; ?>">
            <button style='min-width:50px;float:right;' onclick="selLOGO1('txtLOGO1');"><img id='imgLOGO1' src='/pub/img/<?php echo $CIE_LOGO1; ?>' style='width:250px;height:auto;'> ..</button>
        </div>	
        <div class="divBOX">Logo factures et PDF:<br>
                <?php 
                if ($CIE_GROK_KEY != ""){ echo "<button onclick=\"dw3_prompt_grok_image('imgLOGO2','txtLOGO2','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                if ($CIE_GPT_KEY != ""){ echo "<button onclick=\"dw3_prompt_gpt_image('imgLOGO2','txtLOGO2','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec ChatGPT AI' class='material-icons'>auto_awesome</span> ChatGPT</button>";}
                ?>
            <input id="txtLOGO2" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_LOGO2; ?>">
            <button style='min-width:50px;float:right;' onclick="selLOGO2('txtLOGO2');"><img id='imgLOGO2' src='/pub/img/<?php echo $CIE_LOGO2; ?>' style='width:250px;height:auto;'> ..</button>
        </div>
        <div class="divBOX">Logo menu index:<br>
                <?php 
                if ($CIE_GROK_KEY != ""){ echo "<button onclick=\"dw3_prompt_grok_image('imgLOGO3','txtLOGO3','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                if ($CIE_GPT_KEY != ""){ echo "<button onclick=\"dw3_prompt_gpt_image('imgLOGO3','txtLOGO3','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec ChatGPT AI' class='material-icons'>auto_awesome</span> ChatGPT</button>";}
                ?>
            <input id="txtLOGO3" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_LOGO3; ?>">
            <button style='min-width:50px;float:right;' onclick="selLOGO3('txtLOGO3');"><img id='imgLOGO3' src='/pub/img/<?php echo $CIE_LOGO3; ?>' style='width:250px;height:auto;'> ..</button>
        </div>
        <div class="divBOX">Logo menu système:<br>
                <?php 
                if ($CIE_GROK_KEY != ""){ echo "<button onclick=\"dw3_prompt_grok_image('imgLOGO4','txtLOGO4','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                if ($CIE_GPT_KEY != ""){ echo "<button onclick=\"dw3_prompt_gpt_image('imgLOGO4','txtLOGO4','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec ChatGPT AI' class='material-icons'>auto_awesome</span> ChatGPT</button>";}
                ?>
            <input id="txtLOGO4" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_LOGO4; ?>">
            <button style='min-width:50px;float:right;' onclick="selLOGO4('txtLOGO4');"><img id='imgLOGO4' src='/pub/img/<?php echo $CIE_LOGO4; ?>' style='width:250px;height:auto;'> ..</button>
        </div>
        <div class="divBOX">Logo bas de page:<br>
                <?php 
                if ($CIE_GROK_KEY != ""){ echo "<button onclick=\"dw3_prompt_grok_image('imgLOGO5','txtLOGO5','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                if ($CIE_GPT_KEY != ""){ echo "<button onclick=\"dw3_prompt_gpt_image('imgLOGO5','txtLOGO5','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec ChatGPT AI' class='material-icons'>auto_awesome</span> ChatGPT</button>";}
                ?>
            <input id="txtLOGO5" type="text" style="vertical-align:middle;margin:5px;" value="<?php echo $CIE_LOGO5; ?>">
            <br><div style='font-size:0.7em;float:left;'>Pour afficher le sceau ecoresponsable de WHC entrez un chiffre de 1 à 8</div>
            <br><div style='font-size:0.7em;float:left;'>Pour afficher le badge canadien de WHC entrez un chiffre de 10 à 17</div>
            <button style='min-width:50px;float:right;' onclick="selLOGO5('txtLOGO5');"><img id='imgLOGO5' src='/pub/img/<?php echo $CIE_LOGO5; ?>' style='width:250px;height:auto;'> ..</button>
        </div>
        <div class="divBOX">Arrière plan index:<br>
                <?php 
                if ($CIE_GROK_KEY != ""){ echo "<button onclick=\"dw3_prompt_grok_image('imgBG1','txtBG1','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                if ($CIE_GPT_KEY != ""){ echo "<button onclick=\"dw3_prompt_gpt_image('imgBG1','txtBG1','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec ChatGPT AI' class='material-icons'>auto_awesome</span> ChatGPT</button>";}
                ?>
            <input id="txtBG1" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_BG1; ?>">
            <button style='min-width:50px;float:right;' onclick="selBG1('txtBG1');"><img id='imgBG1' src='/pub/img/<?php echo $CIE_BG1; ?>' style='width:250px;height:auto;'> ..</button>
        </div>
        <div class="divBOX">Arrière plan menu:<br>
                <?php 
                if ($CIE_GROK_KEY != ""){ echo "<button onclick=\"dw3_prompt_grok_image('imgBG5','txtBG5','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                if ($CIE_GPT_KEY != ""){ echo "<button onclick=\"dw3_prompt_gpt_image('imgBG5','txtBG5','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec ChatGPT AI' class='material-icons'>auto_awesome</span> ChatGPT</button>";}
                ?>
            <input id="txtBG5" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_BG5; ?>">
            <button style='min-width:50px;float:right;' onclick="selBG5('txtBG5');"><img id='imgBG5' src='/pub/img/<?php echo $CIE_BG5; ?>' style='width:250px;height:auto;'> ..</button>
        </div>
        <div class="divBOX">Arrière plan système:<br>
                <?php 
                if ($CIE_GROK_KEY != ""){ echo "<button onclick=\"dw3_prompt_grok_image('imgBG2','txtBG2','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                if ($CIE_GPT_KEY != ""){ echo "<button onclick=\"dw3_prompt_gpt_image('imgBG2','txtBG2','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec ChatGPT AI' class='material-icons'>auto_awesome</span> ChatGPT</button>";}
                ?>
            <input id="txtBG2" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_BG2; ?>">
            <button style='min-width:50px;float:right;' onclick="selBG2('txtBG2');"><img id='imgBG2' src='/pub/img/<?php echo $CIE_BG2; ?>' style='width:250px;height:auto;'> ..</button>
        </div>
        <div class="divBOX">Arrière plan scène:<br>
                <?php 
                if ($CIE_GROK_KEY != ""){ echo "<button onclick=\"dw3_prompt_grok_image('imgBG3','txtBG3','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                if ($CIE_GPT_KEY != ""){ echo "<button onclick=\"dw3_prompt_gpt_image('imgBG3','txtBG3','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec ChatGPT AI' class='material-icons'>auto_awesome</span> ChatGPT</button>";}
                ?>
            <input id="txtBG3" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_BG3; ?>">
            <button style='min-width:50px;float:right;' onclick="selBG3('txtBG3');"><img id='imgBG3' src='/pub/img/<?php echo $CIE_BG3; ?>' style='width:250px;height:auto;'> ..</button>
        </div>
        <div class="divBOX">Arrière plan bas de page:<br>
                <?php 
                if ($CIE_GROK_KEY != ""){ echo "<button onclick=\"dw3_prompt_grok_image('imgBG4','txtBG4','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec Grok AI' class='material-icons'>auto_awesome</span> Grok</button>";}
                if ($CIE_GPT_KEY != ""){ echo "<button onclick=\"dw3_prompt_gpt_image('imgBG4','txtBG4','/pub/img/');\" style='float:right;'><span style='font-size:16px;' title='Générer une image à partir de la description française avec ChatGPT AI' class='material-icons'>auto_awesome</span> ChatGPT</button>";}
                ?>
            <input id="txtBG4" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_BG4; ?>">
            <button style='min-width:50px;float:right;' onclick="selBG4('txtBG4');"><img id='imgBG4' src='/pub/img/<?php echo $CIE_BG4; ?>' style='width:250px;height:auto;'> ..</button>
            <br>Espacement:
            <input id="txtBG4_PAD" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_BG4_PAD; ?>">
        </div>
        <div class="divBOX">Favicon:
            <table class="tblINPUT">
                <tr><td>
                    <img id='imgFAVICON' style="padding:5px;width:250px;height:auto;cursor:pointer;-webkit-user-select: none;" onclick="openFile('fileToFav');" src="/pub/img/favicon.ico?t=<?php echo(rand(100,100000)); ?>" onerror="this.onerror=null; this.src='/pub/img/dw3/nd.png';">
                </td>
                <td style="width:25px;user-select:none;text-align:center;cursor:pointer;">
                    <span style="color:#333333;" onclick="openFile('fileToFav');" class="material-icons">more_horiz</span>
                </td></tr>
            </table>
        </div><hr>
        <div class="divBOX">Câdre de fenêtres:
            <input id="txtFRAME" type="text" style="vertical-align:middle;margin:5px;" value="<?php echo $CIE_FRAME; ?>">
            <button style='min-width:50px;float:right;' onclick="selFRAME('txtFRAME');"><img id='imgFRAME' src='/pub/img/frame/<?php echo $CIE_FRAME; ?>' style='width:250px;height:auto;'> ..</button>
        </div>
        <div class="divBOX">Image derrière le câdre:
            <input id="txtFADER" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_FADE; ?>">
            <button style='min-width:50px;float:right;' onclick="selFADE('txtFADER');"><img id='imgFADE' src='/pub/img/fade/<?php echo $CIE_FADE; ?>' style='width:250px;height:auto;'> ..</button>
        </div>
        <div class="divBOX">Image cookies en bas de page:
            <input id="txtCOOKIES" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_COOKIES_IMG; ?>">
            <button style='min-width:50px;float:right;' onclick="selCOOKIES('txtCOOKIES');"><img id='imgCOOKIES' src='/pub/img/cookies/<?php echo $CIE_COOKIES_IMG; ?>' style='width:250px;height:auto;'> ..</button>
        </div>
        <div class="divBOX">Image de chargement:
            <input id="txtLOAD" type="text" style="vertical-align:middle;margin:5px;" value="<?php echo $CIE_LOAD; ?>">
            <button style='background:#fff;min-width:50px;float:right;' onclick="selLOAD('txtLOAD');"><img id='imgLOAD' src='/pub/img/load/<?php echo $CIE_LOAD; ?>' style='width:75px;height:auto;'> ..</button>
        </div><br>
        <div class="divBOX">Radius des boutons:
            <input id="txtBTN_RAD" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_BTN_RADIUS; ?>">
        </div>
        <div class="divBOX">Ombre des boutons:
            <input id="txtBTN_SHADOW" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_BTN_SHADOW; ?>">
        </div>
        <div class="divBOX">Bordure des boutons:
            <input id="txtBTN_BORDER" type="text" style=" vertical-align:middle;margin:5px;" value="<?php echo $CIE_BTN_BORDER; ?>">
        </div>
        <br><button style='padding:10px;border-radius:4px;font-size:24px;margin:1px;' onclick="updDSP();"><span class="material-icons">save</span>Enregistrer</button>
    </div><br>	
    <div class="divPAGE">
        <br><hr><br><div style="font-weight:bold; width:90%;text-align:left; ">Couleurs</div>
        <div class="divBOX" style="width:auto;">Texte des messages:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR10" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR10??'555555'; ?>"></td>
                </tr>
            </table>
        </div>
        <div class="divBOX" style="width:auto;box-shadow:inset 1px 1px 5px green;">*Menu:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR8" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR8; ?>"></td>
                </tr>
            </table>
        </div>	
        <div class="divBOX" style="width:auto;">Menu dégradé:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR8_2" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR8_2; ?>"></td>
                </tr>
            </table>
        </div>	
        <div class="divBOX" style="width:auto;">Menu bordure du haut:
            <table class="tblINPUT" style="width:200px;">
                <tr>
                    <td width="99"><input  onchange="saveCOLOR(this);" id="cfgCOLOR8_3S" type='number' value="<?php echo $CIE_COLOR8_3S; ?>" style='width:75px;'>px</td>
                    <td><input id="cfgCOLOR8_3" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR8_3; ?>"></td>
                </tr>
            </table>
        </div>	
        <div class="divBOX" style="width:auto;;">Menu bordure du bas:
            <table class="tblINPUT" style="width:200px;">
                <tr>
                    <td width="99"><input  onchange="saveCOLOR(this);" id="cfgCOLOR8_4S" type='number' value="<?php echo $CIE_COLOR8_4S; ?>" style='width:75px;'>px</td>
                    <td><input id="cfgCOLOR8_4" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR8_4; ?>"></td>
                </tr>
            </table>
        </div>	
        <div class="divBOX" style="width:auto;box-shadow:inset 1px 1px 5px green;">*Texte du menu:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR9" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR9; ?>"></td>
                </tr>
            </table>
        </div>
        <div class="divBOX" style="width:auto;">Boutons:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR1" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR1; ?>"></td>
                <tr><td><input id="cfgCOLOR1_2" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR1_2; ?>"></td>
                <tr><td><input id="cfgCOLOR1_3" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR1_3; ?>"></td>
                </tr>
            </table>
        </div>	
        <div class="divBOX" style="width:auto;">Texte des boutons:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR2" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR2; ?>"></td>
                </tr>
            </table>
        </div>
        <div class="divBOX" style="width:auto;">Fenetres:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR3" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR3; ?>"></td>
                </tr>
            </table>
        </div>
        <div class="divBOX" style="width:auto;">Texte des fenetres:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR4" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR4; ?>"></td>
                </tr>
            </table>
        </div>	
        <div class="divBOX" style="width:auto;">*Fond page:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR5" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR5; ?>"></td>
                </tr>
            </table>
        </div>
        <div class="divBOX" style="width:auto;">*Texte de fond page:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR0" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR0; ?>"></td>
                </tr>
            </table>
        </div>
        <div class="divBOX" style="width:auto;">Contour objets pointés:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR0_1" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR0_1; ?>"></td>
                </tr>
            </table>
        </div>
        <div class="divBOX" style="width:auto;box-shadow:inset 1px 1px 5px green;">*Entete de tableau:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR6" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR6; ?>"></td>
                </tr>
            </table>
        </div>	
        <div class="divBOX" style="width:auto;box-shadow:inset 1px 1px 5px green;">*Entete de tableau 2:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR6_2" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR6_2; ?>"></td>
                </tr>
            </table>
        </div>	
        <div class="divBOX" style="width:auto;box-shadow:inset 1px 1px 5px green;">*Texte de l'entete:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR7" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR7; ?>"></td>
                </tr>
            </table>
        </div>
        <div class="divBOX" style="width:auto;box-shadow:inset 1px 1px 5px green;">*Fond tableau 1:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR7_2" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR7_2; ?>"></td>
                </tr>
            </table>
        </div>
        <div class="divBOX" style="width:auto;box-shadow:inset 1px 1px 5px green;">*Fond tableau 2:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR7_3" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR7_3; ?>"></td>
                </tr>
            </table>
        </div>
        <div class="divBOX" style="width:auto;box-shadow:inset 1px 1px 5px green;">*Texte tableau:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR7_4" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR7_4; ?>"></td>
                </tr>
            </table>
        </div>
        <div class="divBOX" style="width:auto;box-shadow:inset 1px 1px 5px green;">Bas de page:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR11_1" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR11_1; ?>"></td>
                </tr>
            </table>
        </div>	
        <div class="divBOX" style="width:auto;">Bas de page dégradé:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR11_2" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR11_2; ?>"></td>
                </tr>
            </table>
        </div>
        <div class="divBOX" style="width:auto;">Texte bas de page:
            <table class="tblINPUT" style="width:200px;">
                <tr><td><input id="cfgCOLOR11_3" onchange="saveCOLOR(this);" type="color" value="#<?php echo $CIE_COLOR11_3; ?>"></td>
                </tr>
            </table>
        </div>
    </div>
    <br><span style='box-shadow:inset 1px 1px 5px green;padding:5px;border-radius:5px;'>*Couleurs aussi utilisés pour d'autres fonctions</span><br>
        <button class="btnTHEME" style="background:red;color:white;" onclick="dftCOLOR();">Couleurs par default</button>
        <button class="btnTHEME" style="background:darkgrey;color:white;" onclick="chgTHEME('dark');">Sombre</button>
        <button class="btnTHEME" style="background:lightgrey;color:black;" onclick="chgTHEME('clear');">Clair</button>
        <button class="btnTHEME" style="background:orange;color:white;" onclick="chgTHEME('orange');">Orange</button>
    <br><br>
    <div class="divPAGE">
        <br><hr><br><div style="font-weight:bold; width:90%;text-align:left; ">Polices de caractères</div>

<?php
    $font_files = [];

    $dir = new RecursiveDirectoryIterator($_SERVER['DOCUMENT_ROOT'] . '/pub/font');
    $files = new RecursiveIteratorIterator($dir);
    //$sorted = new ExampleSortedIterator($files);
    foreach($files as $file){
        $fn=basename($file->getFileName(), ".ttf");
        $font_files[] = $fn;
    }
    sort($font_files, SORT_NATURAL | SORT_FLAG_CASE);
?>
        <div class="divBOX" style="width:auto;word-break: break-word;">Général:
            <select name='cfgFONT1' id='cfgFONT1' oninput='dspFONT1(this.value);' style='width:70%;float:right;margin-top:-5px;'>
                <?php
                    echo "<option "; if ($CIE_FONT1 == "Brush Script MT") {echo "selected";} echo " value='Brush Script MT'>Brush Script MT (Web Safe)</option>";                
                    echo "<option "; if ($CIE_FONT1 == "Consolas") {echo "selected";} echo " value='Consolas'>Consolas (Web Safe)</option>";                
                    echo "<option "; if ($CIE_FONT1 == "Courier New, monospace") {echo "selected";} echo " value='Courier New, monospace'>Courier New (Web Safe)</option>";                
                    echo "<option "; if ($CIE_FONT1 == "Garamond") {echo "selected";} echo " value='Garamond'>Garamond (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT1 == "Georgia") {echo "selected";} echo " value='Georgia'>Georgia (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT1 == "Tahoma") {echo "selected";} echo " value='Tahoma'>Tahoma (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT1 == "Times New Roman") {echo "selected";} echo " value='Times New Roman'>Times New Roman (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT1 == "Trebuchet") {echo "selected";} echo " value='Trebuchet'>Trebuchet (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT1 == "Verdana") {echo "selected";} echo " value='Verdana'>Verdana (Web Safe)</option>";

                    foreach($font_files as $fn){
                        if ($fn!="." && $fn!=".." && $fn!="MaterialIcons-Regular" && $fn!="dw3"){
                            echo "<option "; if ($CIE_FONT1 == $fn) {echo "selected";} echo " value='". $fn ."'>".$fn."</option>";
                        }
                    }
                ?>
            </select>
            <span id='font1_demo' onclick="if (this.style.fontWeight=='bold'){this.style.fontWeight='normal';} else {this.style.fontWeight='bold';}" style='font-size:20px;font-weight:normal;font-family:<?php echo $CIE_FONT1; ?>;'>abcdefghijklmnopqrstuvwxyz 1234567890 ABCDEFGHIJKLMNOPQRSTUVWXYZ !@#$%^&*() éàèçôî.,</span>
        </div>	
        <div class="divBOX" style="width:auto;word-break: break-word;">Menu:
            <select name='cfgFONT2' id='cfgFONT2' oninput='dspFONT2(this.value);' style='width:70%;float:right;margin-top:-5px;'>
            <?php
                    echo "<option "; if ($CIE_FONT2 == "Brush Script MT") {echo "selected";} echo " value='Brush Script MT'>Brush Script MT (Web Safe)</option>";                
                    echo "<option "; if ($CIE_FONT2 == "Consolas") {echo "selected";} echo " value='Consolas'>Consolas (Web Safe)</option>";                
                    echo "<option "; if ($CIE_FONT2 == "Courier New, monospace") {echo "selected";} echo " value='Courier New, monospace'>Courier New (Web Safe)</option>";                
                    echo "<option "; if ($CIE_FONT2 == "Garamond") {echo "selected";} echo " value='Garamond'>Garamond (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT2 == "Georgia") {echo "selected";} echo " value='Georgia'>Georgia (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT2 == "Tahoma") {echo "selected";} echo " value='Tahoma'>Tahoma (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT2 == "Times New Roman") {echo "selected";} echo " value='Times New Roman'>Times New Roman (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT2 == "Trebuchet") {echo "selected";} echo " value='Trebuchet'>Trebuchet (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT2 == "Verdana") {echo "selected";} echo " value='Verdana'>Verdana (Web Safe)</option>";
                    foreach($font_files as $fn){
                        if ($fn!="." && $fn!=".." && $fn!="MaterialIcons-Regular" && $fn!="dw3"){
                            echo "<option "; if ($CIE_FONT2 == $fn) {echo "selected";} echo " value='". $fn ."'>".$fn."</option>";
                        }
                    }
                ?>
            </select>
            <span id='font2_demo' onclick="if (this.style.fontWeight=='bold'){this.style.fontWeight='normal';} else {this.style.fontWeight='bold';}" style='font-size:20px;font-weight:normal;font-family:<?php echo $CIE_FONT2; ?>;'>abcdefghijklmnopqrstuvwxyz 1234567890 ABCDEFGHIJKLMNOPQRSTUVWXYZ !@#$%^&*() éàèçôî.,</span>
        </div><br>
        <div class="divBOX" style="width:auto;word-break: break-word;">Fenêtres:
            <select name='cfgFONT3' id='cfgFONT3' oninput='dspFONT3(this.value);' style='width:70%;float:right;margin-top:-5px;'>
            <?php
                    echo "<option "; if ($CIE_FONT3 == "Brush Script MT") {echo "selected";} echo " value='Brush Script MT'>Brush Script MT (Web Safe)</option>";                
                    echo "<option "; if ($CIE_FONT3 == "Consolas") {echo "selected";} echo " value='Consolas'>Consolas (Web Safe)</option>";                
                    echo "<option "; if ($CIE_FONT3 == "Courier New, monospace") {echo "selected";} echo " value='Courier New, monospace'>Courier New (Web Safe)</option>";                
                    echo "<option "; if ($CIE_FONT3 == "Garamond") {echo "selected";} echo " value='Garamond'>Garamond (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT3 == "Georgia") {echo "selected";} echo " value='Georgia'>Georgia (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT3 == "Tahoma") {echo "selected";} echo " value='Tahoma'>Tahoma (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT3 == "Times New Roman") {echo "selected";} echo " value='Times New Roman'>Times New Roman (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT3 == "Trebuchet") {echo "selected";} echo " value='Trebuchet'>Trebuchet (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT3 == "Verdana") {echo "selected";} echo " value='Verdana'>Verdana (Web Safe)</option>";
                    foreach($font_files as $fn){
                        if ($fn!="." && $fn!=".." && $fn!="MaterialIcons-Regular" && $fn!="dw3"){
                            echo "<option "; if ($CIE_FONT3 == $fn) {echo "selected";} echo " value='". $fn ."'>".$fn."</option>";
                        }
                    }
                ?>
            </select>
            <span id='font3_demo' onclick="if (this.style.fontWeight=='bold'){this.style.fontWeight='normal';} else {this.style.fontWeight='bold';}" style='font-size:20px;font-weight:normal;font-family:<?php echo $CIE_FONT3; ?>;'>abcdefghijklmnopqrstuvwxyz 1234567890 ABCDEFGHIJKLMNOPQRSTUVWXYZ !@#$%^&*() éàèçôî.,</span>
        </div>	
        <div class="divBOX" style="width:auto;word-break: break-word;">Boutons:
            <select name='cfgFONT4' id='cfgFONT4' oninput='dspFONT4(this.value);' style='width:70%;float:right;margin-top:-5px;'>
            <?php
                    echo "<option "; if ($CIE_FONT4 == "Brush Script MT") {echo "selected";} echo " value='Brush Script MT'>Brush Script MT (Web Safe)</option>";                
                    echo "<option "; if ($CIE_FONT4 == "Consolas") {echo "selected";} echo " value='Consolas'>Consolas (Web Safe)</option>";                
                    echo "<option "; if ($CIE_FONT4 == "Courier New, monospace") {echo "selected";} echo " value='Courier New, monospace'>Courier New (Web Safe)</option>";                
                    echo "<option "; if ($CIE_FONT4 == "Garamond") {echo "selected";} echo " value='Garamond'>Garamond (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT4 == "Georgia") {echo "selected";} echo " value='Georgia'>Georgia (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT4 == "Tahoma") {echo "selected";} echo " value='Tahoma'>Tahoma (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT4 == "Times New Roman") {echo "selected";} echo " value='Times New Roman'>Times New Roman (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT4 == "Trebuchet") {echo "selected";} echo " value='Trebuchet'>Trebuchet (Web Safe)</option>";
                    echo "<option "; if ($CIE_FONT4 == "Verdana") {echo "selected";} echo " value='Verdana'>Verdana (Web Safe)</option>";
                    foreach($font_files as $fn){
                        if ($fn!="." && $fn!=".." && $fn!="MaterialIcons-Regular" && $fn!="dw3"){
                            echo "<option "; if ($CIE_FONT4 == $fn) {echo "selected";} echo " value='". $fn ."'>".$fn."</option>";
                        }
                    }
                ?>
            </select>
            <span id='font4_demo' onclick="if (this.style.fontWeight=='bold'){this.style.fontWeight='normal';} else {this.style.fontWeight='bold';}" style='font-size:20px;font-weight:normal;font-family:<?php echo $CIE_FONT4; ?>;'>abcdefghijklmnopqrstuvwxyz 1234567890 ABCDEFGHIJKLMNOPQRSTUVWXYZ !@#$%^&*() éàèçôî.,</span>
        </div>
        <br>
        <button style='padding:7px;border-radius:4px;font-size:24px;margin:1px;' onclick="updFONT();"><span class="material-icons">save</span>Appliquer</button>
        <br>
        <hr>
        <div class="divBOX">
            <div id='divFONTS'></div>
            <div style='text-align:center;font-size:14px;'><button class='blue' onclick="selFONT();"><span class='material-icons'>add</span>Ajouter une police</button> (format .ttf, max 2Mo)</div>
        </div>

    </div>
</div>

<div id='divUPLOAD_IMG' style='display:none;'>
    <form id='frmUPLOAD_IMG' method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToImg" id="fileToImg" onchange="document.getElementById('submitUPLOAD_IMG').click();">    
    <input type="submit" value="Upload Image" name="submit_img" id='submitUPLOAD_IMG'>
    </form>
    <input type="text" id="fileToImgOutput" value=''>
</div>

<div id="divUPLOAD_FAV" style="display:none;">
	<form id="frmFAVICON" method="post" enctype="multipart/form-data">
	  <input type="file" accept="image/*" name="fileToFav" id="fileToFav" onchange="document.getElementById('submitFAVICON').click();document.getElementById('imgFAVICON').src = window.URL.createObjectURL(this.files[0]);">
	  <input type="submit" value="Upload Image" name="submitFAVICON" id="submitFAVICON">
	</form>	
</div>

<script><?php require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/js/main.js.php'; ?></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var dw3_file_replace = "unknow";

$(document).ready(function (){
    document.getElementById('config_select').value="/app/config/config_6_display.php";
    dragElement(document.getElementById('divFILES_MANAGER'));
    getFONTS();
});

window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    window.location.reload();
  }
});

function selFRAME_IMG(target,img) {
	document.getElementById(target).value = img;
	document.getElementById("imgFRAME").src = "/pub/img/frame/"+img;
}

function delFONT(target, fnx) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("font_" + fnx).style.display = "none";
	  }
	};
		xmlhttp.open('GET', 'delFILE.php?KEY=' + KEY + "&fn=" + encodeURIComponent(target) + "&d=font", true);
		xmlhttp.send();	
}

function copyFONT(target) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            addNotif("Police copiée dans le dossier des polices du site");
			getFONTS();
	  }
	};
    xmlhttp.open('GET', 'copyFONT.php?KEY=' + KEY + "&fn=" + encodeURIComponent(target), true);
    xmlhttp.send();	
}

function getFONTS() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divFONTS").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getFONTS.php?KEY=' + KEY, true);
    xmlhttp.send();	
}

function selFONT() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divFADE2").style.display = "inline-block";
            document.getElementById("divFADE2").style.opacity = "0.6";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'selFONT.php?KEY=' + KEY, true);
    xmlhttp.send();	
}


function selFRAME(target) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divFADE2").style.display = "inline-block";
            document.getElementById("divFADE2").style.opacity = "0.6";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getFRAME.php?KEY=' + KEY + "&TARGET=" + target, true);
		xmlhttp.send();	
}
function selLOGO1_IMG(target,img) {document.getElementById(target).value = img;document.getElementById("imgLOGO1").src = "/pub/img/"+img;}
function selLOGO1(target) {dw3_file_replace = "unknow";	var xmlhttp = new XMLHttpRequest();	xmlhttp.onreadystatechange = function() {	  if (this.readyState == 4 && this.status == 200) {		    document.getElementById("fileToImgOutput").value = "imgLOGO1";	        document.getElementById("divFADE2").style.display = "inline-block";document.getElementById("divFADE2").style.opacity = "0.6";			document.getElementById("divMSG").style.display = "inline-block";			document.getElementById("divMSG").innerHTML = this.responseText;	  }	};		xmlhttp.open('GET', 'getLOGO1.php?KEY=' + KEY + "&TARGET=" + target, true);		xmlhttp.send();	}
function selLOGO2_IMG(target,img) {document.getElementById(target).value = img;document.getElementById("imgLOGO2").src = "/pub/img/"+img;}
function selLOGO2(target) {dw3_file_replace = "unknow";	var xmlhttp = new XMLHttpRequest();	xmlhttp.onreadystatechange = function() {	  if (this.readyState == 4 && this.status == 200) {		    document.getElementById("fileToImgOutput").value = "imgLOGO2";			document.getElementById("divFADE2").style.display = "inline-block";document.getElementById("divFADE2").style.opacity = "0.6";			document.getElementById("divMSG").style.display = "inline-block";			document.getElementById("divMSG").innerHTML = this.responseText;	  }	};		xmlhttp.open('GET', 'getLOGO2.php?KEY=' + KEY + "&TARGET=" + target, true);		xmlhttp.send();	}
function selLOGO3_IMG(target,img) {document.getElementById(target).value = img;document.getElementById("imgLOGO3").src = "/pub/img/"+img;}
function selLOGO3(target) {dw3_file_replace = "unknow";	var xmlhttp = new XMLHttpRequest();	xmlhttp.onreadystatechange = function() {	  if (this.readyState == 4 && this.status == 200) {		    document.getElementById("fileToImgOutput").value = "imgLOGO3";			document.getElementById("divFADE2").style.display = "inline-block";document.getElementById("divFADE2").style.opacity = "0.6";			document.getElementById("divMSG").style.display = "inline-block";			document.getElementById("divMSG").innerHTML = this.responseText;	  }	};		xmlhttp.open('GET', 'getLOGO3.php?KEY=' + KEY + "&TARGET=" + target, true);		xmlhttp.send();	}
function selLOGO4_IMG(target,img) {document.getElementById(target).value = img;document.getElementById("imgLOGO4").src = "/pub/img/"+img;}
function selLOGO4(target) {dw3_file_replace = "unknow";	var xmlhttp = new XMLHttpRequest();	xmlhttp.onreadystatechange = function() {	  if (this.readyState == 4 && this.status == 200) {		    document.getElementById("fileToImgOutput").value = "imgLOGO4";			document.getElementById("divFADE2").style.display = "inline-block";document.getElementById("divFADE2").style.opacity = "0.6";			document.getElementById("divMSG").style.display = "inline-block";			document.getElementById("divMSG").innerHTML = this.responseText;	  }	};		xmlhttp.open('GET', 'getLOGO4.php?KEY=' + KEY + "&TARGET=" + target, true);		xmlhttp.send();	}
function selLOGO5_IMG(target,img) {document.getElementById(target).value = img;document.getElementById("imgLOGO5").src = "/pub/img/"+img;}
function selLOGO5(target) {dw3_file_replace = "unknow";	var xmlhttp = new XMLHttpRequest();	xmlhttp.onreadystatechange = function() {	  if (this.readyState == 4 && this.status == 200) {		    document.getElementById("fileToImgOutput").value = "imgLOGO5";			document.getElementById("divFADE2").style.display = "inline-block";document.getElementById("divFADE2").style.opacity = "0.6";			document.getElementById("divMSG").style.display = "inline-block";			document.getElementById("divMSG").innerHTML = this.responseText;	  }	};		xmlhttp.open('GET', 'getLOGO5.php?KEY=' + KEY + "&TARGET=" + target, true);		xmlhttp.send();	}

function selBG1_IMG(target,img) {document.getElementById(target).value = img;document.getElementById("imgBG1").src = "/pub/img/"+img;}
function selBG1(target) {dw3_file_replace = "unknow";	var xmlhttp = new XMLHttpRequest();	xmlhttp.onreadystatechange = function() {	  if (this.readyState == 4 && this.status == 200) {		    document.getElementById("fileToImgOutput").value = "imgBG1";			document.getElementById("divFADE2").style.display = "inline-block";document.getElementById("divFADE2").style.opacity = "0.6";			document.getElementById("divMSG").style.display = "inline-block";			document.getElementById("divMSG").innerHTML = this.responseText;	  }	};		xmlhttp.open('GET', 'getBG1.php?KEY=' + KEY + "&TARGET=" + target, true);		xmlhttp.send();	}
function selBG2_IMG(target,img) {document.getElementById(target).value = img;document.getElementById("imgBG2").src = "/pub/img/"+img;}
function selBG2(target) {dw3_file_replace = "unknow";	var xmlhttp = new XMLHttpRequest();	xmlhttp.onreadystatechange = function() {	  if (this.readyState == 4 && this.status == 200) {		    document.getElementById("fileToImgOutput").value = "imgBG2";			document.getElementById("divFADE2").style.display = "inline-block";document.getElementById("divFADE2").style.opacity = "0.6";			document.getElementById("divMSG").style.display = "inline-block";			document.getElementById("divMSG").innerHTML = this.responseText;	  }	};		xmlhttp.open('GET', 'getBG2.php?KEY=' + KEY + "&TARGET=" + target, true);		xmlhttp.send();	}
function selBG3_IMG(target,img) {document.getElementById(target).value = img;document.getElementById("imgBG3").src = "/pub/img/"+img;}
function selBG3(target) {dw3_file_replace = "unknow";	var xmlhttp = new XMLHttpRequest();	xmlhttp.onreadystatechange = function() {	  if (this.readyState == 4 && this.status == 200) {		    document.getElementById("fileToImgOutput").value = "imgBG3";			document.getElementById("divFADE2").style.display = "inline-block";document.getElementById("divFADE2").style.opacity = "0.6";			document.getElementById("divMSG").style.display = "inline-block";			document.getElementById("divMSG").innerHTML = this.responseText;	  }	};		xmlhttp.open('GET', 'getBG3.php?KEY=' + KEY + "&TARGET=" + target, true);		xmlhttp.send();	}
function selBG4_IMG(target,img) {document.getElementById(target).value = img;document.getElementById("imgBG4").src = "/pub/img/"+img;}
function selBG4(target) {dw3_file_replace = "unknow";	var xmlhttp = new XMLHttpRequest();	xmlhttp.onreadystatechange = function() {	  if (this.readyState == 4 && this.status == 200) {		    document.getElementById("fileToImgOutput").value = "imgBG4";			document.getElementById("divFADE2").style.display = "inline-block";document.getElementById("divFADE2").style.opacity = "0.6";			document.getElementById("divMSG").style.display = "inline-block";			document.getElementById("divMSG").innerHTML = this.responseText;	  }	};		xmlhttp.open('GET', 'getBG4.php?KEY=' + KEY + "&TARGET=" + target, true);		xmlhttp.send();	}
function selBG5_IMG(target,img) {document.getElementById(target).value = img;document.getElementById("imgBG5").src = "/pub/img/"+img;}
function selBG5(target) {dw3_file_replace = "unknow";	var xmlhttp = new XMLHttpRequest();	xmlhttp.onreadystatechange = function() {	  if (this.readyState == 4 && this.status == 200) {		    document.getElementById("fileToImgOutput").value = "imgBG5";			document.getElementById("divFADE2").style.display = "inline-block";document.getElementById("divFADE2").style.opacity = "0.6";			document.getElementById("divMSG").style.display = "inline-block";			document.getElementById("divMSG").innerHTML = this.responseText;	  }	};		xmlhttp.open('GET', 'getBG5.php?KEY=' + KEY + "&TARGET=" + target, true);		xmlhttp.send();	}


function selCOOKIES_IMG(target,img) {
	document.getElementById(target).value = img;
	document.getElementById("imgCOOKIES").src = "/pub/img/cookies/"+img;
}

function selCOOKIES(target) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            document.getElementById("divFADE2").style.opacity = "0.6";
            document.getElementById("divFADE2").style.display = "inline-block";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getCOOKIES_IMG.php?KEY=' + KEY + "&TARGET=" + target, true);
		xmlhttp.send();	
}
function selFADE_IMG(target,img) {
	document.getElementById(target).value = img;
	document.getElementById("imgFADE").src = "/pub/img/fade/"+img;
}

function selFADE(target) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
            document.getElementById("divFADE2").style.opacity = "0.6";
			document.getElementById("divFADE2").style.display = "inline-block";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getFADE.php?KEY=' + KEY + "&TARGET=" + target, true);
		xmlhttp.send();	
}
function selLOAD_IMG(target,img) {
	document.getElementById(target).value = img;
	document.getElementById("imgLOAD").src = "/pub/img/load/"+img;
}

function selLOAD(target) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
			document.getElementById("divFADE2").style.display = "inline-block";
            document.getElementById("divFADE2").style.opacity = "0.6";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText;
	  }
	};
		xmlhttp.open('GET', 'getLOAD.php?KEY=' + KEY + "&TARGET=" + target, true);
		xmlhttp.send();	
}
function closeAudioVideo() {
    var audio = document.getElementById('audioUPLOAD');
    audio.pause();
    var video = document.getElementById('videoUPLOAD');
    video.pause();
}
function getFILE_OPT(fn) {
    var fileExt = fn.split('.').pop().toLowerCase();
    document.getElementById("divFADE").style.display = "inline-block";
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
        document.getElementById("imgUPLOAD").src = "/pub/img/"+fn;
    }
    document.getElementById("imgUPLOAD").src = "/pub/img/"+fn;
    document.getElementById("txtUPLOAD_FN").value = fn;
    document.getElementById("txtUPLOAD_RENAME").value = fn;
}
function closeFILES_MANAGER() {
    document.getElementById("divFILES_MANAGER").style.display = "none";
	document.getElementById("divFADE").style.opacity = "0";
    setTimeout(function () {
    document.getElementById("divFADE").style.display = "none";

    }, 500);
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
	  }
	};
    xmlhttp.open('GET', 'getFILES.php?KEY=' + KEY + "&DIR=img", true);
    xmlhttp.send();
}
function closeMSG2(){
    document.getElementById("divMSG2").style.display = "none";
	if (document.getElementById("divFILES_MANAGER").style.display != "inline-block") {
		    document.getElementById("divFADE").style.opacity = "0";
        setTimeout(function () {
		document.getElementById("divFADE").style.display = "none";

		}, 500);
	}
    closeAudioVideo();
}
function delIMG(fn) {
    if (fn == undefined){
       fn = document.getElementById("txtUPLOAD_FN").value;
    }
	document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("divFADE").style.opacity = "0.6";
	document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "Êtes-vous certain de vouloir supprimer le fichier du serveur? <br>Le fichier peur-être utilisé dans une des pages ou sections du site. <br> Cette action est irréversible.<div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span>Annuler</button> <button class='red' onclick=\"closeMSG();deleteIMG('"+fn+"')\"><span class='material-icons' style='vertical-align:middle;'>done</span> Supprimer définitivement </button>";
}
function deleteIMG(fn) {
    closeAudioVideo();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "1"){
            addNotif("Média supprimé du dossier /pub/img");
            openFILES_MANAGER();
            closeMSG2();
        } else {
			document.getElementById("divFADE").style.display = "inline-block";
            document.getElementById("divFADE").style.opacity = "0.6";
			document.getElementById("divMSG").style.display = "inline-block";
			document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok </button>";
        }
	  }
	};
    xmlhttp.open('GET', 'delFILE.php?KEY=' + KEY + "&fn=" + encodeURIComponent(fn) + "&d=img", true);
    xmlhttp.send();
}

function updDSP(){
	var sLOGO1 = document.getElementById("txtLOGO1").value;
	var sLOGO2 = document.getElementById("txtLOGO2").value;
	var sLOGO3 = document.getElementById("txtLOGO3").value;
	var sLOGO4 = document.getElementById("txtLOGO4").value;
	var sLOGO5 = document.getElementById("txtLOGO5").value;
	var sBG1 = document.getElementById("txtBG1").value;
	var sBG2 = document.getElementById("txtBG2").value;
	var sBG3 = document.getElementById("txtBG3").value;
	var sBG4 = document.getElementById("txtBG4").value;
	var sBG4_PAD = document.getElementById("txtBG4_PAD").value;
	var sBG5 = document.getElementById("txtBG5").value;
	var sCOOKIES = document.getElementById("txtCOOKIES").value;
	var sLOAD = document.getElementById("txtLOAD").value;
	var sFRAME = document.getElementById("txtFRAME").value;
	var sFADE = document.getElementById("txtFADER").value;
	var sBTN_RAD = document.getElementById("txtBTN_RAD").value;
	var sBTN_SHADOW = document.getElementById("txtBTN_SHADOW").value;
	var sBTN_BORDER = document.getElementById("txtBTN_BORDER").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		addNotif(this.responseText);
		//selectCONFIG();
	  }
	};
	xmlhttp.open('GET', 'updDSP.php?KEY=' + KEY 
										+ '&L1=' 	+ encodeURIComponent(sLOGO1)
										+ '&L2=' 	+ encodeURIComponent(sLOGO2)
										+ '&L3=' 	+ encodeURIComponent(sLOGO3)
										+ '&L4=' 	+ encodeURIComponent(sLOGO4)
										+ '&L5=' 	+ encodeURIComponent(sLOGO5)
										+ '&B1=' 	+ encodeURIComponent(sBG1)
										+ '&B2=' 	+ encodeURIComponent(sBG2)
										+ '&B3=' 	+ encodeURIComponent(sBG3)
										+ '&B4=' 	+ encodeURIComponent(sBG4)
										+ '&B4_PAD=' 	+ encodeURIComponent(sBG4_PAD)
										+ '&B5=' 	+ encodeURIComponent(sBG5)
										+ '&F=' 	+ encodeURIComponent(sFRAME)
										+ '&A=' 	+ encodeURIComponent(sFADE)
										+ '&L=' 	+ encodeURIComponent(sLOAD)
										+ '&C=' 	+ encodeURIComponent(sCOOKIES)
										+ '&R=' 	+ encodeURIComponent(sBTN_RAD)
										+ '&S=' 	+ encodeURIComponent(sBTN_SHADOW)
										+ '&B=' 	+ encodeURIComponent(sBTN_BORDER)
										,true);
		xmlhttp.send();
}


//ajout dun code de configuration
function dspFONT1(font_name){
    document.getElementById("font1_demo").style.fontFamily=font_name;
}
function dspFONT2(font_name){
    document.getElementById("font2_demo").style.fontFamily=font_name;
}
function dspFONT3(font_name){
    document.getElementById("font3_demo").style.fontFamily=font_name;
}
function dspFONT4(font_name){
    document.getElementById("font4_demo").style.fontFamily=font_name;
}
function updFONT(){
	
	var GRPBOX  = document.getElementById("cfgFONT1");
	var sFN1  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("cfgFONT2");
	var sFN2  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("cfgFONT3");
	var sFN3  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("cfgFONT4");
	var sFN4  = GRPBOX.options[GRPBOX.selectedIndex].value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		addNotif(this.responseText);
		//selectCONFIG();
	  }
	};

		xmlhttp.open('GET', 'updFONT.php?KEY=' + KEY 
										+ '&F1=' 	+ sFN1
										+ '&F2=' 	+ sFN2
										+ '&F3=' 	+ sFN3
										+ '&F4=' 	+ sFN4,
										true);
		xmlhttp.send();
}

function saveCOLOR(){
	var sCOLOR1= document.getElementById("cfgCOLOR1").value.substr(1,6);
	var sCOLOR1_2= document.getElementById("cfgCOLOR1_2").value.substr(1,6);
	var sCOLOR1_3= document.getElementById("cfgCOLOR1_3").value.substr(1,6);
	var sCOLOR2= document.getElementById("cfgCOLOR2").value.substr(1,6);
	var sCOLOR3= document.getElementById("cfgCOLOR3").value.substr(1,6);
	var sCOLOR4= document.getElementById("cfgCOLOR4").value.substr(1,6);
	var sCOLOR5= document.getElementById("cfgCOLOR5").value.substr(1,6);
	var sCOLOR0= document.getElementById("cfgCOLOR0").value.substr(1,6);
	var sCOLOR0_1= document.getElementById("cfgCOLOR0_1").value.substr(1,6);
	var sCOLOR6= document.getElementById("cfgCOLOR6").value.substr(1,6);
	var sCOLOR6_2= document.getElementById("cfgCOLOR6_2").value.substr(1,6);
	var sCOLOR7= document.getElementById("cfgCOLOR7").value.substr(1,6);
	var sCOLOR7_2= document.getElementById("cfgCOLOR7_2").value.substr(1,6);
	var sCOLOR7_3= document.getElementById("cfgCOLOR7_3").value.substr(1,6);
	var sCOLOR7_4= document.getElementById("cfgCOLOR7_4").value.substr(1,6);
	var sCOLOR8= document.getElementById("cfgCOLOR8").value.substr(1,6);
	var sCOLOR8_2= document.getElementById("cfgCOLOR8_2").value.substr(1,6);
	var sCOLOR8_3= document.getElementById("cfgCOLOR8_3").value.substr(1,6);
	var sCOLOR8_4= document.getElementById("cfgCOLOR8_4").value.substr(1,6);
	var sCOLOR8_3S= document.getElementById("cfgCOLOR8_3S").value;
	var sCOLOR8_4S= document.getElementById("cfgCOLOR8_4S").value;
	var sCOLOR9= document.getElementById("cfgCOLOR9").value.substr(1,6);
	var sCOLOR10= document.getElementById("cfgCOLOR10").value.substr(1,6);
	var sCOLOR11_1= document.getElementById("cfgCOLOR11_1").value.substr(1,6);
	var sCOLOR11_2= document.getElementById("cfgCOLOR11_2").value.substr(1,6);
	var sCOLOR11_3= document.getElementById("cfgCOLOR11_3").value.substr(1,6);
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == "0"){
                addNotif("<?php echo $dw3_lbl["SAVE_DONE"];?>");
				//BUTTONS
				var allTAGS = document.getElementsByTagName("button");
				for (var i=0, max=allTAGS.length; i < max; i++) {
					if (allTAGS[i].className != "btnTHEME"){
					 allTAGS[i].style.background = "#" + sCOLOR1;
					 allTAGS[i].style.color = "#" + sCOLOR2;
					}
				}
				//FENETRES
				var allTAGS = document.getElementsByClassName("divMAIN");
				for (var i=0, max=allTAGS.length; i < max; i++) {
					 allTAGS[i].style.background = "#" + sCOLOR3;
					 allTAGS[i].style.color = "#" + sCOLOR4;
				}	
				//TABLEAUX
				var allTAGS = document.getElementsByTagName("th");
				for (var i=0, max=allTAGS.length; i < max; i++) {
					 allTAGS[i].style.background = "#" + sCOLOR6;
					 allTAGS[i].style.color = "#" + sCOLOR7;
				}	
				//body.style.background = "#" + sCOLOR5;			
				
		  } else {
				addMsg(this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		  } 
	  }
	};
		xmlhttp.open('GET', 'updCFG_COLORS.php?KEY=' + KEY  
										+ '&COLOR1=' + sCOLOR1
										+ '&COLOR1_2=' + sCOLOR1_2
										+ '&COLOR1_3=' + sCOLOR1_3
										+ '&COLOR2=' + sCOLOR2
										+ '&COLOR3=' + sCOLOR3
										+ '&COLOR4=' + sCOLOR4
										+ '&COLOR5=' + sCOLOR5
										+ '&COLOR0=' + sCOLOR0
										+ '&COLOR0_1=' + sCOLOR0_1
										+ '&COLOR6=' + sCOLOR6
										+ '&COLOR6_2=' + sCOLOR6_2
										+ '&COLOR7=' + sCOLOR7
										+ '&COLOR7_2=' + sCOLOR7_2
										+ '&COLOR7_3=' + sCOLOR7_3
										+ '&COLOR7_4=' + sCOLOR7_4
										+ '&COLOR8=' + sCOLOR8
										+ '&COLOR8_2=' + sCOLOR8_2
										+ '&COLOR8_3=' + sCOLOR8_3
										+ '&COLOR8_4=' + sCOLOR8_4
										+ '&COLOR8_3S=' + sCOLOR8_3S
										+ '&COLOR8_4S=' + sCOLOR8_4S
										+ '&COLOR9=' + sCOLOR9
										+ '&COLOR10=' + sCOLOR10
										+ '&COLOR11_1=' + sCOLOR11_1
										+ '&COLOR11_2=' + sCOLOR11_2
										+ '&COLOR11_3=' + sCOLOR11_3
										,true);
		xmlhttp.send();
}
function dftCOLOR(){
document.getElementById("cfgCOLOR1").value = "#FF0000";
document.getElementById("cfgCOLOR2").value = "#FFFFFF";
document.getElementById("cfgCOLOR3").value = "#DDDDDD";
document.getElementById("cfgCOLOR4").value = "#000000";
document.getElementById("cfgCOLOR5").value = "#FFFFFF";
document.getElementById("cfgCOLOR6").value = "#04AA6D";
document.getElementById("cfgCOLOR7").value = "#FFFFFF";
document.getElementById("cfgCOLOR8").value = "#FFFFFF";
document.getElementById("cfgCOLOR9").value = "#333333";

	var sCOLOR1= document.getElementById("cfgCOLOR1").value.substr(1,6);
	var sCOLOR2= document.getElementById("cfgCOLOR2").value.substr(1,6);
	var sCOLOR3= document.getElementById("cfgCOLOR3").value.substr(1,6);
	var sCOLOR4= document.getElementById("cfgCOLOR4").value.substr(1,6);
	var sCOLOR5= document.getElementById("cfgCOLOR5").value.substr(1,6);
	var sCOLOR6= document.getElementById("cfgCOLOR6").value.substr(1,6);
	var sCOLOR7= document.getElementById("cfgCOLOR7").value.substr(1,6);
	var sCOLOR8= document.getElementById("cfgCOLOR8").value.substr(1,6);
	var sCOLOR9= document.getElementById("cfgCOLOR9").value.substr(1,6);
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == "0"){
				document.getElementById("divFADE2").style.opacity = "0.6";
                document.getElementById("divFADE2").style.display = "inline-block";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "Sauvegarde réussi.<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
				//BUTTONS
				var allTAGS = document.getElementsByTagName("button");
				for (var i=0, max=allTAGS.length; i < max; i++) {
					if (allTAGS[i].className != "btnTHEME"){
					 allTAGS[i].style.background = "#" + sCOLOR1;
					 allTAGS[i].style.color = "#" + sCOLOR2;
					}
				}
				//FENETRES
				var allTAGS = document.getElementsByClassName("divMAIN");
				for (var i=0, max=allTAGS.length; i < max; i++) {
					 allTAGS[i].style.background = "#" + sCOLOR3;
					 allTAGS[i].style.color = "#" + sCOLOR4;
				}	
				//body.style.background = "#" + sCOLOR5;				
				
		  } else {
				document.getElementById("divFADE2").style.opacity = "0.6";
                document.getElementById("divFADE2").style.display = "inline-block";
				document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updCFG_COLORS.php?KEY=' + KEY 
										+ '&COLOR1=' + sCOLOR1
										+ '&COLOR2=' + sCOLOR2
										+ '&COLOR3=' + sCOLOR3
										+ '&COLOR4=' + sCOLOR4
										+ '&COLOR5=' + sCOLOR5
										+ '&COLOR6=' + sCOLOR6
										+ '&COLOR7=' + sCOLOR7
										+ '&COLOR8=' + sCOLOR8
										+ '&COLOR9=' + sCOLOR9,
										true);
		xmlhttp.send();
}
function openFile(that){
	document.getElementById(that).click();
}

$("#frmFAVICON").submit(function (e)
        {
            e.preventDefault();
            var fileInput = document.getElementById('fileToImg'); 
            var form_data = new FormData(this);
            $.ajax({
                url: 'upload_FAVICON.php?KEY=<?php echo $KEY;?>&REPLACE='+dw3_file_replace, 
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (response)
                    {
                        //document.getElementById("divFADE2").style.opacity = "1";
                        //document.getElementById("divFADE2").style.display = "inline-block";
                        //document.getElementById("divMSG").style.display = "inline-block";
                        //document.getElementById("divMSG").innerHTML = response + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        addNotif(response);
                        fileInput.value = null;
                        closeMSG();
                    },
                error: function ()
                    {
                        document.getElementById("divFADE2").style.opacity = "0.6";
                        document.getElementById("divFADE2").style.display = "inline-block";
                        document.getElementById("divMSG").style.display = "inline-block";
                        document.getElementById("divMSG").innerHTML = response + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        fileInput.value = null;

                    }
            });
    });
    $("#frmUPLOAD_IMG").submit(function (e)
        {
            e.preventDefault();
            e.stopImmediatePropagation();
            sendUPLOAD_IMG();
    });

function sendUPLOAD_IMG(){
            var target = document.getElementById('fileToImgOutput').value;
            var fileInput = document.getElementById('fileToImg');   
            var filename = fileInput.files[0].name;
            var form_data = new FormData(document.getElementById('frmUPLOAD_IMG'));
            $.ajax({
                url: 'upload_img.php?KEY=<?php echo $KEY;?>&REPLACE='+dw3_file_replace, 
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (response)
                    {
                        if (response == "ErrX"){
                            document.getElementById("divMSG").style.display = "inline-block";
                            document.getElementById("divMSG").innerHTML = "Le fichier est déjà existant, voulez-vous le conserver ou le remplacer?<div style='height:20px;'> </div><button class='grey' onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>undo</span> Conserver</button> <button class='blue' onclick=\"closeMSG();dw3_file_replace='yes';sendUPLOAD_IMG();\"><span class='material-icons' style='vertical-align:middle;'>published_with_changes</span> Remplacer</button>";
                        } else {
                            if (target == "imgLOGO1"){document.getElementById("txtLOGO1").value = filename;}
                            if (target == "imgLOGO2"){document.getElementById("txtLOGO2").value = filename;}
                            if (target == "imgLOGO3"){document.getElementById("txtLOGO3").value = filename;}
                            if (target == "imgLOGO4"){document.getElementById("txtLOGO4").value = filename;}
                            if (target == "imgLOGO5"){document.getElementById("txtLOGO5").value = filename;}
                            if (target == "imgBG1"){document.getElementById("txtBG1").value = filename;}
                            if (target == "imgBG2"){document.getElementById("txtBG2").value = filename;}
                            if (target == "imgBG3"){document.getElementById("txtBG3").value = filename;}
                            if (target == "imgBG4"){document.getElementById("txtBG4").value = filename;}
                            if (target == "imgBG5"){document.getElementById("txtBG5").value = filename;}
                            document.getElementById(target).src = "/pub/img/"+filename;
                            addNotif(response);
                            fileInput.value = null;
                            closeMSG();
                        }
                        //document.getElementById("divFADE2").style.opacity = "1";
                        //document.getElementById("divFADE2").style.display = "inline-block";
                        //document.getElementById("divMSG").style.display = "inline-block";
                        //document.getElementById("divMSG").innerHTML = response + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                    },
                error: function ()
                    {
                        document.getElementById("divFADE2").style.opacity = "0.6";
                        document.getElementById("divFADE2").style.display = "inline-block";
                        document.getElementById("divMSG").style.display = "inline-block";
                        document.getElementById("divMSG").innerHTML = response + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
                        fileInput.value = null;
                    }
            });
}

</script>

</body>
</html>
<?php $dw3_conn->close();exit(); ?>
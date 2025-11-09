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
$APNAME = "Infos générales & Facturation";
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';

$sql = "SELECT code,text2,text3 FROM config 
WHERE kind = 'CIE' AND code = 'NOM_HTML' ";
$result = mysqli_query($dw3_conn, $sql);
$PROFIL_SLOGAN_FR = "";
$PROFIL_SLOGAN_EN = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       if ($row["code"]=="NOM_HTML" && trim($row["text2"]) != ""){$PROFIL_SLOGAN_FR = trim($row["text2"]);}
       if ($row["code"]=="NOM_HTML" && trim($row["text3"]) != ""){$PROFIL_SLOGAN_EN = trim($row["text3"]);}
    }
}

?>
<div id="divHEAD">
	<table style="width:100%;margin:0px;white-space:nowrap;margin-top:5px;">
		<tr style="margin:0px;padding:0px;">
			<td width="*">
                <select id="config_select" onchange="window.open(this.value+'?KEY='+KEY,'_self')">
                    <option value="/app/config/config.php"> Tableau de Bord </option>
                    <option selected value="/app/config/config_1_info.php"> Infos générales & Facturation </option>
                    <option value="/app/config/config_2_location.php"> Adresses et Divisions </option>
                    <option value="/app/config/config_3_structure.php"> Structure de l'entreprise </option>
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

<div class="divMAIN" style="padding-top:50px;">
    <div class='divPAGE'>
        <div class="divBOX"><?php echo $dw3_lbl["NAME"]; ?>:
            <input id="cfgNOM" type="text" value="<?php echo $CIE_NOM; ?>" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Nom sur le menu (HTML):
            <input id="cfgNOM_HTML" type="text" value="<?php echo $CIE_NOM_HTML; ?>" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Année d'ouverture de la compagnie:
            <input id="cfgDOUV" type="number" value="<?php echo $CIE_DOUV; ?>" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Site web: <img style='height:16px;width:auto;' src='https://s2.googleusercontent.com/s2/favicons?domain=<?php echo trim($CIE_HOME); ?>'>
            <input id='cfgHOME' type="text" value="<?php echo $CIE_HOME; ?>" onclick="detectCLICK(event,this);">
        </div>
        <br>
        <div class="divBOX">Téléphone principal:
            <input id='cfgTEL1' type="text" value="<?php echo $CIE_TEL1; ?>" onclick="detectCLICK(event,this);">
        </div>		
        <div class="divBOX">Téléphone sans frais:
            <input id='cfgTEL2' type="text" value="<?php echo $CIE_TEL2; ?>" onclick="detectCLICK(event,this);">
        </div>	<hr>
        Ces quatres courriels peuvent être la même adresse de provenance, si elles se terminent par <u>@<?php echo $_SERVER["SERVER_NAME"]; ?></u>.
        <div class="divBOX">Courriel Info:
            <input id='cfgEML1' type="text" value="<?php echo $CIE_EML1; ?>" onclick="detectCLICK(event,this);">
            <small>Doit se terminer par @<?php echo $_SERVER["SERVER_NAME"]; ?></small>
        </div>	
        <div class="divBOX">Courriel Finance:
            <input id='cfgEML2' type="text" value="<?php echo $CIE_EML2; ?>" onclick="detectCLICK(event,this);">
            <small>Doit se terminer par @<?php echo $_SERVER["SERVER_NAME"]; ?></small>
        </div>
        <div class="divBOX">Courriel pour nouvelles commandes:
            <input id='cfgEML3' type="text" value="<?php echo $CIE_EML3; ?>" onclick="detectCLICK(event,this);">
            <small>Peut être un courriel externe.</small>
        </div>	
        <div class="divBOX">Courriel pour nouveaux documents complétés et approuver les commentaires:
            <input id='cfgEML4' type="text" value="<?php echo $CIE_EML4; ?>" onclick="detectCLICK(event,this);">
            <small>Peut être un courriel externe.</small>
        </div><hr>
        <div class="divBOX">Slogan FR:
            <?php if ($CIE_DEEPL_KEY != ""){ ?> <button style='float:right;padding:4px 8px;' onclick="dw3_translate('cfgSLOGAN','fr','en','cfgSLOGAN_EN');"><span class="material-icons" style='font-size:12px;'>translate</span> fr->en</button><?php } ?>
            <textarea id='cfgSLOGAN_FR'><?php echo $PROFIL_SLOGAN_FR; ?></textarea>
        </div>
        <div class="divBOX">Slogan EN:
            <?php if ($CIE_DEEPL_KEY != ""){ ?> <button style='float:right;padding:4px 8px;' onclick="dw3_translate('cfgSLOGAN_EN','en','fr','cfgSLOGAN');"><span class="material-icons" style='font-size:12px;'>translate</span> en->fr</button><?php } ?>
            <textarea id='cfgSLOGAN_EN'><?php echo $PROFIL_SLOGAN_EN; ?></textarea>
        </div>
        <hr>
        <div class="divBOX"><h3>Lundi</h3>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:50%;text-align:right;'><button class='red' onclick="setOPENING('1','closed');"><span class="material-icons">event_busy</span> Fermé</button></div><div style='width:50%;text-align:left;'><button class='green' onclick="setOPENING('1','24h');"><span class="material-icons">event_available</span> 24H</button></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture:</div><div style='float:right;'><input id='cfgOPEN_J1_H1' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J1_H1,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture:</div><div style='float:right;'><input id='cfgOPEN_J1_H2' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J1_H2,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture 2:</div><div style='float:right;'><input id='cfgOPEN_J1_H3' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J1_H3,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture 2:</div><div style='float:right;'><input id='cfgOPEN_J1_H4' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J1_H4,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;font-size:15px;'>Remplacer par (FR):</div><div style='float:right;'><input type='text' id='cfgOPEN_J1_FR' value='<?php echo $CIE_OPEN_J1_FR;?>'></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (EN):</div><div style='float:right;'><input type='text' id='cfgOPEN_J1_EN' value='<?php echo $CIE_OPEN_J1_EN;?>'></div></div>
        </div>
        <div class="divBOX"><h3>Mardi</h3>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:50%;text-align:right;'><button class='red' onclick="setOPENING('2','closed');"><span class="material-icons">event_busy</span> Fermé</button></div><div style='width:50%;text-align:left;'><button class='green' onclick="setOPENING('2','24h');"><span class="material-icons">event_available</span> 24H</button></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture:</div><div style='float:right;'><input id='cfgOPEN_J2_H1' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J2_H1,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture:</div><div style='float:right;'><input id='cfgOPEN_J2_H2' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J2_H2,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture 2:</div><div style='float:right;'><input id='cfgOPEN_J2_H3' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J2_H3,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture 2:</div><div style='float:right;'><input id='cfgOPEN_J2_H4' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J2_H4,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (FR):</div><div style='float:right;'><input type='text' id='cfgOPEN_J2_FR' value='<?php echo $CIE_OPEN_J2_FR;?>'></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (EN):</div><div style='float:right;'><input type='text' id='cfgOPEN_J2_EN' value='<?php echo $CIE_OPEN_J2_EN;?>'></div></div>
        </div>
        <div class="divBOX"><h3>Mercredi</h3>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:50%;text-align:right;'><button class='red' onclick="setOPENING('3','closed');"><span class="material-icons">event_busy</span> Fermé</button></div><div style='width:50%;text-align:left;'><button class='green' onclick="setOPENING('3','24h');"><span class="material-icons">event_available</span> 24H</button></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture:</div><div style='float:right;'><input id='cfgOPEN_J3_H1' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J3_H1,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture:</div><div style='float:right;'><input id='cfgOPEN_J3_H2' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J3_H2,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture 2</div><div style='float:right;'><input id='cfgOPEN_J3_H3' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J3_H3,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture 2</div><div style='float:right;'><input id='cfgOPEN_J3_H4' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J3_H4,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (FR):</div><div style='float:right;'><input type='text' id='cfgOPEN_J3_FR' value='<?php echo $CIE_OPEN_J3_FR;?>'></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (EN):</div><div style='float:right;'><input type='text' id='cfgOPEN_J3_EN' value='<?php echo $CIE_OPEN_J3_EN;?>'></div></div>
        </div>
        <div class="divBOX"><h3>Jeudi</h3>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:50%;text-align:right;'><button class='red' onclick="setOPENING('4','closed');"><span class="material-icons">event_busy</span> Fermé</button></div><div style='width:50%;text-align:left;'><button class='green' onclick="setOPENING('4','24h');"><span class="material-icons">event_available</span> 24H</button></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture</div><div style='float:right;'><input id='cfgOPEN_J4_H1' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J4_H1,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture</div><div style='float:right;'><input id='cfgOPEN_J4_H2' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J4_H2,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture 2</div><div style='float:right;'><input id='cfgOPEN_J4_H3' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J4_H3,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture 2</div><div style='float:right;'><input id='cfgOPEN_J4_H4' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J4_H4,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (FR):</div><div style='float:right;'><input type='text' id='cfgOPEN_J4_FR' value='<?php echo $CIE_OPEN_J4_FR;?>'></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (EN):</div><div style='float:right;'><input type='text' id='cfgOPEN_J4_EN' value='<?php echo $CIE_OPEN_J4_EN;?>'></div></div>
        </div>
        <div class="divBOX"><h3>Vendredi</h3>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:50%;text-align:right;'><button class='red' onclick="setOPENING('5','closed');"><span class="material-icons">event_busy</span> Fermé</button></div><div style='width:50%;text-align:left;'><button class='green' onclick="setOPENING('5','24h');"><span class="material-icons">event_available</span> 24H</button></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture</div><div style='float:right;'><input id='cfgOPEN_J5_H1' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J5_H1,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture</div><div style='float:right;'><input id='cfgOPEN_J5_H2' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J5_H2,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture 2</div><div style='float:right;'><input id='cfgOPEN_J5_H3' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J5_H3,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture 2</div><div style='float:right;'><input id='cfgOPEN_J5_H4' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J5_H4,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (FR):</div><div style='float:right;'><input type='text' id='cfgOPEN_J5_FR' value='<?php echo $CIE_OPEN_J5_FR;?>'></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (EN):</div><div style='float:right;'><input type='text' id='cfgOPEN_J5_EN' value='<?php echo $CIE_OPEN_J5_EN;?>'></div></div>
        </div>
        <div class="divBOX"><h3>Samedi</h3>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:50%;text-align:right;'><button class='red' onclick="setOPENING('6','closed');"><span class="material-icons">event_busy</span> Fermé</button></div><div style='width:50%;text-align:left;'><button class='green' onclick="setOPENING('6','24h');"><span class="material-icons">event_available</span> 24H</button></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture</div><div style='float:right;'><input id='cfgOPEN_J6_H1' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J6_H1,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture</div><div style='float:right;'><input id='cfgOPEN_J6_H2' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J6_H2,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture 2</div><div style='float:right;'><input id='cfgOPEN_J6_H3' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J6_H3,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture 2</div><div style='float:right;'><input id='cfgOPEN_J6_H4' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J6_H4,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (FR):</div><div style='float:right;'><input type='text' id='cfgOPEN_J6_FR' value='<?php echo $CIE_OPEN_J6_FR;?>'></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (EN):</div><div style='float:right;'><input type='text' id='cfgOPEN_J6_EN' value='<?php echo $CIE_OPEN_J6_EN;?>'></div></div>
        </div>
        <div class="divBOX"><h3>Dimanche</h3>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:50%;text-align:right;'><button class='red' onclick="setOPENING('0','closed');"><span class="material-icons">event_busy</span> Fermé</button></div><div style='width:50%;text-align:left;'><button class='green' onclick="setOPENING('0','24h');"><span class="material-icons">event_available</span> 24H</button></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture</div><div style='float:right;'><input id='cfgOPEN_J0_H1' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J0_H1,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture</div><div style='float:right;'><input id='cfgOPEN_J0_H2' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J0_H2,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Ouverture 2</div><div style='float:right;'><input id='cfgOPEN_J0_H3' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J0_H3,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Fermeture 2</div><div style='float:right;'><input id='cfgOPEN_J0_H4' type="time"  min="00:00" max="24:00" value="<?php echo str_pad($CIE_OPEN_J0_H4,5,"0",STR_PAD_LEFT); ?>"></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (FR):</div><div style='float:right;'><input type='text' id='cfgOPEN_J0_FR' value='<?php echo $CIE_OPEN_J0_FR;?>'></div></div>
            <div style="display: flex;flex-wrap: nowrap;width:100%"><div style='width:250px;'>Remplacer par (EN):</div><div style='float:right;'><input type='text' id='cfgOPEN_J0_EN' value='<?php echo $CIE_OPEN_J0_EN;?>'></div></div>
        </div><hr>
        <div class='divBOX'><label for='cfgPUB'>Afficher l'adresse de la maison mère dans les sections contact publique:</label>
            <input id='cfgPUB' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($CIE_ADR_PUB == "true"){echo " checked ";} ?>>
            <span style='font-size:10px;'><?php echo $CIE_ADR; ?></span>
        </div>
        <div class='divBOX'><label for='cfgPUB2'>Afficher l'adresse des succursales dans les sections contact publique:</label>
            <input id='cfgPUB2' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($CIE_ADR_PUB2 == "true"){echo " checked ";} ?>>
        </div>
        <hr> <h2>Facturation & Panier</h2>
        <div class='divBOX'><label for='cfgINTERAC'>Accepter les paiements par Interac en magasin:</label>
            <input id='cfgINTERAC' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($MAG_INTERAC == "true"){echo " checked ";} ?>>
        </div>
        <div class="divBOX">Montant de base pour transport interne:
            <input id='cfgTRANSPORT_PRICE' type="text" value="<?php echo $CIE_TRANSPORT_PRICE; ?>" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Montant minimum pour transport à nos frais (applicable si le champ n'est pas vide ou à 0):
            <input id='cfgTRANSPORT_FREE_MIN' type="text" value="<?php echo $CIE_FREE_MIN; ?>" onclick="detectCLICK(event,this);">
        </div>
        <div class="divBOX">Mode de transport commandes:
            <select id="selTRANSPORT">
                <option disabled selected>Choisir un mode de transport par défaut</option>
                <option value='PICKUP' <?php if ($CIE_TRANSPORT == "PICKUP") {echo "selected";} ?> > Ramassage seulement </option>
                <option value='INTERNAL' <?php if ($CIE_TRANSPORT == "INTERNAL") {echo "selected";} ?> > Transport interne </option>
                <option value='POSTE_CANADA' <?php if ($CIE_TRANSPORT == "POSTE_CANADA") {echo "selected";} ?> > Poste Canada </option>
                <option value='MONTREAL_DROPSHIP' <?php if ($CIE_TRANSPORT == "MONTREAL_DROPSHIP") {echo "selected";} ?> > Livraison à Rabais </option>
            </select>
        </div>
        <div class="divBOX">Action du panier:
            <select id="selCART_ACT">
                <option disabled selected>Choisir l'action du panier</option>
                <option value='CHECKOUT' <?php if ($CIE_CART_ACT == "CHECKOUT") {echo "selected";} ?> > Passer à la caisse (checkout) </option>
                <option value='ORDER' <?php if ($CIE_CART_ACT == "ORDER") {echo "selected";} ?> > Confirmer la commande </option>
                <option value='INVOICE' <?php if ($CIE_CART_ACT == "INVOICE") {echo "selected";} ?> > Recevoir la facture </option>
            </select>
            <span style='font-size:0.8em;'>Notez que pour l'option passer à la caisse (checkout) une API telle que Stripe ou PayPal doit être configurée.</span>
        </div>
        <div class='divBOX'><label for='cfgHIDE_PRICE'>Masquer le prix du panier:</label>
            <input id='cfgHIDE_PRICE' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($CIE_HIDE_PRICE == "true"){echo " checked ";} ?>>
            <span style='font-size:14px;'>Si cette option est sélectionnée, une note mentionnant que les prix peuvent varier et que le total sera déterminé lors du ramassage de la commande en magasin.</span>
        </div>
        <div class="divBOX">API de paiement:
            <select id="selCART_API">
                <option disabled selected value=''>Choisir l'API de paiement</option>
                <option value=''>Aucun</option>
                <option value='PAYPAL' <?php if ($CIE_CART_API == "PAYPAL") {echo "selected";} ?> > PayPal </option>
                <option value='SQUARE' <?php if ($CIE_CART_API == "SQUARE") {echo "selected";} ?> > Square </option>
                <option value='STRIPE' <?php if ($CIE_CART_API == "STRIPE") {echo "selected";} ?> > Stripe </option>
            </select>
        </div>
        <div class="divBOX">Délais de livraison <span style='font-size:0.8em;'>(transport interne)</span>:<br>
            <input id='cfgDTLV_F1' style='width:47%;' type="number" value="<?php echo $CIE_LV_F1; ?>" onclick="detectCLICK(event,this);">
            <select id="cfgDTLV_F2" style='width:47%;'>
                <option value='hour' <?php if ($CIE_LV_F2 == "hour") {echo "selected";} ?> > Heure(s) </option>
                <option value='day' <?php if ($CIE_LV_F2 == "day") {echo "selected";} ?> > Jour(s) </option>
                <option value='week' <?php if ($CIE_LV_F2 == "week") {echo "selected";} ?> > Semaine(s) </option>
                <option value='month' <?php if ($CIE_LV_F2 == "month") {echo "selected";} ?> > Mois </option>
            </select>
        </div>
        <div class="divBOX">Délais de date due facture:<br>
            <input id='cfgDTDU_F1' style='width:47%;' type="number" value="<?php echo $CIE_DU_F1; ?>" onclick="detectCLICK(event,this);">
            <select id="cfgDTDU_F2" style='width:47%;'>
                <option value='day' <?php if ($CIE_DU_F2 == "day") {echo "selected";} ?> > Jour(s) </option>
                <option value='week' <?php if ($CIE_DU_F2 == "week") {echo "selected";} ?> > Semaine(s) </option>
                <option value='month' <?php if ($CIE_DU_F2 == "month") {echo "selected";} ?> > Mois </option>
            </select>
        </div>
        <div class="divBOX">Délais pour ramassage:<br>
            <input id='cfgDTPK_F1' style='width:47%;' type="number" value="<?php echo $CIE_PK_F1; ?>" onclick="detectCLICK(event,this);">
            <select id="cfgDTPK_F2" style='width:47%;'>
                <option value='hour' <?php if ($CIE_PK_F2 == "hour") {echo "selected";} ?> > Heure(s) </option>
                <option value='day' <?php if ($CIE_PK_F2 == "day") {echo "selected";} ?> > Jour(s) </option>
                <option value='week' <?php if ($CIE_PK_F2 == "week") {echo "selected";} ?> > Semaine(s) </option>
                <option value='month' <?php if ($CIE_PK_F2 == "month") {echo "selected";} ?> > Mois </option>
            </select>
        </div>
        <div class='divBOX'>Dans le panier, si le client choisis le ramassage:<br>
                <input type="radio" id='cfgPICK_CAL1' name='cfgPICK_CAL' value='CALL' <?php if ($CIE_PICK_CAL == "CALL" || $CIE_PICK_CAL == "") {echo "checked";} ?>> <label for='cfgPICK_CAL1' style='max-width:85%;'><small>Message: "Vous serez contacté lorsque la commande est prête à ramasser."</small></label><br>
                <hr><input type="radio" id='cfgPICK_CAL2' name='cfgPICK_CAL' value='PICK_DATE' <?php if ($CIE_PICK_CAL == "PICK_DATE") {echo "checked";} ?>> <label for='cfgPICK_CAL2' style='max-width:85%;'><small>Afficher un calendrier pour choisir quand ramasser selon le délais pour ramassage et les heures d'ouvertures.</small></label><br>
                <hr><input type="radio" id='cfgPICK_CAL3' name='cfgPICK_CAL' value='DELAY' <?php if ($CIE_PICK_CAL == "DELAY") {echo "checked";} ?>> <label for='cfgPICK_CAL3' style='max-width:85%;'><small>Afficher à partir de quand ramasser selon le délais pour ramassage et les heures d'ouvertures.</small></label>
            </div>
        <h2 style='text-align:left;margin-left:20px;'>Note de bas de facture</h2>
        <div class='divBOX' style='width:100%;max-width:800px;'>
            <textarea id='cfgINV_NOTE' style='width:100%;height:150px;'><?php echo $CIE_INVOICE_NOTE; ?></textarea>
        </div>

        <hr> <h2>Facturation Distributeurs</h2>
        <div class='divBOX'><label for='cfgDIST_AD' style='max-width:75%;'>Permettre aux distributeurs d'afficher des petites annonces:</label>
            <input id='cfgDIST_AD' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($CIE_DIST_AD == "true"){echo " checked ";} ?>>
        </div>
        <div class='divBOX'><label for='cfgGRAB' style='max-width:75%;'>Percevoir les montants facturés par les distributeurs dans les petites annonces:</label>
            <input id='cfgGRAB' type='checkbox' style='float:right;vertical-align:middle;margin:5px;' <?php if($CIE_GRAB == "true"){echo " checked ";} ?>>
        </div>
        <div class="divBOX">Pourcentage conservé:
            <input id='cfgGRAB_POURCENT' type="text" value="<?php echo $CIE_GRAB_POURCENT; ?>">
        </div>
        <div class="divBOX">Montant conservé:
            <input id='cfgGRAB_AMOUNT' type="text" value="<?php echo $CIE_GRAB_AMOUNT; ?>">
        </div>

        <br><br><button onclick="saveCFG();"><span class="material-icons">save</span>Sauvegarder</button>
    </div>
</div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var client_devtools = function() {};
var cfgHOME = "<?php echo $CIE_HOME; ?>";

$(document).ready(function (){
    document.getElementById('config_select').value="/app/config/config_1_info.php";
});

window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    window.location.reload();
  }
});

function setOPENING(sday,sset){
    if (sset == 'closed'){
        document.getElementById("cfgOPEN_J"+sday+"_H1").value = "00:00";
        document.getElementById("cfgOPEN_J"+sday+"_H2").value = "00:00";
        document.getElementById("cfgOPEN_J"+sday+"_H3").value = "00:00";
        document.getElementById("cfgOPEN_J"+sday+"_H4").value = "00:00";
        document.getElementById("cfgOPEN_J"+sday+"_FR").value = "Fermé";
        document.getElementById("cfgOPEN_J"+sday+"_EN").value = "Closed";
    } else {
        document.getElementById("cfgOPEN_J"+sday+"_H1").value = "00:00";
        document.getElementById("cfgOPEN_J"+sday+"_H2").value = "23:59";
        document.getElementById("cfgOPEN_J"+sday+"_H3").value = "00:00";
        document.getElementById("cfgOPEN_J"+sday+"_H4").value = "00:00";
        document.getElementById("cfgOPEN_J"+sday+"_FR").value = "24H";
        document.getElementById("cfgOPEN_J"+sday+"_EN").value = "24H";
    }
}

function saveCFG(){
	var sNOM = document.getElementById("cfgNOM").value.trim();
	var sDOUV = document.getElementById("cfgDOUV").value.trim();
	var sNOM_HTML = document.getElementById("cfgNOM_HTML").value;
	var sHOME  = document.getElementById("cfgHOME").value.trim();
	var sTEL1   = document.getElementById("cfgTEL1").value;
	var sTEL2  = document.getElementById("cfgTEL2").value;
	var sEML1   = document.getElementById("cfgEML1").value;
	var sEML2   = document.getElementById("cfgEML2").value;
	var sEML3   = document.getElementById("cfgEML3").value;
	var sEML4   = document.getElementById("cfgEML4").value;
	var sSLOGAN_FR   = document.getElementById("cfgSLOGAN_FR").value;
	var sSLOGAN_EN   = document.getElementById("cfgSLOGAN_EN").value;
	var aPKCAL = document.getElementsByName("cfgPICK_CAL");
    for (var i = 0; i < aPKCAL.length; i++) {
        if (aPKCAL[i].checked) {
            sPKCAL = aPKCAL[i].value;
        }
    }
	var sJ1_FR   = document.getElementById("cfgOPEN_J1_FR").value;
	var sJ2_FR   = document.getElementById("cfgOPEN_J2_FR").value;
	var sJ3_FR   = document.getElementById("cfgOPEN_J3_FR").value;
	var sJ4_FR   = document.getElementById("cfgOPEN_J4_FR").value;
	var sJ5_FR   = document.getElementById("cfgOPEN_J5_FR").value;
	var sJ6_FR   = document.getElementById("cfgOPEN_J6_FR").value;
	var sJ0_FR   = document.getElementById("cfgOPEN_J0_FR").value;
	var sJ1_EN   = document.getElementById("cfgOPEN_J1_EN").value;
	var sJ2_EN   = document.getElementById("cfgOPEN_J2_EN").value;
	var sJ3_EN   = document.getElementById("cfgOPEN_J3_EN").value;
	var sJ4_EN   = document.getElementById("cfgOPEN_J4_EN").value;
	var sJ5_EN   = document.getElementById("cfgOPEN_J5_EN").value;
	var sJ6_EN   = document.getElementById("cfgOPEN_J6_EN").value;
	var sJ0_EN   = document.getElementById("cfgOPEN_J0_EN").value;
	var sJ1_H1   = document.getElementById("cfgOPEN_J1_H1").value; if (sJ1_H1.substring(0,1)=="0"){sJ1_H1 = sJ1_H1.substring(1);}
	var sJ1_H2   = document.getElementById("cfgOPEN_J1_H2").value; if (sJ1_H2.substring(0,1)=="0"){sJ1_H2 = sJ1_H2.substring(1);}
	var sJ1_H3   = document.getElementById("cfgOPEN_J1_H3").value; if (sJ1_H3.substring(0,1)=="0"){sJ1_H3 = sJ1_H3.substring(1);}
	var sJ1_H4   = document.getElementById("cfgOPEN_J1_H4").value; if (sJ1_H4.substring(0,1)=="0"){sJ1_H4 = sJ1_H4.substring(1);}
	var sJ2_H1   = document.getElementById("cfgOPEN_J2_H1").value; if (sJ2_H1.substring(0,1)=="0"){sJ2_H1 = sJ2_H1.substring(1);}
	var sJ2_H2   = document.getElementById("cfgOPEN_J2_H2").value; if (sJ2_H2.substring(0,1)=="0"){sJ2_H2 = sJ2_H2.substring(1);}
	var sJ2_H3   = document.getElementById("cfgOPEN_J2_H3").value; if (sJ2_H3.substring(0,1)=="0"){sJ2_H3 = sJ2_H3.substring(1);}
	var sJ2_H4   = document.getElementById("cfgOPEN_J2_H4").value; if (sJ2_H4.substring(0,1)=="0"){sJ2_H4 = sJ2_H4.substring(1);}
	var sJ3_H1   = document.getElementById("cfgOPEN_J3_H1").value; if (sJ3_H1.substring(0,1)=="0"){sJ3_H1 = sJ3_H1.substring(1);}
	var sJ3_H2   = document.getElementById("cfgOPEN_J3_H2").value; if (sJ3_H2.substring(0,1)=="0"){sJ3_H2 = sJ3_H2.substring(1);}
	var sJ3_H3   = document.getElementById("cfgOPEN_J3_H3").value; if (sJ3_H3.substring(0,1)=="0"){sJ3_H3 = sJ3_H3.substring(1);}
	var sJ3_H4   = document.getElementById("cfgOPEN_J3_H4").value; if (sJ3_H4.substring(0,1)=="0"){sJ3_H4 = sJ3_H4.substring(1);}
	var sJ4_H1   = document.getElementById("cfgOPEN_J4_H1").value; if (sJ4_H1.substring(0,1)=="0"){sJ4_H1 = sJ4_H1.substring(1);}
	var sJ4_H2   = document.getElementById("cfgOPEN_J4_H2").value; if (sJ4_H2.substring(0,1)=="0"){sJ4_H2 = sJ4_H2.substring(1);}
	var sJ4_H3   = document.getElementById("cfgOPEN_J4_H3").value; if (sJ4_H3.substring(0,1)=="0"){sJ4_H3 = sJ4_H3.substring(1);}
	var sJ4_H4   = document.getElementById("cfgOPEN_J4_H4").value; if (sJ4_H4.substring(0,1)=="0"){sJ4_H4 = sJ4_H4.substring(1);}
	var sJ5_H1   = document.getElementById("cfgOPEN_J5_H1").value; if (sJ5_H1.substring(0,1)=="0"){sJ5_H1 = sJ5_H1.substring(1);}
	var sJ5_H2   = document.getElementById("cfgOPEN_J5_H2").value; if (sJ5_H2.substring(0,1)=="0"){sJ5_H2 = sJ5_H2.substring(1);}
	var sJ5_H3   = document.getElementById("cfgOPEN_J5_H3").value; if (sJ5_H3.substring(0,1)=="0"){sJ5_H3 = sJ5_H3.substring(1);}
	var sJ5_H4   = document.getElementById("cfgOPEN_J5_H4").value; if (sJ5_H4.substring(0,1)=="0"){sJ5_H4 = sJ5_H4.substring(1);}
	var sJ6_H1   = document.getElementById("cfgOPEN_J6_H1").value; if (sJ6_H1.substring(0,1)=="0"){sJ6_H1 = sJ6_H1.substring(1);}
	var sJ6_H2   = document.getElementById("cfgOPEN_J6_H2").value; if (sJ6_H2.substring(0,1)=="0"){sJ6_H2 = sJ6_H2.substring(1);}
	var sJ6_H3   = document.getElementById("cfgOPEN_J6_H3").value; if (sJ6_H3.substring(0,1)=="0"){sJ6_H3 = sJ6_H3.substring(1);}
	var sJ6_H4   = document.getElementById("cfgOPEN_J6_H4").value; if (sJ6_H4.substring(0,1)=="0"){sJ6_H4 = sJ6_H4.substring(1);}
	var sJ0_H1   = document.getElementById("cfgOPEN_J0_H1").value; if (sJ0_H1.substring(0,1)=="0"){sJ0_H1 = sJ0_H1.substring(1);}
	var sJ0_H2   = document.getElementById("cfgOPEN_J0_H2").value; if (sJ0_H2.substring(0,1)=="0"){sJ0_H2 = sJ0_H2.substring(1);}
	var sJ0_H3   = document.getElementById("cfgOPEN_J0_H3").value; if (sJ0_H3.substring(0,1)=="0"){sJ0_H3 = sJ0_H3.substring(1);}
	var sJ0_H4   = document.getElementById("cfgOPEN_J0_H4").value; if (sJ0_H4.substring(0,1)=="0"){sJ0_H4 = sJ0_H4.substring(1);}
	var sINV_NOTE   = document.getElementById("cfgINV_NOTE").value;

	var GRPBOX  = document.getElementById("selCART_ACT");
	var sCART_ACT = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("selCART_API");
	var sCART_API = GRPBOX.options[GRPBOX.selectedIndex].value;

	var GRPBOX  = document.getElementById("selTRANSPORT");
	var sCIE_TRP = GRPBOX.options[GRPBOX.selectedIndex].value;
    //delais liv
    var sLVF1 = document.getElementById("cfgDTLV_F1").value;
	var GRPBOX  = document.getElementById("cfgDTLV_F2");
	var sLVF2 = GRPBOX.options[GRPBOX.selectedIndex].value;
    //delais pickup
    var sPKF1 = document.getElementById("cfgDTPK_F1").value;
	var GRPBOX  = document.getElementById("cfgDTPK_F2");
	var sPKF2 = GRPBOX.options[GRPBOX.selectedIndex].value;
    //calcul date due
    var sDUF1 = document.getElementById("cfgDTDU_F1").value;
	var GRPBOX  = document.getElementById("cfgDTDU_F2");
	var sDUF2 = GRPBOX.options[GRPBOX.selectedIndex].value;

	var sTRP_PRICE   = document.getElementById("cfgTRANSPORT_PRICE").value;
	var sTRP_FREE_MIN   = document.getElementById("cfgTRANSPORT_FREE_MIN").value;

	//if (document.getElementById("cfgPICKUP").checked == false){var sPICKUP = "false"; } else { var sPICKUP ="true"; }
	if (document.getElementById("cfgINTERAC").checked == false){var sINTERAC = "false"; } else { var sINTERAC ="true"; }
	if (document.getElementById("cfgHIDE_PRICE").checked == false){var sHIDE_PRICE = "false"; } else { var sHIDE_PRICE ="true"; }
	if (document.getElementById("cfgPUB").checked == false){var sPUB = "false"; } else { var sPUB ="true"; }
	if (document.getElementById("cfgPUB2").checked == false){var sPUB2 = "false"; } else { var sPUB2 ="true"; }
	if (document.getElementById("cfgGRAB").checked == false){var sGRAB = "false"; } else { var sGRAB ="true"; }
	if (document.getElementById("cfgDIST_AD").checked == false){var sDIST_AD = "false"; } else { var sDIST_AD ="true"; }
    var sGRAB_POURCENT = document.getElementById("cfgGRAB_POURCENT").value;
    var sGRAB_AMOUNT = document.getElementById("cfgGRAB_AMOUNT").value;

    if (sNOM == ""){
		document.getElementById("cfgNOM").style.borderColor = "red";
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("cfgNOM").style.borderColor = "grey";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	//if (sDOUV == "" || sDOUV == "0"){
		//document.getElementById("cfgDOUV").style.borderColor = "red";
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		//return;
	//} else {
		//document.getElementById("cfgDOUV").style.borderColor = "grey";
		//document.getElementById("lblPRD").innerHTML = "";
	//}
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updCFG.php?KEY=' + KEY 
										+ '&INTERAC=' + encodeURIComponent(sINTERAC)
										+ '&TRP=' + encodeURIComponent(sCIE_TRP)
										+ '&TRPP=' + encodeURIComponent(sTRP_PRICE)
										+ '&TRPM=' + encodeURIComponent(sTRP_FREE_MIN)
										+ '&NOM=' + encodeURIComponent(sNOM)
										+ '&DOUV=' + encodeURIComponent(sDOUV)
										+ '&NOMH=' + encodeURIComponent(sNOM_HTML)
										+ '&EML1=' + encodeURIComponent(sEML1)  
										+ '&EML2=' + encodeURIComponent(sEML2) 
										+ '&EML3=' + encodeURIComponent(sEML3) 
										+ '&EML4=' + encodeURIComponent(sEML4) 
										+ '&S_FR=' + encodeURIComponent(sSLOGAN_FR) 
										+ '&S_EN=' + encodeURIComponent(sSLOGAN_EN) 
										+ '&TEL1=' + encodeURIComponent(sTEL1)   
										+ '&TEL2=' + encodeURIComponent(sTEL2)    
										+ '&PUB=' + encodeURIComponent(sPUB)  
										+ '&PUB2=' + encodeURIComponent(sPUB2)  
										+ '&J0_FR=' + encodeURIComponent(sJ0_FR)  
										+ '&J1_FR=' + encodeURIComponent(sJ1_FR)  
										+ '&J2_FR=' + encodeURIComponent(sJ2_FR)  
										+ '&J3_FR=' + encodeURIComponent(sJ3_FR)  
										+ '&J4_FR=' + encodeURIComponent(sJ4_FR)  
										+ '&J5_FR=' + encodeURIComponent(sJ5_FR)  
										+ '&J6_FR=' + encodeURIComponent(sJ6_FR)  
										+ '&J0_EN=' + encodeURIComponent(sJ0_EN)  
										+ '&J1_EN=' + encodeURIComponent(sJ1_EN)  
										+ '&J2_EN=' + encodeURIComponent(sJ2_EN)  
										+ '&J3_EN=' + encodeURIComponent(sJ3_EN)  
										+ '&J4_EN=' + encodeURIComponent(sJ4_EN)  
										+ '&J5_EN=' + encodeURIComponent(sJ5_EN)  
										+ '&J6_EN=' + encodeURIComponent(sJ6_EN)  
										+ '&J0_H1=' + encodeURIComponent(sJ0_H1)  
										+ '&J0_H2=' + encodeURIComponent(sJ0_H2)  
										+ '&J0_H3=' + encodeURIComponent(sJ0_H3)  
										+ '&J0_H4=' + encodeURIComponent(sJ0_H4)  
										+ '&J1_H1=' + encodeURIComponent(sJ1_H1)  
										+ '&J1_H2=' + encodeURIComponent(sJ1_H2)  
										+ '&J1_H3=' + encodeURIComponent(sJ1_H3)  
										+ '&J1_H4=' + encodeURIComponent(sJ1_H4)  
										+ '&J2_H1=' + encodeURIComponent(sJ2_H1)  
										+ '&J2_H2=' + encodeURIComponent(sJ2_H2)  
										+ '&J2_H3=' + encodeURIComponent(sJ2_H3)  
										+ '&J2_H4=' + encodeURIComponent(sJ2_H4)  
										+ '&J3_H1=' + encodeURIComponent(sJ3_H1)  
										+ '&J3_H2=' + encodeURIComponent(sJ3_H2)  
										+ '&J3_H3=' + encodeURIComponent(sJ3_H3)  
										+ '&J3_H4=' + encodeURIComponent(sJ3_H4)  
										+ '&J4_H1=' + encodeURIComponent(sJ4_H1)  
										+ '&J4_H2=' + encodeURIComponent(sJ4_H2)  
										+ '&J4_H3=' + encodeURIComponent(sJ4_H3)  
										+ '&J4_H4=' + encodeURIComponent(sJ4_H4)  
										+ '&J5_H1=' + encodeURIComponent(sJ5_H1)  
										+ '&J5_H2=' + encodeURIComponent(sJ5_H2)  
										+ '&J5_H3=' + encodeURIComponent(sJ5_H3)  
										+ '&J5_H4=' + encodeURIComponent(sJ5_H4)  
										+ '&J6_H1=' + encodeURIComponent(sJ6_H1)  
										+ '&J6_H2=' + encodeURIComponent(sJ6_H2)  
										+ '&J6_H3=' + encodeURIComponent(sJ6_H3)  
										+ '&J6_H4=' + encodeURIComponent(sJ6_H4)  
										+ '&INVN=' + encodeURIComponent(sINV_NOTE)  
										+ '&LVF1=' + encodeURIComponent(sLVF1)
										+ '&LVF2=' + encodeURIComponent(sLVF2)
										+ '&PKF1=' + encodeURIComponent(sPKF1)
										+ '&PKF2=' + encodeURIComponent(sPKF2)
										+ '&PKCAL=' + encodeURIComponent(sPKCAL)
										+ '&DUF1=' + encodeURIComponent(sDUF1)
										+ '&DUF2=' + encodeURIComponent(sDUF2)
										+ '&HP=' + encodeURIComponent(sHIDE_PRICE)
										+ '&DIST_AD=' + encodeURIComponent(sDIST_AD)
										+ '&GRAB=' + encodeURIComponent(sGRAB)
										+ '&GRAB_P=' + encodeURIComponent(sGRAB_POURCENT)
										+ '&GRAB_A=' + encodeURIComponent(sGRAB_AMOUNT)
										+ '&CART_ACT=' + encodeURIComponent(sCART_ACT)
										+ '&CART_API=' + encodeURIComponent(sCART_API)
										+ '&HOME=' + encodeURIComponent(sHOME) ,
										true);
		xmlhttp.send();
}

</script>
</body>
</html>
<?php $dw3_conn->close();exit(); ?>
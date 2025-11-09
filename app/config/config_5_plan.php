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
$APNAME = "Plan d'affaire";
$sql = "SELECT code,text2,text3 FROM config 
WHERE kind = 'CIE' AND code = 'TYPE' 
OR kind = 'CIE' AND code = 'CAT' 
OR kind = 'PLAN' AND code = 'APERCU' ";
$result = mysqli_query($dw3_conn, $sql);
$CHK_TYPE = "";
$CHK_CAT = "";
$CHK_APERCU = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       if ($row["code"]=="TYPE" && trim($row["text2"]) != "false" && trim($row["text2"] != "")){$CHK_TYPE = "checked";}
       if ($row["code"]=="CAT" && trim($row["text2"]) != "false" && trim($row["text2"] != "")){$CHK_CAT = "checked";}
       if ($row["code"]=="APERCU" && trim($row["text2"]) != "false" && trim($row["text2"] != "")){$CHK_APERCU = "checked";}
    }
}

$PLAN_COMPLETED = 0;
$sql = "SELECT * FROM config WHERE kind = 'PLAN'";
$result = $dw3_conn->query($sql);
$numrows = $result->num_rows;
if ($numrows > 0) {
	while($row = $result->fetch_assoc()) {
	if ($row["code"] == "APERCU")			{$PLAN_APERCU = $row["text1"]; if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "APERCU")		{$PLAN_APERCU = $row["text1"]; if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "CONVENTION")		{$PLAN_CONVENTION = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "CIBLE")		{$PLAN_CIBLE = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "TERRITOIRE")		{$PLAN_TERRITOIRE = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "OCCASION")		{$PLAN_OCCASION = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "CONCURENTS")		{$PLAN_CONCURENTS = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "AVANTAGE_CONCUR")		{$PLAN_AVANTAGE_CONCUR = $row["text1"];if($row["text1"]!=""){++$PLAN_COMPLETED;}	
		} else if ($row["code"] == "ESTIMATION_VENTES")		{$PLAN_ESTIMATION_VENTES = $row["text1"];if($row["text1"]!=""){++$PLAN_COMPLETED;}	
		} else if ($row["code"] == "PRODUITS")		{$PLAN_PRODUITS = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "STRATEGIE")		{$PLAN_STRATEGIE = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "CANAUX")		{$PLAN_CANAUX = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "ACTIONS")		{$PLAN_ACTIONS = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "ESTIMATION_PUB")		{$PLAN_ESTIMATION_PUB = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "PRODUCTION")		{$PLAN_PRODUCTION = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "QUALITE")		{$PLAN_QUALITE = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "SOURCE")		{$PLAN_SOURCE = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "AMENAGEMENT")		{$PLAN_AMENAGEMENT = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "IMMOBILIER_AQUIS")		{$PLAN_IMMOBILIER_AQUIS = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "IMMOBILIER_REQUIS")		{$PLAN_IMMOBILIER_REQUIS = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "INVESTISSEMENT")		{$PLAN_INVESTISSEMENT = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "RECHERCHE")		{$PLAN_RECHERCHE = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "NORMES")		{$PLAN_NORMES = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "EMPLOIS")		{$PLAN_EMPLOIS = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "PARTENAIRES")		{$PLAN_PARTENAIRES = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "PERMIS_REQUIS")		{$PLAN_PERMIS_REQUIS = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "PERMIS_AQUIS")		{$PLAN_PERMIS_AQUIS = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "ENTENTES")		{$PLAN_ENTENTES = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "RH")		{$PLAN_RH = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "ESTIMATION_COUT")		{$PLAN_ESTIMATION_COUT = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "CAPITAL")		{$PLAN_CAPITAL = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "PRET_REQUIS")		{$PLAN_PRET_REQUIS = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "BILAN_ANTERIEUR")		{$PLAN_BILAN_ANTERIEUR = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "PREVISIONS")		{$PLAN_PREVISIONS = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "BUDGET")		{$PLAN_BUDGET = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "OFFRES")		{$PLAN_OFFRES = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "CAPITAL_RISQUE")		{$PLAN_CAPITAL_RISQUE = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "EMPRUNTS")		{$PLAN_EMPRUNTS = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "SUBVENTION")		{$PLAN_SUBVENTION = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "SCENARIO_OPTI")		{$PLAN_SCENARIO_OPTI = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "SCENARIO_PESS")		{$PLAN_SCENARIO_PESS = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "SCENARIO_PROB")		{$PLAN_SCENARIO_PROB = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "CONTAB_PASSE")		{$PLAN_CONTAB_PASSE = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "CONTAB_FUTUR")		{$PLAN_CONTAB_FUTUR = $row["text1"];	if($row["text1"]!=""){++$PLAN_COMPLETED;}
		} else if ($row["code"] == "OUTILS")		{$PLAN_OUTILS = $row["text1"];		if($row["text1"]!=""){++$PLAN_COMPLETED;}	
		}
	}
}
$PLAN_COMPLETED_P = round((100 /$numrows)*$PLAN_COMPLETED);
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';
?>
<div id="divHEAD">
	<table style="width:100%;margin:0px;white-space:nowrap;margin-top:5px;">
		<tr style="margin:0px;padding:0px;">
			<td width="*">
                <select id="config_select" onchange="window.open(this.value+'?KEY='+KEY,'_self')">
                    <option selected value="/app/config/config.php"> Tableau de Bord </option>
                    <option value="/app/config/config_1_info.php"> Infos générales & Facturation </option>
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

<div class="divMAIN" style="margin:50px 0px;">
    <div class='divPAGE'>
        <br><h3 style='font-size:1.1em;text-align:center;'>Aperçu de l'entreprise</h3><hr>
        <div class="divBOX" style='max-width:98%'><br>Forme juridique de l'entreprise:
            <select name='cfgTYPE' id='cfgTYPE'>
                <option <?php if ($CIE_TYPE == "1") {echo "selected";} ?> value="1">Entreprise individuelle</option>
                <option <?php if ($CIE_TYPE == "2") {echo "selected";} ?> value="2">Société en nom collectif</option>
                <option <?php if ($CIE_TYPE == "3") {echo "selected";} ?> value="3">Société en commandite</option>
                <option <?php if ($CIE_TYPE == "4") {echo "selected";} ?> value="4">Société par actions</option>
                <option <?php if ($CIE_TYPE == "5") {echo "selected";} ?> value="5">Coopérative</option>
                <option <?php if ($CIE_TYPE == "6") {echo "selected";} ?> value="6">Organisme à but non lucratif</option>
            </select>
            <div style='padding:5px 0px 0px 5px;'><input id='chkTYPE' <?php echo $CHK_TYPE;?> type="checkbox"><label for='chkTYPE' style='margin-left:5px;'> Afficher sur la page du <u><a href='/profil' target='_blank'>profil publique</a></u></label></div>
        </div>
        <div class="divBOX" style='max-width:98%'><br>Secteurs d'activité:
            <select name='cfgCAT' id='cfgCAT'>
                    <!-- n/a <option value="1">Administrations publiques</option> -->
                    <option <?php if ($CIE_CAT == "2") {echo "selected";} ?> value="2">Agriculture, foresterie, pêche et chasse</option>
                    <option <?php if ($CIE_CAT == "3") {echo "selected";} ?> value="3">Arts, spectacles et loisirs</option>
                    <option <?php if ($CIE_CAT == "4") {echo "selected";} ?> value="4">Autres services (sauf les administrations publiques)</option>
                    <option <?php if ($CIE_CAT == "5") {echo "selected";} ?> value="5">Commerce de détail</option>
                    <option <?php if ($CIE_CAT == "6") {echo "selected";} ?> value="6">Commerce de gros</option>
                    <option <?php if ($CIE_CAT == "7") {echo "selected";} ?> value="7">Construction</option>
                    <option <?php if ($CIE_CAT == "8") {echo "selected";} ?> value="8">Extraction minière, exploitation en carrière, et extraction de pétrole et de gaz</option>
                    <option <?php if ($CIE_CAT == "9") {echo "selected";} ?> value="9">Fabrication</option>
                    <option <?php if ($CIE_CAT == "10") {echo "selected";} ?> value="10">Finance et assurances</option>
                    <option <?php if ($CIE_CAT == "11") {echo "selected";} ?> value="11">Gestion de sociétés et d'entreprises</option>
                    <option <?php if ($CIE_CAT == "12") {echo "selected";} ?> value="12">Hébergement et services de restauration</option>
                    <option <?php if ($CIE_CAT == "13") {echo "selected";} ?> value="13">Industrie de l'information et industrie culturelle</option>
                    <option <?php if ($CIE_CAT == "14") {echo "selected";} ?> value="14">Services administratifs, services de soutien, services de gestion des déchets et services d'assainissement</option>
                    <option <?php if ($CIE_CAT == "15") {echo "selected";} ?> value="15">Services d'enseignement</option>
                    <option <?php if ($CIE_CAT == "16") {echo "selected";} ?> value="16">Services de restauration et débit de boisson</option>
                    <option <?php if ($CIE_CAT == "17") {echo "selected";} ?> value="17">Services immobiliers et services de location et de location à bail</option>
                    <option <?php if ($CIE_CAT == "18") {echo "selected";} ?> value="18">Services professionnels, scientifiques et techniques</option>
                    <!-- n/a <option value="19">Services publics</option> -->
                    <option <?php if ($CIE_CAT == "20") {echo "selected";} ?> value="20">Soins de santé et assistance sociale</option>
                    <option <?php if ($CIE_CAT == "21") {echo "selected";} ?> value="21">Transport et entreposage</option>
                    <option <?php if ($CIE_CAT == "22") {echo "selected";} ?> value="22">Transport par camion</option>
                </select>
            <div style='padding:5px 0px 0px 5px;'><input id='chkCAT' <?php echo $CHK_CAT;?> type="checkbox"><label for='chkCAT' style='margin-left:5px;'> Afficher sur la page du <u><a href='/profil' target='_blank'>profil publique</a></u></label></div>
            </div>
        <div class="divBOX" style='max-width:98%;width:98%;'>
            <b>Description de l'entreprise:</b><br>
            <hr><textarea id='planAPERCU' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_APERCU; ?></textarea>
            <div style='padding:0 15px 10px 15px;font-size: 0.7em;text-align: justify;text-justify: inter-word;'>Mission de l'entreprise, un cours historique, les étapes du projet et date prévue pour la réalisation de chaque étape, vos clients potentiels, vos projets de croissance, etc. Vous devez également expliquer pourquoi les clients devraient acheter votre produit ou service. Qu'est‑ce que vous offrez de plus que vos concurrents? Idéalement, cet aperçu doit tenir sur une seule page, maximum deux, car il s'agit là d'une présentation sommaire de votre entreprise. Il doit aussi piquer suffisamment la curiosité du lecteur pour qu'il lise le reste du plan d'un œil encore plus attentif.</div>
            <div style='padding:0px 0px 0px 5px;'><input id='chkAPERCU' <?php echo $CHK_APERCU;?> type="checkbox"><label for='chkAPERCU' style='margin-left:5px;'> Afficher sur la page du <u><a href='/profil' target='_blank'>profil publique</a></u></label></div>
        </div>
        <div class="divBOX" style='max-width:98%;width:98%;'>
            <b>Convention des actionnaires:</b><br>
                <textarea id='planCONVENTION' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_CONVENTION; ?></textarea>
                <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        </div>
    </div>
    <div class='divPAGE'>
        <br><h3 style='font-size:1.1em;text-align:center;'>Étude de marché</h3><hr>
        <div id='googleMap2' style='height:400px;'></div>
        <div style='display:none;padding:5px 0px 0px 5px;width:100%;text-align:left;'><input id='chkMAP' type="checkbox"><label for='chkMAP' style='margin-left:5px;'> Afficher sur la page du <u><a href='/profil' target='_blank'>profil publique</a></u></label></div>
        <hr><b>Clientèle cible:</b><br>
            <textarea id='planCIBLE' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_CIBLE; ?></textarea>
            <div style='padding:3px 15px 10px 15px;font-size:0.7em;'></div>
        <b>Territoire visé:</b><br>
            <textarea id='planTERRITOIRE' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_TERRITOIRE; ?></textarea>
        <br>
        <br><b>Occasions d'affaires:</b><br>
            <textarea id='planOCCASION' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_OCCASION; ?></textarea>
        <br>
        <br><b>Concurrents:</b><br>
            <textarea id='planCONCURENTS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_CONCURENTS; ?></textarea>
        <br>
        <br><b>Avantage concurrentiel:</b><br>
            <textarea id='planAVANTAGE_CONCUR' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_AVANTAGE_CONCUR; ?></textarea>
        <br>
        <br><b>Estimation des ventes annuelles totales:</b><br>
            <input id='planESTIMATION_VENTES' type="number" value="<?php echo $PLAN_ESTIMATION_VENTES; ?>"><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
    </div>	
    <div class="divPAGE">
    <hr><h3 style='font-size:1.1em;text-align:center;'>Plan marketing</h3>
        <hr><b>Produits et services:</b><br>
            <textarea id='planPRODUITS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_PRODUITS; ?></textarea>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;text-align: justify;text-justify: inter-word;'>Leurs forces et faiblesses, les opportunités et les menaces relatives à leur lancement sur le marché.</div>
        <b>Stratégie de prix:</b><br>
            <textarea id='planSTRATEGIE' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_STRATEGIE; ?></textarea>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>Prix des concurrents, marge bénéficiaire brute, prix de revient</div>
        <b>Canaux de distribution:</b><br>
            <textarea id='planCANAUX' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_CANAUX; ?></textarea>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Actions promotionnelles:</b><br>
            <textarea id='planACTIONS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_ACTIONS; ?></textarea>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Estimation du cout en publicité pour le lancement:</b><br>
            <input id='planESTIMATION_PUB' type="number" value="<?php echo $PLAN_ESTIMATION_PUB; ?>">
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
    </div>	
    <div class="divPAGE">
    <hr><h3 style='font-size:1.1em;text-align:center;'>Plan opérationnel</h3>
    <hr>
    <div style='padding:0 15px 10px 15px;font-size:0.7em;text-align: justify;text-justify: inter-word;'>Le plan opérationnel sert à déterminer vos objectifs d'affaires ainsi que les moyens que vous utiliserez pour les atteindre. Cette partie du plan d'affaires vous permet, dans une certaine mesure, d'orchestrer votre plan marketing et de valider le réalisme de votre projet. Votre plan opérationnel doit préciser les actions à entreprendre dans un horizon de trois à cinq ans relativement à chaque fonction et service de votre entreprise afin d'atteindre vos objectifs d'affaires. Il peut aussi inclure le détail des activités quotidiennes, des installations physiques, de la structure de gouvernance, de la reddition de compte, des besoins matériels et technologiques, etc.</div>
        <b>Processus de production</b>:
            <textarea id='planPRODUCTION' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_PRODUCTION; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Approche qualité</b>:
            <textarea id='planQUALITE' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_QUALITE; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Approvisionnement</b>:
            <textarea id='planSOURCE' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_SOURCE; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>(fournisseurs, produit ou service, délai de livraison..)</div>
        <b>Plan d'aménagement de votre entreprise</b>:
            <textarea id='planAMENAGEMENT' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_AMENAGEMENT; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Détails de location ou de propriété</b>:
            <textarea id='planIMMOBILIER_AQUIS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_IMMOBILIER_AQUIS; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Immobilisations à réaliser</b>:
            <textarea id='planIMMOBILIER_REQUIS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_IMMOBILIER_REQUIS; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>bâtiments et équipements</div>
        <b>Investissements technologiques</b>:
            <textarea id='planINVESTISSEMENT' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_INVESTISSEMENT; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Recherche et développement</b>:
            <textarea id='planRECHERCHE' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_RECHERCHE; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Normes environnementales</b>:
            <textarea id='planNORMES' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_NORMES; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Partenaires et mentors</b>:
            <textarea id='planPARTENAIRES' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_PARTENAIRES; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Permis et autorisations requis</b>:
            <textarea id='planPERMIS_REQUIS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_PERMIS_REQUIS; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Permis et autorisations acquis</b>:
            <textarea id='planPERMIS_AQUIS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_PERMIS_AQUIS; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Ententes à conclure ainsi que tout autre renseignement pertinent pour votre projet</b>:
            <textarea id='planENTENTES' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_ENTENTES; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
    <br>
    </div>	
    <div class="divPAGE">
    <hr><h3 style='font-size:1.1em;text-align:center;'>Plan des ressources humaines</h3>
    <div style='width:100%;text-align:center;'><div id="chart_div2" style='display:inline-block;'></div></div>
    <hr><textarea id='planRH' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_RH; ?></textarea>
        <div style='padding:0 15px 10px 15px;font-size:0.7em;text-align: justify;text-justify: inter-word;'>Le plan des ressources humaines peut prendre diverses formes selon la complexité et la taille de votre entreprise, mais il s'agit essentiellement d'un document écrit qui traite de la gestion des ressources humaines et s'intègre au plan stratégique global de votre organisation. Même dans le cas où votre entreprise ne compterait pas beaucoup d'employés, l'élaboration d'un tel plan permettrait d'orienter vos décisions à prendre pour l'avenir. Cette planification est également importante au point de vue budgétaire car, d'emblée, vous pourrez inclure dans le budget organisationnel les coûts liés aux ressources humaines (recrutement, formation, etc.).</div>
    
        <b>Nombre et description des emplois</b>:
            <textarea id='planEMPLOIS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_EMPLOIS; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>Avant et après le lancement du le projet</div>
    </div><br>	

    <div class="divPAGE">
    <hr><h3 style='font-size:1.1em;text-align:center;'>Plan financier</h3>
        <hr><b>Dépenses projetées pour la réalisation du projet:</b>
            <textarea id='planESTIMATION_COUT' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_ESTIMATION_COUT; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Capital:</b>
            <textarea id='planCAPITAL' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_CAPITAL; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Financement requis:</b>
            <textarea id='planPRET_REQUIS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_PRET_REQUIS; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Bilan des trois dernières années:</b>
            <textarea id='planBILAN_ANTERIEUR' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_BILAN_ANTERIEUR; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Prévisions financières des deux prochaines années:</b>
            <textarea id='planPREVISIONS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_PREVISIONS; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Budget de caisse mensuel des deux prochaines années:</b>
            <textarea id='planBUDGET' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_BUDGET; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Offre des partenaires financiers:</b>
            <textarea id='planOFFRES' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_OFFRES; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Capital de risque:</b>
            <textarea id='planCAPITAL_RISQUE' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_CAPITAL_RISQUE; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Emprunts actifs:</b>
            <textarea id='planEMPRUNTS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_EMPRUNTS; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Subvention:</b>
            <textarea id='planSUBVENTION' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_SUBVENTION; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Scénario optimiste:</b>
            <textarea id='planSCENARIO_OPTI' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_SCENARIO_OPTI; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Scénario pessimiste:</b>
            <textarea id='planSCENARIO_PESS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_SCENARIO_PESS; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Scénario probable:</b>
            <textarea id='planSCENARIO_PROB' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_SCENARIO_PROB; ?></textarea><br>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Analyse de rentabilité:</b>
            <textarea id='planCONTAB_PASSE' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_CONTAB_PASSE; ?></textarea>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>États financiers réalistes pour une période de trois à cinq ans:</b>
            <textarea id='planCONTAB_FUTUR' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_CONTAB_FUTUR; ?></textarea>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;'>..</div>
        <b>Outils financiers</b>:
            <textarea id='planOUTILS' oninput="fitText(this);" onfocus="active_input=this.id;"><?php echo $PLAN_OUTILS; ?></textarea>
            <div style='padding:0 15px 10px 15px;font-size:0.7em;text-align: justify;text-justify: inter-word;'>Calculateurs de ratios, grilles d'analyse, logiciels de comptabilité, etc.</div>
    </div>
    <div class='divFOOT'>
        <button style='background:#66c6dd;margin-top:2px;' onclick="document.getElementById('divChar').style.width='auto';"><span class="material-icons">code</span></button>
        <div id='divChar' style='display:inline-block;overflow:hidden;height:35px;width:0px;vertical-align:middle;'>
            <button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick="addChar('&#x2022; ');">&#x2022;</button>
            <button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick="addChar('&#171;');">&#171;</button>
            <button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick="addChar('&#187;');">&#187;</button>
            <button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick="addChar('&#169;');">&#169;</button>
            <button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick="addChar('&#174;');">&#174;</button>
            <button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:24px;margin:1px;' onclick="addChar('&#8482;');">&#8482;</button>
            <button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick="addChar('&#163;');">&#163;</button>
            <button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick="addChar('&#165;');">&#165;</button>
            <button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick="addChar('&#162;');">&#162;</button>
            <button style='background:#66c6dd;width:30px;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick="addChar('&#8364;');">&#8364;</button>
            <button style='background:#444;padding:5px;border-radius:4px;font-size:22px;margin:1px;' onclick="document.getElementById('divChar').style.width='0px';"><span class="material-icons">cancel</span></button>
        </div>
        <?php echo $PLAN_COMPLETED_P; ?>% complété
        <button onclick="pfdPLAN();" style='margin-top:2px;'><span class="material-icons">print</span></button>
        <button onclick="savePLAN();" style='margin-top:2px;'><span class="material-icons">save</span></button>
        <span onclick="toggleSub('divSub0','up0');" class="material-icons" style='cursor:pointer;position:fixed;right:7px;bottom:15px;'>keyboard_arrow_up</span></h4>
    </div>
</div>
<!-- fenetre pour choisir le format et editer le html avant l'impression -->
<div id='divToPDF'>
	<div id='divToPDF_HEADER' style='z-index:300;cursor:move;position:absolute;top:0px;right:0px;left:0px;height:50px;background:rgba(207, 205, 205, 0.9);'>
		<br><h2>Format de l'impression</h2>
		<button style='background:#555555;top:5px;right:5px;padding:4px;position:absolute;' onclick='document.getElementById("divToPDF").style.display="none";'><span class='material-icons'>cancel</span></button>
		<hr>
    </div>
	<div style='padding-top:60px;cursor:pointer;' onclick='document.getElementById("chkHTML_EDITOR").click();'>
		Editer le HTML avant l'impression:		
	</div>
    <div style='position:absolute;top:60px;right:0px;padding:0px 15px 0 0;vertical-align:middle;'>
			<input id='chkHTML_EDITOR' type="checkbox" onclick="toggleHTML_EDITOR();">
	</div>

	<div id='txtToPDF_' style='display:none;text-align:left;'><i style='font-size:12px;'><sup>Ces dernieres modifications en HTML ne seronts pas enregistrés apres l'impression, elles ne s'appliquent qu'a cette impression.</sup></i>
		<textarea id='txtToPDF' style='min-height:150px;' oninput='txtToOutput();this.style.height = "";this.style.height = this.scrollHeight + "px";'></textarea>
		<button onclick='addTag("txtToPDF","B");' style='width:40px;font-size:13px;height:30px;'><b>B</b></button>
		<button onclick='addTag("txtToPDF","I");' style='width:40px;font-size:13px;height:30px;'><i>I</i></button>
		<button onclick='addTag("txtToPDF","U");' style='width:40px;font-size:13px;height:30px;'><u>U</u></button>
		<button onclick='addTag("txtToPDF","EXP");' style='width:40px;font-size:13px;height:30px;'><sup>SUP</sup></button>
	</div>
	<br>
	<iframe style='width:100%;height:100%;' id='divToPDF_OUTPUT'></iframe>
	<div style='position:sticky;bottom:0px;right:0px;left:0px;height:50px;background:rgba(207, 205, 205, 0.9);text-align:center;'>	
		<button style='background:#555;' onclick='document.getElementById("divToPDF").style.display="none";'><span class="material-icons">cancel</span></button>
		<button onclick='printPLAN();'><span class="material-icons">print</span> Imprimer</button>
		<button onclick='makePDF_PLAN();'><span class="material-icons">picture_as_pdf</span> PDF</button>
		<button onclick='makeDOCX_PLAN();'><span class="material-icons">description</span> Word</button>
	</div>
</div>


<div id="divMSG"></div>
<div id="divOPT"></div>


<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var client_devtools = function() {};
var cfgHOME = "<?php echo $CIE_HOME; ?>";
var myloc;
var map;
var map2;
var mapRECT;
var markers = [];
var concur_circle = [];
var concurents = JSON.parse('{"data":[{"id":"0"},{"id":"24"}]}');
var rectangle;
var activeInfoWindow;
var active_input;

var POSITION_LIST = [<?php
                        $sql = "SELECT *
                                FROM position				
                                ORDER BY auth,name";

                        $result = $dw3_conn->query($sql);
                        if ($result->num_rows > 0) {	
                            while($row = $result->fetch_assoc()) {
                                echo '["'. $row['name'] .'","' . $row['parent_name'] .'","' .$row['description'] . '"],';
                            }
                        }
                    ?>];

$(document).ready(function (){
    google.charts.load('current', {packages:["orgchart"]});
    google.charts.setOnLoadCallback(drawChart2);
    dragElement(document.getElementById('divToPDF'));
    document.getElementById('config_select').value="/app/config/config_5_plan.php";
});

        fitText(document.getElementById("planAPERCU"));
		fitText(document.getElementById("planCONVENTION"));
		fitText(document.getElementById("planCIBLE"));
		fitText(document.getElementById("planTERRITOIRE"));
		fitText(document.getElementById("planOCCASION"));
		fitText(document.getElementById("planCONCURENTS"));
		fitText(document.getElementById("planAVANTAGE_CONCUR"));
		fitText(document.getElementById("planESTIMATION_VENTES"));
		fitText(document.getElementById("planPRODUITS"));
		fitText(document.getElementById("planSTRATEGIE"));
		fitText(document.getElementById("planCANAUX"));
		fitText(document.getElementById("planACTIONS"));
		fitText(document.getElementById("planESTIMATION_PUB"));
		fitText(document.getElementById("planPRODUCTION"));
		fitText(document.getElementById("planQUALITE"));
		fitText(document.getElementById("planSOURCE"));
		fitText(document.getElementById("planAMENAGEMENT"));
		fitText(document.getElementById("planIMMOBILIER_AQUIS"));
		fitText(document.getElementById("planIMMOBILIER_REQUIS"));
		fitText(document.getElementById("planINVESTISSEMENT"));
		fitText(document.getElementById("planRECHERCHE"));
		fitText(document.getElementById("planNORMES"));
		fitText(document.getElementById("planEMPLOIS"));
		fitText(document.getElementById("planPARTENAIRES"));
		fitText(document.getElementById("planENTENTES"));
		fitText(document.getElementById("planRH"));
		fitText(document.getElementById("planESTIMATION_COUT"));
		fitText(document.getElementById("planCAPITAL"));
		fitText(document.getElementById("planPRET_REQUIS"));
		fitText(document.getElementById("planBILAN_ANTERIEUR"));
		fitText(document.getElementById("planPREVISIONS"));
		fitText(document.getElementById("planBUDGET"));
		fitText(document.getElementById("planOFFRES"));
		fitText(document.getElementById("planCAPITAL_RISQUE"));
		fitText(document.getElementById("planEMPRUNTS"));
		fitText(document.getElementById("planSUBVENTION"));
		fitText(document.getElementById("planSCENARIO_OPTI"));
		fitText(document.getElementById("planSCENARIO_PESS"));
		fitText(document.getElementById("planSCENARIO_PROB"));
		fitText(document.getElementById("planCONTAB_PASSE"));
		fitText(document.getElementById("planCONTAB_FUTUR"));
		fitText(document.getElementById("planOUTILS"));
		fitText(document.getElementById("planPERMIS_REQUIS"));
		fitText(document.getElementById("planPERMIS_AQUIS"));


function initMap() {
	  map2 = new google.maps.Map(document.getElementById("googleMap2"), {
		center: { lat: 45.64, lng: -73.71 },
		zoom: 11,
	  });
	  //MARKERS
		//getDEST();
	  
	  //RECT
	  mapRECT = {
		north: 45.66,
		south: 45.59,
		east: -73.66,
		west: -73.75,
	  };
	  
	  rectangle = new google.maps.Rectangle({
		bounds: mapRECT,
		editable: true,
		draggable: true,
		strokeColor: "#FF0000",
		strokeOpacity: 0.7,
		strokeWeight: 2,
		fillColor: "#FF0000",
		fillOpacity: 0.35
	  });

	  rectangle.setMap(map2);
	  // listen to changes
	  //["bounds_changed", "dragstart", "drag", "dragend"].forEach((eventName) => {
	  ["bounds_changed", "dragend"].forEach((eventName) => {
		rectangle.addListener(eventName, () => {
		  //console.log({ bounds: rectangle.getBounds()?.toJSON(), eventName });
		  mapRECT = rectangle.getBounds()?.toJSON();
		});
	  });

		var pos = {
				lat: 45,
				lng: -73
		};
		window.pos = pos;
		var me = new google.maps.LatLng(pos.lat, pos.lng);
		myloc = new google.maps.Marker({
			clickable: false,
			icon: new google.maps.MarkerImage('//maps.gstatic.com/mapfiles/mobile/mobileimgs2.png',
															new google.maps.Size(22,22),
															new google.maps.Point(0,18),
															new google.maps.Point(11,11)),
			shadow: null,
			zIndex: 999,
			map: map2
		});	
		myloc.setPosition(me);

}

function showRect(){
		rectangle.setMap(null);
		rectangle = new google.maps.Rectangle({map: map2,
		bounds: mapRECT,
		editable: true,
		draggable: true,
		strokeColor: "#FF0000",
		strokeOpacity: 0.7,
		strokeWeight: 2,
		fillColor: "#FF2323",
		fillOpacity: 0.30});
		rectangle.setMap(map2);
	  ["bounds_changed", "dragend"].forEach((eventName) => {
		rectangle.addListener(eventName, () => {
		  console.log({ bounds: rectangle.getBounds()?.toJSON(), eventName });
		  mapRECT = rectangle.getBounds()?.toJSON();
		});
	  });
}
function getCONCUR(){
    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		concurents = JSON.parse(this.responseText);
		for (let i = 0; i < dest.data.length; i++) {
			addMarkerWithTimeout2(dest.data[i].lat,dest.data[i].lng, i * 150,dest.data[i].ord,dest.data[i].couleur,dest.data[i].id,dest.data[i].adr,dest.data[i].nom,dest.data[i].heure,dest.data[i].note);
		}
	  }
	};
		xmlhttp.open('GET', 'getCONCUR.php?KEY=' + KEY + '&rtID=' + rtID + "&f=" + fDEST + "&r=" + encodeURIComponent(rDEST)
									 + '&n=' + mapRECT.north
									 + '&s=' + mapRECT.south
									 + '&e=' + mapRECT.east
									 + '&w=' + mapRECT.west , true);
		xmlhttp.send();
}

function addMarkerWithTimeout2(lat,lng, timeout,ord,couleur,id,adr,nom,heure,note) {
	var latlng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
	window.setTimeout(() => {
		var marker = new google.maps.Marker({
			position: latlng,
			map2,
			
			animation: google.maps.Animation.DROP,
			});
			var iLnk = "<a href='http://maps.apple.com/?daddr=" + lat + "," + lng + "&dirflg=d'><button class='btnMap' style='font-size:8px;padding:5px;'><span class='material-icons'>explore</span><br><span>Drive</span></button></a>";
			var isIphone = !!navigator.platform.match(/iPhone|iPod|iPad/);
			if (!isIphone){
				iLnk = "<a href='https://www.google.com/maps/dir/?api=1&destination=" + lat + "," + lng + "'><button class='btnMap' style='font-size:8px;padding:5px;border-radius:5px;'><span class='material-icons'>map</span><br><span>Drive</span></button></a>";
			}
			const contentString =
				  '<div id="content_' + id + '">'
				+ '<div class="content_header" >'
				+ "<button style='color:#000000;position:absolute;top:-10px;left:-10px;background:#ffffff;padding:5px;border-radius:20px;' onclick='mapZOOM(" + lat + "," + lng + ",18)' class='btnMap'><span class='material-icons' style='font-size:22px;vertical-align:center;' >zoom_in</span></button>"
					+ '<b style="font-size:1.5em;">' + nom + '</b>'
				+ "</div>"
				+ '<div class="content_header2">'
					+ "<p><b>" + adr + " </b></p><br><p>" + note + "</p>"
				+ "</div>"
				+ "<div class='content_body'>"
					+ "<button style='background:#555555;color:#ffffff;font-size:8px;padding:5px;border-radius:5px;' onclick='EDIT_CLI(\"" + id + "\",\"" + lng + "\",\"" + lat + "\");' class='btnMap'><span class='material-icons'>edit</span><br><span>Infos</span></button>"
					+ "<button style='font-size:8px;padding:5px;border-radius:5px;' class='btnMap' onclick='document.getElementById(\"chkCLI" + id + "\").checked = true;'><span class='material-icons'>check_box</span><br><span>Selectionner</span></button>"				
				+ "</div></div>";
			const infoWindo = new google.maps.InfoWindow({
				content: contentString,
			});
			marker.addListener('click', function() {
				activeInfoWindow&&activeInfoWindow.close();
				infoWindo.open(map2, marker);
				activeInfoWindow = infoWindo;
			});
			markers2.push(marker);

		}, timeout);
}

function drawChart2() {
    document.getElementById('chart_div2').innerHTML = "";
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Name');
	data.addColumn('string', 'Manager');
	data.addColumn('string', 'ToolTip');

	// For each orgchart box, provide the name, manager, and tooltip to show.
	data.addRows(POSITION_LIST);

	// Create the chart.
	var chart2 = new google.visualization.OrgChart(document.getElementById('chart_div2'));
	// Draw the chart, setting the allowHtml option to true for the tooltips.
	chart2.draw(data, {allowHtml:true});
}


function toggleHTML_EDITOR(){
	if(document.getElementById("txtToPDF_").style.display=="none"){
		document.getElementById("txtToPDF_").style.display="inline-block";
	} else {
		document.getElementById("txtToPDF_").style.display="none";
	}
}

function txtToOutput(){
	var doc = document.getElementById("divToPDF_OUTPUT").contentWindow.document;
	doc.open();
	doc.write(document.getElementById("txtToPDF").value);
	doc.close();
}
function pfdPLAN(){
	//var sGestionnaires = "Prenom Nom, Poste (propriétaire a %owner)<ul><li>$age ans, $experience</li><li>Principales responsabilitées</li></ul>";
	var textarea = document.getElementById("txtToPDF");
	var htmlarea = document.getElementById("divToPDF_OUTPUT");
	var splanAPERCU = document.getElementById("planAPERCU").value;if(splanAPERCU.indexOf("•")>=0) {splanAPERCU = "<ul>" + splanAPERCU.replace(/•/g, '<li>') + "</li></ul>"}
	var splanCONVENTION = document.getElementById("planCONVENTION").value;if(splanCONVENTION.indexOf("•")>=0) {splanCONVENTION = "<ul>" + splanCONVENTION.replace(/•/g, '<li>') + "</li></ul>"}
	var splanCIBLE = document.getElementById("planCIBLE").value;if(splanCIBLE.indexOf("•")>=0) {splanCIBLE = "<ul>" + splanCIBLE.replace(/•/g, '<li>') + "</li></ul>"}
	var splanTERRITOIRE = document.getElementById("planTERRITOIRE").value;if(splanTERRITOIRE.indexOf("•")>=0) {splanTERRITOIRE = "<ul>" + splanTERRITOIRE.replace(/•/g, '<li>') + "</li></ul>"}
	var splanOCCASION = document.getElementById("planOCCASION").value;if(splanOCCASION.indexOf("•")>=0) {splanOCCASION = "<ul>" + splanOCCASION.replace(/•/g, '<li>') + "</li></ul>"}
	var splanCONCURENTS = document.getElementById("planCONCURENTS").value;if(splanCONCURENTS.indexOf("•")>=0) {splanCONCURENTS = "<ul>" + splanCONCURENTS.replace(/•/g, '<li>') + "</li></ul>"}
	var splanAVANTAGE_CONCUR = document.getElementById("planAVANTAGE_CONCUR").value;if(splanAVANTAGE_CONCUR.indexOf("•")>=0) {splanAVANTAGE_CONCUR = "<ul>" + splanAVANTAGE_CONCUR.replace(/•/g, '<li>') + "</li></ul>"}
	var splanESTIMATION_VENTES = document.getElementById("planESTIMATION_VENTES").value;if(splanESTIMATION_VENTES.indexOf("•")>=0) {splanESTIMATION_VENTES = "<ul>" + splanESTIMATION_VENTES.replace(/•/g, '<li>') + "</li></ul>"}
	var splanPRODUITS = document.getElementById("planPRODUITS").value;if(splanPRODUITS.indexOf("•")>=0) {splanPRODUITS = "<ul>" + splanPRODUITS.replace(/•/g, '<li>') + "</li></ul>"}
	var splanSTRATEGIE = document.getElementById("planSTRATEGIE").value;if(splanSTRATEGIE.indexOf("•")>=0) {splanSTRATEGIE = "<ul>" + splanSTRATEGIE.replace(/•/g, '<li>') + "</li></ul>"}
	var splanCANAUX = document.getElementById("planCANAUX").value;if(splanCANAUX.indexOf("•")>=0) {splanCANAUX = "<ul>" + splanCANAUX.replace(/•/g, '<li>') + "</li></ul>"}
	var splanACTIONS = document.getElementById("planACTIONS").value;if(splanACTIONS.indexOf("•")>=0) {splanACTIONS = "<ul>" + splanACTIONS.replace(/•/g, '<li>') + "</li></ul>"}
	var splanESTIMATION_PUB = document.getElementById("planESTIMATION_PUB").value;if(splanESTIMATION_PUB.indexOf("•")>=0) {splanESTIMATION_PUB = "<ul>" + splanESTIMATION_PUB.replace(/•/g, '<li>') + "</li></ul>"}
	var splanPRODUCTION = document.getElementById("planPRODUCTION").value;if(splanPRODUCTION.indexOf("•")>=0) {splanPRODUCTION = "<ul>" + splanPRODUCTION.replace(/•/g, '<li>') + "</li></ul>"}
	var splanQUALITE = document.getElementById("planQUALITE").value;if(splanQUALITE.indexOf("•")>=0) {splanQUALITE = "<ul>" + splanQUALITE.replace(/•/g, '<li>') + "</li></ul>"}
	var splanSOURCE = document.getElementById("planSOURCE").value;if(splanSOURCE.indexOf("•")>=0) {splanSOURCE = "<ul>" + splanSOURCE.replace(/•/g, '<li>') + "</li></ul>"}
	var splanAMENAGEMENT = document.getElementById("planAMENAGEMENT").value;if(splanAMENAGEMENT.indexOf("•")>=0) {splanAMENAGEMENT = "<ul>" + splanAMENAGEMENT.replace(/•/g, '<li>') + "</li></ul>"}
	var splanIMMOBILIER_AQUIS = document.getElementById("planIMMOBILIER_AQUIS").value;if(splanIMMOBILIER_AQUIS.indexOf("•")>=0) {splanIMMOBILIER_AQUIS = "<ul>" + splanIMMOBILIER_AQUIS.replace(/•/g, '<li>') + "</li></ul>"}
	var splanIMMOBILIER_REQUIS = document.getElementById("planIMMOBILIER_REQUIS").value;if(splanIMMOBILIER_REQUIS.indexOf("•")>=0) {splanIMMOBILIER_REQUIS = "<ul>" + splanIMMOBILIER_REQUIS.replace(/•/g, '<li>') + "</li></ul>"}
	var splanINVESTISSEMENT = document.getElementById("planINVESTISSEMENT").value;if(splanINVESTISSEMENT.indexOf("•")>=0) {splanINVESTISSEMENT = "<ul>" + splanINVESTISSEMENT.replace(/•/g, '<li>') + "</li></ul>"}
	var splanRECHERCHE = document.getElementById("planRECHERCHE").value;if(splanRECHERCHE.indexOf("•")>=0) {splanRECHERCHE = "<ul>" + splanRECHERCHE.replace(/•/g, '<li>') + "</li></ul>"}
	var splanNORMES = document.getElementById("planNORMES").value;if(splanNORMES.indexOf("•")>=0) {splanNORMES = "<ul>" + splanNORMES.replace(/•/g, '<li>') + "</li></ul>"}
	var splanEMPLOIS = document.getElementById("planEMPLOIS").value;if(splanEMPLOIS.indexOf("•")>=0) {splanEMPLOIS = "<ul>" + splanEMPLOIS.replace(/•/g, '<li>') + "</li></ul>"}
	var splanPARTENAIRES = document.getElementById("planPARTENAIRES").value;if(splanPARTENAIRES.indexOf("•")>=0) {splanPARTENAIRES = "<ul>" + splanPARTENAIRES.replace(/•/g, '<li>') + "</li></ul>"}
	var splanENTENTES = document.getElementById("planENTENTES").value;if(splanENTENTES.indexOf("•")>=0) {splanENTENTES = "<ul>" + splanENTENTES.replace(/•/g, '<li>') + "</li></ul>"}
	var splanRH = document.getElementById("planRH").value;if(splanRH.indexOf("•")>=0) {splanRH = "<ul>" + splanRH.replace(/•/g, '<li>') + "</li></ul>"}
	var splanESTIMATION_COUT = document.getElementById("planESTIMATION_COUT").value;if(splanESTIMATION_COUT.indexOf("•")>=0) {splanESTIMATION_COUT = "<ul>" + splanESTIMATION_COUT.replace(/•/g, '<li>') + "</li></ul>"}
	var splanCAPITAL = document.getElementById("planCAPITAL").value;if(splanCAPITAL.indexOf("•")>=0) {splanCAPITAL = "<ul>" + splanCAPITAL.replace(/•/g, '<li>') + "</li></ul>"}
	var splanPRET_REQUIS = document.getElementById("planPRET_REQUIS").value;if(splanPRET_REQUIS.indexOf("•")>=0) {splanPRET_REQUIS = "<ul>" + splanPRET_REQUIS.replace(/•/g, '<li>') + "</li></ul>"}
	var splanBILAN_ANTERIEUR = document.getElementById("planBILAN_ANTERIEUR").value;if(splanBILAN_ANTERIEUR.indexOf("•")>=0) {splanBILAN_ANTERIEUR = "<ul>" + splanBILAN_ANTERIEUR.replace(/•/g, '<li>') + "</li></ul>"}
	var splanPREVISIONS = document.getElementById("planPREVISIONS").value;if(splanPREVISIONS.indexOf("•")>=0) {splanPREVISIONS = "<ul>" + splanPREVISIONS.replace(/•/g, '<li>') + "</li></ul>"}
	var splanBUDGET = document.getElementById("planBUDGET").value;if(splanBUDGET.indexOf("•")>=0) {splanBUDGET = "<ul>" + splanBUDGET.replace(/•/g, '<li>') + "</li></ul>"}
	var splanOFFRES = document.getElementById("planOFFRES").value;if(splanOFFRES.indexOf("•")>=0) {splanOFFRES = "<ul>" + splanOFFRES.replace(/•/g, '<li>') + "</li></ul>"}
	var splanCAPITAL_RISQUE = document.getElementById("planCAPITAL_RISQUE").value;if(splanCAPITAL_RISQUE.indexOf("•")>=0) {splanCAPITAL_RISQUE = "<ul>" + splanCAPITAL_RISQUE.replace(/•/g, '<li>') + "</li></ul>"}
	var splanEMPRUNTS = document.getElementById("planEMPRUNTS").value;if(splanEMPRUNTS.indexOf("•")>=0) {splanEMPRUNTS = "<ul>" + splanEMPRUNTS.replace(/•/g, '<li>') + "</li></ul>"}
	var splanSUBVENTION = document.getElementById("planSUBVENTION").value;if(splanSUBVENTION.indexOf("•")>=0) {splanSUBVENTION = "<ul>" + splanSUBVENTION.replace(/•/g, '<li>') + "</li></ul>"}
	var splanSCENARIO_OPTI = document.getElementById("planSCENARIO_OPTI").value;if(splanSCENARIO_OPTI.indexOf("•")>=0) {splanSCENARIO_OPTI = "<ul>" + splanSCENARIO_OPTI.replace(/•/g, '<li>') + "</li></ul>"}
	var splanSCENARIO_PESS = document.getElementById("planSCENARIO_PESS").value;if(splanSCENARIO_PESS.indexOf("•")>=0) {splanSCENARIO_PESS = "<ul>" + splanSCENARIO_PESS.replace(/•/g, '<li>') + "</li></ul>"}
	var splanSCENARIO_PROB = document.getElementById("planSCENARIO_PROB").value;if(splanSCENARIO_PROB.indexOf("•")>=0) {splanSCENARIO_PROB = "<ul>" + splanSCENARIO_PROB.replace(/•/g, '<li>') + "</li></ul>"}
	var splanCONTAB_PASSE = document.getElementById("planCONTAB_PASSE").value;if(splanCONTAB_PASSE.indexOf("•")>=0) {splanCONTAB_PASSE = "<ul>" + splanCONTAB_PASSE.replace(/•/g, '<li>') + "</li></ul>"}
	var splanCONTAB_FUTUR = document.getElementById("planCONTAB_FUTUR").value;if(splanCONTAB_FUTUR.indexOf("•")>=0) {splanCONTAB_FUTUR = "<ul>" + splanCONTAB_FUTUR.replace(/•/g, '<li>') + "</li></ul>"}
	var splanOUTILS = document.getElementById("planOUTILS").value;if(splanOUTILS.indexOf("•")>=0) {splanOUTILS = "<ul>" + splanOUTILS.replace(/•/g, '<li>') + "</li></ul>"}
	var splanPERMIS_REQUIS = document.getElementById("planPERMIS_REQUIS").value;if(splanPERMIS_REQUIS.indexOf("•")>=0) {splanPERMIS_REQUIS = "<ul>" + splanPERMIS_REQUIS.replace(/•/g, '<li>') + "</li></ul>"}
	var splanPERMIS_AQUIS = document.getElementById("planPERMIS_AQUIS").value;if(splanPERMIS_AQUIS.indexOf("•")>=0) {splanPERMIS_AQUIS = "<ul>" + splanPERMIS_AQUIS.replace(/•/g, '<li>') + "</li></ul>"}

	var sPOC = "<b>Julien Béliveau, président</b><br><a href='tel:<?php echo $CIE_TEL1; ?>' target='_blank'><?php echo $CIE_TEL1; ?></a> - <a href='tel:<?php echo $CIE_TEL2; ?>' target='_blank'><?php echo $CIE_TEL2; ?></a><br><a href='mailto:<?php echo $CIE_EML1; ?>'><?php echo $CIE_EML1; ?></a><br><a href='<?php echo $CIE_HOME; ?>' target='_blank'><?php echo $CIE_HOME; ?></a><br><br>";

    //header added after for css depending on output print, pdf, doc
	//page1
    var html = "<div class='main'><div class='bg' style='height:400px;'><img style='height:150px;width:auto;margin:240px 0px 20px 20px;' src='/pub/img/<?php echo $CIE_LOGO1;?>'></div>\n"
            + "<div class='page' style='padding:20px 20px 0px 20px;'><h3><?php echo $CIE_NOM; ?></h3>\n";

	html 	+= "<h1>Plan d'affaire</h1><br><br>\n"
				+ "<b>Préparé le</b><br>"
				+ "18 février 2023"
				+ "</div>\n"
				+ "<table style='width:100%;margin-top:320px;'><tr><th style='width:50%;border: 0px solid #333;'>Coordonées</th><th style='width:50%;border: 0px solid #333;'>Adresse de l'entreprise</th></tr>"
				+ " <tr><td style='border: 0px solid #333;'>" + sPOC + "</td><td style='border: 0px solid #333;border-left:1px solid #777;padding-bottom:20px;'>" + $CIE_ADR + "</td></tr>"
				+ "</table></div>\n";
	html += "<div id='footer'><table style='width:100%;'><tr><th style='width:50px;border: 0px solid #333;'>&#160;&#160;</th><th style='border:0px solid grey;'>Copyright &copy; <?php echo date("Y");?></th><th style='width:50px;border: 0px solid #333;'><span class='page-number'>Page </span></th></tr></table></div>";
	
    //++ajouter table des matieres. codes pour les liens internes dompdf:
    //<div style="page-break-after: always;"><a href="#blah">blah</a></div>
    //<div><a name="blah">link location</a></div>


    //sommaire
	html += "\n\n<div style='page-break-before: always;'> </div><div class='bg'><h1>Sommaire<img style='position:fixed;top:10px;right:10px;height:50px;width:auto;margin:5px 0px 0px 0px;' src='/pub/img/<?php echo $CIE_LOGO1;?>'></h1></div>"
			+ "<div class='page'><h3>Objectifs du projet</h3><hr>"
			+ splanPREVISIONS + "<br>\n"
			+ "<h3>Description de l'entreprise</h3><hr>"
			+ splanAPERCU + "<br>\n"
			+ "<h3>Produits et services</h3><hr>"
			+ splanPRODUITS + "<br>\n"
			+ "<div style='page-break-inside: avoid;padding-top:40px;'><h3>Besoins en financement</h3><hr>"
			+ splanPRET_REQUIS + "</div><br>\n"
			+ "<div style='page-break-inside: avoid;padding-top:40px;'><h3>Personnes clés</h3><hr>"
			+ sPOC + "</div><br>\n"
			+ "<div style='page-break-inside: avoid;padding-top:40px;'><h3>Évaluations des risques et plan d'urgence</h3><hr>"
			+ splanSCENARIO_PESS + "</div>\n"
			+ "</div>";

	//apercu de lentreprise
	html += "\n\n<div style='page-break-before: always;'> </div><div class='bg'><h1>Aperçu de l'entreprise<img style='position:fixed;top:10px;right:10px;height:50px;width:auto;margin:5px 0px 0px 0px;' src='https://<?php echo $_SERVER["SERVER_NAME"];?>/pub/img/<?php echo $CIE_LOGO1;?>'></h1></div><div class='page'>";
	if(splanAPERCU !=""){html += "<h3> Description de l'entreprise</h3><hr>" + splanAPERCU + "<br>\n";}
	if(splanCONVENTION !=""){html += "<h3> Convention des actionnaires</h3><hr>" + splanCONVENTION + "<br>\n";}
	if(splanPRODUITS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Territoire cible</h3><hr>" + splanPRODUITS + "</div><br>\n";}
	html += "<h2>Étude de marché</h2>"
	if(splanCIBLE !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Clientèle cible</h3><hr>" + splanCIBLE + "</div><br>\n";}
	if(splanTERRITOIRE !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Territoire cible</h3><hr>" + splanTERRITOIRE + "</div><br>\n";}
	if(splanOCCASION !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Occasions d'affaires</h3><hr>" + splanOCCASION + "</div><br>\n";}
	if(splanCONCURENTS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Concurrence</h3><hr>" + splanCONCURENTS + "</div><br>\n";}
	if(splanAVANTAGE_CONCUR !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Avantages concurentiels</h3><hr>" + splanAVANTAGE_CONCUR + "</div><br>\n";}
	html += "</div>";

	//Ventes et marketing
	html += "\n\n<div style='page-break-before: always;'> </div><div class='bg'><h1>Ventes et marketing<img style='position:fixed;top:10px;right:10px;height:50px;width:auto;margin:5px 0px 0px 0px;' src='https://<?php echo $_SERVER["SERVER_NAME"];?>/pub/img/<?php echo $CIE_LOGO1;?>'></h1></div><div class='page'>";
	if(splanESTIMATION_VENTES !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Estimations des ventes</h3><hr>" + splanESTIMATION_VENTES + "</div><br>\n";}
	if(splanSTRATEGIE !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Stratégie marketing</h3><hr>" + splanSTRATEGIE + "</div><br>\n";}
	if(splanCANAUX !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Canaux de distribution</h3><hr>" + splanCANAUX + "</div><br>\n";}
	if(splanACTIONS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Publicités et évènements</h3><hr>" + splanACTIONS + "</div><br>\n";}
	if(splanESTIMATION_PUB !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Estimation du cout annuel en publicité</h3><hr>" + splanESTIMATION_PUB + "</div><br>\n";}
	html += "</div>";

	//plan d'operation
	html += "\n\n<div style='page-break-before: always;'> </div><div class='bg'><h1>Plan d'opération<img style='position:fixed;top:10px;right:10px;height:50px;width:auto;margin:5px 0px 0px 0px;' src='https://<?php echo $_SERVER["SERVER_NAME"];?>/pub/img/<?php echo $CIE_LOGO1;?>'></h1></div><div class='page'>";
	if(splanPRODUCTION !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Méthodes de production</h3><hr>" + splanPRODUCTION + "</div><br>\n";}
	if(splanQUALITE !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Assurance qualité</h3><hr>" + splanQUALITE + "</div><br>\n";}
	if(splanSOURCE !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Sources</h3><hr>" + splanSOURCE + "</div><br>\n";}
	if(splanAMENAGEMENT !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Aménagement</h3><hr>" + splanAMENAGEMENT + "</div><br>\n";}
	if(splanIMMOBILIER_AQUIS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Immobilier</h3><hr>" + splanIMMOBILIER_AQUIS + "</div><br>\n";}
	if(splanIMMOBILIER_REQUIS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Immobilier à acquérir</h3><hr>" + splanIMMOBILIER_REQUIS + "</div><br>\n";}
	if(splanINVESTISSEMENT !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Investissements</h3><hr>" + splanINVESTISSEMENT + "</div><br>\n";}
	if(splanRECHERCHE !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Recherches</h3><hr>" + splanRECHERCHE + "</div><br>\n";}
	if(splanNORMES !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Normes</h3><hr>" + splanNORMES + "</div><br>\n";}
	html += "</div>";

	//employés
	html += "\n\n<div style='page-break-before: always;'> </div><div class='bg'><h1>Employés<img style='position:fixed;top:10px;right:10px;height:50px;width:auto;margin:5px 0px 0px 0px;' src='https://<?php echo $_SERVER["SERVER_NAME"];?>/pub/img/<?php echo $CIE_LOGO1;?>'></h1></div><div class='page'>";
	if(splanEMPLOIS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Emplois</h3><hr>" + splanEMPLOIS + "</div><br>\n";}
	if(splanPARTENAIRES !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Partenaires</h3><hr>" + splanPARTENAIRES + "</div><br>\n";}
	if(splanENTENTES !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Ententes</h3><hr>" + splanENTENTES + "</div><br>\n";}
	if(splanRH !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Ressources humaines</h3><hr>" + splanRH + "</div><br>\n";}
	html += "</div>";


	//plan d'action
	html += "\n\n<div style='page-break-before: always;'> </div><div class='bg'><h1>Plan d'action<img style='position:fixed;top:10px;right:10px;height:50px;width:auto;margin:5px 0px 0px 0px;' src='https://<?php echo $_SERVER["SERVER_NAME"];?>/pub/img/<?php echo $CIE_LOGO1;?>'></h1></div><div class='page'>";
	if(splanESTIMATION_COUT !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Estimation du cout</h3><hr>" + splanESTIMATION_COUT + "</div><br>\n";}
	if(splanCAPITAL !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Capital d'ouverture</h3><hr>" + splanCAPITAL + "</div><br>\n";}
	if(splanPRET_REQUIS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Prêt requis</h3><hr>" + splanPRET_REQUIS + "</div><br>\n";}
	if(splanBILAN_ANTERIEUR !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Bilans antérieurs</h3><hr>" + splanBILAN_ANTERIEUR + "</div><br>\n";}
	if(splanPREVISIONS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Prévision budgétaire</h3><hr>" + splanPREVISIONS + "</div><br>\n";}
	if(splanBUDGET !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Budget actuel</h3><hr>" + splanBUDGET + "</div><br>\n";}
	if(splanOFFRES !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Offres d'affaires</h3><hr>" + splanOFFRES + "</div><br>\n";}
	if(splanCAPITAL_RISQUE !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Capital à risque</h3><hr>" + splanCAPITAL_RISQUE + "</div><br>\n";}
	if(splanEMPRUNTS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Emprunts</h3><hr>" + splanEMPRUNTS + "</div><br>\n";}
	if(splanSUBVENTION !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Subventions</h3><hr>" + splanSUBVENTION + "</div><br>\n";}
	if(splanSCENARIO_OPTI !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Scénario optimiste</h3><hr>" + splanSCENARIO_OPTI + "</div><br>\n";}
	if(splanSCENARIO_PESS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Scénario pessimiste</h3><hr>" + splanSCENARIO_PESS + "</div><br>\n";}
	if(splanSCENARIO_PROB !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Scénario probable</h3><hr>" + splanSCENARIO_PROB + "</div><br>\n";}
	if(splanCONTAB_PASSE !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Comtabilité passée</h3><hr>" + splanCONTAB_PASSE + "</div><br>\n";}
	if(splanCONTAB_FUTUR !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Comtabilité future</h3><hr>" + splanCONTAB_FUTUR + "</div><br>\n";}
	if(planOUTILS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Outils technologiques</h3><hr>" + splanOUTILS + "</div><br>\n";}
	if(planPERMIS_AQUIS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Permis acquis</h3><hr>" + splanPERMIS_AQUIS + "</div><br>\n";}
	if(planPERMIS_REQUIS !=""){html += "<div style='page-break-inside: avoid;padding-top:40px;'><h3> Permis requis</h3><hr>" + splanPERMIS_REQUIS + "</div><br>\n";}
	html += "</div></body></html>"; 

	var doc = htmlarea.contentWindow.document;
		doc.open();
		doc.write("<html><head><link rel='stylesheet' href='https://dev.ww7.ca/css/imp.css'></head><body>\n" + html);
		doc.close();
	
	textarea.value = html;
	document.getElementById("divToPDF").style.display = "inline-block";
}
//pdf version serveur php
function makePDF_PLAN() {  
    var html = "<html><head><link rel='stylesheet' href='https://dev.ww7.ca/css/pdf.css'></head><body>\n"
            + encodeURIComponent(document.getElementById("txtToPDF").value);
	var url = "makePDF_PLAN.php?KEY="+KEY;

 	fetch("makePDF_PLAN.php?KEY="+KEY, {
	method: "POST",
	headers: {'Content-Type': 'application/x-www-form-urlencoded'}, 
	body: html
	}).then(res => {
		//console.log("Request complete! response:", res);
		//alert (res.text());
		window.open('readPDF_PLAN.php?KEY='+KEY, "_blank");
	}); 
	//alert (encodeURIComponent(html).length);
	//window.open('makePDF_PLAN.php?KEY='+KEY+"&HTML="+encodeURIComponent(html), "_blank");
}
//docx version js client
function makeDOCX_PLAN() {
    //var html = document.getElementById("txtToPDF").value;
    Export2Word("txtToPDF", "Plan2023")
	//window.open('makePDF_PLAN.php?KEY='+KEY+"&HTML="+encodeURIComponent(html), "_blank");
}
function Export2Word(element, filename = ''){
    var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
    var postHtml = "</body></html>";
    var html = preHtml+document.getElementById(element).value+postHtml;

    var blob = new Blob(['\ufeff', html], {
        type: 'application/msword'
    });
    
    // Specify link url
    var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
    
    // Specify file name
    filename = filename?filename+'.docx':'document.docx';
    
    // Create download link element
    var downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob ){
        navigator.msSaveOrOpenBlob(blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = url;
        
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
    
    document.body.removeChild(downloadLink);
}
//impression du plan par le navigateur
function printPLAN() {
    let obj=document.getElementById("txtToPDF");
    let fn="Plan2023.pdf";
    let mywindow = window.open('${fn}', 'PRINT', 'height=650,width=900,top=100,left=150');
    var html = "<html><head><link rel='stylesheet' href='/css/imp.css'></head><body>\n"
            + obj.value;
    //mywindow.document.write(`<html><head><link type="text/css" rel="stylesheet" media="print" href="https://dw3.ca/imp.css"><title>${fn}</title>`);
    //mywindow.document.write('</head><body>');
    mywindow.document.write(html);
    //mywindow.document.write('</body></html>');
    
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/
    mywindow.print();
    mywindow.close();
    return true;
}

//fonction pour modifier le html du plan avant sa sortie en pdf
function addTag(obj,tag){
	var textarea = document.getElementById(obj);
	var start = textarea.selectionStart;
    var finish = textarea.selectionEnd;
    var sel = textarea.value.substring(start, finish);
	if (tag=="B"){
		textarea.value = textarea.value.substring(0, start) + "<b>" + sel + "</b>" + textarea.value.substring(finish,textarea.value.length);
	} else 	if (tag=="U"){
		textarea.value = textarea.value.substring(0, start) + "<u>" + sel + "</u>" + textarea.value.substring(finish,textarea.value.length);
	} else 	if (tag=="I"){
		textarea.value = textarea.value.substring(0, start) + "<i>" + sel + "</i>" + textarea.value.substring(finish,textarea.value.length);
	} else 	if (tag=="EXP"){
		textarea.value = textarea.value.substring(0, start) + "<sup>" + sel + "</sup>" + textarea.value.substring(finish,textarea.value.length);
	}
	txtToOutput();
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
	}
}

function fitText(that) {
    that.style.height = "";
    if (that.scrollHeight>40){
        that.style.height = that.scrollHeight + 2 + "px";
    }
}

function savePLAN(){
	var GRPBOX  = document.getElementById("cfgTYPE");
	var sTYPE  = GRPBOX.options[GRPBOX.selectedIndex].value;
	var GRPBOX  = document.getElementById("cfgCAT");
	var sCAT  = GRPBOX.options[GRPBOX.selectedIndex].value;

	if (document.getElementById("chkTYPE").checked == true){sCTYPE = "true"; } else {sCTYPE = "false"; }
	if (document.getElementById("chkCAT").checked == true){sCCAT = "true"; } else {sCCAT = "false"; }
	if (document.getElementById("chkAPERCU").checked == true){sCAPERCU = "true"; } else {sCAPERCU = "false"; }

    var splanAPERCU= document.getElementById("planAPERCU").value;
    var splanCONVENTION= document.getElementById("planCONVENTION").value;
    var splanCIBLE= document.getElementById("planCIBLE").value;
    var splanTERRITOIRE= document.getElementById("planTERRITOIRE").value;
    var splanOCCASION= document.getElementById("planOCCASION").value;
    var splanCONCURENTS= document.getElementById("planCONCURENTS").value;
    var splanAVANTAGE_CONCUR= document.getElementById("planAVANTAGE_CONCUR").value;
    var splanESTIMATION_VENTES= document.getElementById("planESTIMATION_VENTES").value;
    var splanPRODUITS= document.getElementById("planPRODUITS").value;
    var splanSTRATEGIE= document.getElementById("planSTRATEGIE").value;
    var splanCANAUX= document.getElementById("planCANAUX").value;
    var splanACTIONS= document.getElementById("planACTIONS").value;
    var splanESTIMATION_PUB= document.getElementById("planESTIMATION_PUB").value;
    var splanPRODUCTION= document.getElementById("planPRODUCTION").value;
    var splanQUALITE= document.getElementById("planQUALITE").value;
    var splanSOURCE= document.getElementById("planSOURCE").value;
    var splanAMENAGEMENT= document.getElementById("planAMENAGEMENT").value;
    var splanIMMOBILIER_AQUIS= document.getElementById("planIMMOBILIER_AQUIS").value;
    var splanIMMOBILIER_REQUIS= document.getElementById("planIMMOBILIER_REQUIS").value;
    var splanINVESTISSEMENT= document.getElementById("planINVESTISSEMENT").value;
    var splanRECHERCHE= document.getElementById("planRECHERCHE").value;
    var splanNORMES= document.getElementById("planNORMES").value;
    var splanEMPLOIS= document.getElementById("planEMPLOIS").value;
    var splanPARTENAIRES= document.getElementById("planPARTENAIRES").value;
    var splanPERMIS_REQUIS= document.getElementById("planPERMIS_REQUIS").value;
    var splanPERMIS_AQUIS= document.getElementById("planPERMIS_AQUIS").value;
    var splanENTENTES= document.getElementById("planENTENTES").value;
    var splanRH= document.getElementById("planRH").value;
    var splanESTIMATION_COUT= document.getElementById("planESTIMATION_COUT").value;
    var splanCAPITAL= document.getElementById("planCAPITAL").value;
    var splanPRET_REQUIS= document.getElementById("planPRET_REQUIS").value;
    var splanBILAN_ANTERIEUR= document.getElementById("planBILAN_ANTERIEUR").value;
    var splanPREVISIONS= document.getElementById("planPREVISIONS").value;
    var splanBUDGET= document.getElementById("planBUDGET").value;
    var splanOFFRES= document.getElementById("planOFFRES").value;
    var splanCAPITAL_RISQUE= document.getElementById("planCAPITAL_RISQUE").value;
    var splanEMPRUNTS= document.getElementById("planEMPRUNTS").value;
    var splanSUBVENTION= document.getElementById("planSUBVENTION").value;
    var splanSCENARIO_OPTI= document.getElementById("planSCENARIO_OPTI").value;
    var splanSCENARIO_PESS= document.getElementById("planSCENARIO_PESS").value;
    var splanSCENARIO_PROB= document.getElementById("planSCENARIO_PROB").value;
    var splanCONTAB_PASSE= document.getElementById("planCONTAB_PASSE").value;
    var splanCONTAB_FUTUR= document.getElementById("planCONTAB_FUTUR").value;
    var splanOUTILS= document.getElementById("planOUTILS").value;

	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
        addNotif(this.responseText);
	  }
	};
		xmlhttp.open('GET', 'updPLAN.php?KEY=' + KEY 
										+ '&TYPE=' + encodeURIComponent(sTYPE)
										+ '&CTYPE=' + encodeURIComponent(sCTYPE)
										+ '&CAT=' + encodeURIComponent(sCAT)
										+ '&CCAT=' + encodeURIComponent(sCCAT)
										+ '&APERCU=' + encodeURIComponent(splanAPERCU)
										+ '&CAPERCU=' + encodeURIComponent(sCAPERCU)
										+ '&CONVENTION=' + encodeURIComponent(splanCONVENTION)
										+ '&CIBLE=' + encodeURIComponent(splanCIBLE)
										+ '&TERRITOIRE=' + encodeURIComponent(splanTERRITOIRE)
										+ '&OCCASION=' + encodeURIComponent(splanOCCASION)
										+ '&CONCURENTS=' + encodeURIComponent(splanCONCURENTS)
										+ '&AVANTAGE_CONCUR=' + encodeURIComponent(splanAVANTAGE_CONCUR)
										+ '&ESTIMATION_VENTES=' + encodeURIComponent(splanESTIMATION_VENTES)
										+ '&PRODUITS=' + encodeURIComponent(splanPRODUITS)
										+ '&STRATEGIE=' + encodeURIComponent(splanSTRATEGIE)
										+ '&CANAUX=' + encodeURIComponent(splanCANAUX)
										+ '&ACTIONS=' + encodeURIComponent(splanACTIONS)
										+ '&ESTIMATION_PUB=' + encodeURIComponent(splanESTIMATION_PUB)
										+ '&PRODUCTION=' + encodeURIComponent(splanPRODUCTION)
										+ '&QUALITE=' + encodeURIComponent(splanQUALITE)
										+ '&SOURCE=' + encodeURIComponent(splanSOURCE)
										+ '&AMENAGEMENT=' + encodeURIComponent(splanAMENAGEMENT)
										+ '&IMMOBILIER_AQUIS=' + encodeURIComponent(splanIMMOBILIER_AQUIS)
										+ '&IMMOBILIER_REQUIS=' + encodeURIComponent(splanIMMOBILIER_REQUIS)
										+ '&INVESTISSEMENT=' + encodeURIComponent(splanINVESTISSEMENT)
										+ '&RECHERCHE=' + encodeURIComponent(splanRECHERCHE)
										+ '&NORMES=' + encodeURIComponent(splanNORMES)
										+ '&EMPLOIS=' + encodeURIComponent(splanEMPLOIS)
										+ '&PARTENAIRES=' + encodeURIComponent(splanPARTENAIRES)
										+ '&PERMIS_REQUIS=' + encodeURIComponent(splanPERMIS_REQUIS)
										+ '&PERMIS_AQUIS=' + encodeURIComponent(splanPERMIS_AQUIS)
										+ '&ENTENTES=' + encodeURIComponent(splanENTENTES)
										+ '&RH=' + encodeURIComponent(splanRH)
										+ '&ESTIMATION_COUT=' + encodeURIComponent(splanESTIMATION_COUT)
										+ '&CAPITAL=' + encodeURIComponent(splanCAPITAL)
										+ '&PRET_REQUIS=' + encodeURIComponent(splanPRET_REQUIS)
										+ '&BILAN_ANTERIEUR=' + encodeURIComponent(splanBILAN_ANTERIEUR)
										+ '&PREVISIONS=' + encodeURIComponent(splanPREVISIONS)
										+ '&BUDGET=' + encodeURIComponent(splanBUDGET)
										+ '&OFFRES=' + encodeURIComponent(splanOFFRES)
										+ '&CAPITAL_RISQUE=' + encodeURIComponent(splanCAPITAL_RISQUE)
										+ '&EMPRUNTS=' + encodeURIComponent(splanEMPRUNTS)
										+ '&SUBVENTION=' + encodeURIComponent(splanSUBVENTION)
										+ '&SCENARIO_OPTI=' + encodeURIComponent(splanSCENARIO_OPTI)
										+ '&SCENARIO_PESS=' + encodeURIComponent(splanSCENARIO_PESS)
										+ '&SCENARIO_PROB=' + encodeURIComponent(splanSCENARIO_PROB)
										+ '&CONTAB_PASSE=' + encodeURIComponent(splanCONTAB_PASSE)
										+ '&CONTAB_FUTUR=' + encodeURIComponent(splanCONTAB_FUTUR)
										+ '&OUTILS=' + encodeURIComponent(splanOUTILS),
										true);
		xmlhttp.send();
}

</script>
<?php if ($CIE_GMAP_KEY!=""){ ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $CIE_GMAP_KEY; ?>&callback=initMap&v=weekly" defer ></script>
<?php } ?>
</body>
</html>
<?php $dw3_conn->close();exit(); ?>
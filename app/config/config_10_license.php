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
$APNAME = "Licenses, politiques, conditions et sitemap";
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
                    <option value="/app/config/config_6_display.php"> Affichage </option>
                    <option value="/app/config/config_7_index.php"> Index & Pages Web </option>
                    <option value="/app/config/config_8_api.php"> API's, IA's et Réseaux Sociaux</option>
                    <option value="/app/config/config_9_update.php"> Mises à jour & Sécurité </option>
                    <option selected value="/app/config/config_10_license.php"> Licenses, politiques, conditions et sitemap </option>
                </select>
            </td>
		</tr>
	</table>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>

<div class='divMAIN' style="padding-top:50px;">
    <div class='divPAGE' style='padding-top:20px;background:#FFF;text-align:middle; display:inline-block;'>
        <!-- PRIVACY -->
        <div class="divBOX" style='max-width:90%;'><h2>Politique de confidentialité</h2></div>
        <div style='text-align:left;font-size:1.4em;margin:0px 20px;'><a href='/legal/PRIVACY.html' target='_blank'>/legal/PRIVACY.html</a></div>
            <form method="POST" action="updPRIVACY.php<?php echo "?KEY=".$KEY;?>">
                <textarea name="privacy_html" rows=10 id='dw3_PRIVACY' style='max-width:95%; padding:0px;margin:5px 5px;text-align:left;overflow-wrap: break-word;white-space: pre-wrap; display:inline-block;font-size:0.7em;font-family:Roboto;'><?php
                if (filesize($req_root . "/legal/PRIVACY.html") > 0){
                    $myfile = fopen($req_root . "/legal/PRIVACY.html", "r")??null;
                    $HTML = fread($myfile,filesize($req_root . "/legal/PRIVACY.html"))??null;
                    fclose($myfile);
                    echo $HTML;
                }
                ?></textarea><input type="submit" value="Sauvegarder" onclick="addNotif('Sauvegarde en cours..')" /></form><br>Dernière modification:
            <?php echo date("Y-m-d", filemtime($req_root . "/legal/PRIVACY.html")); ?>
    </div>
    <div class='divPAGE' style='padding-top:20px;background:#FFF;text-align:middle; display:inline-block;'>
        <!-- RETURNS -->
        <div class="divBOX" style='max-width:90%;'><h2>Politique d'expéditions et de retours</h2></div>
        <div style='text-align:left;font-size:1.4em;margin:0px 20px;'><a href='/legal/RETURNS.html' target='_blank'>/legal/RETURNS.html</a></div>
            <form method="POST" action="updRETURNS.php<?php echo "?KEY=".$KEY;?>">
                <textarea name="returns_html" rows=10 id='dw3_RETURNS' style='max-width:95%; padding:0px;margin:5px 5px;text-align:left;overflow-wrap: break-word;white-space: pre-wrap; display:inline-block;font-size:0.7em;font-family:Roboto;'><?php
                if (filesize($req_root . "/legal/RETURNS.html") > 0){
                    $myfile = fopen($req_root . "/legal/RETURNS.html", "r")??null;
                    $HTML = fread($myfile,filesize($req_root . "/legal/RETURNS.html"))??null;
                    fclose($myfile);
                    echo $HTML;
                }
                ?></textarea><input type="submit" value="Sauvegarder" onclick="addNotif('Sauvegarde en cours..')" /></form><br>Dernière modification:
            <?php echo date("Y-m-d", filemtime($req_root . "/legal/PRIVACY.html")); ?>
    </div>
    <div class='divPAGE' style='padding-top:20px;background:#FFF;text-align:middle; display:inline-block;'>
            <!-- CONDITIONS -->
        <div class="divBOX" style='max-width:90%;'><h2>Conditions d'utilisation</h2></div>
        <div style='text-align:left;font-size:1.4em;margin:0px 20px;'><a href='/legal/CONDITIONS.html' target='_blank'>/legal/CONDITIONS.html</a></div>
        <form method="POST" action="updCONDITIONS.php<?php echo "?KEY=".$KEY;?>">
                <textarea name="conditions_html" rows=10 id='dw3_CONDITIONS' style='max-width:95%; padding:0px;margin:5px 5px;text-align:left;overflow-wrap: break-word;white-space: pre-wrap; display:inline-block;font-size:0.7em;font-family:Roboto;'><?php
                if (filesize($req_root . "/legal/CONDITIONS.html") > 0){
                    $myfile = fopen($req_root . "/legal/CONDITIONS.html", "r")??null;
                    $HTML = fread($myfile,filesize($req_root . "/legal/CONDITIONS.html"))??null;
                    fclose($myfile);
                    echo $HTML;
                }
                ?></textarea><input type="submit" value="Sauvegarder" onclick="addNotif('Sauvegarde en cours..')" /></form><br>Dernière modification:
            <?php echo date("Y-m-d", filemtime($req_root . "/legal/CONDITIONS.html")); ?>
    </div>
    <div class='divPAGE' style='padding-top:20px;background:#FFF;text-align:middle; display:inline-block;'>
            <!-- LICENSE -->
        <div class="divBOX" style='max-width:90%;'><h2>License</h2></div>
        <div style='text-align:left;font-size:1.4em;margin:0px 20px;'><a href='/legal/LICENSE.html' target='_blank'>/legal/LICENSE.html</a></div>
            <form method="POST" action="updLICENSE.php<?php echo "?KEY=".$KEY;?>">
                <textarea name="license_html" rows=10 id='dw3_LICENSE' style='max-width:95%; padding:0px;margin:5px 5px;text-align:left;overflow-wrap: break-word;white-space: pre-wrap; display:inline-block;font-size:0.7em;font-family:Roboto;'><?php
                if (filesize($req_root . "/legal/LICENSE.html") > 0){
                    $myfile = fopen($req_root . "/legal/LICENSE.html", "r")??null;
                    $HTML = fread($myfile,filesize($req_root . "/legal/LICENSE.html"))??null; 
                    fclose($myfile);
                    echo $HTML;
                }
                ?></textarea><input type="submit" value="Sauvegarder" onclick="addNotif('Sauvegarde en cours..')" /></form><br>Dernière modification:
            <?php echo date("Y-m-d", filemtime($req_root . "/legal/LICENSE.html")); ?>
    </div>
    <div class='divPAGE' style='padding-top:20px;background:#FFF;text-align:middle; display:inline-block;'>
            <!-- ROBOT -->
        <div class="divBOX" style='max-width:90%;'><h2>Robots</h2></div>
        <div style='text-align:left;font-size:1.4em;margin:0px 20px;'><a href='/robot.txt' target='_blank'>/robots.txt</a></div>
            <form method="POST" action="updROBOT.php<?php echo "?KEY=".$KEY;?>">
                <textarea name="robots_txt" rows=10 id='dw3_ROBOT' style='max-width:95%; padding:0px;margin:5px 5px;text-align:left;overflow-wrap: break-word;white-space: pre-wrap; display:inline-block;font-size:0.7em;font-family:Roboto;'><?php
                if (filesize($req_root . "/robots.txt") > 0){
                    $myfile = fopen($req_root . "/robots.txt", "r")??null;
                    $HTML = fread($myfile,filesize($req_root . "/robots.txt"))??null;
                    fclose($myfile);
                    echo $HTML;
                }
                ?></textarea><input type="submit" value="Sauvegarder" onclick="addNotif('Sauvegarde en cours..')" /></form><br>Dernière modification:
            <?php echo date("Y-m-d", filemtime($req_root . "/robots.txt")); ?>
    </div>
    <div class='divPAGE' style='padding-top:20px;background:#FFF;text-align:middle; display:inline-block;'>
            <!-- SITEMAP -->
        <div class="divBOX" style='max-width:90%;'><h2>Sitemap</h2></div>
        <div style='text-align:left;font-size:1.4em;margin:0px 20px;'><a href='/sitemap.xml' target='_blank'>/sitemap.xml</a></div>
            <form method="POST" action="updSITEMAP.php<?php echo "?KEY=".$KEY;?>">
                <textarea name="sitemap_xml" rows=10 id='dw3_SITEMAP' style='max-width:95%; padding:0px;margin:5px 5px;text-align:left;overflow-wrap: break-word;white-space: pre-wrap; display:inline-block;font-size:0.7em;font-family:Roboto;'><?php
                if (filesize($req_root . "/sitemap.xml") > 0){
                    $myfile = fopen($req_root . "/sitemap.xml", "r")??null;
                    $HTML = fread($myfile,filesize($req_root . "/sitemap.xml"))??null;
                    fclose($myfile);
                    echo $HTML;
                }
                ?></textarea><input type="submit" value="Sauvegarder" onclick="addNotif('Sauvegarde en cours..')" /></form><br>Dernière modification:
            <?php echo date("Y-m-d", filemtime($req_root . "/sitemap.xml")); ?>
        </div>
    </div>
    <div class='divPAGE' style='padding-top:20px;background:#FFF;text-align:middle; display:inline-block;'>
            <!-- MANIFEST -->
        <div class="divBOX" style='max-width:90%;'><h2>Manifest</h2></div>
        <div style='text-align:left;font-size:1.4em;margin:0px 20px;'><a href='/manifest.json' target='_blank'>/manifest.json</a></div>
            <form method="POST" action="updMANIFEST.php<?php echo "?KEY=".$KEY;?>">
                <textarea name="manifest_json" rows=10 id='dw3_MANIFEST' style='max-width:95%; padding:0px;margin:5px 5px;text-align:left;overflow-wrap: break-word;white-space: pre-wrap; display:inline-block;font-size:0.7em;font-family:Roboto;'><?php
                if (filesize($req_root . "/manifest.json") > 0){
                    $myfile = fopen($req_root . "/manifest.json", "r")??null;
                    $HTML = fread($myfile,filesize($req_root . "/manifest.json"))??null;
                    fclose($myfile);
                    echo $HTML;
                }
                ?></textarea><input type="submit" value="Sauvegarder" onclick="addNotif('Sauvegarde en cours..')" /></form><br>Dernière modification:
            <?php echo date("Y-m-d", filemtime($req_root . "/manifest.json")); ?>
        </div>
    </div>
</div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';

$(document).ready(function (){
    document.getElementById('config_select').value="/app/config/config_10_license.php";
});
window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    window.location.reload();
  }
});
</script>
</body>
</html>
<?php $dw3_conn->close();exit(); ?>
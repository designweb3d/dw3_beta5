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
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/sbin/hash.ini")) {
    $dw3_read_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/hash.ini");
    if (isset($dw3_read_ini["cryptk"])){
        $DECRYPTKEY = $dw3_read_ini["cryptk"];
    } else {
        $DECRYPTKEY = "";
    }
} else {
    $DECRYPTKEY = "";
}
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/sbin/hash_master.ini")) {
    $dw3_read_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/sbin/hash_master.ini");
    if (isset($dw3_read_ini["masterk"])){
        $MASTERKEY = $dw3_read_ini["masterk"];
    } else {
        $MASTERKEY = "";
    }
} else {
    $MASTERKEY = "";
}
?>
<div id="divHEAD">
	<table style="width:100%;margin:0px;white-space:nowrap;margin-top:5px;">
		<tr style="margin:0px;padding:0px;">
			<td width="*">
                <select onchange="window.open(this.value+'?KEY='+KEY,'_self')">
                    <option selected value="/app/config/config.php"> Tableau de Bord </option>
                    <option value="/app/config/config_1_info.php"> Infos générales & Facturation </option>
                    <option value="/app/config/config_2_location.php"> Adresses et Divisions </option>
                    <option value="/app/config/config_3_structure.php"> Structure de l'Entreprise </option>
                    <option value="/app/config/config_4_gouv.php"> Renseignements Gouvernementaux </option>
                    <option value="/app/config/config_5_plan.php"> Plan d'Affaire </option>
                    <option value="/app/config/config_6_display.php"> Affichage </option>
                    <option value="/app/config/config_7_index.php"> Index & Pages Web </option>
                    <option value="/app/config/config_8_api.php"> API's, IA's et Réseaux Sociaux</option>
                    <option value="/app/config/config_9_update.php"> Mises à jour & Sécurité </option>
                    <option value="/app/config/config_10_license.php"> Licenses, Politiques, Conditions et Sitemap </option>
                </select>
            </td>
		</tr>
	</table>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>

<div class='divMAIN' style="background:transparent;margin-top:50px;">
    <div class='divBOX' style='max-width:none;'>
            <?php
            //EMPLOYÉS
            $sql = "SELECT DISTINCT stat, count(stat) as status_count FROM user GROUP BY stat;";
            $result = $dw3_conn->query($sql);
            $row_count = $result->num_rows;
            echo "<table class='tblDATA'>
            <tr><th colspan=2  style='cursor:default;'>Employés</th></tr>";
            if ($row_count > 0) {		
                while($row = $result->fetch_assoc()) {
                    $stat_desc = "Inconnu";
                    if ($row["stat"]=="1" && $row["status_count"] > 1){
                        $stat_desc = "Inactifs";
                    }else if ($row["stat"]=="1" && $row["status_count"] == 1){
                        $stat_desc = "Inactif";
                    }else if ($row["stat"]=="0" && $row["status_count"] > 1){
                        $stat_desc = "Actifs";
                    }else if ($row["stat"]=="0" && $row["status_count"] == 1){
                        $stat_desc = "Actif";
                    }else if ($row["stat"]=="2" && $row["status_count"] > 1){
                        $stat_desc = "Suspendus";
                    }else if ($row["stat"]=="2" && $row["status_count"] == 1){
                        $stat_desc = "Suspendu";
                    }
                    echo "<tr>"
                        . "<td style='width:100px;text-align:center;'><b>". $row["status_count"] . "</b></td>"
                        . "<td width='*'>". $stat_desc ."</td>"
                        . "</tr>";
                }
            } else {
                echo "<tr><td>Aucun employé trouvé</td></tr>";
            }
            echo "</table>";
            ?>
    </div>
    <div class='divBOX' style='max-width:none;'>
            <?php
            //CLIENTS
            $sql = "SELECT DISTINCT stat, count(stat) as status_count FROM customer GROUP BY stat;";
            $result = $dw3_conn->query($sql);
            echo "<table class='tblDATA'>
            <tr><th colspan=2  style='cursor:default;'>Clients</th></tr>";
            if ($result->num_rows > 0) {		
                while($row = $result->fetch_assoc()) {
                    $stat_desc = "Inconnu";
                    if ($row["stat"]=="1" && $row["status_count"] > 1){
                        $stat_desc = "Inactifs";
                    }else if ($row["stat"]=="1" && $row["status_count"] == 1){
                        $stat_desc = "Inactif";
                    }else if ($row["stat"]=="0" && $row["status_count"] > 1){
                        $stat_desc = "Actifs";
                    }else if ($row["stat"]=="0" && $row["status_count"] == 1){
                        $stat_desc = "Actif";
                    }else if ($row["stat"]=="2" && $row["status_count"] > 1){
                        $stat_desc = "Suspendus";
                    }else if ($row["stat"]=="2" && $row["status_count"] == 1){
                        $stat_desc = "Suspendu";
                    }else if ($row["stat"]=="3" && $row["status_count"] > 1){
                        $stat_desc = "Bannis";
                    }else if ($row["stat"]=="3" && $row["status_count"] == 1){
                        $stat_desc = "Banni";
                    }
                    echo "<tr>"
                        . "<td style='width:100px;text-align:center;'><b>". $row["status_count"] . "</b></td>"
                        . "<td width='*'>". $stat_desc ."</td>"
                        . "</tr>";
                }
            } else {
                echo "<tr><td>Aucun client trouvé</td></tr>";
            }
            echo "</table>";
            ?>
    </div>
    <div class='divBOX' style='max-width:none;'>
            <?php
            //COMMANDES
            $sql = "SELECT DISTINCT stat, count(stat) as status_count FROM order_head GROUP BY stat;";
            $result = $dw3_conn->query($sql);
            echo "<table class='tblDATA'>
            <tr><th colspan=2  style='cursor:default;'>Commandes</th></tr>";
            if ($result->num_rows > 0) {		
                while($row = $result->fetch_assoc()) {
                    $stat_desc = "Inconnu";
                    if ($row["stat"]=="0"){
                        $stat_desc = "En traitement";
                    }else if ($row["stat"]=="1"){
                        $stat_desc = "En Facturation";
                    }else if ($row["stat"]=="2"){
                        $stat_desc = "En expédition";
                    }else if ($row["stat"]=="3" && $row["status_count"] > 1){
                        $stat_desc = "Terminés";
                    }else if ($row["stat"]=="3" && $row["status_count"] == 1){
                        $stat_desc = "Terminé";
                    }else if ($row["stat"]=="4" && $row["status_count"] > 1){
                        $stat_desc = "Annulés";
                    }else if ($row["stat"]=="4" && $row["status_count"] == 1){
                        $stat_desc = "Annulé";
                    }
                    echo "<tr>"
                        . "<td style='width:100px;text-align:center;'><b>". $row["status_count"] . "</b></td>"
                        . "<td width='*'>". $stat_desc ."</td>"
                        . "</tr>";
                }
            } else {
                echo "<tr><td>Aucune commande trouvée</td></tr>";
            }
            echo "</table>";
            ?>
    </div>
    <div class='divBOX' style='max-width:none;'>
            <?php
            //FACTURES
            $sql = "SELECT DISTINCT stat, count(stat) as status_count, IFNULL(SUM(total),'0.00') as tot FROM invoice_head GROUP BY stat;";
            $result = $dw3_conn->query($sql);
            $gtot = 0;
            $ftot = 0;
            echo "<table class='tblDATA'>
            <tr><th colspan=3 style='cursor:default;'>Factures client</th></tr>";
            $row_count = $result->num_rows;
            if ($row_count  > 0) {		
                while($row = $result->fetch_assoc()) {
                    $stat_desc = "Inconnu";
                    if ($row["stat"]=="0" && $row["status_count"] > 1){
                        $stat_desc = "Non-Facturées";
                        $gtot = $gtot + $row["tot"];
                    }else if ($row["stat"]=="0" && $row["status_count"] == 1){
                        $stat_desc = "Non-Facturée";
                        $gtot = $gtot + $row["tot"];
                    }else if ($row["stat"]=="1" && $row["status_count"] > 1){
                        $stat_desc = "Facturées et non-payées";
                        $gtot = $gtot + $row["tot"];
                    }else if ($row["stat"]=="1" && $row["status_count"] == 1){
                        $stat_desc = "Facturée et non-payée";
                        $gtot = $gtot + $row["tot"];
                    }else if ($row["stat"]=="2" && $row["status_count"] > 1){
                        $stat_desc = "Payées";
                        $gtot = $gtot + $row["tot"];
                    }else if ($row["stat"]=="2" && $row["status_count"] == 1){
                        $stat_desc = "Payée";
                        $gtot = $gtot + $row["tot"];
                    }else if ($row["stat"]=="3" && $row["status_count"] > 1){
                        $stat_desc = "Annulées";
                    }else if ($row["stat"]=="3" && $row["status_count"] == 1){
                        $stat_desc = "Annulée";
                    }
                    $ftot = $ftot + $row["status_count"];
                    echo "
                        <tr>"
                        . "<td style='width:100px;text-align:center;'><b>". $row["status_count"] . "</b></td>"
                        . "<td width='*'>". $stat_desc ."</td>";
                        if ($row["stat"]=="3"){
                            echo "<td style='text-decoration: line-through;text-align:right;'>". number_format($row["tot"],2,"."," ") ."$</td>";
                        } else {
                            echo "<td style='text-align:right;'>". number_format($row["tot"],2,"."," ") ."$</td>";
                        }
                        echo "</tr>";
                }
                    echo "
                        <tr style='border-top:2px solid #000;border-bottom:2px solid #000;'>"
                        . "<td style='width:100px;text-align:center;'><b>". $ftot . "</b></td>"
                        . "<td width='*'><b>Grand Total</b></td>"
                        . "<td style='text-align:right;'><b>". number_format($gtot,2,"."," ") ."$</b></td>"
                        . "</tr>";
            } else {
                echo "<tr><td colspan='2'>Aucune facture trouvée</td></tr>";
            }
            if ($row_count > 0) {
                $sql = "SELECT count(*) as late_count, IFNULL(SUM(total),'0.00') as tot FROM invoice_head WHERE date_due < CURDATE() AND stat = '1';";
                $result = $dw3_conn->query($sql);
                if ($result->num_rows > 0) {		
                    while($row = $result->fetch_assoc()) {
                        echo "
                            <tr>"
                            . "<td style='text-align:center;'><b>".$row["late_count"]."</b></td>"
                            . "<td width='*'>En retard</td>"
                            . "<td style='text-align:right;'>". number_format($row["tot"],2,"."," ") ."$</td>"
                            . "</tr>";
                    }
                }
            }
            echo "</table>";
            ?>
    </div>

<div class='divPAGE' style='background-color:#fff;color:#333;text-align:left;padding:20px;font-size:0.7em'><h3>Configuration initiale</h3>
    <br><p>Pour initialiser la plateforme DW3, veuillez suivre les étapes suivantes:</p><br>
    <ul style='margin-left:20px;'>
        <li style='margin:5px 0px;'>Créez votre clé maitre unique pour que le système fonctionne correctement de façon autonome et sécuritaire. (Ne peut être créé qu'une seule fois)</li>
        <li style='margin:5px 0px;'>Ensuite dans le cPanel  créez une tâche Cron Job pour exécuter les scripts suivants (définir de s'exécuter une fois par jour est recommandé):
            <ol style='margin-left:20px;'>
                <li>Script 1: Fin de jour, pour générer des factures pour les abonnements récurrents. (À programmer pour minuit et une)<br><span style='font-size:12px;'><b>/usr/local/bin/ea-php82 /home/dossierxyz/public_html ou autre/sbin/finDEjour.php K=<?php if($MASTERKEY == "") { echo "MASTERKEY"; } else { echo $MASTERKEY; } ?></b></span></li>
                <li>Script 2: Sauvegarde automatique. Les fichiers de sauvegarde seront placés dans /backup. (À programmer pour minuit et demi)<br><span style='font-size:12px;'><b>/usr/local/bin/ea-php82 /home/dossierxyz/public_html ou autre/sbin/sauvegarde.php K=<?php if($MASTERKEY == "") { echo "MASTERKEY"; } else { echo $MASTERKEY; } ?></b></span></li>
                <li>Script 3: Mise à jour automatique. (Abonnement à un plan chez Design Web 3D necessaire pour les mises à jour quotidiennes) (À programmer pour une heure du matin)<br><span style='font-size:12px;'><b>/usr/local/bin/ea-php82 /home/dossierxyz/public_html ou autre/sbin/miseAjour.php K=<?php if($MASTERKEY == "") { echo "MASTERKEY"; } else { echo $MASTERKEY; } ?></b></span></li>
                <li>Script 4: Envoi des logs à vérifier à info@dw3.ca. (À programmer pour deux heures du matin)<br><span style='font-size:12px;'><b>/usr/local/bin/ea-php82 /home/dossierxyz/public_html ou autre/sbin/send_logs_stat.php K=<?php if($MASTERKEY == "") { echo "MASTERKEY"; } else { echo $MASTERKEY; } ?></b></span></li>
            </ol>
            Remplacez ea-php82 par la version actuelle de PHP utilisé et les répertoires correspondants. Recherchez dans le gestionnaire MultiPHP du cPanel la version PHP réelle attribuée à un domaine.
        </li>
        <li style='margin:5px 0px;'>Créez votre clé de cryptage unique pour assurer la sécurité des données. (Ne peut être créé qu'une seule fois)<br><b>Doit absolument être générée avant de créer des clients et des utilisateurs.</b></li>
        <li style='margin:5px 0px;'>Explorez chaques sections de la configuration pour vous familiariser avec les options disponibles et modifier les paramètres selon vos besoins.</li>
        <li style='margin:5px 0px;'>Créez des utilisateurs et attribuez-leur des applications et des niveaux d'autorisations appropriés.</li>
        <li style='margin:5px 0px;'>Abonnez-vous au plan de support technique pour bénéficier d'une assistance dédiée sur <a href="https://www.designweb3d.com/shop" target="_blank"><u>notre site de produits/services</u></a>.</li>
    </ul>
    <div style='width:100%;background-color:#ccc;margin:20px 0px;text-align:center;'>
        <div class='divBOX'>Clé maitre: <br>
            <?php if($MASTERKEY != "") { echo "<b>La clé maitre déjà créée.</b>"; } else { echo "<button class='green' style='width:98%;' onclick=\"createKey('MASTER')\">Créer une clé maitre</button>";} ?>
        </div>
        <div class='divBOX'>Clé de cryptage: <br>
            <?php if($DECRYPTKEY != "") { echo "<b>La clé de cryptage déjà créée.</b>"; } else { echo "<button class='green' style='width:98%;' onclick=\"createKey('DECRYPT')\">Créer une clé de cryptage</button>";} ?>
        </div>
    </div>

</div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';

function createKey(type){
    if (type == "MASTER"){
        if (confirm("Êtes-vous sûr de vouloir créer une clé maitre? Cette action est irréversible et ne peut être effectuée qu'une seule fois.")){
            showLoading("Création de la clé maitre en cours...");
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/app/config/config_create_key.php?KEY="+KEY+"&TYPE=MASTER", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    hideLoading();
                    if (xhr.responseText.trim() == "OK"){
                        alert("Clé maitre créée avec succès.");
                        location.reload();
                    } else {
                        alert("Erreur lors de la création de la clé maitre: " + xhr.responseText);
                    }
                }
            };
            xhr.send();
        }
    } else if (type == "DECRYPT"){
        if (confirm("Êtes-vous sûr de vouloir créer une clé de décryptage? Cette action est irréversible et ne peut être effectuée qu'une seule fois.")){
            showLoading("Création de la clé de décryptage en cours...");
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/app/config/config_create_key.php?KEY="+KEY+"&TYPE=DECRYPT", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    hideLoading();
                    if (xhr.responseText.trim() == "OK"){
                        alert("Clé de décryptage créée avec succès.");
                        location.reload();
                    } else {
                        alert("Erreur lors de la création de la clé de décryptage: " + xhr.responseText);
                    }
                }
            };
            xhr.send();
        }
    }
}
function hideLoading(){
    var div = document.getElementById("loadingDiv");
    if (div){
        document.body.removeChild(div);
    }
}
function showLoading(msg){
    var div = document.createElement("div");
    div.id = "loadingDiv";
    div.style.position = "fixed";
    div.style.top = "0";
    div.style.left = "0";
    div.style.width = "100%";
    div.style.height = "100%";
    div.style.backgroundColor = "rgba(0,0,0,0.5)";
    div.style.display = "flex";
    div.style.justifyContent = "center";
    div.style.alignItems = "center";
    div.style.zIndex = "1000";
    div.innerHTML = "<div style='background-color:#fff;padding:20px;border-radius:5px;box-shadow:0 0 10px rgba(0,0,0,0.5);text-align:center;'><img src='/pub/img/load/<?php echo $CIE_LOAD;?>' alt='Loading...' style='width:50px;height:50px;'><br><br><span>" + msg + "</span></div>";
    document.body.appendChild(div);
}

<?php 
 if($MASTERKEY == "" && $DECRYPTKEY != "") { echo "addMsg(\"La clé maitre est manquante. Veuillez vous référer aux instructions en bas de page. <div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>\");"; }
 if($MASTERKEY != "" && $DECRYPTKEY == "") { echo "addMsg(\"La clé de décryptage est manquante. Veuillez vous référer aux instructions en bas de page. <div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>\");"; }
 if($MASTERKEY == "" && $DECRYPTKEY == "") { echo "addMsg(\"La clé maitre et la clé de décryptage sont manquantes. Veuillez vous référer aux instructions en bas de page. <div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>\");"; }
?>

</script>
</body>
</html>
<?php $dw3_conn->close();exit(); ?>
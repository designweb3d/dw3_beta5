<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';  
?>

<div id='divHEAD'><h2>Exportation de données</h2></div>

<div class='divMAIN' style="padding-top:50px;">
    <h2 style='text-align:left;'>Exporter la base de données</h2>
    	<div class="divBOX">Au format SQL:
            <button onclick="getDB_SQL();" style='float:right;'>Télécharger</button>
            <div style='width:100%;font-size:12px;color:gray;margin-top:10px;'>Le fichier SQL contient toutes les données de la base de données (sans les fichiers). Veuillez attendre quelques instants pendant que le fichier est généré.</div>
        </div><br>

    <h2 style='text-align:left;'>Exporter les fichiers</h2>
        <div class="divBOX">Au format ZIP:
            <button onclick="getFS_ZIP();" style='float:right;'>Télécharger</button>
            <div style='width:100%;font-size:12px;color:gray;margin-top:10px;'>Le fichier ZIP contient tous les fichiers (images, documents, etc.) téléchargés sur le serveur. Veuillez attendre quelques instants pendant que le fichier est généré.</div>
        </div><br>
       
</div>
<div id="divMSG"></div>

<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>

<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var date_time = '<?php echo($datetime); ?>';
$(document).ready(function ()
    {
		  
	});

function getDB_SQL(){
	window.open("/sbin/backup_db.php?KEY="+KEY)
}
function getFS_ZIP(){
	window.open("/sbin/backup_files.php?KEY="+KEY)
}


</script>
</body>
</html>

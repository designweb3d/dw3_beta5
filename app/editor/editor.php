<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php'; 
$SCENE_ID  = $_GET['SCENE_ID']??'';

$sql = "SELECT * FROM scene WHERE id = '" . $SCENE_ID . "';";
$result = mysqli_query($dw3_conn, $sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $SCENE_NAME = $row["name_fr"];
		if ($row["animation_status"]==1){
    	    $SCENE_ANIM_STATUS = "play";
		}else{
			$SCENE_ANIM_STATUS = "stop";
		}
        $SCENE_BG   = $row["bg_path"];
        $SCENE_DESC = $row["description"];
    }
} else {
    $SCENE_NAME = "Ocean";
    $SCENE_BG   = "";
    $SCENE_DESC = "Éditeur 3D";
	$SCENE_ANIM_STATUS = "stop";
}
?>

<div id='divHEAD'>
	<table style="width:100%;margin:0px;white-space:nowrap;">
		<tr style="margin:0px;padding:0px;">
			<td width="40"><button style="margin:0px 2px 0px 2px;padding:8px;font-size:0.8em;" onclick="openEDITOR_MENU();"><span class="material-icons">apps</span></button></td>
			<td width="*" style="margin:0px;padding:0px;">
				<h2><?php echo $SCENE_NAME; ?></h2>
			</td>
			<td width="100" style="margin:0px;padding:0px;text-align:right;">
				<button class='blue' style="margin:0px 2px 0px 2px;padding:8px;" onclick="updSCENE_REC('animation_status','')"><span id='span_animation_status' class="material-icons">play_circle</span></button>
				<button class='grey' style="margin:0px 2px 0px 2px;padding:8px;" onclick="openPARAM();"><span class="material-icons">settings</span></button>
			 </td>
		</tr>
	</table>
</div>

<iframe id='scene_iframe' src='scene.php?K=<?php echo $KEY; ?>&SCENE_ID=<?php echo $SCENE_ID; ?>' style='position:fixed;top:46px;left:0px;width:100%;height:calc(100% - 46px);border:none;'></iframe>

<div id="divSEL_SCENE" class="divSELECT" style='min-width:330px;min-height:90%;'>
    <div id="divSEL_SCENE_HEADER" class='dw3_form_head'><h3>
	    Sélection ID </h3>
        <button onclick='closeSEL_SCENE();' class='dw3_form_close'><span class="material-icons">close</span></button>
    </div>
    <div class='dw3_form_data'>
        <div class="divBOX">
            <input id="selSCENE" oninput="getSEL_SCENE('');" type="search" readonly onfocus="this.removeAttribute('readonly');" autocorrect="off" spellcheck="false" autocomplete="off" onclick="detectCLICK(event,this);"  placeholder="<?php echo $dw3_lbl["RECH"]; ?>.." title="<?php echo $dw3_lbl["RECH"]; ?>">
        </div><br>
            <div id="divSEL_SCENE_DATA" style="margin:10px;max-height:75%;">		
                Inscrire votre recherche pour trouver une scene.
            </div>
    </div>
	<div class='dw3_form_foot'>
		<button class='grey' onclick="closeSEL_SCENE();getElementById('divSEL_SCENE_DATA').innerHTML='Inscrire votre recherche pour trouver un fournisseur.';"><span class="material-icons">cancel</span> <?php echo $dw3_lbl["CANCEL"]; ?></button>
	</div><br>
</div>

<div id="divMSG"></div>
<div id="divOPT"></div>
<script type="text/javascript" src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY."&INACTIVE=".$USER_INACTIVE; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>  
var KEY = '<?php echo($KEY); ?>';
var scene_id = '<?php echo($SCENE_ID); ?>';
var animation_status = '<?php echo($SCENE_ANIM_STATUS); ?>';

$(document).ready(function (){
	dragElement(document.getElementById('divSEL_SCENE'));
	if (animation_status == "play"){
		document.getElementById("span_animation_status").innerHTML = "stop_circle";
	}else{
		document.getElementById("span_animation_status").innerHTML = "play_circle";
	}
	if (scene_id == ""){
		openSEL_SCENE();
	}
 });

//SELECTION SCENE
function getSEL_SCENE(sS) {
	if(sS==""){sS = document.getElementById("selSCENE").value.trim();}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divSEL_SCENE_DATA").innerHTML = this.responseText;
	  }
	};
    xmlhttp.open('GET', 'getSEL_SCENE.php?KEY=' + KEY + '&SS=' + encodeURIComponent(sS.trim()), true);
    xmlhttp.send();
}
function openSEL_SCENE() {
    document.getElementById('divSEL_SCENE').style.display = "inline-block";
    getSEL_SCENE('');
}
function closeSEL_SCENE() {
    document.getElementById('divSEL_SCENE').style.display = "none";
}
function validateSCENE(sID) {
    closeSEL_SCENE();
	window.location.href = 'editor.php?KEY=' + KEY + '&SCENE_ID=' + sID;
}

function updSCENE_REC(record_name,record_value){
	if (record_name == "animation_status"){
		if (animation_status == "play"){
			record_value = "0";
			animation_status = "stop";
			document.getElementById("span_animation_status").innerHTML = "play_circle";
		}else{
			record_value = "1";
			animation_status = "play";
			document.getElementById("span_animation_status").innerHTML = "stop_circle";
		}
	}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  //alert (this.responseText);
		  if (this.responseText.trim() == ""){
            document.getElementById('scene_iframe').contentWindow.location.reload();
            addNotif("Mise à jour de la scène terminée");
		  } else  {
            document.getElementById("divMSG").style.display = "inline-block";
            document.getElementById("divMSG").innerHTML = this.responseText + "<div style='height:20px;'> </div><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', 'updSCENE_REC.php?KEY=' + KEY 
										+ '&ID=' + scene_id 
										+ '&REC=' + record_name
										+ '&VAL=' + record_value,    
										true);
		xmlhttp.send();
}

</script>
</body>
</html>

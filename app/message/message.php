<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/app/common_header.php';
?>
<div id='divHEAD'>
<table style="width:100%;margin:0px;white-space:nowrap;"><tr style="margin:0px;padding:0px;"><td width="*" style="margin:0px;padding:0px;">
	<h2><?php echo($APNAME); ?></h2> 
	</td><td width="100" style="margin:0px;padding:0px;text-align:right;">
		<button style="margin:0px 2px 0px 2px;padding:8px;background:#555555;" onclick="openPARAM();"><span class="material-icons">settings</span></button>
	  </td></tr></table>
</div>
<div id='dw3_panel_top' style='transition: all 1s;position:fixed;top:50px;left:0px;right:0px;height:auto;overflow:hidden;'>
	<form><table class="tblDATA"><tr onclick='dw3_message_down()' style='height:50px;'><th>Destinataires</th></tr>
				<?php
					$sql = "SELECT * FROM user WHERE id <> '". $USER . "' ORDER BY name ASC";
					$result = $dw3_conn->query($sql);
					if ($result->num_rows > 0) {	
						while($row = $result->fetch_assoc()) {
							echo "<tr onclick=\"dw3_message_list('". $row["id"] . "','". strtoupper($row["name"]) . "');\"><td style='width:200px;' class='short'><input type='radio' id='messageN" . $row["id"]  . "' name='user_to' value=''><label for='messageN" . $row["id"]  . "'>[" . $row["name"] . "] " . $row["first_name"] . " " . $row["last_name"] . "</label></td></tr>";
					}}
				?>
	</table></form>
</div>
<div id='dw3_panel_bot' style='transition: all 1s;position:fixed;top:100%;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:scroll;'>
	<div id="divMAIN" style='display:inline-block;width:100%;'></div>
</div>
<div style='text-align:right;position:fixed;bottom:0px;right:0px;left:0px;height:50px;'>
    <table style='width:100%;'><tr>
        <td width='30px'><button onclick='dw3_message_add();' style='transition: all 1s;font-size:14px;padding:0px;rotate:180deg;'><span class='material-icons'>send</span></button><td>
        <td width='*'><textarea style='width:100%;height:50px;' id='dw3_message_input' ></textarea></td>
    </tr></table>
</div>
<div id="divMSG"></div>
<div id="divOPT"></div>
<div id="divPARAM"  class="divEDITOR" style="background: rgba(0, 0, 0, 0.7);color:white;"></div>
<script src="/pub/js/main.js.php?t=<?php echo(rand(100,100000)); echo "&KEY=" . $KEY; ?>"></script>
<script src="/pub/js/multiavatar.min.js"></script>
<script>
var KEY = '<?php echo($_GET['KEY']); ?>';
var dw3_selected_id = "";
$(document).ready(function (){
	//dw3_message_list();
    document.body.style.overflow='hidden';
});
//Fonction pour
function dw3_message_up() {
    document.getElementById("dw3_panel_top").style.height = "50px";
    document.getElementById("dw3_panel_bot").style.top = "100px";
}
function dw3_message_down() {
    document.getElementById("dw3_panel_top").style.height = "auto";
    document.getElementById("dw3_panel_bot").style.top = "100%";
}
function dw3_message_list(usID,usNAME) {
	dw3_selected_id = usID;
    dw3_message_up();
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 document.getElementById("divMAIN").innerHTML = "<table id='dw3_message_table' class='tblMESSAGE' style='width:100%;max-width:100%;'><tr style='position:sticky;top:0px;background-color:rgba(0,0,0,0.8);color:#aaa;font-weight:bold;'><td style='padding:10px;'>" + usNAME + "</td><td style='text-align:right;padding:10px;'><?php echo strtoupper($USER_NAME);?></th></tr>" + this.responseText;
		 document.getElementById("dw3_message_input").focus();
	  }
	};
	xmlhttp.open('GET', 'dw3_message_list.php?KEY=' + KEY + '&usID=' + usID, true);xmlhttp.send();	
}
//Fonction pour
function dw3_message_add(){
	var sMSG = document.getElementById("dw3_message_input").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == ""){
            addNotif("Message envoyé");
			dw3_message_list(dw3_selected_id);
			document.getElementById("dw3_message_input").focus();
		  } else {
				addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>");
		  } 
	  }
	};
	xmlhttp.open('GET', 'dw3_message_add.php?KEY=' + KEY + '&usTO=' + dw3_selected_id + '&MSG=' + encodeURIComponent(sMSG), true);xmlhttp.send();
}
//Fonction pour
function dw3_message_del(msID) { 
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText.substr(0, 3) != "Err"){
			addNotif("Message effacé.")
			getUSERS();
		  } else {
			addMsg(this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span> Ok</button>");
		  } 
	  }
	};
	xmlhttp.open('GET', 'dw3_message_del.php?KEY=' + KEY + '&msID=' + msID , true);xmlhttp.send();
}
//Fonction pour
function openPARAM() {
	document.getElementById("divFADE").style.display = "inline-block";document.getElementById("divFADE").style.opacity = "0.6";
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		 if (this.responseText != ""){
			document.getElementById('divPARAM').style.display = "inline-block";
			document.getElementById('divPARAM').innerHTML = this.responseText;
		 }
	  }};
	xmlhttp.open('GET', 'getPARAM.php?KEY=' + KEY, true);xmlhttp.send();
}
var dw3_message_listen1 = document.getElementById("dw3_message_input");
dw3_message_listen1.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
	dw3_message_add();
  }
});
</script></body></html><?php $dw3_conn->close();exit;?>
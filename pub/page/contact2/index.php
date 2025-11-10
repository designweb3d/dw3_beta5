<?php 
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/loader.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_HEADER;
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';
 ?>

 <div class='dw3_paragraf'>
    <h2>Contactez-nous</h2>
    <br><span style='color:#888;'>Nous sommes là pour vous aider et répondre à toutes vos questions.</span>
    <br><br>
    <span class='material-icons' style='font-size:20px;color:#f17144;vertical-align:middle;'>phone</span> Téléphone<br>
    &#160;&#160;&#160;&#160;&#160;&#160;<span style='color:#888;'><?php echo $CIE_TEL1; ?></span><br><br>
    <span class='material-icons' style='font-size:20px;color:#f17144;vertical-align:middle;'>fax</span> Sans frais<br>
    &#160;&#160;&#160;&#160;&#160;&#160;<span style='color:#888;'><?php echo $CIE_TEL2; ?></span><br><br>
    <span class='material-icons' style='font-size:20px;color:#f17144;vertical-align:middle;'>mail</span> Courriel<br>
    &#160;&#160;&#160;&#160;&#160;&#160;<span style='color:#888;'><?php echo $CIE_EML1; ?></span><br><br>
    <span class='material-icons' style='font-size:20px;color:#f17144;vertical-align:middle;'>place</span> Adresse<br>
    &#160;&#160;&#160;&#160;&#160;&#160;<span style='color:#888;'><?php echo $CIE_ADR; ?></span><br><br>
    <span class='material-icons' style='font-size:20px;color:#f17144;vertical-align:middle;'>schedule</span> Heures d'ouvertures<br>
    &#160;&#160;&#160;&#160;&#160;&#160;<span style='color:#888;'>Du Lundi au Dimanche: 09:00H – 17:00H</span><br><br>
</div>

<div class='paragraf'>
    <h2>Faites nous part de vos projets ou commentaires.</h2><br><span style='color:#888;'>Veuillez remplir notre formulaire, un de nos collègues vous recontactera bientôt!</span><br><br>
        <table style='width:90%;border-spacing: 0px;'>
            <tr><td width='35' style='border-bottom:1px solid #ddd;'><span class='material-icons' style='font-size:25px;color:#444;'>person_outline</span></td>
                    <td width='*' style='border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:5px;' type='text' id='txtContactName' placeHolder='Nom*' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
            <tr><td width='35' style='border-bottom:1px solid #ddd;'><span class='material-icons' style='font-size:25px;color:#444;'>mail</span></td>
                    <td width='*' style='border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:5px;' type='text' id='txtContactEmail' placeHolder='Courriel*' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
            <tr><td width='35' style='border-bottom:1px solid #ddd;'><span class='material-icons' style='font-size:25px;color:#444;'>phone</span></td>
                    <td width='*' style='border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:5px;' type='text' id='txtContactPhone' placeHolder='Téléphone' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
            <tr><td colspan=2><textarea placeHolder='Message*' id='txtContactMessage' style='padding:7px;width:100%;height:120px;border:1px solid #dfdfdf;'  onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></textarea></td></tr>
        </table><input id='chkROBOT' name='chkROBOT' type='checkbox'><label for='chkROBOT'> Je ne suis pas un robot</label><br>
        <button id='btnSEND' onclick='emlContact();' style='float:right;margin-right:60px;border-radius:3px;padding:15px 20px;'>Send</button>
</div>

    <div id='divFrame' class='dw3_form'>
		<div id='divFrame_HEADER' class='dw3_form_head'></div>
		<button onclick='closeFrame();' class='dw3_form_close'><span class='material-icons' style='margin-top:2px;'>close</span></button>
		<iframe class='dw3_form_data' id='divFrameData' src='' style='width:100%;height:100%;'></iframe>
		<div class='dw3_form_foot'><button class='dw3_form_cancel' onclick='closeFrame()'>Ok</button></div>                    
    </div>
     
    <script>

$(document).ready(function (){

    //dragElement(document.getElementById("divFrame"));
    //document.getElementById("chkROBOT").checked = false;

});

function emlContact(){
	var sEML  = document.getElementById("txtContactEmail").value;
	var sNOM     = document.getElementById("txtContactName").value;
	var sTEL    = document.getElementById("txtContactPhone").value;
	var sMSG      = document.getElementById("txtContactMessage").value;

	if (sNOM == ""){
		document.getElementById("txtContactName").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtContactName").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("txtContactName").style.boxShadow = "0px 0px 0px white";
		//document.getElementById("lblPRD").innerHTML = "";
	}
    if (sEML == ""){
		document.getElementById("txtContactEmail").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtContactEmail").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("txtContactEmail").style.boxShadow = "0px 0px 0px white";
		//document.getElementById("lblPRD").innerHTML = "";
	}
    if (sMSG == ""){
		document.getElementById("txtContactMessage").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtContactMessage").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("txtContactMessage").style.boxShadow = "0px 0px 0px white";
		//document.getElementById("lblPRD").innerHTML = "";
	}
	if (document.getElementById("chkROBOT").checked == false){
		document.getElementById("chkROBOT").style.boxShadow = "5px 10px 15px red";
		document.getElementById("chkROBOT").focus();
        return;
    } else {
		document.getElementById("chkROBOT").style.boxShadow = "0px 0px 0px white";
    }

    document.getElementById("divFADE").style.display = "inline-block";
    document.getElementById("divMSG").style.display = "inline-block";
	document.getElementById("divMSG").innerHTML = "<br>Le message est en cours d'envoi<br><img style='width:100px;height:auto;' src='/pub/img/loading.gif'><br><span style='color:#999;font-size:16px;'>Veuillez patienter un instant..</span>";
    document.getElementById("btnSEND").disabled = true;
    document.getElementById("btnSEND").style.background = '#555';
    document.getElementById("btnSEND").innerHTML = 'Envoyé';

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == "ok"){
                document.getElementById("divFADE").style.display = "inline-block";
                document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = "Votre message a été envoyé!<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } else {
		        document.getElementById("divFADE").style.display = "inline-block";
                document.getElementById("divMSG").style.display = "inline-block";
				document.getElementById("divMSG").innerHTML = this.responseText + "<br><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>done</span>Ok</button>";
		  } 
	  }
	};
		xmlhttp.open('GET', '/sbin/emlContact.php?E=' + encodeURIComponent(sEML) 
										+ '&N=' + encodeURIComponent(sNOM) 
										+ '&T=' + encodeURIComponent(sTEL)  
										+ '&M=' + encodeURIComponent(sMSG),                 
										true);
		xmlhttp.send();
}
<?php 
     require_once $_SERVER['DOCUMENT_ROOT'] . "/pub/page/page.js.php";
?>
</script>

</body>
</html>

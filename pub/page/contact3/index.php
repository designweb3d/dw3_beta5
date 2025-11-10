<?php 
 require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_main.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . $PAGE_HEADER;
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';
 if ($PAGE_HEADER== '/pub/section/header0.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header1.php'){$INDEX_HEADER_HEIGHT = '120';}
 else if ($PAGE_HEADER== '/pub/section/header2.php'){$INDEX_HEADER_HEIGHT = '105';}
 else if ($PAGE_HEADER== '/pub/section/header3.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header4.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header5.php'){$INDEX_HEADER_HEIGHT = '102';}
 else if ($PAGE_HEADER== '/pub/section/header6.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header7.php'){$INDEX_HEADER_HEIGHT = '105';}
 else if ($PAGE_HEADER== '/pub/section/header8.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header9.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header10.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header11.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header12.php'){$INDEX_HEADER_HEIGHT = '82';}
 else if ($PAGE_HEADER== '/pub/section/header13.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header14.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header15.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header16.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header17.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header18.php'){$INDEX_HEADER_HEIGHT = '90';}
 else if ($PAGE_HEADER== '/pub/section/header19.php'){$INDEX_HEADER_HEIGHT = '100';}
 else if ($PAGE_HEADER== '/pub/section/header20.php'){$INDEX_HEADER_HEIGHT = '90';}
 else if ($PAGE_HEADER== '/pub/section/header21.php'){$INDEX_HEADER_HEIGHT = '90';}
 else if ($PAGE_HEADER== '/pub/section/header22.php'){$INDEX_HEADER_HEIGHT = '70';}
 else if ($PAGE_HEADER== '/pub/section/header23.php'){$INDEX_HEADER_HEIGHT = '70';}
 else {$INDEX_HEADER_HEIGHT='70';}

echo "<div style='height:" . $INDEX_HEADER_HEIGHT . "px;'> </div>";
 
 ?>
         
    <div class='dw3_paragraf' style='max-width:600px;box-shadow:3px 3px 6px 6px rgba(0,0,0,0.3);border-radius:20px;background-color:rgba(255,255,255,0.95);'>
        <h2 style='border-top-left-radius:20px;border-top-right-radius:20px;line-height:1em;margin:0px 0px 10px 0px;padding:10px;background-color:rgba(0,0,0,0.1);'><?php if ($USER_LANG == "FR"){ echo "Contactez-nous"; }else { echo "Contact us";}?></h2>
        <span style='color:#888;margin:10px 20px;'>
        <?php if ($USER_LANG == "FR"){ 
                echo "Nous sommes là pour répondre à toutes vos questions.";
            }else{
                echo "We are here to answer all your questions.";
            }
        ?>
        </span>
        <br> 
<?php if ($CIE_TEL1 != "") { ?>
        <span class='dw3_font' style='margin-left:15px;font-size:20px;color:#888;transform: translateY(10px);'>N</span> <?php if ($USER_LANG == "FR"){ echo "Téléphone"; }else{echo "Phone";}?><br>
        <span style='margin-left:48px;color:#555;margin-bottom:10px;font-size:1.3em;'><strong><a arial-label="Téléphone de la compagnie" style='color:#333;' href='tel:<?php echo trim($CIE_TEL1); ?>'><?php echo $CIE_TEL1; ?></a></strong></span><br>
<?php }
     if ($CIE_TEL2 != '') { ?>
        <br><span class='dw3_font' style='margin-left:15px;font-size:20px;color:#888;transform: translateY(10px);'>N</span> <?php if ($USER_LANG == "FR"){ echo "Téléphone"; }else{echo "Phone";}?><br>
        <span style='margin-left:48px;color:#555;margin-bottom:10px;font-size:1.3em;'><strong><a arial-label="Téléphone de la compagnie" style='color:#333;' href='tel:<?php echo trim($CIE_TEL2); ?>'><?php echo $CIE_TEL2; ?></a></strong></span><br>
<?php } ?>
        <br><span class='dw3_font' style='margin-left:15px;font-size:20px;color:#888;transform: translateY(10px);'>M</span> <?php if ($USER_LANG == "FR"){ echo "Courriel"; }else{echo "Email";}?><br>
        <span style='margin-left:48px;color:#555;margin-bottom:10px;font-size:1em;'><strong><a arial-label="Courriel de la compagnie" style='color:#333;' href='mailto:<?php echo trim($CIE_EML1); ?>'><?php echo $CIE_EML1; ?></a></strong></span><br>
<?php if ($CIE_ADR_PUB == 'true') { if (trim($CIE_ADR2)!=""){$ADR_DSP = $CIE_ADR1.'<br>'.$CIE_ADR2;} else {$ADR_DSP = $CIE_ADR1;}?>
        <br><span class='dw3_font' style='margin-left:15px;font-size:20px;color:#888;transform: translateY(10px);'>$</span> <?php if ($USER_LANG == "FR"){ echo "Adresse Principale"; }else{echo "Main Address";}?><br>
        <span style='margin-left:48px;margin-bottom:10px;color:#555;font-size:1.3em;'><strong><a arial-label="Adresse de la compagnie sur Google Maps" style='color:#333;' href='https://www.google.com/maps/search/?api=1&query=<?php echo str_replace(" ","+",$CIE_ADR1.' '.$CIE_ADR2.' '.$CIE_VILLE.', '.$CIE_PROV.' '.$CIE_PAYS.', '.$CIE_CP); ?>' target='_blank'><?php echo $ADR_DSP.'<br>'.$CIE_VILLE.', '.$CIE_PROV.'<br>'.$CIE_PAYS.', '.$CIE_CP; ?></a></strong></span><br>
<?php }

if ($CIE_ADR_PUB2 == 'true') {
    $sql = "SELECT * FROM location WHERE type = '1';";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if (trim($row["adr2"])!=""){$ADR_DSP = $row["adr1"]."<br>".$row["adr2"];} else {$ADR_DSP = $row["adr1"];}
            echo "<br><span class='dw3_font' style='margin-left:15px;font-size:20px;color:#". $CIE_COLOR6.";transform: translateY(10px);'>$</span> ".$row["name"]."<br>
                    <span style='margin-left:48px;margin-bottom:10px;color:#333;font-size:1.3em;'><strong>".$ADR_DSP."<br>".$row["city"].", ".$row["province"]."<br>".$row["country"].", ".$row["postal_code"]."<br></strong></span><br><br>";
        }
    }
} 

    echo "<br></div><br>";

    if (trim($INDEX_FACEBOOK) != "" || trim($INDEX_TWITTER) != "" || trim($INDEX_INSTAGRAM) != "" || trim($INDEX_LINKEDIN) != "" || trim($INDEX_TIKTOK) != "" || trim($INDEX_YOUTUBE) != "" || trim($INDEX_PINTEREST) != ""){

?>
    <div class='dw3_paragraf' style='max-width:600px;box-shadow:3px 3px 6px 6px rgba(0,0,0,0.3);border-radius:20px;background-color:rgba(255,255,255,0.95);'>
        <h2 style='border-top-left-radius:20px;border-top-right-radius:20px;line-height:1em;margin:0px 0px 10px 0px;padding:10px;background-color:rgba(0,0,0,0.1);'> <?php if ($USER_LANG == "FR"){ echo "Suivez-nous"; }else{echo "Follow us";}?></h2>
        <div style='color:#888;margin:10px;width:100%;text-align:center;'> <?php 
            if (trim($INDEX_FACEBOOK) != ""){
                echo " <a arial-label='Lien Facebook de la compagnie' href='" . $INDEX_FACEBOOK . "'> <img src='/pub/img/dw3/facebook.png' style='height:40px;width:auto;'> </a> ";
            }
            if (trim($INDEX_TWITTER) != ""){
                echo " <a arial-label='Lien Twitter de la compagnie' href='" . $INDEX_TWITTER . "'> <img src='/pub/img/dw3/twitter.png' style='height:40px;width:auto;'> </a> ";
            }
            if (trim($INDEX_INSTAGRAM) != ""){
                echo " <a arial-label='Lien Instagram de la compagnie' href='" . $INDEX_INSTAGRAM . "'> <img src='/pub/img/dw3/instagram.png' style='height:40px;width:auto;'> </a> ";
            }
            if (trim($INDEX_LINKEDIN) != ""){
                echo " <a arial-label='Lien Linkedin de la compagnie' href='" . $INDEX_LINKEDIN . "'> <img src='/pub/img/dw3/linkedin.png' style='height:40px;width:auto;'> </a> ";
            }
            if (trim($INDEX_TIKTOK) != ""){
                echo " <a arial-label='Lien Tiktok de la compagnie' href='" . $INDEX_TIKTOK . "'> <img src='/pub/img/dw3/tiktok.png' style='height:40px;width:auto;'> </a> ";
            }
            if (trim($INDEX_YOUTUBE) != ""){
                echo " <a arial-label='Lien Youtube de la compagnie' href='" . $INDEX_YOUTUBE . "'> <img src='/pub/img/dw3/youtube.png' style='height:40px;width:auto;'> </a> ";
            }
            if (trim($INDEX_PINTEREST) != ""){
                echo " <a arial-label='Lien Pinterest de la compagnie' href='" . $INDEX_PINTEREST . "'> <img src='/pub/img/dw3/pinterest.png' style='height:40px;width:auto;'> </a> ";
            }
    ?>
    </div>
</div><br>
<?php } ?>
    <div class='dw3_paragraf' style='max-width:600px;box-shadow:3px 3px 6px 6px rgba(0,0,0,0.3);border-radius:20px;background-color:rgba(255,255,255,0.95);'>
        <h2 style='border-top-left-radius:20px;border-top-right-radius:20px;line-height:1em;margin:0px 0px 10px 0px;padding:10px;background-color:rgba(0,0,0,0.1);'><?php if ($USER_LANG == "FR"){ echo "Questions, suggestions ou commentaires?"; }else{echo "Questions, suggestions or comments?";}?></h2>
        <br><span style='color:#888;margin:10px;'><?php if ($USER_LANG == "FR"){ echo "Veuillez remplir notre formulaire, un de nos collègues vous contactera bientôt!"; }else{echo "Please fill out our form, one of our colleagues will contact you soon!";}?></span><br><br>
            <div style='width:100%;text-align:center;'><table style='width:95%;border-collapse:collapse: 0px;margin-right:auto;margin-left:auto;'>
                <tr><td width='35' style='padding:5px;border-bottom:1px solid #ddd;'><span class='dw3_font' style='font-size:25px;color:#444;'>Ɔ</span></td>
                        <td width='*' style='border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:5px;' type='text' id='txtContactName' placeHolder='<?php if ($USER_LANG == "FR"){ echo "Nom*"; }else{echo "Name*";}?>' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
                <tr><td width='35' style='padding:5px;border-bottom:1px solid #ddd;'><span class='dw3_font' style='font-size:25px;color:#444;'>M</span></td>
                        <td width='*' style='border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:5px;' type='text' id='txtContactEmail' placeHolder='<?php if ($USER_LANG == "FR"){ echo "Courriel*"; }else{echo "Email*";}?>' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
                <tr><td width='35' style='padding:5px;border-bottom:1px solid #ddd;'><span class='dw3_font' style='font-size:25px;color:#444;'>N</span></td>
                        <td width='*' style='border-bottom:1px solid #ddd;'><input style='width:100%;border:0px;padding:5px;' type='text' id='txtContactPhone' placeHolder='<?php if ($USER_LANG == "FR"){ echo "Téléphone"; }else{echo "Phone";}?>' onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></td></tr>
                <tr><td colspan=2><textarea placeHolder='Message*' id='txtContactMessage' style='padding:7px;width:100%;height:120px;border:1px solid #dfdfdf;'  onfocus='this.setAttribute("rel", this.getAttribute("placeholder"));this.removeAttribute("placeholder");' onblur='this.setAttribute("placeholder", this.getAttribute("rel"));this.removeAttribute("rel");'></textarea></td></tr>
            </table></div><div style='font-size:0.8em;margin:10px;'><?php if ($USER_LANG == "FR"){ echo "En cliquant 'Envoyer', j'accepte la"; }else{echo "By clicking 'Send', I accept the";}?> <a href='/legal/PRIVACY.html' target='_blank' arial-label="Politique de confidentialité"><?php if ($USER_LANG == "FR"){ echo "politique de confidentialité"; }else{echo "privacy Policy";}?></a> <?php if ($USER_LANG == "FR"){ echo "et les "; }else{echo "and the ";}?><a href='/legal/CONDITIONS.html' target='_blank' arial-label="Conditions d'utilisations"><?php if ($USER_LANG == "FR"){ echo "conditions d'utilisations"; }else{echo "conditions of use";}?></a>.<br></div>
            <button id='btnSEND' onclick='emlContact();' style='float:right;border-bottom-right-radius:20px;padding:15px 20px;font-size:1.1em;'><?php if ($USER_LANG == "FR"){ echo "Envoyer"; }else{echo "Send";}?></button>
    </div><br>
    <?php 
    if ($CIE_PROTECTOR == "-1"){
        echo "<div class='dw3_paragraf' style='display:none;max-width:600px;box-shadow:3px 3px 6px 6px rgba(0,0,0,0.3);border-radius:20px;background-color:rgba(255,255,255,0.95);'>";
    } else {
        echo "<div class='dw3_paragraf' style='max-width:600px;box-shadow:3px 3px 6px 6px rgba(0,0,0,0.3);border-radius:20px;background-color:rgba(255,255,255,0.95);'>";
    }
    ?>
    
        <h3 style='border-top-left-radius:20px;border-top-right-radius:20px;line-height:1em;margin:0px 0px 10px 0px;padding:10px;background-color:rgba(0,0,0,0.1);'> <?php if ($USER_LANG == "FR"){ echo "Qui est responsable de la protection des renseignements personnels chez "; }else{echo "Who is responsible for the protection of personal information at ";}  echo $CIE_NOM; ?> ?</h3>
        <?php
            $sql = "SELECT * FROM user WHERE id = '" . $CIE_PROTECTOR . "' LIMIT 1";
            $result = $dw3_conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $PROT_NAME = trim($row["prefix"]. " ".$row["first_name"]. " " .$row["last_name"]. " " .$row["suffix"]);
                    $PROT_PHONE = trim($row["tel1"]);
                    $PROT_EML = trim($row["eml3"]);
                }
            } else {
                $PROT_NAME = "Propriétaire et Fondateur";
                $PROT_PHONE = $CIE_TEL1;
                $PROT_EML = $CIE_EML1;
            }
        ?>
         <span class='dw3_font' style='margin-left:15px;font-size:20px;color:#888;transform: translateY(10px);'>Ɔ</span> <?php if ($USER_LANG == "FR"){ echo "Personnel désigné"; }else{echo "Designated staff";}?><br>
         <span style='margin-left:48px;color:#555;margin-bottom:10px;font-size:1.3em;'><strong><?php echo $PROT_NAME; ?></strong></span><br><br>
         <div style='<?php if ($PROT_PHONE==""){echo "display:none;";} ?>'>
            <span class='dw3_font' style='margin-left:15px;font-size:20px;color:#888;transform: translateY(10px);'>N</span> <?php if ($USER_LANG == "FR"){ echo "Téléphone"; }else{echo "Phone";}?><br>
            <span style='margin-left:48px;color:#555;margin-bottom:10px;font-size:1.3em;'><strong><?php echo $PROT_PHONE; ?></strong></span><br><br>
        </div>
        <div style='<?php if ($PROT_EML==""){echo "display:none;";} ?>'>
            <span class='dw3_font' style='margin-left:15px;font-size:20px;color:#888;transform: translateY(10px);'>M</span> <?php if ($USER_LANG == "FR"){ echo "Courriel"; }else{echo "Email";}?><br>
            <span style='margin-left:48px;color:#555;margin-bottom:10px;font-size:1em;'><strong><?php echo $PROT_EML; ?></strong></span><br>
        </div>
        <span style='margin-left:8px;color:#888;margin:10px;font-size:0.8em;'> <?php if ($USER_LANG == "FR"){ echo "Pour plus de détails veuillez consulter"; }else{echo "For more details please see";}?><a href='/legal/PRIVACY.html' target='_blank'><?php if ($USER_LANG == "FR"){ echo " notre politique de confidentialité."; }else{echo " our privacy policy.";}?></a></span>
    </div><br>
        <?php
            $sql = "SELECT * FROM attribution ORDER BY name_fr DESC";
            $result = $dw3_conn->query($sql);
            $row_number = 0;
            if ($result->num_rows > 0) { 
                echo "<div style='line-height:1;padding:20px 15px;margin:10px 0px 40px 0px;background-image: linear-gradient(transparent,white,white,white,white,transparent);color:#222;'><h2>Attributions</h2>
                <ul style='text-align:left;list-style-type: square;margin-left:20px;'>";
                while($row = $result->fetch_assoc()) {
                    if ($USER_LANG == "FR"){
                        $name_trad = $row["name_fr"];
                        $description_trad = $row["description_fr"];
                    }else{
                        $name_trad = $row["name_en"];
                        $description_trad = $row["description_en"];
                    }    
                    if ($row["img_link"] != ""){
                        echo "<li style='margin-bottom:20px;'><strong>".$name_trad."</strong><br><img src='".$row["img_link"]."' style='width:100px;height:auto;'><br>".$description_trad." <u><a href='".$row["href"]."' target='_blank'>".$row["href"]."</u><span style='font-size:14px;'> ↗</span></a></li>";
                    } else {
                        echo "<li style='margin-bottom:20px;'><strong>".$name_trad."</strong><br>".$description_trad."<br><u><a href='".$row["href"]."' target='_blank'>".$row["href"]."</u><span style='font-size:14px;'> ↗</span></a></li>";
                    }
                }
            echo "</ul></div>";
            }
        ?>
    <div id='divFrame' class='dw3_form'>
		<div id='divFrame_HEADER' class='dw3_form_head'></div>
		<button onclick='closeFrame();' class='dw3_form_close'>❎</button>
		<iframe class='dw3_form_data' id='divFrameData' src='' style='width:100%;height:100%;'></iframe>
		<div class='dw3_form_foot'><button class='dw3_form_cancel' onclick='closeFrame()'>Ok</button></div>                    
    </div>

<script>

document.getElementById('txtContactPhone').addEventListener('input', function (e) {
  var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
  e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
});

function emlContact(){
	var sEML  = document.getElementById("txtContactEmail").value;
	var sNOM  = document.getElementById("txtContactName").value;
	var sTEL  = document.getElementById("txtContactPhone").value;
	var sMSG  = document.getElementById("txtContactMessage").value;

	if (sNOM.trim() == ""){
		document.getElementById("txtContactName").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtContactName").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("txtContactName").style.boxShadow = "0px 0px 0px white";
		//document.getElementById("lblPRD").innerHTML = "";
	}
    if (sEML.trim() == ""){
		document.getElementById("txtContactEmail").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtContactEmail").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("txtContactEmail").style.boxShadow = "0px 0px 0px white";
		//document.getElementById("lblPRD").innerHTML = "";
	}
    if (sMSG.trim() == ""){
		document.getElementById("txtContactMessage").style.boxShadow = "5px 10px 15px red";
		document.getElementById("txtContactMessage").focus();
		//document.getElementById("lblPRD").innerHTML = "Veuillez entrer un # de produit.";
		return;
	} else {
		document.getElementById("txtContactMessage").style.boxShadow = "0px 0px 0px white";
		//document.getElementById("lblPRD").innerHTML = "";
	}
    document.getElementById("txtContactPhone").style.boxShadow = "0px 0px 0px white";

    document.getElementById("dw3_body_fade").style.display = "inline-block";
    document.getElementById("dw3_msg").style.display = "inline-block";
	document.getElementById("dw3_msg").innerHTML = "<br>Le message est en cours d'envoi<br><img style='width:100px;height:auto;border-radius:5px;' src='/pub/img/load/<?php echo $CIE_LOAD; ?>'><br><span style='color:#999;font-size:16px;'>Veuillez patienter un instant..</span>";
    document.getElementById("btnSEND").disabled = true;
    document.getElementById("btnSEND").style.boxShadow = "2px 2px 5px red";

    var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  if (this.responseText == "ok"){
                document.getElementById("dw3_body_fade").style.display = "inline-block";
                document.getElementById("dw3_msg").style.display = "inline-block";
                document.getElementById("btnSEND").innerHTML = 'Envoyé';
                if (USER_LANG=="FR"){
				    document.getElementById("dw3_msg").innerHTML = "Votre message a été envoyé!<br><br><button onclick='dw3_msg_close();'>✅ Ok</button>";
                }else{
				    document.getElementById("dw3_msg").innerHTML = "Your message has been sent!<br><br><button onclick='dw3_msg_close();'>✅ Ok</button>";
                }
          } else if (this.responseText == "e1"){
                document.getElementById("txtContactEmail").style.boxShadow = "5px 10px 15px red";
                document.getElementById("txtContactEmail").focus();
                document.getElementById("dw3_body_fade").style.display = "inline-block";
                document.getElementById("dw3_msg").style.display = "inline-block";
				document.getElementById("dw3_msg").innerHTML = "Adresse courriel invalide.<br><br><button onclick='dw3_msg_close();'>✅ Ok</button>";
                document.getElementById("btnSEND").disabled = false;
                document.getElementById("btnSEND").style.boxShadow = 'var(--dw3_button_shadow)';
                if (USER_LANG == "FR"){ 
                    document.getElementById("btnSEND").innerHTML = 'Envoyer';
                }else{
                    document.getElementById("btnSEND").innerHTML = 'Send';
                }
                
		  } else {
		        document.getElementById("dw3_body_fade").style.display = "inline-block";
                document.getElementById("dw3_msg").style.display = "inline-block";
				document.getElementById("dw3_msg").innerHTML = this.responseText + "<br><br><button onclick='dw3_msg_close();'>✅ Ok</button>";
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

var CART = <?php if(isset($_COOKIE["CART"])) { echo $_COOKIE["CART"]; }  else {echo "[]";} ?>;
</script>
<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_FOOTER;
    exit; 
?>
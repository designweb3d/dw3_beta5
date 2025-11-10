<?php 
if 	($SECTION_IMG_DSP  =="gradiant"){$bg_gradiant = "background-image:".$SECTION_IMG.";";} else {$bg_gradiant = "";}
if 	($SECTION_FONT!=""){$font_family = "font-family:".$SECTION_FONT.";";} else {$font_family = "";}
echo "<div style='margin:".$SECTION_MARGIN.";display:inline-block;width:100%;height:auto;background-color:".$SECTION_BG.";color:".$SECTION_FG.";box-shadow: ".$SECTION_SHADOW.";".$bg_gradiant.$font_family."'>"; ?>
    <table style='width:100%;text-align:center;max-width:2800px;margin-right:auto;margin-left:auto;margin-bottom:0px;border-collapse: collapse;'><tr>
        <td width='*' style='line-height: 150%;text-align:left;vertical-align:middle;'><span style='margin:15px;'><b>
        <?php 
            if ($SECTION_HTML_FR == ""){
                if($USER_LANG == "FR"){ 
                    echo "Vous souhaitez réaliser un projet ? Contactez-nous ou remplissez le formulaire, c’est simple et rapide!";
                }else{
                    echo "Do you want to carry out a project? Contact us or fill out the form, it’s quick and easy!";
                }
            } else {
                if($USER_LANG == "FR"){ 
                    echo $SECTION_HTML_FR;
                }else{
                    echo $SECTION_HTML_EN;
                }
            }
        ?>
        </b></span></td>
        <td  style='vertical-align:middle;'><button onclick='window.open("/pub/page/contact3/index.php?PID=<?php echo $PARAM1; ?>","_self")'  style='padding:10px 25px;float:right;margin:20px;'>Contact</button></td>
    </tr></table>
</div>
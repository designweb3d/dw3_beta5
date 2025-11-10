<?php 
if 	($SECTION_IMG_DSP  =="gradiant"){$bg_gradiant = "background-image:".$SECTION_IMG.";";} else {$bg_gradiant = "";}
if 	($SECTION_FONT!=""){$font_family = "font-family:".$SECTION_FONT.";";} else {$font_family = "";}

echo "<div style='margin:".$SECTION_MARGIN.";display:inline-block;width:100%;height:auto;background-color:".$SECTION_BG.";color:".$SECTION_FG.";box-shadow: ".$SECTION_SHADOW.";".$bg_gradiant.$font_family."'>"; ?>
    <table style='width:100%;text-align:center;max-width:800px;margin-right:auto;margin-left:auto;margin-bottom:0px;border-collapse: collapse;margin-bottom:10px;'><tr>
        <td width='*' style='line-height: 150%;text-align:middle;vertical-align:middle;'><span style='margin:15px;'><b>
        <?php 
            if ($SECTION_HTML_FR == ""){
                if($USER_LANG == "FR"){ 
                    echo "Abonnez-vous à notre infolettre!";
                }else{
                    echo "Subscribe to our Newsletters!";
                }
            } else {
                if($USER_LANG == "FR"){ 
                    echo $SECTION_HTML_FR;
                }else{
                    echo $SECTION_HTML_EN;
                }
            }
        ?>
        </b></span></td></tr><tr>
        <td style='vertical-align:middle;text-align:center;'><input type='text' id='new_eml_news2' placeholder="Entrez votre adresse courriel" style='width:90%;margin:0px 0px 20px 0px;max-width:400px;'></td>
    </tr><tr><td style='text-align:middle;'><button id='btn_eml_news2' class='no-effect' onclick='add_eml_news2();'><span class='dw3_font'>Ē</span> Je m'inscrit!</button></td></tr></table>
</div>
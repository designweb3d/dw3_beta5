<?php 
$PAGE_URL = "/pub/page/profil/index.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
 if ($PAGE_ID == ""){
     $sql = "SELECT * FROM index_head WHERE url = '/pub/page/profil/index.php'; ";
     $result = $dw3_conn->query($sql);
     if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
                 $PAGE_PID = $row["parent_id"];
                 if ($row["header_path"] != ""){$PAGE_HEADER = $row["header_path"];}
                 $PAGE_TITLE = $row["title"];
                 $PAGE_TITLE_EN = $row["title_en"];
                 $PAGE_IMG = $row["img_url"];
                 $PAGE_SCENE = $row["scene"];
                 $PAGE_IMG_DSP = $row["img_display"];
                 $PAGE_TITLE_DSP = $row["title_display"];
                 $PAGE_ICON_DSP = $row["icon_display"];
                 $PAGE_TARGET = $row["target"];
                 $PAGE_MENU = $row["is_in_menu"];
                 $PAGE_ICON = $row["icon"];
                 $PAGE_LIST = $row["cat_list"];
                 $PAGE_ID = $row["id"];
                 $PAGE_OPACITY = $row["opacity"];
                 $PAGE_BG = $row["background"];
                 $PAGE_FG = $row["foreground"];
                 $PAGE_FONT = $row["font_family"];
                 $PAGE_MAXW = $row["max_width"];
                 $PAGE_MARGIN = $row["margin"];
                 $PAGE_RADIUS = $row["border_radius"];
                 $PAGE_SHADOW = $row["boxShadow"];
                 $PAGE_HTML_FR = $row["html_fr"];
                 $PAGE_HTML_EN = $row["html_en"];
                 $PAGE_VISITED = $row["total_visited"];
                 $PAGE_URL = $row["url"];
                 $CIE_BG1 = $row["img_url"];
         }
     }
 }
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_main.php';
 require_once $_SERVER['DOCUMENT_ROOT'] . $PAGE_HEADER;
 require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';

 $sql = "SELECT code,text1,text2,text3 FROM config 
 WHERE kind = 'CIE' AND code = 'TYPE' 
 OR kind = 'CIE' AND code = 'CAT' 
 OR kind = 'CIE' AND code = 'NOM_HTML' 
 OR kind = 'PLAN' AND code = 'APERCU' ";
 $result = mysqli_query($dw3_conn, $sql);
 $PROFIL_TYPE = "";
 $PROFIL_CAT = "";
 $PROFIL_APERCU = "";
 $PROFIL_DSP_TYPE = "";
 $PROFIL_DSP_CAT = "";
 $PROFIL_DSP_APERCU = "";
 $PROFIL_SLOGAN_FR = "";
 $PROFIL_SLOGAN_EN = "";
 if ($result->num_rows > 0) {
     while($row = $result->fetch_assoc()) {
        if ($row["code"]=="TYPE" && trim($row["text2"] != "")){$PROFIL_TYPE = trim($row["text1"]);}
        if ($row["code"]=="CAT" && trim($row["text2"] != "")){$PROFIL_CAT = trim($row["text1"]);}
        if ($row["code"]=="APERCU" && trim($row["text2"] != "")){$PROFIL_APERCU = trim($row["text1"]);}
        if ($row["code"]=="TYPE" && trim($row["text1"] != "")){$PROFIL_DSP_TYPE = trim($row["text2"]);}
        if ($row["code"]=="CAT" && trim($row["text1"] != "")){$PROFIL_DSP_CAT = trim($row["text2"]);}
        if ($row["code"]=="APERCU" && trim($row["text1"] != "")){$PROFIL_DSP_APERCU = trim($row["text2"]);}
        if ($row["code"]=="NOM_HTML" && trim($row["text2"] != "")){$PROFIL_SLOGAN_FR = trim($row["text2"]);}
        if ($row["code"]=="NOM_HTML" && trim($row["text3"] != "")){$PROFIL_SLOGAN_EN = trim($row["text3"]);}
     }
 }

if (!isset($PAGE_IMG_DSP)){$PAGE_IMG_DSP = "";}
if (!isset($PAGE_FONT)){$PAGE_FONT = "";}
if (!isset($PAGE_BG)){$PAGE_BG = "#333";}
if (!isset($PAGE_FG)){$PAGE_FG = "#DDD";}
if (!isset($PAGE_MARGIN)){$PAGE_MARGIN = "10px";}
if (!isset($PAGE_IMG)){$PAGE_IMG = "";}
if (!isset($PAGE_RADIUS)){$PAGE_RADIUS = "0px";}
if (!isset($PAGE_MAXW)){$PAGE_MAXW = "800px;width:100%";}
if (!isset($PAGE_SHADOW)){$PAGE_SHADOW = "none";}
 if ($PAGE_IMG_DSP=="gradiant"){$bg_gradiant = "background-image:".$PAGE_IMG.";";} else {$bg_gradiant = "";}
 if ($PAGE_FONT!=""){$font_family = "font-family:".$PAGE_FONT.";";} else {$font_family = "";}
 echo "<div style='line-height:1.2;background-color:".$PAGE_BG.";color:". $PAGE_FG.";max-width:100%;text-align:center;margin:". $PAGE_MARGIN.";display:inline-block;text-align:center;height:auto;border-radius:". $PAGE_RADIUS.";max-width:". $PAGE_MAXW.";box-shadow:". $PAGE_SHADOW.";".$bg_gradiant.$font_family."'>";

//type dentreprise
if($USER_LANG == "FR"){ 
    if ($CIE_TYPE == "1") {$PROFIL_TYPE = "est une entreprise individuelle";}
    if ($CIE_TYPE == "2") {$PROFIL_TYPE = "est une société en nom collectif";}
    if ($CIE_TYPE == "3") {$PROFIL_TYPE = "est une société en commandite";}
    if ($CIE_TYPE == "4") {$PROFIL_TYPE = "est une société par actions";}
    if ($CIE_TYPE == "5") {$PROFIL_TYPE = "est une coopérative";}
    if ($CIE_TYPE == "6") {$PROFIL_TYPE = "est un organisme à but non lucratif";}
} else {
    if ($CIE_TYPE == "1") {$PROFIL_TYPE = "is a sole proprietorship";}
    if ($CIE_TYPE == "2") {$PROFIL_TYPE = "is a general partnership";}
    if ($CIE_TYPE == "3") {$PROFIL_TYPE = "is a limited partnership";}
    if ($CIE_TYPE == "4") {$PROFIL_TYPE = "is a corporation";}
    if ($CIE_TYPE == "5") {$PROFIL_TYPE = "is a cooperative";}
    if ($CIE_TYPE == "6") {$PROFIL_TYPE = "is a non-profit organization";}
}


//categorie 
if($USER_LANG == "FR"){ 
    if ($CIE_CAT == "2") {$PROFIL_CAT="les principaux secteurs d'activités sont l'agriculture, foresterie, pêche et chasse";}
    if ($CIE_CAT == "3") {$PROFIL_CAT="les principaux secteurs d'activités sont les arts, spectacles et loisirs";}
    if ($CIE_CAT == "4") {$PROFIL_CAT="le principal secteur d'activité est l'offre de services (sauf les administrations publiques)";}
    if ($CIE_CAT == "5") {$PROFIL_CAT="le principal secteur d'activité est le commerce de détail";}
    if ($CIE_CAT == "6") {$PROFIL_CAT="le principal secteur d'activité est le commerce de gros";}
    if ($CIE_CAT == "7") {$PROFIL_CAT="le principal secteur d'activité est la construction";}
    if ($CIE_CAT == "8") {$PROFIL_CAT="les principaux secteurs d'activités sont l'extraction minière, exploitation en carrière, et extraction de pétrole et de gaz";}
    if ($CIE_CAT == "9") {$PROFIL_CAT="le principal secteur d'activité est la fabrication";}
    if ($CIE_CAT == "10") {$PROFIL_CAT="les principaux secteurs d'activités sont la finance et les assurances";}
    if ($CIE_CAT == "11") {$PROFIL_CAT="le principal secteur d'activité est la gestion de sociétés et d'entreprises";}
    if ($CIE_CAT == "12") {$PROFIL_CAT="le principal secteur d'activité est l'hébergement";}
    if ($CIE_CAT == "13") {$PROFIL_CAT="les principaux secteurs d'activités sont l'industrie de l'information et l'industrie culturelle";}
    if ($CIE_CAT == "14") {$PROFIL_CAT="les principaux secteurs d'activités sont les services administratifs et les services de soutien";}
    if ($CIE_CAT == "15") {$PROFIL_CAT="les principaux secteurs d'activités sont les services d'enseignement";}
    if ($CIE_CAT == "16") {$PROFIL_CAT="les principaux secteurs d'activités sont les services de restauration";}
    if ($CIE_CAT == "17") {$PROFIL_CAT="les principaux secteurs d'activités sont les services immobiliers et services de location et de location à bail";}
    if ($CIE_CAT == "18") {$PROFIL_CAT="les principaux secteurs d'activités sont les services professionnels, scientifiques et techniques";}
    if ($CIE_CAT == "20") {$PROFIL_CAT="les principaux secteurs d'activités sont les soins de santé et assistance sociale";}
    if ($CIE_CAT == "21") {$PROFIL_CAT="les principaux secteurs d'activités sont le transport et l'entreposage";}
    if ($CIE_CAT == "22") {$PROFIL_CAT="le principal secteur d'activité est le transport par camion";}
} else {
    if ($CIE_CAT == "2") {$PROFIL_CAT="the main sectors of activity are agriculture, forestry, fishing and hunting";}
    if ($CIE_CAT == "3") {$PROFIL_CAT="the main sectors of activity are arts, entertainment and recreation";}
    if ($CIE_CAT == "4") {$PROFIL_CAT="the main sector of activity is the provision of services (except public administration)";}
    if ($CIE_CAT == "5") {$PROFIL_CAT="the main sector of activity is retail trade";}
    if ($CIE_CAT == "6") {$PROFIL_CAT="the main sector of activity is wholesale trade";}
    if ($CIE_CAT == "7") {$PROFIL_CAT="the main sector of activity is construction";}
    if ($CIE_CAT == "8") {$PROFIL_CAT="the main sectors of activity are mining, quarrying, and oil and gas extraction";}
    if ($CIE_CAT == "9") {$PROFIL_CAT="the main sector of activity is manufacturing";}
    if ($CIE_CAT == "10") {$PROFIL_CAT="the main sectors of activity are finance and insurance";}
    if ($CIE_CAT == "11") {$PROFIL_CAT="the main sector of activity is management of companies and businesses";}
    if ($CIE_CAT == "12") {$PROFIL_CAT="the main sector of activity is accommodation";}
    if ($CIE_CAT == "13") {$PROFIL_CAT="the main sectors of activity are the information industry and the cultural industry";}
    if ($CIE_CAT == "14") {$PROFIL_CAT="the main sectors of activity are administrative and support services";}
    if ($CIE_CAT == "15") {$PROFIL_CAT="the main sectors of activity are educational services";}
    if ($CIE_CAT == "16") {$PROFIL_CAT="the main sectors of activity are food services";}
    if ($CIE_CAT == "17") {$PROFIL_CAT="the main sectors of activity are real estate services and rental and leasing services";}
    if ($CIE_CAT == "18") {$PROFIL_CAT="the main sectors of activity are professional, scientific and technical services";}
    if ($CIE_CAT == "20") {$PROFIL_CAT="the main sectors of activity are health care and social assistance";}
    if ($CIE_CAT == "21") {$PROFIL_CAT="the main sectors of activity are transportation and warehousing";}
    if ($CIE_CAT == "22") {$PROFIL_CAT="the main sector of activity is truck transportation";}
}
        //TITRE
        if($USER_LANG == "FR"){ 
            echo "<h1 style='margin:30px 0px 10px 0px;'>PROFIL DE L'ENTREPRISE</h1>";
        }else{
            echo "<h1 style='margin:30px 0px 10px 0px;'>COMPANY PROFILE</h1>";
        }
        //SLOGAN
        if($USER_LANG == "FR"){
            if ($PROFIL_SLOGAN_FR!= ""){echo "<h3>". $PROFIL_SLOGAN_FR ."</h3>";} 
        }else{
            if ($PROFIL_SLOGAN_EN!= ""){echo "<h3>". $PROFIL_SLOGAN_EN ."</h3>";} 
        }

        echo "<div style='margin:20px 0px;text-align:left;'>";
            //ANNÉE D'OUVERTURE
            if($USER_LANG == "FR"){
                echo "Fondé en " . $CIE_DOUV.",";
            }else{
                echo "Founded in " . $CIE_DOUV .",";
            }

            //TYPE & CAT
            if ($PROFIL_TYPE!= "" && $PROFIL_DSP_TYPE == "true" && $PROFIL_CAT!= "" && $PROFIL_DSP_CAT == "true"){
                echo "<div style='height:10px;'> </div>".$CIE_NOM. " ". strtolower($PROFIL_TYPE); if($USER_LANG == "FR"){echo " dont ";}else{ echo " of which "; } echo strtolower($PROFIL_CAT).".";
            } else if ($PROFIL_TYPE!= "" && $PROFIL_DSP_TYPE == "true" && $PROFIL_DSP_CAT == "false"){
                echo "<div style='height:10px;'> </div>".$CIE_NOM. " ". strtolower($PROFIL_TYPE) . ".";
            } else if ($PROFIL_DSP_TYPE == "false" && $PROFIL_CAT!= "" && $PROFIL_DSP_CAT == "true"){
                echo "<div style='height:10px;'> </div>Chez ".$CIE_NOM." ". strtolower($PROFIL_CAT) . ".";
            }
            //APERCU
            if ($PROFIL_APERCU!= "" && $PROFIL_DSP_APERCU == "true"){echo "<div style='height:10px;'> </div><pre style='max-width:100%;white-space: pre-wrap;text-align:left;".$font_family."'>".$PROFIL_APERCU . "</pre><div style='height:20px;'> </div>";}
        if($USER_LANG == "FR"){
            echo "<div style='height:10px;'> </div>".$PAGE_HTML_FR . "<br>";
        }else{
            echo "<div style='height:10px;'> </div>".$PAGE_HTML_EN . "<br>";
        }
echo "</div></div>";
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("dw3_body").innerHTML = "";

});
</script>
<?php 
     require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_FOOTER;
?>

</body>
</html>

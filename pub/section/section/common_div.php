<canvas id="dw3_scene"></canvas>
<div id='dw3_body'>
<?php
$section_number = 0;
$timeline_number = 0;
$TABINDEX = 0;
    if ($PAGE_ID !="" || $_SERVER["SCRIPT_FILENAME"] == $_SERVER['DOCUMENT_ROOT'] . "/index.php"){
        $sql_common = "SELECT * FROM index_head WHERE parent_id='".$PAGE_ID ."' ORDER BY menu_order ASC;";
        $result_common = $dw3_conn->query($sql_common);
        if ($result_common->num_rows > 0) {
            while($row_common = $result_common->fetch_assoc()) {
                $section_style = "";
                if ($row_common["target"] == "section"){
                    $SECTION_PID = $row_common["parent_id"];
                    $SECTION_HEADER = $row_common["header_path"];
                    $SECTION_TITLE = $row_common["title"];
                    $SECTION_TITLE_EN = $row_common["title_en"];
                    $SECTION_IMG = $row_common["img_url"];
                    $SECTION_IMG_ANIM = $row_common["img_anim"];
                    $SECTION_IMG_ANIM_TIME = $row_common["img_anim_time"];
                    $SECTION_IMG_DSP = $row_common["img_display"];
                    $SECTION_TITLE_DSP = $row_common["title_display"];
                    $SECTION_ICON_DSP = $row_common["icon_display"];
                    $SECTION_TARGET = $row_common["target"];
                    $SECTION_MENU = $row_common["is_in_menu"];
                    $SECTION_ICON = $row_common["icon"];
                    $SECTION_ICON_COLOR = $row_common["icon_color"];
                    $SECTION_ICON_TEXT_SHADOW = $row_common["icon_textShadow"];
                    $SECTION_LIST = $row_common["cat_list"];
                    $PARAM1 = $SECTION_LIST;
                    $cat_lst = $SECTION_LIST;
                    $cat_list = $SECTION_LIST;
                    $SECTION_ID = $row_common["id"];
                    $SID = $SECTION_ID;
                    $SECTION_OPACITY = $row_common["opacity"];
                    $SECTION_BG = $row_common["background"];
                    $SECTION_FG = $row_common["foreground"];
                    $SECTION_FONT = $row_common["font_family"];
                    $SECTION_MAXW = $row_common["max_width"];
                    $SECTION_MARGIN = $row_common["margin"];
                    $SECTION_RADIUS = $row_common["border_radius"];
                    $SECTION_SHADOW = $row_common["boxShadow"];
                    $SECTION_HTML_FR = $row_common["html_fr"];
                    $SECTION_HTML_EN = $row_common["html_en"];
                    $SECTION_VISITED = $row_common["total_visited"];
                    $SECTION_URL = $row_common["url"];
                    //error_log($SECTION_URL."-".$SECTION_FONT . "\n", 3, $_SERVER['DOCUMENT_ROOT'] . '/section_font.log');
                    if ($row_common["img_display"] == "background"){
                        $section_style = "background-image: url('/pub/upload/".$row_common["img_url"]."');background-position:center center;background-size:cover;background-repeat:no-repeat;background-attachment:fixed;";
                    } else if ($row_common["img_display"] == "background2"){
                        $section_style = "background-image: url('/pub/upload/".$row_common["img_url"]."');background-position:center center;background-size:cover;background-repeat:no-repeat;background-attachment:scroll;";
                    }else {
                        $section_style = "";
                    }
                    $section_style .= "background-color:".$SECTION_BG.";border-radius:".$SECTION_RADIUS.";";
                    if ($row_common["url"] == "/pub/section/slideshow2/index.php" || $row_common["url"] == "/pub/section/slideshow3/index.php"){
                        $section_style .= "display:inline-block;width:auto;";
                    }
                    if ($SECTION_IMG_ANIM != "" && $SECTION_IMG_ANIM_TIME != ""){
                        $SECTION_IMG_ANIM_TIME = "animation-duration: ".$SECTION_IMG_ANIM_TIME. "s;";
                    } else {
                        $SECTION_IMG_ANIM_TIME = "";
                    }
                    //chatbot not inline
                    if ($SECTION_URL == "/pub/section/chatbot/index.php"){
                        echo '<div id="dw3_chatbot_container" style="'.$section_style.'">' .PHP_EOL;
                        require($_SERVER['DOCUMENT_ROOT'] . $SECTION_URL);
                        echo '</div>'.PHP_EOL;
                        echo '<div id="dw3_chatbot_btn" onclick="dw3_chatbot_toggle();" class="dw3_noselect"><span class="dw3_font" style="vertical-align:middle;margin:12px 8px;">Ư</span></div>'.PHP_EOL;
                    }else {
                        echo '<div id="dw3_section_'.$section_number.'" class="dw3_section dw3_section_'.$row_common["anim_class"].' '.$SECTION_IMG_ANIM.'" style="'.$section_style.$SECTION_IMG_ANIM_TIME.'">' .PHP_EOL;
                        require($_SERVER['DOCUMENT_ROOT'] . $SECTION_URL);
                        echo '</div>'.PHP_EOL;
                    } 
                    $section_number++;
                    if ($row_common["url"] == "/pub/section/historic/index.php" || $row_common["url"] == "/pub/section/historic2/index.php" || $row_common["url"] == "/pub/section/realisation/index.php" || $row_common["url"] == "/pub/section/realisation2/index.php"){
                        $timeline_number++;
                    }
                }
            }
        }
    }
    //error_log("AFTER-".$SECTION_FONT . "\n", 3, $_SERVER['DOCUMENT_ROOT'] . '/section_font.log');
?>

</div>
<div id='dw3_notif_container'></div>
<div id='dw3_copyright_bar'>© <?php echo $CIE_NOM;?></div>
<div id='dw3_body_fade' class='dw3_body_fade'></div>
<div id='dw3_form_fade'></div>
<div id="dw3_msg"></div>
<div id="dw3_scroll_top" onclick="window.scrollTo({top: 0, behavior: 'smooth'});" class="dw3_noselect"><span class='dw3_font' style="vertical-align:middle;margin:12px 8px;">ľ</span></div>
<div id='dw3_cookie_msg'></div>
<div id='dw3_editor'></div>
<div id='dw3_menu_fade' onclick='dw3_menu_toggle()'></div>
<div id='dw3_cart'></div>
<div id='dw3_cookie_pref'><div style='margin:15px;line-height:1;display:inline-block;min-width:350px;overflow:hidden;'>
    <?php if($USER_LANG == "FR"){ ?>
        <h4><button style='float:right;border-radius:20px;' class='no-effect' onclick='document.getElementById("dw3_cookie_pref").style.transform="scaleX(0%)"'> X </button>Préférences en matière de conservation des données </h4>
        <div style='text-align:justify;margin:10px 0px 15px 0px;'>Lorsque vous visitez notre site Web, nous peuvent stockons et récupérons des données vous concernant à l'aide de ("cookies"). Les cookies peuvent être nécessaires pour la fonctionnalité de base du site Web ainsi qu'à d'autres fins. Vous avez la possibilité de désactiver certains types de cookies, bien que cela puisse avoir un impact sur votre expérience sur le site Web.<br>
            <hr>
            <label for='dw3_cookie_pref1'><b>Essentiel</b> : </label><input id='dw3_cookie_pref1' checked disabled type='checkbox'><br>
            Nécessaire pour activer les fonctionnalités de base du site Web (dont le choix de langue et le contenu du panier). Vous ne pouvez pas désactiver les cookies essentiels. 
            <hr>
            <label for='dw3_cookie_pref2'><b>Publicité ciblée</b> : </label><input id='dw3_cookie_pref2' <?php if($COOKIE_PREF2 == "OK") {echo "checked";} ?> type='checkbox'><br>
            N'est pas utilisé sur ce site présentement. Peut-être utilisé pour diffuser des publicités plus pertinentes pour vous et vos intérêts. Peut également être utilisé pour limiter le nombre de fois que vous voyez une publicité et mesurer l'efficacité des campagnes publicitaires. Les réseaux publicitaires les placent généralement avec l'autorisation de l'opérateur du site Web.
            <hr>
            <label for='dw3_cookie_pref3'><b>Personnalisation</b> : </label><input id='dw3_cookie_pref3' <?php if($COOKIE_PREF3 == "OK") {echo "checked";} ?> type='checkbox'><br>
            Autorisez le site Web à mémoriser les choix que vous faites (tels que les pages et produits que vous avez consultés) et offrir des fonctionnalités améliorées et plus personnelles.
            <hr>
            <label for='dw3_cookie_pref4'><b>Analyses</b> : </label><input id='dw3_cookie_pref4' <?php if($COOKIE_PREF4 == "OK") {echo "checked";} ?> type='checkbox'><br>
            Aidez l'opérateur du site Web à comprendre comment son site Web fonctionne, comment les visiteurs interagissent avec le site et s'il peut y avoir des problèmes techniques.
        </div>
        <button onclick='dw3_cookie_save();' style='padding:10px;' class='green no-effect'>Sauvegarder</button><br>
    <?php } else { ?>    
        <h4><button style='float:right;border-radius:20px;' class='no-effect' onclick='document.getElementById("dw3_cookie_pref").style.transform="scaleX(0%)"'> X </button>Data retention preferences </h4>
        <div style='text-align:left;margin:10px 0px 15px 0px;'>When you visit websites, they may store or retrieve data about you using cookies and similar technologies (“cookies”). Cookies may be necessary for basic functionality of the website as well as for other purposes. You have the option to disable certain types of cookies, although this may impact your experience on the website.<br>
            <hr>
            <label for='dw3_cookie_pref1'><b>Essential</b> : </label><input id='dw3_cookie_pref1' checked disabled type='checkbox'><br>
            Necessary to enable basic functionality of the website (including language choice and the shopping cart content). You cannot disable essential cookies.
            <hr>
            <label for='dw3_cookie_pref2'><b>Targeted advertising</b> : </label><input id='dw3_cookie_pref2' <?php if($COOKIE_PREF2 == "OK") {echo "checked";} ?> type='checkbox'><br>
            Used to deliver advertisements more relevant to you and your interests. Can also be used to limit the number of times you see an advertisement and measure the effectiveness of advertising campaigns. Advertising networks usually place them with the permission of the website operator.
            <hr>
            <label for='dw3_cookie_pref3'><b>Personnalization</b> : </label><input id='dw3_cookie_pref3' <?php if($COOKIE_PREF3 == "OK") {echo "checked";} ?> type='checkbox'><br>
            Allow the website to remember choices you make (such as the pages and products you have viewed) and provide enhanced, more personal features.
            <hr>
            <label for='dw3_cookie_pref4'><b>Analyses</b> : </label><input id='dw3_cookie_pref4' <?php if($COOKIE_PREF4 == "OK") {echo "checked";} ?> type='checkbox'><br>
            Help the website operator understand how their website works, how visitors interact with the site, and whether there may be technical issues.
        </div>
        <button onclick='dw3_cookie_save();' style='padding:10px;' class='green no-effect'>Save</button><br>
    <?php } ?></div>
</div>
<!-- Section Gallery 2 Modal -->
<div id="gal2_modal" class="gal2_modal" onclick='dw3_gal2_close()'>
  <div id="gal2_caption"></div>
  <span class="gal2_close" onclick='dw3_gal2_close()'>&times;</span>
  <img class="gal2_modal-content" id="gal2_model_img">
</div>
<!-- Section Gallery 3 Swipe Modal -->
<div id="gal3_modal" class="gal2_modal" style='cursor: default;overflow:hidden;'>
  <div id="gal3_caption"></div>
  <span class="gal2_close" onclick='dw3_gal3_close()'>&times;</span>
  <span class="gal3_back" onclick='dw3_gal3_back()'><</span>
  <span class="gal3_next" onclick='dw3_gal3_next()'>></span>
  <img class="gal3_modal-content" id="gal3_model_img">
</div>
<script><?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/js/multiavatar.min.js'; ?></script>
<?php 
if ($section_number > 0){ include $_SERVER['DOCUMENT_ROOT'] . '/pub/js/section.js.php'; }

if ($timeline_number > 0){ 
    echo "<script>";
        include $_SERVER['DOCUMENT_ROOT'] . '/pub/js/jquery-3.7.1.min.js'; 
    echo "</script>";
    include $_SERVER['DOCUMENT_ROOT'] . '/pub/js/timeline.js.php'; 
    } 
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/js/page.js.php'; ?>

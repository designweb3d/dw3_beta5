<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
$ID  = $_GET['ID'];

//get some page display settings from summary page
$PAGE_ID  = $_GET['P1'];
if ($PAGE_ID !="" && $PAGE_ID != "0"){
    $sql = "SELECT *
    FROM index_head
    WHERE id = '".$PAGE_ID."'";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
                $PAGE_PID = $row["parent_id"];
                if ($row["header_path"] != ""){$PAGE_HEADER = $row["header_path"];}
                $PAGE_IMG = $row["img_url"];
                $PAGE_IMG_DSP = $row["img_display"];
                $PAGE_BG = $row["background"];
                $PAGE_FG = $row["foreground"];
                $CIE_BG1 = $row["img_url"];
                $PAGE_URL = "/pub/page/article/article.php";
        }
    }
}

$sql = "SELECT * FROM article WHERE id = '".$ID."' LIMIT 1;";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    header('Location: https://'.$_SERVER["SERVER_NAME"].'/');
    exit;
}
$image_url = "https://".$_SERVER["SERVER_NAME"].'pub/upload/'.$data["img_link"];
$share_url = "https://".$_SERVER["SERVER_NAME"].'/pub/page/article/article.php?ID='.$data["id"].'&P1='.$PAGE_P1;
if (!isset($dw3_conn)){header('Location: https://'.$_SERVER["SERVER_NAME"].'/');exit;}?><!DOCTYPE html>
    <html lang="<?php if ($USER_LANG == "FR"){echo "fr";} else{echo "en";} ?>"><head>
       <meta charset="utf-8">
       <title><?php 
        if ($USER_LANG == "FR"){
            echo $data["title_fr"] . " - " . $CIE_NOM;
        } else {
            echo $data["title_en"] . " - " . $CIE_NOM;
        } ?></title>
       <meta name="description" content="<?php echo $INDEX_META_DESC; ?>">
       <meta name="keywords" content="<?php echo $INDEX_META_KEYW; ?>">
       <meta name="author" content="<?php echo $CIE_NOM; ?>">
       <meta name="theme-color" content="#<?php echo $CIE_COLOR8??'444'; ?>">
       <meta property="og:title" content="<?php if ($USER_LANG == "FR"){echo $data["title_fr"];} else {echo $data["title_en"];} ?>"><meta property="og:description" content="<?php if ($USER_LANG == "FR"){echo substr($data["description_fr"],0,80).'..';} else {echo substr($data["description_en"],0,80).'..';} ?>"><meta property="og:image" content="<?php echo $image_url; ?>"><meta property="og:url" content="<?php echo $share_url; ?>">
       <meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="<?php if ($USER_LANG == "FR"){echo $data["title_fr"];} else {echo $data["title_en"];} ?>"><meta name="twitter:description" content="<?php if ($USER_LANG == "FR"){echo $data["description_fr"];} else {echo $data["description_en"];} ?>"><meta name="twitter:image" content="<?php echo $image_url; ?>">
       <meta http-equiv="page-enter" content="revealtrans(duration=2,transition=1)" />
       <meta http-equiv="page-exit" content="revealtrans(duration=2,transition=1)" />
       <meta name="robots" content="all"> 
       <meta name="googlebot" content="all">
       <link rel="amphtml" href="<?php echo $share_url;?>">
       <script type="importmap">{"imports": {"three": "/api/three.js/build/three.module.js","three/addons/": "./jsm/"}}</script>
       <meta name="viewport" content="width=device-width, viewport-fit=cover, user-scalable=no, shrink-to-fit=no, initial-scale=1.0, maximum-scale=1.0" />
           <link rel="apple-touch-icon" sizes="180x180" href="<?php echo 'https://'.$_SERVER["SERVER_NAME"]; ?>/pub/img/apple-touch-icon.png">
           <link rel="icon" type="image/png" sizes="96x96" href="<?php echo 'https://'.$_SERVER["SERVER_NAME"]; ?>/pub/img/favicon-96x96.png">
           <link rel="icon" type="image/png" sizes="32x32" href="<?php echo 'https://'.$_SERVER["SERVER_NAME"]; ?>/pub/img/favicon-32x32.png">
           <link rel="icon" type="image/png" sizes="16x16" href="<?php echo 'https://'.$_SERVER["SERVER_NAME"]; ?>/pub/img/favicon-16x16.png">
           <link rel="icon" type="image/svg+xml" href="<?php echo 'https://'.$_SERVER["SERVER_NAME"]; ?>/pub/img/favicon.svg">
           <link rel="shortcut icon" href="<?php echo 'https://'.$_SERVER["SERVER_NAME"]; ?>/pub/img/favicon.ico">
           <link rel="manifest" href="<?php echo 'https://'.$_SERVER["SERVER_NAME"]; ?>/pub/img/site.webmanifest">
           <meta name="msapplication-TileColor" content="#da532c">
           <meta name="msapplication-config" content="<?php echo 'https://'.$_SERVER["SERVER_NAME"]; ?>/pub/img/browserconfig.xml">
           <meta name="theme-color" content="#ffffff">
       <style>
           <?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/index.css.php'; ?>
       </style>
</head><body>
<?php

if ($PAGE_ID == "" || $PAGE_ID == "0"){
    $PAGE_HEADER = '/pub/section/header0.php';
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
    else {$INDEX_HEADER_HEIGHT='70';}
}

require_once $_SERVER['DOCUMENT_ROOT'] . $PAGE_HEADER;
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';
//echo "<div style='text-align:left;margin:". $INDEX_HEADER_HEIGHT."px 0px 5px 10px;'>"; 
echo "<div style='text-align:left;margin:20px 0px 5px 10px;'>"; 
if ($USER_LANG == "FR"){ echo "Partager sur:<br>"; } else {echo "Share on:<br>";} 
if ($USER_LANG == "FR"){ $pdf_path = "/pub/download/Article_".$data["id"].".pdf"; } else {$pdf_path = "/pub/download/News_".$data["id"].".pdf";} 
echo "\n<img src='/pub/img/dw3/facebook.png' onclick='dw3_share_news_fb()' style='margin:10px;cursor:pointer;width:40px;height:40px;'><img src='/pub/img/dw3/twitter.png' onclick='dw3_share_news_tw()' style='margin:10px;cursor:pointer;width:40px;height:40px;'></div>";
echo "\n<div style='position:fixed;top:100px;right:5px;'><img src='/pub/img/dw3/accsessibility.png' onclick='openACB()' style='cursor:pointer;width:40px;height:40px;'><br><a href='".$pdf_path."' download><img src='/pub/img/dw3/pdf.png' style='cursor:pointer;width:40px;height:40px;margin-top:10px;'></a></div>";
if ($USER_LANG == "FR"){
    echo "<div style='max-width:1200px;display:inline-block;line-height:1.5em;text-align:left;background-color:#fff;color:#444;' id='artMAIN'>
    <i>(Temps de lecture: " . round(str_word_count($data["html_fr"])/130) . " minutes)</i>";
    echo "<h1 style='margin:20px 10px;' id='txtTitle'>".$data["title_fr"]."</h1>";
    echo "<img src='/pub/upload/".$data["img_link"]."' style='width:100%;height:auto;'><br>";
    echo "<div style='display:flex;width:100%;'><span style='width:50%;padding-left:5px;'>Par <b>".$data["author_name"]."</b></span><span style='width:50%;text-align:right;padding-right:5px;'><b>".substr($data["date_created"],0,10)."</b></span></div>";
    echo "<h2 style='text-align:left;margin:20px 5px;' id='txtDesc'>".$data["description_fr"]."</h2>";
    echo "<div id='artHTML' style='padding:0px 10px;'>".$data["html_fr"]."</div>";
    echo "<br><br>";
    echo "<div style='width:100%;text-align:center;margin:30px 0px;'><button onclick=\"window.open('/pub/page/article/index.php?PID=".$PAGE_P1."','_self')\">Retour au sommaire</button></div>";
} else {
    echo "<div style='max-width:1200px;display:inline-block;line-height:1.5em;text-align:left;background-color:#fff;color:#444;' id='artMAIN'>
    <i>(Reading time: " . round(str_word_count($data["html_en"])/130) . " minutes)</i>";
    echo "<h1 style='margin:20px 10px;' id='txtTitle'>".$data["title_en"]."</h1>";
    echo "<img src='/pub/upload/".$data["img_link"]."' style='width:100%;height:auto;'><br>";
    echo "<div style='display:flex;width:100%;'><span style='width:50%;padding-left:5px;'>By <b>".$data["author_name"]."</b></span><span style='width:50%;text-align:right;padding-right:5px;'><b>".substr($data["date_created"],0,10)."</b></span></div>";
    echo "<h2 style='text-align:left;margin:20px 5px;' id='txtDesc'>".$data["description_en"]."</h2>";
    echo "<div id='artHTML' style='padding:0px 10px;'>".$data["html_en"]."</div>";
    echo "<br><br>";
    echo "\n<div style='width:100%;text-align:center;margin:30px 0px;'><button onclick=\"window.open('/pub/page/article/index.php?PID=".$PAGE_P1."','_self')\">Back to summary</button></div>";
}
echo "</div>";

if ($data["allow_comments"]== "1"){
    if ($USER_LANG == "FR"){
        echo "\n<div class='dw3_page'><h3>Commentaires</h3>";
    } else {
        echo "\n<div class='dw3_page'><h3>Comments</h3>";
    }
    if ($KEY != "" && $USER_ID != ""){
        if ($USER_TYPE == "user"){
            $display_name = $USER_NAME;
        } else {
            $display_name = "user_".$USER_ID;
        }
        echo "<table id='article_comment_form' class='tblDATA'><tr><td style='text-align:left;border-radius:0px;border:0px;'>".$display_name."</td><td style='text-align:right;border:0px;border-radius:0px;'>".$today."</td></tr>";
        echo "<tr><td colspan='2' style='text-align:center;border:0px;border-bottom:1px solid lightgrey;'><textarea id='new_comment' rows='4' style='width:98%;padding:10px;resize: none;'></textarea></td></tr></table>";
    }
    echo "<div style='width:100%;text-align:right;'><button id='article_comment_btn' onclick=\"add_article_comment('".$data["id"]."')\" style='margin:15px;'>+ Ajouter un commentaire</button></div>";

    $sql = "SELECT A.*, IFNULL(B.customer_name,'') AS customer_name, IFNULL(C.user_name,'') AS user_name FROM article_comment A
    LEFT JOIN (SELECT id, user_name AS customer_name FROM customer) B ON A.customer_id = B.id
    LEFT JOIN (SELECT id, name AS user_name FROM user) C ON A.user_id = C.id
    WHERE article_id = '" . $data["id"] . "' AND verified = '1'
    ORDER BY date_created DESC;";
    //echo $sql;
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<div style='width:100%;text-align:left;margin-top:20px;'>";
        while($row = $result->fetch_assoc()) {
            $who_commented = "";
            if ($row["customer_id"]!="0"){
                if ($row["customer_name"] != ""){
                    $who_commented = $row["customer_name"];
                } else {
                    $who_commented = "user_".$row["customer_id"];
                }
            } else {
                $who_commented = $row["user_name"];
            }
            echo "\n<table class='tblDATA' id='comment_".$row["id"]."' style='margin:10px 0px;max-width:100%;white-space:wrap;'>";
            if ($USER_TYPE == "user"){
                echo "<tr><td colspan=2 style='border-radius:0px;text-align:right;'><button class='red' onclick=\"remove_article_comment('".$row["id"]."')\"> X </button></td></tr>";
            }
            echo "<tr><td style='text-align:left;border-radius:0px;border:0px;'>".$who_commented."</td><td style='text-align:right;border-radius:0px;border:0px;'>".$row["date_created"]."</td></tr>";
            echo "<tr><td colspan='2' style='border:0px;border-bottom:1px solid lightgrey;'>".$row["comment"]."</td></tr></table>";
        }
        echo "</div>";
    } else {
        echo "<div class='dw3_box' style='margin:50px 0px;text-align:center;'>Aucun commentaire trouvé.</div>";
    }
    echo "</div>";
}
?>

<script>
const curURL = "<?php echo $_SERVER["SERVER_NAME"].'/pub/page/article/article.php';?>";
const curPARM = "<?php echo 'ID='.$data["id"].'&P1='.$PAGE_P1; ?>";
const PAGE_ID = "<?php echo $PAGE_P1; ?>";
const ART_ID = "<?php echo $ID; ?>";
const sTitle = document.getElementById("txtTitle").innerHTML;

/* calculer et updater au serveur le temps de lecture */
let reading_start = new Date();
window.addEventListener('beforeunload', function (e) {
    let reading_end = new Date();
    let diffMilliseconds = reading_end.getTime() - reading_start.getTime();
    let diffMinutes = diffMilliseconds / (1000 * 60);
    let reading_time = Math.abs(Math.round(diffMinutes));
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        //done
    }
    };
    xmlhttp.open('GET', '/sbin/updART_RDA.php?A='+ART_ID+'&M=' + reading_time.toString(), true);
    xmlhttp.send(); 
});


function remove_article_comment(comment_id){
    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("comment_"+comment_id).style.display = "none";
            dw3_notif_add(this.responseText);
        }
        };
        xmlhttp.open('GET', '/sbin/delCOMMENT.php?KEY=' + KEY + '&C=' +comment_id, true);
        xmlhttp.send();
}

function add_article_comment(article_id){
    if (KEY == "" || USER_ID == ""){
        document.getElementById("dw3_body_fade").style.display = "inline-block";
        document.getElementById("dw3_body_fade").style.opacity = "0.5";
        document.getElementById("dw3_msg").style.display = "inline-block";
        document.getElementById("dw3_msg").innerHTML = "<?php if($USER_LANG == "FR"){ echo "Veuillez vous connecter ou vous inscrire pour continuer."; }else{echo "Please connect or subscribe to continue.";} ?><br><button onclick='dw3_msg_close();' style='margin-top:20px;'>Annuler</button> <button onclick='dw3_msg_close();go_to_login();' style='margin-top:20px;'>&#9989;Ok</button>";
        return;
    } else {
        document.getElementById("article_comment_btn").disabled = true;
        var comment = document.getElementById("new_comment").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("article_comment_form").style.display = "none";
            document.getElementById("dw3_body_fade").style.display = "inline-block";
            document.getElementById("dw3_body_fade").style.opacity = "0.5";
            document.getElementById("dw3_msg").style.display = "inline-block";
            document.getElementById("dw3_msg").innerHTML = this.responseText + "<br> <button onclick='dw3_msg_close();' style='margin-top:20px;'>&#9989;Ok</button>";
        }
        };
        xmlhttp.open('GET', 'setCOMMENT.php?KEY=' + KEY + '&A=' +article_id+ '&C='+encodeURIComponent(comment) + "&P="+PAGE_ID, true);
        xmlhttp.send();
    }
}
function openACB(){
    var elemento = document.getElementById('artMAIN');
    var dftFont = window.getComputedStyle(elemento).getPropertyValue('font-family');
    if (USER_LANG == "FR" || USER_LANG == ""){
        var sHTML = "<div class='dw3_form_head' id='dw3_editor_HEAD'>"
        +"<h2 style='vertical-align:middle;height:40px;'><img src='/pub/img/dw3/accsessibility.png' style='width:40px;height:40px;'></h2>"
        +"<button class='white dw3_form_close no-effect' style='background:transparent;' onclick='dw3_editor_close();'>&#10062;</button>"
        +"</div><div class='dw3_form_data' style='background:#EEE;color:#333;'>";
        sHTML += "<div class='dw3_box' style='line-height:1.3;'><h2>Police de caractères</h2>"
        +"<input type='radio' checked name='acb_font' value='"+dftFont+"' id='acb_font_dft'><label for='acb_font_dft' style='font-family:"+dftFont+";'> "+dftFont+" (police par défaut)</label><br>"
        +"<input type='radio' name='acb_font' value='Arial,serif' id='acb_font_arial'><label for='acb_font_arial' style='font-family:Arial,sans-serif;'> Arial</label><br>"
        +"<input type='radio' name='acb_font' value='Brush Script MT,cursive' id='acb_font_brush'><label for='acb_font_brush' style='font-family:Brush Script MT,cursive;'> Brush Script MT</label><br>"
        +"<input type='radio' name='acb_font' value='Courrier New,monospace' id='acb_font_courrier'><label for='acb_font_courrier' style='font-family:Courrier New,monospace;'> Courrier New</label><br>"
        +"<input type='radio' name='acb_font' value='Garamond,serif' id='acb_font_garamond'><label for='acb_font_garamond' style='font-family:Garamond,serif;'> Garamond</label><br>"
        +"<input type='radio' name='acb_font' value='Georgia,serif' id='acb_font_georgia'><label for='acb_font_georgia' style='font-family:Georgia,serif;'> Georgia</label><br>"
        +"<input type='radio' name='acb_font' value='Tahoma,serif' id='acb_font_tahoma'><label for='acb_font_tahoma' style='font-family:Tahoma,sans-serif;'> Tahoma</label><br>"
        +"<input type='radio' name='acb_font' value='Trebuchet MS,serif' id='acb_font_trebuchet'><label for='acb_font_trebuchet' style='font-family:Trebuchet MS,sans-serif;'> Trebuchet MS</label><br>"
        +"<input type='radio' name='acb_font' value='Times New Roman,serif' id='acb_font_times'><label for='acb_font_times' style='font-family:Times New Roman,serif;'> Times New Roman</label><br>"
        +"</div>";
        sHTML += "<div class='dw3_box' style='line-height:1.3;'><h2>Taille des caractères</h2>"
        +"<input type='radio' name='acb_size' value='14px' id='acb_size_14'><label for='acb_size_14' style='font-size:14px;'> Très très petit</label><br>"
        +"<input type='radio' name='acb_size' value='16px' id='acb_size_16'><label for='acb_size_16' style='font-size:16px;'> Très petit</label><br>"
        +"<input type='radio' checked name='acb_size' value='18px' id='acb_size_18'><label for='acb_size_18' style='font-size:18px;'> Petit</label><br>"
        +"<input type='radio' name='acb_size' value='20px' id='acb_size_20'><label for='acb_size_20' style='font-size:20px;'> Moyen</label><br>"
        +"<input type='radio' name='acb_size' value='22px' id='acb_size_22'><label for='acb_size_22' style='font-size:22px;'> Grand</label><br>"
        +"<input type='radio' name='acb_size' value='24px' id='acb_size_24'><label for='acb_size_24' style='font-size:24px;'> Très grand</label><br>"
        +"<input type='radio' name='acb_size' value='26px' id='acb_size_26'><label for='acb_size_26' style='font-size:26px;'> Très très grand</label><br>"
        +"<input type='radio' name='acb_size' value='28px' id='acb_size_28'><label for='acb_size_28' style='font-size:28px;'> Très très très grand</label><br>"
        +"</div><hr>";
        sHTML += "<div class='dw3_box' style='line-height:1.3;'><h2>Couleur de l'arrière plan</h2><table style='width:100%;'><tr><td>"
        +"<input type='radio' name='acb_bg' value='transparent' id='acb_bg_t'><label for='acb_bg_t'> <span  style='vertical-align:middle;background-color:transparent; height:30px;width:125px;border-radius:5px;border:1px solid #777;text-align:center;color:#999;'>Transparent</span></label><br>"
        +"<input type='radio' name='acb_bg' value='#000' id='acb_bg_0'><label for='acb_bg_0'> <span  style='vertical-align:middle;background-color:#000; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#444' id='acb_bg_4'><label for='acb_bg_4'> <span  style='vertical-align:middle;background-color:#444; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#888' id='acb_bg_8'><label for='acb_bg_8'> <span  style='vertical-align:middle;background-color:#888; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#aaa' id='acb_bg_a'><label for='acb_bg_a'> <span  style='vertical-align:middle;background-color:#aaa; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' checked name='acb_bg' value='#fff' id='acb_bg_f'><label for='acb_bg_f'> <span  style='vertical-align:middle;background-color:#fff; height:30px;width:125px;border-radius:5px;border:1px solid #777;'> </span></label><br>"
        +"</td><td><input type='radio' name='acb_bg' value='#F9E1E1' id='acb_bg_u'><label for='acb_bg_u'> <span  style='vertical-align:middle;background-color:#F9E1E1; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#D9D6FF' id='acb_bg_v'><label for='acb_bg_v'> <span  style='vertical-align:middle;background-color:#D9D6FF; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#B7E1B7' id='acb_bg_w'><label for='acb_bg_w'> <span  style='vertical-align:middle;background-color:#B7E1B7; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#FFE4A8' id='acb_bg_x'><label for='acb_bg_x'> <span  style='vertical-align:middle;background-color:#FFE4A8; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#534DA8' id='acb_bg_y'><label for='acb_bg_y'> <span  style='vertical-align:middle;background-color:#534DA8; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#4B1616' id='acb_bg_z'><label for='acb_bg_z'> <span  style='vertical-align:middle;background-color:#4B1616; height:30px;width:125px;border-radius:5px;border:1px solid #777;'> </span></label><br>"
        +"</td></tr></table></div>";
        sHTML += "<div class='dw3_box' style='line-height:1.3;'><h2>Couleur du texte</h2><table style='width:100%;'><tr><td>"
        +"<input type='radio' name='acb_color' value='darkblue' id='acb_color_b'><label for='acb_color_b'> <span  style='vertical-align:middle;background-color:darkblue; color:#ddd;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='#000' id='acb_color_0'><label for='acb_color_0'> <span  style='vertical-align:middle;background-color:#000; color:#ddd;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' checked name='acb_color' value='#444' id='acb_color_4'><label for='acb_color_4'> <span  style='vertical-align:middle;background-color:#444; color:#fff;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='#888' id='acb_color_8'><label for='acb_color_8'> <span  style='vertical-align:middle;background-color:#888; color:#000;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='#aaa' id='acb_color_a'><label for='acb_color_a'> <span  style='vertical-align:middle;background-color:#aaa; color:#222;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='#fff' id='acb_color_f'><label for='acb_color_f'> <span  style='vertical-align:middle;background-color:#fff; color:#444;height:30px;width:125px;border-radius:5px;border:1px solid #777;'> </span></label><br>"
        +"</td><td><input type='radio' name='acb_color' value='darkred' id='acb_color_u'><label for='acb_color_u'> <span  style='vertical-align:middle;background-color:darkred; color:#ddd;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='orange' id='acb_color_v'><label for='acb_color_v'> <span  style='vertical-align:middle;background-color:orange; color:#ddd;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='purple' id='acb_color_w'><label for='acb_color_w'> <span  style='vertical-align:middle;background-color:purple; color:#fff;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='green' id='acb_color_x'><label for='acb_color_x'> <span  style='vertical-align:middle;background-color:green; color:#000;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='darkgreen' id='acb_color_y'><label for='acb_color_y'> <span  style='vertical-align:middle;background-color:darkgreen; color:#222;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='beige' id='acb_color_z'><label for='acb_color_z'> <span  style='vertical-align:middle;background-color:beige; color:#444;height:30px;width:125px;border-radius:5px;border:1px solid #777;'> </span></label><br>"
        +"</td></tr></table></div><hr>";
        sHTML += "<div class='dw3_box' style='line-height:1.3;'><h2>Espacement</h2>"
        +"<input type='radio' style='vertical-align:middle;' name='acb_space' value='1' id='acb_space_1'><label for='acb_space_1'>         <div style='display:inline-block;vertical-align:middle;background-color:#fff; border-top:1px solid #000;border-bottom:1px solid #000;width:285px;height:3px;line-height:1;'> <br> </div></label><br>"
        +"<input type='radio' style='vertical-align:middle;' name='acb_space' value='1.3' id='acb_space_13'><label for='acb_space_13'>     <div style='display:inline-block;vertical-align:middle;background-color:#fff; border-top:1px solid #000;border-bottom:1px solid #000;width:285px;height:5px;line-height:1.3;'> <br> </div></label><br>"
        +"<input type='radio' style='vertical-align:middle;' checked name='acb_space' value='1.5' id='acb_space_15'><label for='acb_space_15'>     <div style='display:inline-block;vertical-align:middle;background-color:#fff; border-top:1px solid #000;border-bottom:1px solid #000;width:285px;height:7px;line-height:1.5;'> <br> </div></label><br>"
        +"<input type='radio' style='vertical-align:middle;' name='acb_space' value='2' id='acb_space_2'><label for='acb_space_2'> <div style='display:inline-block;vertical-align:middle;background-color:#fff; border-top:1px solid #000;border-bottom:1px solid #000;width:285px;height:9px;line-height:2;'> <br> </div></label><br>"
        +"<input type='radio' style='vertical-align:middle;' name='acb_space' value='2.5' id='acb_space_25'><label for='acb_space_25'>     <div style='display:inline-block;vertical-align:middle;background-color:#fff; border-top:1px solid #000;border-bottom:1px solid #000;width:285px;height:11px;line-height:2.5;'> <br> </div></label><br>"
        +"<input type='radio' style='vertical-align:middle;' name='acb_space' value='3' id='acb_space_3'><label for='acb_space_3'>         <div style='display:inline-block;vertical-align:middle;background-color:#fff; border-top:1px solid #000;border-bottom:1px solid #000;width:285px;height:13px;line-height:3;'> <br> </div></label><br>"
        +"</div></div>";
        sHTML += "<div class='dw3_form_foot' style=''><button class='no-effect grey' style='margin:0px 5px 0px 5px;' onclick='resetACB();'><span  style='font-size:24px;vertical-align:middle;'>♺</span> Réinitialiser</button> <button class='no-effect white' style='margin:0px 5px 0px 5px;' onclick='applyACB();'><span  style='font-size:24px;vertical-align:middle;'>&#9989;</span> Appliquer </button></div>";
    } else {
        var sHTML = "<div class='dw3_form_head' id='dw3_editor_HEAD'>"
        +"<h2 style='vertical-align:middle;height:40px;'><img src='/pub/img/dw3/accsessibility.png' style='width:40px;height:40px;'></h2>"
        +"<button class='white dw3_form_close no-effect' style='background:transparent;' onclick='dw3_editor_close();'>&#10062;</button>"
        +"</div><div class='dw3_form_data' style='background:#EEE;color:#333;'>";
        sHTML += "<div class='dw3_box' style='line-height:1.3;'><h2>Font</h2>"
        +"<input type='radio' checked name='acb_font' value='"+dftFont+"' id='acb_font_dft'><label for='acb_font_dft' style='font-family:"+dftFont+";'> "+dftFont+" (default font)</label><br>"
        +"<input type='radio' name='acb_font' value='Arial,serif' id='acb_font_arial'><label for='acb_font_arial' style='font-family:Arial,sans-serif;'> Arial</label><br>"
        +"<input type='radio' name='acb_font' value='Brush Script MT,cursive' id='acb_font_brush'><label for='acb_font_brush' style='font-family:Brush Script MT,cursive;'> Brush Script MT</label><br>"
        +"<input type='radio' name='acb_font' value='Courrier New,monospace' id='acb_font_courrier'><label for='acb_font_courrier' style='font-family:Courrier New,monospace;'> Courrier New</label><br>"
        +"<input type='radio' name='acb_font' value='Garamond,serif' id='acb_font_garamond'><label for='acb_font_garamond' style='font-family:Garamond,serif;'> Garamond</label><br>"
        +"<input type='radio' name='acb_font' value='Georgia,serif' id='acb_font_georgia'><label for='acb_font_georgia' style='font-family:Georgia,serif;'> Georgia</label><br>"
        +"<input type='radio' name='acb_font' value='Tahoma,serif' id='acb_font_tahoma'><label for='acb_font_tahoma' style='font-family:Tahoma,sans-serif;'> Tahoma</label><br>"
        +"<input type='radio' name='acb_font' value='Trebuchet MS,serif' id='acb_font_trebuchet'><label for='acb_font_trebuchet' style='font-family:Trebuchet MS,sans-serif;'> Trebuchet MS</label><br>"
        +"<input type='radio' name='acb_font' value='Times New Roman,serif' id='acb_font_times'><label for='acb_font_times' style='font-family:Times New Roman,serif;'> Times New Roman</label><br>"
        +"</div>";
        sHTML += "<div class='dw3_box' style='line-height:1.3;'><h2>Font Size</h2>"
        +"<input type='radio' name='acb_size' value='14px' id='acb_size_14'><label for='acb_size_14' style='font-size:14px;'> Very Very Small</label><br>"
        +"<input type='radio' name='acb_size' value='16px' id='acb_size_16'><label for='acb_size_16' style='font-size:16px;'> Very Small</label><br>"
        +"<input type='radio' checked name='acb_size' value='18px' id='acb_size_18'><label for='acb_size_18' style='font-size:18px;'> Small</label><br>"
        +"<input type='radio' name='acb_size' value='20px' id='acb_size_20'><label for='acb_size_20' style='font-size:20px;'> Medium</label><br>"
        +"<input type='radio' name='acb_size' value='22px' id='acb_size_22'><label for='acb_size_22' style='font-size:22px;'> Large</label><br>"
        +"<input type='radio' name='acb_size' value='24px' id='acb_size_24'><label for='acb_size_24' style='font-size:24px;'> Very Large</label><br>"
        +"<input type='radio' name='acb_size' value='26px' id='acb_size_26'><label for='acb_size_26' style='font-size:26px;'> Very Very Large</label><br>"
        +"<input type='radio' name='acb_size' value='28px' id='acb_size_28'><label for='acb_size_28' style='font-size:28px;'> Very Very Very Large</label><br>"
        +"</div><hr>";
        sHTML += "<div class='dw3_box' style='line-height:1.3;'><h2>Background Color</h2><table style='width:100%;'><tr><td>"
        +"<input type='radio' name='acb_bg' value='transparent' id='acb_bg_t'><label for='acb_bg_t'> <span  style='vertical-align:middle;background-color:transparent; height:30px;width:125px;border-radius:5px;border:1px solid #777;text-align:center;color:#999;'>Transparent</span></label><br>"
        +"<input type='radio' name='acb_bg' value='#000' id='acb_bg_0'><label for='acb_bg_0'> <span  style='vertical-align:middle;background-color:#000; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#444' id='acb_bg_4'><label for='acb_bg_4'> <span  style='vertical-align:middle;background-color:#444; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#888' id='acb_bg_8'><label for='acb_bg_8'> <span  style='vertical-align:middle;background-color:#888; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#aaa' id='acb_bg_a'><label for='acb_bg_a'> <span  style='vertical-align:middle;background-color:#aaa; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' checked name='acb_bg' value='#fff' id='acb_bg_f'><label for='acb_bg_f'> <span  style='vertical-align:middle;background-color:#fff; height:30px;width:125px;border-radius:5px;border:1px solid #777;'> </span></label><br>"
        +"</td><td><input type='radio' name='acb_bg' value='#F9E1E1' id='acb_bg_u'><label for='acb_bg_u'> <span  style='vertical-align:middle;background-color:#F9E1E1; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#D9D6FF' id='acb_bg_v'><label for='acb_bg_v'> <span  style='vertical-align:middle;background-color:#D9D6FF; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#B7E1B7' id='acb_bg_w'><label for='acb_bg_w'> <span  style='vertical-align:middle;background-color:#B7E1B7; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#FFE4A8' id='acb_bg_x'><label for='acb_bg_x'> <span  style='vertical-align:middle;background-color:#FFE4A8; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#534DA8' id='acb_bg_y'><label for='acb_bg_y'> <span  style='vertical-align:middle;background-color:#534DA8; height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_bg' value='#4B1616' id='acb_bg_z'><label for='acb_bg_z'> <span  style='vertical-align:middle;background-color:#4B1616; height:30px;width:125px;border-radius:5px;border:1px solid #777;'> </span></label><br>"
        +"</td></tr></table></div>";
        sHTML += "<div class='dw3_box' style='line-height:1.3;'><h2>Text Color</h2><table style='width:100%;'><tr><td>"
        +"<input type='radio' name='acb_color' value='darkblue' id='acb_color_b'><label for='acb_color_b'> <span  style='vertical-align:middle;background-color:darkblue; color:#ddd;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='#000' id='acb_color_0'><label for='acb_color_0'> <span  style='vertical-align:middle;background-color:#000; color:#ddd;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' checked name='acb_color' value='#444' id='acb_color_4'><label for='acb_color_4'> <span  style='vertical-align:middle;background-color:#444; color:#fff;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='#888' id='acb_color_8'><label for='acb_color_8'> <span  style='vertical-align:middle;background-color:#888; color:#000;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='#aaa' id='acb_color_a'><label for='acb_color_a'> <span  style='vertical-align:middle;background-color:#aaa; color:#222;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='#fff' id='acb_color_f'><label for='acb_color_f'> <span  style='vertical-align:middle;background-color:#fff; color:#444;height:30px;width:125px;border-radius:5px;border:1px solid #777;'> </span></label><br>"
        +"</td><td><input type='radio' name='acb_color' value='darkred' id='acb_color_u'><label for='acb_color_u'> <span  style='vertical-align:middle;background-color:darkred; color:#ddd;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='orange' id='acb_color_v'><label for='acb_color_v'> <span  style='vertical-align:middle;background-color:orange; color:#ddd;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='purple' id='acb_color_w'><label for='acb_color_w'> <span  style='vertical-align:middle;background-color:purple; color:#fff;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='green' id='acb_color_x'><label for='acb_color_8x> <span  style='vertical-align:middle;background-color:green; color:#000;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='darkgreen' id='acb_color_y'><label for='acb_color_y'> <span  style='vertical-align:middle;background-color:darkgreen; color:#222;height:30px;width:125px;border-radius:5px;'> </span></label><br>"
        +"<input type='radio' name='acb_color' value='beige' id='acb_color_z'><label for='acb_color_z'> <span  style='vertical-align:middle;background-color:beige; color:#444;height:30px;width:125px;border-radius:5px;border:1px solid #777;'> </span></label><br>"
        +"</td></tr></table></div><hr>";
        sHTML += "<div class='dw3_box' style='line-height:1.3;'><h2>Spacing</h2>"
        +"<input type='radio' style='vertical-align:middle;' name='acb_space' value='1' id='acb_space_1'><label for='acb_space_1'>         <div style='display:inline-block;vertical-align:middle;background-color:#fff; border-top:1px solid #000;border-bottom:1px solid #000;width:285px;height:3px;line-height:1;'> <br> </div></label><br>"
        +"<input type='radio' style='vertical-align:middle;' name='acb_space' value='1.3' id='acb_space_13'><label for='acb_space_13'>     <div style='display:inline-block;vertical-align:middle;background-color:#fff; border-top:1px solid #000;border-bottom:1px solid #000;width:285px;height:5px;line-height:1.3;'> <br> </div></label><br>"
        +"<input type='radio' style='vertical-align:middle;' checked name='acb_space' value='1.5' id='acb_space_15'><label for='acb_space_15'>     <div style='display:inline-block;vertical-align:middle;background-color:#fff; border-top:1px solid #000;border-bottom:1px solid #000;width:285px;height:7px;line-height:1.5;'> <br> </div></label><br>"
        +"<input type='radio' style='vertical-align:middle;' name='acb_space' value='2' id='acb_space_2'><label for='acb_space_2'> <div style='display:inline-block;vertical-align:middle;background-color:#fff; border-top:1px solid #000;border-bottom:1px solid #000;width:285px;height:9px;line-height:2;'> <br> </div></label><br>"
        +"<input type='radio' style='vertical-align:middle;' name='acb_space' value='2.5' id='acb_space_25'><label for='acb_space_25'>     <div style='display:inline-block;vertical-align:middle;background-color:#fff; border-top:1px solid #000;border-bottom:1px solid #000;width:285px;height:11px;line-height:2.5;'> <br> </div></label><br>"
        +"<input type='radio' style='vertical-align:middle;' name='acb_space' value='3' id='acb_space_3'><label for='acb_space_3'>         <div style='display:inline-block;vertical-align:middle;background-color:#fff; border-top:1px solid #000;border-bottom:1px solid #000;width:285px;height:13px;line-height:3;'> <br> </div></label><br>"
        +"</div></div>";
        sHTML += "<div class='dw3_form_foot' style=''><button class='no-effect grey' style='margin:0px 5px 0px 5px;' onclick='resetACB();'><span  style='font-size:24px;vertical-align:middle;'>♺</span> Reset</button> <button class='no-effect white' style='margin:0px 5px 0px 5px;' onclick='applyACB();'><span  style='font-size:24px;vertical-align:middle;'>&#9989;</span> Apply </button></div>";

    }
    if (document.getElementById("dw3_editor").innerHTML == ""){
        document.getElementById("dw3_editor").innerHTML = sHTML;
    }
    dw3_editor_open();
    dw3_drag_init(document.getElementById('dw3_editor'));
}

function resetACB() {
    document.getElementById('acb_font_dft').checked = true;
    document.getElementById('acb_size_18').checked = true;
    document.getElementById('acb_bg_f').checked = true;
    document.getElementById('acb_color_4').checked = true;
    document.getElementById('acb_space_15').checked = true;
}
function applyACB() {
    var acb_font = document.querySelector('input[name="acb_font"]:checked').value;
    var acb_size = document.querySelector('input[name="acb_size"]:checked').value;
    var acb_bg = document.querySelector('input[name="acb_bg"]:checked').value;
    var acb_color = document.querySelector('input[name="acb_color"]:checked').value;
    var acb_space = document.querySelector('input[name="acb_space"]:checked').value;
    document.getElementById("artHTML").style.fontFamily = acb_font;
    document.getElementById("artHTML").style.fontSize = acb_size;
    document.getElementById("artHTML").style.lineHeight = acb_space;
    document.getElementById("artMAIN").style.backgroundColor = acb_bg;
    document.getElementById("artMAIN").style.color = acb_color;
    dw3_editor_close();
}
function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function go_to_login(){
    window.open('/client','_self');
}
function dw3_share_news_fb(artID){
    var url = "https://www.facebook.com/sharer/sharer.php?t="+encodeURIComponent(sTitle) + "&u=https://"+curURL+"?"+curPARM;
    window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
    return false;
}

function dw3_share_news_tw(){
    var url = 'https://twitter.com/intent/tweet?via=getboldify&text='+encodeURIComponent(sTitle)+'&url=https://'+curURL+'?'+curPARM;
    TwitterWindow = window.open(url, 'TwitterWindow',width=600,height=300);
    return false;
 }

</script>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_FOOTER;
exit; 
?>
<!-- <script type="application/ld+json">{ "@context": "https://schema.org", "@type": "Article", "headline": "How to Use Meta Tags in HTML for SEO" }</script>
<script type="application/ld+json">{ "@context": "https://schema.org", "@type": "Article", "headline": "How to Use Meta Tags in HTML for SEO", "image": "https://example.com/image.jpg", "author": { "@type": "Person", "name": "John Doe" }, "publisher": { "@type": "Organization", "name": "Example", "logo": { "@type": "ImageObject", "url": "https://example.com/logo.png" } }, "datePublished": "2024-05-16", "dateModified": "2024-05-16"}</script>
facebook open graph tag
<meta property="og:title" content="Understanding Meta Tags in HTML for SEO"><meta property="og:description" content="Learn how to optimize meta tags HTML for better SEO and social media engagement."><meta property="og:image" content="https://example.com/image.jpg"><meta property="og:url" content="https://example.com/meta-tags">

twitter cards
<meta name="twitter:card" content="summary_large_image"><meta name="twitter:title" content="Guide to Meta Tags in HTML for SEO"><meta name="twitter:description" content="Explore the best practices for optimizing meta tags for SEO and social media."><meta name="twitter:image" content="https://example.com/twitter-image.jpg">

page timezone_transitions_get
<meta http-equiv="page-enter" content="revealtrans(duration=seconds,transition=num)" />
<meta http-equiv="page-enter" content="blendTrans(duration=sec)" />
<meta http-equiv="page-exit" content="revealtrans(duration=seconds,transition=num)" /> -->
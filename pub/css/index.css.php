<?php
if (!isset($CIE_COLOR5)){$CIE_COLOR5='FFF';}
if (!isset($CIE_COLOR0)){$CIE_COLOR0='333';}
?>
/*
+---------------------------------------------------------------------------------+
| DW3 Platform BETA                                                               |
| Version 5                                                                       |
|                                                                                 | 
|  The MIT License                                                                |
|  Copyright © 2025 Design Web 3D                                                 | 
|                                                                                 |
|  Permission is hereby granted, free of charge, to any person obtaining a copy   |
|   of this software and associated documentation files (the "Software"), to deal |
|   in the Software without restriction, including without limitation the rights  |
|   to use, copy, modify, merge, publish, distribute, sublicense, and/or sell     |
|   copies of the Software, and to permit persons to whom the Software is         |
|   furnished to do so, subject to the following conditions:                      | 
|                                                                                 |
|   The above copyright notice and this permission notice shall be included in    | 
|   all copies or substantial portions of the Software.                           |
|                                                                                 | 
|   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR    |
|   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,      |
|   FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE   | 
|   AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER        |
|   LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, | 
|   OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN     |
|   THE SOFTWARE.                                                                 |
|                                                                                 |
+---------------------------------------------------------------------------------+
| Author: Julien Béliveau <info@dw3.ca>                                           |
+---------------------------------------------------------------------------------+
+---------------------------------------------------+
| RESPONSIVE AREA                                   |
+---------------------------------------------------+*/
@media screen and (min-width: 200px) {
    body {--dw3_body_fontsize:  16px;}
    .dw3_high_view_menu {display:none;height:0px;max-height:0px;}
    .dw3_wide_view_menu {display:none;width:0px;max-width:0px;}
    .dw3_wide_view_div {width:100%;max-width:100%;min-width:200px;display:inline-block;vertical-align:top;}
    .dw3_wide_view_parent {display:inline-block;}
    .dw3_third_view_div {width:100%;max-width:100%;min-width:200px;display:inline-block;}
    .dw3_flex_horizon {flex-direction: column;}
    #dw3_small_view_menu {display:table-cell;width:40px;max-width:40px;}
    #header3_img {width:50%;}
    #dw3_menu button {font-size:0.9em;}
}
@media screen and (min-width: 300px) {
    body {--dw3_body_fontsize:  16px;}
    .dw3_high_view_menu {display:none;height:0px;max-height:0px;}
    .dw3_wide_view_menu {display:none;width:0px;max-width:0px;}
    .dw3_wide_view_div {width:100%;max-width:100%;min-width:300px;display:inline-block;vertical-align:top;}
    .dw3_wide_view_parent {display:inline-block;}
    .dw3_third_view_div {width:100%;max-width:100%;min-width:300px;display:inline-block;}
    .dw3_flex_horizon {flex-direction: column;}
    #dw3_small_view_menu {display:table-cell;width:40px;max-width:40px;}
    #header3_img {width:80%;}
    #dw3_menu button {font-size:1em;}
}
@media screen and (min-width: 640px) {
    body {--dw3_body_fontsize:  16px;}
    .dw3_high_view_menu {display:none;height:0px;max-height:0px;}
    .dw3_wide_view_menu {display:none;width:0px;max-width:0px;}
    .dw3_wide_view_div {width:100%;max-width:100%;min-width:300px;display:inline-block;vertical-align:top;}
    .dw3_wide_view_parent {display:inline-block;}
    .dw3_third_view_div {width:100%;max-width:100%;min-width:300px;display:inline-block;}
    .dw3_flex_horizon {flex-direction: row;}
    #dw3_small_view_menu {display:table-cell;width:40px;max-width:40px;}
    #header3_img {width:80%;}
    #dw3_menu button {font-size:1.1em;}
}

@media only screen and (max-width: 700px){
    .gal2_modal-content {width: 100%;}
}

@media screen and (min-width: 1080px) {
    body {--dw3_body_fontsize:  16px;}
    .dw3_high_view_menu {display:table-row;height:auto;max-height:none;}
    .dw3_wide_view_menu {display:table-cell;width:auto;max-width:none;}
    .dw3_wide_view_div {width:50%;max-width:50%;min-width:300px;display:inline-block;vertical-align:top;}
    .dw3_wide_view_parent {display: flex;}
    .dw3_third_view_div {width:33%;max-width:33%;min-width:300px;display:inline-block;}
    .dw3_flex_horizon {flex-direction: row;}
    #dw3_small_view_menu {display:none;width:0px;max-width:0px;}
    #header3_img {width:20%;}
    #dw3_menu button {font-size:1em;}
}
@media screen and (min-width: 1680px) {
    body {--dw3_body_fontsize:  18px;}
    .dw3_high_view_menu {display:table-row;height:auto;max-height:none;}
    .dw3_wide_view_menu {display:table-cell;width:auto;max-width:none;}
    .dw3_wide_view_div {width:50%;max-width:50%;min-width:300px;display:inline-block;vertical-align:top;}
    .dw3_wide_view_parent {display: flex;}
    .dw3_third_view_div {width:33%;max-width:33%;min-width:300px;display:inline-block;}
    .dw3_flex_horizon {flex-direction: row;}
    #dw3_small_view_menu {display:none;width:0px;max-width:0px;}
    #header3_img {width:20%;}
    #dw3_menu button {font-size:0.8em;}
}
@media screen and (min-width: 2060px) {
    body {--dw3_body_fontsize:  22px;}
    .dw3_high_view_menu {display:table-row;height:auto;max-height:none;}
    .dw3_wide_view_menu {display:table-cell;width:auto;max-width:none;}
    .dw3_wide_view_div {width:50%;max-width:50%;min-width:300px;display:inline-block;vertical-align:top;}
    .dw3_wide_view_parent {display: flex;}
    .dw3_third_view_div {width:33%;max-width:33%;min-width:300px;display:inline-block;}
    .dw3_flex_horizon {flex-direction: row;}
    #dw3_small_view_menu {display:none;width:0px;max-width:0px;}
    #header3_img {width:10%;}
    #dw3_menu button {font-size:0.7em;}
}
@media screen and (min-width: 3120px) {
    body {--dw3_body_fontsize:  26px;}
    .dw3_high_view_menu {display:table-row;height:auto;max-height:none;}
    .dw3_wide_view_menu {display:table-cell;width:auto;max-width:none;}
    .dw3_wide_view_div {width:50%;max-width:50%;min-width:300px;display:inline-block;vertical-align:top;}
    .dw3_wide_view_parent {display: flex;}
    .dw3_third_view_div {width:33%;max-width:33%;min-width:300px;display:inline-block;}
    .dw3_flex_horizon {flex-direction: row;}
    #dw3_small_view_menu {display:none;width:0px;max-width:0px;}
    #header3_img {width:10%;}
    #dw3_menu button {font-size:0.6em;}
}
/*+---------------------------------------------------+ 
  | GLOBAL CSS VARIABLES                              |
  +---------------------------------------------------+*/
:root {
    --dw3_selected_border: #<?php echo $CIE_COLOR0_1??'004ff8'; ?>;
    --dw3_menu_font:  <?php echo $CIE_FONT2??'Roboto'; ?>;
    --dw3_body_font:  <?php echo $CIE_FONT1??'Roboto'; ?>;
    --dw3_body_fontsize: 16px;
    --dw3_body_background: <?php  if (isset($PAGE_BG)) {  if ($PAGE_BG != ""){ echo $PAGE_BG; } else { echo '#'.$CIE_COLOR5??'EEE';}} else { echo '#'.$CIE_COLOR5??'EEE';} ?>;
    --dw3_body_color:  #<?php echo $CIE_COLOR4??'555'; ?>;
    --dw3_menu_background: #<?php echo $CIE_COLOR8??'FFF'; ?>;
    --dw3_menu_background2: #<?php echo $CIE_COLOR8_2??'FFF'; ?>;
    --dw3_menu_color: #<?php echo $CIE_COLOR9??'333'; ?>;
    --dw3_head_background: #<?php echo $CIE_COLOR6??'EEE'; ?>;
    --dw3_head_background2: #<?php echo $CIE_COLOR6_2??'EEE'; ?>;
    --dw3_head_color: #<?php echo $CIE_COLOR7??'555'; ?>;
    --dw3_line_background: #<?php echo $CIE_COLOR7_2??'FFF'; ?>;
    --dw3_line_background2: #<?php echo $CIE_COLOR7_3??'CCC'; ?>;
    --dw3_line_color: #<?php echo $CIE_COLOR7_4??'CCC'; ?>;
    --dw3_form_background: #<?php echo $CIE_COLOR3??'EEE'; ?>;
    --dw3_form_color: #<?php echo $CIE_COLOR4??'555'; ?>;
    --dw3_form_font: <?php echo $CIE_FONT3??'Roboto'; ?>;
    --dw3_form_radius: <?php echo $CIE_FORM_RADIUS??'15px'; ?>;
    --dw3_button_background: #<?php echo $CIE_COLOR1??'EEE'; ?>;
    --dw3_button_background2: #<?php echo $CIE_COLOR1_2??'EEE'; ?>;
    --dw3_button_background3: #<?php echo $CIE_COLOR1_3??'EEE'; ?>;
    --dw3_button_color: #<?php echo $CIE_COLOR2??'555'; ?>;
    --dw3_button_border: #<?php echo $CIE_COLOR2??'transparent'; ?>;
    --dw3_button_font: <?php echo $CIE_FONT4??'Roboto'; ?>;
    --dw3_button_fontsize: 16px;
    --dw3_button_radius: <?php echo $CIE_BTN_RADIUS??'3px'; ?>;
    --dw3_button_shadow: <?php echo $CIE_BTN_SHADOW??'inset 1px 1px 5px #fff'; ?>;
    --dw3_button_border: <?php echo $CIE_BTN_BORDER??'0px'; ?>;
    --dw3_msg_color: #<?php echo $CIE_COLOR10??'666'; ?>;
    --dw3_foot_background1: #<?php echo $CIE_COLOR11_1??'FFF'; ?>;
    --dw3_foot_background2: #<?php echo $CIE_COLOR11_2??'EEE'; ?>;
    --dw3_foot_color: #<?php echo $CIE_COLOR11_3??'444'; ?>;

/*     --md-sys-color-primary: #<?php echo $CIE_COLOR2??'555'; ?>;
    --md-sys-color-on-primary: #<?php echo $CIE_COLOR1??'EEE'; ?>;
    --md-sys-color-primary-container: #<?php echo $CIE_COLOR4??'555'; ?>;
    --md-sys-color-on-primary-container: #<?php echo $CIE_COLOR3??'EEE'; ?>; */

  }      

/*+---------------------------------------------------+ 
  | FONTS DIR SCAN + Google Materials                 |
  +---------------------------------------------------+*/
    <?php
        $dir = new RecursiveDirectoryIterator($_SERVER['DOCUMENT_ROOT'] . '/pub/font');
        $files = new RecursiveIteratorIterator($dir);
        foreach($files as $file){
            $fn=basename($file->getFileName(), ".ttf");
            if ($fn!="." && $fn!=".."){
                if ($fn == "Courrier New"){
                    echo "  @font-face {font-family:" . $fn .", monospace ;}" . PHP_EOL;
                } else if ($fn == "Garamond" || $fn == "Georgia" || $fn == "Times New Roman"){
                    echo "  @font-face {font-family:" . $fn .", serif ;}" . PHP_EOL;
                } else if ($fn == "Arial" || $fn == "Verdana" || $fn == "Tahoma" || $fn == "Trebuchet MS"){
                    echo "  @font-face {font-family:" . $fn .", sans-serif ;}" . PHP_EOL;
                } else if ($fn == "Brush Script MT"){
                    echo "  @font-face {font-family:" . $fn .", cursive ;}" . PHP_EOL;
                } else {
                    echo "  @font-face {font-family:" . $fn .";src: url(/pub/font/".$fn.".ttf);}" . PHP_EOL;
                }
            }
        }
    ?>
    
/*+---------------------------------------------------+ 
  | GENERAL CSS BY TAG                                |
  +---------------------------------------------------+*/
    *{margin:0;padding:0;}
    html { 
        max-width: 100%;
        overflow-x: hidden;
        font-size: var(--dw3_body_fontsize);
        line-height: 1;
    }
    body {
/*         background-image: url("/pub/<?php if (isset($PAGE_ID) && isset($CIE_BG1) && isset($PAGE_URL)){ 
                                                if ($PAGE_ID != '' && $PAGE_URL!='/' && $PAGE_URL!='' || $PAGE_URL=='/pub/page/profil/index.php') {
                                                    echo 'upload/';
                                                } else{
                                                    echo 'img/';
                                                } 
                                                /* echo $CIE_BG1??'404.jpg'; */
                                             }else{
                                                /* echo 'img/404.jpg'; */
                                             } ?>");
        background-color: var(--dw3_body_background);
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover; */
        top: 0px !important;
        left: 0px !important;
        width: 100% !important;
        max-width: 100% !important;
        min-height: 100vh;
        margin: 0px 0px 0px 0px;
        font-size: var(--dw3_body_fontsize);
        line-height: 0.6;
        text-align:center;
        overflow-x:clip;
        padding:0px 0px 0px 0px;
        font-family:  var(--dw3_body_font);
        touch-action: pan-x pan-y;
    }
    body:before{
        position:fixed;
        top:0;
        left:0;
        content:'';
        height:100%;
        width:100%;
        background-image:url("/pub/<?php if (isset($PAGE_ID) && isset($CIE_BG1) && isset($PAGE_URL)){ if ($PAGE_ID != '' && $PAGE_URL!='/' && $PAGE_URL!='' || $PAGE_URL=='/pub/page/profil/index.php') {echo 'upload/';} else{echo 'img/';} if ($CIE_BG1 !='') { echo $CIE_BG1;} else {echo 'just_transparent.png';}} else{/* echo 'img/404.jpg'; */} ?>");
        background-position: center center;
        background-repeat: no-repeat;
        background-color: var(--dw3_body_background);
        background-size:cover;
        z-index:-1;
    }

    /* @supports (-webkit-touch-callout: none) { 	body { 		background-attachment: scroll, fixed;background-size: auto auto;background-position:top; 	} } */
    ul { vertical-align: middle; margin-left:20px; }
    /* br {content:"";display: block; margin:0px 0px 0px 0px; line-height:0; font-size:0px;height:0;max-height:0;overflow:hidden;} */
    .br_tiny {margin:0px;line-height:0px; }
    .br_small {margin:1px 0px 1px 0px;line-height:1px; }
    .br_medium {margin:3px 0px 3px 0px; }
    span{display:inline-block;vertical-align:middle!important;}
    img{vertical-align:middle!important;}
    a:link {text-decoration: none; color:inherit;}
    a:visited {text-decoration: none; color:inherit;}
    a.hovera:hover {text-decoration-line: underline;text-decoration-thickness: 2px;text-decoration-color: var(--dw3_selected_border);text-decoration-skip-ink: none;text-underline-offset: 4px;}    
    a:active {text-decoration: none;}
    a[href^=tel] {text-decoration:inherit; color: inherit; }
    h1 {text-align:center;line-height: 1;}
    h2 {text-align:center;line-height: 1;}
    h3 {text-align:center;line-height: 1;} 
    h4 {text-align:left;line-height: 1;}
    hr {
        margin: 10px 0;
        height: 1px;
        border: none;
        background: -webkit-gradient(linear, 0 0, 100% 0, from(transparent), to(transparent), color-stop(50%, black));
    }
    hr.colored {
        margin: 10px 0;
        height: 1px;
        border: none;
        background: -webkit-gradient(linear, 0 0, 100% 0, from(transparent), to(transparent), color-stop(50%, var(--dw3_selected_border)));
    }
    ::-webkit-scrollbar {
        width: 12px;
        /*--border-top-right-radius:7px;
        border-bottom-right-radius:7px;-- */
        background:  var(--dw3_menu_background);
    }
    ::-webkit-scrollbar-track {
        /*--border-bottom-right-radius:7px;border-top-right-radius:7px;-- */
        /* -webkit-box-shadow: inset 0 0 2px  var(--dw3_menu_color); */
        background: var(--dw3_menu_background);
        
    }
    ::-webkit-scrollbar-thumb {
        /* -webkit-box-shadow: inset 0 0 1px  var(--dw3_menu_background); */
        background: var(--dw3_menu_color);
        border-bottom-right-radius:6px;
        border-bottom-left-radius:6px;
        cursor:pointer;
        /* border-radius:5px; */
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    label {
        cursor:pointer;
    }
    button {
        display:inline-block;
        position:relative;
        background-color:  var(--dw3_button_background1);
        background-image: linear-gradient(to bottom right, var(--dw3_button_background) , var(--dw3_button_background2) , var(--dw3_button_background3));
        color:   var(--dw3_button_color);
        border-radius: var(--dw3_button_radius);
        padding: 0.5rem;
        margin:3px;
        cursor:pointer;
        border: var(--dw3_button_border);
        vertical-align:middle;
        box-shadow: var(--dw3_button_shadow);
        /* font-weight:bold; */
        font-family: var(--dw3_button_font);
        transition: all 0.5s linear;
        line-height: 1;
        font-size:0.7em;
    }
    button:after{
        content:'►';
        font-size:10px;
        color:var(--dw3_button_color);
        position:absolute;
        top:38%;
        right:-5px;
        opacity:0;
        transition: all 0.5s linear;
    }
    button:hover {
        background-color:  var(--dw3_button_color);
        background-image: linear-gradient(to bottom right, var(--dw3_button_color) , var(--dw3_button_color) , var(--dw3_button_color));
        box-shadow:inset 0px 0px 2px 1px var(--dw3_button_background2);
        color: var(--dw3_button_background2);
    }
    button:hover:after {
        opacity: 1;
        right: 0px;
        color:var(--dw3_button_background);
        transition:all 0.5s linear;
    }
    .no-effect:hover:after {
        opacity: 0;
        right: -5px;
    }

    button.blue {  background-image: linear-gradient(to bottom right, #2E83CE , #1E73BE, #2E83CE); color: white; border: 0px;transition:all 0.5s linear;}
    button.blue:hover { box-shadow:inset 0px 0px 2px 1px #1E73BE; background-image: linear-gradient(to bottom right, white , white, #EEE); color: #1E73BE;transition:all 0.5s linear;}
    button.green {  background-image: linear-gradient(to bottom right, #4C9917 , #008000, #4C9917); color: white; border: 0px;transition:all 0.5s linear;}
    button.green:hover { box-shadow:inset 0px 0px 2px 1px #008000; background-image: linear-gradient(to bottom right, white , white, #EEE); color: #008000;transition:all 0.5s linear;}
    button.red {  background-image: linear-gradient(to bottom right, rgb(128, 19, 0) ,rgb(114, 6, 2), rgb(128, 19, 0)); color: white; border: 0px; transition:all 0.5s linear;}
    button.red:hover { box-shadow:inset 0px 0px 2px 1px rgb(114, 6, 2); background-image: linear-gradient(to bottom right, white , white, #EEE); color: rgb(114, 6, 2);transition:all 0.5s linear;}
    button.orange {  background-image: linear-gradient(to bottom right, rgb(246, 123, 0) ,rgb(246, 123, 0), rgb(246, 123, 0)); color: white; border: 0px; transition:all 0.5s linear;}
    button.orange:hover { box-shadow:inset 0px 0px 2px 1px rgb(246, 123, 0); background-image: linear-gradient(to bottom right, white , white, #EEE); color: rgb(246, 123, 0);transition:all 0.5s linear;}
    button.white { background-image: linear-gradient(to bottom right, rgb(222, 222, 222) ,rgb(255, 255, 255), rgb(222, 222, 222)); color: #444;transition:all 0.5s linear;}
    button.white:hover { box-shadow:inset 0px 0px 2px 1px white; background-image: linear-gradient(to bottom right, #444 , #444, #333);color: #eee;transition:all 0.5s linear;}
    button.grey {  background-image: linear-gradient(to bottom right, rgb(77, 77, 77) ,rgb(77, 77, 77), rgb(66, 66, 66)); color: white;transition:all 0.5s linear;}
    button.grey:hover { box-shadow:inset 0px 0px 2px 1px #333; background-image: linear-gradient(to bottom right, white , white, #EEE); color: #333;transition:all 0.5s linear;}
    button.gold {  background-image: linear-gradient(to bottom right, rgb(255,215,0) ,rgb(255,215,0), rgb(233,205,0)); color: #333;transition:all 0.5s linear;}
    button.gold:hover { box-shadow:inset 0px 0px 2px 1pxgold; background-image: linear-gradient(to bottom right, #333 , #333, #222); color: gold;transition:all 0.5s linear;}
    button.clear1 {  background-image: linear-gradient(to bottom right, rgb(0,0,0,0.5) ,rgb(0,0,0,0.6), rgb(0,0,0,0.5)); color: #eee;transition:all 0.5s linear;}
    button.clear1:hover { box-shadow:inset 0px 0px 2px 1px#eee; background-image: linear-gradient(to bottom right, #eee , #eee, #eee);color: #333;transition:all 0.5s linear;}
    button.clear2 {background-image: linear-gradient(to bottom right, rgb(255,255,255,0.5) ,rgb(255,255,255,0.6), rgb(255,255,255,0.5));color: #333;transition:all 0.5s linear;}
    button.clear2:hover {box-shadow:inset 0px 0px 2px 1px#333;background-image: linear-gradient(to bottom right, #333 , #333, #222);color: #eee;transition:all 0.5s linear;}

/* link animation */

    a.hover-style-1:hover {
        background-color: grey;
        color:white;
    }
    a.hover-style-1 {
        background-color: white;
        border:1px solid grey;
        color:grey;
        transition:all 0.5s linear;
        padding:15px;
        cursor:pointer;
    }
    a.hover-style-2:hover {
        background-color: #ffffff;
        color:grey;
    }
    a.hover-style-2 {
        background-color: transparent;
        border:1px solid #ffffff;
        color:white;
        transition:all 0.5s linear;
        padding:15px;
        cursor:pointer;
    }
    a.hover-style-3:hover {
        background-color: #ffffff;
        color: #1E73BE;
        border:1px solid #1E73BE;
    }
    a.hover-style-3 {
        background-color: #1E73BE;
        border:1px solid #1E73BE;
        color:white;
        transition:all 0.5s linear;
        border-radius:4px;
        padding:15px;
        cursor:pointer;
    }
    a.hover-style-4:hover {
        background-color: #000;
        color: var(--dw3_selected_border);
        border:1px solid var(--dw3_selected_border);
    }
    a.hover-style-4 {
        background-color: var(--dw3_selected_border);
        border:1px solid var(--dw3_selected_border);
        color: #000;
        transition:all 0.5s linear;
        border-radius:4px;
        padding:15px;
        cursor:pointer;
    }
    a.hover-style-5:hover {
        background-color: #000;
        border:1px solid var(--dw3_selected_border);
    }
    a.hover-style-5 {
        background-color: #FFF;
        border:1px solid #000;
        transition:all 0.5s linear;
        border-radius:4px;
        padding:15px;
        cursor:pointer;
    }
    a.hover-style-6:hover {
        background-color: rgba(72, 160, 50, 0.8);
    }
    a.hover-style-6 {
        background-color: rgba(92, 186, 60, 0.8);
        transition:all 0.5s linear;
        border-radius:24px;
        padding:22px;
        cursor:pointer;
        color: white;
    }
    a.hover-style-7:hover {
        background-color: white;
        color:#333;
    }
    a.hover-style-7 {
        background-color: transparent;
        transition:all 0.5s linear;
        border-radius:24px;
        padding:22px;
        cursor:pointer;
        color: white;
        border:1px solid white;
    }
    a.hover-style-8:hover {
        background-color: #000;
        color:#fff;
    }
    a.hover-style-8 {
        background-color: #fff;
        transition:all 0.5s linear;
        border-radius:24px;
        padding:22px;
        cursor:pointer;
        color: #000;
        border:1px solid #000;
    }
    span.grey_capsule:hover {
        background-color: white;
        color:#555;
    }
    span.grey_capsule {
        transition:all 0.5s linear;
        color:white;
        background:#555;
        border-radius:10px;
        padding:15px;
        margin:5px;
        font-size:18px;
        border:1px solid #555;
    }
/*
    button:hover:disabled {
        cursor: default;
    }
    button:active:disabled {
        cursor: default;
        box-shadow: 0px 5px 5px rgba(190, 0, 0, 0.55);
    }
    button:active:enabled {
        box-shadow: inset 1px 1px 5px var(--dw3_button_background);
        transform: translateY(2px);
    }*/ 
    button:disabled,
    button[disabled]{
/*         border: 1px solid #999999;
        background-color: #cccccc;
        color: #666666;
        text-shadow: 0px 0px 1px #333; */
        box-shadow:inset 0px 0px 2px 1px red;
    } 
    textarea:focus {border: 1px solid white;color: #000;background: #FFF;box-shadow: rgba(0, 0, 0, 0.15) 0px 5px 15px;}
    textarea {
        outline: none;
        font-weight: bold;
        padding: 5px;
        box-sizing: border-box;
        border-radius: var(--dw3_button_radius);
        border: 1px solid lightgrey;
        width:100%;
        color: #333333;
        background: #eee;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
        line-height: 1;
    }
    select {
        display: inline-block;
        outline: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background: url(/pub/img/dw3/drop.png) 100%/25px no-repeat #EEE;
        box-sizing: border-box;
        border-radius: var(--dw3_button_radius);
        border: 1px solid lightgrey;
        width:100%;
        color: #333333;
        font-weight: bold;
        padding: 5px 30px 5px 10px;
        /* min-width:295px; */
        cursor:pointer;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }
    .like_search {
        margin:3px 0px;
        vertical-align:middle;
        outline: none;
        font-weight: bold;
        padding: 7px;
        box-sizing: border-box;
        border-radius: var(--dw3_button_radius);
        border: 1px solid lightgrey;
        font-size: 1em; 
        color: #333333;
        width:100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        background: url(/pub/img/dw3/drop.png) 100%/25px no-repeat #fff;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }
/*     input:focus{
        box-shadow: inset 0 0 5px var(--dw3_selected_border);
    } */
    select:focus{
        box-shadow: inset 0 0 5px var(--dw3_selected_border);
    }
    textarea:focus{
        box-shadow: inset 0 0 5px var(--dw3_selected_border);
    }
    input.pourcent{
        background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #EEE;
    }
    input.money{
        background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #EEE;
    }
    input.cm{
        background: url(/pub/img/dw3/arrow-cm.png) 99% / 20px no-repeat #EEE;
    }
    input.g{
        background: url(/pub/img/dw3/arrow-g.png) 99% / 20px no-repeat #EEE;
    }
    input.kg{
        background: url(/pub/img/dw3/arrow-kg.png) 99% / 20px no-repeat #EEE;
    }
    input.eye_on{ 
        background: url(/pub/img/dw3/eye_off.png) 100% / 8% no-repeat #EEE;
    }
    input.eye_off{ 
        background: url(/pub/img/dw3/eye.png) 100% / 8% no-repeat #EEE;
    }
    input.editable {
        background: url(/pub/img/dw3/edit.png) 100% / 8% no-repeat #EEE;
    }
    input.dropbox {
        background: url(/pub/img/dw3/drop.png) 100% / 8% no-repeat #EEE;
    }

    input[type=date]:disabled {
        border: 1px solid #999999;
        background-color: #eee;
        color: #444;
    }

    input[type=date] {
        outline: none;
        vertical-align:middle;
        text-align:center;
        font-weight: bold;
        padding: 5px;
        box-sizing: border-box;
        border-radius: var(--dw3_button_radius);
        border: 1px solid lightgrey;
        color: #333333;
        background: #eee;
        width:100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }

    input[type=datetime-local]:disabled {
        border: 1px solid #999999;
        background-color: #eee;
        color: #444;
    }
  
    input[type=datetime-local] {
        outline: none;
        vertical-align:middle;
        text-align:center;
        font-weight: bold;
        padding: 5px;
        box-sizing: border-box;
        border-radius: var(--dw3_button_radius);
        border: 1px solid lightgrey;
        color: #333333;
        background: #eee;
        width:100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }
    input[type=text]:disabled {
        border: 1px solid #999999;
        background-color: #cccccc;
        color: #444;
    }
    input[type=text]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #F0F0F0;
        color: #222;
    }
    input[type=text] {
        outline: none;
        font-weight: bold;
        padding: 5px 25px 5px 5px;
        box-sizing: border-box;
        border-radius: var(--dw3_button_radius);
        border: 1px solid lightgrey;
        color: #333333;
        width:100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.35) ;
        vertical-align:middle;
        background: url(/pub/img/dw3/arrow-under-tag.png) 99% / 20px no-repeat #EEE;
    }
    input[type=number]:disabled {
        border: 1px solid #999999;
        background-color: #cccccc;
        color: #444;
    }
    input[type=number]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #F0F0F0;
        color: #222;
    }
    input[type=number] {
        outline: none;
        font-weight: bold;
        padding: 5px;
        text-align:left;
        box-sizing: border-box;
        border-radius: var(--dw3_button_radius);
        border: 1px solid lightgrey;
        color: #333333;
        width:100%;
        vertical-align:middle;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
       /*  -moz-appearance: textfield; */
        background: url(/pub/img/dw3/arrow-number.png) 99% / 20px no-repeat #EEE;
    }
    input[type=password]:disabled {
        border: 1px solid #999999;
        background-color: #cccccc;
        color: #444;
    }
    input[type=password]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #F0F0F0;
        color: #222;
    }
    input[type=password] {
        outline: none;
        font-weight: bold;
        padding: 5px 25px 5px 5px;
        border-radius: var(--dw3_button_radius);
        vertical-align:middle;
        border: 1px solid lightgrey;
        color: #333333;
        width:100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
        background: url(/pub/img/dw3/eye_off.png) 99% / 20px no-repeat #EEE;

    }
    input[type=search] {
        vertical-align:middle;
        outline: none;
        font-weight: bold;
        padding: 7px 26px 7px 7px;
        box-sizing: border-box;
        border-radius: var(--dw3_button_radius);
        border: 1px solid lightgrey;
        font-size: 1.2em; 
        color: #333333;
        width:100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        background: #fff;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
        background: url(/pub/img/dw3/searchicon.png) 99% / 20px no-repeat #fff;
    }
    input[type=time] {
        outline: none;
        font-weight: bold;
        padding: 5px;
        box-sizing: border-box;
        border-radius: var(--dw3_button_radius);
        border: 0px solid grey;
        color: #333333;
        background: #EEE;
        width:100%;
        vertical-align:middle;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }
    input[type=file] {
        outline: none;
        font-weight: bold;
        padding: 5px;
        box-sizing: border-box;
        border-radius: var(--dw3_button_radius);
        border: 0px solid grey;
        color: #333333;
        background: #EEE;
        width:100%;
        vertical-align:middle;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }
    input[type=color] {
        outline: none;
        box-sizing: border-box;
        border: 0px solid grey; 
        width:100%;
        cursor:pointer;
        vertical-align:middle;
        padding: 0px 20px 0px 0px;
        background: url(/pub/img/dw3/drop.png) 99% / 20px no-repeat #EEE;
    }
    input[type=checkbox]:disabled {
        background-color:#EEE;
        color: currentColor;
        cursor:not-allowed;
    }
    input[type=checkbox] {
        border-radius: var(--dw3_button_radius);
        border: 1px solid var(--dw3_form_color);
        color: var(--dw3_form_color);
        background: #EEE;
        box-shadow: 1px 1px 3px 1px rgba(0, 0, 0, 0.2) ;
        transform: scale(1.2);
    }
    input[type=checkbox]:checked{
        accent-color: var(--dw3_selected_border);
    }
   /*  input[type="checkbox"] {
        -webkit-appearance: none;
        appearance: none;
        background-color:  var(--dw3_form_background);
        margin: 0;
        outline: none;
        font: inherit;
        color: currentColor;
        
        width: 1.15em;
        height: 1.15em;
        border: 0.15em solid currentColor;
        border-radius: var(--dw3_button_radius);
        transform: translateY(-0.075em);
        cursor:pointer;
        display: grid;
        place-content: center;
    }
    input[type="checkbox"]::before {
        content: "";
        width: 0.65em;
        height: 0.65em;
        clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
        transform: scale(0);
        transform-origin: bottom left;
        transition: 120ms transform ease-in-out;
        box-shadow: inset 1em 1em var(--form-control-color);
        background-color: CanvasText;
    }
    input[type="checkbox"]:checked::before {
        transform: scale(1);
    }
    input[type="checkbox"]:focus {
        outline: max(2px, 0.15em) solid currentColor;
        outline-offset: max(2px, 0.15em);
    } */
    tbody{
        width: 100%;
        margin:0;padding:0;
    }
    input[type="submit"] {
        display:inline-block;
        background:  var(--dw3_button_background);
        color:   var(--dw3_button_color);
        border-radius: var(--dw3_button_radius);
        padding: 7px 10px;
        margin:3px;
        cursor:pointer;
        border: 1px solid var(--dw3_button_color);
        vertical-align:middle;
        box-shadow: var(--dw3_button_shadow);
        /* text-shadow: 0px 0px 1px #666; */
        font-weight:bold;
        font-family: var(--dw3_button_font);
    }

/*+---------------------------------------------------------------------------------+ 
  |                                                                                 |
  |                                       BODY                                      |
  |                                                                                 |
  +---------------------------------------------------------------------------------+*/

.dw3_font {
    font-family:dw3;
    font-size:26px;
    -webkit-font-smoothing: antialiased;
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.sticky{ 
    position: sticky;  
    top: 0;  
    width: 100%;
}

/* sub-menus on wide screen: */
.dw3_sub_menu {
    z-index:3000;max-height:0px;position:absolute;overflow:hidden;transition: all 0.5s ease-in-out;text-align:center;margin-top:10px;
    -ms-overflow-style: none;  /* Internet Explorer 10+ */
    scrollbar-width: none;  /* Firefox */
}

.dw3_sub_menu::-webkit-scrollbar { 
    display: none;  /* Safari and Chrome */
}
/* sub-menus on small screen: */
.dw3_sub_menu2 {z-index:3000;max-height:0px;overflow:hidden;width:100%;max-width:100%;transition: all 0.5s ease-in-out;box-shadow:inset 0px 0px 7px 7px rgba(0,0,0,0.1);}
.dw3_sub_menu_open_100 {transition: all 0.4s ease-in-out;max-height:100px;}
.dw3_sub_menu_open_150 {transition: all 0.4s ease-in-out;max-height:150px;}
.dw3_sub_menu_open_200 {transition: all 0.4s ease-in-out;max-height:200px;}
.dw3_sub_menu_open_250 {transition: all 0.4s ease-in-out;max-height:250px;}
.dw3_sub_menu_open_300 {transition: all 0.4s ease-in-out;max-height:300px;}
.dw3_sub_menu_open_350 {transition: all 0.4s ease-in-out;max-height:350px;}
.dw3_sub_menu_open_400 {transition: all 0.4s ease-in-out;max-height:400px;}
.dw3_sub_menu_open_450 {transition: all 0.4s ease-in-out;max-height:450px;}
.dw3_sub_menu_open_500 {transition: all 0.5s ease-in-out;max-height:500px;}
.dw3_sub_menu_open_550 {transition: all 0.5s ease-in-out;max-height:550px;}
.dw3_sub_menu_open_600 {transition: all 0.5s ease-in-out;max-height:600px;}
.dw3_sub_menu_open_650 {transition: all 0.5s ease-in-out;max-height:650px;}
.dw3_sub_menu_open_700 {transition: all 0.5s ease-in-out;max-height:700px;}
.dw3_sub_menu_open_800 {transition: all 0.5s ease-in-out;max-height:800px;}
.dw3_sub_menu_open_900 {transition: all 0.5s ease-in-out;max-height:900px;}
.dw3_sub_menu_open_1000 {transition: all 0.5s ease-in-out;max-height:1000px;overflow-y:auto;}
.dw3_sub_menu_open_auto {transition: all 0.5s ease-in-out;max-height:100vh;overflow-y:auto;}
.dw3_sub_menu a button{font-size:1em;border:0;box-shadow:0;font-family:var(--dw3_menu_font);color:var(--dw3_menu_color);background-image: linear-gradient(var(--dw3_menu_background) 0%, var(--dw3_menu_background2) 40%);margin:1px 0px;}

/* subs NOT-MENU */

.dw3_sub {
    transition-property: max-height;
    transition-duration: 0.5s;
    transition-timing-function: linear;
    transition-delay: 0s;
    overflow:hidden;
    width:100%;
    border-radius:5px;
    text-align:center;
    max-height:0px;
}
.dw3_sub p {width:100%;}

.dw3_sub_open_100  {max-height:100px;}
.dw3_sub_open_150  {max-height:150px;}
.dw3_sub_open_200  {max-height:200px;}
.dw3_sub_open_250  {max-height:250px;}
.dw3_sub_open_300  {max-height:300px;}
.dw3_sub_open_350  {max-height:350px;}
.dw3_sub_open_400  {max-height:400px;}
.dw3_sub_open_450  {max-height:450px;}
.dw3_sub_open_500  {max-height:500px;}
.dw3_sub_open_550  {max-height:550px;}
.dw3_sub_open_600  {max-height:600px;}
.dw3_sub_open_650  {max-height:650px;}
.dw3_sub_open_700  {max-height:700px;}
.dw3_sub_open_800  {max-height:800px;}
.dw3_sub_open_900  {max-height:900px;}
.dw3_sub_open_1000 {max-height:1000px;}
.dw3_sub_open_auto {max-height:none;}
.no_underline:hover{
    text-decoration: none; 
}

.dw3_sub_closed {
    max-height:0px;
    transition: all 0.5s ease-in-out;
    overflow-x:hidden;
    overflow-y:hidden;
    border-radius:5px;
    font-family:  var(--dw3_form_font);
    text-align:center;
}

.dw3_high_view_link a {
    font-size:17px;
    text-decoration-line: underline; 
    text-decoration-thickness: 2px; 
    text-decoration-color: rgba(0,0,0,0);
    text-decoration-skip-ink: none;
    text-underline-offset:7px;
}
.dw3_high_view_link a:hover {
    text-decoration-color: var(--dw3_menu_color);
}  
.dw3_wide_view_menu a {
    text-decoration-line: underline; 
    text-decoration-thickness: 1px; 
    text-decoration-color: rgba(0,0,0,0);
    text-decoration-skip-ink: none;
    text-underline-offset:7px;
}
.dw3_wide_view_menu a:hover {
    text-decoration-color: var(--dw3_selected_border);
}  
.dw3_wide_view_menu {
    overflow: hidden;
    white-space: nowrap;
    transition: width 1s linear;
}
#dw3_small_view_menu {
    overflow: hidden;
    white-space: nowrap;
    transition: width 0.5s linear;
}
#dw3_scene{
    z-index:-1;
    content:"";
    position:<?php echo $INDEX_SCENE_POS??'fixed!important;'; ?>;
    width:100vw;
    min-height: 100vh;
    left: 0px;
    top: 0px;
}

#dw3_scene_fade{
    z-index:-1;
    position: fixed;
    text-align:center;
    top:0px;
    right:0px;
    left:0px;
    height: 100vh;
    opacity: 0.7;
    transition: opacity 0.7s linear;
    background: rgba(0, 0, 0, 0.7);
}

#dw3_chatbot_container{
    display:none;
    opacity: 0;
    z-index:500;
    position: fixed;
    text-align:center;
    bottom:85px;
    right:5px;
    transition: opacity 0.7s linear;
    width:330px;
    height:330px;
}

#dw3_chatbot_btn:hover{
    color: #fff;
    background-color: rgba(44, 44, 44, 0.3);
    border: 1px solid #fff;
}
#dw3_chatbot_btn{
    z-index:3001;
    border: 1px solid #333;
    /* mix-blend-mode: difference; */
    transition: all .5s ease 0s;
    position: fixed;
    padding:0px;
    overflow:hidden;
    right: 25px;
    bottom: 55px;
    color: #777;
    background-color: rgba(205, 205, 205, 0.3);
    border-radius: 64px;
    cursor: pointer;
}
#dw3_scroll_top:hover{
    color: #fff;
    background-color: rgba(44, 44, 44, 0.3);
    border: 1px solid #fff;
}
#dw3_scroll_top{
    z-index:3001;
    border: 1px solid #333;
    /* mix-blend-mode: difference; */
    transition: all .5s ease 0s;
    position: fixed;
    padding:0px;
    overflow:hidden;
    right: -105px;
    <?php if (isset($CIE_SCHAT_KEY1) && $CIE_SCHAT_KEY1!="" && $CIE_SCHAT_ACTIVE == "checked"){ echo "bottom: 85px;"; } else { echo "bottom: 10px;"; } ?>    
    color: #777;
    background-color: rgba(205, 205, 205, 0.3);
    border-radius: 64px;
    cursor: pointer;
}

#dw3_head table{width:100%;margin-left:auto;margin-right:auto;max-width:3000px;}
#dw3_head{
    z-index:350;
    user-select:none;
    /* position: relative; */
    width:100%;
    height:70px;
    max-height:70px;
    color: var(--dw3_menu_color);
    <?php if (isset($CIE_BG5) && $CIE_BG5 != ""){
      echo "background-image: url('/pub/img/".$CIE_BG5."');";
      echo "background-repeat: no-repeat;";
      //echo "background-attachment: fixed;";
      echo "background-position: top;";
      echo "background-size: cover;";
    } else {
      //echo "background: var(--dw3_menu_background);";
      echo "background-image: linear-gradient(var(--dw3_menu_background) 0%, var(--dw3_menu_background2) 40%);";
    }
    ?>
    text-align:center;
    vertical-align:middle!important;
    transition: all 1s;
    border: 0px solid darkgrey;
    /* box-shadow:  inset rgba(255, 255, 255, 0.25) 0px 0px 2px 2px; */
    line-height: 1;
    margin: 0px 0px 0px 0px;
    font-size:1em;
}

#dw3_head_popup{
    display:none;
    opacity:0;
    z-index:150;
    position: fixed;
    top: 55px;
    right:60px;
    height:0px;
    width:150px;
    color:black;
    font-size: 14px;
    background: rgba(255, 255, 255, 0.8);
    text-align:right;
    vertical-align:middle;
    padding: 2px ;
    border-radius: var(--dw3_button_radius);
    border: 0px solid darkgrey;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    transition: height 1s;
    line-height: 1;
}
/* !!test only!! #dw3_body{ 
    display:inline-block;
    text-align:center;
    max-width: 100%;
    overflow-x: hidden;
} */
/* #dw3_body { 
    width:100%;
    max-width:3000px;
    display:inline-block;
    min-height:90vh;
} */

.dw3_image_view{
    position:relative;
    cursor:pointer;
    margin:5px;
    box-shadow: 2px 2px 5px 2px black;
    width:auto;
    height:300px;
    max-height:300px;
    max-width:95%;
    border-radius:5px;
    transition: all 0.3s linear;
}
.dw3_image_zoom{
    z-index:+10;
    position:fixed;
    margin:0px;
    top:0px;
    left:0px;
    width:95vw;
    height:auto;
    max-height:100%;
    max-width:100%;
    background-color: rgba(0,0,0,0.5);
}
.dw3_body_fade{
    z-index: 2050;
    position:fixed;
    top:0px;
    height:100%;
    left:0px;
    width:100vw;
    overflow:hidden;
    opacity:0;
    transition: 0.7s;
    background: linear-gradient(-45deg,rgb(238, 183, 82),rgb(248, 48, 48),rgb(41, 140, 233),rgb(54, 235, 38));
	background-size: 400% 400%;
	animation: body_fade_gradient 15s ease infinite;
	height: 100vh;
    display:none;
}

@keyframes body_fade_gradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}

.dw3_body_foot{
    display:inline-block;
    position: fixed;
    right:0px;
    left: 0px;
    bottom:0px;
    height:40px;
    text-align:center;
    vertical-align:middle; 
    border: 0px solid darkgrey;
    background: var(--dw3_head_background);
    color: var(--dw3_head_color);
    overflow:hidden;
    box-shadow: inset 1px 1px  5px #f0f0f0;
    line-height: 1;
}
.dw3_page_foot{
    display:inline-block;
    width:100%;
    user-select:none;
    min-height:240px;
    color: var(--dw3_foot_color);
    font-family: var(--dw3_form_font);
    text-align:center;
    vertical-align:top;
    border: 0px solid darkgrey;
    line-height: 1;
    overflow:hidden;
    margin:-1px 0px 0px 0px;
    <?php 
    if (isset($CIE_BG4_PAD)){echo "padding-top:".$CIE_BG4_PAD.";";}
    if (isset($CIE_BG4) && $CIE_BG4 != ""){
      echo "background-image: url('/pub/img/".$CIE_BG4."');";
      echo "background-repeat: no-repeat;";
      //echo "background-attachment: fixed;";
      echo "background-position: top;";
      echo "background-size: cover;";
    } else {
      //echo "background: var(--dw3_menu_background);";
      echo "background-image: linear-gradient(var(--dw3_foot_background1) 0%, var(--dw3_foot_background2) 40%);";
    }
    ?>
}
#dw3_msg{
    display:none;
    z-index:2500;
    position: fixed;
    max-width:95%;
    max-height:90%;
    min-width:300px;
    min-height:80px;
    width:auto;
    top: 50%;
    left: 50%;
    -moz-transform: translateX(-50%) translateY(-50%);
    -webkit-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
    text-align:center;
    padding:35px;
    border: 0px solid #000;
    font-size: 1.1em;
    background-image: url('/pub/img/frame/<?php echo $CIE_FRAME??'frame5.png'; ?>');
    background-repeat: no-repeat;
    background-position: center;
    background-size: 100% 100%;
    color: var(--dw3_msg_color);
    font-family:  var(--dw3_form_font);
    overflow-x:hidden;
    overflow-y:auto;
    transition-property: height, width, transform, opacity;
    transition-duration: 0.75s;
    transition-timing-function: linear;
    transition-delay: 0s;
    line-height: 1.2;
    border-radius:8px;
}
#dw3_editor{
    z-index:2200;
    display:none;
    position: fixed;
    width:95%;
    min-width:250px;
    max-width:750px;
    left: 50%;
    top: 53%;
    min-height:85%;
    max-height:90%;
    transform: translateX(-50%) translateY(-50%);
    text-align:center;
    padding:0px;
    opacity:0;
    border-radius: var(--dw3_form_radius);
    border: 1px solid darkgrey;
    background: var(--dw3_form_background);
    color: var(--dw3_form_color);
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
    overflow-x:hidden;
    overflow-y:hidden;
    font-family:  var(--dw3_body_font);
    transition-property: height, width, transform, opacity;
    transition-duration: 0.5s;
    transition-timing-function: linear;
    transition-delay: 0s;
    line-height: 1;
}
.dw3_editor{
    z-index:2200;
    display:none;
    position: fixed;
    width:95%;
    min-width:250px;
    max-width:750px;
    left: 50%;
    top: 53%;
    min-height:85%;
    max-height:90%;
    transform: translateX(-50%) translateY(-50%);
    text-align:center;
    padding:0px;
    opacity:0;
    border-radius: var(--dw3_form_radius);
    border: 1px solid darkgrey;
    background: var(--dw3_form_background);
    color: var(--dw3_form_color);
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
    overflow-x:hidden;
    overflow-y:hidden;
    font-family:  var(--dw3_body_font);
    transition-property: height, width, transform, opacity;
    transition-duration: 0.5s;
    transition-timing-function: linear;
    transition-delay: 0s;
    line-height: 1;
}
#dw3_cart{
    z-index:2100;
    display:none;
    position: fixed;
    width:95%;
    min-width:250px;
    max-width:750px;
    left: 50%;
    top:2%;
    min-height:90%;
    max-height:95%;
    transform: translateX(-50%);
    text-align:center;
    padding:0px;
    opacity:0;
    border-radius: var(--dw3_form_radius);
    border: 1px solid darkgrey;
    background: var(--dw3_form_background);
    color: var(--dw3_form_color);
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
    overflow-x:hidden;
    overflow-y:hidden;
    font-family:  var(--dw3_body_font);
    line-height: 1;
    transition-property: height, width, transform, opacity;
    transition-duration: 0.5s;
    transition-timing-function: linear;
    transition-delay: 0s;
}

.dw3_paragraf{
    margin:15px 10px;
    max-width:1024px;
    display:inline-block;
    vertical-align:top;
    text-align:left;
    line-height:1;
    width:95%;
} 
.dw3_page{ 
    width:100%; 
    max-width:1080px; 
    display:inline-block;	
    padding: 0px;
    text-align:center;
}

.dw3_tabs{
    overflow: hidden;
    border-top: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    background-color: #f1f1f1;
    display:flex;
    justify-content: space-around;
    width:100%;
    line-height:1;
}
.dw3_tabs div {
  background-color: inherit;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.5s;
  box-shadow:0px;
}

.dw3_tabs div:hover {
  background: #ddd;
}

.dw3_tabs_content {
  display: none;
  padding: 0px;
  border: 1px solid #ccc;
  border-top: none;
  animation: dw3_tab_fade_effect 1s;
  line-height:1;
}

@keyframes dw3_tab_fade_effect {
  from {opacity: 0;}
  to {opacity: 1;}
}


/* .dw3_section:first-child {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0s;
    opacity:1;
    
} */
@supports (-webkit-overflow-scrolling: touch) { 	.dw3_section: { 		background-attachment: scroll; 	} }
.dw3_section {
    display:inline-block;
    width: 100%;
    text-align:center;
    margin: 0px 0px 0px 0px;
    padding: 0px 0px 0px 0px;
    transition-property: transform, opacity;
    transition-duration: 1.5s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.1s;
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: <?php if (isset($_SERVER['HTTP_USER_AGENT'])){if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'iphone') || strstr($_SERVER['HTTP_USER_AGENT'], 'iPad')){echo "scroll";}else{echo "fixed";}} else {echo "fixed";} ?>;
    background-size: cover;
    <?php if (isset($_SERVER['HTTP_USER_AGENT'])){if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'iphone') || strstr($_SERVER['HTTP_USER_AGENT'], 'iPad')){echo "transform: translateZ(0);will-change: transform;";}} ?>
}
.dw3_section_none {
    opacity:1;
}
 /* Redimension 3D 10% */
 .dw3_section_scale3D {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: scale3D(1,0.85,1);
    opacity:0;
 }
 /* Redimension 3D 20% */
 .dw3_section_scale3D2 {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: scale3D(0.8,0.65,0.8);
    opacity:0;
 }
 /* Redimension 3D 45% */
 .dw3_section_scale3D3 {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: scale3D(0.45,0.45,0.45);
    opacity:0;
 }
 /* Redimension 3D 90% */
 .dw3_section_scale3D4 {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: scale3D(0.1,0.1,0.1);
    opacity:0;
 }
 /* Redimension Largeur 45% */
 .dw3_section_scaleX {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: scaleX(0.45);
    opacity:0;
 }
 /* Redimension Largeur 90% */
 .dw3_section_scaleX2 {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: scaleX(0.1);
    opacity:0;
 }
 /* Redimension Hauteur 45% */
 .dw3_section_scaleY {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: scaleY(0.45);
    opacity:0;
 }
 /* Redimension Hauteur 90% */
 .dw3_section_scaleY2 {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: scaleY(0.1);
    opacity:0;
 }
 /* Tourner Axe Z 89deg */
 .dw3_section_rotate {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: rotate(89deg);
    opacity:0;
 }
 /* Tourner Axe Z 180deg */
 .dw3_section_rotate2 {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: rotate(180deg);
    opacity:0;
 }
 /* Tourner Axe Z 360deg */
 .dw3_section_rotate3 {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: rotate(360deg);
    opacity:0;
 }
 /* Tourner Axe X 180deg */
 .dw3_section_rotate4 {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: rotateX(180deg);
    opacity:0;
 }
 /* Tourner Axe X 360deg */
 .dw3_section_rotate5 {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: rotateX(360deg);
    opacity:0;
 }
 /* Tourner Axe X 720deg */
 .dw3_section_rotate6 {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: rotateX(720deg);
    opacity:0;
 }
 /* Tourner Axe Y 180deg */
 .dw3_section_rotate7 {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: rotateY(180deg);
    opacity:0;
 }
 /* Tourner Axe Y 360deg */
 .dw3_section_rotate8 {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: rotateY(360deg);
    opacity:0;
 }
 /* Tordu 15deg */
 .dw3_section_skew {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: skew(15deg, 15deg);
    opacity:0;
 }
 /* Déplacement Droite */
 .dw3_section_translateR {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: translateX(99%);
    opacity:0;
 }
 /* Déplacement Gauche */
 .dw3_section_translateL {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: translateX(-99%);
    opacity:0;
 }
 /* Déplacement Hauteur */
.dw3_section_translateH {
    transition-property: transform, opacity;
    transition-duration: 2s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    transform: translateY(10%);
    opacity:0;
 }
 /* Déplacement & Redimension Hauteur */
 .dw3_section_translateH2 {
    transition-property: transform, opacity;
    transition-duration: 3s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.6s;
    transform: translateY(20%) scaleY(0.8);
    opacity:0;
 }
 /* Transparence seulement */
 .dw3_section_opacity {
    transition-property: transform, opacity;
    transition-duration: 3s;
    transition-timing-function: ease-in-out;
    transition-delay: 0.4s;
    opacity:0;
 }


.dw3_article div > div {    
    transition-property: transform;
    transition-duration: 0.5s;
    transition-timing-function: ease-in-out;
}
.dw3_article:hover div > div {
    transform: scale(1.1,1.1);
}

.dw3_article{
    background-color:#fff;
    color:#222;
    cursor:pointer;
    box-shadow:2px 2px 4px 2px grey;
    padding:0px;
    border-radius:10px;
    text-align:center;
    width:97%;max-width:335px;
    display:inline-block;
    vertical-align:top;
    margin:5px 2px 5px 2px;
    font-family:  var(--dw3_form_font);
    line-height: 1;
    overflow:hidden;
}
.dw3_box{
    width:97%;max-width:335px;
    display:inline-block;
    text-align:left;
    vertical-align:top;
    box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.25);
    padding:10px 3px 10px 3px;
    border-radius:4px;
    margin:5px 2px 5px 2px;
    background: var(--dw3_form_background);
    color: var(--dw3_form_color);
    font-family:  var(--dw3_form_font);
    line-height: 1;
}
#dw3_notif_container{
    z-index:3000;
    position: fixed;
    top: 70px;
    right:5px;
    width:50px;
    text-align:right;
    -moz-transition: height .5s;
    -ms-transition: height .5s;
    -o-transition: height .5s;
    -webkit-transition: height .5s;
    transition: height .5s;
    line-height: 1;
}

.dw3_product_photo{
    border:0px solid #999; 
    box-shadow: 2px 2px 3px 1px rgba(0, 0, 0, 0.35);
    height:200px;
    width:auto;
    max-width:380px;
    margin:0px 4px;
}
.dw3_category_photo{
    border:0px solid #999; 
    box-shadow: rgba(0, 0, 0, 0.25) 0px 5px 5px;
    max-height:170px;
    height:auto;
    width:170px;
    max-width:170px;
    border-top-right-radius:10px;
    border-top-left-radius:10px;
}

.dw3_image_bg {
    background: rgba(0,0,0,0);
    background-image: url("/pub/img/dw3/nd.png");
    background-repeat: no-repeat;
    background-size: 100% auto;
    background-position: center;
    vertical-align:bottom;
    border:0px solid #000;
}

.dw3_noselect { /*  to avoid text selection */
    -webkit-touch-callout:none;
    -webkit-user-select:none;
    -khtml-user-select:none;
    -moz-user-select:none;
    -ms-user-select:none;
    user-select:none;
    -webkit-tap-highlight-color:rgba(0,0,0,0);
}
.dw3_config-icon{
    -moz-animation:spin 16s linear infinite;
    animation:spin 16s linear infinite;
    -webkit-animation: spin 16s infinite linear;
}


#dw3_logo_top{
    width:auto;
    height:32px;
}

.dw3_inverted_bg{
    -webkit-filter: invert(100%);
    filter: invert(100%);
}
.dw3_svg_portal{
    z-index:1500;
    position: fixed;
    top: -25%;
    left: -25%;
    right: -25%;
    bottom: -25%;
    min-width:500px;
    min-height:500px;
}
  
/*+---------------------------------------------------------------------------------+ 
  |                                                                                 |
  |                                       MENU                                      |
  |                                                                                 |
  +---------------------------------------------------------------------------------+*/

#dw3_cookie_msg {
    z-index: 3000;
    display:inline-block;
    padding:0px; /* ne pas changer laisser a 0px */    
    position:fixed;
    bottom:10px;
    /* left:0px; */
    right:10px;
    /* height:0px; */
    max-width:90%;
    width:500px;
    opacity:1;
    transition: height 1s ease-in-out;
    overflow:hidden;
    background-color:var(--dw3_menu_background);
    color:var(--dw3_menu_color);
    font-family: var(--dw3_form_font);
    line-height: 1.2;
    font-size:1em;
    border-radius:5px;
    box-shadow:inset 0px 0px 2px 1px grey;
}
#dw3_cookie_pref {
    z-index: 2900;
    display:inline-block;
    padding:0px;     
    position:fixed;
    text-align:center;
    top:0px;
    left:0px;
    min-width:20%;
    width:380px;
    max-width:95%;
    max-height:90%;
    opacity:1;
    transition: 0.9s ease-in-out;
    overflow-x:hidden;
    overflow-y:auto;
    background-color:var(--dw3_menu_background);
    color:var(--dw3_menu_color);
    font-family: var(--dw3_form_font);
    line-height: 0.9;
    transform:scaleX(0%);
    transform-origin:center left;
}
#dw3_menu_fade {
    z-index: 199;
    position:fixed;
    top:0px;
    height:100%;
    left:0px;
    width:0vw;
    overflow:hidden;
    opacity:0.4;
    transition: 0.7s;
    background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
	background-size: 400% 400%;
	animation: menu_fade_gradient 12s ease infinite;
	height: 100vh;
}
.dw3_menu_fade_open{
    width:100vw !important;
}
@keyframes menu_fade_gradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}

#dw3_menu {
    z-index: 2000;
    display:inline-block;
    padding:0px 0px 5px 0px;     
    position:fixed;
    <?php if (isset($INDEX_HEADER)){if ($INDEX_HEADER == "/pub/section/header3.php"){ echo "top:0px;"; } else if ($INDEX_HEADER == "/pub/section/header7.php") {echo "top:70px;";} else {echo "top:70px;";}}else{echo "top:70px;";}?>
    right:-370px;
    opacity:1;
    max-width:370px; 
    min-height:33px;
    max-height:80vh;
    transition: 0.7s;
    border-bottom-left-radius:var(--dw3_button_radius);
    overflow-x:hidden;
    overflow-y:auto;
    background-color:var(--dw3_menu_background2);
    line-height: 1;
}
#dw3_menu button {
    background: var(--dw3_menu_background2);
    border: 1px solid var(--dw3_menu_background2);
    background-image: linear-gradient(var(--dw3_menu_background) 0%, var(--dw3_menu_background2) 40%);
    color: var(--dw3_menu_color);
    font-weight:normal;
    font-family:var(--dw3_menu_font);
    width:100%;
    padding:5px 5px;
    /* filter: drop-shadow(1px 1px 1px var(--dw3_menu_color)); */
    cursor: pointer;

    margin:0px;
    vertical-align:middle;
    /* text-shadow: 0px 0px 1px #888; */
    box-shadow: inset 0px 0px  0px #000;
    border-radius:0px;
    line-height: 1;
}
#dw3_menu button div {
    text-align:left;
    width:270px;
    margin-top:7px;
    margin-left:3px;
    vertical-align:middle;
    display:inline-block;
    text-decoration:none;
} 
#dw3_menu button span {
    vertical-align:middle;
    display:inline-block;
} 
#dw3_menu button:hover div, #dw3_menu button:active div {
    text-decoration-line: underline; 
    text-decoration-thickness: 2px; 
    text-decoration-skip-ink: none;
    text-underline-offset:5px;
    text-decoration-style: solid;
    text-decoration-color: var(--dw3_selected_border);
}  
/* #dw3_menu button:hover, #dw3_menu button:active {
    box-shadow: 0px 0px 0px rgba(0, 0, 0, 0);
    border: 1px solid var(--dw3_menu_color);
    border-bottom:1px solid rgba(0,0,0,0.3);
}  */ 
.menu_close {
    position:absolute;
    text-align:center;
    z-index:150;
    width: 35px;
    height: 25px;
    opacity:0; 
    transition: opacity 0.5s linear; 
    font-size:20px;
    vertical-align:bottom;
    font-weight:bold;
    padding-top:10px;
    color:var(--dw3_menu_color);
    text-shadow:1px 1px 1px gold;
    box-shadow:none;
  }
  #dw3_menu_bars{
    display:inline-block;
    width:50px;
    max-width:50px;
    overflow:hidden;
  }
.dw3_menu_bar1, .dw3_menu_bar2, .dw3_menu_bar3 {
    width: 35px;
    height: 6px;
    background-color:  var(--dw3_menu_color);
    margin: 6px 0;
    transition: 0.4s;
    border-radius:3px;
    box-shadow :1px 1px 1px #222;
}
<?php if ($INDEX_MENU_ANIM??"X" == "X"){ ?>
.dw3_menu_bars_change .dw3_menu_bar1 {
    opacity: 0;
}
.dw3_menu_bars_change .dw3_menu_bar2 {
    transform: rotate(45deg);
    box-shadow :none;
}
.dw3_menu_bars_change .dw3_menu_bar3 {
    transform: rotate(-45deg) translateX(8px) translateY(-9px);
    box-shadow :none;
}

.dw3_menu_change {
    /* transform: initial; */
    transform: translateX(-370px);
}

<?php } else { ?>
    .dw3_menu_bars_change .dw3_menu_bar1 {
    transform: translate(0, 24px);
    opacity: 0;
}
.dw3_menu_bars_change .dw3_menu_bar2 {
    opacity: 0;
    transform: translate(0, 12px);
}
.dw3_menu_bars_change .dw3_menu_bar3 {
    transform: translate(0, 6px);
    box-shadow :0px 0px 5px var(--dw3_head_background);
}

.dw3_menu_change {
    /* transform: initial; */
    transform: translateX(-370px);
}
.dw3_menu_bars_change .menu_close {
    opacity: 1;
}
<?php } ?>
/*+-------------------------------------------------------------------------------+ 
|                                                                                 |
|                                       FORM                                      |
|                                                                                 |
+---------------------------------------------------------------------------------+*/

#dw3_form_fade{
    position: fixed;
    text-align:center;
    z-index:2000;
    top:0px;
    right:0px;
    left:0px;
    height: 100vh;
    opacity: 0;
    transition: opacity 0.5s linear;
    display: none;
    background-color: rgba(255,255,255,0.4);  
}

#dw3_opt_form {
    display:none;
    z-index:1110;
    position: fixed;
    width:350px;
    height:80%;
    min-height:350px;
    max-height:900px;
    top: 30px;
    left: 50%;
    -moz-transform: translateX(-50%) ;
    -webkit-transform: translateX(-50%);
    transform: translateX(-50%);
    text-align:center;
    padding:25px;
    border-radius: var(--dw3_form_radius);
    border: 1px solid darkgrey;
    font-size: 20px;
    color: black;
    opacity: 0;
    transition: opacity 1s;
    overflow:hidden;
}
#dw3_opt_form .dw3_form_data{
    background: rgba(255, 255, 255, 0.9);
    background-image: url('/pub/img/dw3/flowers.gif');
    background-repeat: no-repeat;
    background-position: left bottom;
}

#dw3_filter_form{
    display:none;
    z-index:300;
    position: fixed;
    width:305px;
    top: 50%;
    left: 50%;
    -moz-transform: translateX(-50%) translateY(-50%);
    -webkit-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
    text-align:left;
    padding:10px;
    border-radius: var(--dw3_form_radius);
    border: 1px solid darkgrey;
    background:  var(--dw3_form_background);
    color:  var(--dw3_form_color);
    transition: all 1s;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
}

#dw3_map_form{
    display:none;
    z-index:150;
    position: fixed;
    width:75%;
    top: 5px;
    left: 50%;
    -moz-transform: translateX(-50%);
    -webkit-transform: translateX(-50%) ;
    transform: translateX(-50%) ;
    background:  var(--dw3_form_background);
    text-align:center;
    padding:5px;
    border-radius: var(--dw3_form_radius);;
    border: 1px solid darkgrey;
    color: black;
    transition: all 1s;
    overflow-x: hidden;
    overflow-y: auto;
    max-height: 95%;
}
.dw3_form{
    z-index:1099;
    display:none;
    position: fixed;
    width:95%;
    min-width:250px;
    max-width:750px;
    left: 50%;
    top:2%;
    min-height:90%;
    max-height:95%;
    transform: translateX(-50%);
    text-align:center;
    padding:0px;
    border-radius: var(--dw3_form_radius);
    border: 1px solid darkgrey;
    background: var(--dw3_form_background);
    color: var(--dw3_form_color);
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
    overflow-x:hidden;
    overflow-y:hidden;
    font-family:  var(--dw3_body_font);
    line-height: 1;
}
.dw3_form_cancel{
    background:#444;
}
.dw3_form_close{
    z-index:+1;
    background:#444;
    top:0px;
    right:0px;
    padding:7px 6px 8px 6px;
    text-align:center;
    margin:3px;
    position:absolute;
    color:rgba(255,255,255,0.7);
    border-radius: 1em;
    box-shadow:none;
    font-size:18px;
}
.dw3_form_delete{
    background:red;
}
.dw3_form_data{
    position:absolute;
    top:40px;
    left:0px;
    bottom:30px;
    right:0px;
    overflow-x:hidden; 
    overflow-y:auto;
    line-height: 1;
    padding-bottom:30px;
}
.dw3_form_foot{
    position: absolute;
    bottom:0px;
    left:0px;
    right:0px;
    min-height:30px;
    background: var(--dw3_head_background);
    color: var(--dw3_head_color);
    border-bottom-right-radius:15px;
    border-bottom-left-radius:15px;
    overflow:hidden;
}
.dw3_form_head{
    cursor:move;
    position:absolute;
    top:0px;
    right:0px;
    left:0px;
    height:40px;
    background:var(--dw3_head_background);
    color: var(--dw3_head_color);        
    border-top-right-radius:var(--dw3_form_radius);
    border-top-left-radius:var(--dw3_form_radius);
}
.dw3_quiz{
    z-index:1098;
    display:none;
    position: fixed;
    width:95%;
    min-width:250px;
    max-width:750px;
    left: 50%;
    top:2%;
    min-height:90%;
    max-height:95%;
    transform: translateX(-50%);
    text-align:center;
    padding:0px;
    border-radius: var(--dw3_form_radius);
    border: 1px solid darkgrey;
    background: var(--dw3_form_background);
    color: var(--dw3_form_color);
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
    overflow-x:hidden;
    overflow-y:hidden;
    font-family:  var(--dw3_form_font);
    line-height: 1;
}
.dw3_quiz_cancel{
    background:#444;
}
.dw3_quiz_close{
    background:#444;
    top:0px;
    right:0px;
    padding:7px;
    margin:3px;
    position:absolute;
    color:rgba(255,255,255,0.7);
    border-radius: 17px;
    box-shadow:none;
}
.dw3_quiz_delete{
    background:red;
}
.dw3_quiz_data{
    position:absolute;
    top:0px;
    left:0px;
    bottom:0px;
    right:0px;
    overflow-x:hidden; 
    overflow-y:auto;
    line-height: 1;
}
.dw3_quiz_foot{
    width:100%;
    max-width:100%;
    min-height:45px;
    background: var(--dw3_head_background);
    color: var(--dw3_head_color);
    overflow:hidden;
}
.dw3_quiz_head{
    cursor:move;
    position:absolute;
    top:0px;
    right:0px;
    left:0px;
    height:40px;
    background: #1d2e5a;
    color: var(--dw3_head_color);        

}

  /*+-------------------------------------------------------------------------------+ 
  |                                                                                 |
  |                                      TABLES                                     |
  |                                                                                 |
  +---------------------------------------------------------------------------------+*/
.dw3_row_popup{
    display:none;
    opacity:0;
    z-index:150;
    position: fixed;
    top: 55px;
    right:60px;
    height:auto;
    width:auto;
    color:black;
    font-size: 14px;
    background: rgba(255, 255, 255, 0.8);
    text-align:right;
    vertical-align:middle;
    padding: 5px ;
    border-radius: var(--dw3_button_radius);
    border: 0px solid darkgrey;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    transition: all 1s;
}
  .tblINPUT{
    border-radius:10px;
    border:1px solid white;
    background: var(--dw3_form_background);
    width:100%;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}
.selectList{ width:100%; }
.searchINPUT{
    background-image: url('/pub/img/dw3/searchicon.png');
    background-position: 10px 10px;
    background-repeat: no-repeat;
    width: 100%;
    padding: 12px 20px 12px 40px;
    border: 1px solid #eee;
    margin-bottom: 12px;
}
.tblDATA {
    width:100%;
    margin:0px;
    background: rgba(255, 255, 255, 0.1);
    white-space:nowrap;
    border-collapse: collapse;
    font-family:  var(--dw3_form_font);
    line-height: 1;
}
.tblDATA td{
    text-align:left;
    border: 1px solid #ddd;
    padding: 8px;
    color: var(--dw3_line_color);
    overflow:hidden;
}
.tblDATA th{
    text-align:left;
    padding: 12px 8px 6px 8px;
    user-select:none;	
    background: linear-gradient(180deg, var(--dw3_head_background), var(--dw3_head_background2));
    color:  var(--dw3_head_color);
    position: sticky;
    vertical-align:top;
    top: 0; /* Don't forget this, required for the stickiness */
    /* box-shadow: 0 2px 2px 1px rgba(0, 0, 0, 0.4); */
    /* text-shadow: 0px 0px 2px #222; */
}
.tblDATA tr:nth-child(even){background-color: var(--dw3_line_background);}
.tblDATA tr:nth-child(odd){background-color: var(--dw3_line_background2);}
/* .tblDATA tr:first-child{border-top-left-radius: 10px;border-top-right-radius: 10px;border-left:1px solid  var(--dw3_head_background);} */
.tblDATA tr:first-child{border-top-left-radius: 10px;border-top-right-radius: 10px;}
.tblDATA2 {
    width:100%;
    table-layout: fixed;
    margin:0px;
    background: rgba(255, 255, 255, 0.1);
    border-collapse: collapse;
    font-family:  var(--dw3_form_font);
    line-height: 1;
    border-top-left-radius: 10px;border-top-right-radius: 10px;
    border-style: hidden;
    font-size:18px;
    max-width:100%;
}
.tblDATA2 td{
    text-align:left;
    border: 0px solid #ddd;
    padding: 8px;
    color: var(--dw3_line_color);
    word-wrap:break-word;
    white-space: normal;
}
.tblDATA2 th{
    text-align:left;
    padding: 12px 8px 6px 8px;
    user-select:none;	
    background: linear-gradient(180deg, var(--dw3_head_background), var(--dw3_head_background2));
    color:  var(--dw3_head_color);
}
.tblDATA2 tr:nth-child(even){background-color: var(--dw3_line_background);}
.tblDATA2 tr:nth-child(odd){background-color: var(--dw3_line_background2);}
.tblDATA tr:first-child{border-top-left-radius: 10px;border-top-right-radius: 10px;}
.tblDATA tr:first-child td:first-child{border-top-left-radius: 10px;}
.tblDATA tr:first-child td:last-child{border-top-right-radius: 10px;}
.odd{background-color: white;} 
.even{background-color: lightgrey;} 
.selected_cell{ border: 1pt solid blue;background-color: rgba(102, 198, 221, 0.35);}
.short{ /*  to limit cell size  */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.tblSIMPLE {border-collapse: collapse;width:100%;text-align:left;margin-left:auto;margin-right:auto;}
.tblSIMPLE td, th {padding: 7px}

.tblSIMPLE2 {border-collapse: collapse;width:100%;text-align:left;margin-left:auto;margin-right:auto;}
.tblSIMPLE2 td, th {padding: 7px;}
.tblSIMPLE2 tr:nth-child(even){background-color: var(--dw3_line_background);}
.tblSIMPLE2 tr:nth-child(odd){background-color: var(--dw3_line_background2);}

.inputRECH:focus {box-shadow:1px 1px 3px 2px var(--dw3_selected_border);}
.hoverShadow:hover{box-shadow:0px 0px 3px 2px var(--dw3_selected_border);}
.tblAD {
  font-family: var(--dw3_form_font);
  width: 100%;
  border: none;
  border-collapse: collapse;
  line-height:1em;
  margin:5px 0px;
  box-shadow:2px 2px 4px 2px lightgrey;
  border-radius:15px;
}

.tblAD td {
  padding: 8px;
  background-color: #fff;
  cursor:pointer;
}

.tblAD tr:nth-child(even) td:first-child {
  border-radius: 15px 0 0 15px;
}
.tblAD tr:nth-child(even) td:last-child {
  border-radius: 0 0 15px 15px;
}
.tblAD tr:nth-child(odd) td:first-child {
  border-radius: 15px 0 0 0;
}
.tblAD tr:nth-child(odd) td:last-child {
  border-radius: 0 15px 0 0;
}

.tblSEL {
    width:100%;
    margin:0px;
    background: rgba(255, 255, 255, 0.1);
    white-space:nowrap;
    border-collapse: collapse;
    font-family:  var(--dw3_form_font);
    line-height: 1;
}
.tblSEL td{
    text-align:left;
    border: 1px solid #ddd;
    padding: 8px;
    user-select:none;
    color: var(--dw3_line_color);
    cursor:pointer;
    overflow:hidden;
}
.tblSEL th{
    text-align:left;
    padding: 12px 8px 6px 8px;
    user-select:none;	
    background: linear-gradient(180deg, var(--dw3_head_background), var(--dw3_head_background2));
    color:  var(--dw3_head_color);
    position: sticky;
    vertical-align:top;
    top: 0; /* Don't forget this, required for the stickiness */
    box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    /* text-shadow: -1px 1px #222; */
}
.tblSEL tr:nth-child(even){background-color: #f2f2f2;}
.tblSEL tr:nth-child(odd){background-color: lightgrey;}
.tblSEL tr:first-child{border-top-left-radius: 10px;border-top-right-radius: 10px;border-left:1px solid  var(--dw3_form_color);}
.tblSEL tr:hover {background-color: #B2DDE7;}
.tblSEL2 {
    width:100%;
    margin:0px;
    background: rgba(255, 255, 255, 0.1);
    max-width:100%;
    white-space:normal;
    border:0px;
    border-collapse: collapse;
    font-family:  var(--dw3_form_font);
    line-height: 1;
}
.tblSEL2 tr{
    border-bottom: 1px solid #ddd;
}
.tblSEL2 td{
    text-align:left;
    border: 0px solid #ddd;
    padding: 8px;
    user-select:none;
    color: var(--dw3_line_color);
    cursor:pointer;
    overflow:hidden;
}
.tblSEL2 th{
    text-align:left;
    overflow:hidden;
    padding: 12px 8px 6px 8px;
    user-select:none;	
    background: linear-gradient(180deg, var(--dw3_form_color), var(--dw3_form_color), var(--dw3_form_color), var(--dw3_form_color), var(--dw3_form_color), var(--dw3_form_color));
    color:  var(--dw3_form_color);
    cursor:n-resize;
    position: sticky;
    top: 0; /* Don't forget this, required for the stickiness */
    box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    /* text-shadow: -1px 1px #222; */
}
.tblSEL2 tr:first-child{border-top-left-radius: 10px;border-top-right-radius: 10px;}
.tblSEL2 tr:hover {background-color: lightgrey;}
.tblCAL {
    width:100%;
    max-width:1080px;
    margin:0px;
    background: rgba(255, 255, 255, 0.1);
    white-space:nowrap;
    border-collapse: collapse;
    font-family:  var(--dw3_form_font);
    margin-right:auto;
    margin-left:auto;
    line-height: 1;
}
.tblCAL tbody tr{
    height:50px;
}
.tblCAL td{
    vertical-align:top;
    text-align:left;
    border: 0px solid #ddd;
    padding: 0px;
    user-select:none;
    color: #333333;
    box-shadow: inset 0 2px 2px -1px rgba(0, 0, 0, 0.4);
 }
.tblCAL th{
    text-align:left;
    padding: 3px 0px 3px 4px;
    user-select:none;	
    background: var(--dw3_form_background);
    color:  var(--dw3_form_color);
    position: sticky;
    top: 0; /* Don't forget this, required for the stickiness */
    box-shadow: inset 0px 0px 2px -1px rgba(0, 0, 0, 0.4);
    /* text-shadow: -1px 1px #222; */
    border:0px;
}
.tblCAL tr:nth-child(even){background-color: #f2f2f2;}
.tblCAL tr:nth-child(odd){background-color: lightgrey;}
.tblCAL tr:first-child{border-top-left-radius: 10px;border-top-right-radius: 10px;border-left:0px solid  var(--dw3_form_color);}
.tblCAL tr td:hover {background-color: #B2DDE7;}
.tblCAL2 {
    width:100%;
    max-width:1080px;
    margin:0px;
    white-space:nowrap;
    border-collapse: collapse;
    font-family:  var(--dw3_form_font);
    margin-right:auto;
    margin-left:auto;
    line-height: 1;
}
.tblCAL2 tbody tr{
    height:50px;
}
.tblCAL2 td{
    vertical-align:top;
    text-align:center;
    text-align:left;
    border: 0px solid #ddd;
    padding: 0px;
    user-select:none;
    color: #333333;
    box-shadow: inset 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    background-color: rgba(0,0,0,0.5);
    -webkit-transition: .6s;
    transition: .6s;
    word-wrap: break-word;
    white-space: normal;
 }
.tblCAL2 th{
    text-align:left;
    padding: 3px 0px 3px 4px;
    user-select:none;	
    background: var(--dw3_form_background);
    color:  var(--dw3_form_color);
    position: sticky;
    z-index:100;
    top: 0; /* Don't forget this, required for the stickiness */
    box-shadow: inset 0px 0px 2px -1px rgba(0, 0, 0, 0.4);
    /* text-shadow: -1px 1px #222; */
    border:0px;
}
.tblCAL2 tr td:hover {background-color: #efefef;}
.tblMESSAGE{
    width:100%;
    margin:0px;
    background: rgba(255, 255, 255, 0.1);
    white-space:nowrap;
    border-collapse: collapse;text-align: left;  
    line-height: 1;
}
.tblMESSAGE th{
    text-align:left;
    border: 1px solid #ddd;
    padding: 8px;
    cursor:n-resize;
    user-select:none;
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background:  var(--dw3_form_background);
    color:  var(--dw3_form_color);
}
.bordered{
    border-bottom: 1px solid  var(--dw3_form_background);
    border-radius:15px;
}

  /*+-------------------------------------------------------------------------------+ 
  |                                                                                 |
  |                                    ANIMATIONS                                   |
  |                                                                                 |
  +---------------------------------------------------------------------------------+*/
    .dw3_rotate_infinite{
        -webkit-animation:spin 36s linear infinite;
        -moz-animation:spin 36s linear infinite;
        animation:spin 36s linear infinite;
    }
    @-webkit-keyframes spin {
        0%  {-webkit-transform: rotate(0deg);}
        100% {-webkit-transform: rotate(360deg);}   
    }

    .dw3_pan_infinite{
        -webkit-animation:pan 15s linear infinite;
        -moz-animation:pan 15s linear infinite;
        animation:pan 15s linear infinite;
    }
    @-webkit-keyframes pan {
        0%  {background-position:0%;}
        50% {background-position:100%;}   
        100% {background-position:0%;}   
    }

    .dw3_unzoom{
        -webkit-animation:unzoom 15s linear ;
        -moz-animation:unzoom 15s linear ;
        animation:unzoom 15s linear ;
    }
    @-webkit-keyframes unzoom {
        0% {background-size:auto 180%;}   
        100% {background-size:auto 100%;}   
    }
    .dw3_unzoom2{
        -webkit-animation:unzoom2 15s linear ;
        -moz-animation:unzoom2 15s linear ;
        animation:unzoom2 15s linear ;
    }
    @-webkit-keyframes unzoom2 {
        0% {background-size:180% auto;}   
        100% {background-size:100% auto;}   
    }

    .dw3_zoom_infinite{
        -webkit-animation:zoom 15s linear infinite;
        -moz-animation:zoom 15s linear infinite;
        animation:zoom 15s linear infinite;
    }
    @-webkit-keyframes zoom {
        0%  {background-size:auto 100%;}
        50% {background-size:auto 150%;}   
        100% {background-size:auto 100%;}   
    }

    .dw3_zoom2_infinite{
        -webkit-animation:zoom2 15s linear infinite;
        -moz-animation:zoom2 15s linear infinite;
        animation:zoom2 15s linear infinite;
    }
    @-webkit-keyframes zoom2 {
        0%  {background-size:100% auto;}
        50% {background-size:150% auto;}   
        100% {background-size:100% auto;}   
    }
 
/*--------------------------------------------------- */
/*- CSS SANDBOX ------------------------------------- */
/*--------------------------------------------------- */

/* google maps */
/* remove active blue border */
.gm-style iframe + div { border:none!important; }

    /*--checkbox to switch----------------------------- */
        .switch{
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        vertical-align:middle;
        }

        .switch input{ 
        opacity: 0;
        width: 0;
        height: 0;
        }

        .slider{
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .6s;
        transition: .6s;
        }

        .slider:before{
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .6s;
        transition: .6s;
        }
        input:checked + .slider{
        background-color: #2196F3;
        }

        input:focus + .slider{
        box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before{
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
        }

        .slider.round{
        border-radius: 34px;
        }

        .slider.round:before{
        border-radius: 50%;
        }

        /*--slideshow4-------------------------- */         

        #slideshow4-container {
          position: relative;
          width: 100%; 
          height: 100%;
          min-height:350px;
          overflow:hidden;
        }

        #slideshow4-container img {
          position: absolute;
          top: 50%;
          left: 0;
          width: 100%;
          height: auto;
          object-fit: cover; 
          opacity: 0;
          transition: opacity 1.5s ease-in-out; 
          -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            transform: translateY(-50%);
        }

        #slideshow4-container img.active {
          opacity: 1;
        }


        /*--image galery slide-------------------------- */         
          .slider-wrapper {
            margin: 0;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
          }
          
          .slides-container {
            /*--height: calc(100vh - 2rem);------------ */ 
            height:auto;
            width: 100%;
            display: flex;
            overflow: hidden;
            scroll-behavior: smooth;
            list-style: none;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-align:center;
            max-height:100vh;
          }
/*           .slide_text{
            z-index:+1;position: absolute;top: 180px;left:0; mix-blend-mode: difference;     
          } */
          .slide-arrow {
            position: absolute;
            display: flex;
            overflow:hidden;
            top: 0;
            bottom: 0;
            margin: auto;
            height: 48px;
            background:rgba(0,0,0,0.8);
            color: #eee;
            border: none;
            width: 32px;
            font-size: 32px;
            font-family:Roboto;
            padding: 0px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 100ms;
            box-sizing: border-box;
          }
          
          .slide-arrow:hover,
          .slide-arrow:focus {
            opacity: 1;
          }
          
          #slide-arrow-prev {
            left: 0;
            padding-left: 8px;
            padding-top: 5px;
            border-radius: 0 48px 48px 0;
            box-sizing: border-box;
            font-family:Roboto;
          }
          
          #slide-arrow-next {
            right: 0;
            padding-left: 12px;
            padding-top: 5px;
            border-radius: 48px 0 0 48px;
            box-sizing: border-box;
            font-family:Roboto;
          }

          /* pour le slide des Affilies */
          #slide-arrow-prevA {
            left: 0;
            padding-left: 8px;
            padding-top: 5px;
            border-radius: 0 48px 48px 0;
            box-sizing: border-box;
            font-family:Roboto;
          }
          
          #slide-arrow-nextA {
            right: 0;
            padding-left: 12px;
            padding-top: 5px;
            border-radius: 48px 0 0 48px;
            box-sizing: border-box;
            font-family:Roboto;
          }
          
          .slide {
            width: 100%;
            height: 100%;
            flex: 1 0 100%;
            box-sizing: border-box;
          }
          
          .slide:nth-child(1) {
            background-image: linear-gradient(to bottom right, red, yellow);
          }
          .slide:nth-child(2) {
            background-image: linear-gradient(to right, gold,green, blue);
          }
          .slide:nth-child(3) {
            background-image: linear-gradient(to top right,blue, green, blue);
          }
          .slide:nth-child(4) {
            background-image: linear-gradient(to bottom right, purple, blue);
          }
          .slide:nth-child(5) {
            background-image: conic-gradient(red, yellow, green, blue, black);
          }
          .slide:nth-child(6) {
            background-image: conic-gradient(from 90deg, red, yellow, green);
          }
          .slide:nth-child(7) {
            background-image: conic-gradient(from 270deg, green, yellow, red);
          }
          .slide:nth-child(8) {
            background-image: linear-gradient(red, yellow);
          }
          .slide:nth-child(9) {
            background-image: linear-gradient(red, yellow, green);
          }
          .slide:nth-child(10) {
            background-image: linear-gradient(to bottom right, red, yellow);
          }
          .slide:nth-child(11) {
            background-image: linear-gradient(to right, rgba(255,0,0,0), rgba(255,0,0,1));
          }
          .slide:nth-child(12) {
            background-image: repeating-linear-gradient(red, yellow 10%, green 20%);
          }
          .slide:nth-child(13) {
            background-image: radial-gradient(red 5%, yellow 15%, orange 60%);
          }

          .slideA {
            width: 100%;
            height: 100%;
            flex: 1 0 100%;
            box-sizing: border-box;
          }

          .yt_container {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%;
        }
        .yt_video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }


          #opt_video {
            border: 1px solid black;
            box-shadow: 2px 2px 3px black;
            width: 320px;
            height: 240px;
          }
          
          #opt_photo {
            border: 1px solid black;
            box-shadow: 1px 1px 2px #233;
            width: 320px;
            height: auto;
          }
          
          #opt_canvas {
            display: none;
          }
          
          #opt_camera {
            width: 340px;
            display: none;
          }
          
          #opt_output {
            width: 340px;
            display: inline-block;
            vertical-align: top;
          }
          
          #opt_startbutton:hover {text-shadow: -1px 1px gold;border: 1px solid rgba(255, 255, 255, 1);}
          #opt_startbutton {
            display: block;
            position: relative;
            margin-left: auto;
            margin-right: auto;
            bottom: 32px;
            background-color: rgba(0, 150, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0px 0px 1px 2px rgba(0, 0, 0, 0.2);
            font-size: 14px;
            font-family: "Roboto";
            color: rgba(255, 255, 255, 1);
          }
          
          .opt_contentarea {
            font-size: 16px;
            font-family: "Roboto";
            width: 760px;
          }




/* spinner/processing state, errors */
.spinner,
.spinner:before,
.spinner:after {
  border-radius: 50%;
}
.spinner {
  color: #ffffff;
  font-size: 22px;
  text-indent: -99999px;
  margin: 0px auto;
  position: relative;
  width: 20px;
  height: 20px;
  box-shadow: inset 0 0 0 2px;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
.spinner:before,
.spinner:after {
  position: absolute;
  content: "";
}
.spinner:before {
  width: 10.4px;
  height: 20.4px;
  background: #30d14d;
  border-radius: 20.4px 0 0 20.4px;
  top: -0.2px;
  left: -0.2px;
  -webkit-transform-origin: 10.4px 10.2px;
  transform-origin: 10.4px 10.2px;
  -webkit-animation: loading 2s infinite ease 1.5s;
  animation: loading 2s infinite ease 1.5s;
}
.spinner:after {
  width: 10.4px;
  height: 10.2px;
  background: #30d14d;
  border-radius: 0 10.2px 10.2px 0;
  top: -0.1px;
  left: 10.2px;
  -webkit-transform-origin: 0px 10.2px;
  transform-origin: 0px 10.2px;
  -webkit-animation: loading 2s infinite ease;
  animation: loading 2s infinite ease;
}

@-webkit-keyframes loading {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes loading {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

/*- TIMELINES -*/
.cd-horizontal-timeline {
    opacity: 0;
    margin: 0px;
    padding-bottom:40px;
    -webkit-transition: opacity 0.2s;
    -moz-transition: opacity 0.2s;
    transition: opacity 0.2s;
    background-color:#000;color:#FFF;
    line-height:1;
  }
  .cd-horizontal-timeline::before {
    /* never visible - this is used in jQuery to check the current MQ */
    content: 'mobile';
    display: none;
  }
  .cd-horizontal-timeline.loaded {
    /* show the timeline after events position has been set (using JavaScript) */
    opacity: 1;
  }
  .cd-horizontal-timeline .timeline {
    position: relative;
    height: 100px;
    width: 90%;
    max-width: 1000px;
    margin: 0 auto;
  }
  .cd-horizontal-timeline .events-wrapper {
    position: relative;
    height: 100%;
    margin: 0 40px;
    overflow: hidden;
  }
  .cd-horizontal-timeline .events-wrapper::after, .cd-horizontal-timeline .events-wrapper::before {
    /* these are used to create a shadow effect at the sides of the timeline */
    content: '';
    position: absolute;
    z-index: 2;
    top: 0;
    height: 100%;
    width: 20px;
  }
  .cd-horizontal-timeline .events-wrapper::before {
    left: 0;

  }
  .cd-horizontal-timeline .events-wrapper::after {
    right: 0;

  }
  .cd-horizontal-timeline .events {
    /* this is the grey line/timeline */
    position: absolute;
    z-index: 1;
    left: 0;
    top: 49px;
    height: 2px;
    /* width will be set using JavaScript */
    background: #dfdfdf;
    -webkit-transition: -webkit-transform 0.4s;
    -moz-transition: -moz-transform 0.4s;
    transition: transform 0.4s;
  }
  .cd-horizontal-timeline .filling-line {
    /* this is used to create the green line filling the timeline */
    position: absolute;
    z-index: 1;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    background-color: #f17144;
    -webkit-transform: scaleX(0);
    -moz-transform: scaleX(0);
    -ms-transform: scaleX(0);
    -o-transform: scaleX(0);
    transform: scaleX(0);
    -webkit-transform-origin: left center;
    -moz-transform-origin: left center;
    -ms-transform-origin: left center;
    -o-transform-origin: left center;
    transform-origin: left center;
    -webkit-transition: -webkit-transform 0.3s;
    -moz-transition: -moz-transform 0.3s;
    transition: transform 0.3s;
  }
  .cd-horizontal-timeline .events a:hover {
    text-decoration:none;color:#fff;
  }
  .cd-horizontal-timeline .events a {
    position: absolute;
    bottom: 0;
    z-index: 2;
    text-align: center;
    font-size: 1.1rem;
    padding-bottom: 15px;
    color: #f17144;
    /* fix bug on Safari - text flickering while timeline translates */
    -webkit-transform: translateZ(0);
    -moz-transform: translateZ(0);
    -ms-transform: translateZ(0);
    -o-transform: translateZ(0);
    transform: translateZ(0);
  }
  .cd-horizontal-timeline .events a::after {
    /* this is used to create the event spot */
    content: '';
    position: absolute;
    left: 50%;
    right: auto;
    -webkit-transform: translateX(-50%);
    -moz-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    -o-transform: translateX(-50%);
    transform: translateX(-50%);
    bottom: -8px;
    height: 14px;
    width: 14px;
    border-radius: 50%;
    border: 2px solid #dfdfdf;
    background-color: #f8f8f8;
    -webkit-transition: background-color 0.3s, border-color 0.3s;
    -moz-transition: background-color 0.3s, border-color 0.3s;
    transition: background-color 0.3s, border-color 0.3s;
  }
  .no-touch .cd-horizontal-timeline .events a:hover::after {
    background-color: #7b9d6f;
    border-color: #7b9d6f;
  }
  .cd-horizontal-timeline .events a.selected {
    pointer-events: none;
  }
  .cd-horizontal-timeline .events a.selected::after {
    background-color: #f17144;
    border-color: #f17144;
  }
  .cd-horizontal-timeline .events a.older-event::after {
    border-color: #f17144;
  }
  @media only screen and (min-width: 1100px) {

    .cd-horizontal-timeline::before {
      /* never visible - this is used in jQuery to check the current MQ */
      content: 'desktop';
    }
  }
  
  .cd-timeline-navigation a {
    /* these are the left/right arrows to navigate the timeline */
    position: absolute;
    z-index: 1;
    line-height:1;
    top: 51%;
    bottom: auto;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
    height: 34px;
    width: 34px;
    border-radius: 50%;
    border: 2px solid #dfdfdf;
    /* replace text with an icon */
    overflow: hidden;
    color: transparent;
    text-indent: 100%;
    white-space: nowrap;
    -webkit-transition: border-color 0.3s;
    -moz-transition: border-color 0.3s;
    transition: border-color 0.3s;
  }
  .cd-timeline-navigation a::after {
    /* arrow icon */
    content: '';
    position: absolute;
    height: 16px;
    width: 16px;
    left: 50%;
    top: 51%;
    bottom: auto;
    right: auto;
    -webkit-transform: translateX(-50%) translateY(-50%);
    -moz-transform: translateX(-50%) translateY(-50%);
    -ms-transform: translateX(-50%) translateY(-50%);
    -o-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
  }
  .cd-timeline-navigation a.prev {
    left: 2px;
  }
  .cd-timeline-navigation a.next {
    right: 1px;
  }
  .no-touch .cd-timeline-navigation a:hover {
    border-color: #7b9d6f;
  }
  .cd-timeline-navigation a.inactive {
    cursor: not-allowed;
  }
  .cd-timeline-navigation a.inactive::after {
    background-position: 0 -16px;
  }
  .no-touch .cd-timeline-navigation a.inactive:hover {
    border-color: #dfdfdf;
  }
  
  .cd-horizontal-timeline .events-content {
    position: relative;
    width: 100%;
    margin: 1em 0;
    overflow: hidden;
    -webkit-transition: height 0.4s;
    -moz-transition: height 0.4s;
    transition: height 0.4s;
    color:#333;line-height:2em;
  }
  .cd-horizontal-timeline .events-content li {
    position: absolute;
    z-index: 1;
    width: 100%;
    left: 0;
    top: 0;
    -webkit-transform: translateX(-100%);
    -moz-transform: translateX(-100%);
    -ms-transform: translateX(-100%);
    -o-transform: translateX(-100%);
    transform: translateX(-100%);
    padding: 0;
    opacity: 0;
    transition: height 0.4s;
    -webkit-animation-duration: 0.4s;
    -moz-animation-duration: 0.4s;
    animation-duration: 0.4s;
    -webkit-animation-timing-function: ease-in-out;
    -moz-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out;
  }
  .cd-horizontal-timeline .events-content li.selected {
    /* visible event content */
    position: relative;
    z-index: 2;
    opacity: 1;
    -webkit-transform: translateX(0);
    -moz-transform: translateX(0);
    -ms-transform: translateX(0);
    -o-transform: translateX(0);
    transform: translateX(0);
  }
  .cd-horizontal-timeline .events-content li.enter-right, .cd-horizontal-timeline .events-content li.leave-right {
    -webkit-animation-name: cd-enter-right;
    -moz-animation-name: cd-enter-right;
    animation-name: cd-enter-right;
  }
  .cd-horizontal-timeline .events-content li.enter-left, .cd-horizontal-timeline .events-content li.leave-left {
    -webkit-animation-name: cd-enter-left;
    -moz-animation-name: cd-enter-left;
    animation-name: cd-enter-left;
  }
  .cd-horizontal-timeline .events-content li.leave-right, .cd-horizontal-timeline .events-content li.leave-left {
    -webkit-animation-direction: reverse;
    -moz-animation-direction: reverse;
    animation-direction: reverse;
  }
  .cd-horizontal-timeline .events-content li > * {
    max-width: 1000px;
    margin: 0 auto;
  }
  .cd-horizontal-timeline .events-content h2 {
    font-weight: bold;
    font-size: 2.6rem;
    font-family: "Roboto";
    font-weight: 700;
    line-height: 1.2;
  }
  .cd-horizontal-timeline .events-content em {
    display: block;
    font-style: italic;
    margin: 10px auto;
  }
  .cd-horizontal-timeline .events-content em::before {
    content: '- ';
  }
  .cd-horizontal-timeline .events-content p {
    font-size:18px;
    color: #959595;
  }
  .cd-horizontal-timeline .events-content em, .cd-horizontal-timeline .events-content p {
    line-height: 1.6;
  }
  @media only screen and (min-width: 768px) {
    .cd-horizontal-timeline .events-content h2 {
      font-size: 7rem;
    }
    .cd-horizontal-timeline .events-content em {
      font-size: 2rem;
    }

  }

  .timeline2{-webkit-box-sizing:border-box;box-sizing:border-box;position:relative;min-height:300px;}
  .timeline2 *,.timeline :after,.timeline :before{-webkit-box-sizing:inherit;box-sizing:inherit}
  .timeline2:not(.timeline--horizontal):before{background-color:#ddd;bottom:0;content:'';left:50%;margin-left:-2px;position:absolute;top:0;width:4px;z-index:1}
  .timeline__wrap{overflow:hidden;position:relative;z-index:2;min-height:350px;}
  .timeline__item{font-size:15px;padding:.425rem 2.5rem .425rem 0;position:relative;width:50%;z-index:2;}
  .timeline__item:after{background-color:#f17144;border:0px solid #ddd;border-radius:50%;content:'';height:20px;position:absolute;right:-10px;-webkit-transform:translateY(-50%);-ms-transform:translateY(-50%);transform:translateY(-50%);top:50%;width:20px;z-index:1}
  .timeline__item.animated{-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both;opacity:0}
  .timeline__item.fadeIn{-webkit-animation-name:fadeIn;animation-name:fadeIn}
  .timeline__item--left{left:0}
  .timeline__item--right{left:50%;padding:.425rem 0 .425rem 2.5rem}
  .timeline__item--right:after{left:-10px}
  .timeline__item--right .timeline__content:before{border-bottom:10px solid transparent;border-right:12px solid #ccc;border-left:none;border-top:10px solid transparent;left:-12px}
  .timeline__item--right .timeline__content:after{border-bottom:9px solid transparent;border-right:11px solid #fff;border-left:none;border-top:9px solid transparent;left:-10px}
  .timeline__content{border:1px solid #e16144;color:#fff;background-color:#f17144;display:block;padding:1.25rem 0;position:relative;margin:0px 15px 0px 15px;white-space:nowrap;}
  .timeline__content:after,.timeline__content:before{content:'';height:0;position:absolute;-webkit-transform:translateY(-50%);-ms-transform:translateY(-50%);transform:translateY(-50%);top:50%;width:0;}
  .timeline__content:before{border-bottom:10px solid transparent;border-left:12px solid #ccc;border-top:10px solid transparent;right:-12px;z-index:1;}
  .timeline__content:after{border-bottom:9px solid transparent;border-left:11px solid #fff;border-top:9px solid transparent;right:-10px;z-index:2;}
  .timeline__content h2{font-size:1.25rem;font-weight:700;margin:0 0 .425rem}
  .timeline__content p{font-size:.9375rem;line-height:1.5;margin-bottom:10px}
  .timeline--horizontal{font-size:0;padding:0 3.125rem;overflow:hidden;white-space:nowrap}
  .timeline--horizontal .timeline-divider{background-color:#ddd;display:block;height:4px;left:40px;position:absolute;-webkit-transform:translateY(-50%);-ms-transform:translateY(-50%);transform:translateY(-50%);right:40px;z-index:1}
  .timeline--horizontal .timeline__items{-webkit-transition:all .8s;-o-transition:all .8s;transition:all .8s;will-change:transform}
  .timeline--horizontal .timeline__item{display:inline-block;left:0;padding:0 0 2.5rem;position:relative;-webkit-transition:none;-o-transition:none;transition:none;vertical-align:top;white-space:normal}
  .timeline--horizontal .timeline__item:after{left:50%;right:auto;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%);top:100%}
  .timeline--horizontal .timeline__item .timeline__item__inner{display:table;height:100%;width:100%}
  .timeline--horizontal .timeline__item .timeline__content__wrap{display:table-cell;margin:0;padding:0;vertical-align:bottom;}
  .timeline--horizontal .timeline__item .timeline__content:before{border-left:12px solid transparent;border-right:12px solid transparent;border-top:12px solid #f17144;left:50%;right:auto;-webkit-transform:translateX(-50%);-ms-transform:translateX(-50%);transform:translateX(-50%);top:100%}
  .timeline--horizontal .timeline__item .timeline__content:after{border-left:10px solid transparent;border-right:10px solid transparent;border-top:10px solid #f17144;left:50%;right:auto;-webkit-transform:translateX(-50%);-ms-transform:translateX(-50%);transform:translateX(-50%);top:100%}
  .timeline--horizontal .timeline__item--bottom{padding:2.5rem 0 0;}
  .timeline--horizontal .timeline__item--bottom:after{top:0;}
  .timeline--horizontal .timeline__item--bottom .timeline__content__wrap{vertical-align:top;}
  .timeline--horizontal .timeline__item--bottom .timeline__content:before{border-bottom:12px solid #f17144;border-left:12px solid transparent;border-right:12px solid transparent;border-top:none;bottom:100%;top:auto}
  .timeline--horizontal .timeline__item--bottom .timeline__content:after{border-bottom:10px solid #f17144;border-left:10px solid transparent;border-right:10px solid transparent;border-top:none;bottom:100%;top:auto}
  .timeline-nav-button{background-color:#fff;border:2px solid #ddd;border-radius:50px;-webkit-box-sizing:border-box;box-sizing:border-box;-webkit-box-shadow:none;box-shadow:none;cursor:pointer;display:block;height:40px;outline:0;position:absolute;text-indent:-9999px;top:80px;width:40px;z-index:10}
  .timeline-nav-button:disabled{opacity:.5;pointer-events:none}
  .timeline-nav-button:before{background-position:center center;background-repeat:no-repeat;content:'';display:block;height:14px;left:50%;position:absolute;-webkit-transform:translateX(-50%) translateY(-50%);-ms-transform:translateX(-50%) translateY(-50%);transform:translateX(-50%) translateY(-50%);top:50%;width:8px}
  .timeline-nav-button--prev{left:0}.timeline-nav-button--prev:before{background-image:url(/pub/img/dw3/arrow_left.png);background-repeat: no-repeat;background-size: 9px 14px;background-position: top;}
  .timeline-nav-button--next{right:0}.timeline-nav-button--next:before{background-image:url(/pub/img/dw3/arrow_right.png);background-repeat: no-repeat;background-size: 9px 14px;background-position: top;}
  .timeline--mobile{padding:0}.timeline--mobile:before{left:10px!important;margin:0!important}
  .timeline--mobile .timeline__item{left:0;padding-left:40px;padding-right:0;width:100%}
  .timeline--mobile .timeline__item:after{left:2px;margin:0}
  .timeline--mobile .timeline__item .timeline__content:before{left:-12px;border-bottom:12px solid transparent;border-right:12px solid #ccc;border-left:none;border-top:12px solid transparent}
  .timeline--mobile .timeline__item .timeline__content:after{left:-10px;border-bottom:10px solid transparent;border-right:10px solid #fff;border-left:none;border-top:10px solid transparent}
  @-webkit-keyframes fadeIn{0%{opacity:0;top:70px}100%{opacity:1;top:0}}
  @keyframes fadeIn{0%{opacity:0;top:70px}100%{opacity:1;top:0}}
  @-webkit-keyframes liftUp{0%{top:0}100%{top:-15px}}
  @keyframes liftUp{0%{top:0}100%{top:-15px}}       

/* Scrolling text */
#scroll-container {
    
    width:100%;
    height:30px;
    vertical-align:middle;
    font-size:25px;
    line-height:1;
    padding-top:3px;
    overflow:hidden;
}

#scroll-text {
    text-align:left;
    text-wrap: nowrap;
    min-width:100%;
  /* animation properties */
    -moz-transform: translateX(100%);
    -webkit-transform: translateX(100%);
    transform: translateX(100%);
    -moz-animation: scroll_text 30s linear infinite;
    -webkit-animation: scroll_text 30s linear infinite;
    animation: scroll_text 30s linear infinite;
}

/* for Firefox */
@-moz-keyframes scroll_text {
  from { -moz-transform: translateX(100%); }
  to { -moz-transform: translateX(-100%); }
}

/* for Chrome */
@-webkit-keyframes scroll_text {
  from { -webkit-transform: translateX(100%); }
  to { -webkit-transform: translateX(-100%); }
}

@keyframes scroll_text {
  from {
    -moz-transform: translateX(100%);
    -webkit-transform: translateX(100%);
    transform: translateX(100%);
  }
  to {
    -moz-transform: translateX(-100%);
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%);
  }

}

/* Gallery 2 */
.gal2_img {
border-radius: 5px;
cursor: zoom-in;
transition: 0.3s;
opacity: 0;
width:300px;
height:300px;
}

.gal2_img:hover {/*opacity: 0.7;*/}

.gal2_modal {
display: none; 
position: fixed; 
z-index: 3002; 
left: 0;
top: 0;
width: 100%; 
height: 100vh; 
overflow: auto; 
background-color: rgb(0,0,0); 
background-color: rgba(0,0,0,0.9); 
cursor: zoom-out;
}

.gal2_modal-content {
margin: auto;
display: block;
width: 80%;
max-width: 700px;
text-align: center;
margin-top:15px;
}

#gal2_caption {
margin: auto;
display: block;
width: 80%;
max-width: 1200px;
text-align: center;
color: #ccc;
padding: 10px 0;
height: 20px;
line-height:1;
}

.gal2_modal-content, #gal2_caption {  
-webkit-animation-name: gal2_zoom;
-webkit-animation-duration: 0.6s;
animation-name: gal2_zoom;
animation-duration: 0.6s;
}

@-webkit-keyframes gal2_zoom {
from {-webkit-transform:scale(0)} 
to {-webkit-transform:scale(1)}
}

@keyframes gal2_zoom {
from {transform:scale(0)} 
to {transform:scale(1)}
}

.gal2_close {
position: absolute;
top: 10px;
right: 10px;
color: #f1f1f1;
font-size: 2.2em;
font-weight: bold;
transition: 0.3s;
}

.gal2_close:hover,
.gal2_close:focus {
color: #bbb;
text-decoration: none;
cursor: zoom-out;
}

.gal3_back {
    position: absolute;
    top: 45%;
    left: 0px;
    color: #f1f1f1;
    font-size: 2em;
    font-weight: bold;
    transition: 0.3s;
    cursor:pointer;
}
.gal3_next {
    position: absolute;
    top: 45%;
    right: 0px;
    color: #f1f1f1;
    font-size: 2em;
    font-weight: bold;
    transition: 0.3s;
    cursor:pointer;
}

.gal3_modal-content {
margin: auto;
display: block;
width: 80%;
max-width: 900px;
text-align: center;
margin-top:15px;
}

#gal3_caption {
margin: auto;
display: block;
width: 80%;
max-width: 700px;
text-align: center;
color: #ccc;
padding: 10px 0;
line-height:1;
}

#gal3_model_img {
  perspective: 1200px;
  transform-style: preserve-3d;
  transition: transform 1.2s;
  transition-timing-function: ease-in-out;
}

.dw3_flip_card{
    position:relative;
    width:300px;
    height:400px;
    perspective: 1000px;
    transform-style: preserve-3d;
    border-radius:10px;
}
.dw3_flip_card_back{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
/*     display:flex; */
    align-items:center;
    transition: transform 0.6s;
    backface-visibility:hidden;
    transform: rotateY(180deg);
    background-color:#fff;
    color:#333;
    border-radius:10px;
}
.dw3_flip_card_front{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
/*     display:flex; */
    align-items:center;
    transition: transform 0.6s;
    backface-visibility:hidden;
    background-color:#fff;
    color:#333;
    border-radius:10px;
}

.dw3_card_flip .dw3_flip_card_back {
    transform: rotateY(0deg);
}
.dw3_card_flip .dw3_flip_card_front{
    transform: rotateY(-180deg);
}

.text_gradient_purple {
    background: -webkit-linear-gradient(300deg, hsl(200, 100%, 58%) 20%, hsl(250, 100%, 67%) 70%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    padding:10px 0px;
}
.text_gradient_pink {
    background: -webkit-linear-gradient(300deg, #2EBCB3 , #9730A9 , #FA3E76);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    padding:10px 0px;
}

/* GLOWING TEXT */
.glow_purple {
  color: #fff;
  text-align: center;
  -webkit-animation: glow_purple 1s ease-in-out infinite alternate;
  -moz-animation: glow_purple 1s ease-in-out infinite alternate;
  animation: glow_purple 1s ease-in-out infinite alternate;
}

@-webkit-keyframes glow_purple {
  from {
    text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #e60073, 0 0 40px #e60073, 0 0 50px #e60073, 0 0 60px #e60073, 0 0 70px #e60073;
  }
  to {
    text-shadow: 0 0 20px #fff, 0 0 30px #ff4da6, 0 0 40px #ff4da6, 0 0 50px #ff4da6, 0 0 60px #ff4da6, 0 0 70px #ff4da6, 0 0 80px #ff4da6;
  }
}

.glow_gold {
  color: #fff;
  text-align: center;
  -webkit-animation: glow_gold 1s ease-in-out infinite alternate;
  -moz-animation: glow_gold 1s ease-in-out infinite alternate;
  animation: glow_gold 1s ease-in-out infinite alternate;
}

@-webkit-keyframes glow_gold {
  from {
    text-shadow: 0 0 0px #fff, 0 0 5px #fff, 0 0 10px #FFAB01, 0 0 15px #FFAB01, 0 0 20px #FFAB01, 0 0 25px #FFAB01, 0 0 30px #FFAB01;
  }
  to {
    text-shadow: 0 0 10px #fff, 0 0 15px #FECB3E, 0 0 20px #FECB3E, 0 0 25px #FECB3E, 0 0 30px #FECB3E, 0 0 35px #FECB3E, 0 0 40px #FECB3E;
  }
}

#dw3_copyright_bar {
  visibility: hidden; /* Hidden by default. Visible on click */
  min-width: 250px; /* Set a default minimum width */
  margin-left: -125px; /* Divide value of min-width by 2 */
  background-color: #303030; /* Black background color */
  color: #fff; /* White text color */
  text-align: center; /* Centered text */
  border-radius: 2px; /* Rounded borders */
  padding: 16px; /* Padding */
  position: fixed; /* Sit on top of the screen */
  z-index: 3300; /* Add a z-index if needed */
  left: 50%; /* Center the snackbar */
  bottom: 30px; /* 30px from the bottom */
}

/* Show the snackbar when clicking on a button (class added with JavaScript) */
#dw3_copyright_bar.show {
  visibility: visible; /* Show the snackbar */
  /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
  However, delay the fade out process for 2.5 seconds */
  -webkit-animation: cp_fadein 0.5s, fadeout 0.5s 2.5s;
  animation: cp_fadein 0.5s, fadeout 0.5s 2.5s;
}

/* Animations to fade the snackbar in and out */
@-webkit-keyframes cp_fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@keyframes cp_fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes cp_fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

@keyframes cp_fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

/*-END OF MAIN CSS- */
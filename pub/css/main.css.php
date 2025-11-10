/*+---------------------------------------------------------------------------------+
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
  +---------------------------------------------------------------------------------+*/
/*---------------------------------------------------- */
/*- RESPONSIVE --------------------------------------- */
/*---------------------------------------------------- */
@media screen and (min-width: 250px) {
    body {
        --dw3_body_fontsize:  16px;
    }
}
@media screen and (min-width: 600px) {
    body {
        --dw3_body_fontsize:  18px;
    }
}
@media screen and (min-width: 900px) {
    body {
        --dw3_body_fontsize:  20px;
    }
}
@media screen and (min-width: 1980px) {
    body {
        --dw3_body_fontsize:  22px;
    }
}
@media screen and (min-width: 2960px) {
    body {
        --dw3_body_fontsize:  24px;
    }
}
@media screen and (min-width: 4120px) {
    body {
        --dw3_body_fontsize:  26px;
    }
}
/*---------------------------------------------------- */
/*- GLOBAL ------------------------------------------- */
/*---------------------------------------------------- */
:root {
    --dw3_selected_border: #<?php echo $CIE_COLOR0_1??'004ff8'; ?>;
    --dw3_menu_font:  <?php echo $CIE_FONT2??'Roboto'; ?>;
    --dw3_body_font:  <?php echo $CIE_FONT1??'Roboto'; ?>;
    --dw3_body_fontsize: 16px;
    --dw3_body_background: #<?php echo $CIE_COLOR5??'EEE'; ?>;
    --dw3_body_color:  #<?php echo $CIE_COLOR4??'555'; ?>;
    --dw3_menu_background: #<?php echo $CIE_COLOR8??'FFF'; ?>;
    --dw3_menu_background2: #<?php echo $CIE_COLOR8_2??'FFF'; ?>;
    --dw3_menu_color: #<?php echo $CIE_COLOR9??'333'; ?>;
    --dw3_head_background: #<?php echo $CIE_COLOR6??'EEE'; ?>;
    --dw3_head_background2: #<?php echo $CIE_COLOR6_2??'EEE'; ?>;
    --dw3_head_color: #<?php echo $CIE_COLOR7??'555'; ?>;
    --dw3_line_background: #<?php echo $CIE_COLOR7_2??'FFF'; ?>;
    --dw3_line_background2: #<?php echo $CIE_COLOR7_3??'CCC'; ?>;
    --dw3_line_color: #<?php echo $CIE_COLOR7_4??'444'; ?>;
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
  }      
/*--------------------------------------------------- */
/*- FONTS ------------------------------------------- */
/*--------------------------------------------------- */
    <?php
        $dir = new RecursiveDirectoryIterator($_SERVER['DOCUMENT_ROOT'] . '/pub/font');
        $files = new RecursiveIteratorIterator($dir);
        foreach($files as $file){
            $fn=basename($file->getFileName(), ".ttf");
            if ($fn!="." && $fn!=".."){
                echo "  @font-face {font-family:" . $fn .";src: url(/pub/font/".$fn.".ttf);}" . PHP_EOL;
            }
        }
    ?>
    @font-face {
        font-family: 'Material Icons';
        font-style: normal;
        font-weight: 400;
        src: local('Material Icons'),
                local('MaterialIcons-Regular'),
                url(/sbin/MaterialIcons-Regular.ttf) format('truetype');
    }

    .material-icons {
        font-family: 'Material Icons';
        font-weight: normal;
        font-style: normal;
        font-size: 24px;  /* Preferred icon size */
        display: inline-block;
        line-height: 1;
        text-transform: none;
        letter-spacing: normal;
        word-wrap: normal;
        white-space: nowrap;
        direction: ltr;

        /* Support for all WebKit browsers. */
        -webkit-font-smoothing: antialiased;
        /* Support for Safari and Chrome. */
        text-rendering: optimizeLegibility;

        /* Support for Firefox. */
        -moz-osx-font-smoothing: grayscale;

        /* Support for IE. */
        font-feature-settings: 'liga';
    }
/*--------------------------------------------------- */
/*- BY TAG ------------------------------------------ */
/*--------------------------------------------------- */
    *{margin:0;padding:0;}
    html { 
        background: url("/pub/img/<?php echo $CIE_BG2.'?t=' . rand(100,100000); ?>") no-repeat top center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        height: 100%;
        min-height: 100%;
        max-height: 100%;
    }
    body {
        top: 0px !important;
        left: 0px !important;
        width: 100% !important;
        max-width: 100% !important;
        height: 100%;
        min-height: 100%;
        max-height: 100%;
        margin: 0px 0px 0px 0px;
        font-size: var(--dw3_body_fontsize);
        text-align:center;
        overflow-x:hidden;
        overflow-y:auto;
        padding:0px;
        font-family: <?php echo $CIE_FONT1??'Roboto'; ?>;
    }
    canvas {

        position: fixed;
        top:0px;
        left:0px;
        
    }
    br { content: " "; display: block; margin:2px 0px 2px 0px; line-height:2px; font-size:0px;}
    br .small { content: " "; display: block; margin:0px; line-height:1px; }
    table{margin:0;padding:0;width:100%;white-space:nowrap;}
    span{display:inline-block;vertical-align:middle!important;}
    span.hover_gold:hover {text-shadow: 0px 0px 3px #e5bb51;transform: scale(1.4,1.4);}
    img{vertical-align:middle!important;}
    img.photo{border:1px solid #444; border-radius:7px;box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;}
    a:link {text-decoration: none;color:#<?php echo $CIE_COLOR4??'777'; ?>;}
    a:visited {text-decoration: none;color:#<?php echo $CIE_COLOR4??'777'; ?>;}
    a:hover {text-shadow: 1px 1px 1px #999; text-decoration: none;}
    a:active {text-shadow: -1px -1px #999;text-decoration: none;}
    h1 { text-shadow: 1px 0px #222;text-align:center;}
    h2 { text-shadow: 1px 0px #222;text-align:center;}
    h3 { text-shadow: 1px 0px #222;text-align:center;}
    h4 { text-shadow: 1px 0px #222;text-align:left;}
    hr {
        margin: 10px 0;
        height: 1px;
        border: none;
        background: -webkit-gradient(linear, 0 0, 100% 0, from(transparent), to(transparent), color-stop(50%, black));
    }
    ::-webkit-scrollbar {
        width: 10px;
        /*--border-top-right-radius:7px;
        border-bottom-right-radius:7px;-- */
        background: rgba(255,255,255,1);
    }
    ::-webkit-scrollbar-track {
        /*--border-bottom-right-radius:7px;border-top-right-radius:7px;-- */
        -webkit-box-shadow: inset 0 0 6px <?php echo $CIE_COLOR1??'F5F5F5'; ?>;
        background: rgba(255,255,255,0.8);
        
    }
    ::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px <?php echo $CIE_COLOR1??'777'; ?>;
        background: #1d2e5a;
        cursor:pointer;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }
    @-webkit-keyframes spin {
        0%  {-webkit-transform: rotate(0deg);}
        100% {-webkit-transform: rotate(360deg);}   
    }
    label {
        cursor:pointer;
    }
    button {
        display:inline-block;
        background:  var(--dw3_button_background);
        background-image: linear-gradient(to right, var(--dw3_button_background) , var(--dw3_button_background2) , var(--dw3_button_background3));
        color:   var(--dw3_button_color);
        border-radius: var(--dw3_button_radius);
        padding: 7px;
        margin:3px;
        cursor:pointer;
        border: var(--dw3_button_border);
        vertical-align:middle;
        box-shadow: 0px 0px 1px #444;
        /* text-shadow: 0px 0px 1px #666; */
        font-weight:bold;
        font-family: var(--dw3_button_font);
        transition: all 0.5s linear;
    }
    button:hover:enabled {
        background-color:  var(--dw3_button_color);
        background-image: linear-gradient(to bottom right, var(--dw3_button_color) , var(--dw3_button_color) , var(--dw3_button_color));
        box-shadow:inset 0px 0px 2px 1px  var(--dw3_button_background2);
        color: var(--dw3_button_background2);
    }
    button:hover:disabled {
        cursor: default;
    }
    button:active:disabled {
        cursor: default;
        box-shadow: 0px 5px 5px rgba(190, 0, 0, 0.55);
    }
    button:active:enabled {
        box-shadow: inset 1px 1px 5px #fff;
        transform: translateY(2px);
    }
    button:disabled,
    button[disabled]{
/*         border: 1px solid #999999;
        background-color: #cccccc;
        color: #666666;
        text-shadow: 0px 0px 2px #333; */
        box-shadow:inset 0px 0px 2px 1px red;
    } 

    button.blue { background-color: #1E73BE; background-image: linear-gradient(to bottom right, #2E83CE , #1E73BE, #2E83CE); color: white; border: 0px;}
    button.blue:hover { box-shadow:inset 0px 0px 2px 1px #1E73BE; background-color: white; background-image: linear-gradient(to bottom right, white , white, #EEE); color: #1E73BE;}
    button.green { background-color: #008000; background-image: linear-gradient(to bottom right, #4C9917 , #008000, #4C9917); color: white; border: 0px;}
    button.green:hover { box-shadow:inset 0px 0px 2px 1px #008000; background-color: white; background-image: linear-gradient(to bottom right, white , white, #EEE); color: #008000;}
    button.red { background-color:rgb(168, 19, 0); background-image: linear-gradient(to bottom right, rgb(158, 19, 0) ,rgb(134, 6, 2), rgb(168, 19, 0)); color: white; border: 0px; }
    button.red:hover { box-shadow:inset 0px 0px 2px 1px rgb(144, 6, 2); background-color: white; background-image: linear-gradient(to bottom right, white , white, #EEE); color: rgb(114, 6, 2);}
    button.orange {  background-image: linear-gradient(to bottom right, rgb(246, 123, 0) ,rgb(246, 123, 0), rgb(246, 123, 0)); color: white; border: 0px; transition:all 0.5s linear;}
    button.orange:hover { box-shadow:inset 0px 0px 2px 1px rgb(246, 123, 0); background-image: linear-gradient(to bottom right, white , white, #EEE); color: rgb(246, 123, 0);transition:all 0.5s linear;}
    button.white { background-color:white; background-image: linear-gradient(to bottom right, rgb(222, 222, 222) ,rgb(255, 255, 255), rgb(222, 222, 222)); color: #444;}
    button.white:hover { box-shadow:inset 0px 0px 2px 1px white; background-color: #444; background-image: linear-gradient(to bottom right, #444 , #444, #333);color: #eee;}
    button.grey { background-color: #333; background-image: linear-gradient(to bottom right, rgb(77, 77, 77) ,rgb(77, 77, 77), rgb(66, 66, 66)); color: white;}
    button.grey:hover { box-shadow:inset 0px 0px 2px 1px #333; background-color: white; background-image: linear-gradient(to bottom right, white , white, #EEE); color: #333;}
    button.gold { background-color: gold; background-image: linear-gradient(to bottom right, #e5bb51 , #e7c15f, #e3b542); color: #333;}
    button.gold:hover { box-shadow:gold; background-color: #333; background-image: linear-gradient(to bottom right, #333 , #333, #222); color: #e5bb51;}
    button.clear1 { background-color: transparent; background-image: linear-gradient(to bottom right, rgb(0,0,0,0.5) ,rgb(0,0,0,0.6), rgb(0,0,0,0.5)); color: #eee;}
    button.clear1:hover { box-shadow:#eee; background-color: #eee;background-image: linear-gradient(to bottom right, #ddd , #ddd, #eee);color: #333;}
    button.clear2 {background-color: transparent;background-image: linear-gradient(to bottom right, rgb(255,255,255,0.5) ,rgb(255,255,255,0.6), rgb(255,255,255,0.5));color: #333;}
    button.clear2:hover {box-shadow:#333;background-color: #333;background-image: linear-gradient(to bottom right, #333 , #333, #222);color: #eee;}
    
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
        padding:10px 15px 15px 15px;
    }
    
    textarea:focus {border: 1px solid white;color: #000;background: #FFF;box-shadow: rgba(0, 0, 0, 0.15) 0px 5px 15px;}
    textarea {
        outline: none;
        font-weight: bold;
        padding: 5px;
        box-sizing: border-box;
        border-radius: 10px;
        border: 1px solid light;
        width:100%;
        color: #333333;
        background-color: #fff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }
    select {
        display: inline-block;
        outline: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background: url(/pub/img/dw3/drop.png) 100%/25px no-repeat #fff;
        box-sizing: border-box;
        border-radius: 10px;
        border: 1px solid light;
        width:100%;
        color: #444;
        font-weight: bold;
        padding: 5px 35px 5px 5px;
        vertical-align: middle;
        cursor:pointer;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }
    select:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #FFF;
        color: #222;
    }
    option:checked {
        background: linear-gradient(180deg, #ddd 0%, var(--dw3_selected_border) 100%);
    }
    .multiple {
        background: #eee;
        overflow-y: auto;
        -webkit-appearance: auto;
        -moz-appearance: auto;
        appearance: auto;
        display: inline-block;
        box-sizing: border-box;
        border-radius: 10px;
        border: 1px solid light;
        width:100%;
        color: #444;
        font-weight: bold;
        padding: 5px;
        cursor:pointer;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }

/*     input:focus{
        box-shadow: inset 0 0 5px var(--dw3_selected_border);
    }
    select:focus{
        box-shadow: inset 0 0 5px var(--dw3_selected_border);
    }
    textarea:focus{
        box-shadow: inset 0 0 5px var(--dw3_selected_border);
    } */
    .pourcent{
        background: url(/pub/img/dw3/arrow-pourcent.png) 99% / 20px no-repeat #fff;
    }
    .money{
        background: url(/pub/img/dw3/arrow-money.png) 99% / 20px no-repeat #fff;
    }
    .cm{
        background: url(/pub/img/dw3/arrow-cm.png) 99% / 20px no-repeat #fff;
    }
    .g{
        background: url(/pub/img/dw3/arrow-g.png) 99% / 20px no-repeat #fff;
    }
    .kg{
        background: url(/pub/img/dw3/arrow-kg.png) 99% / 20px no-repeat #fff;
    }
    .eye_on{ 
        background: url(/pub/img/dw3/eye_off.png) 99% / 20px no-repeat #fff;
    }
    .eye_off{ 
        background: url(/pub/img/dw3/eye.png) 99% / 20px no-repeat #fff;
    }
    .editable {
        background: url(/pub/img/dw3/edit.png) 99% / 20px no-repeat #fff;
    }
    .dropbox {
        background: url(/pub/img/dw3/drop.png) 99% / 20px no-repeat #fff;
    }
    .no-bg {
        background: transparent;
    }


    input[type=date] {
        outline: none;
        vertical-align:middle;
        text-align:center;
        font-weight: bold;
        padding: 5px;
        box-sizing: border-box;
        border-radius: 10px;
        border: 1px solid lightgrey;
        color: #333333;
        background-color: #fff;
        width:100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }
    input[type=date]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #FFF;
        color: #222;
    }
    input[type=date]:disabled {
        border: 1px solid #999999;
        background-color: #dcdcdc;
        color: #444;
    }

    input[type=time] {
        outline: none;
        vertical-align:middle;
        text-align:center;
        font-weight: bold;
        padding: 5px;
        box-sizing: border-box;
        border-radius: 10px;
        border: 1px solid lightgrey;
        color: #333333;
        background-color: #fff;
        width:100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }
    input[type=time]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #FFF;
        color: #222;
    }
    input[type=time]:disabled {
        border: 1px solid #999999;
        background-color: #dcdcdc;
        color: #444;
    }

    input[type=datetime-local] {
        outline: none;
        vertical-align:middle;
        text-align:center;
        font-weight: bold;
        padding: 5px;
        box-sizing: border-box;
        border-radius: 10px;
        border: 1px solid lightgrey;
        color: #333333;
        background-color: #fff;
        width:100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }
    input[type=datetime-local]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #FFF;
        color: #222;
    }
    input[type=datetime-local]:disabled {
        border: 1px solid lightgrey;
        background-color: #dcdcdc;
        color: #444;
    }


    input[type=text] {
        outline: none;
        font-weight: bold;
        padding: 5px 25px 5px 5px;
        box-sizing: border-box;
        border-radius: 10px;
        border: 1px solid lightgrey;
        color: #444;
        width:100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.35) ;
        vertical-align:middle;
        background: url(/pub/img/dw3/arrow-under-tag.png) 99% / 20px no-repeat #fff;
    }
    input[type=text]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #FFF;
        color: #222;
    }
    input[type=text]:disabled {
        border: 1px solid #999999;
        background-color: #cccccc;
        color: #444;
    }

    input[type=list] {
        outline: none;
        font-weight: bold;
        padding: 5px;
        border-radius: 10px;
        border: 1px solid lightgrey;
        color: #444;
        background:#fff;
        width:100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.35) ;
        vertical-align:middle;
    }
    input[type=list]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #FFF;
        color: #222;
    }

    input[type=number] {
        outline: none;
        font-weight: bold;
        padding: 5px 25px 5px 5px;
        text-align:right;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        border-radius: 10px;
        border: 1px solid lightgrey;
        color: #444;
        width:100%;
        vertical-align:middle;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
        -moz-appearance: textfield;
        background: url(/pub/img/dw3/arrow-number.png) 99% / 20px no-repeat #fff;
    }
    input[type=number]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #FFF;
        color: #222;
    }

    input[type=password] {
        outline: none;
        font-weight: bold;
        padding: 5px 25px 5px 5px;
        border-radius: 10px;
        vertical-align:middle;
        border: 1px solid lightgrey;
        color: #333333;
        width:100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        background: #fff;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }
    input[type=password]:disabled {
        border: 1px solid #999999;
        background-color: #cccccc;
        color: #444;
    }
    input[type=password]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #FFF;
        color: #222;
    }
    input[type=password]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #FFF;
        color: #222;
    }

    input[type=search] {
        vertical-align:middle;
        outline: none;
        font-weight: bold;
        padding: 7px 26px 7px 7px;
        box-sizing: border-box;
        border-radius: 10px;
        border: 1px solid lightgrey;
        font-size: 1.2em; 
        color: #333333;
        width:100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        background: #fff;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
        background: url(/pub/img/dw3/searchicon.png) 99% / 20px no-repeat #FFF;
    }
    input[type=search]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #FFF;
        color: #222;
    }

    input[type=file] {
        outline: none;
        font-weight: bold;
        padding: 5px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        border-radius: 10px;
        border: 0px solid grey;
        background: #fff;
        color:#333;
        width:100%;
        vertical-align:middle;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
    }
    input[type=file]:focus{
        box-shadow: inset 0 0 3px var(--dw3_selected_border);
        background-color: #FFF;
        color: #222;
    }

    input[type=color] {
        outline: none;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        border: 0px solid grey; 
        width:100%;
        cursor:pointer;
        vertical-align:middle;
        background: url(/pub/img/dw3/drop.png) 99% / 20px no-repeat #fff;
    }

    input[type="checkbox"] {
        /* Add if not using autoprefixer */
        -webkit-appearance: none;
        /* Remove most all native input styles */
        appearance: none;
        /* For iOS < 15 */
        background-color:#fff;
        /* Not removed via appearance */
        margin: 0;
        outline: none;
        font: inherit;
        color: currentColor;
        vertical-align:middle;
        width: 1.15em;
        height: 1.15em;
        border: 0.15em solid currentColor;
        border-radius: 0.15em;
        transform: translateY(-0.075em);
        cursor:pointer;
        display: inline-grid;
        place-content: center;
    }
    input[type="checkbox"]:disabled {
        background-color:#fff;
        color: currentColor;
        cursor:not-allowed;
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
        /* Windows High Contrast Mode */
        background-color: CanvasText;
    }
    input[type="checkbox"]:checked::before {
        transform: scale(1);
    }
    input[type="checkbox"]:focus {
        outline: max(2px, 0.15em) solid currentColor;
        outline-offset: max(2px, 0.15em);
    }
    input[type="submit"] {
        background: #<?php echo $CIE_COLOR1??'222'; ?>;
        color:  #<?php echo $CIE_COLOR2??'F5F5F5'; ?>;
        border-radius: 15px;
        padding: 10px;
        margin:3px;
        line-height: 80%;
        cursor:pointer;
        border: 1px solid #<?php echo $CIE_COLOR2??'F5F5F5'; ?>;
        vertical-align:middle;
        box-shadow: inset 1px 1px  5px #fff;
        text-shadow: -1px 1px #222;
        font-family: <?php echo $CIE_FONT4??'Roboto'; ?>;
    }
    input[type="submit"].blue { background-color: #1E73BE; background-image: linear-gradient(to bottom right, #2E83CE , #1E73BE, #2E83CE); color: white; border: 0px;}
    input[type="submit"].blue:hover { box-shadow:inset 0px 0px 2px 1px #1E73BE; background-color: white; background-image: linear-gradient(to bottom right, white , white, #EEE); color: #1E73BE;}
    input[type="submit"].green { background-color: #008000; background-image: linear-gradient(to bottom right, #4C9917 , #008000, #4C9917); color: white; border: 0px;}
    input[type="submit"].green:hover { box-shadow:inset 0px 0px 2px 1px #008000; background-color: white; background-image: linear-gradient(to bottom right, white , white, #EEE); color: #008000;}
    input[type="submit"].red { background-color:rgb(128, 19, 0); background-image: linear-gradient(to bottom right, rgb(128, 19, 0) ,rgb(114, 6, 2), rgb(128, 19, 0)); color: white; border: 0px; }
    input[type="submit"].red:hover { box-shadow:inset 0px 0px 2px 1px rgb(114, 6, 2); background-color: white; background-image: linear-gradient(to bottom right, white , white, #EEE); color: rgb(114, 6, 2);}
    input[type="submit"].white { background-color:white; background-image: linear-gradient(to bottom right, rgb(222, 222, 222) ,rgb(255, 255, 255), rgb(222, 222, 222)); color: #444;}
    input[type="submit"].white:hover { box-shadow:inset 0px 0px 2px 1px white; background-color: #444; background-image: linear-gradient(to bottom right, #444 , #444, #333);color: #eee;}
    input[type="submit"].grey { background-color: #333; background-image: linear-gradient(to bottom right, rgb(77, 77, 77) ,rgb(77, 77, 77), rgb(66, 66, 66)); color: white;}
    input[type="submit"].grey:hover { box-shadow:inset 0px 0px 2px 1px #333; background-color: white; background-image: linear-gradient(to bottom right, white , white, #EEE); color: #333;}
    input[type="submit"].gold { background-color: gold; background-image: linear-gradient(to bottom right, rgb(255,215,0) ,rgb(255,215,0), rgb(233,205,0)); color: #333;}
    input[type="submit"].gold:hover { box-shadow:gold; background-color: #333; background-image: linear-gradient(to bottom right, #333 , #333, #222); color: gold;}
    input[type="submit"].clear1 { background-color: transparent; background-image: linear-gradient(to bottom right, rgb(0,0,0,0.5) ,rgb(0,0,0,0.6), rgb(0,0,0,0.5)); color: #eee;}
    input[type="submit"].clear1:hover { box-shadow:#eee; background-color: #eee;background-image: linear-gradient(to bottom right, #eee , #eee, #eee);color: #333;}
    input[type="submit"].clear2 {background-color: transparent;background-image: linear-gradient(to bottom right, rgb(255,255,255,0.5) ,rgb(255,255,255,0.6), rgb(255,255,255,0.5));color: #333;}
    input[type="submit"].clear2:hover {box-shadow:#333;background-color: #333;background-image: linear-gradient(to bottom right, #333 , #333, #222);color: #eee;}
    
/*--------------------------------------------------- */
/*- BY CLASS ---------------------------------------- */
/*--------------------------------------------------- */

.dw3_font {
    font-family:dw3;
    font-size:26px;
    -webkit-font-smoothing: antialiased;
}


/* menu */
.menu{
    cursor: pointer;
    text-align:right;
    font-size:17px;
}
.menu_container {   
    padding:0px;     
    position:fixed;
    top:50px;
    right:0px;
    opacity:1;
    height: auto;
    max-width:190px;
    transition: 0.7s;
    border-radius:3px;
    overflow:hidden;
    background-color: rgba(255,255,255,0.5);
    transform: translate(75px,-210px) scale3d(0.2,0,0);
}
.menu_container button {
    background:<?php echo $CIE_COLOR2; ?>;
    border:1px solid <?php echo $CIE_COLOR1; ?>;
    border-radius:5px;
    color:#<?php echo $CIE_COLOR1; ?>;
    font-weight:normal;
    width:180px;
    padding:10px 5px;
    filter: drop-shadow(1px 1px 1px #66c6dd);
    cursor: pointer;
    font-size:21px;
} 
.menu_bar1, .menu_bar2, .menu_bar3 {
    width: 35px;
    height: 6px;
    background-color:#<?php echo $CIE_COLOR1;?>;
    margin: 6px 0;
    transition: 0.4s;
    border-radius:3px;
    filter: drop-shadow(1px 1px 1px #66c6dd);
}
.change .menu_bar1 {
    transform: translate(0, 24px);
    opacity: 0;
}
.change .menu_bar2 {
    opacity: 0;
    transform: translate(0, 12px);
}
.change .menu_bar3 {
    transform: translate(0, 6px);
    
}
.change2 {
    transform: initial;
}
/* end menu */

    .dw3_rotate_infinite{
        -webkit-animation:spin 36s linear infinite;
        -moz-animation:spin 36s linear infinite;
        animation:spin 36s linear infinite;
    }
    .dw3_index_foot{
        display:inline-block;
        width:100%;
        user-select:none;
        height:340px;
        min-height:340px;
        color:#ccc;
        background-image: url("/pub/img/<?php echo $CIE_BG4.'?t=' . rand(100,100000); ?>");
        background-repeat: repeat;
        background-size: auto 100%;
        background-position: top;
        text-align:center;
        vertical-align:top;
        border: 0px solid darkgrey;
        overflow:hidden;
    }
    .dw3_main_foot{
        display:inline-block;
        position: fixed;
        right:0px;
        left: 0px;
        bottom:0px;
        height:45px;
        text-align:center;
        vertical-align:middle; 
        border: 0px solid darkgrey;
        background: var(--dw3_head_background);
        color: var(--dw3_head_color);
        overflow:hidden;
        box-shadow: inset 1px 1px  5px #f0f0f0;
    }
    .dw3_msg{
        display:none;
        z-index:2500;
        position: fixed;
        max-width:95%;
        min-width:340px;
        min-height:200px;
        width:auto;
        top: 45%;
        left: 50%;
        -moz-transform: translateX(-50%) translateY(-50%);
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        text-align:center;
        padding:25px;
        border-radius: 18px;
        border: 0px solid #333;
        font-size: 20px;
        background: var(--dw3_form_background);
        color: var(--dw3_form_color);
        font-family: <?php echo $CIE_FONT3??'Roboto'; ?>;
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
        border-radius: 15px;
        border: 1px solid darkgrey;
        background: var(--dw3_form_background);
        color: var(--dw3_form_color);
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
        overflow-x:hidden;
        overflow-y:hidden;
        font-family: <?php echo $CIE_FONT3??'Roboto'; ?>;
    }
    .dw3_form_cancel{
        background:#444;
    }
    .dw3_form_close{
        background:#444;
        top:0px;
        right:0px;
        padding:5px;
        text-align:center;
        margin:3px;
        position:absolute;
        color:rgba(255,255,255,0.7);
        border-radius: 15px;
        box-shadow:none;
    }
    .dw3_form_delete{
        background:red;
    }
    .dw3_form_data{
        position:absolute;
        top:40px;
        left:0px;
        bottom:50px;
        right:0px;
        overflow-x:hidden; 
        overflow-y:auto;
    }
    .dw3_form_foot{
        position: absolute;
        bottom:0px;
        left:0px;
        right:0px;
        /* height:50px; */
        min-height:30px;
        background: var(--dw3_head_background);
        color: var(--dw3_head_color);
        border-bottom-right-radius:15px;
        border-bottom-left-radius:15px;
        overflow:hidden;
    }
    .dw3_form_head>h2{
        display: grid;align-items: center;height:40px;
    }
    .dw3_form_head>h3{
        display: grid;align-items: center;height:40px;
    }
    .dw3_form_head{
        cursor:move;
        position:absolute;
        top:0px;
        right:0px;
        left:0px;
        height:40px;
        background: var(--dw3_head_background);
        background-image: linear-gradient(125deg, var(--dw3_head_background),var(--dw3_head_background2));
        color: var(--dw3_head_color);        
        border-top-right-radius:15px;
        border-top-left-radius:15px;
        border:0px solid #000;
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
        border-radius: 15px;
        border: 1px solid darkgrey;
        background: var(--dw3_form_background);
        color: var(--dw3_form_color);
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
        overflow-x:hidden;
        overflow-y:hidden;
        font-family: <?php echo $CIE_FONT3??'Roboto'; ?>;
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
        top:40px;
        left:0px;
        bottom:0px;
        right:0px;
        overflow-x:hidden; 
        overflow-y:auto;
    }
    .dw3_quiz_foot{
        position: absolute;
        bottom:0px;
        left:0px;
        right:0px;
        height:45px;
        background: var(--dw3_head_background);
        color: var(--dw3_head_color);
        border-bottom-right-radius:15px;
        border-bottom-left-radius:15px;
        overflow-y:hidden;
    }
    .dw3_quiz_head{
        cursor:move;
        position:absolute;
        top:0px;
        right:0px;
        left:0px;
        height:40px;
        background: #1d2e5a;
        background-image: linear-gradient(125deg, var(--dw3_head_background),var(--dw3_head_background2));
        color: var(--dw3_head_color);        
        border-top-right-radius:15px;
        border-top-left-radius:15px;
    }
    .image:focus {
        box-shadow: 0px 0px 4px 2px blue;
    }
    .image:active {
        box-shadow: 0px 0px 4px 2px blue;
    }
    .image {
        background: rgba(0,0,0,0);
        background-image: url("/pub/img/dw3/nd.png");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        vertical-align:bottom;
        border:0px solid #000;
    }
    .noselect { /*  to avoid text selection */
        -webkit-touch-callout:none;
        -webkit-user-select:none;
        -khtml-user-select:none;
        -moz-user-select:none;
        -ms-user-select:none;
        user-select:none;
        -webkit-tap-highlight-color:rgba(0,0,0,0);
    }
    .divMAIN{
        display: inline-block;
        z-index:250;
        margin: 0;
        background: #<?php echo $CIE_COLOR3??'F5F5F5'; ?>;
        color:#<?php echo $CIE_COLOR4??'000'; ?>;
        text-align:center;
        vertical-align:middle;
        height: auto;
        border-radius: 0px;
        border: 0px solid darkgrey;
        width:100%;
        max-width:100%;
        overflow:auto;
        transition: height 1.5s ease-in-out;
    }
    .divPAGE{ 
        width:100%; 
        max-width:1080px; 
        overflow:auto;
        display:inline-block;	
        padding: 0px 0px 10px 0px;
        text-align:center;
        box-shadow: inset rgba(0, 0, 0, 0.35) 0px 5px 5px;
        background: rgba(255,255,255,0.2);
    }
    .divSECTION{ 
        width:100%; 
        max-width:100%; 
        display:inline-block;	
        padding: 0;
        text-align:center;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
        overflow:auto;
    }
    .divBOX{
        width:97%;max-width:335px;
        min-height:20px;
        display:inline-block;
        text-align:left;
        vertical-align:middle;
        box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.25);
        padding:10px 3px 5px 3px;
        border-radius:4px;
        margin:5px 2px 5px 2px;
/*         font-weight:bold; */
        background: var(--dw3_form_background);
        color: var(--dw3_form_color);
        font-family: <?php echo $CIE_FONT3??'Roboto'; ?>;
    }
    .divBOX label{vertical-align:middle;display:inline-block;}
    .dw3_box label{vertical-align:middle;display:inline-block;}
    .dw3_box{
        width:97%;max-width:335px;
        min-height:20px;
        display:inline-block;
        text-align:left;
        vertical-align:middle;
        box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.25);
        padding:10px 3px 10px 3px;
        border-radius:4px;
        margin:5px 0px 5px 2px;
        background: var(--dw3_form_background);
        color: var(--dw3_form_color);
        font-family:  var(--dw3_form_font);
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

    .dw3_drop_area{
        border: 3px dashed #fff;
        height: 400px;
        width: 100%;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        box-sizing: border-box;
    }
    .dw3_drop_area.dw3_drop_active{
        border: 3px solid #fff;
      }
    .dw3_drop_area.icon{
        font-size: 100px;
        color: #fff;
      }
    .dw3_drop_area.header{
        font-size: 30px;
        font-weight: 500;
        color: #fff;
      }
    .dw3_drop_area.img{
        height: 100%;
        width: 100%;
        object-fit: cover;
        border-radius: 5px;
        box-sizing: border-box;
      }
      .dw3_drop_area button:hover{
        background: rgb(228, 220, 220);
        box-sizing: border-box;
      }
    
      .hoverShadow:hover{box-shadow:0px 0px 3px 2px var(--dw3_selected_border);}

    .tblINPUT{
        border-radius:10px;
        border:1px solid white;
        color:#<?php echo $CIE_COLOR4??'333'; ?>;
        background:<?php echo $CIE_COLOR3??'F5F5F5'; ?>;
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
    .tblSIDE_TH {
        width:100%;
        margin:0px;
        background: rgba(255, 255, 255, 0.1);
        white-space:nowrap;
        border-collapse: collapse;
        font-family: <?php echo $CIE_FONT3??'Roboto'; ?>;
    }
    .tblSIDE_TH td{
        text-align:left;
        border: 0px solid #ddd;
        padding: 1px;
        font-size:15px;
        color: #333333;
        overflow:hidden;
    }
    .tblSIDE_TH td input{
        border-radius:0px;
    }
    .tblSIDE_TH td select{
        border-radius:4px;
    }
    .tblSIDE_TH th{
        text-align:left;
        padding: 2px;
        user-select:none;	
        background: linear-gradient(180deg,#<?php echo $CIE_COLOR7??'F5F5F5'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>);
        color:#<?php echo $CIE_COLOR7??'000'; ?>;
        cursor:n-resize;
        font-size:15px;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        text-shadow: 1px 1px #222;
    }
    .tblSIMPLE {
        width:100%;
        margin:0px;
        background: #fff;
        border-collapse: collapse;
        font-family: Calibri, sans-serif;
        border-top-left-radius: 10px;border-top-right-radius: 10px;
    }
    .tblSIMPLE > tbody > tr >td{
        text-align:left;
        border-bottom: 1px solid #999;
        padding: 4px;
        color: #444;
        overflow:hidden;
    }
    .tblSIMPLE > tbody > tr > th{
        text-align:left;
        padding: 6px;
        user-select:none;	
        vertical-align:middle;
        background: #777;
        color: #fff;
        position: sticky;
        top: 0;
    }
    .tblSIMPLE > tbody > tr:first-child > td:first-child {border-top-left-radius: 10px;}
    .tblSIMPLE > tbody > tr:first-child > td:last-child {border-top-right-radius: 10px;}
    .tblSIMPLE > tbody > tr:first-child > th:first-child {border-top-left-radius: 10px;}
    .tblSIMPLE > tbody > tr:first-child > th:last-child {border-top-right-radius: 10px;}

    .tblDATA {
        width:100%;
        margin:0px;
        background: rgba(255, 255, 255, 0.1);
        white-space:nowrap;
        border-collapse: collapse;
        font-family: <?php echo $CIE_FONT3??'Roboto'; ?>;
    }
    .tblDATA td{
        text-align:left;
        border: 1px solid #<?php echo $CIE_COLOR7_3??'AAA'; ?>;;
        padding: 4px;
        color: #<?php echo $CIE_COLOR7_4??'333'; ?>;
        overflow:hidden;
    }
    .tblDATA th{
        text-align:left;
        padding: 6px;
        user-select:none;	
        vertical-align:top;
        background: linear-gradient(180deg,#<?php echo $CIE_COLOR6??'F5F5F5'; ?>,#<?php echo $CIE_COLOR6_2??'DDD'; ?>);
        color:#<?php echo $CIE_COLOR7??'000'; ?>;
        position: sticky;
        top: 0;
        cursor:n-resize;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        border:1px solid #<?php echo $CIE_COLOR6??'888'; ?>;
    }
    .tblDATA tr:nth-child(even){background-color: #<?php echo $CIE_COLOR7_2??'FFF'; ?>;}
    .tblDATA tr:nth-child(odd){background-color: #<?php echo $CIE_COLOR7_3??'AAA'; ?>;}
    /* .tblDATA tr:first-child{border-top-left-radius: 10px;border-top-right-radius: 10px;border-left:1px solid #<?php echo $CIE_COLOR6??'888'; ?>;} */
    .odd{background-color: #<?php echo $CIE_COLOR7_3??'FFF'; ?>;} 
    .even{background-color: #<?php echo $CIE_COLOR7_2??'FFF'; ?>;} 
    .selected{ border: 1pt solid #<?php echo $CIE_COLOR0_1??'004ff8'; ?>;box-shadow: inset 0px 0px 4px 2px #<?php echo $CIE_COLOR0_1??'004ff8'; ?>;}
    .short{ /*  to limit cell size  */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .tblSEL {
        width:100%;
        margin:0px;
        background: rgba(255, 255, 255, 0.1);
        white-space:nowrap;
        border-collapse: collapse;
        font-family: <?php echo $CIE_FONT3??'Roboto'; ?>;
        
    }
    .tblSEL td{
        text-align:left;
        border: 1px solid #ddd;
        padding: 6px;
        user-select:none;
        color: #<?php echo $CIE_COLOR7_4??'333333'; ?>;
        cursor:pointer;
        overflow:hidden;
    }
    .tblSEL th{
        text-align:left;
        overflow:hidden;
        padding: 5px;
        user-select:none;	
        background: linear-gradient(180deg,#<?php echo $CIE_COLOR7??'F5F5F5'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>);
        color:#<?php echo $CIE_COLOR7??'000'; ?>;
        cursor:n-resize;
        position: sticky;
        top: 0; /* Don't forget this, required for the stickiness */
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        text-shadow: -1px 1px #222;
    }
    .tblSEL tr:nth-child(even){background-color: #<?php echo $CIE_COLOR7_2??'FFF'; ?>;}
    .tblSEL tr:nth-child(odd){background-color: #<?php echo $CIE_COLOR7_3??'AAA'; ?>;}
    .tblSEL tr:first-child{border-top-left-radius: 10px;border-top-right-radius: 10px;border-left:1px solid <?php echo $CIE_COLOR6??'888'; ?>;}
    .tblSEL tr:hover {background-color: #B2DDE7;}
    .tblCAL {
        table-layout:fixed;
        width:100%;
        max-width:100%;
        margin:0px;
        background: rgba(255, 255, 255, 0.1);
        white-space:nowrap;
        border-collapse: collapse;
        font-family: <?php echo $CIE_FONT2??'Roboto'; ?>;
    }
    .tblCAL tbody tr{
        height:20px;
        max-height:100px;
    }
    .tblCAL td{
        vertical-align:top;
        text-align:left;
        border: 0px solid #ddd;
        padding: 4px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        user-select:none;
        color: #<?php echo $CIE_COLOR7_4??'333333'; ?>;
        max-height:100px;
        box-shadow: inset 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        transition: 1s background-color linear;
     }
    .tblCAL th{
        text-align:center;
        padding: 2px 3px;
        user-select:none;	
        /* background: linear-gradient(180deg,#<?php echo $CIE_COLOR7??'F5F5F5'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>,#<?php echo $CIE_COLOR6??'222'; ?>); */
        color:#EEE;
        position: sticky;
        top: 0; /* Don't forget this, required for the stickiness */
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        text-shadow: 1px 1px 3px #222;
        border:0px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .tblCAL tr:nth-child(even){background-color: #f2f2f2;}
    .tblCAL tr:nth-child(odd){background-color: lightgrey;}
    .tblCAL tr:first-child{border-top-left-radius: 10px;border-top-right-radius: 10px;border-left:0px solid <?php echo $CIE_COLOR6??'888'; ?>;}
    .tblCAL tr td:hover {background-color: #B2DDE7;}
    .tblMESSAGE{
        width:100%;
        margin:0px;
        background: rgba(255, 255, 255, 0.1);
        white-space:wrap;
        border-collapse: collapse;text-align: left;  
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
        background: #<?php echo $CIE_COLOR6??'777'; ?>;
        color:#<?php echo $CIE_COLOR7??'F5F5F5'; ?>;
    }
    .bordered{
        border-bottom: 1px solid <?php echo $CIE_COLOR6??'777'; ?>;
        border-radius:15px;
    }
    .divEDITOR{
        z-index:1100;
        display:none;
        position: fixed;
        width:95%;
        max-width:900px;
        left: 50%;
        top:2%;
        min-height:90%;
        max-height:95%;
        transform: translateX(-50%);
        text-align:center;
        padding:0px;
        border-radius: 17px;
        border: 1px solid darkgrey;
        background: #<?php echo $CIE_COLOR3??'F5F5F5'; ?>;
        color:#<?php echo $CIE_COLOR4??'777'; ?>;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
        overflow-x:hidden;
        overflow-y:hidden;
        font-family: <?php echo $CIE_FONT3??'Roboto'; ?>;
    }
    .divSELECT{
        z-index:1200;
        display:none;
        position: fixed;
        width:95%;
        max-width:95%;
        left: 50%;
        top:2%;
        min-height:90%;
        max-height:95%;
        transform: translateX(-50%);
        text-align:center;
        padding:0px;
        border-radius: 15px;
        border: 1px solid darkgrey;
        background: #<?php echo $CIE_COLOR3??'F5F5F5'; ?>;
        color:#<?php echo $CIE_COLOR4??'777'; ?>;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
        overflow-x:hidden;
        overflow-y:hidden;
        font-family: <?php echo $CIE_FONT3??'Roboto'; ?>;
    }
    
    .footer{

    }
    .EDIT_FOOT{
        position: absolute;
        width:100%;
        bottom:0px;
        left:0px;
        right:0px;
        background: #<?php echo $CIE_COLOR3??'F5F5F5'; ?>;
        color:#<?php echo $CIE_COLOR4??'777'; ?>;
        }
    .visible{
        display: inline-block;
        opacity: 0.5;
        transition: opacity 1.5s linear;
        }
    .divFOOT{
            z-index:100;
            position: fixed;
            bottom: 0px;
            left: 5px;
            right:5px;
            height:49px;
            color:#<?php echo $CIE_COLOR0??'333'; ?>;
            font-size: 14px;
            background: #<?php echo $CIE_COLOR5??'F5F5F5'; ?>;
            text-align:center;
            vertical-align:middle;
            padding: 4px 0px 0px 0px;
            border-radius: 15px;
            border: 0px solid darkgrey;
            box-shadow: inset rgba(0, 0, 0, 0.35) 0px 5px 10px;
        }
        #dw3_notif_container{
            z-index:4000;
            position: fixed;
            top: 40px;
            right:5px;
            width:50px;
            max-width:95%;
            text-align:right;
            border-radius: 10px;
            -moz-transition: height .5s;
            -ms-transition: height .5s;
            -o-transition: height .5s;
            -webkit-transition: height .5s;
            transition: height .5s;
        }
        .section {
            display:inline-block;
            font-weight:bold;
            text-align:left;
            background: rgba(255, 255, 255, 0.75);
            font-size: 1.25rem;
            line-height: 2rem;
            width: 85%;
            max-width:800px;
            border-radius:30px;
            margin:25px 0px;
            scroll-snap-align: center;
            scroll-snap-type: y mandatory;
            overflow-y:auto;
            scrollbar-width:none;
            box-shadow: rgba(102, 198, 221, 0.75) 5px 15px 20px;
          }
          .section p{
            margin:25px;
          }
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
            background-attachment: fixed;
            background-size: 100% 100%;
        }
/*--------------------------------------------------- */
/*- BY ID ------------------------------------------- */
/*--------------------------------------------------- */
#dw3_fade_body{
    position: fixed;
    text-align:center;
    z-index:1000;
    top:0px;
    right:0px;
    left:0px;
    height: 100vh;
    opacity: 0;
    transition: opacity 0.5s linear;
    display: none;
    background-color: rgba(0,50,150,0.3);
}
#dw3_fade_form{
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
    #dw3_scene{z-index:-2;
        content:"";
        position:fixed;
        width:100vw;
        height:100vh;
        left: 0;
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
    }

    #divToPDF{
        display:none;
        position: fixed;
        width:95%;height:95%;
        left: 50%;
        top:2%;
        max-height:95%;
        max-width:900px;
        transform: translateX(-50%);
        z-index:1950;
        background: rgba(255, 255, 255, 0.9);
        text-align:left;
        padding:0px;
        border-radius: 10px;
        border: 1px solid darkgrey;
        color: black;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
        overflow-x:hidden;
        overflow-y:auto;
    }
    #divEDIT_FOOT{
        position: absolute;
        bottom:0px;
        left:0px;
        right:0px;
        /* height:50px; */
        min-height:30px;
        background: var(--dw3_head_background);
        color: var(--dw3_head_color);
        border-bottom-right-radius:15px;
        border-bottom-left-radius:15px;
        overflow:hidden;
    }
    #divNEW_FOOT{
        position: absolute;
        bottom:0px;
        left:0px;
        right:0px;
        background: var(--dw3_head_background);
        color: var(--dw3_head_color);
        border-bottom-right-radius:15px;
        border-bottom-left-radius:15px;
        overflow:hidden;
    }
    #iMap{
        display:none;
        width: 100%;
        top: 50px;
        bottom:50px;
        position: fixed;
    }

    #divMENU_BTN:active{
        width: 25px;
        transition:  1s;
    }
    #divMENU_BTN{
        z-index:90;
        position: fixed;
        top: 0px;
        left: 0px;
        width: 52px;
        height:46px;
        color:#<?php echo $CIE_COLOR2??'777'; ?>;
        font-size:30px;
        background-image: linear-gradient(to right, var(--dw3_button_background) , var(--dw3_button_background2) , var(--dw3_button_background3));
        text-align:center;
        padding: 0px;
        border-bottom-right-radius: 15px ;
        border: 0px solid darkgrey;
        cursor:pointer;
        overflow:hidden;
        box-shadow:  inset rgba(255, 255, 255, 0.25) 0px 0px 2px 2px;
    }
    #divMENU_BTN:first-child{ font-size: 28px;padding-top:5px;}
    #divMENU{
        z-index:1800;
        position: fixed;
        top: 0px;
        left: 0px;
        /* width: 275px; */
        max-width: 330px;
        height:auto;
        max-height:100%;
        color:black;
        font-size: 17px;
        font-weight:bold;
        background: rgba(255, 255, 255, 0);
        text-align:left;
        padding: 0px;
        border-bottom-right-radius: 35px 35px;
        border: 0px solid darkgrey;
        overflow-x:hidden;
        overflow-y:hidden;
        transition: 0.5s;
        user-select:none;
        transform: translate(-275px,0px) scale3d(0,0,0);
    }
    #divMENU_TOP{
        width: auto;
        height:34px;
        background-image: linear-gradient(to right, var(--dw3_button_background) , var(--dw3_button_background2) , var(--dw3_button_background3));
        color:#<?php echo $CIE_COLOR2??'777'; ?>;
        padding:7px 0px 4px 4px;
        font-size: 15px;
        white-space:nowrap;
        vertical-align:middle;
        cursor:pointer;
        border-top-right-radius: 35px 35px ;
        box-shadow:  inset rgba(255, 255, 255, 0.25) 0px 0px 2px 2px;
    }
    #divMENU_BOT{
        width: auto;
        height:36px;
        background-image: linear-gradient(to right, var(--dw3_button_background) , var(--dw3_button_background2) , var(--dw3_button_background3));
        color:#<?php echo $CIE_COLOR2??'777'; ?>;
        padding:12px 0px 0px 4px;
        font-size: 19px;
        white-space:nowrap;
        vertical-align:middle;
        cursor:pointer;
        border-bottom-right-radius: 35px 35px ;
        box-shadow:  inset rgba(255, 255, 255, 0.25) 0px 0px 2px 2px;
    }
    #tblMENU{
        width:100%;
        margin:0px;padding:0px;
        cursor:pointer;
        background: #<?php echo $CIE_COLOR5??'F5F5F5'; ?>;
        text-align:left;
        white-space:nowrap;
        user-select:none;
        border-collapse: collapse;
        border-bottom-right-radius: 25px 10px;
    }
    #tblMENU>tbody>tr>td{
        padding:5px;
        margin:0px;
        user-select:none;
    }
    #tblMENU>tbody>tr{
        color:#<?php echo $CIE_COLOR4; ?>;
        background: #<?php echo $CIE_COLOR3; ?>;
    }
    #tblMENU>tbody>tr>:hover{
        color:#<?php echo $CIE_COLOR3; ?>;
        background: #<?php echo $CIE_COLOR4; ?>;
    }
    #tblMENU>tfoot>tr>td{
        padding:5px;
        margin:0px;
        user-select:none;
    }
    

    /* -------------------------MENU -------------------- */

    

    #divLOGIN{
        display:none;
        z-index:1200;
        position: fixed;
        top: 50px;
        right: 10px;
        width:300px;
        min-height:350px;
        color:white;
        font-size: 18px;
        background: rgba(33, 33, 33, 0.9);
        text-align:center;
        padding: 10px 10px 10px 10px;
        border-radius: 5px;
        border: 1px solid darkgrey;
    }
    #divSIGNIN{
        display:none;
        z-index:1200;
        position: fixed;
        top: 50px;
        right: 10px;
        width:300px;
        color:white;
        font-size: 18px;
        background: rgba(33, 33, 33, 0.9);
        text-align:center;
        padding: 10px 10px 10px 10px;
        border-radius: 5px;
        border: 1px solid darkgrey;
    }

    #dw3_head21bg{transition: opacity 1s;}
    #dw3_head22bg{transition: opacity 1s;}
    #dw3_head table{width:100%;}
    #dw3_head{
        z-index:100;
        user-select:none;
        position: fixed;
        top: 0px;
        left: 55px;
        right:0px;
        height:46px;
        color:#<?php echo $CIE_COLOR2??'777'; ?>;
        background: #<?php echo $CIE_COLOR1??'F5F5F5'; ?>;
        text-align:left;
        vertical-align:top;
        padding: 0px 10px 0px 10px;
        border-bottom-left-radius:  15px ;
        border: 0px solid darkgrey;
        box-shadow:  inset rgba(255, 255, 255, 0.25) 0px 0px 2px 2px;
        overflow:hidden;
    }
    #divHEAD{
        z-index:100;
        user-select:none;
        position: fixed;
        top: 0px;
        left: 55px;
        right:0px;
        height:46px;
        color:var(--dw3_menu_color);
        background: var(--dw3_menu_background);
        text-align:left;
        vertical-align:top;
        padding: 0px 10px 0px 10px;
        border-bottom-left-radius:  15px ;
        border: 0px solid darkgrey;
        box-shadow:  inset rgba(255, 255, 255, 0.25) 0px 0px 2px 2px;
        overflow:hidden;
    }
    #divHEAD_POPUP{
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
        border-radius: 15px;
        border: 0px solid darkgrey;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
        transition: height 1s;
    }
    #divROW_POPUP{
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
        border-radius: 10px;
        border: 0px solid darkgrey;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 5px;
        transition: all 1s;
    }
    #divFOOT{
        z-index:100;
        position: fixed;
        bottom: 0px;
        left: 5px;
        right:5px;
        height:49px;
        color:#<?php echo $CIE_COLOR0??'333'; ?>;
        font-size: 14px;
        background: #<?php echo $CIE_COLOR5??'F5F5F5'; ?>;
        text-align:center;
        vertical-align:middle;
        padding: 7px 0px 0px 0px;
        border-radius: 15px;
        border: 0px solid darkgrey;
        box-shadow: inset rgba(0, 0, 0, 0.35) 0px 5px 10px;
    }

    .config-icon{
        -moz-animation:spin 16s linear infinite;
        animation:spin 16s linear infinite;
        -webkit-animation: spin 16s infinite linear;
    }
    
    #divMAP{
        display:none;
        z-index:150;
        position: fixed;
        width:75%;
        top: 5px;
        left: 50%;
        -moz-transform: translateX(-50%);
        -webkit-transform: translateX(-50%) ;
        transform: translateX(-50%) ;
        background: #<?php echo $CIE_COLOR5??'F5F5F5'; ?>;
        text-align:center;
        padding:5px;
        border-radius: 5px;
        border: 1px solid darkgrey;
        color: #<?php echo $CIE_COLOR0??'333'; ?>;
        transition: all 1s;
        overflow-x: hidden;
        overflow-y: auto;
        max-height: 95%;
    }
    #imgLOGO_TOP{
        width:auto;
        height:32px;
    }

    #divFILTRE{
        display:none;
        z-index:1100;
        position: fixed;
        width:305px;
        max-height:100%;
        overflow-x:hidden;overflow-y:auto;
        top: 10%;
        left: 50%;
        -moz-transform: translateX(-50%);
        -webkit-transform: translateX(-50%);
        transform: translateX(-50%);
        text-align:left;
        padding:10px;
        border-radius: 15px;
        border: 1px solid darkgrey;
        background: #<?php echo $CIE_COLOR3??'F5F5F5'; ?>;
        color:#<?php echo $CIE_COLOR4??'777'; ?>;
        transition: all 1s;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
    }
    #dw3_editor{
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
        opacity:0;
        border-radius: var(--dw3_form_radius);
        border: 1px solid darkgrey;
        background: var(--dw3_form_background);
        color: var(--dw3_form_color);
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 10px;
        overflow-x:hidden;
        overflow-y:hidden;
        font-family:  var(--dw3_body_font);
    }
    #divMSG{
        display:none;
        z-index:2700;
        position: fixed;
        max-width:95%;
        min-width:195px;
        min-height:95px;
        max-height:85%;
        top: 50%;
        left: 50%;
        -moz-transform: translateX(-50%) translateY(-50%);
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        background-image: url('/pub/img/frame/<?php echo $CIE_FRAME??'frame5.png'; ?>');
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100% 100%;
        text-align:center;
        padding:25px;
        border: 0px solid darkgrey;
        font-size: 20px;
        color: var(--dw3_msg_color);
   /*      text-shadow:0px 0px 1px black; */
        overflow:auto;
    }
    #divTOOL_HEADER{
        margin:-15px 0px 15px 0px;
        color: #FFF;
        cursor:move;
        background-image: linear-gradient(to right, transparent , rgba(0,0,0,0.3) , rgba(0,0,0,0.3),transparent);
    }
    #divTOOL{
        display:none;
        z-index:2710;
        position: fixed;
        max-width:95%;
        min-width:195px;
        min-height:95px;
        max-height:85%;
        top: 50%;
        left: 20%;
        font-family: Consolas, monospace;
        -moz-transform: translateX(-20%) translateY(-50%);
        -webkit-transform: translateX(-20%) translateY(-50%);
        transform: translateX(-20%) translateY(-50%);
        background-image: url('/pub/img/frame/frame99.png');
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100% 100%;
        text-align:center;
        padding:25px;
        border: 0px solid darkgrey;
        font-size: 20px;
        color: #FFF;
        overflow:auto;
    }

    #divMSG2{
        display:none;
        z-index:2650;
        position: fixed;
        max-width:95%;
        min-width:195px;
        min-height:95px;
        max-height:95%;
        top: 50%;
        left: 50%;
        -moz-transform: translateX(-50%) translateY(-50%);
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        background-image: url('/pub/img/frame/<?php echo $CIE_FRAME??'frame5.png'; ?>');
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100% 100%;
        text-align:center;
        padding:25px;
        border: 0px solid darkgrey;
        font-size: 20px;
        color: var(--dw3_msg_color);
   /*      text-shadow:0px 0px 1px black; */
        overflow:auto;
    }

    .inverted_bg{
        -webkit-filter: invert(100%);
        filter: invert(100%);
    }
    .svg_portal{
        z-index:1500;
        position: fixed;
        top: -25%;
        left: -25%;
        right: -25%;
        bottom: -25%;
        min-width:500px;
        min-height:500px;
    }
    .divMSG{
        display:none;
        z-index:2700;
        position: fixed;
        max-width:95%;
        min-width:195px;
        min-height:95px;
        max-height:95%;
        top: 50%;
        left: 50%;
        -moz-transform: translateX(-50%) translateY(-50%);
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        background-image: url('/pub/img/frame/<?php echo $CIE_FRAME??'frame5.png'; ?>');
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100% 100%;
        text-align:center;
        padding:25px;
        border: 0px solid darkgrey;
        font-size: 20px;
        color: var(--dw3_msg_color);
   /*      text-shadow:0px 0px 1px black; */
        overflow:auto;
    }
    #divOPT .dw3_form_data{
        background: rgba(255, 255, 255, 0.9);
        background-image: url('/pub/img/dw3/flowers.gif');
        background-repeat: no-repeat;
        background-position: left bottom;
    }
    #divOPT{
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
        border-radius: 15px;
        border: 1px solid darkgrey;
        font-size: 20px;
        color: black;
        opacity: 0;
        transition: opacity 1s;
        overflow:hidden;
    }

    #divFADE{
        position: fixed;
        text-align:center;
        z-index:1000;
        top:0px;
        right:0px;
        left:0px;
        height: 100vh;
        opacity: 0;
        transition: opacity 0.5s linear;
        display: none;
        background-color: rgba(0,50,150,0.3);
        background: url("/pub/img/fade/<?php echo $CIE_FADE; ?>") no-repeat top center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        background-position:center;
        }
    #divFADE2{
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
        background-color: rgba(0,0,0,0.9);  
    }


    #divFADE_BG{
        display:none;
        position: fixed;
        text-align:center;
        vertical-align:middle;
        z-index:100;
        top:0px;
        left:0px;
        width:100%;
        height: 100vh;
        background: rgba(0, 0, 0, 0.7);
    }

/*--------------------------------------------------- */
/*- CSS SANDBOX ------------------------------------- */
/*--------------------------------------------------- */


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
        -webkit-transition: .4s;
        transition: .4s;
        }

        .slider:before{
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
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
          }
          .slide-arrow {
            position: absolute;
            display: flex;
            top: 0;
            bottom: 0;
            margin: auto;
            height: 4rem;
            background-color: white;
            border: none;
            width: 2rem;
            font-size: 3rem;
            padding: 0;
            cursor: pointer;
            opacity: 0.5;
            transition: opacity 100ms;
            box-sizing: border-box;
          }
          
          .slide-arrow:hover,
          .slide-arrow:focus {
            opacity: 1;
          }
          
          #slide-arrow-prev {
            left: 0;
            padding-left: 0.25rem;
            padding-top: 0.5rem;
            border-radius: 0 2rem 2rem 0;
            box-sizing: border-box;
          }
          
          #slide-arrow-next {
            right: 0;
            padding-left: 0.75rem;
            padding-top: 0.5rem;
            border-radius: 2rem 0 0 2rem;
            box-sizing: border-box;
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
            font-family: "Lucida Grande", "Arial", sans-serif;
            color: rgba(255, 255, 255, 1);
          }
          
          .opt_contentarea {
            font-size: 16px;
            font-family: "Lucida Grande", "Arial", sans-serif;
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
max-width: 700px;
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
font-size: 40px;
font-weight: bold;
transition: 0.3s;
}

.gal2_close:hover,
.gal2_close:focus {
color: #bbb;
text-decoration: none;
cursor: zoom-out;
}

/*-END OF MAIN CSS- */

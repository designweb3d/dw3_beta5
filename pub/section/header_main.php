<?php /** DW3 Platform BETA5
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
  if (!isset($dw3_conn)){header('Location: https://'.$_SERVER["SERVER_NAME"].'/');exit;}?><!DOCTYPE html>
 <html lang="<?php if ($USER_LANG == "FR"){echo "fr";} else{echo "en";} ?>"><head>
	<meta charset="utf-8">
	<title><?php 
    if (!isset($CIE_NOM))           {$CIE_NOM = $_SERVER["SERVER_NAME"];}
    if (!isset($PAGE_TITLE))     {$PAGE_TITLE = "";}
    if (!isset($PAGE_ID))           {$PAGE_ID= "0";}
    if (!isset($USER_LANG))         {$USER_LANG = "FR";}
    if (!isset($PAGE_TITLE))     {$PAGE_TITLE="";}
    if (!isset($PAGE_TITLE_EN))  {$PAGE_TITLE_EN = "";}
    if (!isset($INDEX_META_DESC))   {$INDEX_META_DESC = "";}
    if (!isset($INDEX_META_KEYW))   {$INDEX_META_KEYW = "";}
        if ($PAGE_TITLE != ""){ 
            if ($PAGE_ID == "0") { 
                if ($USER_LANG == "FR"){
                    echo $CIE_NOM . " - " . $PAGE_TITLE;
                }else{
                    echo $CIE_NOM . " - " . $PAGE_TITLE_EN;
                } 
            } else { 
                if ($USER_LANG == "FR"){
                    echo $PAGE_TITLE . " - " . $CIE_NOM;
                } else {
                    echo $PAGE_TITLE_EN . " - " . $CIE_NOM;
                }
            } 
        } else { 
            echo $CIE_NOM; 
        }  ?></title>
    <meta name="description" content="<?php echo $INDEX_META_DESC; ?>">
    <meta name="keywords" content="<?php echo $INDEX_META_KEYW; ?>">
    <meta name="author" content="<?php echo $CIE_NOM; ?>">
    <meta name="theme-color" content="#<?php echo $CIE_COLOR8??'444'; ?>">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="all">
    <!-- <script src="https://www.gstatic.com/charts/loader.js"></script> -->
	<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> -->
    <script type="importmap">{"imports": {"three": "/api/three.js/build/three.module.js","three/addons/": "./jsm/"}}</script>
    <script async src="https://unpkg.com/es-module-shims@1.3.6/dist/es-module-shims.js"></script>
	<meta name="viewport" content="width=device-width, height=device-height, viewport-fit=cover, shrink-to-fit=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0" />
        <link rel="apple-touch-icon" sizes="180x180" href="/pub/img/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/pub/img/favicon-96x96.png">
        <link rel="icon" type="image/svg+xml" href="/pub/img/favicon.svg">
        <link rel="shortcut icon" href="/pub/img/favicon.ico">
        <link rel="manifest" href="/manifest.json">
        <?php if ($_SERVER['SCRIPT_FILENAME'] == $_SERVER["DOCUMENT_ROOT"] . "/pub/page/contact3/index.php"){ echo '<link rel="canonical" href="/pub/page/contact3/" />'; }?>
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-config" content="/pub/img/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">
        <meta property="og:image" content="https://<?php echo $_SERVER["SERVER_NAME"];?>/pub/img/favicon.svg" />
        <link rel="image_src" href="https://<?php echo $_SERVER["SERVER_NAME"];?>/pub/img/favicon.svg" />
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/index.css.php'; ?>
    </style>
<?php if (isset($INDEX_FOOTER)&&$INDEX_FOOTER=="/pub/section/footer15.php"){ ?>
    <!-- TrustBox script -->
    <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
    <!-- End TrustBox script -->
<?php } if (isset($CIE_GANALYTICS)&&$CIE_GANALYTICS!=""){ ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $CIE_GANALYTICS;?>">
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo $CIE_GANALYTICS;?>');
    </script>
<?php } 
$TABINDEX = 0; 
if (!isset($CIE_LOGO3))     {$CIE_LOGO3 = "";}
if (!isset($PAGE_ID))       {$PAGE_ID = "";}
if (!isset($CIE_COLOR8_3S)) {$CIE_COLOR8_3S = "";}
if (!isset($CIE_COLOR8_3))  {$CIE_COLOR8_3 = "";}
if (!isset($CIE_COLOR8_4S)) {$CIE_COLOR8_4S = "";}
if (!isset($CIE_COLOR8_4))  {$CIE_COLOR8_4 = "";}
if (!isset($CIE_TEL1))      {$CIE_TEL1 = "";}
if (!isset($CIE_COLOR9))    {$CIE_COLOR9 = "";}
if (!isset($CIE_EML))       {$CIE_EML = "";}
if (!isset($CIE_OPEN_J1_TXT)){$CIE_OPEN_J1_TXT = "";}
if (!isset($CIE_OPEN_J2_TXT)){$CIE_OPEN_J2_TXT = "";}
if (!isset($CIE_OPEN_J3_TXT)){$CIE_OPEN_J3_TXT = "";}
if (!isset($CIE_OPEN_J4_TXT)){$CIE_OPEN_J4_TXT = "";}
if (!isset($CIE_OPEN_J5_TXT)){$CIE_OPEN_J5_TXT = "";}
if (!isset($CIE_OPEN_J6_TXT)){$CIE_OPEN_J6_TXT = "";}
if (!isset($CIE_OPEN_J0_TXT)){$CIE_OPEN_J0_TXT = "";}

if (isset($CIE_SCHAT_KEY1) && $CIE_SCHAT_KEY1!="" && $CIE_SCHAT_ACTIVE == "checked"){ ?><script>
(function (w, d, t, u, i) {
        w.aiChat = w.aiChat || function () {
            (w.aiChat.q = w.aiChat.q || []).push(arguments);
        };
        var s = d.createElement(t);
        s.async = true;
        s.src = u;
        s.onload = function () {
            w.aiChat('init', {id: i});
        };
        d.head.appendChild(s);
    })(window, document, 'script', 'https://supportchat.ca/js/chat-widget.js', '<?php echo $CIE_SCHAT_KEY1; ?>');
</script><?php } ?>

</head><body><header>
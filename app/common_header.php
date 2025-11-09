<!DOCTYPE html><html lang="fr-CA"><head><meta charset="utf-8">
<title><?php echo $APNAME . " - " . $CIE_NOM; ?></title>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="/pub/js/jquery-3.7.1.min.js"></script>
	<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
	<meta name="viewport" content="width=device-width, viewport-fit=cover, user-scalable=no, shrink-to-fit=no, initial-scale=1.0, maximum-scale=1.0" />
	<link rel="shortcut icon" href="/pub/img/favicon.ico">
	<meta name="application-name" content="<?php echo $APNAME. "-" . $CIE_NOM; ?>"/>
	<meta name="msapplication-TileColor" content="#FFFFFF" />
	<meta name="msapplication-TileImage" content="<?php echo $domain_path; ?>pub/img/favicon.ico" />
    <script type="importmap">{"imports": {"three": "/api/three.js/build/three.module.js","three/addons/": "./jsm/"}}</script>
    <script async src="https://unpkg.com/es-module-shims@1.3.6/dist/es-module-shims.js"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="/pub/js/signature_pad.min.js" referrerpolicy="no-referrer"></script> 
    <script src="/pub/js/JsBarcode.all.min.js"></script>
    <script type="text/javascript" src="/pub/js/pdfmake.min.js"></script>
    <script type="text/javascript" src="/pub/js/vfs_fonts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <script src="https://d3js.org/d3.v3.min.js"></script> -->
    <script>const process = { env: {} };process.env.GOOGLE_MAPS_API_KEY ="<?php echo($CIE_GMAP_KEY); ?>";</script>
    <script src="/pub/js/multiavatar.min.js"></script>
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/pub/css/main.css.php'; ?>
</style>   
</head>
<body>
<!-- <div id="bg" style='background:rgba(255,255,255,0.6);'></div> -->
<div id='divTOOL'></div>
<div id='divFADE'></div>
<div id='divFADE2'></div>
<div id='divMENU_BTN'><span class="material-icons" style='position:absolute;top:4px;left:15px;font-size:20px;'><?php echo $PAGE_ICON; ?></span><span style='position:absolute;top:24px;left:2px;font-size:7px;width:90%;color:<?php echo $CIE_COLOR1??'777'; ?>;text-shadow:<?php echo $CIE_COLOR2??'777'; ?>;text-align:center;'><?php echo $APNAME; ?></span></div>
<div id='divMENU'>
	<div id='divMENU_TOP'>
    <img src="/pub/img/<?php echo $CIE_LOGO4; ?>" style='height:34px;width:auto;'> <?php echo $CIE_NOM_HTML; ?>
	</div>
	<div style='overflow-y:scroll;overflow-x:hidden;max-height:75vh;'><?php echo $MENU; ?></div>
    <div id='divMENU_BOT' style='background:#" . $CIE_COLOR1 . ";color:#" . $CIE_COLOR2 . ";' onclick='logOUT();'> <span class='material-icons'>logout</span> <b><?php echo $dw3_lbl["LOGOUT"]; ?></b></div>
</div>
<div id='dw3_notif_container'></div>

<div id='divUPLOAD' style='display:none;'>
    <form id='frmUPLOAD' method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload" onchange="document.getElementById('submitUPLOAD').click();">    
    <input type="text" name="fileNameUpload" id="fileNameUpload" value='0'>
    <input type="submit" value="Upload Image" name="submit" id='submitUPLOAD'>
    </form>
    <input type="text" id="fileToUploadOutput" value=''>
</div>

<div id='divUPLOAD_OPT' style='display:none;'>
    <form id='frmUPLOAD_OPT' method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToOpt" id="fileToOpt" onchange="document.getElementById('submitUPLOAD_OPT').click();">    
    <input type="text" name="fileNameOpt" id="fileNameOpt" value='0'>
    <input type="submit" value="Upload Image" name="submit_opt" id='submitUPLOAD_OPT'>
    </form>
</div>
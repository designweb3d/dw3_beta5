<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$target  = $_GET['TARGET'];
$upath  = $_GET['PATH']??'/pub/upload/';
$filenames = []; 
$dirpath = $_SERVER['DOCUMENT_ROOT'] . $upath;
$folder=scandir($dirpath);
foreach($folder as $file) {
    if (!is_dir($dirpath . $file) && $file != "." && $file != ".."){
        $filenames[] = $file;
    }
}

    $html = "<div style='width:345px;height:400px;overflow:auto;'>
    <div style='position:sticky;top:0px'>
    <button onclick='closeMSG();' class='grey'><span class=\"material-icons\">close</span>Annuler</button>
    <button onclick=\"dw3_file_replace='unknow';document.getElementById('fileToUpload').click();\" class='blue'><span class=\"material-icons\">add</span>Ajouter</button>
    </div>
    <div id='divFILES'>";
    if(count($filenames)>=1){
        foreach($filenames as $file) {
               $html .= "<button onclick=\"selSECTION_IMG('".$target."','".$file."');closeMSG();\" style='vertical-align:bottom;margin:3px;color:#111;text-shadow: 1px 1px #1baff3;height:160px;width:160px;background-image: url(\"". $upath . $file . "\");background-size:cover;'><div style='display:inline-block;background:rgba(255,255,255,0.7);padding:3px;border-radius:3px;width:100%;max-width:100%;font-size:0.7em;vertical-align:bottom;'>" . $file . "</div></button>";
        }
    }
$html .= "</div>";
$dw3_conn->close();
die($html);
?>
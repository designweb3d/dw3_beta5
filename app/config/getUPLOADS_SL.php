<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$section_id  = $_GET['sid'];
$upath  = $_GET['PATH']??'/pub/upload/';
$filenames = []; 
$dirpath = $_SERVER['DOCUMENT_ROOT'] . $upath;
$folder=scandir($dirpath);
foreach($folder as $file) {
    if (!is_dir($dirpath . $file) && $file != "." && $file != ".."){
        $filenames[] = $file;
    }
}

    $html = "<div style='max-width:95vw;max-height:90vh;overflow-x:hidden;overflow-y:auto;'>
    <div position:sticky;top:0px;'><button onclick=\"document.getElementById('fileToUpload').click();\"><span class=\"material-icons\">add</span>Ajouter</button>
    <button onclick='closeMSG();' style='background-color:#444;'><span class=\"material-icons\">add</span>Annuler</button></div>
    <div id='divFILES'>";
    if(count($filenames)>=1){
        foreach($filenames as $file) {
               $html .= "<div style='display:inline-block;margin:3px;box-shadow:0px 0px 5px 2px #EEE;background-color:white;color:#333;'><button style='background-color:red;color:yellow;' onclick=\"delFILE_SL('".$file."','".$section_id."');\"> <span class=\"material-icons\">cancel</span </button><button onclick=\"newSLIDE('".$section_id."','".$file."');closeMSG();\" style='margin:0px 3px 0px 3px;color:#111;text-shadow: 1px 1px #1baff3;height:auto;width:80%;min-width:100px;max-width:300px;background-image: url(\"". $upath . $file . "\");background-size:100% 100%;'><span style='background:rgba(255,255,255,0.7);padding:3px;border-radius:3px;margin-top:75px;'>" . $file . "</span></button></div>";
        }
    }
$html .= "</div>";
$dw3_conn->close();
die($html);
?>
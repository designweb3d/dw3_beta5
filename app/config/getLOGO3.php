<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$target  = $_GET['TARGET'];
$upath  = $_GET['PATH']??'/pub/img/';
$filenames = []; 
$dirpath = $_SERVER['DOCUMENT_ROOT'] . $upath;
$folder=scandir($dirpath);
foreach($folder as $file) {
    if (!is_dir($dirpath . $file) && $file != "." && $file != ".."){
        $filenames[] = $file;
    }
}

    $html = "<div style='width:350px;height:400px;overflow:auto;'>
    <button onclick=\"document.getElementById('fileToImg').click();\" style='position:sticky;top:0px;'><span class=\"material-icons\">add</span>Ajouter</button>
    <button onclick='closeMSG();' class='grey' style='position:sticky;top:0px;'><span class=\"material-icons\">cancel</span>Annuler</button>
    <div id='divFILES'>";
    if(count($filenames)>=1){
        foreach($filenames as $file) {
            $html .= "<button onclick=\"selLOGO3_IMG('".$target."','".$file."');closeMSG();\" style='margin:0px 3px 0px 3px;color:#111;text-shadow: 1px 1px #1baff3;height:150px;width:150px;background-image: url(\"". $upath . $file . "\");background-size:100% auto;background-repeat:no-repeat;background-position: center;background-color:white;'><span style='background:rgba(255,255,255,0.7);padding:3px;border-radius:3px;margin-top:95px;width:100%;'>" . $file . "</span></button>";
        }
    }
$html .= "</div>";
$dw3_conn->close();
die($html);
?>
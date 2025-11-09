<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$upath  = '/pub/font_lib/';
$filenames = []; 
$dirpath = $_SERVER['DOCUMENT_ROOT'] . $upath;
$folder=scandir($dirpath);
foreach($folder as $file) {
    if (!is_dir($dirpath . $file) && $file != "." && $file != ".."){
        $filenames[] = $file;
    } 
}

    $html = "<div style='width:250px;height:400px;overflow:auto;'>
    <div style='position:absolute;top:20;left:0;right:10px;text-align:center;'>
        <button class='blue' onclick=\"document.getElementById('fileToFont').click();\"><span class=\"material-icons\">add</span> Ajouter</button>
        <button class='grey' onclick='closeMSG();'><span class=\"material-icons\">cancel</span> Annuler</button>
    </div>
    <div style='margin-top:55px;'>";
    if($USER_LANG=="FR"){
        $html .= "<b>Choisir une police :</b><br><small> (Les noms de fichiers des polices que vous ajouter doivent porter le nom de la police et avoir l'extension .ttf)</small><br>";
    } else {
        $html .= "<b>Select a font :</b><br><small> (Font file names must match the font name and have the .ttf extension)</small><br>";
    }
    if(count($filenames)>=1){
        foreach($filenames as $file) {
            $fn=basename($file, ".ttf");
            $html .= "<button class='white' onclick=\"copyFONT('".$file."');closeMSG();\" style='margin:1px;padding:4px;font-size:18px;color:#444;height:auto;font-family:". $fn . ";background-color:white;width:200px;'>" . $fn . "</button><br>";
        }
    }
$html .= "</div>";
$dw3_conn->close();
die($html);
?>
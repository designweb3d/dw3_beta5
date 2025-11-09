<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$target  = $_GET['TARGET'];
$filenames = []; 
$dirpath = $_SERVER['DOCUMENT_ROOT'] ."/pub/img/avatar/";
$folder=scandir($dirpath);
foreach($folder as $file) {
    if (!is_dir($dirpath . $file) && $file != "." && $file != ".."){
        $filenames[] = $file;
    }
}

    $html = "<button onclick='closeMSG();' class='dw3_close'><span class=\"material-icons\">close</span></button>
    <div style='width:250px;height:400px;overflow:auto;'>
    <div id='divFILES'>";
    if(count($filenames)>=1){
        foreach($filenames as $file) {
               $html .= "<button onclick=\"dw3_opt_picture2('".$target."','".$file."');closeMSG();\" style='margin:0px 3px 0px 3px;color:#111;text-shadow: 1px 1px #1baff3;height:auto;width:80%;min-width:100px;background-image: url(\"/pub/img/avatar/" . $file . "\");background-size:100% 100%;'><span style='background:rgba(255,255,255,0.7);padding:3px;border-radius:3px;margin-top:75px;'>" . $file . "</span></button>";
        } 
    }
$html .= "</div>";
$dw3_conn->close();
die($html);
?>
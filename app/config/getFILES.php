<?php 
//SCRIPT FOR FILE MANAGER
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$DIR  = $_GET['DIR'];
if ($DIR == "img"){
    $sys_dir = "/pub/img/";
} else if ($DIR == "upload"){
    $sys_dir = "/pub/upload/";
}

$html = "";
$folder=scandir($_SERVER['DOCUMENT_ROOT'] .$sys_dir);
    foreach($folder as $file) {
        if (!is_dir($_SERVER['DOCUMENT_ROOT'] .$sys_dir . $file) && $file != "." && $file != ".."){
            $source_file = $_SERVER['DOCUMENT_ROOT'] .$sys_dir .$file;
            $imageFileType = strtolower(pathinfo($source_file,PATHINFO_EXTENSION));
            //file size
            if (filesize($source_file) <= 1024){ 
                $file_size = filesize($source_file) . " bytes";
            }else if (filesize($source_file) >= 1048576){
                $file_size = round((filesize($source_file)/1024)/1024,2) . "MB";
            } else {
                $file_size = round(filesize($source_file)/1024) . "KB";
            }
            //image size
            $check = getimagesize($_SERVER['DOCUMENT_ROOT'] .$sys_dir.$file);
            if ($check === false) {
                $image_width = "";
                $image_height = "";
            } else {
                $image_width = "".$check[0];
                $image_height = "".$check[1];
            }
            if($image_width != ""){
                $file_dimensions = $image_width . " x " . $image_height;
            } else {
                $file_dimensions = "";
            }
            if (strlen($file)>16){
                $file_name = substr($file,0,10)."..".substr($file,-6);
            } else {
                $file_name = $file;
            }
            //last_modified
            $file_modified = date("Y-m-d", filemtime($source_file));
            if ($DIR == "img"){
                $html .= "<div style='display:inline-block;position: relative;'><button class='red' onclick=\"delIMG('".$file."')\" style='padding:5px;position:absolute;top:-3px;right:-3px;'><span class='material-icons' style='vertical-align:middle;'>delete_forever</span></button><button onclick='getFILE_OPT(\"".$file."\");' style=\"margin:3px;color:#111;height:150px;width:150px;background-size:cover;background-position:center center;background-repeat:no-repeat;background-image: url('/pub/img/" . $file . "');\"><div style='background:rgba(255,255,255,0.7);padding:3px;border-radius:3px;max-width:100%;word-break: break-all;'>" . $file_name . "<br>" . $file_size. "<br>". $file_modified . "<br>" . $file_dimensions . "</div></button></div>";
            } else if ($DIR == "upload"){
                $html .= "<div style='display:inline-block;position: relative;'><button class='red' onclick=\"delUPLOAD('".$file."')\" style='padding:5px;position:absolute;top:-3px;right:-3px;'><span class='material-icons' style='vertical-align:middle;'>delete_forever</span></button><button onclick='getFILE_OPT(\"".$file."\");' style=\"margin:3px;color:#111;height:150px;width:150px;background-size:cover;background-position:center center;background-repeat:no-repeat;background-image: url('/pub/upload/" . $file . "');\"><div style='background:rgba(255,255,255,0.7);padding:3px;border-radius:3px;max-width:100%;word-break: break-all;'>" . $file_name . "<br>" . $file_size. "<br>". $file_modified . "<br>" . $file_dimensions . "</div></button></div>";
            }
        }
    }

$dw3_conn->close();
header('Status: 200');
die($html);
?>
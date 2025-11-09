<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$file = $_GET['file'];
$file = $_SERVER['DOCUMENT_ROOT'] ."/pub/upload/" . $file ;
$dw3_conn->close();
$html="";
if (!file_exists($file)) {
    die("File do not exist.");
}
$html .= "<input type='text' disabled id='txtURL_IMG' style='display:none;' value='" . $_GET['file']. "'>";
$html .= "<u>File:</u> <b>" . $_GET['file'] . "</b><br>";
$html .= "<u>Extension:</u> <b>" . pathinfo($file,PATHINFO_EXTENSION) . "</b><br>";
if (filesize($file) <= 1024){ 
    $html .= "<u>Size:</u> <b>" . filesize($file) . " bytes</b><br>";
}else if (filesize($file) >= 1048576){
    $html .= "<u>Size:</u> <b>" . round((filesize($file)/1024)/1024,2) . "MB</b><br>";
} else {
    $html .= "<u>Size:</u> <b>" . round(filesize($file)/1024) . "KB</b><br>";
}
list($width, $height) = getimagesize($file);
if($width !== false){
    $html .= "<u>Width:</u> <b>" . $width . "</b><br>";
    $html .= "<u>Height:</u> <b>" . $height . "</b><br>";
}
$html .= "<u>Last modified:</u> <b>" . date("Y-m-d", filemtime($file)) . "</b><br>";
$html .= "<u>Last accessed:</u> <b>" . date("Y-m-d", fileatime($file)) . "</b><br>";
die($html);
?>
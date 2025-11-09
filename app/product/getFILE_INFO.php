<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$file = $_GET['file'];
$file = $_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $ID . "/" . $file ;
$dw3_conn->close();
$html="";
if (!file_exists($file)) {
    die("File do not exist.");
}
$html .= "<input type='text' disabled id='txtURL_IMG' style='display:none;' value='" . $_GET['file']. "'>";
if ($APREAD_ONLY == false) { 
    $html .= "<button onclick=\"dw3_gal2_show('https://".$_SERVER['SERVER_NAME']."/fs/product/" . $ID . "/" . $_GET['file'] ."?t=".rand(1,100000)."');\" style='float:right;'><span class='material-icons'>zoom_out_map</span></button>
    <button onclick=\"rotate_picture('" . $ID . "','" . $_GET['file'] ."');\" style='float:right;'><span class='material-icons'>rotate_90_degrees_ccw</span></button>";
}
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
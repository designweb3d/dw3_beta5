<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$LOG_DIR  = mysqli_real_escape_string($dw3_conn, $_GET['L']);
if ($LOG_DIR == 'root'){
    $file_path = $_SERVER['DOCUMENT_ROOT'] . "/" ;
}else{
    $file_path =  $_SERVER['DOCUMENT_ROOT'] . "/" . $LOG_DIR. "/";
}
if (!file_exists($file_path. "error_log")){
    $dw3_conn->close(); 
    die("<b>" . $file_path. "error_log</b> not found");
}
$lines = file($file_path . "error_log");
$count = 0;
$lines_size = 0;
$html = "";
if (count($lines)){
    foreach($lines as $line) {
        $count += 1;
        $html .= str_pad($count, 3, 0, STR_PAD_LEFT).". ".$line . "<br style='margin:0px;'>";
        $lines_size = $lines_size + strlen($line);
    }
}

    if ($lines_size < 1024){
        $lines_size = $lines_size . "b";
    } else if ($lines_size >= 1024 && $lines_size < (1024*1024)){
        $lines_size = round($lines_size/1024). "Kb";
    } else if ($lines_size >= (1024*1024)){
        $lines_size = round($lines_size/(1024*1024)). "Mb";
    }

$dw3_conn->close(); 
die("File size: <b>". $lines_size. "</b><br style='margin:0px;'>" . $html);
?>
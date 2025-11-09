<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$html = "";


$myfile = fopen($req_root . "/error_log", "r")??null;
$html .= fread($myfile,filesize($req_root . "/error_log"))??null;
fclose($myfile);
$html .= "\nLast modified:" . date("Y-m-d", filemtime($req_root . "/error_log"))


die $html;    
?>
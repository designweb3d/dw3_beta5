<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$html = $_POST['sitemap_xml'];
$myfile = fopen($req_root . "/sitemap.xml", "w") or die("Unable to update file!");
fwrite($myfile, $html);
fclose($myfile);
$dw3_conn->close();
header("HTTP/1.1 204 NO CONTENT");
exit();
?>
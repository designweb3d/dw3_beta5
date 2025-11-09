<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$html = $_POST['conditions_html'];
$myfile = fopen($req_root . "/legal/CONDITIONS.html", "w") or die("Unable to update file!");
fwrite($myfile, $html);
fclose($myfile);
$dw3_conn->close();
header("HTTP/1.1 204 NO CONTENT");
exit();
?>
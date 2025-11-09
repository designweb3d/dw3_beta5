<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dompdf/autoload.inc.php';

//$HTML = htmlspecialchars_decode($_GET['HTML']);
//$HTML = htmlspecialchars_decode($_POST);
//$HTML = htmlspecialchars_decode(file_get_contents('php://input'));
//$HTML = htmlspecialchars_decode(stream_get_contents(STDIN));
$body = file_get_contents('php://input');
//if(!empty($_POST)) { $HTML .= implode(",", $_POST); }
$HTML = urldecode($body);

$myfile = fopen("plan.txt", "w") or die("Unable to open file!");
fwrite($myfile,$HTML);
fclose($myfile);

$conn->close();
die();

?>
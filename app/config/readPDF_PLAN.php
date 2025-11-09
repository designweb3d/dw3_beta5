<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dompdf/autoload.inc.php';
//$HTML = htmlspecialchars_decode($_GET['HTML']);
//$HTML = htmlspecialchars_decode($_POST);
//$HTML = htmlspecialchars_decode(file_get_contents('php://input'));
//$HTML = htmlspecialchars_decode(stream_get_contents(STDIN));
//$body = file_get_contents('php://input');
//if(!empty($_POST)) { $HTML .= implode(",", $_POST); }
//$HTML = urldecode($body);

//$myfile = fopen("plan.txt", "w") or die("Unable to open file!");
$myfile = fopen("plan.txt", "r") or die("Unable to open file!");
$HTML = fread($myfile,filesize("plan.txt"));
fclose($myfile);

$dw3_conn->close();
//die();

use Dompdf\Dompdf; 
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isJavascriptEnabled', TRUE);
$dompdf = new Dompdf($options);
$dompdf->set_option('defaultMediaType', 'all');
$dompdf->set_option('isFontSubsettingEnabled', true);


$dompdf->loadHtml($HTML, 'UTF-8'); 
 
// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A4', 'portrait'); 
//$dompdf->setPaper('A4', 'landscape'); 
 
// Render the HTML as PDF 
$dompdf->render(); 
 
// Output the generated PDF to Browser 
$dompdf->stream("Plan2023.pdf")

?>
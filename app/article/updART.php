<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dompdf/autoload.inc.php';
use Dompdf\Dompdf; 
use Dompdf\Options;

$ID= $_POST['ID'];
$title_fr = mysqli_real_escape_string($dw3_conn,$_POST['TITLE_FR']);
$title_en = mysqli_real_escape_string($dw3_conn,$_POST['TITLE_EN']);
$html_fr = mysqli_real_escape_string($dw3_conn,$_POST['HTML_FR']);
$html_en = mysqli_real_escape_string($dw3_conn,$_POST['HTML_EN']);
$desc_fr = mysqli_real_escape_string($dw3_conn,$_POST['DESC_FR']);
$desc_en = mysqli_real_escape_string($dw3_conn,$_POST['DESC_EN']);
$cat_fr = mysqli_real_escape_string($dw3_conn,$_POST['CAT_FR']);
$cat_en = mysqli_real_escape_string($dw3_conn,$_POST['CAT_EN']);
$img_link = mysqli_real_escape_string($dw3_conn,$_POST['IMG']);
$author_name = mysqli_real_escape_string($dw3_conn,$_POST['AUTHOR']);
$is_active = mysqli_real_escape_string($dw3_conn,$_POST['ACTIVE']);
$comment = mysqli_real_escape_string($dw3_conn,$_POST['COMMENT']);
$created = mysqli_real_escape_string($dw3_conn,$_POST['CREATED']);
$modified = mysqli_real_escape_string($dw3_conn,$_POST['MODIFIED']);


$sql = "UPDATE article SET    
title_fr = '" . $title_fr . "',
title_en = '" . $title_en . "',
description_fr = '" . $desc_fr . "',
description_en = '" . $desc_en . "',
category_fr = '" . $cat_fr . "',
category_en = '" . $cat_en . "',
html_fr = '" . $html_fr . "',
html_en = '" . $html_en . "',
img_link = '" . $img_link . "',
author_name = '" . $author_name . "',
is_active = '" . $is_active . "',
allow_comments = '" . $comment . "',
date_created = '" . $created . "',
date_modified = '" . $modified . "'
WHERE id = '" . $ID . "' 
LIMIT 1";

if ($dw3_conn->query($sql) === TRUE) {
    echo "";
} else {
    echo $dw3_conn->error;
}

//fr
$output = "<html><head><title>".$_POST['TITLE_FR']."</title><style>
@page {
    margin-top: 120px;
    margin-bottom: 50px;
}
main {
    break-inside: auto;
}

header {
    position: fixed;
    top: 0px;
    left: 0px;
    right: 0px;
    height: 100px;
    margin-top: -110px;
}

footer {
    position: fixed; 
    bottom: 0px; 
    left: 0px; 
    right: 0px;
    height: 20px; 
    margin-bottom: -40px;
}
body{font-size:16px;font-family:Tahoma;}
br { content: ' '; display: block; margin:0px; font-size:0px;}
</style></head><body>";
$output .= "<header><table style='width:100%;'><tr><td><h3 style='font-family:Imperial;text-transform: uppercase;text-align:left;'>".$_POST['TITLE_FR']."</h3></td><td style='text-align:right;'>".substr($created,0,10)."</td></tr></table></header>    
<footer> &copy; ".$CIE_NOM." " .date('Y'). "</footer><main>";
$output .= "<img src='https://".$_SERVER["SERVER_NAME"].$img_link."' style='width:100%;'><br><div style='margin:20px 0px;'><b>".$_POST['DESC_FR']."</b></div><br>".$_POST['HTML_FR'];
$output .= "</main></body></html>";

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isJavascriptEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('defaultMediaType', 'all');
$dompdf->set_option('isFontSubsettingEnabled', true);
$dompdf->loadHtml($output, 'UTF-8');
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();
$font = $dompdf->getFontMetrics()->get_font("Tahoma", "");
$dompdf->get_canvas()->page_text(577, 770, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0,0,0));
$output_pdf = $dompdf->output();
$output_fn = $_SERVER['DOCUMENT_ROOT'] . "/pub/download/Article_".$ID.".pdf";
file_put_contents($output_fn, $output_pdf);

//eng
$output = "<html><head><title>".$_POST['TITLE_EN']."</title><style>
@page {
    margin-top: 120px;
    margin-bottom: 50px;
}
main {
    break-inside: auto;
}

header {
    position: fixed;
    top: 0px;
    left: 0px;
    right: 0px;
    height: 100px;
    margin-top: -110px;
}

footer {
    position: fixed; 
    bottom: 0px; 
    left: 0px; 
    right: 0px;
    height: 20px; 
    margin-bottom: -40px;
}
body{font-size:16px;font-family:Tahoma;}
br { content: ' '; display: block; margin:0px; font-size:0px;}
</style></head><body>";
$output .= "<header><table style='width:100%;'><tr><td><h3 style='font-family:Imperial;text-transform: uppercase;text-align:left;'>".$_POST['TITLE_EN']."</h3></td><td style='text-align:right;'>".substr($created,0,10)."</td></tr></table></header>    
<footer> &copy; ".$CIE_NOM." " .date('Y'). "</footer><main>";
$output .= "<img src='https://".$_SERVER["SERVER_NAME"].$img_link."' style='width:100%;'><br><div style='margin:20px 0px;'><b>".$_POST['DESC_FR']."</b></div><br>".$_POST['HTML_EN'];
$output .= "</main></body></html>";

$options2 = new Options();
$options2->set('isRemoteEnabled', true);
$options2->set('isJavascriptEnabled', true);
$dompdf2 = new Dompdf($options2);
$dompdf2->set_option('isHtml5ParserEnabled', true);
$dompdf2->set_option('defaultMediaType', 'all');
$dompdf2->set_option('isFontSubsettingEnabled', true);
$dompdf2->loadHtml($output, 'UTF-8');
$dompdf2->setPaper('letter', 'portrait');
$dompdf2->render();
$font2 = $dompdf2->getFontMetrics()->get_font("Tahoma", "");
$dompdf2->get_canvas()->page_text(577, 770, "{PAGE_NUM} / {PAGE_COUNT}", $font2, 10, array(0,0,0));
$output_pdf2 = $dompdf2->output();
$output_fn2 = $_SERVER['DOCUMENT_ROOT'] . "/pub/download/News_".$ID.".pdf";
file_put_contents($output_fn2, $output_pdf2);

$dw3_conn->close();
die();
?>
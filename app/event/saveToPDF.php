<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dompdf/autoload.inc.php';
$SS  = str_replace("\"", "\'", str_replace("'", "\'", $_GET['SS'])); //RECHERCHE 
$evTYPE  = $_GET['TYPE'];

use Dompdf\Dompdf; 
use Dompdf\Options;

if ($evTYPE == "PRIVACY_INCIDENT"){
    $event_type = "d'incidents de confidentialité";
} else if ($evTYPE == "TASK"){
    $event_type = "des tâches";
} else if ($evTYPE == "PUBLIC"){
    $event_type = "d'évènements publique";
} else if ($evTYPE == "ROAD_INCIDENT"){
    $event_type = "d'incidents de la route";
} else if ($evTYPE == "CALL_INFO"){
    $event_type = "d'appels d'un client pour de l'information";
} else if ($evTYPE == "CALL_TECH"){
    $event_type = "d'appels d'un client pour du support";
} else if ($evTYPE == "CALL_INCIDENT"){
    $event_type = "d'appels d'un client pour une plainte";
} else if ($evTYPE == "SYSTEM"){
    $event_type = "d'action du système";
} else {
    $event_type = "d'évènements";
}

$sql = "SELECT * FROM event WHERE id > -1 ";
if ($evTYPE != ""){ $sql = $sql . " AND  event_type = '" . $evTYPE . "' "; }
if ($SS != ""){ $sql = $sql . " AND  CONCAT(name, event_type, description) like '%" . $SS . "%' "; }			
$sql = $sql . " ORDER BY date_start DESC LIMIT 400";

$html_PDF = "<!DOCTYPE html><html><head><meta charset='utf-8'>
    <title>" . $CIE_NOM . "</title><meta http-equiv=\"Content-Type\" content=\"text/html\">
    <style>
        body { margin: 150px 30px 50px 30px; }
        @page {margin: 0cm 0cm;}
        header {position: fixed;top: 0px;left: 0px;right: 0px;height: 140px;}
        footer {position: fixed; bottom: 0px; left: 0px; right: 0px;height: 50px; }
        footer .page-number:after { content: counter(page);}
    </style></head>
    <body style='text-align:left;'><header>
        <table style='width:100%;'><tr><td style='text-align:left;padding:10px;'><img src='https://" . $_SERVER["SERVER_NAME"] . "/pub/img/".$CIE_LOGO2."' style='height:80px;width:auto;max-width:500px;'><br>
        <div style='width:100%;text-align:center;'>
        <h3>Rapport ".$event_type."</h3>
        </div></td>
            <td style='vertical-align:top;text-align:right;padding:25px 10px;'>Date du rapport:</td>
            <td style='vertical-align:top;text-align:left;padding:25px 10px;'><b>" . $today . "</b></td></tr>
        </table></header><main>";
    $result = $dw3_conn->query($sql);
    $numrows = $result->num_rows;
    
    if ($numrows > 0) {	
        $html_PDF.= "<table cellspacing=0 style='width:100%;border-collapse: collapse;border-left: none;border-right: none;'>
        <tr style='background:white;'><th style='text-align:left;'>Date et heure</th><th style='text-align:left;'>Type d'évènement</th><th style='text-align:left;'>Nom de l'évènement</th></tr>";
        while($row = $result->fetch_assoc()) {
            if ($row["event_type"] == "PRIVACY_INCIDENT"){
                $event_type = "Incident de confidentialité";
            } else if ($row["event_type"] == "TASK"){
                $event_type = "Tâche";
            } else if ($row["event_type"] == "PUBLIC"){
                $event_type = "Évènement publique";
            } else if ($row["event_type"] == "ROAD_INCIDENT"){
                $event_type = "Incident de la route";
            } else if ($row["event_type"] == "CALL_INFO"){
                $event_type = "Appel d'un client pour de l'information";
            } else if ($row["event_type"] == "CALL_TECH"){
                $event_type = "Appel d'un client pour du support";
            } else if ($row["event_type"] == "CALL_INCIDENT"){
                $event_type = "Appel d'un client pour une plainte";
            } else {
                $event_type = "Évènement";
            }
            $html_PDF.= "<tr style='border-top:1px solid lightgrey;'><td>". $row["date_start"] . "</td>";
            $html_PDF.= "<td>". $event_type . "</td>";
            $html_PDF.= "<td>". $row["name"] . "</td>";
            $html_PDF.= "</tr><tr><td colspan='3'>". $row["description"] . "</td></tr>";
        }
        $html_PDF.= "</table></main>";
    }
    $html_PDF .= "<footer><hr><table style='width:100%;'><tr><th style='width:50px;border: 0px solid #333;'>&#160;&#160;</th><th style='border:0px solid grey;'>" . $CIE_NOM . "</th><th style='width:50px;border: 0px solid #333;'></th></tr></table></footer>";
    $html_PDF .= "</body></html>";
    
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isJavascriptEnabled', true);
    //$options->set("isPhpEnabled", true);
    $dompdf = new Dompdf($options);
    $dompdf->set_option('defaultMediaType', 'all');
    $dompdf->set_option('isFontSubsettingEnabled', true);
    $dompdf->loadHtml($html_PDF, 'UTF-8'); 
    $dompdf->setPaper('letter', 'portrait'); 
    $dompdf->render(); 
    $font = $dompdf->getFontMetrics()->get_font("Verdana", "");
    $dompdf->get_canvas()->page_text(577, 770, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0,0,0));
    $file_to_save = $dompdf->output();
    $file_name = "event_report_" . $today . "_" . date("H-i-s") . ".pdf";
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/fs/event/".$file_name, $file_to_save); 

header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="'.$file_name.'"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($_SERVER['DOCUMENT_ROOT'] . "/fs/event/".$file_name));
header('Accept-Ranges: bytes');
readfile($_SERVER['DOCUMENT_ROOT'] . "/fs/event/".$file_name);
exit();
?>

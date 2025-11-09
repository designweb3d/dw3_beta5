<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dompdf/autoload.inc.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/PHPMailer/src/PHPMailer.php';

$SELECTION  = $_GET['LST'];

$DOC_TYPE = "TABLE";
$LIMIT = "5000";

$html = "<html><head><title>CATALOGUE ".date("Y")." ".$CIE_NOM."</title><style>
@font-face {
    font-family: 'Imperial';
    font-style: normal;
    font-weight: 400;
    src:local('Imperial'), url('https://" . $_SERVER["SERVER_NAME"] . "/pub/font/Imperial.ttf') format('truetype');
}
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
body{font-size:14px;font-family:Tahoma;}
a{color:#333;}
input {
    border:0px;
}

    .tblDATA {
        width:100%;
        max-width:100%;
        margin:0px;
        background: rgba(255, 255, 255, 0.1);
        border-collapse: collapse;
        font-family:". $CIE_FONT3.";
    }
    .tblDATA td{
        text-align:left;
        border: 1px solid #ddd;
        padding: 4px;
        color: #".$CIE_COLOR7_4.";
        vertical-align:top;
        
    }
    .tblDATA th{
        text-align:left;
        padding: 6px;
        user-select:none;	
        vertical-align:top;
        background: linear-gradient(180deg,#".$CIE_COLOR6.",#".$CIE_COLOR6_2.");
        color:#".$CIE_COLOR7.";
        cursor:n-resize;
        position: sticky;
        top: 0;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        text-shadow: 1px 1px #222;
    }
    .tblDATA tr:nth-child(even){background-color: #".$CIE_COLOR7_2.";}
    .tblDATA tr:nth-child(odd){background-color: #".$CIE_COLOR7_3.";}
    .tblDATA tr:first-child{border-top-left-radius: 10px;border-top-right-radius: 10px;border-left:1px solid ".$CIE_COLOR6.";}

.divBOX{
    display:inline-block;
    padding:5px;
    border-bottom:1px solid #ddd;
}
br { content: ' '; display: block; margin:0px; font-size:0px;}
</style></head><body>";
    $html .= "<div style='page-break-after: always;'>
    <table style='width:100%;font-size:10px;border-bottom:2px solid #555;'>
        <tr><td style='text-align:center;font-size:53px;font-family:Imperial;'>".$CIE_NOM."</td></tr>
        <tr><td style='text-align:center; width:50%;padding:100px 0px'><img src='https://" . $_SERVER["SERVER_NAME"] . "/pub/img/".$CIE_LOGO1."' style='height:auto;width:50%;'></td></tr>
        <tr><td style='text-align:center;padding:100px 0px'> <div style='border-right:3px solid #333;border-left:3px solid #555;padding:10px 5px;font-weight:bold;'><span style='font-size: 22px;'>CATALOGUE ".date("Y")."</span></div></td></tr>
        <tr><td style='text-align:right;width:260px;'><b style='font-size:14px;'>".$CIE_TEL1."</b><br>".$CIE_EML1."<br>".trim($CIE_ADR1." ".$CIE_ADR2)." ".$CIE_VILLE.",<br>".$CIE_PROV." ".$CIE_PAYS." ".$CIE_CP."<br><a href='https://".$_SERVER["SERVER_NAME"]."'>www.".$_SERVER["SERVER_NAME"]."</a></td></tr>
    </tr></table>
    </div>";
    $html .= "<header><table style='width:100%;'><tr><td><h3 style='font-family:Imperial;text-transform: uppercase;text-align:left;'>".$CIE_NOM."</h3></td><td style='text-align:right;'>CATALOGUE ".date("Y")."</td></tr></table></header>    
    <footer> &copy; ".$CIE_NOM." " .date('Y'). "</footer><main>";


	//PARAMETRES D'AFFICHAGE
	$sqlx = "SELECT *
			FROM app_prm
			WHERE app_id = '" . $APID . "'
			AND   user_id = '" . $USER . "'
			ORDER BY value";
	$result = $dw3_conn->query($sqlx);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			switch ($row["name"]) {
				case 'DOC_TYPE':
					$DOC_TYPE = $row["value"];
					break;
				case 'ORDERBY':
					$ORDERBY = $row["value"];
					break;
				case 'ORDERWAY':
					$ORDERWAY = $row["value"];
					break;				
				case 'LIMIT':
					if ($row["value"] != ''){ $LIMIT = $row["value"]; }
					break;
				case 'ID':
					$DSP_ID = $row["value"];
					break;
				case 'STAT':
					$DSP_STAT = $row["value"];
					break;
				case 'NOM':
					$DSP_NOM = $row["value"];
					break;
                case 'DESC':
                    $DSP_DESC = $row["value"];
                    break;
                case 'PACK':
                    $DSP_PACK = $row["value"];
                    break;
                case 'PRIX_ACH':
                    $DSP_PRIX_ACH = $row["value"];
                    break;
                case 'TOTAL':
                    $DSP_TOTAL = $row["value"];
                    break;
                case 'PRIX_VTE':
                    $DSP_PRIX_VTE = $row["value"];
                    break;
                case 'KG':
                    $DSP_KG = $row["value"];
                    break;
                case 'WIDTH':
                    $DSP_WIDTH = $row["value"];
                    break;
                case 'HEIGHT':
                    $DSP_HEIGHT = $row["value"];
                    break;
                case 'DEPTH':
                    $DSP_DEPTH = $row["value"];
                    break;
                case 'FRN1':
                    $DSP_FRN1 = $row["value"];
                    break;
                case 'CAT':
                    $DSP_CAT = $row["value"];
                    break;
                case 'DTAD':
                    $DSP_DTAD = $row["value"];
                    break;
                case 'DTMD':
                    $DSP_DTMD = $row["value"];
                    break;
            }
        }
    } else {
        $ORDERBY = "PRICE";
        $ORDERWAY = "";
        $DSP_ID = "1";
        $DSP_STAT = "1";
        $DSP_NOM = "1";
        $DSP_DESC = "0";
        $DSP_CAT = "1";
        $DSP_FRN1 = "1";
        $DSP_PACK = "0";
        $DSP_KG = "0";
        $DSP_WIDTH = "0";
        $DSP_HEIGHT = "0";
        $DSP_DEPTH = "0";
        $DSP_TOTAL = "1";
        $DSP_PRIX_ACH = "0";
        $DSP_PRIX_VTE = "1";
        $DSP_DTAD = "0";
        $DSP_DTMD = "0";
        $DOC_TYPE = "TABLE";
    }
//ORDER BY & WAY
    if ($ORDERBY == ""){ $ORDERBY = " trim(A.name_fr) " ;}
	if ($ORDERBY == "NOM"){ $ORDERBY = " trim(A.name_fr) " ;}
	if ($ORDERBY == "CAT"){ $ORDERBY = " C.name_fr" ;}
	if ($ORDERBY == "FRN1"){ $ORDERBY = " A.supplier_id " ;}
	if ($ORDERBY == "KG"){ $ORDERBY = " A.kg " ;}
	if ($ORDERBY == "PRICE"){ $ORDERBY = " A.price1 " ;}
	if ($ORDERBY == "SIZE"){ $ORDERBY = " (A.width*A.height*A.depth) " ;}
	if ($ORDERBY == "DTMD"){ $ORDERBY = " A.date_modified " ;}
	if ($ORDERBY == "ID"){ $ORDERBY = " A.id " ;}
	if ($ORDERWAY == ""){ $ORDERWAY = " ASC " ;}
	
	
//ROW COUNT
$sql = "SELECT COUNT(*) as rowCount
FROM product A
WHERE A.id >= 0 AND id IN ".$SELECTION.";";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$numrows = $data['rowCount'];
//WITH LIMIT
			$sql = "SELECT A.*,B.company_name AS frNAME, IFNULL(C.name_fr,'') AS catNAME, IFNULL(D.name_fr,'') AS catNAME2, IFNULL(E.name_fr,'') AS catNAME3,C.description_fr as category_desc_fr, C.description_en as category_desc_en, C.img_url AS cat_img
				FROM product A
                LEFT JOIN supplier B ON A.supplier_id = B.id
                LEFT JOIN product_category C ON A.category_id = C.id
                LEFT JOIN product_category D ON A.category2_id = D.id
                LEFT JOIN product_category E ON A.category3_id = E.id
				WHERE A.id >= 0 AND A.id IN ".$SELECTION;
			$sql = $sql . "
				ORDER BY " . $ORDERBY . " " . $ORDERWAY . ", A.name_fr ASC
				LIMIT " . $LIMIT . ";";
                $last_cat_name = "";
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
            $html .="<div style='max-width:100%;width:100%;overflow-x:auto;'>" ;		
            if ($DOC_TYPE == "TABLE" || $DOC_TYPE == ""){
                $html .="<table id='dataTABLE' class='tblDATA'>";
            }            
			while($row = $result->fetch_assoc()) {
                //categories
                if ($ORDERBY == " C.name_fr" && $DSP_CAT  == "1"){
                    if ($USER_LANG == "FR"){
                        if ($row["catNAME"] != $last_cat_name){
                            $last_cat_name = $row["catNAME"];
                            $html .= "</table><div style=\"page-break-before: always;width:100%;background-color:#ddd;background-image: url('https://".$_SERVER["SERVER_NAME"].$row["cat_img"]."');background-size:100% auto;background-position:center center;text-align:center;\"><div style='padding:27px 5px;color:#FFF;vertical-align:middle;text-align:center;font-size:40px;text-transform: uppercase;font-weight:bold;font-family:Imperial;text-shadow:0px 0px 2px #000;'>".$row["catNAME"]."</div></div>";
                            if ($row["category_desc_fr"] != ""){
                                $html .= "<br><div class='dw3_box' style='max-width:600px;'>".$row["category_desc_fr"]."</div><br>";
                            }
                            $html .="<table id='dataTABLE' class='tblDATA'>";
                        }
                    } else {
                        if ($row["catNAME"] != $last_cat_name){
                            $last_cat_name = $row["catNAME"];
                            $html .= "</table><div style=\"page-break-before: always;width:100%;background-color:#ddd;background-image: url('https://".$_SERVER["SERVER_NAME"].$row["cat_img"]."');background-size:100% auto;background-position:center center;text-align:center;\"><div style='padding:27px 5px;color:#FFF;vertical-align:middle;text-align:center;font-size:40px;text-transform: uppercase;font-weight:bold;font-family:Imperial;text-shadow:0px 0px 2px #000;'>".$row["catNAME"]."</div></div>";
                            if ($row["category_desc_en"] != ""){
                                $html .= "<br><div class='dw3_box' style='max-width:600px;'>".$row["category_desc_en"]."</div><br>";
                            }
                            $html .="<table id='dataTABLE' class='tblDATA'>";
                        }
                    }
                }
                //image
                $filename= $row["url_img"];
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                    $filename = "https://" . $_SERVER["SERVER_NAME"] ."/pub/img/dw3/nd.png";
                } else {
                    if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                        $filename = "https://" . $_SERVER["SERVER_NAME"] . "/pub/img/dw3/nd.png";
                    }else{
                        $filename = "https://" . $_SERVER["SERVER_NAME"] . "/fs/product/" . $row["id"] . "/" . $filename;
                    }
                }
                $line_tvq = 0.00;
                $line_tps = 0.00;
                $line_price = $row["price1"];
                $line_price_text = number_format($row["price1"],2)."$";
                $date_promo = new DateTime($row["promo_expire"]);
                $now = new DateTime();
                if($date_promo > $now) {
                    $line_price = $row["promo_price"];
                    $line_price_text = "<div style='display:block;padding:0px;height:20px;margin-top:-5px;'><b>".round($row["promo_price"],2)."</b>".$row["price_suffix_fr"]."</b><i style='font-size:0.6em;'>".substr($row["promo_expire"],0,10)."</i></div> ";
                } 
                if ($row["tax_fed"] == "1"){
                    $line_tps = round(floatval($line_price)*0.05,2);
                }
                if ($row["tax_prov"] == "1"){
                    $line_tvq = round(floatval($line_price)*0.09975,2);
                } 
                
                    $TOTAL_TAX = (floatval($line_price)) + $line_tps + $line_tvq;
                    //afficher si special pour 2
                    $price2_text = "";
                    if ($row["price2"] != 0 && $row["qty_min_price2"] != 0){
                     $price2_text = "<div style='display:block;padding:0px;margin-top:-5px;'><b>".$row["qty_min_price2"] . " pour " . round($row["price2"],2)."</b>".$row["price_suffix_fr"]."</div>";
                    }
                //$TOTAL_TAX = round((($row["price1"]/100)*14.975)+$row["price1"]) . "$";
                if ($DOC_TYPE == "TABLE" || $DOC_TYPE == ""){
                    $html .="<tr><td style=\"padding:0px;background-image: url('" . $filename . "');background-size:cover;background-position: center;background-repeat: no-repeat;\"><div style='width:50px;height:50px;'></div></td>";
                    if ($DSP_ID == "1") {$html .="<td >". $row["id"] . "</td>";}
                    if ($DSP_STAT == "1") {$html .="<td >"; if (    $row["stat"] == "0") {$html .="<b style='color:green;'>Disponible</b>"; } else if ($row["stat"] == "1") {$html .="<b style='color:#DFC000;'>Inactif temporairement</b>"; } else if ($row["stat"] == "2") {$html .="<b style='color:#E38600;'>En rappel</b>"; } else if ($row["stat"] == "3") {$html .="<b style='color:red;'>BETA Test</b>"; } else if ($row["stat"] == "4") {$html .="<b style='color:red;'>À venir bientôt</b>"; } else if ($row["stat"] == "5") {$html .="<b style='color:red;'>Discontinué</b>"; }  else if ($row["stat"] == "6") {$html .="<b style='color:red;'>En production</b>"; }$html .="</td>";}
                    if ($DSP_NOM == "1") {$html .="<td ><b>".          $row["name_fr"] . "</b></td>";}
                    if ($DSP_CAT  == "1") {$html .="<td   style='line-height:0.8;'>".         $row["catNAME"];
                        if ($row["catNAME2"] != ""){ $html .= "<br style='margin:0px; line-height:0;'><span style='font-size:0.7em;'>".$row["catNAME2"] ."</span>"; }
                        if ($row["catNAME3"] != ""){ $html .= "<br style='margin:0px; line-height:0;'><span style='font-size:0.7em;'>".$row["catNAME3"] ."</span>"; }
                        $html .= "</td>";}
                    if ($DSP_DESC == "1") {$html .="<td>".         $row["description_fr"] . "</td>";}
                    if ($DSP_FRN1 == "1") {$html .="<td>".         $row["frNAME"] . "</td>";}
                    if ($DSP_PACK == "1") {$html .="<td>".         $row["pack"] . "</td>";}
                    if ($DSP_KG == "1") {$html .="<td>".           $row["kg"] . "</td>";}
                    if ($DSP_WIDTH == "1") {$html .="<td>".        $row["width"] . "</td>";}
                    if ($DSP_HEIGHT == "1") {$html .="<td>".        $row["height"] . "</td>";}
                    if ($DSP_DEPTH == "1") {$html .="<td>".        $row["depth"] . "</td>";}
                    //if ($DSP_JOURS_CONSERV == "1") {$html .="<td >".$row["conservation_days"] . "</td>";}
                    if ($DSP_PRIX_VTE == "1") {$html .="<td  style='text-align:right;'>". $line_price_text . $price2_text."</td>";}
                    if ($DSP_TOTAL == "1") {$html .="<td  style='text-align:right;'>".     number_format($TOTAL_TAX,2,'.',' ') . "$</td>";}
                    if ($DSP_PRIX_ACH == "1") {$html .="<td  style='text-align:right;'>".     number_format($row["prod_cost"],2,'.',' ') . "</td>";}
                    if ($DSP_DTAD == "1") {$html .="<td  style='text-align:center;'>".         $row["date_created"] . "</td>";}
                    if ($DSP_DTMD == "1") {$html .="<td  style='text-align:center;'>".         $row["date_modified"] . "</td>";}
                    $html .= "</tr>"; 
                } else {
                    $html .= "<div style='margin:5px;border:0px solid #444; display:inline-block;border-radius:10px;'>
                    <table class='hoverShadow' style='line-height:1;border-collapse: collapse;border:0px;width:100%;min-height:100%;margin-right:auto;margin-left:auto;min-width:200px;background:#fff;color:#333;border-radius:10px;'>
                    <tr '  style='cursor:pointer;padding:0px;border:0px;border-top-right-radius:10px;border-top-left-radius:10px;font-size:16px;' >";
                    if($USER_LANG == "FR"){
                        $html .= "<td colspan=2 style='text-align:center;padding:4px 0px 4px 0px;border-top-right-radius:10px;border-top-left-radius:10px;'><strong>". $row["name_fr"] ."</strong></td></tr>";
                    } else {
                        $html .= "<td colspan=2 style='text-align:center;padding:4px 0px 4px 0px;border-top-right-radius:10px;border-top-left-radius:10px;'><strong>". $row["name_en"] ."</strong></td></tr>";
                    }                         
                        $html .= "<tr style='padding:0px;border:0px;' '>"
                            . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px;'><div style=\"width:200px;height:200px;background-image:url('".$filename."?t=" . $RNDSEQ . "');background-position: bottom center;background-repeat: no-repeat;background-size:cover;border-bottom-right-radius:10px;border-bottom-left-radius:10px;\"> </div></td></tr>";
                    $html .= "</table></div>";
                }
			}
            if ($DOC_TYPE == "TABLE" || $DOC_TYPE == ""){
			    $html .="</table>";
            }
			$html .="</div>";
		} else {
			$html .="<hr><table class='tblDATA'>
					<tr><th>" . $APNAME . "</th><tr>
					<tr><td>Aucunes donn&#233;es trouv&#233; selon la recherche..</td></tr>
					</table>";
		}



$html .= "</main></body></html>";

//die($html);

//$html .= "<br>Signature de l'assuré:<br><img src='https://infotronix.ca/technicien/dossier/signature-" . $dossier . ".png' style='width:400px;width:150px;'><br>https://infotronix.ca/technicien/dossier/signature-" . $dossier . ".png" ;
//$html = "<img src='https://infotronix.ca/img/Infotronix_fr.png'>";

use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isJavascriptEnabled', true);
$fontDirectory = '/pub/font';
$options->setChroot($fontDirectory);
$dompdf = new Dompdf($options);
$dompdf->getFontMetrics()->registerFont(
    ['family' => 'Imperial', 'style' => 'normal', 'weight' => 'normal'],
    $fontDirectory . '/Imperial.ttf'
); 
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('defaultMediaType', 'all');
$dompdf->set_option('isFontSubsettingEnabled', true);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('letter', 'portrait');
// Render the HTML as PDF
$dompdf->render();
//page#
$font = $dompdf->getFontMetrics()->get_font("Verdana", "");
$dompdf->get_canvas()->page_text(577, 770, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0,0,0));
// Output the generated PDF 
//$dompdf->stream(trim($dossier) . "-CopieClient.pdf");
$output_pdf = $dompdf->output();
$output_fn = $_SERVER['DOCUMENT_ROOT'] . "/fs/product/Catalogue-".date("Y").".pdf";
file_put_contents($output_fn, $output_pdf);
sleep(2);

if (trim($EML_TO) == ""){
    //$file_to_save = $_SERVER['DOCUMENT_ROOT'] . '/fs/tmp_file_'.time().'.pdf';
    //save the pdf file on the server
    //file_put_contents($file_to_save, $dompdf->output()); 
    //print the pdf file to the screen for saving
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="Catalogue-'.date("Y").'.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($output_fn));
    header('Accept-Ranges: bytes');
    readfile($output_fn);
    $dw3_conn->close();
    exit();
}

$dw3_conn->close();
?>
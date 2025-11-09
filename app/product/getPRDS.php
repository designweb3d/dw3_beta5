<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = strtolower(str_replace("\"", "\'", str_replace("'", "\'", $_GET['SS']))); //RECHERCHE 
$STAT = $_GET['STAT'];
$CAT  = $_GET['CAT'];
$FRN1  = $_GET['FRN1'];
$OFFSET  = $_GET['OFFSET'];
$LIMIT  = $_GET['LIMIT'];
$html='';
if ($OFFSET == ""){
	$OFFSET = "0";	
}
if ($LIMIT == "" || $LIMIT == "0"){
	$LIMIT = "15";	
}
$DOC_TYPE = "";
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
	if ($ORDERBY == "CAT"){ $ORDERBY = " A.category_id" ;}
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
WHERE A.id >= 0 ";
if ($STAT != ""){ $sql = $sql . " AND  A.stat = '" . $STAT . "' "; }
if ($CAT != ""){ $sql = $sql . " AND  A.category_id = '" . $CAT . "' "; }
if ($FRN1 != ""){ $sql = $sql . " AND  A.supplier_id = '" . $FRN1 . "' "; }
if ($SS != ""){ $sql = $sql . " AND  LCASE(CONCAT(A.name_fr, A.upc, A.description_fr)) like '%" . $SS . "%' "; }
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$numrows = $data['rowCount'];
//WITH LIMIT
			$sql = "SELECT A.*,B.company_name AS frNAME, IFNULL(C.name_fr,'') AS catNAME, IFNULL(D.name_fr,'') AS catNAME2, IFNULL(E.name_fr,'') AS catNAME3
				FROM product A
                LEFT JOIN supplier B ON A.supplier_id = B.id
                LEFT JOIN product_category C ON A.category_id = C.id
                LEFT JOIN product_category D ON A.category2_id = D.id
                LEFT JOIN product_category E ON A.category3_id = E.id
				WHERE A.id >= 0 ";
            if ($STAT != ""){ $sql = $sql . " AND  A.stat = '" . $STAT . "' "; }
            if ($CAT != ""){ $sql = $sql . " AND  A.category_id = '" . $CAT . "' "; }
            if ($FRN1 != ""){ $sql = $sql . " AND  A.supplier_id = '" . $FRN1 . "' "; }
            if ($SS != ""){ $sql = $sql . " AND  LCASE(CONCAT(A.name_fr, A.upc, A.description_fr)) like '%" . $SS . "%' "; }
			$sql = $sql . "
				ORDER BY " . $ORDERBY . " " . $ORDERWAY . "
				LIMIT " . $LIMIT . " OFFSET " . $OFFSET;
				
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
            $html .="<div style='max-width:100%;width:100%;overflow-x:auto;'>" ;		
            $html .="<form onsubmit='submitForm(event)' onclick='checkBatch(this);' id='frmPRD' class='submit-disabled' enctype='multipart/form-data'>";
            if ($DOC_TYPE == "TABLE" || $DOC_TYPE == ""){
                $html .="<table id='dataTABLE' class='tblSEL'>
                <tr><th></th>";
                $col_index=1;
                    if ($DSP_ID  == "1") {$html .="<th>" .            $dw3_lbl["ID"] . "</th>"; $col_index++;}
                    if ($DSP_STAT == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["STAT"] . "</th>"; $col_index++;}
                    if ($DSP_NOM == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .            $dw3_lbl["NOM"] . "</th>"; $col_index++;}
                    if ($DSP_DESC == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["DESC"] . "</th>"; $col_index++;}
                    if ($DSP_CAT  == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["CAT"]  . "</th>"; $col_index++;}
                    if ($DSP_FRN1 == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["FRN"] . "</th>"; $col_index++;}
                    if ($DSP_PACK == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["PACK"] . "</th>"; $col_index++;}
                    if ($DSP_KG == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .             $dw3_lbl["KG"] = "</th>"; $col_index++;}
                    if ($DSP_WIDTH == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .          $dw3_lbl["WIDTH"] . "</th>"; $col_index++;}
                    if ($DSP_HEIGHT == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .          $dw3_lbl["HEIGHT"] . "</th>"; $col_index++;}
                    if ($DSP_DEPTH == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .          $dw3_lbl["DEPTH"] . "</th>"; $col_index++;}
                    if ($DSP_PRIX_VTE == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>Prix unitaire</th>"; $col_index++;}
                    if ($DSP_TOTAL == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>Avec taxes</th>"; $col_index++;}
                    if ($DSP_PRIX_ACH == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .       $dw3_lbl["PRIX_ACH"] . "</th>"; $col_index++;}
                    if ($DSP_DTAD == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["DTAD"] . "</th>"; $col_index++;}
                    if ($DSP_DTMD == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["DTMD"] . "</th>"; $col_index++;}
                $html .="</tr>";
            }            
			while($row = $result->fetch_assoc()) {
                $filename= $row["url_img"];
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                    $filename = "/pub/img/dw3/nd.png";
                } else {
                    if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                        $filename = "/pub/img/dw3/nd.png";
                    }else{
                        $filename = "/fs/product/" . $row["id"] . "/" . $filename;
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
/*                     $price2_text = "";
                    if ($row["price2"] != 0 && $row["qty_min_price2"] != 0){
                     $price2_text = "<div style='display:block;padding:0px;margin-top:-5px;'><b>".$row["qty_min_price2"] . " pour " . round($row["price2"],2)."</b>".$row["price_suffix_fr"]."</div>";
                    } */
                //$TOTAL_TAX = round((($row["price1"]/100)*14.975)+$row["price1"]) . "$";
                if ($DOC_TYPE == "TABLE" || $DOC_TYPE == ""){
                    $html .="
                        <tr><td onclick=\"document.getElementById('chkPR" . $row["id"] . "').click();\" style=\"padding:0px;background-image: url('" . $filename . "?t=".rand(1,100000)."');background-size:auto 100%;background-position: center;background-repeat: no-repeat;\"><div style='width:50px;height:50px;'><input id='chkPR" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox' style='pointer-events: none;'></div></td>";
                    if ($DSP_ID == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\">". $row["id"] . "</td>";}
                    if ($DSP_STAT == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\">"; if (    $row["stat"] == "0") {$html .="<b style='color:green;'>Disponible</b>"; } else if ($row["stat"] == "1") {$html .="<b style='color:#DFC000;'>Inactif temporairement</b>"; } else if ($row["stat"] == "2") {$html .="<b style='color:#E38600;'>En rappel</b>"; } else if ($row["stat"] == "3") {$html .="<b style='color:red;'>BETA Test</b>"; } else if ($row["stat"] == "4") {$html .="<b style='color:red;'>À venir bientôt</b>"; } else if ($row["stat"] == "5") {$html .="<b style='color:red;'>Discontinué</b>"; }  else if ($row["stat"] == "6") {$html .="<b style='color:red;'>En production</b>"; }$html .="</td>";}
                    if ($DSP_NOM == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\"><b>".          $row["name_fr"] . "</b></td>";}
                    if ($DSP_DESC == "1") {
                        if ($row["desc_dataia_fr"] != ""){
                            $is_dia_desc = "<span style='color:gold;transform:translate(-8px -8px);float:right;position:absolute;font-size:16px;z-index:+1;vertical-align:top;'>+</span>";
                        } else {
                            $is_dia_desc = "";
                        }
                        if (strlen($row["description_fr"])>40){
                            $html .="<td class='short' style='padding:0px;' onclick=\"getPRD('". $row["id"] . "');\"><textarea onfocus='this.blur();' onclick=\"getPRD('". $row["id"] . "');\" style='width:96%;overflow:hidden;max-height:50px;cursor:pointer;resize:none;border:0px;background-color:transparent;box-shadow:none;margin:0px;'>".   substr($row["description_fr"],0,40) . "..</textarea>".$is_dia_desc."</td>";
                        } else {
                            $html .="<td class='short' style='padding:0px;' onclick=\"getPRD('". $row["id"] . "');\"><textarea onfocus='this.blur();' onclick=\"getPRD('". $row["id"] . "');\" style='width:96%;overflow:hidden;max-height:50px;cursor:pointer;resize:none;border:0px;background-color:transparent;box-shadow:none;margin:0px;'>".    $row["description_fr"] . "</textarea>".$is_dia_desc."</td>";
                        }
                    }
                    if ($DSP_CAT  == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\"  style='line-height:0.8;'>".         $row["catNAME"];
                        if ($row["catNAME2"] != ""){ $html .= "<br style='margin:0px; line-height:0;'><span style='font-size:0.7em;'>".$row["catNAME2"] ."</span>"; }
                        if ($row["catNAME3"] != ""){ $html .= "<br style='margin:0px; line-height:0;'><span style='font-size:0.7em;'>".$row["catNAME3"] ."</span>"; }
                        $html .= "</td>";}
                    if ($DSP_FRN1 == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\">".         $row["frNAME"] . "</td>";}
                    if ($DSP_PACK == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\">".         $row["pack"] . "</td>";}
                    if ($DSP_KG == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\">".           $row["kg"] . "</td>";}
                    if ($DSP_WIDTH == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\">".        $row["width"] . "</td>";}
                    if ($DSP_HEIGHT == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\">".        $row["height"] . "</td>";}
                    if ($DSP_DEPTH == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\">".        $row["depth"] . "</td>";}
                    //if ($DSP_JOURS_CONSERV == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\">".$row["conservation_days"] . "</td>";}
                    if ($DSP_PRIX_VTE == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\" style='text-align:right;'>". $line_price_text ."</td>";}
                    if ($DSP_TOTAL == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\" style='text-align:right;'>".     number_format($TOTAL_TAX,2,'.',' ') . "$</td>";}
                    if ($DSP_PRIX_ACH == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\" style='text-align:right;'>".     number_format($row["prod_cost"],2,'.',' ') . "</td>";}
                    if ($DSP_DTAD == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\" style='text-align:center;'>".         $row["date_created"] . "</td>";}
                    if ($DSP_DTMD == "1") {$html .="<td onclick=\"getPRD('". $row["id"] . "');\" style='text-align:center;'>".         $row["date_modified"] . "</td>";}
                    $html .= "</tr>"; 
                } else {
                    $html .= "<div style='margin:5px;border:0px solid #444; display:inline-block;border-radius:10px;'>
                    <table class='hoverShadow' style='line-height:1;border-collapse: collapse;border:0px;width:100%;min-height:100%;margin-right:auto;margin-left:auto;min-width:200px;background:#fff;color:#333;border-radius:10px;'>
                    <tr onclick='getPRD(". $row["id"] . ");'  style='cursor:pointer;padding:0px;border:0px;border-top-right-radius:10px;border-top-left-radius:10px;font-size:16px;' >";
                    if($USER_LANG == "FR"){
                        $html .= "<td colspan=2 style='text-align:center;padding:4px 0px 4px 0px;border-top-right-radius:10px;border-top-left-radius:10px;'><strong>". $row["name_fr"] ."</strong></td></tr>";
                    } else {
                        $html .= "<td colspan=2 style='text-align:center;padding:4px 0px 4px 0px;border-top-right-radius:10px;border-top-left-radius:10px;'><strong>". $row["name_en"] ."</strong></td></tr>";
                    }                         
                        $html .= "<tr style='padding:0px;border:0px;' onclick='getPRD(". $row["id"] . ");'>"
                            . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px;'><div style=\"width:200px;height:200px;background-image:url('".$filename."?t=" . $RNDSEQ . "');background-position: bottom center;background-repeat: no-repeat;background-size:cover;border-bottom-right-radius:10px;border-bottom-left-radius:10px;\"> </div></td></tr>";
                    $html .= "</table></div>";
                }
			}
            if ($DOC_TYPE == "TABLE" || $DOC_TYPE == ""){
			    $html .="</table>";
            }
			$html .="</form></div>";
           $html .="<div style='text-align:left;width:100%;padding:5px;'>Total de <b>" . $numrows . "</b> produits selon les filtres et la recherche. <span style='font-size:15px;color:goldenrod;'>+ La description globale de DataIA a été ajoutée.</span></div>";
				$html .="<div id='divFOOT'><div id='hiddenDiv2' style='text-align:left;display:inline-block;'>
						<button onclick=\"selALL('frmPRD','checkbox');\"><span class='material-icons'>done_all</span></button>";
				$html .="  <button onclick=\"selNONE('frmPRD','checkbox');\"><span class='material-icons'>remove_done</span></button>
						<button disabled id='btnBatch' style='margin:3px;' onclick='openBatch();'><span class='material-icons'>ballot</span></button>";
				$html .=" <div id='divBATCH' style='color:white;background:#444444;border-radius:5px;position:fixed;transition: all 1s;bottom:-300px;left:50%;-webkit-transform: translateX(-65%);padding:5px'>";
				$html .="		<u>Selon la selection:</u>";
                $html .= "<br><button style='margin:3px;' onclick=\"ExportToPDF('dataTABLE','Products');\"><span class='material-icons'>picture_as_pdf</span></button> PDF";
				$html .= "<br><button style='margin:3px;' onclick=\"ExportToExcel('dataTABLE','xlsx','Products');\"><span class='material-icons'>table_view</span></button> XLSX";
				if ($APREAD_ONLY == false) { $html .="<br><button class='blue' style='margin:3px;' onclick='getOPTS_LST();'><span class='material-icons'>add</span></button> Option";}
				if ($APREAD_ONLY == false) { $html .="<br><button class='red' style='margin:3px;' onclick='deletePRDS();'><span class='material-icons'>delete_sweep</span></button> Supprimer";}
                $html .=" </div>";
				$html .="</div>";		
			//FIRST PAGE
			if ($OFFSET > 0){
				$html .="<button onclick='getPRDS(\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
			} else {
				$html .="<button disabled><span class='material-icons'>first_page</span></button>";
			}
			//PREVIOUS PAGE
			if ($OFFSET > 0){
				$page = $OFFSET-$LIMIT;
				if ($page<0){$page=0;}
				$html .="<button onclick='getPRDS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
			} else {
				$html .="<button disabled><span class='material-icons'>navigate_before</span></button>";
			}
			//CURRENT PAGE
			$html .="<b style='font-size:1.2em;'>" . ceil(($OFFSET/$LIMIT)+1) 
			. "</b>/<b>" . ceil($numrows/$LIMIT) 
			. "</b>";
			//NEXTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$page = $OFFSET+$LIMIT;
				$html .="<button onclick='getPRDS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
			} else {
				$html .="<button disabled><span class='material-icons'>navigate_next</span></button>";
			}
			//LASTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$lastpage = $numrows-$LIMIT;
				$html .="<button onclick='getPRDS(\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
			} else {
				$html .="<button disabled><span class='material-icons'>last_page</span></button>";
			}
			$html .="</div>";
		} else {
			$html .="<hr><table id='dataTABLE' class='tblDATA'>
					<tr><th>" . $APNAME . "</th><tr>
					<tr onclick='openNEW();'><td>Aucunes donn&#233;es trouv&#233; selon la recherche... Pour ajouter un nouveau appuyez sur [+]</td></tr>
					</table>";
		}
echo $html;
$dw3_conn->close();
?>

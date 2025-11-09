<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = strtolower(str_replace("\"", "\'", str_replace("'", "\'", $_GET['SS']))); //RECHERCHE 
$STAT = $_GET['STAT'];
$CAT  = $_GET['CAT'];
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
                case 'PROC':
                    $DSP_PROC_ID = $row["value"];
                    break;
                case 'PRD':
                    $DSP_PRD = $row["value"];
                    break;
                case 'CAT':
                    $DSP_CAT = $row["value"];
                    break;
                case 'QTY':
                    $DSP_QTY = $row["value"];
                    break;
                case 'LOT':
                    $DSP_LOT = $row["value"];
                    break;
                case 'ORDER':
                    $DSP_ORDER_ID = $row["value"];
                    break;
                case 'STORAGE':
                    $DSP_STORAGE_ID = $row["value"];
                    break;
                case 'START':
                    $DSP_START = $row["value"];
                    break;
                case 'END':
                    $DSP_END = $row["value"];
                    break;
                case 'DUE':
                    $DSP_DUE = $row["value"];
                    break;
            }
        }
    } else {
        $ORDERBY = "ID";
        $ORDERWAY = "";
        $DSP_ID = "1";
        $DSP_STAT = "1";
        $DSP_NOM = "1";
        $DSP_CAT = "0";
        $DSP_PRD = "1";
        $DSP_PROC_ID = "0";
        $DSP_QTY = "1";
        $DSP_LOT = "1";
        $DSP_ORDER_ID = "0";
        $DSP_STORAGE_ID = "1";
        $DSP_DUE = "1";
        $DSP_END = "0";
        $DSP_START = "0";
    }
//ORDER BY & WAY
    if ($ORDERBY == ""){ $ORDERBY = " F.name_fr " ;}
	if ($ORDERBY == "NOM"){ $ORDERBY = " F.name_fr " ;}
	if ($ORDERBY == "CAT"){ $ORDERBY = " C.name_fr " ;}
	if ($ORDERBY == "PROC"){ $ORDERBY = " procedure_id" ;}
	if ($ORDERBY == "PRD"){ $ORDERBY = " B.name_fr" ;}
	if ($ORDERBY == "STAT"){ $ORDERBY = " status " ;}
	if ($ORDERBY == "ORDER"){ $ORDERBY = " order_id " ;}
	if ($ORDERBY == "LOT"){ $ORDERBY = " lot_no " ;}
	if ($ORDERBY == "STORAGE"){ $ORDERBY = " storage_id " ;}
	if ($ORDERBY == "START"){ $ORDERBY = " date_start " ;}
	if ($ORDERBY == "DUE"){ $ORDERBY = " date_due " ;}
	if ($ORDERBY == "END"){ $ORDERBY = " date_end " ;}
	if ($ORDERBY == "ID"){ $ORDERBY = " id " ;}
	if ($ORDERWAY == ""){ $ORDERWAY = " DESC " ;}
	
	
//ROW COUNT
$sql = "SELECT COUNT(*) as rowCount
FROM production A
LEFT JOIN procedure_head F ON A.procedure_id = F.id
LEFT JOIN product B ON F.product_id = B.id
LEFT JOIN product_category C ON B.category_id = C.id
LEFT JOIN product_category D ON B.category2_id = D.id
LEFT JOIN product_category E ON B.category3_id = E.id
WHERE A.id >= 0 ";
if ($STAT != ""){ $sql = $sql . " AND  status = '" . $STAT . "' "; }
if ($CAT != ""){ $sql = $sql . " AND  B.category_id = '" . $CAT . "' "; }
if ($SS != ""){ $sql = $sql . " AND  LCASE(CONCAT(A.name_fr, A.lot_no, A.status,B.name_fr,C.name_fr,D.name_fr,E.name_fr)) like '%" . $SS . "%' "; }
//die($sql);
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$numrows = $data['rowCount'];
//WITH LIMIT
			$sql = "SELECT A.*,B.url_img,B.name_fr AS prNAME, IFNULL(C.name_fr,'') AS catNAME, IFNULL(D.name_fr,'') AS catNAME2, IFNULL(E.name_fr,'') AS catNAME3,
                    F.name_fr AS procNAME, F.product_id AS product_id                        
				FROM production A
                LEFT JOIN procedure_head F ON A.procedure_id = F.id
                LEFT JOIN product B ON F.product_id = B.id
                LEFT JOIN product_category C ON B.category_id = C.id
                LEFT JOIN product_category D ON B.category2_id = D.id
                LEFT JOIN product_category E ON B.category3_id = E.id
				WHERE A.id >= 0 ";
            if ($STAT != ""){ $sql = $sql . " AND  A.status = '" . $STAT . "' "; }
            if ($CAT != ""){ $sql = $sql . " AND  B.category_id = '" . $CAT . "' "; }
            if ($SS != ""){ $sql = $sql . " AND  LCASE(CONCAT(A.lot_no, A.status,B.name_fr,C.name_fr,D.name_fr,E.name_fr)) like '%" . $SS . "%' "; }
			$sql = $sql . "
				ORDER BY " . $ORDERBY . " " . $ORDERWAY . "
				LIMIT " . $LIMIT . " OFFSET " . $OFFSET;
		//die($sql);
		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {	
            $html .="<div style='max-width:100%;width:100%;overflow-x:auto;'>" ;		
            $html .="<form onsubmit='submitForm(event)' onclick='checkBatch(this);' id='frmPROD' class='submit-disabled' enctype='multipart/form-data'>";
            if ($DOC_TYPE == "TABLE" || $DOC_TYPE == ""){
                $html .="<table id='dataTABLE' class='tblSEL'>
                <tr><th></th>";
                $col_index=1;
                    if ($DSP_ID  == "1") {$html .="<th>" .            $dw3_lbl["ID"] . "</th>"; $col_index++;}
                    if ($DSP_STAT == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["STAT"] . "</th>"; $col_index++;}
                    if ($DSP_NOM == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .            $dw3_lbl["NOM"] . "</th>"; $col_index++;}
                    if ($DSP_CAT  == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["CAT"]  . "</th>"; $col_index++;}
                    if ($DSP_PRD == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>Produit #</th>"; $col_index++;}
                    if ($DSP_PROC_ID == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>Procedure #</th>"; $col_index++;}
                    if ($DSP_QTY == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>Quantité</th>"; $col_index++;}
                    if ($DSP_LOT == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>Lot #</th>"; $col_index++;}
                    if ($DSP_ORDER_ID == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>Commande #</th>"; $col_index++;}
                    if ($DSP_STORAGE_ID == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>Emplacement</th>"; $col_index++;}
                    if ($DSP_START == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>Date fin</th>"; $col_index++;}
                    if ($DSP_DUE == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>Date due</th>"; $col_index++;}
                    if ($DSP_END == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>Date début</th>"; $col_index++;}
                $html .="</tr>";
            }            
			while($row = $result->fetch_assoc()) {
                $filename= $row["url_img"];
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["product_id"] . "/" . $filename)){
                    $filename = "/pub/img/dw3/nd.png";
                } else {
                    if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["product_id"] . "/" . $filename)){
                        $filename = "/pub/img/dw3/nd.png";
                    }else{
                        $filename = "/fs/product/" . $row["product_id"] . "/" . $filename;
                    }
                }
                $RNDSEQ = rand(1,100000);
                if ($DOC_TYPE == "TABLE" || $DOC_TYPE == ""){
                    $html .="
                        <tr><td onclick=\"document.getElementById('chkPR" . $row["id"] . "').click();\" style=\"padding:0px;background-image: url('" . $filename . "?t=".rand(1,100000)."');background-size:auto 100%;background-position: center;background-repeat: no-repeat;\"><div style='width:50px;height:50px;'><input id='chkPR" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox' style='pointer-events: none;'></div></td>";
                    if ($DSP_ID == "1") {$html .="<td onclick=\"getPROD('". $row["id"] . "');\">". $row["id"] . "</td>";}
                    if ($DSP_STAT == "1") {$html .="<td onclick=\"getPROD('". $row["id"] . "');\">".          $row["status"] . "</td>";}
                    if ($DSP_NOM == "1") {$html .="<td onclick=\"getPROD('". $row["id"] . "');\"><b>".          $row["procNAME"] . "</b></td>";}
                    if ($DSP_CAT  == "1") {$html .="<td onclick=\"getPRODUCTION('". $row["id"] . "');\"  style='line-height:0.8;'>".         $row["catNAME"];
                        if ($row["catNAME2"] != ""){ $html .= "<br style='margin:0px; line-height:0;'><span style='font-size:0.7em;'>".$row["catNAME2"] ."</span>"; }
                        if ($row["catNAME3"] != ""){ $html .= "<br style='margin:0px; line-height:0;'><span style='font-size:0.7em;'>".$row["catNAME3"] ."</span>"; }
                        $html .= "</td>";}
                    if ($DSP_PRD == "1") {$html .="<td onclick=\"getPRODUCTION('". $row["id"] . "');\">".         $row["prNAME"] . "</td>";}
                    if ($DSP_PROC_ID == "1") {$html .="<td onclick=\"getPRODUCTION('". $row["id"] . "');\">".         $row["procedure_id"] . "</td>";}
                    if ($DSP_QTY == "1") {$html .="<td onclick=\"getPRODUCTION('". $row["id"] . "');\">".           $row["qty_needed"] . "</td>";}
                    if ($DSP_LOT == "1") {$html .="<td onclick=\"getPRODUCTION('". $row["id"] . "');\">".        $row["lot_no"] . "</td>";}
                    if ($DSP_ORDER_ID == "1") {$html .="<td onclick=\"getPRODUCTION('". $row["id"] . "');\">".        $row["order_id"] . "</td>";}
                    if ($DSP_STORAGE_ID == "1") {$html .="<td onclick=\"getPRODUCTION('". $row["id"] . "');\">".        $row["storage_id"] . "</td>";}
                    if ($DSP_START == "1") {$html .="<td onclick=\"getPRODUCTION('". $row["id"] . "');\" style='text-align:center;'>".         $row["date_start"] . "</td>";}
                    if ($DSP_DUE == "1") {$html .="<td onclick=\"getPRODUCTION('". $row["id"] . "');\" style='text-align:center;'>".         $row["date_due"] . "</td>";}
                    if ($DSP_END == "1") {$html .="<td onclick=\"getPRODUCTION('". $row["id"] . "');\" style='text-align:center;'>".         $row["date_end"] . "</td>";}
                    $html .= "</tr>"; 
                } else {
                    $html .= "<div style='margin:5px;border:0px solid #444; display:inline-block;border-radius:10px;'>
                    <table class='hoverShadow' style='line-height:1;border-collapse: collapse;border:0px;width:100%;min-height:100%;margin-right:auto;margin-left:auto;min-width:200px;background:#fff;color:#333;border-radius:10px;'>
                    <tr onclick='getPRODUCTION(". $row["id"] . ");'  style='cursor:pointer;padding:0px;border:0px;border-top-right-radius:10px;border-top-left-radius:10px;font-size:16px;' >";
                    if($USER_LANG == "FR"){
                        $html .= "<td colspan=2 style='text-align:center;padding:4px 0px 4px 0px;border-top-right-radius:10px;border-top-left-radius:10px;'><strong>". $row["procNAME"] ."</strong></td></tr>";
                    } else {
                        $html .= "<td colspan=2 style='text-align:center;padding:4px 0px 4px 0px;border-top-right-radius:10px;border-top-left-radius:10px;'><strong>". $row["procNAME"] ."</strong></td></tr>";
                    }                         
                        $html .= "<tr style='padding:0px;border:0px;' onclick='getPRODUCTION(". $row["id"] . ");'>"
                            . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px;'><div style=\"width:200px;height:200px;background-image:url('".$filename."?t=" . $RNDSEQ . "');background-position: bottom center;background-repeat: no-repeat;background-size:cover;border-bottom-right-radius:10px;border-bottom-left-radius:10px;\"> </div></td></tr>";
                    $html .= "</table></div>";
                }
			}
            if ($DOC_TYPE == "TABLE" || $DOC_TYPE == ""){
			    $html .="</table>";
            }
			$html .="</form></div>";
           $html .="<div style='text-align:left;width:100%;padding:5px;'>Total de <b>" . $numrows . "</b> produits selon les filtres et la recherche.</div>";
				$html .="<div id='divFOOT'><div id='hiddenDiv2' style='text-align:left;display:inline-block;'>
						<button onclick=\"selALL('frmPROD','checkbox');\"><span class='material-icons'>done_all</span></button>";
				$html .="  <button onclick=\"selNONE('frmPROD','checkbox');\"><span class='material-icons'>remove_done</span></button>
						<button disabled id='btnBatch' style='margin:3px;' onclick='openBatch();'><span class='material-icons'>ballot</span></button>";
				$html .=" <div id='divBATCH' style='color:white;background:#444444;border-radius:5px;position:fixed;transition: all 1s;bottom:-300px;left:50%;-webkit-transform: translateX(-65%);padding:5px'>";
				$html .="		<u>Selon la selection:</u>";
                            	$html .= "<br><button onclick=\"ExportToPDF('dataTABLE','Productions');\"><span class='material-icons'>picture_as_pdf</span></button> PDF ";
				                $html .= "<br><button onclick=\"ExportToExcel('dataTABLE','xlsx','Productions');\"><span class='material-icons'>table_view</span></button> XLSX ";
				if ($APREAD_ONLY == false) { $html .="		<br><button class='red' style='margin:3px;' onclick='deletePRODUCTIONS();'><span class='material-icons'>delete_sweep</span></button> Supprimer";}
                $html .=" </div>";
				$html .="</div>";		
			//FIRST PAGE
			if ($OFFSET > 0){
				$html .="<button onclick='getPRODUCTIONS(\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
			} else {
				$html .="<button disabled><span class='material-icons'>first_page</span></button>";
			}
			//PREVIOUS PAGE
			if ($OFFSET > 0){
				$page = $OFFSET-$LIMIT;
				if ($page<0){$page=0;}
				$html .="<button onclick='getPRODUCTIONS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
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
				$html .="<button onclick='getPRODUCTIONS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
			} else {
				$html .="<button disabled><span class='material-icons'>navigate_next</span></button>";
			}
			//LASTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$lastpage = $numrows-$LIMIT;
				$html .="<button onclick='getPRODUCTIONS(\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
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

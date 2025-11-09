<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = str_replace("\"", "\'", str_replace("'", "\'", $_GET['SS'])); //RECHERCHE 
$KIND = $_GET['KIND'];
$CAT  = $_GET['CAT'];
$FRN1  = $_GET['FRN1'];
$OFFSET  = $_GET['OFFSET'];
$LIMIT  = $_GET['LIMIT'];
$ORDERWAY = " ASC " ;
$html='';
$gtot=0;
if ($OFFSET == ""){
	$OFFSET = "0";	
}
if ($LIMIT == "" || $LIMIT == "0"){
	$LIMIT = "15";	
}
	//PARAMETRES D'AFFICHAGE
	$sql = "SELECT *
			FROM app_prm
			WHERE app_id = '" . $APID . "'
			AND   user_id = '" . $USER . "' 
			ORDER BY value";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			switch ($row["name"]) {
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
				case 'KIND':
					$DSP_KIND = $row["value"];
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
                case 'TOTAL':
                    $DSP_TOTAL = $row["value"];
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
                case 'JOURS_CONSERV':
                    $DSP_JOURS_CONSERV = $row["value"];
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
                    $DSP_ID = "0";
                    $DSP_KIND = "0";
                    $DSP_NOM = "1";
                    $DSP_DESC = "0";
                    $DSP_CAT = "1";
                    $DSP_FRN1 = "1";
                    $DSP_PACK = "0";
                    $DSP_KG = "0";
                    $DSP_WIDTH = "0";
                    $DSP_HEIGHT = "0";
                    $DSP_DEPTH = "0";
                    $DSP_JOURS_CONSERV = "0";
                    $DSP_TOTAL = "1";
                    $DSP_DTAD = "0";
                    $DSP_DTMD = "0";
    }
//ORDER BY & WAY
if ($ORDERBY??"" == ""){ $ORDERBY = " trim(A.name_fr)" ;}
	if ($ORDERBY == "NOM"){ $ORDERBY = " trim(A.name_fr) " ;}
	if ($ORDERBY == "CAT"){ $ORDERBY = " A.category_id" ;}
	if ($ORDERBY == "FRN1"){ $ORDERBY = " A.supplier_id " ;}
	if ($ORDERBY == "KG"){ $ORDERBY = " A.kg " ;}
	if ($ORDERBY == "SIZE"){ $ORDERBY = " (A.width*A.height*A.depth) " ;}
	if ($ORDERBY == "DTMD"){ $ORDERBY = " A.date_modified " ;}
	if ($ORDERBY == "DTAD"){ $ORDERBY = " A.date_created " ;}
	if ($ORDERWAY == ""){ $ORDERWAY = " ASC " ;}

    $sql = "SELECT A.*,IFNULL(B.company_name,'') AS frNAME, IFNULL(C.name_fr,'') AS catNAME, IFNULL(D.total,0) AS invTOT 
    FROM product A
    LEFT JOIN supplier B ON A.supplier_id = B.id
    LEFT JOIN product_category C ON A.category_id = C.id
    LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) D ON A.id = D.product_id
    WHERE A.id >= 0 
    AND A.id IN (SELECT DISTINCT product_id FROM transfer)";
//if ($KIND != ""){ $sql = $sql . " AND  D.kind = '" . $KIND . "' "; }
if ($CAT != ""){ $sql = $sql . " AND  A.category_id = '" . $CAT . "' "; }
if ($FRN1 != ""){ $sql = $sql . " AND  A.supplier_id = '" . $FRN1 . "' "; }
if ($SS != ""){ $sql = $sql . " AND  LCASE(CONCAT(A.name_fr, A.upc, A.description_fr)) like '%" . strtolower($SS) . "%' "; }
    //die($sql);
$result = $dw3_conn->query($sql);
$numrows = $result->num_rows;

	$sql = "SELECT A.*,IFNULL(B.company_name,'') AS frNAME, IFNULL(C.name_fr,'') AS catNAME, IFNULL(D.total,0) AS invTOT 
				FROM product A
                LEFT JOIN supplier B ON A.supplier_id = B.id
                LEFT JOIN product_category C ON A.category_id = C.id
                LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) D ON A.id = D.product_id
				WHERE A.id >= 0 
                AND A.id IN (SELECT DISTINCT product_id FROM transfer)";
            //if ($KIND != ""){ $sql = $sql . " AND  D.kind = '" . $KIND . "' "; }
            if ($CAT != ""){ $sql = $sql . " AND  A.category_id = '" . $CAT . "' "; }
            if ($FRN1 != ""){ $sql = $sql . " AND  A.supplier_id = '" . $FRN1 . "' "; }
            if ($SS != ""){ $sql = $sql . " AND  LCASE(CONCAT(A.name_fr, A.upc, A.description_fr)) like '%" . strtolower($SS) . "%' "; }
			$sql = $sql . "
                ORDER BY " . $ORDERBY . " " . $ORDERWAY . "
				LIMIT " . $LIMIT . " OFFSET " . $OFFSET;
				//die($sql);
		$result = $dw3_conn->query($sql);
        //$numrows = $result->num_rows;
		if ($numrows > 0) {	
			$html .="<div style='max-width:100%;width:100%;overflow-x:auto;'>" ;		
			$html .="<form onsubmit='submitForm(event)' onclick='checkBatch(this);' id='frmPRD' class='submit-disabled' enctype='multipart/form-data'>
			<table id='dataTABLE' class='tblSEL'>
			<tr><th></th>";
			$col_index=1;
				if ($DSP_ID  == "1") {$html .="<th>" .            $dw3_lbl["ID"] . "</th>"; $col_index++;}
				if ($DSP_KIND == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>Type</th>"; $col_index++;}
				if ($DSP_NOM == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .            $dw3_lbl["NOM"] . "</th>"; $col_index++;}
				if ($DSP_DESC == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["DESC"] . "</th>"; $col_index++;}
				if ($DSP_CAT  == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["CAT"]  . "</th>"; $col_index++;}
				if ($DSP_FRN1 == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["FRN1"] . "</th>"; $col_index++;}
				if ($DSP_PACK == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["PACK"] . "</th>"; $col_index++;}
				if ($DSP_KG == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .             $dw3_lbl["KG"] = "</th>"; $col_index++;}
				if ($DSP_WIDTH == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .          $dw3_lbl["WIDTH"] . "</th>"; $col_index++;}
				if ($DSP_HEIGHT == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .          $dw3_lbl["HEIGHT"] . "</th>"; $col_index++;}
				if ($DSP_DEPTH == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .          $dw3_lbl["DEPTH"] . "</th>"; $col_index++;}
				if ($DSP_JOURS_CONSERV == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .  $dw3_lbl["JOURS_CONSERV"] . "</th>"; $col_index++;}
				if ($DSP_TOTAL == "1") {$html .="<th onclick='sortTable(" .$col_index . ")' style='text-align:right;'>" .          $dw3_lbl["QTY"] . "</th>"; $col_index++;}
				if ($DSP_DTAD == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["DTAD"] . "</th>"; $col_index++;}
				if ($DSP_DTMD == "1") {$html .="<th onclick='sortTable(" .$col_index . ")'>" .           $dw3_lbl["DTMD"] . "</th>"; $col_index++;}
			$html .="</tr>";
            
			while($row = $result->fetch_assoc()) {
                $filename= $row["url_img"];
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                    $filename = "/img/nd.png";
                } else {
                    if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                        $filename = "/img/nd.png";
                    }else{
                        $filename = "/fs/product/" . $row["id"] . "/" . $filename;
                    }
                }
				$html .="
					 <tr><td onclick=\"document.getElementById('chkPR" . $row["id"] . "').click();\" style=\"padding:0px;background-image: url('" . $filename . "');background-size:auto 100%;background-position: center;background-repeat: no-repeat;\"><div style='width:50px;height:50px;'><input id='chkPR" . $row["id"] . "' value='" . $row["id"] . "' type='checkbox' style='pointer-events: none;'></div></td>";
				if ($DSP_ID == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'>". $row["id"] . "</td>";}
				if ($DSP_KIND == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'>" . $dw3_lbl["kind"] . "</td>";}
				if ($DSP_NOM == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'><b>".          $row["name_fr"] . "</b></td>";}
				if ($DSP_DESC == "1") {$html .="<td class='short' style='max-width:300px;' onclick='getPRD(\"". $row["id"] . "\");'>".         $row["description_fr"] . "</td>";}
				if ($DSP_CAT  == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'>".         $row["catNAME"] . "</td>";}
				if ($DSP_FRN1 == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'>".         $row["frNAME"] . "</td>";}
				if ($DSP_PACK == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'>".         $row["pack"] . "</td>";}
				if ($DSP_KG == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'>".           $row["kg"] . "</td>";}
				if ($DSP_WIDTH == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'>".        $row["width"] . "</td>";}
				if ($DSP_HEIGHT == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'>".        $row["height"] . "</td>";}
				if ($DSP_DEPTH == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'>".        $row["depth"] . "</td>";}
				if ($DSP_JOURS_CONSERV == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'>".$row["conservation_days"] . "</td>";}
				if ($DSP_TOTAL == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");' style='text-align:right;'><b>".     $row["invTOT"] . "</b></td>";}
				if ($DSP_DTAD == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'>".         $row["date_created"] . "</td>";}
				if ($DSP_DTMD == "1") {$html .="<td onclick='getPRD(\"". $row["id"] . "\");'>".         $row["date_modified"] . "</td>";}
				$html .="</tr>"; 
                $gtot += $row["invTOT"];
			}
			$html .="</table></form></div>";
            $html .="<div style='text-align:left;width:100%;padding:5px;'><br>Total de <b>" . $numrows . "</b> produits selon la recherche.<div style='float:right;margin-right:12px;font-size:20px;margin-top:-5px;'><b>" . $gtot . "</b></div></div>";
				$html .="<div id='divFOOT'><div id='hiddenDiv2' style='text-align:left;display:inline-block;'>
						<button style='background:#444444;' onclick='selALL(\"frmPRD\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
				$html .="  <button style='background:#444444;' onclick='selNONE(\"frmPRD\",\"checkbox\");'><span class='material-icons'>remove_done</span></button>
						<button disabled id='btnBatch' style='background:#666;margin:3px;' onclick='openBatch();'><span class='material-icons'>ballot</span></button>";
				$html .=" <div id='divBATCH' style='color:white;background:#444444;border-radius:5px;position:fixed;transition: all 1s;bottom:-300px;left:50%;-webkit-transform: translateX(-65%);padding:5px'>";
				$html .="		<u>Selon la selection:</u>";
                $html .= "<br><button style='margin:3px;' onclick=\"ExportToPDF('dataTABLE','Inventory');\"><span class='material-icons'>picture_as_pdf</span></button> PDF";
				$html .= "<br><button style='margin:3px;' onclick=\"ExportToExcel('dataTABLE','xlsx','Inventory');\"><span class='material-icons'>table_view</span></button> XLSX";
				$html .="		<br><button style='background:red;margin:3px;' onclick='deletePRDS();'><span class='material-icons'>delete_sweep</span></button> Supprimer";
               $html .=" </div>";
				$html .="</div>";		
			//FIRST PAGE
			if ($OFFSET > 0){
				$html .="<button onclick='getINV(\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
			} else {
				$html .="<button disabled><span class='material-icons'>first_page</span></button>";
			}
			//PREVIOUS PAGE
			if ($OFFSET > 0){
				$page = $OFFSET-$LIMIT;
				if ($page<0){$page=0;}
				$html .="<button onclick='getINV(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
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
				$html .="<button onclick='getINV(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
			} else {
				$html .="<button disabled><span class='material-icons'>navigate_next</span></button>";
			}
			//LASTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$lastpage = $numrows-$LIMIT;
				$html .="<button onclick='getINV(\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
			} else {
				$html .="<button disabled><span class='material-icons'>last_page</span></button>";
			}
			$html .="</div>";
		} else {
			$html .="<hr><table id='dataTABLE' class='tblSEL'>
					<tr><th>" . $APNAME . "</th><tr>
					<tr onclick='openNEW();'><td>Aucunes donn&#233;es trouv&#233; selon la recherche... Pour ajouter un nouveau appuyez sur [+]</td></tr>
					</table>";
		}
echo $html;
$dw3_conn->close();
?>

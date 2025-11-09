<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
//PARAMETRES PRODUITS

//TABLE or CARDS
$sql = "SELECT * FROM app_prm WHERE app_id = '" . $APID . "' AND user_id = '" . $USER . "' AND name = 'DOC_TYPE' LIMIT 1";
$result = $dw3_conn->query($sql);
echo "<div id='divPRM_0' style='background: rgba(33, 33, 33, 0.3);padding:5px;color:#ffffff;text-align:left;'>";
if ($result->num_rows > 0) {	
    while($row = $result->fetch_assoc()) {
        echo "Type d'affichage:<br> 
        <select id='prmDOC_TYPE'>
        <option value='TABLE' "; if ($row["value"] == 'TABLE' || $row["value"] == ''){ echo "selected ";} echo ">Tableau</option>
        <option value='CARD' "; if ($row["value"] == 'CARD'){ echo "selected ";} echo ">Cartes images</option>
        </select><br>Veuiller noter que les cartes n'affichent que le nom et l'image principale.<br>";
    }
} else {
    echo "Type d'affichage:<br> 
    <select id='prmDOC_TYPE'>
    <option value='TABLE' selected>Tableau</option>
    <option value='CARD'>Cartes images</option>
    </select><br>Veuiller noter que les cartes n'affichent que le nom et l'image principale.<br>";
}
echo "</div>";
	//LIMIT
	$sql = "SELECT *
			FROM app_prm
			WHERE app_id = '" . $APID . "'
			AND   user_id = '" . $USER . "' 
			AND   name = 'LIMIT' 
			LIMIT 1";
	$result = $dw3_conn->query($sql);
	echo "<div id='divPRM_1' style='background: rgba(133, 33, 33, 0.3);padding:5px;color:#ffffff;text-align:left;'>";
	echo "Nombre de lignes par page:<br> 
			<select name='prmLIMIT' id='prmLIMIT'>";	
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
			//roadmap
			echo "<option ";
			if ($row["value"] == ''){ echo "selected ";}
			echo "value=''>Responsive</option>";
			//roadmap
			echo "<option ";
			if ($row["value"] == '12'){ echo "selected ";}
			echo "value='12'>12</option>";
			//satellite
			echo "<option ";
			if ($row["value"] == '25'){ echo "selected ";}
			echo "value='25'>25</option>";
			//hybrid
			echo "<option ";
			if ($row["value"] == '50'){ echo "selected ";}
			echo "value='50'>50</option>";
			//terrain
			echo "<option ";
			if ($row["value"] == '100'){ echo "selected ";}
			echo "value='100'>100</option>";
			//terrain
			echo "<option ";
			if ($row["value"] == '250'){ echo "selected ";}
			echo "value='250'>250</option>";
			//terrain
			echo "<option ";
			if ($row["value"] == '500'){ echo "selected ";}
			echo "value='500'>500</option>";
			//terrain
			echo "<option ";
			if ($row["value"] == '1000'){ echo "selected ";}
			echo "value='1000'>1000</option>";
		}
	} else {
			echo "<option selected value=''>Responsive</option>";
			echo "<option value='12'>12</option>";
			echo "<option value='25'>25</option>";
			echo "<option value='50'>50</option>";
			echo "<option value='100'>100</option>";
			echo "<option value='250'>250</option>";
			echo "<option value='500'>500</option>";
			echo "<option value='1000'>1000</option>";
	}
	echo "</select></div><br>";	

	//ORDERBY
	$sql = "SELECT *
			FROM app_prm
			WHERE app_id = '" . $APID . "'
			AND   user_id = '" . $USER . "' 
			AND   name = 'ORDERBY' 
			LIMIT 1";
	$result = $dw3_conn->query($sql);
	echo "<div id='divPRM_2' style='background: rgba(33, 133, 33, 0.3);padding:5px;color:#ffffff;text-align:left;'>";
	echo "Trier par:  <select name='prmORDERBY' id='prmORDERBY'>";	
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
			//nom du produit
			echo "<option ";
			if ($row["value"] == 'NOM'){ echo "selected ";}
			echo "value='NOM'>Nom de produit</option>";
			//cat et scat
			echo "<option ";
			if ($row["value"] == 'CAT'){ echo "selected ";}
			echo "value='CAT'>" . $dw3_lbl["CAT"] . "</option>";
            //frn1
			echo "<option ";
			if ($row["value"] == 'FRN1'){ echo "selected ";}
			echo "value='FRN1'>" . $dw3_lbl["FRN1"] . "</option>";
            //size
			echo "<option ";
			if ($row["value"] == 'PRICE'){ echo "selected ";}
			echo "value='PRICE'>Prix</option>";
            //kg
			echo "<option ";
			if ($row["value"] == 'KG'){ echo "selected ";}
			echo "value='KG'>" . $dw3_lbl["KG"] . "</option>";
			//date creation
			echo "<option ";
			if ($row["value"] == 'ID'){ echo "selected ";}
			echo "value='ID'>#ID</option>";
			//date modif
			echo "<option ";
			if ($row["value"] == 'DTMD'){ echo "selected ";}
			echo "value='DTMD'>" . $dw3_lbl["DTMD"] . "</option>";
		}
	} else {
			//par defaut
			echo "<option selected value='NOM'>Nom de produit</option>";
			echo "<option value='ID'>#ID</option>";
			echo "<option value='CAT'>" . $dw3_lbl["CAT"] . "</option>";
			echo "<option value='FRN1'>" . $dw3_lbl["FRN1"] . "</option>";
			//echo "<option value='SIZE'>" . $dw3_lbl["SIZE"] . "</option>";
			echo "<option value='KG'>" . $dw3_lbl["KG"] . "</option>";
			echo "<option value='DTMD'>" . $dw3_lbl["DTMD"] . "</option>";
	}
	echo "</select><br>";
	$sql = "SELECT *
			FROM app_prm
			WHERE app_id = '" . $APID . "'
			AND   user_id = '" . $USER . "' 
			AND   name = 'ORDERWAY' 
			LIMIT 1";
	$result = $dw3_conn->query($sql);
	echo "<select name='prmORDERWAY' id='prmORDERWAY'>";	
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
			//ascendent
			echo "<option ";
			if ($row["value"] == 'ASC'){ echo "selected ";}
			echo "value='ASC'>" . $dw3_lbl["ORD_ASC"] . "</option>";
			//descendent
			echo "<option ";
			if ($row["value"] == 'DESC'){ echo "selected ";}
			echo "value='DESC'>" . $dw3_lbl["ORD_DESC"] . "</option>";
		}
	} else {
			//par defaut
			echo "<option selected value='ASC'>" . $dw3_lbl["ORD_ASC"] . "</option>";
			echo "<option value='DESC'>" . $dw3_lbl["ORD_DESC"] . "</option>";
	}
	echo "</select></div><br>";
	
	//COLONES A AFFICHER
	$sql = "SELECT *
			FROM app_prm
			WHERE app_id = '" . $APID . "'
			AND   user_id = '" . $USER . "' 
			AND   name IN ('ID','STAT','NOM','DESC',
							'CAT','TAX_FED','TAX_PROV','TOTAL','FRN1','PACK','KG','WIDTH','HEIGHT',
							'DEPTH','PRIX_VTE','PRIX_ACH','DTAD','DTMD')
			ORDER BY name";
	$result = $dw3_conn->query($sql);
	echo "<div id='divPRM_3' style='background: rgba(33, 33, 133, 0.3);padding:5px;color:#ffffff;text-align:left;'>";
	echo "<h4>Colonnes a afficher:</h4>";	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			switch ($row["name"]) {
				case 'ID':
					$colName = $dw3_lbl["ID"];
					break;
				case 'STAT':
					$colName = $dw3_lbl["STAT"];
					break;
				case 'NOM':
					$colName = $dw3_lbl["NOM"];
					break;
				case 'DESC':
					$colName = $dw3_lbl["DESC"];
					break;
				case 'CAT':
					$colName = $dw3_lbl["CAT"];
					break;
				case 'TOTAL':
					$colName = $dw3_lbl["TOTAL"];
					break;
				case 'FRN1':
					$colName = $dw3_lbl["FRN1"];
					break;
				case 'PACK':
					$colName = $dw3_lbl["PACK"];
					break;
				case 'KG':
					$colName = $dw3_lbl["KG"];
					break;
				case 'WIDTH':
					$colName = $dw3_lbl["WIDTH"];
					break;
				case 'HEIGHT':
					$colName = $dw3_lbl["HEIGHT"];
					break;
				case 'DEPTH':
					$colName = $dw3_lbl["DEPTH"];
					break;
				case 'PRIX_VTE':
					$colName = $dw3_lbl["PRIX_VTE"];
					break;
				case 'PRIX_ACH':
					$colName = $dw3_lbl["PRIX_ACH"];
					break;
				case 'DTAD':
					$colName = $dw3_lbl["DTAD"];
					break;
				case 'DTMD':
					$colName = $dw3_lbl["DTMD"];
					break;
			}
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_" . $row["name"] . "\").click();'>" . $colName . " :";
			echo "</td><td style='width:60px;'><label class='switch'>
					  <input id='DSP_COL_" . $row["name"] . "' type='checkbox' "; if ( $row["value"] =="1"){ echo " checked"; } echo ">
					  <span class='slider round'></span>
					</label></td></tr></table>";
		}
	} else {
			//ID
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_ID\").click();'>" . $dw3_lbl["ID"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>
				<input id='DSP_COL_ID' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//STAT                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_STAT\").click();'>" . $dw3_lbl["STAT"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
				    <input id='DSP_COL_STAT' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//NOM
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_NOM\").click();'>" . $dw3_lbl["NOM"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_NOM' type='checkbox'checked><span class='slider round'></span></label></td></tr></table>";
			//DESC                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_DESC\").click();'>" . $dw3_lbl["DESC"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_DESC' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//CAT                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_CAT\").click();'>" . $dw3_lbl["CAT"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_CAT' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//SCAT                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_TOTAL\").click();'>" . $dw3_lbl["TOTAL"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_TOTAL' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//FRN1                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_FRN1\").click();'>" . $dw3_lbl["FRN1"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_FRN1' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//PACK                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_PACK\").click();'>" . $dw3_lbl["PACK"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_PACK' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//KG                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_KG\").click();'>" . $dw3_lbl["KG"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_KG' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//WIDTH                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_WIDTH\").click();'>" . $dw3_lbl["WIDTH"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_WIDTH' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//HEIGHT                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_HEIGHT\").click();'>" . $dw3_lbl["HEIGHT"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_HEIGHT' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//DEPTH                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_DEPTH\").click();'>" . $dw3_lbl["DEPTH"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_DEPTH' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//PRIX_VTE                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_PRIX_VTE\").click();'>" . $dw3_lbl["PRIX_VTE"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_PRIX_VTE' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//PRIX_ACH                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_PRIX_ACH\").click();'>" . $dw3_lbl["PRIX_ACH"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_PRIX_ACH' type='checkbox'><span class='slider round'></span></label></td></tr></table>";			
		     //DTAD                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_DTAD\").click();'>" . $dw3_lbl["DTAD"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_DTAD' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
		     //DTMD                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_DTMD\").click();'>" . $dw3_lbl["DTMD"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_DTMD' type='checkbox'><span class='slider round'></span></label></td></tr></table>";                                    
	}                                          
	echo "<br><br></div>";                         

$dw3_conn->close();
?>

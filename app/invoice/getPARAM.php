<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
//parametres de l'application 
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
			//id
			echo "<option ";
			if ($row["value"] == 'ID'){ echo "selected ";}
			echo "value='ID'>#ID</option>";
			//nom prenom
			echo "<option ";
			if ($row["value"] == 'NOM'){ echo "selected ";}
			echo "value='NOM'>" . $dw3_lbl["FLNAM"] . "</option>";
			if ($row["value"] == 'PROJECT'){ echo "selected ";}
			echo "value='PROJECT'>ID Projet</option>";
			//adresse pays/prov/ville
			echo "<option ";
			if ($row["value"] == 'ADR'){ echo "selected ";}
			echo "value='ADR'>" . $dw3_lbl["ORDV"] . "</option>";
			//date creation
			echo "<option ";
			if ($row["value"] == 'DTAD'){ echo "selected ";}
			echo "value='DTAD'>" . $dw3_lbl["DTAD"] . "</option>";
			//date modif
			echo "<option ";
			if ($row["value"] == 'DTMD'){ echo "selected ";}
			echo "value='DTMD'>" . $dw3_lbl["DTMD"] . "</option>";
		}
	} else {
			//par defaut
			echo "<option value='ID'>#ID</option>";
			echo "<option value='NOM'>" . $dw3_lbl["FLNAM"] . "</option>";
			echo "<option value='PROJECT'>ID Projet</option>";
			echo "<option selected value='ADR'>" . $dw3_lbl["ORDV"]. "</option>";
			echo "<option value='DTAD'>" . $dw3_lbl["DTCR"] . "</option>";
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
			AND   name IN ('ID','ORDER_ID','PROJECT_ID','STAT','SOURCE','NOM','ADR1','CIE',
							'ADR2','VILLE','PROV','PAYS','CP',
							'NOTE','DTAD','DTDU','DTMD','STOT','TAX','TRP','TOT')
			ORDER BY value DESC";
	$result = $dw3_conn->query($sql);
	echo "<div id='divPRM_3' style='background: rgba(33, 33, 133, 0.3);padding:5px;color:#ffffff;text-align:left;'>";
	echo "<h4>Colonnes a afficher:</h4>";	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			switch ($row["name"]) {
				case 'ID':
					$colName = $dw3_lbl["ID"];
					break;
				case 'ORDER_ID':
					$colName = $dw3_lbl["ORDER_ID"];
					break;
				case 'PROJECT_ID':
					$colName = "ID Projet";
					break;
				case 'STAT':
					$colName = $dw3_lbl["STAT"];
					break;
				case 'SOURCE':
					$colName = "Source de la vente";
					break;
				case 'NOM':
					$colName = $dw3_lbl["NOM"];
					break;
				case 'CIE':
					$colName = "Compagnie";
					break;
				case 'ADR1':
					$colName = $dw3_lbl["ADR1"];
					break;
				case 'ADR2':
					$colName = $dw3_lbl["ADR2"];
					break;
				case 'VILLE':
					$colName = $dw3_lbl["VILLE"];
					break;
				case 'PROV':
					$colName = $dw3_lbl["PROV"];
					break;
				case 'PAYS':
					$colName = $dw3_lbl["PAYS"];
					break;
				case 'CP':
					$colName = $dw3_lbl["CP"];
					break;
				case 'NOTE':
					$colName = $dw3_lbl["NOTE"];
					break;
				case 'DTAD':
					$colName = $dw3_lbl["DTAD"];
					break;
				case 'DTDU':
					$colName = $dw3_lbl["DTDU"];
					break;
				case 'DTMD':
					$colName = $dw3_lbl["DTMD"];
					break;
				case 'STOT':
					$colName = $dw3_lbl["STOT"];
					break;
				case 'TAX':
					$colName = "Tx.";
					break;
				case 'TRP':
					$colName = "Transport";
					break;
				case 'TOT':
					$colName = "Total";
					break;
			}
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_" . $row["name"] . "\").click();'>" . $colName . " :";
			echo "</td><td style='width:60px;'><label class='switch'>
					  <input id='DSP_COL_" . $row["name"] . "' type='checkbox' "; if 	($row["value"] =="1"){ echo " checked"; } echo ">
					  <span class='slider round'></span>
					</label></td></tr></table>";

		}
	} else {
			//ID
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_ID\").click();'>" . $dw3_lbl["ID"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>
				<input id='DSP_COL_ID' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
                         
			//ORDER_ID
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_ORDER_ID\").click();'>" . $dw3_lbl["ORDER_ID"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>
				<input id='DSP_COL_ORDER_ID' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
                         
			//PROJECT_ID
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_PROJECT_ID\").click();'>ID Projet : ";
			echo "</td><td style='width:60px;'><label class='switch'>
				<input id='DSP_COL_PROJECT_ID' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
                         
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_STAT\").click();'>" . $dw3_lbl["STAT"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_STAT' type='checkbox' ><span class='slider round'></span></label></td></tr></table>";
                             
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_STAT\").click();'>Source de la vente : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_SOURCE' type='checkbox' ><span class='slider round'></span></label></td></tr></table>";
                             
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_NOM\").click();'>" . $dw3_lbl["NOM"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_NOM' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//ID                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_NOM\").click();'>Compagnie : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_CIE' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//ID                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_ADR1\").click();'>" . $dw3_lbl["ADR1"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_ADR1' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//ID                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_ADR2\").click();'>" . $dw3_lbl["ADR2"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_ADR2' type='checkbox' ><span class='slider round'></span></label></td></tr></table>";
			//ID                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_VILLE\").click();'>" . $dw3_lbl["VILLE"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_VILLE' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//ID                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_PROV\").click();'>" . $dw3_lbl["PROV"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_PROV' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//ID                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_PAYS\").click();'>" . $dw3_lbl["PAYS"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_PAYS' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//ID                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_CP\").click();'>" . $dw3_lbl["CP"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_CP' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
                        
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_NOTE\").click();'>" . $dw3_lbl["NOTE"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_NOTE' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
		     //ID                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_DTAD\").click();'>" . $dw3_lbl["DTAD"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_DTAD' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
		     //ID                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_DTDU\").click();'>" . $dw3_lbl["DTDU"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_DTDU' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
		     //ID                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_DTMD\").click();'>" . $dw3_lbl["DTMD"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_DTMD' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
		     //ID                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_STOT\").click();'>" . $dw3_lbl["STOT"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_STOT' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
		     //ID                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_TAX\").click();'>Taxes : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_TAX' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
		     //transport                              
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_TRP\").click();'>Transport : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_TRP' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
		     //total                               
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_TOT\").click();'>Total : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_TOT' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
		                                     
	                                           
	}                                          
    echo "<br><br></div>";                         

$dw3_conn->close(); ?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
//PARAMETRES CLIENTS
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
			//Responsive
			echo "<option ";
			if ($row["value"] == ''){ echo "selected ";}
			echo "value=''>Responsive</option>";
			//12
			echo "<option ";
			if ($row["value"] == '12'){ echo "selected ";}
			echo "value='12'>12</option>";
			//25
			echo "<option ";
			if ($row["value"] == '25'){ echo "selected ";}
			echo "value='25'>25</option>";
			//50
			echo "<option ";
			if ($row["value"] == '50'){ echo "selected ";}
			echo "value='50'>50</option>";
			//100
			echo "<option ";
			if ($row["value"] == '100'){ echo "selected ";}
			echo "value='100'>100</option>";
			//250
			echo "<option ";
			if ($row["value"] == '250'){ echo "selected ";}
			echo "value='250'>250</option>";
			//500
			echo "<option ";
			if ($row["value"] == '500'){ echo "selected ";}
			echo "value='500'>500</option>";
			//1000
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
			//nom type
			echo "<option ";
			if ($row["value"] == 'ID'){ echo "selected ";}
			echo "value='ID'>#Identification</option>";
			//nom type
			echo "<option ";
			if ($row["value"] == 'TYPE'){ echo "selected ";}
			echo "value='TYPE'>Type d'évènement</option>";
			//nom nom
			echo "<option ";
			if ($row["value"] == 'NAME'){ echo "selected ";}
			echo "value='NAME'>Nom</option>";
			//date modif
			echo "<option ";
			if ($row["value"] == 'DTMD'){ echo "selected ";}
			echo "value='DTMD'>" . $dw3_lbl["DTMD"] . "</option>";
		}
	} else {
			//par defaut
			echo "<option value='ID'>#Identification</option>";
			echo "<option value='TYPE'>Type d'évènement</option>";
			echo "<option value='NAME'>Nom</option>";
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
			AND   name IN ('ID','NAME','TYPE','DESC','DTMD')
			ORDER BY name";
	$result = $dw3_conn->query($sql);
	echo "<div id='divPRM_3' style='background: rgba(33, 33, 133, 0.3);padding:5px;color:#ffffff;text-align:left;'>";
	echo "<h4>Colonnes a afficher:</h4>";	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			switch ($row["name"]) {
				case 'ID':
					$colName = "#ID";
					break;
				case 'NAME':
					$colName = "Nom";
					break;
				case 'TYPE':
					$colName = "Type";
					break;
				case 'DESC':
					$colName = "Description";
					break;
				case 'DTMD':
					$colName = "Date et heure";
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
			//NOM
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_NAME\").click();'>Nom : ";
			echo "</td><td style='width:60px;'><label class='switch'>
				<input id='DSP_COL_NAME' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//TYPE                                                            
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_TYPE\").click();'>Type : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_TYPE' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//DESC                              
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_DESC\").click();'>Description : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_DESC' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
		     //DTMD                              
			echo "<table style='width:100%;border:0;'><tr><td width='*'  style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_DTMD\").click();'>Date et heure : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
							<input id='DSP_COL_DTMD' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";                                       
	                                           
	}                                          
                                        
echo "<br></div>";                         
$dw3_conn->close();
?>

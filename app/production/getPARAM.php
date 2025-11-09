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
        </select><br><small><i>Veuiller noter que les cartes n'affichent que le nom et l'image principale.</i></small><br>";
    }
} else {
    echo "Type d'affichage:<br> 
    <select id='prmDOC_TYPE'>
    <option value='TABLE' selected>Tableau</option>
    <option value='CARD'>Cartes images</option>
    </select><br><small><i>Veuiller noter que les cartes n'affichent que le nom et l'image principale.</i></small><br>";
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
			if ($row["value"] == 'PROC'){ echo "selected ";}
			echo "value='PROC'>Procédure #</option>";
            //size
			echo "<option ";
			if ($row["value"] == 'PRD'){ echo "selected ";}
			echo "value='PRD'>Produit #</option>";
            //kg
			echo "<option ";
			if ($row["value"] == 'STAT'){ echo "selected ";}
			echo "value='STAT'>Status</option>";
			//date creation
			echo "<option ";
			if ($row["value"] == 'ID'){ echo "selected ";}
			echo "value='ID'>#ID</option>";
			//date modif
			echo "<option ";
			if ($row["value"] == 'ORDER'){ echo "selected ";}
			echo "value='ORDER'>Commande #</option>";
			//date modif
			echo "<option ";
			if ($row["value"] == 'STORAGE'){ echo "selected ";}
			echo "value='STORAGE'>Emplacement</option>";
			//date modif
			echo "<option ";
			if ($row["value"] == 'LOT'){ echo "selected ";}
			echo "value='LOT'>Lot</option>";
			//date modif
			echo "<option ";
			if ($row["value"] == 'START'){ echo "selected ";}
			echo "value='START'>Date de début</option>";
			//date modif
			echo "<option ";
			if ($row["value"] == 'DUE'){ echo "selected ";}
			echo "value='DUE'>Date due</option>";
			//date modif
			echo "<option ";
			if ($row["value"] == 'END'){ echo "selected ";}
			echo "value='END'>Date de fin</option>";
		}
	} else {
			//par defaut
			echo "<option selected value='NOM'>Nom de procédure</option>";
			echo "<option value='ID'>#ID</option>";
			echo "<option value='CAT'>" . $dw3_lbl["CAT"] . "</option>";
			echo "<option value='PRD'>Produit #</option>";
			echo "<option value='STATUS'>Status</option>";
			echo "<option value='ORDER'>Commande #</option>";
			echo "<option value='LOT'>Lot #</option>";
			echo "<option value='STORAGE'>Emplacement</option>";
			echo "<option value='START'>Date de début</option>";
			echo "<option value='DUE'>Date due</option>";
			echo "<option value='END'>Date de fin</option>";
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
            AND   name IN ('ID','STAT','NOM','PROC','PRD','ORDER','LOT','QTY','STORAGE','START','DUE','END','CAT')
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
				case 'PROC':
					$colName = "Procédure #";
					break;
				case 'CAT':
					$colName = $dw3_lbl["CAT"];
					break;
				case 'PRD':
					$colName = "Produit #";
					break;
				case 'ORDER':
					$colName = "Commande #";
					break;
				case 'LOT':
					$colName = "Lot #";
					break;
				case 'QTY':
					$colName = "Quantité";
					break;
   				case 'STORAGE':
					$colName = "Emplacement";
					break;
				case 'START':
					$colName = "Date de début";
					break;
				case 'DUE':
					$colName = "Date due";
					break;
				case 'END':
					$colName = "Date de fin";
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
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_ID\").click();'>" . $dw3_lbl["ID"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>
				<input id='DSP_COL_ID' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//STAT                               
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_STAT\").click();'>" . $dw3_lbl["STAT"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
				    <input id='DSP_COL_STAT' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//NOM
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_NOM\").click();'>" . $dw3_lbl["NOM"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_NOM' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//PROC                               
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_PROC\").click();'>Procédure # : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_PROC' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//CAT                               
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_CAT\").click();'>" . $dw3_lbl["CAT"]   . " : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_CAT' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//PRD                               
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_PRD\").click();'>Produit # : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_PRD' type='checkbox' checked><span class='slider round'></span></label></td></tr></table>";
			//ORDER                               
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_ORDER\").click();'>Commande # : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_ORDER' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//QTY                           
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_QTY\").click();'>Quantité : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_QTY' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//LOT                            
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_LOT\").click();'>Lot # : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_LOT' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//STORAGE                               
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_STORAGE\").click();'>Emplacement : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_STORAGE' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//START                               
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_START\").click();'>Date de début : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_START' type='checkbox'><span class='slider round'></span></label></td></tr></table>";
			//DUE                               
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_DUE\").click();'>Date d'échéance : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_DUE' type='checkbox'  checked><span class='slider round'></span></label></td></tr></table>";
			//END                               
			echo "<table style='width:100%;border:0;'><tr><td width='*' style='border-bottom:1px dashed #666;cursor:pointer;' onclick='document.getElementById(\"DSP_COL_END\").click();'>Date de fin : ";
			echo "</td><td style='width:60px;'><label class='switch'>       
					<input id='DSP_COL_END' type='checkbox'><span class='slider round'></span></label></td></tr></table>";                                  
	}                                          
	echo "<br><br></div>";                         

$dw3_conn->close();
?>

<?php
require '../security.php';
$CAT  = $_GET['CAT'];
$OFFSET  = $_GET['OFFSET'];
$LIMIT  = $_GET['LIMIT'];

if ($USER_LANG == "FR"){
	$LBL_HEAD = "Clients";
	$LBL_SAVE = "Sauvegarder";
	$LBL_NAME = "Nom";
// } else if ($USER_LANG == "ES"){ 
} else {
	$LBL_HEAD = "Customers";
	$LBL_SAVE = "Save";
	$LBL_NAME = "First Name";
}

if ($OFFSET == ""){
	$OFFSET = "0";	
}
if ($LIMIT == ""){
	$LIMIT = "15";	
}

//GET TOTAL
if ($CAT == ""){
			$sql = "SELECT COUNT(*) as prCOUNT
				FROM BDPROD" ;
} else {
			$sql = "SELECT COUNT(*) as prCOUNT
				FROM BDPROD 
				WHERE prCAT = '" . $CAT . "'";
}
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$numrows = $row["prCOUNT"] ;
		}
	}

//with offset
if ($CAT == ""){
			$sql = "SELECT *
				FROM BDPROD
				ORDER BY trim(prNOM)
				LIMIT " . $LIMIT . " OFFSET " . $OFFSET ;
} else {
			$sql = "SELECT *
				FROM BDPROD 
				WHERE prCAT = '" . $CAT . "'
				ORDER BY trim(prNOM)
				LIMIT " . $LIMIT . " OFFSET " . $OFFSET ;
}

		$result = $dw3_conn->query($sql);
		if ($result->num_rows > 0) {		
			echo "<table id='dataTABLE' class='tblDATA'>
			<tr><th onclick='sortTable(0)'>Nom</th><th onclick='sortTable(1)'>#Produit</th><th onclick='sortTable(2)'>Description</th><th onclick='sortTable(3)'>Qte/Boite</th></tr>";
			while($row = $result->fetch_assoc()) {
				echo "
					 <tr onclick='getPRD(\"". $row["prID"] . "\");'>"
					. "<td>". $row["prNOM"] . "</td>"
					. "<td>". $row["prSKU"] . "</td>"
					. "<td>". $row["prDESC"] . "</td>"
					. "<td>". $row["prPACK"] . "</td>"
					. "</tr>";
			}
			echo "</table><div id='divFOOT'>";
			//FIRST PAGE
			if ($OFFSET > 0){
				echo "<button onclick='getPRDS(\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled'><span class='material-icons'>first_page</span></button>";
			}
			//PREVIOUS PAGE
			if ($OFFSET > 0){
				$page = $OFFSET-$LIMIT;
				if ($page<0){$page=0;}
				echo "<button onclick='getPRDS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled'><span class='material-icons'>navigate_before</span></button>";
			}
			//CURRENT PAGE
			echo "offset:" . $OFFSET 
			. " limit:" . $LIMIT 
			. " page:" . ceil(($OFFSET/$LIMIT)+1) 
			. " nbpages:" . ceil($numrows/$LIMIT) 
			. " rows:" . $numrows ;
			//NEXTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$page = $OFFSET+$LIMIT;
				echo "<button onclick='getPRDS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>navigate_next</span></button>";
			}
			//LASTPAGE
			if (($OFFSET+$LIMIT) < ($numrows)){
				$lastpage = $numrows-$LIMIT;
				echo "<button onclick='getPRDS(\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
			} else {
				echo "<button style='background:#666666;' disabled><span class='material-icons'>last_page</span></button>";
			}
			echo "</div>";
		}
$dw3_conn->close();
?>
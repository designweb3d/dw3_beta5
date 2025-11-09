<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$LOOK_FOR = ucwords($_GET['LOOK_FOR']); //premiere lettre en majuscule
$LOOK_FOR2 = strtolower($_GET['LOOK_FOR']); //tout en minuscules
$LOOK_FOR3 = strtoupper($_GET['LOOK_FOR']); //tout en majuscules
echo "Seul les clients et employés inscrits sont affichés ici.<br><div style='font-weight: 300;'>Un maximum de 100 clients est affiché pour éviter de déclancher les filtres anti-spams. Faites une recherche pour réduire le nombre de résultats.</div>";
echo "<div><input type='text' id='cli_look_for' placeholder='Rechercher...' value='" . htmlspecialchars($_GET['LOOK_FOR'], ENT_QUOTES) . "' style='width:85%;margin:5px;'><button class='grey' onclick='sendART(document.getElementById(\"dw3_lst_id\").value,document.getElementById(\"cli_look_for\").value);'><span class='material-icons'>search</span></button></div>";
echo "<form onsubmit='submitForm(event)' id='frmCLI_LST' class='submit-disabled' style='text-align:left;font-weight: 300;'>";

    //clients
    if ($LOOK_FOR != "") {
        $LOOK_FOR = dw3_crypt($LOOK_FOR);
        $sql = "SELECT * FROM customer WHERE news_stat = 1 and stat=0 and (CONCAT(first_name,last_name,company,eml1) LIKE '%" . $LOOK_FOR . "%' OR CONCAT(first_name,last_name,company,eml1) LIKE '%" . $LOOK_FOR2 . "%' OR CONCAT(first_name,last_name,company,eml1) LIKE '%" . $LOOK_FOR3 . "%') LIMIT 100;";
    } else {
        $sql = "SELECT * FROM customer WHERE news_stat = 1 and stat=0 LIMIT 100;";
    }
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	
        echo "<h2 style='text-align:left;padding-left:5px;'>Clients:</h2>";
		while($row = $result->fetch_assoc()) {
            echo "<div style='display:inline-block;border-bottom:1px solid #777;width:97%;padding:5px 0px;margin:3px;'><input type='checkbox' id='CLI_LST_".$row["id"]."' value='".$row["id"]."' checked style='margin-right:5px;'> <label for='CLI_LST_".$row["id"]."'> ".dw3_decrypt($row["first_name"])." ".dw3_decrypt($row["last_name"])." - ".dw3_decrypt($row["eml1"])."</label></div>";
        }
    }
echo "</form>";
if ($result->num_rows > 0) {
    echo "<div style='width:100%;text-align:left;'><button class='grey' onclick='selALL(\"frmCLI_LST\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
    echo " <button class='grey' onclick='selNONE(\"frmCLI_LST\",\"checkbox\");'><span class='material-icons'>remove_done</span></button></div>";
}
echo "<form onsubmit='submitForm(event)' id='frmUSR_LST' class='submit-disabled' style='text-align:left;margin-top:10px;'>";
    //utilisateurs
    if ($LOOK_FOR != "") {
        $sql = "SELECT * FROM user WHERE news_stat = 1 and stat=0 and (CONCAT(first_name,last_name,eml1,name) LIKE '%" . $LOOK_FOR . "%' OR CONCAT(first_name,last_name,eml1,name) LIKE '%" . $LOOK_FOR2 . "%' OR CONCAT(first_name,last_name,eml1,name) LIKE '%" . $LOOK_FOR3 . "%');";
    } else {
        $sql = "SELECT * FROM user WHERE news_stat = 1 and stat=0;";
    }
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	
        echo "<h2 style='text-align:left;padding-left:5px;'>Employés:</h2>";
		while($row = $result->fetch_assoc()) {
            echo "<div style='display:inline-block;border-bottom:1px solid #777;width:97%;padding:5px 0px;margin:3px;'><input type='checkbox' id='USR_LST_".$row["id"]."' value='".$row["id"]."' checked style='margin-right:5px;'> <label for='USR_LST_".$row["id"]."'> ".trim($row["first_name"]." ".$row["last_name"])." (".$row["name"].")" . " - ".$row["eml1"]."</label></div>";
        }
    }
echo "</form>";
if ($result->num_rows > 0) {
    echo "<div style='width:100%;text-align:left;'><button class='grey' onclick='selALL(\"frmUSR_LST\",\"checkbox\");'><span class='material-icons'>done_all</span></button>";
    echo " <button class='grey' onclick='selNONE(\"frmUSR_LST\",\"checkbox\");'><span class='material-icons'>remove_done</span></button></div>";
}
$dw3_conn->close();
exit();
?>
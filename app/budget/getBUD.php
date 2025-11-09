<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];

	$sql = "SELECT * FROM budget WHERE id = " . $ID . " LIMIT 1";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	

		while($row = $result->fetch_assoc()) {
			echo "<div id='divEDIT_HEADER' class='dw3_form_head'>
                        <h2>" . htmlspecialchars($row["name_fr"], ENT_QUOTES) . "</h2>
                         <button class='grey' style='top:0px;right:0px;padding:4px;position:absolute;' onclick='closeEDITOR(this);'><span class='material-icons'>cancel</span></button>
                </div>
                <div style='position:absolute;top:40px;left:0px;right:0px;bottom:50px;overflow-x:hidden;overflow-y:auto;'>           
                    <div class='divBOX'>Nom:
                        <input id='budNAME_FR' type='text' value='" . htmlspecialchars($row["name_fr"], ENT_QUOTES) . "'>
                    </div><br>
                    <div class='divBOX'>Type:
                        <div style='display:inline-block;float:right;'>
                            <input id='budREVENU_1' name='budREVENU' type='radio' value='1' " . ($row["revenu"] == 1 ? "checked" : "") . " style='vertical-align: middle;'> <label for='budREVENU_1'> Revenu</label>
                            <input id='budREVENU_0' name='budREVENU' type='radio' value='0' " . ($row["revenu"] == 0 ? "checked" : "") . " style='vertical-align: middle;'> <label for='budREVENU_0'> Dépense</label>
                        </div>
                    </div><br>
                    <div class='divBOX'>Date de début:
                        <input id='budSTART' type='date' value='" . $row["date_start"] . "'>
                    </div><br>
                    <div class='divBOX'>Date de fin:";
                    if ($APREAD_ONLY == false) { echo "<button class='blue' style='float:right;' onclick='calcEnd();' style='padding:4px;'><span class='material-icons' style='font-size:14px'>free_cancellation</span></button>";}
                    echo "<input id='budEND' type='date' value='" . $row["date_end"] . "'>
                    </div><br>
                    <div class='divBOX'>Fréquence:
                        <select id='budFREQ'>
                            <option value=''" . ($row["freq"] == '' ? " selected" : "") . ">Non défini</option>
                            <option value='ONETIME'" . ($row["freq"] == 'ONETIME' ? " selected" : "") . ">Une fois</option>
                            <option value='DAILY'" . ($row["freq"] == 'DAILY' ? " selected" : "") . ">Quotidien</option>
                            <option value='WEEKLY'" . ($row["freq"] == 'WEEKLY' ? " selected" : "") . ">Hebdomadaire</option>
                            <option value='BI-WEEKLY'" . ($row["freq"] == 'BI-WEEKLY' ? " selected" : "") . ">Bihebdomadaire</option>
                            <option value='MONTHLY'" . ($row["freq"] == 'MONTHLY' ? " selected" : "") . ">Mensuel</option>
                            <option value='MONTHLY2'" . ($row["freq"] == 'MONTHLY2' ? " selected" : "") . ">Bimestriel</option>
                            <option value='MONTHLY3'" . ($row["freq"] == 'MONTHLY3' ? " selected" : "") . ">Trimestriel</option>
                            <option value='MONTHLY4'" . ($row["freq"] == 'MONTHLY4' ? " selected" : "") . ">Quadrimestriel</option>
                            <option value='MONTHLY6'" . ($row["freq"] == 'MONTHLY6' ? " selected" : "") . ">Semestriel</option>
                            <option value='YEARLY'" . ($row["freq"] == 'YEARLY' ? " selected" : "") . ">Annuel</option>
                        </select>
                    </div><br>
                    <div class='divBOX'>Montant:
                        <input id='budMONTANT' type='number' step='0.01' value='" . $row["amount"] . "' style='text-align:right;'>
                    </div><br>
                </div><div class='dw3_form_foot'>";
                    if ($APREAD_ONLY == false) { echo "<button class='red' onclick='deleteBUD(\"" . $row["id"] . "\");'><span class='material-icons'>delete</span></button>";}
                    echo "<button class='grey' onclick='closeEDITOR();'><span class='material-icons'>cancel</span> " . $dw3_lbl["CLOSE"] . "</button>";
                    if ($APREAD_ONLY == false) { echo "<button class='green' onclick='updBUD(\"" . $row["id"] . "\");'><span class='material-icons'>save</span>" . $dw3_lbl["SAVE"] . "</button>";}
				echo "</div>";
		}
	
	}
$dw3_conn->close();
?>
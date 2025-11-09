<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$clID  = $_GET['clID'];

	$sql = "SELECT * FROM customer WHERE id = '" . $clID . "' LIMIT 1";

	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {		
		while($row = $result->fetch_assoc()) {
			echo "<div style='color:#bbbbbb;width:95%;text-align:left;padding:20px 10px 10px 10px;'>
                <b style='color:#ffffff'>" . $LBL_ADR . ":</b>
                " . dw3_decrypt($row["clADR1"]) ." ". $row["city"] . " " .  $row["province"] ." " .  $row["country"] ." " .  $row["postal_code"] ."
			    <hr style='height:5px;margin:0px;'>
                <b style='color:#ffffff'>" . $LBL_NOM . ":</b>
                " . $row["title"] ." ". dw3_decrypt($row["first_name"]) . " " .  dw3_decrypt($row["last_name"]) ."
			    <hr style='height:5px;margin:0px;'>
                <b style='color:#ffffff'>" . $LBL_TEL1 . ":</b>
                <a style='color:#bbbbbb;' href='tel:+" . dw3_decrypt($row["tel1"]) . "'><u>" . dw3_decrypt($row["tel1"]) . "</u></a>
			    <hr style='height:5px;margin:0px;'>
                <b style='color:#ffffff'>" . $LBL_TEL2 . ":</b>
                <a style='color:#bbbbbb;' href='tel:+" . $row["tel2"] . "'><u>" . $row["tel2"] . "</u></a>
			    <hr style='height:5px;margin:0px;'>
                <b style='color:#ffffff'>Notes:</b>
                <textarea id='clNOTE' style='width:100%;height:60px;' >" . str_replace('<br>', '&#10;', $row["note"]) . "</textarea>
                <br><h3 style='color:rgba(207, 205, 205, 0);'>Envoi de SMS</h3>
                <div class='divBOX' style='color:#bbbbbb;width:100%;'>
                    Losrqu'arrivé sur place:
                    <select>
                        <option selected>Déneigement en cours</option>
                        <option>Aucun envoi de SMS</option>
                    </select><br>
                    Envoyer un SMS maintenant:
                    <select>
                        <option>Avis arriver dans 15 mins.</option>
                        <option>Avis arriver dans 30 mins.</option>
                        <option>Avis arriver dans 60 mins.</option>
                        <option>Avis de vehicule emcombrant</option>
                    </select><button>Envoyer</button>                   
                </div>
            </div>
            <div style='position:sticky;bottom:0px;right:0px;left:0px;height:50px;background:rgba(33, 33, 33, 0.7);'>
            <button style='background:#555555;' onclick='closeEDITOR();'><span class='material-icons'>cancel</span> Annuler</button>
            <button onclick='updCLI_RTE(\"" . $row["id"] . "\");'><span class='material-icons'>save</span> Sauvegarder</button>
            </div>";
		}
	}
$dw3_conn->close();
?>

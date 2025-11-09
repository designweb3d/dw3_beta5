<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$sql = "SELECT * FROM supply WHERE id='".$ID."' LIMIT 1 ;";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {		
    while($row = $result->fetch_assoc()) {
        echo "<div class='divBOX'>Nom:
            <input id='spNAME' type='text' style='width:50%;float:right;' value='" . $row["name_fr"] . "' onclick='detectCLICK(event,this);'>
            </div>";
        echo "<div class='divBOX'>Type:
                <select id='spTYPE' style='width:50%;float:right;'>
                    <option value='BOX'"; if 	($row["supply_type"] =="BOX"){ echo " selected"; } echo ">Boîte</option>
                    <option value='ENVELOPE'"; if 	($row["supply_type"] =="ENVELOPE"){ echo " selected"; } echo ">Enveloppe</option>
                    <option value='CRATE'"; if 	($row["supply_type"] =="CRATE"){ echo " selected"; } echo ">Caisse</option>
                </select>
            </div>";
        echo "<div class='divBOX'>Largeur en CM:
            <input id='spWIDTH' type='number' style='width:50%;float:right;' value='" . $row["width"] . "' onclick='detectCLICK(event,this);'>
            </div>";
        echo "<div class='divBOX'>Hauteur en CM:
            <input id='spHEIGHT' type='number' style='width:50%;float:right;' value='" . $row["height"] . "' onclick='detectCLICK(event,this);'>
            </div>";
        echo "<div class='divBOX'>Profondeur en CM:
            <input id='spDEPTH' type='number' style='width:50%;float:right;' value='" . $row["depth"] . "' onclick='detectCLICK(event,this);'>
            </div>";
        echo "<div class='divBOX'>Poid en KG:
            <input id='spWEIGHT' type='number' style='width:50%;float:right;' value='" . $row["weight"] . "' onclick='detectCLICK(event,this);'>
            </div><hr>";
        echo "<button class='grey' onclick='openSUPPLY();'><span class='material-icons'>cancel</span> Fermer</button>";
        if ($APREAD_ONLY == false) { echo "<button class='red' style='color:yellow;' onclick='delSUPPLY(".$row["id"].");'><span class='material-icons'>delete</span> Supprimer</button>";}
        if ($APREAD_ONLY == false) { echo "<button class='green' onclick='updSUPPLY(".$row["id"].");'><span class='material-icons'>save</span> Enregistrer</button><hr>";}
    }
}
$dw3_conn->close();
?>
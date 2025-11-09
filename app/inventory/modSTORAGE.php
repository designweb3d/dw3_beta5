<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID  = $_GET['ID'];
$sql = "SELECT * FROM storage WHERE id='".$ID."' LIMIT 1 ;";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {		
    while($row = $result->fetch_assoc()) {
        echo "<div class='divBOX'>Adresse:
                <select id='stLOCATION'>";
                $sql2 = "SELECT * FROM location ORDER BY name";
                $result2 = $dw3_conn->query($sql2);
                echo "<option value='' disabled>Choisir une adresse</option>";
                if ($result2->num_rows > 0) {	
                    while($row2 = $result2->fetch_assoc()) {
                         echo "<option value='". $row2["id"] . "' "; if($row["location_id"] == $row2["id"]){echo "selected";} echo ">"	. $row2["name"] . "</option>";
                    }
                }
        echo "</select>
            </div>";
        echo "<div><div class='divBOX'>Étage:
                <input id='stLEVEL' type='text' style='width:50%;float:right;' value='" . $row["level"] . "' onclick='detectCLICK(event,this);'>
            </div>";
        echo "<div><div class='divBOX'>Local:
                <input id='stLOCAL' type='text' style='width:50%;float:right;' value='" . $row["local"] . "' onclick='detectCLICK(event,this);'>
            </div>";
        echo "<div><div class='divBOX'>Allée:
                <input id='stROW' type='text' style='width:50%;float:right;' value='" . $row["row"] . "' onclick='detectCLICK(event,this);'>
            </div>";
        echo "<div><div class='divBOX'>Étagère:
                <input id='stSHELF' type='text' style='width:50%;float:right;' value='" . $row["shelf"] . "' onclick='detectCLICK(event,this);'>
            </div>";
        echo "<div><div class='divBOX'>Section:
                <input id='stSECTION' type='text' style='width:50%;float:right;' value='" . $row["section"] . "' onclick='detectCLICK(event,this);'>
            </div>";

        echo "</div><hr>";
        echo "<button class='grey' onclick='openSTORAGE();'><span class='material-icons'>cancel</span> Fermer</button>";
        if ($APREAD_ONLY == false) { echo "<button class='red' style='color:yellow;' onclick='delSTORAGE(".$row["id"].");'><span class='material-icons'>delete</span> Supprimer</button>";}
        if ($APREAD_ONLY == false) { echo "<button class='green' onclick='updSTORAGE(".$row["id"].");'><span class='material-icons'>save</span> Enregistrer</button><hr>";}
    }
}
$dw3_conn->close();
?>
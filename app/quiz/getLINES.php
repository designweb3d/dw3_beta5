<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];

echo "<table class='tblSEL'>
    <tr style='background:white;'>
        <th>#</th>
        <th>Type</th>
        <th>Question</th>
    </tr>";

	$sql = "SELECT * FROM prototype_line WHERE head_id = '" . $ID . "' ORDER BY position ASC;";
	$result = $dw3_conn->query($sql);
	if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
            echo "<tr onclick=\"getLINE('". $row["id"] . "');\">";
            echo "<td>".$row["position"]."</td>";
            if ($row["response_type"] == "TEXT"){
                echo "<td width='120px'>Texte / Nombre</td>";
            }else if ($row["response_type"] == "CHECKBOX"){
                echo "<td width='120px'>Case à cocher</td>";
            }else if ($row["response_type"] == "YES/NO"){
                echo "<td width='120px'>Oui / Non</td>";
            }else if ($row["response_type"] == "CHOICE"){
                echo "<td width='120px'>Choix de réponses</td>";
            }else if ($row["response_type"] == "MULTI-CHOICE"){
                echo "<td width='120px'>Choix de réponses multiple</td>";
            }else if ($row["response_type"] == "MULTI-TEXT"){
                echo "<td width='120px'>Texte / Nombre multiple</td>";
            }else if ($row["response_type"] == "FILE"){
                echo "<td width='120px'>Fichier</td>";
            }else if ($row["response_type"] == "COLOR"){
                echo "<td width='120px'>Couleur</td>";
            }else if ($row["response_type"] == "PASSWORD"){
                echo "<td width='120px'>Mot de passe</td>";
            }else if ($row["response_type"] == "DATE"){
                echo "<td width='120px'>Date</td>";
            }else if ($row["response_type"] == "TIME"){
                echo "<td width='120px'>Heure</td>";
            }else if ($row["response_type"] == "SIGNATURE"){
                echo "<td width='120px'>Signature</td>";
            }else if ($row["response_type"] == "SIG-USER"){
                echo "<td width='120px'>Signature de l'employé</td>";
            }else if ($row["response_type"] == "PICKTIME"){
                echo "<td width='120px'>Date et heure de ramassage</td>";
            }else if ($row["response_type"] == "NONE"){
                echo "<td width='120px'>Information</td>";
            } else {
                echo "<td width='120px'>Erreur</td>";
            }
            echo "<td width='*'>".$row["name_fr"]."</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
$dw3_conn->close();
?>
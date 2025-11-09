<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$clID  = $_GET['clID'];
$sqla = "SELECT A.*, B.name AS user_name 
    FROM event A
    LEFT JOIN user B ON A.user_id = B.id
    WHERE A.customer_id = '" . $clID . "'
    ORDER BY A.date_start DESC";
        $resulta = $dw3_conn->query($sqla);
        echo "<table class='tblSEL'><tr><th colspan=2>Évènement</th><th>Utilisateur</th><th>Date</th><th>Heure</th></tr>";
        if ( $resulta->num_rows > 0) {
            while($rowa = $resulta->fetch_assoc()) {
                if ($rowa["event_type"] == "CALL_INFO"){
                    $event_type = "Appel pour info";
                } else if ($rowa["event_type"] == "CALL_TECH"){
                    $event_type = "Demande de support";
                } else if ($rowa["event_type"] == "TASK"){
                    $event_type = "Tâche";
                } else if ($rowa["event_type"] == "EMAIL"){
                    $event_type = "Courriel";
                } else if ($rowa["event_type"] == "COMPLAINT"){
                    $event_type = "Plainte";
                } else if ($rowa["event_type"] == "PRIVACY_INCIDENT"){
                    $event_type = "Incident de confidentialité";
                } else if ($rowa["event_type"] == "CUSTOMER"){
                    $event_type = "Ajout / Modification";
                } else {
                    $event_type = "Autre";
                }
                echo "<tr onclick='getEVENT(".$rowa["id"].")'><td>" . $event_type  . "</td><td>" . $rowa["name"] . "</td><td>" . $rowa["user_name"] . "</td><td>".substr($rowa["date_start"],0,10). "</td><td>".substr($rowa["date_start"],11,5). "</td></tr>";  
            }
        } else{
            echo "<tr><td colspan=4>Aucun évènement trouvé.</td></tr>";
        }
echo "</table>";
$dw3_conn->close();
?>

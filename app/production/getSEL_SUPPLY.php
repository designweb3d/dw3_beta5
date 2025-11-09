<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$why  = $_GET['why'];
$html="";

$sql = "SELECT * FROM supply ";
if ($SS != "") { $sql = $sql . " AND UCASE(name_fr) like '%" . strtoupper($SS) . "%' "; }
$sql = $sql . " ORDER BY name_fr ASC LIMIT 100;";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {	
    $html .= "<div style='max-width:100%;overflow-y:auto;'>
    <table class='tblSEL'>
    <tr></tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Type</th>
        <th>Hauteur</th>
        <th>Largeur</th>
        <th>Profondeur</th>
        <th>Poid</th>";  
    $html .= "</tr>";
    while($row = $result->fetch_assoc()) {
        $html .= "<tr onclick=\"validateSUPPLY('". $row["id"] . "','". $row["name_fr"] . "');\">";
        $html .= "<td>". $row["id"] .   "</td>";
        $html .= "<td>". $row["name_fr"] .   "</td>";
        $html .= "<td>" . $row["supply_type"] .  "</td>";
        $html .= "<td>" . $row["height"] .  "</td>";
        $html .= "<td>" . $row["width"] .  "</td>";
        $html .= "<td>" . $row["depth"] .  "</td>";
        $html .= "<td>" . $row["weight"] .  "</td>";
        $html .= "</tr>";
    }
    $html .= "</table></div>";
    if ($result->num_rows > 100) {
        $html .= "<div style='text-align:center;color:red;'>Plus de 100 résultats, veuillez affiner votre recherche.</div>";
    }
} else {
    $html .= "<div style='text-align:center;color:red;'>Aucun résultat trouvé.</div>";
}
$dw3_conn->close();
die($html);
?>

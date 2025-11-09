<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$html="";

$sql = "SELECT * FROM user WHERE stat=0 ";
if ($SS != "") { $sql = $sql . " AND UCASE(CONCAT(first_namelast_name,name,eml1,eml2,eml3)) like '%" . strtoupper($SS) . "%' "; }
$sql = $sql . " ORDER BY last_name ASC, first_name ASC LIMIT 100;";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {	
    $html .= "<div style='max-width:100%;overflow-y:auto;'>
    <table class='tblSEL'>
    <tr></tr>
        <th>ID</th>
        <th>Auth.</th>
        <th>Username</th>
        <th>Nom</th>
        <th>Courriel</th></tr>";
    while($row = $result->fetch_assoc()) {
        $html .= "<tr onclick=\"validateUSER('". $row["id"] . "','". $row["first_name"] . " " . strtoupper($row["last_name"]) . "');\">";
        $html .= "<td>". $row["id"] .   "</td>";
        $html .= "<td>" . $row["auth"] .  "</td>";
        $html .= "<td>" . $row["name"] .  "</td>";
        $html .= "<td><b>". strtoupper($row["last_name"]) . "</b>, " . $row["first_name"] .   "</td>";
        $html .= "<td>" . $row["eml1"] .  "</td>";
        $html .= "</tr>";
    }
    $html .= "</table></div>";
    if ($result->num_rows > 100) {
        $html .= "<div style='text-align:center;color:red;'>Plus de 100 résultats, veuillez affiner votre recherche.</div>";
    }
}
$dw3_conn->close();
die($html);
?>

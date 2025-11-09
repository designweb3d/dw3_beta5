<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$why  = $_GET['why'];
$html="";

$sql = "SELECT A.*, B.name AS location_name FROM order_head A LEFT JOIN location B ON A.location_id = B.id ";
if ($SS != "") { $sql = $sql . " WHERE UCASE(CONCAT(postal_code,city)) like '%" . strtoupper($SS) . "%' OR name like '%" . dw3_crypt($SS) . "%' OR name like '%" . dw3_crypt(ucwords($SS)) . "%'"; }
$sql = $sql . " ORDER BY id DESC LIMIT 100;";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {	
    $html .= "<div style='max-width:100%;overflow-y:auto;'>
    <table class='tblSEL'>
    <tr></tr>
        <th>ID</th>
        <th>Magasin</th>
        <th>Client</th>
        <th>Ville</th>
        <th>Date créée</th>";  
    $html .= "</tr>";
    while($row = $result->fetch_assoc()) {
        $html .= "<tr onclick=\"validateORDER('". $row["id"] . "','". dw3_decrypt($row["name"]) . "');\">";
        $html .= "<td>". $row["id"] .   "</td>";
        $html .= "<td>". $row["location_name"] .   "</td>";
        $html .= "<td>" . dw3_decrypt($row["name"]) .  "</td>";
        $html .= "<td>" . $row["city"] .  "</td>";
        $html .= "<td>" . $row["date_modified"] .  "</td>";
        $html .= "</tr>";
    }
    $html .= "</table></div>";
    if ($result->num_rows > 100) {
        $html .= "<div style='text-align:center;color:red;'>Plus de 100 résultats, veuillez affiner votre recherche.</div>";
    }
} else {
    $html .= "Aucun résultat trouvé.";
}
$dw3_conn->close();
die($html.$sql);
?>

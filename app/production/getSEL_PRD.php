<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$SS  = mysqli_real_escape_string($dw3_conn, $_GET['SS']);
$why  = $_GET['why'];
$html="";

$sql = "SELECT A.*, IFNULL(B.name_fr, '') AS category_name FROM product A
LEFT JOIN product_category B ON A.category_id = B.id ";
if ($SS != "") { $sql = $sql . " AND UCASE(CONCAT(A.name_fr,A.name_en,A.upc)) like '%" . strtoupper($SS) . "%' "; }
$sql = $sql . " ORDER BY name_fr ASC LIMIT 100;";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {	
    $html .= "<div style='max-width:100%;overflow-y:auto;'>
    <table class='tblSEL'>
    <tr></tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Catégorie principale</th>";  
    $html .= "</tr>";
    while($row = $result->fetch_assoc()) {
        $html .= "<tr onclick=\"validatePRD('". $row["id"] . "','". $row["name_fr"] . "','". $why . "');\">";
        $html .= "<td>". $row["id"] .   "</td>";
        $html .= "<td>". $row["name_fr"] .   "</td>";
        $html .= "<td>" . $row["category_name"] .  "</td>";
        $html .= "</tr>";
    }
    $html .= "</table></div>";
    if ($result->num_rows > 100) {
        $html .= "<div style='text-align:center;color:red;'>Plus de 100 résultats, veuillez affiner votre recherche.</div>";
    }
} else {
    $html .= "<div style='text-align:center;color:red;'>Aucun produit trouvé.</div>";
}
$dw3_conn->close();
die($html.$sql);
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$html = "";	
$sql = "SELECT DISTINCT(kind) FROM gl ";
$result = $dw3_conn->query($sql);
$numrows = $result->num_rows;
$html .= "<select id='selKIND' onchange='getKIND();'>";
$html .= "<option value=''>Tout les postes</option>";
if ($numrows > 0) {		
    while($row = $result->fetch_assoc()) {
        $html .= "<option value='" . $row["kind"] . "'>" . $row["kind"] . "</option>";
    }
}else {
    $html .= "<option disabled value=''>Erreur lecture du GL</option>";
}
$html .= "</select>";
echo $html;
$dw3_conn->close();
?>

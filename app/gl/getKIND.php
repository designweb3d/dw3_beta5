<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$KIND = mysqli_real_escape_string($dw3_conn,$_GET['KIND']);
$html = "";	
$sql = "SELECT *, IFNULL(B.gl_code,'') as is_used FROM gl 
        LEFT JOIN (SELECT DISTINCT(gl_code) FROM gls) B ON B.gl_code = code ";
    if (trim($KIND) !=""){
            $sql .= " WHERE kind = '" . $KIND . "' ";
    }
$result = $dw3_conn->query($sql);
$numrows = $result->num_rows;
$html .= "<table class='tblSEL'>";
if ($numrows > 0) {		
    while($row = $result->fetch_assoc()) {
        if ($row["is_used"] != ""){
            $html .= "<tr onclick='getCODE(" . $row["code"] . ");'><td style='width:40px;text-align:center;'><b>" . $row["code"] . "</b></td><td width='*'><sup><span class='material-icons' style='font-size:10px;color:gold;margin-left:-10px;margin-top:-3px;'>star_rate</span></sup><b>" . $row["name_fr"] . "</b></td><td style='text-align:center;'>" . $row["kind"] . "</td></tr>";
        }else{
            $html .= "<tr onclick='getCODE(" . $row["code"] . ");'><td style='width:40px;text-align:center;'><b>" . $row["code"] . "</b></td><td width='*'><b>" . $row["name_fr"] . "</b></td><td style='text-align:center;'>" . $row["kind"] . "</td></tr>";
        }
    }
}else {
    $html .= "<tr><td>Aucun poste trouvé pour cette section</td></tr>";
}
$html .= "</table>";
echo $html;
$dw3_conn->close();
?>

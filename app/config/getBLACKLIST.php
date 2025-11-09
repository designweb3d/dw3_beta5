<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$sql = "SELECT MIN(day_created) as first_attempt,MAX(day_created) as last_attempt, count(ip) AS total_attempt, ip FROM blacklist GROUP BY ip ORDER BY day_created DESC";
$result = $dw3_conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='tblDATA'><tr><th>Première et dernière tentative erronée</th><th>Adresse IP</th><th>Nb de tentatives erronés</th><th></th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td width='*'>".$row["first_attempt"]." - ".$row["last_attempt"]."</td>
        <td>".$row["ip"]."</td>
        <td>".$row["total_attempt"]."</td>
        <td width='50'><button onclick=\"delBL_IP('".$row["ip"]."');\"><span class='material-icons'>delete</span></button></td>
        </tr>";
    }
    echo "</table>";
}

$dw3_conn->close();
?>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$GENR = $_GET['GENR'];
$HTML = "<table class='tblSEL'>";
$sql = "SELECT * FROM config WHERE kind = '" . $GENR . "' and code <> '' ORDER BY code";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $HTML .= "<tr onclick='selectCODE(\"". $row["code"] . "\")'><td>(<b>" .$row["code"] . "</b>)<pre><code>" . str_replace(">","&gt;",(str_replace("<","&lt;",substr($row["text1"],0,60)))) . " " . str_replace(">","&gt;",(str_replace("<","&lt;",substr($row["text2"],0,30)))) . "</code></pre></td></tr>";
            }
        }
die($HTML . "</table>");
$dw3_conn->close();
?>
        
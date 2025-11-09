<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$GENR = $_GET['GENR'];
$CODE = $_GET['CODE'];

$sql = "SELECT *
        FROM config
        WHERE kind = '" . $GENR . "' AND code = '" . $CODE . "'
        ";

        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {	
            while($row = $result->fetch_assoc()) {
                echo '{"GENR": "'. $row["kind"] .'", "CODE": "'. $row["code"] .'", "DSC1": "'. $row["text1"] .'", "DSC2": "'. $row["text2"] .'", "DSC3": "'. $row["text3"] .'", "DSC4": "'. $row["text4"] .'"}';
                //echo "<tr onclick='selectCODE(\"". $row["cfCODE"] . "\")'><td>(" .$row["cfCODE"] . ") " . $row["cfDSC1"] . "</td></tr>";
            }
        }

$dw3_conn->close();
?>
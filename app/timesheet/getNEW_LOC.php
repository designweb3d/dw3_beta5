<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

//GET USER INFO
$currentUSER = $_GET['currentUSER'];
$sql2 = "SELECT location_id FROM user 
WHERE id = '" . $currentUSER . "';";
$result2 = mysqli_query($dw3_conn, $sql2);
$data2 = mysqli_fetch_assoc($result2);
$currentUSER_LOC = $data2['location_id'];

//GET USER DEFAULT LOCATION
echo "Emplacement:  <select id='newLOC'><option value='-1'>Télétravail</option>";
    $sql = "SELECT * FROM location ORDER BY name";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
        while($row = $result->fetch_assoc()) {
            if ($row["id"] == $currentUSER_LOC){
                echo "<option value='" . $row["id"]  . "' selected>" . $row["name"]  . " *</option>";
            } else {
                echo "<option value='" . $row["id"]  . "'>" . $row["name"]  . "</option>";
            }
        }
    }                
echo "</select><small>* Emplacement par défaut pour cet utilisateur</small>";
$dw3_conn->close();
?>
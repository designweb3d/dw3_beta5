<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$HEAD  = $_GET['HEAD'];
$ID  = $_GET['ID'];

      $sql2 = "SELECT * FROM prototype_line WHERE head_id = '" . $HEAD . "' AND id <> '".$ID."';";
      $result2 = $dw3_conn->query($sql2);
        if ($result2->num_rows > 0) {
            echo "<table class='tblSEL'>";
            while($row2 = $result2->fetch_assoc()) {
                echo "<tr onclick='setMULT_LINE(".$row2["id"].")'><td>".$row2["name_fr"]."</td></tr>";
            }
            echo "</table><br><button onclick='closeMSG();'><span class='material-icons' style='vertical-align:middle;'>cancel</span> Annuler</button>";
        } else {
            echo "Aucune autre question trouvée.";
        }

$dw3_conn->close();
echo $inserted_id;
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$ID   = $_GET['ID'];

    $sql = "SELECT * FROM index_head WHERE id = '" . $ID . "';";
    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {		
        while($row = $result->fetch_assoc()) {
            $sql1 = "DELETE FROM index_head WHERE parent_id = '" . $row['id'] . "';" ;
            $dw3_conn->query($sql1);
            $sql2 = "DELETE FROM index_line WHERE head_id = '" . $row['id'] . "';" ;
            $dw3_conn->query($sql2);
            $sql3 = "DELETE FROM slideshow WHERE index_id = '" . $row['id'] . "';" ;
            $dw3_conn->query($sql3);
        }
    }

    $sql1 = "DELETE FROM index_head WHERE id = '" . $ID . "' OR parent_id = '" . $ID . "';" ;
    $dw3_conn->query($sql1);
    $sql2 = "DELETE FROM index_line WHERE head_id = '" . $ID . "';" ;
    $dw3_conn->query($sql2);
    $sql3 = "DELETE FROM slideshow WHERE index_id = '" . $ID . "';" ;
    $dw3_conn->query($sql3);


$dw3_conn->close();
echo "Suppression terminée.";
?>
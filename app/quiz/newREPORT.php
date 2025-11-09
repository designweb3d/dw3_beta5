<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];

/* $sql = "SELECT * FROM prototype_head WHERE id = '" . $ID . "' ";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result); */

	$sql = "INSERT INTO prototype_report
    (head_id,user_created,date_submited)
    VALUES 
        ('" . $ID  . "',
         '" . $USER  . "',
         '" . $datetime  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
	  $inserted_id = $dw3_conn->insert_id;

      $sql2 = "SELECT * FROM prototype_line WHERE head_id = '" . $ID . "';";
      $result2 = $dw3_conn->query($sql2);
        if ($result2->num_rows > 0) {	
            while($row2 = $result2->fetch_assoc()) {
                if ($row2['response_type']!="NONE"){
                    $sql3 = "INSERT INTO `prototype_data` (`head_id`,`report_id`, `line_id`) 
                    VALUES ('.$ID.','".$inserted_id."','".$row2['id']."');";
                    $result3 = mysqli_query($dw3_conn, $sql3);
                }
            }
        }
	} else {
	  //echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
echo $inserted_id;
?>
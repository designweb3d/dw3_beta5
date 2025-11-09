<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$DB  = $_GET['DB'];
$UID  = $_GET['UID'];

$reports_count = 0;

$sql4 = "SELECT * FROM prototype_head WHERE auto_add = '1' AND parent_table = '".$DB."' ;";
$result4 = $dw3_conn->query($sql4);
  if ($result4->num_rows > 0) {	
      while($row4 = $result4->fetch_assoc()) {
        $reports_count++;
        $sql = "INSERT INTO prototype_report
        (head_id,parent_id,user_created,date_submited)
        VALUES 
            ('" . $row4['id']  . "',
             '" . $UID  . "',
             '" . $USER  . "',
             '" . $datetime  . "')";
        if ($dw3_conn->query($sql) === TRUE) {
          $inserted_id = $dw3_conn->insert_id;
          $sql2 = "SELECT * FROM prototype_line WHERE head_id = '" . $row4['id'] . "';";
          $result2 = $dw3_conn->query($sql2);
            if ($result2->num_rows > 0) {	
                while($row2 = $result2->fetch_assoc()) {
                    if ($row2['response_type']!="NONE"){
                        $sql3 = "INSERT INTO `prototype_data` (`head_id`,`report_id`, `line_id`) VALUES ('".$row4['id']."','".$inserted_id."','".$row2['id']."');";
                        $result3 = mysqli_query($dw3_conn, $sql3);
                    }
                }
            }
        } else {
          //echo "Erreur: " . $dw3_conn->error;
        }

      }
  }

$dw3_conn->close();
echo $reports_count;
?>
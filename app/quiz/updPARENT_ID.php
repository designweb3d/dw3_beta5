<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$RID   = $_GET['RID'];
$UID  = $_GET['UID'];
$DB  = $_GET['DB'];

if ($DB == "customer"){
/*     $sql = "SELECT lang FROM customer WHERE id = '" . $UID . "';";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $report_lang = $data["lang"]; */
} else if ($DB == "user"){
/*     $sql = "SELECT lang FROM user WHERE id = '" . $UID . "';";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $report_lang = $data["lang"]; */
}

//move files from /fs/bd/upload to user/customer folder
    $sql = "SELECT A.*, B.* FROM prototype_data A 
    LEFT JOIN prototype_line B ON A.line_id = B.id
    WHERE report_id = '" . $RID . "';";
	$result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {	
		while($row = $result->fetch_assoc()) {
            if ($row["response_type"] == "FILE"){
                if (file_exists($_SERVER['DOCUMENT_ROOT']."/fs/".$DB."/upload/".$row["value1"])){
                    rename($_SERVER['DOCUMENT_ROOT']."/fs/".$DB."/upload/".$row["value1"], $_SERVER['DOCUMENT_ROOT']."/fs/".$DB."/".$UID."/".$row["value1"]);
                    error_log($_SERVER['DOCUMENT_ROOT']."/fs/".$DB."/upload/".$row["value1"]);
                } else {
                    error_log("err: ".$_SERVER['DOCUMENT_ROOT']."/fs/".$DB."/upload/".$row["value1"]);
                }
            }
        }
    }

$sql = "UPDATE prototype_report SET    
	 parent_id   = '" . $UID   . "'
	 WHERE id = '" . $RID . "' 
	 LIMIT 1";
/* $sql = "UPDATE prototype_report SET    
	 parent_id   = '" . $UID   . "',
	 lang   = '" . $report_lang   . "'
	 WHERE id = '" . $RID . "' 
	 LIMIT 1"; */
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
exit();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];

//get next position
$sql = "SELECT MAX(position)+1 as nextPos FROM prototype_line WHERE head_id = " . $ID;
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);

//insert
	$sql = "INSERT INTO `prototype_line` (`id`, `head_id`, `response_type`,`position`, `name_fr`, `description_fr`, `choice_name1`, `choice_value1`, `choice_name2`, `choice_value2`, `choice_name3`, `choice_value3`, `choice_name4`, `choice_value4`, `choice_name5`, `choice_value5`, `choice_name6`, `choice_value6`, `choice_name7`, `choice_value7`, `choice_name8`, `choice_value8`, `choice_name9`, `choice_value9`, `choice_name0`, `choice_value0`) 
	VALUES (NULL, '".$ID."', 'TEXT','".$data['nextPos'] ."', '', '', '', '0.00', '', '0.00', '', '0.00', '', '0.00', '', '0.00', '', '0.00', '', '0.00', '', '0.00', '', '0.00', '', '0.00');";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo $dw3_conn->insert_id;
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
?>
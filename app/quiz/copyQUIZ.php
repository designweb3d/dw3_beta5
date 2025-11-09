<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID  = $_GET['ID'];

	$sql = "INSERT INTO prototype_head
    (name_fr,description_fr,total_type,parent_table,total_max)
    SELECT '" . $datetime  . "',description_fr,total_type,parent_table,total_max
    FROM prototype_head WHERE id = '".$ID."' ";
	if ($dw3_conn->query($sql) === TRUE) {
	  $inserted_id =  $dw3_conn->insert_id;
        //insert lines
        $sql = "INSERT INTO `prototype_line` (`head_id`, `response_type`,`position`, `name_fr`, `description_fr`, `choice_name1`, `choice_value1`, `choice_name2`, `choice_value2`, `choice_name3`, `choice_value3`, `choice_name4`, `choice_value4`, `choice_name5`, `choice_value5`, `choice_name6`, `choice_value6`, `choice_name7`, `choice_value7`, `choice_name8`, `choice_value8`, `choice_name9`, `choice_value9`, `choice_name0`, `choice_value0`) 
        SELECT  $inserted_id, `response_type`,`position`, `name_fr`, `description_fr`, `choice_name1`, `choice_value1`, `choice_name2`, `choice_value2`, `choice_name3`, `choice_value3`, `choice_name4`, `choice_value4`, `choice_name5`, `choice_value5`, `choice_name6`, `choice_value6`, `choice_name7`, `choice_value7`, `choice_name8`, `choice_value8`, `choice_name9`, `choice_value9`, `choice_name0`, `choice_value0`
        FROM `prototype_line` WHERE head_id = '".$ID."';";
        if ($dw3_conn->query($sql) === TRUE) {
            echo $inserted_id;
        }
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}
$dw3_conn->close();
exit();
?>
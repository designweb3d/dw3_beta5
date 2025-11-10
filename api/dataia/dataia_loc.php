<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
//die ('[{"result":"err","data":"Internal server error."}]');

    $TYPE = $_GET['t'];
    $OUTPUT = $_GET['o'];
    $FIND = $_GET['f'];
    $PARENT = $_GET['p'];

    //DATAIA -canada id:47
    $mysqli7 = mysqli_connect("","","","");
    $mysqli7->set_charset("utf8");
    //$charset = $mysqli7 -> character_set_name(); //echo "Default character set is: " . $charset;

    //$client_conn = mysqli_get_connection_stats($mysqli);
    if (mysqli_connect_errno()) {
        mysqli_close($mysqli7);
        die ('[{"result":"err","data":"Internal server error."}]');
        exit();
    }

    $sql7 = "SELECT * FROM LOC WHERE locID <> 0 ";
    if ($FIND != "" && $FIND != "0"){
        $sql7 .= " AND CONCAT(locTYPE,locNAME,locDESC) LIKE '%". $FIND ."%' ";
    }
    if ($TYPE != ""){
        $sql7 .= " AND locTYPE = '". $TYPE ."' ";
    }
    if ($PARENT != ""){
        $sql7 .= " AND locPARENT = '". $PARENT ."' ";
    }
    $sql7 .= " ORDER BY locNAME";

    if ($result7 = $mysqli7 -> query($sql7)) {
        $field_count7 = mysqli_affected_rows($mysqli7);
        $tmp = array();
        $tmp['result'][] = "ok";
        $tmp['row_count'][] = $field_count7;
        while ($row7 = $result7 -> fetch_row()) {
            $tmp['data'][] = $row7;
        }
        mysqli_close($mysqli7);
        die(json_encode($tmp)); 
    } else {
        //echo '[{"result":"err","data":"' . $mysqli -> error_list  . '"}]';
        //echo '[{"result":"err","data":"' . $sql7 . '"}]';
        mysqli_close($mysqli7);
        die ('[{"result":"err","data":"' . $LBL_ERR . '"}]');
    }
 
    //$sql7 = "INSERT INTO LOG (logIp,logDT,logKEY,logSQL) VALUES ('" . $RIP . "','" .  $datetime . "','" . $KEY . "','" . urlencode($sql7) . "')";
    //$result7 = $mysqli7->query($sql7);

    mysqli_close($mysqli7);
die('[{"result":"err","data":"' . $LBL_ERR . '"}]');
?>

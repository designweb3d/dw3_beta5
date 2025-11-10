<?php

    $QT = $_GET['QT'];if($QT==""){$QT=1;}
    $LNG = $_GET['LAT'];
    $LAT = $_GET['LNG'];

    //DATAIA -canada id:47
    $mysqli7 = mysqli_connect("localhost","uaqkv257_kufu","2IprgfQr@p8L","uaqkv257_UNIVERS");
    $mysqli7->set_charset("utf8");
    //$charset = $mysqli7 -> character_set_name(); //echo "Default character set is: " . $charset;
    $client_info = mysqli_get_client_info();
    $client_stats = mysqli_get_client_stats();
    $client_version = mysqli_get_client_version();

    if (mysqli_connect_errno()) {
        mysqli_close($mysqli7);
        die ('[{"result":"err","data":"Internal server error."}]');
        exit();
    }

    $sql7 = " SELECT *,(ABS(zipLNG-". $LNG . "))+(ABS(zipLAT-". $LAT . ")) as zipDIST FROM ZIP WHERE zipSTATE = 'QC' 
    AND (ABS(zipLNG-". $LNG . "))+(ABS(zipLAT-". $LAT . ")) < 0.005
    ORDER BY zipDIST ASC
    LIMIT " . $QT;

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
        die ('[{"result":"err","data":"' . htmlspecialchars($sql7, ENT_QUOTES) . '"}]');
    }
 
    //$sql7 = "INSERT INTO LOG (logIp,logDT,logKEY,logSQL) VALUES ('" . $RIP . "','" .  $datetime . "','" . $KEY . "','" . urlencode($sql7) . "')";
    //$result7 = $mysqli7->query($sql7);

    mysqli_close($mysqli7);
die('[{"result":"err","data":"' . $sql7 . '"}]');
?>
<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/dw3_func.php';
date_default_timezone_set('America/New_York');
setlocale(LC_ALL, 'fr_CA');
$ID = $_GET['ID'];
$report_id = $_GET['RID']??"0";
$captcha = $_GET['CPTCH']??"";

if ($report_id == ""){$report_id = "0";}

$EML = trim(mysqli_real_escape_string($dw3_conn, $_GET['EML']));
$LINES = "";
$lastLineID ="";
$val1 = "";
$val2 = "";
$val3 = "";
$val4 = "";
$val5 = "";
$val6 = "";
$val7 = "";
$val8 = "";
$val9 = "";
$val0 = "";
$xLoop=0;
$parent_id="-1";
$new_report_id = "";
    //get prototype header
    $sql = "SELECT * FROM prototype_head WHERE id = '" . $ID . "' LIMIT 1";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $head_parent_table = $data['parent_table']??'';
    $head_name = $data['name_fr']??'';
    $next_id = $data['next_id']??'';
    $allow_user_reedit = $data['allow_user_reedit']??'0';

    if ($next_id == "0"){$next_id = "";}
    if ($data['captcha_required'] == "1"){
        if(!isset($_SESSION['captcha_text']) || $captcha != $_SESSION['captcha_text']) {
            $dw3_conn->close();
            die ('{"error":"Captcha invalide. Veuillez réessayer..", "next_id":"", "report_id":""}');
        }
    }

    if ($head_parent_table == "customer"){
        $sql = "SELECT id FROM customer WHERE eml1 = '" . dw3_crypt(trim(strtolower($EML))) . "' AND eml1 <> '' LIMIT 1";
        $result = mysqli_query($dw3_conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $parent_id = $data['id']??'';
        $report_eml = dw3_crypt($EML);
    } else if ($head_parent_table == "user"){
        $sql = "SELECT id FROM user WHERE TRIM(LCASE(eml1)) = '" . trim(strtolower($EML)) . "' AND eml1 <> '' LIMIT 1";
        $result = mysqli_query($dw3_conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $parent_id = $data['id']??'';
        $report_eml = $EML;
    }

if ($report_id == "0"){
        //double protection bloquer edit et creer un nouveau report
        if ($allow_user_reedit!="1" && $report_id != "0"){
            echo '{"error":"", "next_id":"' . $next_id . '", "report_id":"' . $report_id . '"} ';
            $dw3_conn->close();
            exit();
        }
    //insert report header
    $sql = "INSERT INTO prototype_report (head_id,parent_id,report_eml,lang,date_completed) 
            VALUES ('" . $ID  . "','" . $parent_id  . "','" . $report_eml  . "','".$USER_LANG."','" . $datetime  . "')";
            //die($sql);
    if ($dw3_conn->query($sql) === TRUE) {
        $new_report_id = $dw3_conn->insert_id;
    } else {
        echo "Erreur: " . $sql;
    }
} else {
     //update report header
     $sql = "UPDATE prototype_report SET date_completed =  '" . $datetime  . "' WHERE id = '".$report_id."';";
    if ($dw3_conn->query($sql) === TRUE) {
    //continue
    } else {
    echo "Erreur: " . $sql;
    }   
        //double protection bloquer edit et creer un nouveau report
        if ($allow_user_reedit!="1" && $report_id != ""){
            echo '{"error":"", "next_id":"' . $next_id . '", "report_id":"' . $report_id . '"} ';
            $dw3_conn->close();
            exit();
        }
}
    //compile or update data 
    foreach ($_GET as $key => $value) {
        if ($key != "ID" && $key != "EML" && $key != "CPTCH" && $key != "RID"){
            $lineID = substr($key,2);
            $lineValID = substr($key,0,1);
            if ($lastLineID != $lineID && $xLoop !=0){
                if (is_numeric($lastLineID)){
                    if ($report_id == "0"){
                        $LINES .= "('".$ID."','".$new_report_id."', '".$lastLineID."','".$val1 ."', '".$val2 ."', '".$val3 ."', '".$val4 ."', '".$val5 ."', '".$val6 ."', '".$val7 ."', '".$val8 ."', '".$val9 ."', '".$val0 ."')\n,";
                    } else {
                        $sql = "UPDATE prototype_data SET value1='".$val1."',value2='".$val2."', value3='".$val3."', value4='".$val4."', value5='".$val5."', value6='".$val6."', value7='".$val7."', value8='".$val8."', value9='".$val9."', value0='".$val0."'
                        WHERE line_id = '" . $lastLineID . "' AND report_id='".$report_id."' LIMIT 1";
                        $result = mysqli_query($dw3_conn, $sql);                 
                    }
                }
                $val1 = "";
                $val2 = "";
                $val3 = "";
                $val4 = "";
                $val5 = "";
                $val6 = "";
                $val7 = "";
                $val8 = "";
                $val9 = "";
                $val0 = "";
            }     
            if($lineValID == "1"){$val1 = $value;}
            if($lineValID == "2"){$val2 = $value;}
            if($lineValID == "3"){$val3 = $value;}
            if($lineValID == "4"){$val4 = $value;}
            if($lineValID == "5"){$val5 = $value;}
            if($lineValID == "6"){$val6 = $value;}
            if($lineValID == "7"){$val7 = $value;}
            if($lineValID == "8"){$val8 = $value;}
            if($lineValID == "9"){$val9 = $value;}
            if($lineValID == "0"){$val0 = $value;}
            $lastLineID = $lineID;
            $xLoop++;
        }
    }
    if ($report_id == "0"){
        //insert data lines
        $sql2 = "INSERT INTO `prototype_data` (`head_id`,`report_id`, `line_id`,`value1`, `value2`, `value3`, `value4`, `value5`, `value6`, `value7`, `value8`, `value9`, `value0`) 
        VALUES ".substr($LINES, 0, -1).";";
        if ($dw3_conn->query($sql2) === TRUE) {
        //echo $dw3_conn->insert_id;
        //echo "test firefox noerr vs chrome: " . $sql2;
        } else {
            error_log($sql);
        //echo "test firefox error vs chrome: " . $sql2;
        }
    }

if ($new_report_id != "") {$report_id = $new_report_id;}
//if ($next_id != "" && $next_id != "0"){
    //echo "next_id=".$next_id;
    echo '{"error":"' . $dw3_conn->error . '", "next_id":"' . $next_id . '", "report_id":"' . $report_id . '"} ';
//}    
$dw3_conn->close();
?>
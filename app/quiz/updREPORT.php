<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$RID  = $_GET['RID'];
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

foreach ($_GET as $key => $value) {
    if ($key != "ID" && $key != "EML"){
        $lineID = substr($key,2);
        $lineValID = substr($key,0,1);
        if ($lastLineID != $lineID && $xLoop !=0){
            if (is_numeric($lastLineID)){
                $sql = "UPDATE prototype_data SET value1='".$val1."',value2='".$val2."', value3='".$val3."', value4='".$val4."', value5='".$val5."', value6='".$val6."', value7='".$val7."', value8='".$val8."', value9='".$val9."', value0='".$val0."'
                WHERE line_id = '" . $lastLineID . "' AND report_id='".$RID."' LIMIT 1";
                $result = mysqli_query($dw3_conn, $sql);                 
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

$sql = "UPDATE prototype_report SET date_completed='".$datetime."' WHERE id = '" . $RID . "' LIMIT 1";
$result = mysqli_query($dw3_conn, $sql);

$dw3_conn->close();
?>
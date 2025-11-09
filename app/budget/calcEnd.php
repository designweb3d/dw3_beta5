<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$freq   = $_GET['FREQ'];
$amount = $_GET['AMOUNT'];
$next_date  = $_GET['START'];
$to_pay  = $_GET['TO_PAY'];
$paid = 0;
if ($amount <= 0 || $to_pay <= 0 || $next_date == "" || $freq == "" || $freq == "ONETIME") {
    echo $next_date;
    $dw3_conn->close();
    exit;
}
do {
    if($freq == "WEEKLY"){
        $next_date = date('Y-m-d', strtotime($next_date . ' +7 day'));
    }
    if($freq == "BI-WEEKLY"){
        $next_date = date('Y-m-d', strtotime($next_date . ' +14 day'));
    }
    if($freq == "MONTHLY"){
        $next_date = date('Y-m-d', strtotime($next_date . ' +1 month'));
    }
    if($freq == "MONTHLY2"){
        $next_date = date('Y-m-d', strtotime($next_date . ' +2 month'));
    }
    if($freq == "MONTHLY3"){
        $next_date = date('Y-m-d', strtotime($next_date . ' +3 month'));
    }
    if($freq == "MONTHLY4"){
        $next_date = date('Y-m-d', strtotime($next_date . ' +4 month'));
    }
    if($freq == "MONTHLY6"){
        $next_date = date('Y-m-d', strtotime($next_date . ' +6 month'));
    }
    if($freq == "YEARLY"){
        $next_date = date('Y-m-d', strtotime($next_date . ' +1 year'));
    }
    if($freq == "DAILY"){
        $next_date = date('Y-m-d', strtotime($next_date . ' +1 day'));
    }  
    $paid = $paid + $amount;
} while ($paid < $to_pay);
echo $next_date;
$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$carrerID   = $_GET['ID'];
$v1 = str_replace("'","’",$_GET['v1']);                     //sSALARY_MIN    
$v2 = str_replace("'","’",$_GET['v2']);                     //sRESP
$v3 = str_replace("'","’",$_GET['v3']);                     //sHABI
$v4 = str_replace("'","’",$_GET['v4']);                     //sQUAL
$v5 = str_replace("'","’",$_GET['v5']);                     //sEDUC
$v6 = str_replace("'","’",$_GET['v6']);                     //sEXPE
$v7  = $_GET['v7'];                                         //sACTIVE
$v8  = $_GET['v8'];                                         //sSALARY_TYPE
$v9  = $_GET['v9'];                                         //sTELECOMMUTE
$v10 = $_GET['v10'];if ($v10=="false"){$v10=0;}else{$v10=1;}//sFULL_TIME
$v11 = $_GET['v11'];if ($v11=="false"){$v11=0;}else{$v11=1;}//sPART_TIME
$v12 = $_GET['v12'];if ($v12=="false"){$v12=0;}else{$v12=1;}//sCONTRACTOR
$v13 = $_GET['v13'];if ($v13=="false"){$v13=0;}else{$v13=1;}//sTEMPORARY
$v14 = $_GET['v14'];if ($v14=="false"){$v14=0;}else{$v14=1;}//sINTERN
$v15 = $_GET['v15'];if ($v15=="false"){$v15=0;}else{$v15=1;}//sVOLUNTEER
$v16 = $_GET['v16'];if ($v16=="false"){$v16=0;}else{$v16=1;}//sPER_DIEM
$v17 = $_GET['v17'];if ($v17=="false"){$v17=0;}else{$v17=1;}//sOTHER
$v18  = $_GET['v18'];                                        //sEND_DATE
$v19  = $_GET['v19'];                                        //sDOC
 
$sql = "UPDATE position SET    
salary_min = '" . $v1 . "',
responsibilities = '" . $v2 . "',
skills = '" . $v3 . "',
qualifications = '" . $v4 . "',
education = '" . $v5 . "',
experience = '" . $v6 . "',
active = '" . $v7 . "',
salary_type = '" . $v8 . "',
telecommute = '" . $v9 . "',
full_time = '" . $v10 . "',
part_time = '" . $v11 . "',
contractor = '" . $v12 . "',
temporary = '" . $v13 . "',
intern = '" . $v14 . "',
volunteer = '" . $v15 . "',
per_diem = '" . $v16 . "',
other = '" . $v17. "',
date_end_post = '" . $v18. "',
document_id = '" . $v19. "'
WHERE id = '" . $carrerID . "' LIMIT 1;";
	if ($dw3_conn->query($sql) === TRUE) {
        header('Status: 200');
	    echo ""; 
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
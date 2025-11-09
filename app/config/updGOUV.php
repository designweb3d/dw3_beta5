<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';

$TPS    = $_GET['TPS'];
$TVQ    = $_GET['TVQ'];
$NEQ    = $_GET['NEQ'];
$NE     = $_GET['NE'];
$RBQ    = $_GET['RBQ'];
$TPS_YT = $_GET['TPS_YT'];
$TVP_YT = $_GET['TVP_YT'];
$TVH_YT = $_GET['TVH_YT'];
$TPS_QC = $_GET['TPS_QC'];
$TVP_QC = $_GET['TVP_QC'];
$TVH_QC = $_GET['TVH_QC'];
$TPS_SK = $_GET['TPS_SK'];
$TVP_SK = $_GET['TVP_SK'];
$TVH_SK = $_GET['TVH_SK'];
$TPS_PE = $_GET['TPS_PE'];
$TVP_PE = $_GET['TVP_PE'];
$TVH_PE = $_GET['TVH_PE'];
$TPS_ON = $_GET['TPS_ON'];
$TVP_ON = $_GET['TVP_ON'];
$TVH_ON = $_GET['TVH_ON'];
$TPS_MB = $_GET['TPS_MB'];
$TVP_MB = $_GET['TVP_MB'];
$TVH_MB = $_GET['TVH_MB'];
$TPS_NU = $_GET['TPS_NU'];
$TVP_NU = $_GET['TVP_NU'];
$TVH_NU = $_GET['TVH_NU'];
$TPS_NL = $_GET['TPS_NL'];
$TVP_NL = $_GET['TVP_NL'];
$TVH_NL = $_GET['TVH_NL'];
$TPS_NS = $_GET['TPS_NS'];
$TVP_NS = $_GET['TVP_NS'];
$TVH_NS = $_GET['TVH_NS'];
$TPS_NT = $_GET['TPS_NT'];
$TVP_NT = $_GET['TVP_NT'];
$TVH_NT = $_GET['TVH_NT'];
$TPS_NB = $_GET['TPS_NB'];
$TVP_NB = $_GET['TVP_NB'];
$TVH_NB = $_GET['TVH_NB'];
$TPS_BC = $_GET['TPS_BC'];
$TVP_BC = $_GET['TVP_BC'];
$TVH_BC = $_GET['TVH_BC'];
$TPS_AB = $_GET['TPS_AB'];
$TVP_AB = $_GET['TVP_AB'];
$TVH_AB = $_GET['TVH_AB'];

	$sql = "INSERT INTO config
    (kind, code,text1,text2,text3,text4)
    VALUES 
        ('CIE', 'TPS', '" . $TPS . "','','',''),
        ('CIE', 'TVQ', '" . $TVQ . "','','',''),
        ('CIE', 'NEQ', '" . $NEQ . "','','',''),
        ('CIE', 'NE', '" . $NE . "','','',''),
        ('CIE', 'RBQ', '" . $RBQ . "','','',''),
        ('CIE', 'TX_YT','" . $TPS_YT . "','" . $TVP_YT . "','" . $TVH_YT . "',''),
        ('CIE', 'TX_QC','" . $TPS_QC . "','" . $TVP_QC . "','" . $TVH_QC . "',''),
        ('CIE', 'TX_SK','" . $TPS_SK . "','" . $TVP_SK . "','" . $TVH_SK . "',''),
        ('CIE', 'TX_PE','" . $TPS_PE . "','" . $TVP_PE . "','" . $TVH_PE . "',''),
        ('CIE', 'TX_ON','" . $TPS_ON . "','" . $TVP_ON . "','" . $TVH_ON . "',''),
        ('CIE', 'TX_MB','" . $TPS_MB . "','" . $TVP_MB . "','" . $TVH_MB . "',''),
        ('CIE', 'TX_NU','" . $TPS_NU . "','" . $TVP_NU . "','" . $TVH_NU . "',''),
        ('CIE', 'TX_NL','" . $TPS_NL . "','" . $TVP_NL . "','" . $TVH_NL . "',''),
        ('CIE', 'TX_NS','" . $TPS_NS . "','" . $TVP_NS . "','" . $TVH_NS . "',''),
        ('CIE', 'TX_NT','" . $TPS_NT . "','" . $TVP_NT . "','" . $TVH_NT . "',''),
        ('CIE', 'TX_NB','" . $TPS_NB . "','" . $TVP_NB . "','" . $TVH_NB . "',''),
        ('CIE', 'TX_BC','" . $TPS_BC . "','" . $TVP_BC . "','" . $TVH_BC . "',''),
        ('CIE', 'TX_AB','" . $TPS_AB . "','" . $TVP_AB . "','" . $TVH_AB . "','')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2),text3 = VALUES(text3),text4 = VALUES(text4);";
	if ($dw3_conn->query($sql) === TRUE) {
        header('Status: 200');
	    echo "Les informations gouvernementales ont étés mises &#224; jour.";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
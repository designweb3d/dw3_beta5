<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$NOM	= str_replace("'","’",$_GET['NOM']);
$DOUV	= mysqli_real_escape_string($dw3_conn,$_GET['DOUV']);
$NOMH	= mysqli_real_escape_string($dw3_conn,$_GET['NOMH']);
$EML1  = mysqli_real_escape_string($dw3_conn,$_GET['EML1']);
$EML2  = mysqli_real_escape_string($dw3_conn,$_GET['EML2']);
$EML3  = mysqli_real_escape_string($dw3_conn,$_GET['EML3']);
$EML4  = mysqli_real_escape_string($dw3_conn,$_GET['EML4']);
$SLOGAN_FR  = mysqli_real_escape_string($dw3_conn,$_GET['S_FR']);
$SLOGAN_EN  = mysqli_real_escape_string($dw3_conn,$_GET['S_EN']);
$TEL1  = mysqli_real_escape_string($dw3_conn,$_GET['TEL1']);
$TEL2  = mysqli_real_escape_string($dw3_conn,$_GET['TEL2']);
$HOME   = mysqli_real_escape_string($dw3_conn,$_GET['HOME']);
$PUB   = mysqli_real_escape_string($dw3_conn,$_GET['PUB']);
$PUB2   = mysqli_real_escape_string($dw3_conn,$_GET['PUB2']);
$J0_FR   = mysqli_real_escape_string($dw3_conn,$_GET['J0_FR']);
$J1_FR   = mysqli_real_escape_string($dw3_conn,$_GET['J1_FR']);
$J2_FR   = mysqli_real_escape_string($dw3_conn,$_GET['J2_FR']);
$J3_FR   = mysqli_real_escape_string($dw3_conn,$_GET['J3_FR']);
$J4_FR   = mysqli_real_escape_string($dw3_conn,$_GET['J4_FR']);
$J5_FR   = mysqli_real_escape_string($dw3_conn,$_GET['J5_FR']);
$J6_FR   = mysqli_real_escape_string($dw3_conn,$_GET['J6_FR']);
$J0_EN   = mysqli_real_escape_string($dw3_conn,$_GET['J0_EN']);
$J1_EN   = mysqli_real_escape_string($dw3_conn,$_GET['J1_EN']);
$J2_EN   = mysqli_real_escape_string($dw3_conn,$_GET['J2_EN']);
$J3_EN   = mysqli_real_escape_string($dw3_conn,$_GET['J3_EN']);
$J4_EN   = mysqli_real_escape_string($dw3_conn,$_GET['J4_EN']);
$J5_EN   = mysqli_real_escape_string($dw3_conn,$_GET['J5_EN']);
$J6_EN   = mysqli_real_escape_string($dw3_conn,$_GET['J6_EN']);
$J1_H1   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J1_H1'],5,"0",STR_PAD_LEFT));
$J1_H2   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J1_H2'],5,"0",STR_PAD_LEFT));
$J1_H3   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J1_H3'],5,"0",STR_PAD_LEFT));
$J1_H4   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J1_H4'],5,"0",STR_PAD_LEFT));
$J2_H1   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J2_H1'],5,"0",STR_PAD_LEFT));
$J2_H2   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J2_H2'],5,"0",STR_PAD_LEFT));
$J2_H3   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J2_H3'],5,"0",STR_PAD_LEFT));
$J2_H4   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J2_H4'],5,"0",STR_PAD_LEFT));
$J3_H1   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J3_H1'],5,"0",STR_PAD_LEFT));
$J3_H2   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J3_H2'],5,"0",STR_PAD_LEFT));
$J3_H3   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J3_H3'],5,"0",STR_PAD_LEFT));
$J3_H4   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J3_H4'],5,"0",STR_PAD_LEFT));
$J4_H1   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J4_H1'],5,"0",STR_PAD_LEFT));
$J4_H2   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J4_H2'],5,"0",STR_PAD_LEFT));
$J4_H3   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J4_H3'],5,"0",STR_PAD_LEFT));
$J4_H4   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J4_H4'],5,"0",STR_PAD_LEFT));
$J5_H1   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J5_H1'],5,"0",STR_PAD_LEFT));
$J5_H2   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J5_H2'],5,"0",STR_PAD_LEFT));
$J5_H3   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J5_H3'],5,"0",STR_PAD_LEFT));
$J5_H4   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J5_H4'],5,"0",STR_PAD_LEFT));
$J6_H1   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J6_H1'],5,"0",STR_PAD_LEFT));
$J6_H2   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J6_H2'],5,"0",STR_PAD_LEFT));
$J6_H3   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J6_H3'],5,"0",STR_PAD_LEFT));
$J6_H4   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J6_H4'],5,"0",STR_PAD_LEFT));
$J0_H1   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J0_H1'],5,"0",STR_PAD_LEFT));
$J0_H2   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J0_H2'],5,"0",STR_PAD_LEFT));
$J0_H3   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J0_H3'],5,"0",STR_PAD_LEFT));
$J0_H4   = mysqli_real_escape_string($dw3_conn,str_pad($_GET['J0_H4'],5,"0",STR_PAD_LEFT));
$INV_NOTE   = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['INVN']));
$LVF1   = mysqli_real_escape_string($dw3_conn,$_GET['LVF1']);
$LVF2   = mysqli_real_escape_string($dw3_conn,$_GET['LVF2']);
$PKF1   = mysqli_real_escape_string($dw3_conn,$_GET['PKF1']);
$PKF2   = mysqli_real_escape_string($dw3_conn,$_GET['PKF2']);
$PKCAL   = mysqli_real_escape_string($dw3_conn,$_GET['PKCAL']);
$DUF1   = mysqli_real_escape_string($dw3_conn,$_GET['DUF1']);
$DUF2   = mysqli_real_escape_string($dw3_conn,$_GET['DUF2']);
$CART_ACT   = mysqli_real_escape_string($dw3_conn,$_GET['CART_ACT']);
$CART_API   = $_GET['CART_API'];
$INTERAC   = $_GET['INTERAC'];
$HIDE_PRICE   = $_GET['HP'];
$TRP   = mysqli_real_escape_string($dw3_conn,$_GET['TRP']);
$TRPP   = mysqli_real_escape_string($dw3_conn,$_GET['TRPP']);
$TRPM   = mysqli_real_escape_string($dw3_conn,$_GET['TRPM']);
$DIST_AD   = mysqli_real_escape_string($dw3_conn,$_GET['DIST_AD']);
$GRAB   = mysqli_real_escape_string($dw3_conn,$_GET['GRAB']);
$GRAB_P   = mysqli_real_escape_string($dw3_conn,$_GET['GRAB_P']);
$GRAB_A   = mysqli_real_escape_string($dw3_conn,$_GET['GRAB_A']);

	$sql = "INSERT INTO config
    (kind, code,text1,text2,text3,text4)
    VALUES 
        ('CIE', 'NOM', '" . $NOM . "','','".$DOUV."','".$INTERAC."'),
        ('CIE', 'NOM_HTML', '" . $NOMH . "','".$SLOGAN_FR."','".$SLOGAN_EN."',''),
        ('CIE', 'TEL1', '" . $TEL1 . "','','',''),
        ('CIE', 'TEL2', '" . $TEL2 . "','','',''),
        ('CIE', 'ADR_PUB', '" . $PUB . "','','',''),
        ('CIE', 'ADR_PUB2', '" . $PUB2 . "','','',''),
        ('CIE', 'TRANSPORT', '" . $TRP . "','','',''),
        ('CIE', 'TRANSPORT_PRICE', '" . $TRPP . "','".$HIDE_PRICE."','',''),
        ('CIE', 'FREE_MIN', '" . $TRPM . "','".$PKCAL."','" . $PKF1 . "','" . $PKF2 . "'),
        ('CIE', 'OPEN_J0', '" . $J0_H1 . "','" . $J0_H2 . "','" . $J0_H3 . "','" . $J0_H4 . "'),
        ('CIE', 'OPEN_J1', '" . $J1_H1 . "','" . $J1_H2 . "','" . $J1_H3 . "','" . $J1_H4 . "'),
        ('CIE', 'OPEN_J2', '" . $J2_H1 . "','" . $J2_H2 . "','" . $J2_H3 . "','" . $J2_H4 . "'),
        ('CIE', 'OPEN_J3', '" . $J3_H1 . "','" . $J3_H2 . "','" . $J3_H3 . "','" . $J3_H4 . "'),
        ('CIE', 'OPEN_J4', '" . $J4_H1 . "','" . $J4_H2 . "','" . $J4_H3 . "','" . $J4_H4 . "'),
        ('CIE', 'OPEN_J5', '" . $J5_H1 . "','" . $J5_H2 . "','" . $J5_H3 . "','" . $J5_H4 . "'),
        ('CIE', 'OPEN_J6', '" . $J6_H1 . "','" . $J6_H2 . "','" . $J6_H3 . "','" . $J6_H4 . "'),
        ('CIE', 'OPEN_JFR1', '" . $J0_FR . "','" . $J1_FR . "','" . $J2_FR . "','" . $J3_FR . "'),
        ('CIE', 'OPEN_JFR2', '" . $J4_FR . "','" . $J5_FR . "','" . $J6_FR . "',''),
        ('CIE', 'OPEN_JEN1', '" . $J0_EN . "','" . $J1_EN . "','" . $J2_EN . "','" . $J3_EN . "'),
        ('CIE', 'OPEN_JEN2', '" . $J4_EN . "','" . $J5_EN . "','" . $J6_EN . "',''),
        ('CIE', 'INVOICE_NOTE', '" . $INV_NOTE . "','','',''),
        ('CIE', 'DTLVDU', '" . $LVF1 . "','" . $LVF2 . "','" . $DUF1 . "','" . $DUF2 . "'),
        ('CIE', 'GRAB', '" . $GRAB . "','" . $GRAB_P . "','" . $GRAB_A . "','".$DIST_AD."'),
        ('CIE', 'HOME', '" . $HOME . "','".$CART_ACT."','".$CART_API."','')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2),text3 = VALUES(text3),text4 = VALUES(text4);";
	if ($dw3_conn->query($sql) === TRUE) {
        //header('Status: 200');
	    //echo "Les informations générales ont étés mises &#224; jour.";
	} else {
	  echo $dw3_conn->error;
	}
    $sql = "INSERT INTO config
    (kind, code,text1)
    VALUES 
        ('CIE', 'EML1', '" . $EML1  . "'),
        ('CIE', 'EML2', '" . $EML2  . "'),
        ('CIE', 'EML3', '" . $EML3  . "'),
        ('CIE', 'EML4', '" . $EML4  . "')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1);";
	if ($dw3_conn->query($sql) === TRUE) {
        //header('Status: 200');
	    echo "Les informations générales ont étés mises &#224; jour.";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
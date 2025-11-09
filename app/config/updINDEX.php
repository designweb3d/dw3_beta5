<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$dw3_conn->set_charset('utf8mb4');
$INDEX_NEWS    = mysqli_real_escape_string($dw3_conn,$_GET['N']);
$INDEX_HEADER    = mysqli_real_escape_string($dw3_conn,$_GET['H']);
$INDEX_FOOTER    = mysqli_real_escape_string($dw3_conn,$_GET['F']);
$INDEX_SCENE    = mysqli_real_escape_string($dw3_conn,$_GET['S']);
$INDEX_CART    = mysqli_real_escape_string($dw3_conn,$_GET['K']);
$INDEX_WISH    = mysqli_real_escape_string($dw3_conn,$_GET['W']);
$INDEX_SEARCH    = mysqli_real_escape_string($dw3_conn,$_GET['SS']);
$CIE_COOKIE    = mysqli_real_escape_string($dw3_conn,$_GET['C']);
$CIE_COOKIE_EN    = mysqli_real_escape_string($dw3_conn,$_GET['CE']);
$CIE_PROTECTOR    = mysqli_real_escape_string($dw3_conn,$_GET['PR']);
$FOOT_MARGIN    = mysqli_real_escape_string($dw3_conn,$_GET['M']);
$INDEX_LANG    = mysqli_real_escape_string($dw3_conn,$_GET['L']);
$INDEX_DSP_SIGNIN    = mysqli_real_escape_string($dw3_conn,$_GET['SI']);
$LOGIN_BTN_CLASS    = mysqli_real_escape_string($dw3_conn,$_GET['BC']);
$INDEX_BLOCK_DEBUG    = mysqli_real_escape_string($dw3_conn,$_GET['BD']);
$INDEX_DSP_LANG    = mysqli_real_escape_string($dw3_conn,$_GET['DL']);
$INDEX_DSP_SUPPLIER    = mysqli_real_escape_string($dw3_conn,$_GET['DS']);
$INDEX_TITLE_FR    = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['TF']));
$INDEX_TITLE_EN    = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['TE']));
$INDEX_TOP_FR    = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['OF']));
$INDEX_TOP_EN    = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['OE']));
$INDEX_POPUP_FR    = mysqli_real_escape_string($dw3_conn,$_GET['PF']);
$INDEX_POPUP_EN    = mysqli_real_escape_string($dw3_conn,$_GET['PE']);
$INDEX_META_DESC    = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['MD']));
$INDEX_META_KEYW    = str_replace("'","’",mysqli_real_escape_string($dw3_conn,$_GET['MK']));
$DASH    = $_GET['DASH'];

	$sql = "INSERT INTO config
    (kind, code,text1,text2)
    VALUES 
        ('INDEX', 'HEADER', '" . $INDEX_HEADER    . "','".$INDEX_BLOCK_DEBUG."'),
        ('INDEX', 'FOOTER', '" . $INDEX_FOOTER    . "','".$INDEX_NEWS."'),
        ('INDEX', 'SCENE', '" . $INDEX_SCENE    . "','".$INDEX_SEARCH."'),
        ('INDEX', 'FOOT_MARGIN', '" . $FOOT_MARGIN    . "','".$INDEX_DSP_SUPPLIER."'),
        ('INDEX', 'CART', '" . $INDEX_CART    . "','" . $INDEX_WISH   . "'),
        ('CIE', 'COOKIE_MSG', '" . $CIE_COOKIE    . "','" . $CIE_COOKIE_EN    . "'),
        ('INDEX', 'INDEX_LANG', '" . $INDEX_LANG    . "','".$LOGIN_BTN_CLASS."'),
        ('INDEX', 'INDEX_DSP_LANG', '" . $INDEX_DSP_LANG    . "','" . $INDEX_DSP_SIGNIN . "'),
        ('INDEX', 'INDEX_TITLE_FR', '" . $INDEX_TITLE_FR    . "',''),
        ('INDEX', 'INDEX_TITLE_EN', '" . $INDEX_TITLE_EN    . "',''),
        ('INDEX', 'INDEX_TOP_FR', '" . $INDEX_TOP_FR    . "','" . $INDEX_POPUP_FR    . "'),
        ('INDEX', 'INDEX_TOP_EN', '" . $INDEX_TOP_EN    . "','" . $INDEX_POPUP_EN    . "'),
        ('INDEX', 'INDEX_META_DESC', '" . $INDEX_META_DESC    . "',''),
        ('INDEX', 'INDEX_META_KEYW', '" . $INDEX_META_KEYW    . "',''),
        ('INDEX', 'DASHBOARD_DSP', '" . $DASH . "',''),
        ('CIE', 'PROTECTOR', '" . $CIE_PROTECTOR    . "','')
        ON DUPLICATE KEY UPDATE text1 = VALUES(text1),text2 = VALUES(text2);";
           
    if ($dw3_conn->query($sql) === TRUE) {
	  //echo "L'index a été mise &#224; jour";
	  echo "";
	} else {
        $dw3_conn->close();
	    die($dw3_conn->error);
	}

$dw3_conn->close();
?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$ID   = $_GET['ID'];
$SCENE   = mysqli_real_escape_string($dw3_conn,$_GET['SCENE']);
$TITLE   = str_replace("'","’",$_GET['TITLE']);
$TITLE_EN   = str_replace("'","’",$_GET['TITLE_EN']);
$META_DESC   = str_replace("'","’",$_GET['METAD']);
$META_KEYW   = str_replace("'","’",$_GET['METAK']);
$HEADER  = mysqli_real_escape_string($dw3_conn,$_GET['HEADER']);
$URL  = mysqli_real_escape_string($dw3_conn,$_GET['URL']);
$FONT  = mysqli_real_escape_string($dw3_conn,$_GET['FONT']);
$ICON   = mysqli_real_escape_string($dw3_conn,$_GET['ICON']);
$MENU  = mysqli_real_escape_string($dw3_conn,$_GET['MENU']);
$ORDER  = mysqli_real_escape_string($dw3_conn,$_GET['ORDER']);
$LIST = mysqli_real_escape_string($dw3_conn,$_GET['LIST']);
$IMG = mysqli_real_escape_string($dw3_conn,$_GET['IMG']);
$IMG_ANIM = mysqli_real_escape_string($dw3_conn,$_GET['IMG_ANIM']);
$IMG_ANIM_TIME = mysqli_real_escape_string($dw3_conn,$_GET['IMG_ANIM_TIME']);
$IMG_DSP = mysqli_real_escape_string($dw3_conn,$_GET['IMG_DSP']);
$ICON_DSP = mysqli_real_escape_string($dw3_conn,$_GET['ICON_DSP']);
$TITLE_DSP = mysqli_real_escape_string($dw3_conn,$_GET['TITLE_DSP']);
$ICON_COLOR = mysqli_real_escape_string($dw3_conn,$_GET['ICON_COLOR']);
$ICON_TS = mysqli_real_escape_string($dw3_conn,$_GET['ICON_TS']);
$OPACITY = mysqli_real_escape_string($dw3_conn,$_GET['OPACITY']);
$RADIUS = mysqli_real_escape_string($dw3_conn,$_GET['RADIUS']);
$BG = mysqli_real_escape_string($dw3_conn,$_GET['BG']);
$FG = mysqli_real_escape_string($dw3_conn,$_GET['FG']);
$MAXW = mysqli_real_escape_string($dw3_conn,$_GET['MAXW']);
$MARGIN = mysqli_real_escape_string($dw3_conn,$_GET['MARGIN']);
$SHADOW = mysqli_real_escape_string($dw3_conn,$_GET['SHADOW']);
$ANIM = mysqli_real_escape_string($dw3_conn,$_GET['ANIM']);
//$FR = mysqli_real_escape_string($dw3_conn,$_GET['FR']);
//$EN = mysqli_real_escape_string($dw3_conn,$_GET['EN']);

	$sql = "UPDATE index_head
     SET    
	 title  = '" . $TITLE   . "',
	 title_en  = '" . $TITLE_EN   . "',
	 title_display  = '" . $TITLE_DSP   . "',
	 meta_keywords  = '" . $META_KEYW   . "',
	 meta_description  = '" . $META_DESC   . "',
	 header_path = '" . $HEADER . "',
	 scene = '" . $SCENE . "',
	 url = '" . $URL  . "',
	 font_family = '" . $FONT  . "',
	 icon = '" . $ICON  . "',
	 icon_display = '" . $ICON_DSP  . "',
	 icon_color = '" . $ICON_COLOR  . "',
	 icon_textShadow = '" . $ICON_TS  . "',
	 is_in_menu = '" . $MENU  . "',
	 menu_order= '" . $ORDER . "',
	 cat_list= '" . $LIST . "',
	 img_url= '" . $IMG . "',
	 img_anim= '" . $IMG_ANIM . "',
	 img_anim_time= '" . $IMG_ANIM_TIME . "',
	 img_display= '" . $IMG_DSP . "',
	 opacity= '" . $OPACITY . "',
	 background= '" . $BG . "',
	 foreground= '" . $FG . "',
	 max_width= '" . $MAXW . "',
	 margin= '" . $MARGIN . "',
	 boxShadow= '" . $SHADOW . "',
	 anim_class= '" . $ANIM . "',
	 border_radius= '" . $RADIUS . "'
	 WHERE id = '" . $ID . "'";
	if ($dw3_conn->query($sql) === TRUE) {
	  echo "0";
	} else {
	  echo $dw3_conn->error;
	}

    $dw3_conn->close();
    die(""); 

?>
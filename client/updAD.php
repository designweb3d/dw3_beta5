<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$ID  = $_GET['ID'];
$ACTIVE = $_GET['ACTIVE'];if ($ACTIVE=="false"){$ACTIVE=0;}else{$ACTIVE=1;}
$DROP = $_GET['DROP'];if ($DROP=="false"){$DROP=0;}else{$DROP=1;}
$CAT = str_replace("'","’",$_GET['CAT']);
$ETAT = str_replace("'","’",$_GET['ETAT']);
$SHIP = str_replace("'","’",$_GET['SHIP']);
$NAME_FR = str_replace("'","’",$_GET['NAME_FR']);
$NAME_EN = str_replace("'","’",$_GET['NAME_EN']);
$DESC_FR = str_replace("'","’",$_GET['DESC_FR']);
$DESC_EN = str_replace("'","’",$_GET['DESC_EN']);
$QTY = $_GET['QTY'];
$KG = $_GET['KG'];
$HEIGHT = $_GET['H'];
$WIDTH = $_GET['W'];
$DEPTH = $_GET['D'];
$PRICE = $_GET['PRICE'];
$TAX_FED = $_GET['TAX_FED'];if ($TAX_FED=="false"){$TAX_FED=0;}else{$TAX_FED=1;}
$TAX_PROV = $_GET['TAX_PROV'];if ($TAX_PROV=="false"){$TAX_PROV=0;}else{$TAX_PROV=1;}
$BRAND = str_replace("'","’",$_GET['BRAND']);
$MODEL = str_replace("'","’",$_GET['MODEL']);
$YEAR = str_replace("'","’",$_GET['YEAR']);
$RECOMMENDED = $_GET['RECOMMENDED'];

$sql = "UPDATE classified SET  
etat = '" . $ETAT . "',
ship_type = '" . $SHIP . "',
drop_shipped = '" . $DROP . "',
active = '" . $ACTIVE . "',
category_id = '" . $CAT . "',
name_fr = '" . $NAME_FR . "',
name_en = '" . $NAME_EN . "',
description_fr ='" . $DESC_FR . "',
description_en ='" . $DESC_EN . "',
qty_available ='" . $QTY . "',
price ='" . $PRICE . "',
kg ='" . $KG . "',
height ='" . $HEIGHT . "',
width ='" . $WIDTH . "',
depth ='" . $DEPTH . "',
tax_fed ='" . $TAX_FED . "',
tax_prov ='" . $TAX_PROV . "',
brand = '" . $BRAND . "',	 
model ='" . $MODEL . "',
year_production ='" . $YEAR . "',
recommended ='" . $RECOMMENDED . "'
WHERE id = '" . $ID . "' 
LIMIT 1";
if ($dw3_conn->query($sql) == TRUE) {
    echo "";
} else {
  echo $dw3_conn->error;
}
$dw3_conn->close();
?>
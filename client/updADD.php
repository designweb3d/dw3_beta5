<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$ID  = $_GET['ID'];
$ACTIVE = $_GET['ACTIVE'];if ($ACTIVE=="false"){$ACTIVE=0;}else{$ACTIVE=1;}
$CAT = $_GET['CAT'];
$NAME_FR = $_GET['NAME_FR'];
$NAME_EN = $_GET['NAME_EN'];
$DESC_FR = $_GET['DESC_FR'];
$DESC_EN = $_GET['DESC_EN'];
$QTY = $_GET['QTY'];
$PRICE = $_GET['PRICE'];
$TAX = $_GET['TAX'];if ($TAX=="false"){$TAX=0;}else{$TAX=1;}
$BRAND = $_GET['BRAND'];
$MODEL = $_GET['MODEL'];
$YEAR = $_GET['YEAR'];
$RECOMMENDED = $_GET['RECOMMENDED'];

$sql = "UPDATE classified SET  
active = '" . $ACTIVE . "',
category_id = '" . $CAT . "',
name_fr = '" . $NAME_FR . "',
name_en = '" . $NAME_EN . "',
description_fr ='" . $DESC_FR . "',
description_en ='" . $DESC_EN . "',
qty_available ='" . $QTY . "',
price ='" . $PRICE . "',
taxable ='" . $TAX . "',
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
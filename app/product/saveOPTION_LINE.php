<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php'; 
$line_id  = $_GET['LNG'];
$name_fr  = $_GET['FR'];
$name_en  = $_GET['EN'];
$amount  = $_GET['MNT'];
$liter  = $_GET['LT'];
$kg  = $_GET['KG'];
$height  = $_GET['HT'];
$width  = $_GET['WD'];
$depth  = $_GET['DP'];
$is_dft	= $_GET['DFT'];if ($is_dft=="false"){$is_dft=0;}else{$is_dft=1;}

if ($is_dft == 1){
	$sql1 = "SELECT * FROM product_option_line WHERE id = '".$line_id."' LIMIT 1;";
    $result1 = mysqli_query($dw3_conn, $sql1);
    $data1 = mysqli_fetch_assoc($result1);
    $option_id = $data1["option_id"];

    $sql2 = "UPDATE product_option_line SET default_selection = '0' WHERE option_id = '".$option_id."'";
    $dw3_conn->query($sql2);
    echo $sql2;
}

$sql = "UPDATE product_option_line SET 
default_selection = '".$is_dft."', 
name_fr = '" . $name_fr . "', 
name_en = '" . $name_en . "', 
amount = '" . $amount . "',
liter = '" . $liter . "',
kg = '" . $kg . "',
height = '" . $height . "',
width = '" . $width . "',
depth = '" . $depth . "'
WHERE id = '" . $line_id . "'  LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) {
	  //echo $sql;
      echo "";
	} else {
	  echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
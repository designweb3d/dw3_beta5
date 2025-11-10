<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$lnID     = $_GET['lnID'];
$optID     = $_GET['optID'];
$optlID     = $_GET['optlID'];

    //get option info
    $sql = "SELECT * FROM product_option WHERE id = '".$optID."'";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $option_name = $data['name_fr'];
	//get option_line info
    $sql = "SELECT * FROM product_option_line WHERE id = '".$optlID."'";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $option_name = $option_name . ": " .$data['name_fr'];
    $option_price = $data['amount'];

	$sql = "UPDATE cart_option
     SET    
	 option_line_id = '" . $optlID  . "',
	 description_fr = '" . $option_name  . "',
	 price = '" . $option_price  . "'
	 WHERE id = '" . $lnID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) { 
        echo "";
	} else {
	    echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
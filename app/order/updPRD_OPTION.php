<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enlnID     = $_GET['enlnID'];
$lnID     = $_GET['lnID'];
$optID     = $_GET['optID'];
$optlID     = $_GET['optlID'];

    //get order_line info
    /* $sql = "SELECT * FROM order_line WHERE id = '".$enlnID."'";
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $line_qty = $data['qty_order']; */

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
    $options_price = 0;
    $options_text = "";

    //update order_option
	$sql = "UPDATE order_option
     SET    
	 option_line_id = '" . $optlID  . "',
	 description_fr = '" . $option_name  . "',
	 price = '" . $option_price  . "'
	 WHERE id = '" . $lnID . "' 
	 LIMIT 1";
	if ($dw3_conn->query($sql) === TRUE) { 
            //update line option_price
            $sql2 = "SELECT * FROM order_option WHERE line_id = '".$enlnID ."';";
            $result2 = $dw3_conn->query($sql2);
            if ($result2->num_rows > 0) {
                while($row2 = $result2->fetch_assoc()) { 
                    //$options_price = $options_price + ($row2["price"]*$line_qty);
                    $options_price = $options_price + $row2["price"];
                    $options_text .= " /".$row2["description_fr"];
                }
            }
            $sql = "UPDATE order_line SET  options_price = '" . $options_price . "', product_opt = '".$options_text."' WHERE id = '" . $enlnID . "'  LIMIT 1";
            if ($dw3_conn->query($sql) === TRUE) { echo ""; } else { echo $dw3_conn->error;}
	} else {
	    echo $dw3_conn->error;
	}
$dw3_conn->close();
?>
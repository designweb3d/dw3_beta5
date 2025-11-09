<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID   = $_GET['enID'];
$prUPC   = $_GET['prUPC'];
$product_qty   = $_GET['lgQTE'];
//get customer id
$sql = "SELECT customer_id FROM order_head WHERE id = '".$enID."'";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$customer_id = $data['customer_id'];
//get next LGN
$sql = "SELECT MAX(line)+1 as nextLGN FROM order_line WHERE head_id = '" . $enID . "'";
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$line_billing = $data["billing"];
$nextLGN = $data['nextLGN'];
if ($nextLGN == 0 || $nextLGN == ''){$nextLGN == '1';}

//get prd data before insert 
	$sql = "SELECT * FROM product WHERE upc = '" .  $prUPC . "' AND upc <> '' LIMIT 1";
	$result = mysqli_query($dw3_conn, $sql);
	$data = mysqli_fetch_assoc($result);

    //get price from getPRICE.php
    $product_id = $prID;
    require $_SERVER['DOCUMENT_ROOT'] . '/app/product/getPRICE.php';
    $line_price = $product_price;

/*     $line_price = $data["price1"];
    $date_promo = new DateTime($row["promo_expire"]);
    $now = new DateTime();
    if($date_promo > $now) {
        $line_price = $row["promo_price"];
    } */


    if ($line_billing == "ANNUEL" || $line_billing == "MENSUEL" || $line_billing == "HEBDO"){
        $line_renew = '1';
    } else {
        $line_renew = '0';
    }
//insert
	$sql = "INSERT INTO order_line
    (head_id,line,product_renew,product_id,product_desc,qty_order,price,date_created,date_modified)
    VALUES 
        ('" . $enID  . "',
        '" . $nextLGN . "',
        '" . $line_renew . "',
        '" . $data['id'] . "',
        '" . $data['name_fr'] . "',
         '" . $product_qty . "',
         '" . $line_price  . "',
         '" . $datetime  . "',
         '" . $datetime  . "')";
	if ($dw3_conn->query($sql) === TRUE) {
            $new_line_id = $dw3_conn->insert_id;
            //options
            $sql2 = "SELECT * FROM product_option WHERE product_id = '" .  $prID . "'";
            $result2 = $dw3_conn->query($sql2);
            if ($result2->num_rows> 0) { 
                while($row2 = $result2->fetch_assoc()) {
                    //options_line
                    $sql3 = "SELECT * FROM product_option_line WHERE option_id = '" .  $row2["id"] . "'";
                    $result3 = $dw3_conn->query($sql3);
                    if ($result3->num_rows> 0) { 
                        while($row3 = $result3->fetch_assoc()) {
                            if ($row3["default_selection"] == "1"){
                                $sql4 = "INSERT INTO order_option (id,line_id,option_id,option_line_id,price,description_fr) VALUES (NULL,'".$new_line_id."','".$row3["option_id"]."','".$row3["id"]."','".$row3["amount"]."','".$row2["name_fr"].": ".$row3["name_fr"]."')";  
                                $result4 = mysqli_query($dw3_conn, $sql4);
                            }
                        }
                    }
                }
            }
        $sqlx = "UPDATE order_head SET date_modified   = '" . $datetime   . "',	 user_modified   = '" . $USER   . "' WHERE id = '" . $enID . "' LIMIT 1";
        $resultx = mysqli_query($dw3_conn, $sqlx);
	} else {
	  echo "Erreur: " . $dw3_conn->error;
	}

$dw3_conn->close();
?>

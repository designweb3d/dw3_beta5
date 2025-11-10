<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$ID = $_GET['ID'];

//get product_info
$sql1 = "SELECT * FROM product WHERE id = '" . $ID . "' LIMIT 1";
$result1 = mysqli_query($dw3_conn, $sql1);
$data = mysqli_fetch_assoc($result1);

$sql = "INSERT INTO cart_line (device_id,product_id,quantity,ship_type) VALUES ('".$_COOKIE["DEVICE"]."','".$ID."','".$data["qty_min_sold"]."','".$data["ship_type"]."');";
$result = mysqli_query($dw3_conn, $sql);
$new_line_id = $dw3_conn->insert_id;

            //options
            $sql2 = "SELECT * FROM product_option WHERE product_id = '" .  $ID . "'";
            $result2 = $dw3_conn->query($sql2);
            if ($result2->num_rows> 0) { 
                while($row2 = $result2->fetch_assoc()) {
                    //options_line
                    $sql3 = "SELECT * FROM product_option_line WHERE option_id = '" .  $row2["id"] . "'";
                    $result3 = $dw3_conn->query($sql3);
                    if ($result3->num_rows> 0) { 
                        while($row3 = $result3->fetch_assoc()) {
                            if ($row3["default_selection"] == "1"){
                                $sql4 = "INSERT INTO cart_option (line_id,option_id,option_line_id,price,description_fr) VALUES ('".$new_line_id."','".$row3["option_id"]."','".$row3["id"]."','".$row3["amount"]."','".$row2["name_fr"].": ".$row3["name_fr"]."')";  
                                $result4 = mysqli_query($dw3_conn, $sql4);
                            }
                        }
                    }
                }
            }

$dw3_conn->close();
?>
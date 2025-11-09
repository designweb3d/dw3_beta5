<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$enID  = $_GET['enID'];
$sql = "SELECT * FROM order_line WHERE head_id = '" . $enID . "' ";
$result = mysqli_query($dw3_conn, $sql);
$gtot = 0;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { 
                    $line_price = $row["price"];
                    //options
                    $sql2 = "SELECT * FROM order_option WHERE line_id = '".$row["id"]."';";
                    $result2 = $dw3_conn->query($sql2);
                    if ($result2->num_rows > 0) {
                        while($row2 = $result2->fetch_assoc()) { 
                            $line_price = $line_price + $row2["price"];
                        }
                    }
                $gtot = $gtot + ($row["qty_order"] * $line_price);
                }
            }

echo "(Sous-total: " . number_format($gtot,2,',','.') . "$" . ")";
$dw3_conn->close();
?>

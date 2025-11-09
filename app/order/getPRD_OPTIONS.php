<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/security.php';
$line_id  = $_GET['lnID'];
$product_id  = $_GET['prdID'];
$html = "";
    $sql2 = "SELECT * FROM product_option WHERE product_id = '".$product_id."' ORDER BY name_fr ASC;";
    $result2 = $dw3_conn->query($sql2);
    if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
            $html .= "<div class='divBOX'>".$row2["name_fr"].":<br><div style='width:100%;text-align:center;'><div style='text-align:left;display:inline-block;'>";	

                //option_line selected
                $sqlx = "SELECT * FROM order_option WHERE line_id = '".$line_id."' AND option_id = '".$row2["id"]."' LIMIT 1;";
                $resultx = mysqli_query($dw3_conn, $sqlx);
                if ($resultx->num_rows > 0) {
                    $datax = mysqli_fetch_assoc($resultx);
                    $selected_option_line = $datax["option_line_id"];
                    $option_line_id = $datax["id"];
                
                    $sql3 = "SELECT * FROM product_option_line WHERE option_id = '".$row2["id"]."' ORDER BY amount ASC;";
                    $result3 = $dw3_conn->query($sql3);
                    if ($result3->num_rows > 0) {
                        while($row3 = $result3->fetch_assoc()) {
                            if ($selected_option_line == $row3["id"]){
                                $html .= "<input onclick=\"updPRD_OPTION('".$option_line_id."','".$row2["id"]."','".$row3["id"]."','".$line_id."')\" id='opt".$row3["id"]."' name='opts".$row2["id"]."' type='radio' value='". $row3["id"] . "' checked> <label for='opt".$row3["id"]."' style='padding-top:0px;'>". $row3["name_fr"] . " <small>+" . $row3["amount"] . "$</small></label><br>";		
                            } else {
                                $html .= "<input onclick=\"updPRD_OPTION('".$option_line_id."','".$row2["id"]."','".$row3["id"]."','".$line_id."')\" id='opt".$row3["id"]."' name='opts".$row2["id"]."' type='radio' value='". $row3["id"] . "'> <label for='opt".$row3["id"]."' style='padding-top:0px;'>". $row3["name_fr"] . " <small>+" . $row3["amount"] . "$</small></label><br>";		
                            }
                        }
                    }
                }
            $html .= "</div></div></div>";
        }
    } else {
        $html .= "<div class='divBOX'> Aucune option trouvée pour ce produit.</div>";
    }

	$html .= "</div><div class='dw3_form_foot'>";
    $html .= "<button class='grey' onclick='closeOPTIONS()' style='margin:5px;'><span class='material-icons'>cancel</span> Fermer</button></div>";
	$html .= "</div>";

$dw3_conn->close();
header('Status: 200');
die($html);
?>
<?php 
if($USER_LANG == "FR"){
    $lbl1 = "Mon panier";
    $lbl2 = "Livraison GRATUITE avec une commande avant taxes de";
    $lbl3 = "$ et plus";
}else{
    $lbl1 = "My basket";
    $lbl2 = "FREE delivery with an order before taxes of";
    $lbl3 = "$ and more";
}
   $sql = "SELECT A.*, IFNULL(B.total,0) AS invTOT FROM product A 
   LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) B ON A.id = B.product_id
   WHERE stat = 0 AND web_dsp = 1 ";
   if ($cat_lst != "") {
    $sql .= " AND category_id IN (".$cat_lst.") ";
   }
   $sql.="
   ORDER BY price1 ASC";

        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $RNDSEQ=rand(100,100000);
                    $filename= $row["url_img"];
                    if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                        $filename = "/pub/img/dw3/nd.png";
                    } else {
                        if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/product/" . $row["id"] . "/" . $filename)){
                            $filename = "/pub/img/dw3/nd.png";
                        }else{
                            $filename = "/fs/product/" . $row["id"] . "/" . $filename;
                        }
                    }
                    
                    echo "<div style='border:1px solid #444;margin:15px; box-shadow: 3px 3px 5px 2px rgba(0,0,0,0.5);max-width:420px;display:inline-block;height:385px;border-radius:10px;'>
                            <table style='border-collapse: collapse;border:0px;width:100%;min-height:100%;margin-right:auto;margin-left:auto;display:inline-block;background:rgba(255,255,255,0.8);border-radius:10px;'>
                            <tr onclick='getPRD(". $row["id"] . ");'  style='cursor:pointer;padding:0px;border:0px;border-top-right-radius:10px;border-top-left-radius:10px;' >"
                            . "<td colspan=2 style='vertical-align:middle;text-align:center;padding:5px 0px 0px 0px;background:rgba(255,255,255,0.7);border-top-right-radius:10px;border-top-left-radius:10px;'><div style='display:inline-block;vertical-align:middle;font-size:18px;'>";
                            if($USER_LANG == "FR"){echo $row["name_fr"]; }else{echo $row["name_en"];}
                        echo "</div></td></tr>";
                        //image                           
                             echo "<tr style='padding:0px;border:0px;' onclick='getPRD(". $row["id"] . ");'>"
                                   . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;'><img class='dw3_product_photo' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"./img/dw3/nd.png\";'></td></tr>";
                        //prix
                        $date_promo = new DateTime($row["promo_expire"]);
                        $now = new DateTime();
                        if($date_promo > $now) {
                            if($USER_LANG == "FR"){
                                if ( trim($row["price_text_fr"]) == "") {
                                    echo "<tr><td><span class='material-icons' style='color:gold;text-shadow:1px 1px 2px goldenrod;'>new_releases</span> <b>". number_format($row["promo_price"],2,"."," ").$row["price_suffix_fr"]."</b></td>";
                                } else {
                                    echo "<tr><td><b>". $row["price_text_fr"]."</b></td>";
                                }
                                echo "<td style='vertical-align:top;'><span style='text-decoration: line-through;text-decoration-thickness: 2px;'>" . number_format($row["price1"],2,"."," ") . $row["price_suffix_fr"]."</span></td></tr>";
                                echo "<tr><td colspan='2' style='font-size:14px;'><div style='height:24px;overflow:hidden;vertical-align:middle;'>Valide jusqu'au: " . substr($row["promo_expire"],0,10) . "</div></td></tr>";
                            }else{
                                if ( trim($row["price_text_en"]) == "") {
                                    echo "<tr><td><span class='material-icons' style='color:gold;text-shadow:1px 1px 2px goldenrod;'>new_releases</span> <b>". number_format($row["promo_price"],2,"."," ").$row["price_suffix_en"]."</b></td>";
                                } else {
                                    echo "<tr><td><b>". $row["price_text_en"]."</b></td>";
                                }
                                echo "<td style='vertical-align:top;'><span style='text-decoration: line-through;text-decoration-thickness: 2px;'>" . number_format($row["price1"],2,"."," ") . $row["price_suffix_en"]."</span></td></tr>";
                                echo "<tr><td colspan='2' style='vertical-align:middle;font-size:14px;'><div style='height:24px;overflow:hidden;vertical-align:middle;'>Valid until: " . substr($row["promo_expire"],0,10) . "</div></td></tr>";
                            }
                        }else {
                            if ( trim($row["price_text_fr"]) == "") {
                                if ($row["price2"] != 0 && $row["qty_min_price2"] >=2){
                                    $plitted = explode(".",round($row["price2"]*$row["qty_min_price2"],2));
                                    $whole = $plitted[0]??round($row["price2"]*$row["qty_min_price2"],2);
                                    $fraction = $plitted[1]??0; 
                                    if ($fraction == 0){
                                        //$fraction = "00";
                                        $fraction = "";
                                    }else{
                                        $fraction = "." . str_pad(rtrim($fraction, "0"), 2 , "0");
                                    }
                                    //prix2
                                    echo "<tr style='height:35px;'><td width='50%' style='border:0px;text-align:right;padding-right:5px;'><b>".$row["qty_min_price2"]."</b> pour <b>". number_format($whole) . "<sup>" . $fraction . "$</sup>". "</b></td>";
                                    if($USER_LANG == "FR"){
                                        echo "<td style='vertical-align:top;'><span style=''>" . number_format($row["price1"],2,"."," ") . "</span>".$row["price_suffix_fr"]."</td></tr>";
                                    }else{
                                        echo "<td style='vertical-align:top;'><span style=''>" . number_format($row["price1"],2,"."," ") . "</span>".$row["price_suffix_en"]."</td></tr>";
                                    }
                                    echo "<tr><td colspan='2'><span style='font-size:14px;'> </span></td></tr>";
                                } else {
                                    $plitted = explode(".",$row["price1"]);
                                    $whole = $plitted[0]??$row["price1"];
                                    $fraction = $plitted[1]??0; 
                                    if ($fraction == 0){
                                        //$fraction = ".00";
                                        $fraction = "";
                                    }else{
                                        $fraction = ".".str_pad(rtrim($fraction, "0"), 2 , "0");
                                    }
                                    //prix1 
                                    if($USER_LANG == "FR"){
                                        echo "<tr style='height:35px;'><td width='50%' style='border:0px;text-align:right;padding-right:5px;'><b>". number_format($whole) ."<sup>" . $fraction . "</sup></b></td><td style='text-align:left;padding-right:5px;border:0px;' width='50%'>". $row["price_suffix_fr"] . "</td></tr>";
                                    }else{
                                        echo "<tr style='height:35px;'><td width='50%' style='border:0px;text-align:right;padding-right:5px;'><b>". number_format($whole) ."<sup>" . $fraction . "</sup></b></td><td style='text-align:left;padding-right:5px;border:0px;' width='50%'>". $row["price_suffix_en"] . "</td></tr>";
                                    }
                                    echo "<tr><td colspan='2'><span style='font-size:14px;'> </span></td></tr>";
                                }
                            } else { 
                                //texte au lieu du prix
                                if($USER_LANG == "FR"){
                                    echo " <tr style='height:35px;'><td colspan=2 style='border:0px;text-align:center;padding-right:5px;'><b>". $row["price_text_fr"] . "</b></td></tr>";
                                }else{
                                    echo " <tr style='height:35px;'><td colspan=2 style='border:0px;text-align:center;padding-right:5px;'><b>". $row["price_text_en"] . "</b></td></tr>";
                                }
                                echo "<tr><td colspan='2'><span style='font-size:11px;'> </span></td></tr>";
                            }
                        } 

                        echo "<tr style='border-bottom-right-radius:10px;border-bottom-left-radius:10px;'><td style='width:50%;border:0px;text-align:left;background:rgba(255,255,255,0.9);border-bottom-left-radius:10px;min-width:20px;'>";
                        switch ($row["btn_action2"]) {
                            case "DOWNLOAD":
                                $ACTION = 'dw3_download("' . $row["id"]  . '","' . $row["url_action2"]  . '",this);';
                            break;
                            case "INFO":
                                $ACTION = 'getPRD("' . $row["id"]  . '");';
                            break;
                            case "SUBMIT":
                                $ACTION = "dw3_action_submit(" . $row["id"]  . ",this);";
                            break;
                            case "CART":
                                $ACTION = "dw3_cart_add(" . $row["id"]  . ",this);";
                            break;
                            case "LINK":
                                $ACTION = 'dw3_page_open("' . $row["url_action2"]  . '",this);';
                            break;
                            case "BUY":
                                $ACTION = "dw3_cart_add(" . $row["id"]  . ",this);";
                            break;
                            default:
                                $ACTION = "";
                        }
                        if ($row["btn_action2"] != "NONE" && $row["btn_action2"] != ""){
                            if ($row["invTOT"] <= 0 && $row["btn_action2"] == "CART"){
                                if($USER_LANG == "FR"){
                                    echo "<button disabled style='min-height:50px;margin-right:0px;float:left;border-bottom-left-radius:10px;'><span class='material-icons' style='font-size:24px;vertical-align:middle;color:orange;'>warning</span> Rupture de stock</button>";
                                } else{
                                    echo "<button disabled style='min-height:50px;margin-right:0px;float:left;border-bottom-left-radius:10px;'><span class='material-icons' style='font-size:24px;vertical-align:middle;color:orange;'>warning</span> Out of stock</button>";
                                }
                            } else {
                                if($USER_LANG == "FR"){
                                    echo "<button onclick='" . $ACTION . "' style='min-height:50px;margin-right:0px;border-bottom-left-radius:10px;'><span class='material-icons' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn2_icon"] . "</span> " . $row["web_btn2_fr"] . "</span></button>";
                                }else{
                                    echo "<button onclick='" . $ACTION . "' style='min-height:50px;margin-right:0px;border-bottom-left-radius:10px;'><span class='material-icons' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn2_icon"] . "</span> " . $row["web_btn2_en"] . "</span></button>";
                                }
                            }
                        } 
                        echo " </td><td style='width:50%;min-width:20px;border:0px;text-align:right;background:rgba(255,255,255,0.9);border-bottom-right-radius:10px;'>"; 
                        switch ($row["btn_action1"]) {
                            case "DOWNLOAD":
                                $ACTION = 'dw3_download("' . $row["id"]  . '","' . $row["url_action1"]  . '",this);';
                            break;
                            case "INFO":
                                $ACTION = 'getPRD("' . $row["id"]  . '");';
                            break;
                            case "SUBMIT":
                                $ACTION = 'dw3_action_submit(' . $row["id"]  . ',this);';
                            break;
                            case "CART":
                                $ACTION = "dw3_cart_add(" . $row["id"]  . ",this);";
                            break;
                            case "LINK":
                                $ACTION = "dw3_page_open(\"" . $row["url_action1"]  . "\",\"_self\");";
                            break;
                            case "BUY":
                                $ACTION = "dw3_cart_add(" . $row["id"]  . ",this);";
                            break;
                            default:
                                $ACTION = "";
                        }
                        if ($row["btn_action1"] != "NONE" && $row["btn_action1"] != ""){
                            if ($row["invTOT"] <= 0 && $row["btn_action1"] == "CART"){
                                if($USER_LANG == "FR"){
                                    echo "<button disabled style='min-height:50px;margin-left:0px;float:right;border-bottom-left-radius:10px;'><span class='material-icons' style='font-size:24px;vertical-align:middle;color:orange;'>warning</span> Rupture de stock</button>";
                                } else{
                                    echo "<button disabled style='min-height:50px;margin-left:0px;float:right;border-bottom-left-radius:10px;'><span class='material-icons' style='font-size:24px;vertical-align:middle;color:orange;'>warning</span> Out of stock</button>";
                                }
                            } else {
                                if($USER_LANG == "FR"){
                                    echo "<button onclick='" . $ACTION . "' style='min-height:50px;margin-left:0px;float:right;border-bottom-right-radius:10px;'>" . $row["web_btn_fr"] . " <span class='material-icons' style='font-size:24px;vertical-align:middle;'> " . $row["web_btn_icon"] . "</span></button>";
                                }else{
                                    echo "<button onclick='" . $ACTION . "' style='min-height:50px;margin-left:0px;float:right;border-bottom-right-radius:10px;'>" . $row["web_btn_en"] . " <span class='material-icons' style='font-size:24px;vertical-align:middle;'> " . $row["web_btn_icon"] . "</span></button>";
                                }
                            }
                        }   
                        
                        echo "</td></tr></table></div>";
                }
            } else {
                //echo "Aucun produit/service trouvé pour le moment.";
            }
        
    ?>
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

if 	($SECTION_IMG_DSP=="gradiant"){$bg_gradiant = "background-image:".$SECTION_IMG.";";} else {$bg_gradiant = "";}
    if 	($SECTION_FONT!=""){$font_family = "font-family:".$SECTION_FONT.";";} else {$font_family = "";}
    echo "<div style='background-color:".$SECTION_BG.";color:". $SECTION_FG.";width:100%;text-align:center;margin:". $SECTION_MARGIN.";display:inline-block;text-align:center;height:auto;border-radius:". $SECTION_RADIUS.";max-width:". $SECTION_MAXW.";box-shadow:". $SECTION_SHADOW.";".$bg_gradiant.$font_family."'>";
    //img
    if ($SECTION_IMG_DSP == "header"){
        echo "<img src='/pub/upload/".$SECTION_IMG."' style='border-top-right-radius:".$SECTION_RADIUS.";border-top-left-radius:".$SECTION_RADIUS.";width:100%;height:auto;'>";
        echo "<div style='margin-top:-1px;display:inline-block;text-align:center;width:100%;height:auto;max-width:100%;line-height:1.5em;border-bottom-left-radius:".$SECTION_RADIUS.";border-bottom-right-radius:".$SECTION_RADIUS.";'>";
    } else {
        echo "<div style='margin-top:-1px;display:inline-block;text-align:center;width:100%;height:auto;max-width:100%;line-height:1.5em;border-radius:". $SECTION_RADIUS .";'>";
    }

    //title
    if ($SECTION_TITLE_DSP!="none" && $SECTION_TITLE_DSP!=""){
        if($USER_LANG == "FR"){
            echo "<h3 style='text-align:".$SECTION_TITLE_DSP.";text-shadow:0px 0px 2px white;padding:5px;'>".$SECTION_TITLE."</h3>";
        } else {
            echo "<h3 style='text-align:".$SECTION_TITLE_DSP.";text-shadow:0px 0px 2px white;padding:5px;'>".$SECTION_TITLE_EN."</h3>";
        }
    }


//sous-categories
if (trim(strtolower($cat_lst)) != "promo"){
    $sql = "SELECT A.*, IFNULL(C.id,-1) as parent_id, IFNULL(C.name_fr,'Retour') as parent_name, IFNULL(C.name_en,'Return') as parent_name_en, IFNULL(B.name_fr,'') as child_name, IFNULL(B.name_en,'') as child_name_en 
    FROM product_category A
    LEFT JOIN (SELECT id, name_fr,name_en,parent_name FROM product_category) B ON A.parent_name = B.name_fr
    LEFT JOIN (SELECT id, name_fr,name_en FROM product_category) C ON B.parent_name = C.name_fr
    WHERE web_dsp = 1 ";
    if ($cat_lst != "" && $cat_lst != "all") {
        $sql .= " AND B.id IN (".$cat_lst.") ";
    } else {
        $sql .= " AND A.parent_name = '' "; 
    }
    $cat_name = "";
    if ($USER_LANG == "FR"){
        $sql.="ORDER BY A.name_fr ASC ;";
    } else {
        $sql.="ORDER BY A.name_en ASC ;";
    }
    $result = $dw3_conn->query($sql);
    $sub_cats_count = $result->num_rows;
    if ($sub_cats_count > 0) {
        echo "<div class='dw3_page' style='max-width:1150px;'>";
         while($row = $result->fetch_assoc()) {
             $RNDSEQ=rand(100,100000);
                 $filename= $row["img_url"];
                 if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $filename)){
                     //$filename = "/pub/img/dw3/nd.png";
                 } else {
                     if (!is_file($_SERVER['DOCUMENT_ROOT'] . $filename)){
                         //$filename = "/pub/img/dw3/nd.png";
                     }
                 }
                 if($USER_LANG == "FR"){  
                    $trad_parent = $row["parent_name"]; 
                    $trad_child = $row["child_name"]; 
                } else {
                    $trad_parent = $row["parent_name_en"];
                    $trad_child = $row["child_name_en"];
                }
                    //navigate in categories must be sorted by categories
/*                     if ($row["parent_name"] != "" && $cat_name != $row["parent_name"]){
                        if ($row["parent_id"] == "-1"){
                            if ($row["child_name"] !=""){
                                echo "<h3 style='text-align:left;padding:10px;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";vertical-align:middle;'><a href='/pub/page/products/index.php?KEY=".$KEY."&PID=".$PAGE_ID."&P1='><u style='vertical-align:middle;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";'>".$trad_parent."</u> </a> <div style='vertical-align:middle;display:inline-block;'> > ".$trad_child ."</div></h3>";
                            }else{
                                echo "<h3 style='text-align:left;padding:10px;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";vertical-align:middle;'><span style='cursor:pointer;vertical-align:middle;' onclick='history.back()'><u style='vertical-align:middle;'> ".$trad_parent."</u></span></h3>";
                            }
                        } else {
                                echo "<h3 style='text-align:left;padding:10px;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";vertical-align:middle;'><a href='/pub/page/products/index.php?KEY=".$KEY."&PID=".$PAGE_ID."&P1=".$row["parent_id"]."'><u style='vertical-align:middle;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";'>".$trad_parent."</u></a> <div style='vertical-align:middle;display:inline-block;'> > ".$trad_child ."</div></h3>";
                        }
                    } */
                    //echo "before row cn:".$row["name_fr"]."var cn:".$cat_name."<hr>";
                    $cat_name = $row["parent_name"];
                    //echo "before row cn:".$row["name_fr"]."var cn:".$cat_name."<hr>";

                     echo "<div style='background:#f0f0f0;color:#333;border:1px solid #444;margin:10px 6px; box-shadow: 0px 0px 4px 2px rgba(0,0,0,0.5);max-width:170px;width:170px;display:inline-block;height:250px;border-radius:12px;'>
                     <table class='hoverShadow' style='line-height:1;border-collapse: collapse;border:0px;width:100%;min-height:100%;margin-right:auto;margin-left:auto;display:inline-block;border-radius:10px;'>";
                 //image                           
                      echo "<tr style='padding:0px;border:0px;' onclick=\"getPRDS(". $row["id"] . ",'');\">"
                            . "<td colspan=2 style='border-top-right-radius:10px;border-top-left-radius:10px;cursor:pointer;text-align:center;padding:0px 0px 0px 0px;'><div style=\"border-top-right-radius:10px;border-top-left-radius:10px;width:170px;height:170px;background-image:url('".$filename."?t=" . $RNDSEQ . "');background-position: bottom center;background-repeat: no-repeat;background-size:cover;\"> </div></td></tr>";
                
                 //description    
                 if($USER_LANG == "FR"){         
                      echo "<tr style='padding:0px;border:0px;' onclick=\"getPRDS(". $row["id"] . ",'');\">"
                            . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;height:70px;width:170px;font-size:16px;'>". $row["name_fr"] . "</td></tr>";
                 }else {
                    echo "<tr style='padding:0px;border:0px;' onclick=\"getPRDS(". $row["id"] . ",'');\">"
                    . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;height:70px;width:170px;font-size:16px;'>". $row["name_en"] . "</td></tr>";
                }
                 
                 echo "</table></div>";
             }
         } 
         echo "</div><br>";
}



    //products
    $sql = "SELECT A.*, IFNULL(B.total,0) AS invTOT FROM product A 
    LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) B ON A.id = B.product_id
    WHERE stat = 0 AND web_dsp = 1 ";
    if ($cat_lst != "") {
    $sql .= " AND category_id IN (".$cat_lst.") OR stat = 0 AND web_dsp = 1 AND category2_id IN (".$cat_lst.") OR stat = 0 AND web_dsp = 1 AND category3_id IN (".$cat_lst.")";
    }
    $sql.="
    ORDER BY price1 ASC";
//die($sql);
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
                    
                    echo "<div style='font-family:".$SECTION_FONT.";color:". $SECTION_FG.";vertical-align:top;border:0px;margin:5px;min-width:275px;text-align:center;box-shadow:". $SECTION_SHADOW.";display:inline-block;border-radius:10px;'>
                            <table style='line-height:1;border-collapse: collapse;border:0px;width:100%;min-height:100%;margin-right:auto;margin-left:auto;background:rgba(255,255,255,0.8);color:#333;border-radius:10px;'>
                            <tr onclick='getPRD(". $row["id"] . ");'  style='height:26px;cursor:pointer;padding:0px;border:0px;border-top-right-radius:10px;border-top-left-radius:10px;' >"
                            . "<td colspan=2 style='vertical-align:top;text-align:center;padding:5px 0px;background:rgba(255,255,255,0.7);border-top-right-radius:10px;border-top-left-radius:10px;'><div style='display:inline-block;vertical-align:middle;font-size:18px;'>";
                            if($USER_LANG == "FR"){echo $row["name_fr"]; }else{echo $row["name_en"];}
                        echo "</div></td></tr>";
                        //image                           
                             echo "<tr style='padding:0px;border:0px;' onclick='getPRD(". $row["id"] . ");'>"
                                   . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;'><div style=\"width:300px;height:300px;background-image:url('".$filename."');background-position: bottom center;background-repeat: no-repeat;background-size:cover;\"> </div></td></tr>";
                        //prix
                        $date_promo = new DateTime($row["promo_expire"]);
                        $now = new DateTime();
                        if($date_promo > $now) {
                            if($USER_LANG == "FR"){
                                if ( $row["price_text_fr"] == "") {
                                    echo "<tr style='height:35px;'><td><span style='color:gold;text-shadow:1px 1px 2px goldenrod;'>&#128165;</span> <strong>". number_format($row["promo_price"],2,"."," ").$row["price_suffix_fr"]."</strong></td>";
                                } else {
                                    echo "<tr style='height:35px;'><td>". $row["price_text_fr"]."</td>";
                                }
                                echo "<td style='vertical-align:top;'><span style='text-decoration: line-through;text-decoration-thickness: 2px;'>" . number_format($row["price1"],2,"."," ") . $row["price_suffix_fr"]."</span></td></tr>";
                                //echo "<tr><td colspan='2' style='font-size:14px;'><div style='height:24px;overflow:hidden;vertical-align:middle;'>Valide jusqu'au: " . substr($row["promo_expire"],0,10) . "</div></td></tr>";
                            }else{
                                if ( $row["price_text_en"] == "") {
                                    echo "<tr style='height:35px;'><td><span style='color:gold;text-shadow:1px 1px 2px goldenrod;'>&#128165;</span> <strong>". number_format($row["promo_price"],2,"."," ").$row["price_suffix_en"]."</strong></td>";
                                } else {
                                    echo "<tr style='height:35px;'><td>". $row["price_text_en"]."</td>";
                                }
                                echo "<td style='vertical-align:top;'><span style='text-decoration: line-through;text-decoration-thickness: 2px;'>" . number_format($row["price1"],2,"."," ") . $row["price_suffix_en"]."</span></td></tr>";
                                //echo "<tr><td colspan='2' style='vertical-align:middle;font-size:14px;'><div style='height:24px;overflow:hidden;vertical-align:middle;'>Valid until: " . substr($row["promo_expire"],0,10) . "</div></td></tr>";
                            }
                        }else {
                            if ( $row["price_text_fr"] == "") {
                                //verif si escompte produit du fournisseur x
                                $line_price = $row["price1"];
                                if ($USER != ""){
                                    $sqlx = "SELECT * FROM customer_discount WHERE customer_id = '".$USER."' AND supplier_id = '" . $row["supplier_id"] . "' AND supplier_id <> 0 LIMIT 1";
                                    $resultx = mysqli_query($dw3_conn, $sqlx);
                                    $datax = mysqli_fetch_assoc($resultx);
                                    if (isset($datax["escount_pourcent"]) && $datax["escount_pourcent"] != 0){
                                        $line_price = $line_price - (round($line_price*($datax["escount_pourcent"]/100),2));
                                    }
                                }
                                /* if ($row["price2"] != 0 && $row["qty_min_price2"] >=2 && $line_price > $row["price2"]){
                                    $plitted = explode(".",number_format($row["price2"]*$row["qty_min_price2"],2,"."," "));
                                    $whole = $plitted[0];
                                    $fraction = $plitted[1]??0; 
                                    if ($fraction == 0){
                                        //$fraction = "00";
                                        $fraction = "00";
                                    }else{
                                        $fraction = "." . str_pad(rtrim($fraction, "0"), 2 , "0");
                                    }
                                    //prix2
                                    echo "<tr style='height:35px;'><td width='50%' style='border:0px;text-align:right;padding-right:5px;'><strong>".$row["qty_min_price2"]."</strong> pour <strong>". number_format($whole) . "<sup>" . $fraction . "$</sup>". "</strong></td>";
                                    if($USER_LANG == "FR"){
                                        echo "<td style='vertical-align:top;'><span style=''>" . number_format($row["price1"],2,"."," ") . "</span>".$row["price_suffix_fr"]."</td></tr>";
                                    }else{
                                        echo "<td style='vertical-align:top;'><span style=''>" . number_format($row["price1"],2,"."," ") . "</span>".$row["price_suffix_en"]."</td></tr>";
                                    }
                                    //echo "<tr><td colspan='2'><span style='font-size:14px;'> </span></td></tr>";
                                } */ //else {
                                    $plitted = explode(".",number_format($line_price,2,"."," "));
                                    $whole = $plitted[0];
                                    $fraction = $plitted[1]??0; 
                                    if ($fraction == 0){
                                        //$fraction = ".00";
                                        $fraction = "00";
                                    }else{
                                        $fraction = ".".str_pad(rtrim($fraction, "0"), 2 , "0");
                                    }
                                    //prix1 
                                    if($USER_LANG == "FR"){
                                        echo "<tr style='height:35px;'><td width='50%' style='border:0px;text-align:right;'><strong>". number_format($whole) ."<sup>" . $fraction . "</sup></strong></td><td style='text-align:left;border:0px;' width='50%'><strong>". $row["price_suffix_fr"] . "</strong></td></tr>";
                                    }else{
                                        echo "<tr style='height:35px;'><td width='50%' style='border:0px;text-align:right;'><strong>". number_format($whole) ."<sup>" . $fraction . "</sup></strong></td><td style='text-align:left;border:0px;' width='50%'><strong>". $row["price_suffix_en"] . "</strong></td></tr>";
                                    }
                                    //echo "<tr><td colspan='2'><span style='font-size:14px;'> </span></td></tr>";
                                //}
                            } else if (trim($row["price_text_fr"]) !=""){ 
                                //texte au lieu du prix
                                if($USER_LANG == "FR"){
                                    echo " <tr style='height:35px;'><td colspan=2 style='border:0px;text-align:center;'><strong>". $row["price_text_fr"] . "</strong></td></tr>";
                                }else{
                                    echo " <tr style='height:35px;'><td colspan=2 style='border:0px;text-align:center;'><strong>". $row["price_text_en"] . "</strong></td></tr>";
                                }
                                //echo "<tr><td colspan='2'><span style='font-size:11px;'> </span></td></tr>";
                            }
                        } 

                        echo "<tr style='border-bottom-right-radius:10px;border-bottom-left-radius:10px;'><td colspan=2 style='border:0px;border-bottom-left-radius:10px;border-bottom-right-radius:10px;'>";
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
                                $ACTION = "dw3_buy(" . $row["id"]  . ",this);";
                                break;
                            case "SUBSCRIBE":
                                $ACTION = "dw3_subscribe(" . $row["id"]  . ",this);";
                                break;

                            default:
                                $ACTION = "";
                        }
                        $is_service = true;
                        if ($row["billing"] == "FINAL" || $row["billing"] == "LOCATION"){
                            $is_service = false;
                        }
                        if ($row["btn_action2"] != "NONE" && $row["btn_action2"] != ""){
                            if ($row["btn_action1"] == "NONE" || $row["btn_action1"] == ""){$btn_width = "100%";} else {$btn_width = "49%";}
                            if ($row["btn_action2"] != "SUBMIT" && $row["btn_action2"] != "LINK"){$action_class = "no-effect";} else {$action_class = "";}
                            if ($row["invTOT"] <= 0 && $row["qty_max_by_inv"] == 1 && $row["btn_action2"] == "CART" && $is_service == false){
                                if($USER_LANG == "FR"){
                                    echo "<button disabled class='".$action_class."' style='min-height:50px;margin:0px;float:left;border-radius:0px 5px 5px 8px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span style='font-size:24px;vertical-align:middle;color:orange;'>&#128219;</span> Rupture de stock</button>";
                                } else{
                                    echo "<button disabled class='".$action_class."' style='min-height:50px;margin:0px;float:left;border-radius:0px 5px 5px 8px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span style='font-size:24px;vertical-align:middle;color:orange;'>&#128219;</span> Out of stock</button>";
                                }
                            } else {
                                if($USER_LANG == "FR"){
                                    echo "<button class='".$action_class."' onclick='" . $ACTION . "' style='min-height:50px;margin:0px;float:left;border-radius:0px 5px 5px 8px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn2_icon"] . "</span><br>" . $row["web_btn2_fr"] . "</span></button>";
                                }else{
                                    echo "<button class='".$action_class."' onclick='" . $ACTION . "' style='min-height:50px;margin:0px;float:left;border-radius:0px 5px 5px 8px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn2_icon"] . "</span><br>" . $row["web_btn2_en"] . "</span></button>";
                                }
                            }
                        } 
                        //echo " </td><td style='width:50%;min-width:20px;border:0px;text-align:right;background:rgba(255,255,255,0.9);border-bottom-right-radius:10px;'>"; 
                        switch ($row["btn_action1"]) {
                            case "WISH":
                                $ACTION = "dw3_wish_toogle(" . $row["id"]  . ",this);";
                            break;                            
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
                            if ($row["btn_action2"] == "NONE" || $row["btn_action2"] == ""){$btn_width = "100%";} else {$btn_width = "49%";}
                            if ($row["btn_action1"] != "SUBMIT" && $row["btn_action1"] != "LINK"){$action_class = "no-effect";} else {$action_class = "";}
                            if ($row["invTOT"] <= 0 && $row["qty_max_by_inv"] == 1 && $row["btn_action1"] == "CART" && $is_service == false){
                                if($USER_LANG == "FR"){
                                    echo "<button disabled class='".$action_class."' style='min-height:50px;margin:0px;float:right;border-radius:5px 0px 8px 5px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span style='font-size:24px;vertical-align:middle;color:orange;'>&#128219;</span> Rupture de stock</button>";
                                } else{
                                    echo "<button disabled class='".$action_class."' style='min-height:50px;margin:0px;float:right;border-radius:5px 0px 8px 5px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span style='font-size:24px;vertical-align:middle;color:orange;'>&#128219;</span> Out of stock</button>";
                                }
                            } else {
                                if ($row["btn_action1"]=="WISH"){
                                    $is_wished = false;
                                    foreach ($dw3_wish as $key=>$val){
                                        if (intval($dw3_wish[$key]) > 0 && substr($key,0,5)=="WISH_" && ltrim($key,"WISH_") == $row["id"]){
                                            $is_wished = true;
                                        }
                                    }
                                    if($USER_LANG == "FR"){ $button_trad = $row["web_btn_fr"];} else {$button_trad = $row["web_btn_en"];}
                                    if ($is_wished == true){
                                        echo "<button class='no-effect' onclick='" . $ACTION . "' style='min-height:50px;margin:0px;float:right;border-radius:5px 0px 8px 5px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span id='dw3_wish3_".$row["id"]."' style='font-size:24px;'>&#9829;</span><br>".$button_trad."</button>";
                                    } else {
                                        echo "<button class='no-effect'onclick='" . $ACTION . "' style='min-height:50px;margin:0px;float:right;border-radius:5px 0px 8px 5px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span id='dw3_wish3_".$row["id"]."' style='font-size:24px;'>&#9825;</span><br>".$button_trad."</button>";
                                    }
                                } else {
                                    if($USER_LANG == "FR"){
                                        echo "<button class='".$action_class."' onclick='" . $ACTION . "' style='min-height:50px;margin:0px;float:right;border-radius:5px 0px 8px 5px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span class='dw3_font' style='font-size:24px;vertical-align:middle;'> " . $row["web_btn_icon"] . "</span><br>" . $row["web_btn_fr"] . "</button>";
                                    }else{
                                        echo "<button class='".$action_class."' onclick='" . $ACTION . "' style='min-height:50px;margin:0px;float:right;border-radius:5px 0px 8px 5px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span class='dw3_font' style='font-size:24px;vertical-align:middle;'> " . $row["web_btn_icon"] . "</span><br>" . $row["web_btn_en"] . "</button>";
                                    }
                                }
                            }
                        }   
                        
                        echo "</td></tr></table></div>";
                }
            } else {
                //echo "Aucun produit/service trouvé pour le moment.";
            }
        echo  "</div></div>";
    ?>
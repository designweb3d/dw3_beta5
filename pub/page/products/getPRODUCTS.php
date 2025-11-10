<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';

$FIND = strtolower($_GET['SS']);
$OFFSET  = $_GET['OFFSET'];
$SUBS_COUNT  = trim($_GET['SUBS']);
$LIMIT  = $_GET['LIMIT'];
if ($OFFSET == ""){
	$OFFSET = "0";	
}
if ($LIMIT == "" || $LIMIT == "0"){
	$LIMIT = "24";	
}

//description categorie actuelle
if (trim(strtolower($cat_lst)) != "" && trim(strtolower($cat_lst)) != "promo" && trim(strtolower($cat_lst)) != "all"){
    $sql = "SELECT * FROM product_category WHERE id IN ('" . $cat_lst. "');";
        $result = mysqli_query($dw3_conn, $sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($USER_LANG == "FR" && $row["description_fr"] !=""){
                    echo "<div class='dw3_page' style='width:96%;line-height:1.2;text-align:left;padding:5px 2%;border-left:4px solid #".$CIE_COLOR7.";'>";
                    echo "<b>".$row["name_fr"]."</b><br>";
                    echo "".$row["description_fr"]."";
                    echo "</div><br>";
                } else if ($USER_LANG == "EN" && $row["description_fr"] !="") {
                    echo "<div class='dw3_page' style='width:96%;line-height:1.2;text-align:left;padding:5px 2%;border-left:4px solid #".$CIE_COLOR7.";'>";
                    echo "<b>".$row["name_en"]."</b><br>";
                    echo "".$row["description_en"]."";
                    echo "</div><br>";
                }
            }
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

                     echo "<div style='background:#f0f0f0;color:#333;border:1px solid #444;margin:10px 6px; box-shadow: 0px 0px 4px 2px rgba(0,0,0,0.5);max-width:170px;width:170px;display:inline-block;height:250;border-radius:12px;'>
                     <table class='hoverShadow' style='line-height:1;border-collapse: collapse;border:0px;width:100%;min-height:100%;margin-right:auto;margin-left:auto;display:inline-block;border-radius:10px;'>";
                 //image                           
                      echo "<tr style='padding:0px;border:0px;' onclick=\"getPRDS(". $row["id"] . ",'". $PAGE_ID . "');\">"
                            . "<td colspan=2 style='border-top-right-radius:10px;border-top-left-radius:10px;cursor:pointer;text-align:center;padding:0px 0px 0px 0px;'><div style=\"border-top-right-radius:10px;border-top-left-radius:10px;width:170px;height:170px;background-image:url('".$filename."?t=" . $RNDSEQ . "');background-position: bottom center;background-repeat: no-repeat;background-size:cover;\"> </div></td></tr>";
                
                 //description    
                 if($USER_LANG == "FR"){         
                      echo "<tr style='padding:0px;border:0px;' onclick=\"getPRDS(". $row["id"] . ",'". $PAGE_ID . "');\">"
                            . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;height:70px;width:170px;font-size:16px;'>". $row["name_fr"] . "</td></tr>";
                 }else {
                    echo "<tr style='padding:0px;border:0px;' onclick=\"getPRDS(". $row["id"] . ",'". $PAGE_ID . "');\">"
                    . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;height:70px;width:170px;font-size:16px;'>". $row["name_en"] . "</td></tr>";
                }
                 
                 echo "</table></div>";
             }
         } 
         echo "</div><br>";
}


//ROW COUNT
$sql = "SELECT COUNT(*) as rowCount
    FROM product A
    WHERE A.stat = 0 AND A.web_dsp = 1 ";
    if ($cat_lst != "" && trim(strtolower($cat_lst)) != "promo" && trim(strtolower($cat_lst)) != "all") {
        if (trim($FIND) != ""){
            $sql .= " AND A.category_id IN (".$cat_lst.") AND LOWER(CONCAT(A.name_fr,A.name_en,A.description_fr,A.model,A.brand)) LIKE '%".$FIND."%' ";
            $sql .= " OR A.stat = 0 AND A.web_dsp = 1 AND A.category2_id IN (".$cat_lst.") AND LOWER(CONCAT(A.name_fr,A.name_en,A.description_fr,A.model,A.brand)) LIKE '%".$FIND."%' ";
            $sql .= " OR A.stat = 0 AND A.web_dsp = 1 AND A.category3_id IN (".$cat_lst.") AND LOWER(CONCAT(A.name_fr,A.name_en,A.description_fr,A.model,A.brand)) LIKE '%".$FIND."%' ";
        } else{
            $sql .= " AND A.category_id IN (".$cat_lst.") ";
            $sql .= " OR A.stat = 0 AND A.web_dsp = 1 AND A.category2_id IN (".$cat_lst.") ";
            $sql .= " OR A.stat = 0 AND A.web_dsp = 1 AND A.category3_id IN (".$cat_lst.") ";
        }
    } else if (trim(strtolower($cat_lst)) == "promo"){
        if (trim($FIND) != ""){
            $sql .= " AND A.promo_expire > CURRENT_TIMESTAMP() AND LOWER(CONCAT(A.name_fr,A.name_en,A.description_fr,A.model,A.brand)) LIKE '%".$FIND."%' ;";
        } else {
            $sql .= " AND A.promo_expire > CURRENT_TIMESTAMP() ;";
        }
    } else {
        $sql .= " AND LOWER(CONCAT(A.name_fr,A.name_en,A.description_fr,A.model,A.brand)) LIKE '%".$FIND."%' ";
    }
    $result = mysqli_query($dw3_conn, $sql);
    $data = mysqli_fetch_assoc($result);
    $numrows = $data['rowCount'];

/*    $sql = "SELECT A.*,IFNULL(D.total,0) AS invTOT,B.name_fr as category_name_fr
    FROM product A
    LEFT JOIN (SELECT id, name_fr,name_en,parent_name FROM product_category) B ON A.category_id = B.id
   LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) D ON A.id = D.product_id
   WHERE A.stat = 0 AND A.web_dsp = 1 ";
   if ($cat_lst != "" && trim(strtolower($cat_lst)) != "promo" && trim(strtolower($cat_lst)) != "all") {
    $sql .= " AND A.category_id IN (".$cat_lst.") ";
    $sql .= " OR A.stat = 0 AND A.web_dsp = 1 AND A.category2_id IN (".$cat_lst.") ";
    $sql .= " OR A.stat = 0 AND A.web_dsp = 1 AND A.category3_id IN (".$cat_lst.") ";
    $sql .= " ORDER BY A.name_fr ASC LIMIT 500";
   } else if (trim(strtolower($cat_lst)) == "promo"){
       $sql .= " AND A.promo_expire > CURRENT_TIMESTAMP()
       ORDER BY A.promo_price ASC, A.id DESC";
   } else {
       $sql.=" ORDER BY A.name_fr ASC LIMIT 500 ";
   }
   $cat_name = ""; */

   $sql = "SELECT A.*,IFNULL(D.total,0) AS invTOT,B.name_fr as category_name_fr, B.name_en as category_name_en,B.description_fr as category_desc_fr, B.description_en as category_desc_en
   FROM product A
   LEFT JOIN (SELECT id, name_fr,name_en,description_fr,description_en,parent_name FROM product_category) B ON A.category_id = B.id
   LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) D ON A.id = D.product_id
   WHERE A.stat = 0 AND A.web_dsp = 1 ";
    if ($cat_lst != "" && trim(strtolower($cat_lst)) != "promo" && trim(strtolower($cat_lst)) != "all") {
       if (trim($FIND) != ""){
           $sql .= " AND A.category_id IN (".$cat_lst.") AND LOWER(CONCAT(A.name_fr,A.name_en,A.description_fr,A.model,A.brand)) LIKE '%".$FIND."%' ";
           $sql .= " OR A.stat = 0 AND A.web_dsp = 1 AND A.category2_id IN (".$cat_lst.") AND LOWER(CONCAT(A.name_fr,A.name_en,A.description_fr,A.model,A.brand)) LIKE '%".$FIND."%' ";
           $sql .= " OR A.stat = 0 AND A.web_dsp = 1 AND A.category3_id IN (".$cat_lst.") AND LOWER(CONCAT(A.name_fr,A.name_en,A.description_fr,A.model,A.brand)) LIKE '%".$FIND."%' ";
       } else{
           $sql .= " AND A.category_id IN (".$cat_lst.") ";
           $sql .= " OR A.stat = 0 AND A.web_dsp = 1 AND A.category2_id IN (".$cat_lst.") ";
           $sql .= " OR A.stat = 0 AND A.web_dsp = 1 AND A.category3_id IN (".$cat_lst.") ";
       }
    } else if (trim(strtolower($cat_lst)) == "promo"){
       if (trim($FIND) != ""){
           $sql .= " AND A.promo_expire > CURRENT_TIMESTAMP() AND LOWER(CONCAT(A.name_fr,A.name_en,A.description_fr,A.model,A.brand)) LIKE '%".$FIND."%' ";
       } else {
           $sql .= " AND A.promo_expire > CURRENT_TIMESTAMP() ";
       }
    } else {
        $sql .= " AND LOWER(CONCAT(A.name_fr,A.name_en,A.description_fr,A.model,A.brand)) LIKE '%".$FIND."%' ";
    }
    if ($USER_LANG == "FR"){
        $sql .= " ORDER BY category_name_fr ASC, A.name_fr ASC ";
    } else {
        $sql .= " ORDER BY category_name_en ASC, A.name_en ASC ";
    }
   $sql = $sql . " LIMIT " . $LIMIT . " OFFSET " . $OFFSET . ";";
    $last_cat_name = "";
   //echo $sql;
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
                    if ($USER_LANG == "FR"){
                        if ($row["category_name_fr"] != $last_cat_name){
                            $last_cat_name = $row["category_name_fr"];
                            echo "<a href='/pub/page/products/index.php?P1=".$row["category_id"]."'><h4 style='padding:10px;color:#".$CIE_COLOR7.";background-color:transparent;background-image: linear-gradient(125deg, #".$CIE_COLOR6.",#".$CIE_COLOR6_2.");vertical-align:middle;text-align:left;'><u>".$row["category_name_fr"]."</u> &#11106;</h4></a>";
/*                             if ($row["category_desc_fr"] != ""){
                                //echo "<br><div class='dw3_box' style='max-width:600px;'>".$row["category_desc_fr"]."</div><br>";
                                echo "<br><div class='dw3_page' style='line-height:1.2;text-align:left;padding-left:5px;border-left:4px solid #".$CIE_COLOR7.";'>";
                                echo "<b>".$row["name_fr"]."</b><br>";
                                echo "".$row["description_fr"]."";
                                echo "</div><br>";
                            } */
                        }
                    } else {
                        if ($row["category_name_en"] != $last_cat_name){
                            $last_cat_name = $row["category_name_en"];
                            echo "<a href='/pub/page/products/index.php?P1=".$row["category_id"]."'><h4 style='padding:10px;color:#".$CIE_COLOR7.";background-color:transparent;background-image: linear-gradient(125deg, #".$CIE_COLOR6.",#".$CIE_COLOR6_2.");vertical-align:middle;text-align:left;'><u>".$row["category_name_en"]."</u> &#11106;</h4></a>";
/*                             if ($row["category_desc_en"] != ""){
                                //echo "<br><div class='dw3_box' style='max-width:600px;'>".$row["category_desc_en"]."</div><br>";
                                echo "<br><div class='dw3_page' style='line-height:1.2;text-align:left;padding-left:5px;border-left:4px solid #".$CIE_COLOR7.";'>";
                                echo "<b>".$row["name_en"]."</b><br>";
                                echo "".$row["description_en"]."";
                                echo "</div><br>";
                            } */
                        }
                    }
                    //product div
                    echo "<div style='margin:5px;border:0px solid #444; display:inline-block;border-radius:10px;'>
                            <table class='hoverShadow' style='line-height:1;border-collapse: collapse;border:0px;width:100%;min-height:100%;margin-right:auto;margin-left:auto;min-width:300px;color:#".$CIE_COLOR4.";background-color:#".$CIE_COLOR3.";border-radius:10px;'>
                            <tr onclick='getPRD(". $row["id"] . ");'  style='cursor:pointer;padding:0px;border:0px;border-top-right-radius:10px;border-top-left-radius:10px;' >";
                            if($USER_LANG == "FR"){
                                echo "<td colspan=2 style='white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width:300px;text-align:center;padding:4px 0px 4px 0px;border-top-right-radius:10px;border-top-left-radius:10px;'><strong>". $row["name_fr"] ."</strong></td></tr>";
                            } else {
                                echo "<td colspan=2 style='white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width:300px;text-align:center;padding:4px 0px 4px 0px;border-top-right-radius:10px;border-top-left-radius:10px;'><strong>". $row["name_en"] ."</strong></td></tr>";
                            }
                        //image                           
                             echo "<tr style='padding:0px;border:0px;' onclick='getPRD(". $row["id"] . ");'>"
                                   . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 5px 0px;'><div style=\"width:300px;height:300px;background-image:url('".$filename."');background-position: center center;background-repeat: no-repeat;background-size:cover;\"> </div></td></tr>";
                        //prix
                        $date_promo = new DateTime($row["promo_expire"]);
                        $now = new DateTime();
                        if($date_promo > $now) {
                            //prix promo
                            //echo "<tr><td style='font-family:" .$CIE_FONT2. ";'><span class='material-icons' style='color:gold;text-shadow:1px 1px 2px goldenrod;'>new_releases</span> <strong>". number_format($row["promo_price"],2,"."," ").$row["price_suffix_fr"]."</strong></td>";
                           //echo "<td style='vertical-align:top;font-family:" .$CIE_FONT2. ";'><span style='text-decoration: line-through;text-decoration-thickness: 2px;'>" . number_format($row["price1"],2,"."," ") . $row["price_suffix_fr"]."</span></td></tr>";
                           //echo "<tr><td colspan='2'><span style='font-size:11px;font-family:" .$CIE_FONT2. ";'>Jusqu'au: " . substr($row["promo_expire"],0,10) . "</span></td></tr>";
                           if($USER_LANG == "FR"){
                            if ( trim($row["price_text_fr"]) == "") {
                                echo "<tr style='height:35px;'><td style='border:0px;padding-top:5px;padding-bottom:13px;'>&#128293; <strong>". number_format($row["promo_price"],2,"."," ").$row["price_suffix_fr"]."</strong></td>";
                            } else {
                                echo "<tr style='height:35px;'><td style='border:0px;padding-top:5px;padding-bottom:5px;'><strong>". $row["price_text_fr"]."</strong></td>";
                            }
                            echo "<td style='vertical-align:top;'><span style='text-decoration: line-through;text-decoration-thickness: 2px;'>" . number_format($row["price1"],2,"."," ") . $row["price_suffix_fr"]."</span></td></tr>";
                            //echo "<tr><td colspan='2' style='font-size:14px;'><div style='height:24px;overflow:hidden;vertical-align:middle;'>Valide jusqu'au: " . substr($row["promo_expire"],0,10) . "</div></td></tr>";
                        }else{
                            if ( trim($row["price_text_en"]) == "") {
                                echo "<tr style='height:35px;'><td style='border:0px;padding-top:5px;padding-bottom:5px;'>&#128293; <strong>". number_format($row["promo_price"],2,"."," ").$row["price_suffix_en"]."</strong></td>";
                            } else {
                                echo "<tr style='height:35px;'><td style='border:0px;padding-top:5px;padding-bottom:5px;'><strong>". $row["price_text_en"]."</strong></td>";
                            }
                            echo "<td style='border:0px;padding-top:10px;padding-bottom:5px;'><span style='text-decoration: line-through;text-decoration-thickness: 2px;'>" . number_format($row["price1"],2,"."," ") . $row["price_suffix_en"]."</span></td></tr>";
                            //echo "<tr><td colspan='2' style='font-size:14px;'><div style='height:24px;overflow:hidden;vertical-align:middle;'>Valid until: " . substr($row["promo_expire"],0,10) . "</div></td></tr>";
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
                                if ($row["price2"] != 0 && $row["qty_min_price2"] >=2 && $line_price > $row["price2"]){
                                    $plitted = explode(".",number_format($row["price2"]*$row["qty_min_price2"],2,"."," "));
                                    $whole = $plitted[0]??round($row["price2"]*$row["qty_min_price2"],2);
                                    $fraction = $plitted[1]??0; 
                                        if ($fraction == 0){
                                        $fraction = "00";
                                    }else{
                                        $fraction = str_pad(rtrim($fraction, "0"), 2 , "0");
                                    }
                                    //prix2
                                    echo "<tr style='height:35px;'><td width='50%' style='border:0px;text-align:right;padding-right:5px;padding-top:10px;padding-bottom:13px;'><strong>".$row["qty_min_price2"]."</strong> pour <strong>". number_format($whole) . "<sup>" . $fraction . "$</sup>". "</strong></td>";
                                    echo "<td style='vertical-align:top;padding-top:10px;'><span style=''>" . number_format($row["price1"],2,"."," ") . "</span>".$row["price_suffix_fr"]."</td></tr>";
                                } //else {
                                    $plitted = explode(".",number_format($line_price,2,"."," "));
                                    $whole = $plitted[0];
                                    $fraction = $plitted[1]??0; 
                                    if ($fraction == 0){
                                        $fraction = "00";
                                    }else{
                                        $fraction = str_pad(rtrim($fraction, "0"), 2 , "0");
                                    }
                                    //prix1 
                                    echo "<tr style='height:35px;'><td width='50%' style='border:0px;text-align:right;padding-right:5px;padding-top:10px;padding-bottom:13px;'><strong>". number_format($whole) . ".<sup>" . $fraction . "</sup></strong></td><td style='text-align:left;border:0px;' width='50%'>". $row["price_suffix_fr"] . "</td></tr>";
                                    //echo "<tr><td colspan='2'><span style='font-size:11px;'> </span></td></tr>";
                                //}
                            } else { 
                                //texte au lieu du prix
                                if (trim($row["price_text_fr"]) != ""){
                                    echo " <tr style='height:35px;'><td colspan=2 style='border:0px;text-align:center;padding-right:5px;padding-top:10px;padding-bottom:13px;'><strong>". $row["price_text_fr"] . "</strong></td></tr>";
                                }
                                //echo "<tr><td colspan='2'><span style='font-size:11px;'> </span></td></tr>";
                            }
                        } 

                        echo "<tr style='border-bottom-right-radius:10px;border-bottom-left-radius:10px;'><td colspan=2 style='border:0px;border-bottom-left-radius:10px;border-bottom-right-radius:10px;'>";
                        switch ($row["btn_action2"]) {
                            case "DOWNLOAD":
                                $ACTION = "dw3_download('" . $row["id"]  . "','" . $row["url_action2"]  . "',this);";
                            break;
                            case "INFO":
                                $ACTION = "getPRD('" . $row["id"]  . "');";
                            break;
                            case "SUBMIT":
                                $ACTION = "dw3_action_submit(" . $row["id"]  . ",this);";
                            break;
                            case "CART":
                                $ACTION = "dw3_cart_add(" . $row["id"]  . ",this);";
                            break;
                            case "LINK":
                                if (substr($row["url_action2"],0,1)=="/"){
                                    $ACTION = "dw3_page_open('" . $row["url_action2"]  . "','_self');";
                                } else {
                                    $ACTION = "dw3_page_open('" . $row["url_action2"]  . "','_blank');";
                                }
                            break;
                            case "BUY":
                                $ACTION = "dw3_cart_add(" . $row["id"]  . ",this);";
                            break;
                            case "SUBSCRIBE":
                                $ACTION = "dw3_subscribe(" . $row["id"]  . ",this);";
                                break;
                            default:
                                $ACTION = "";
                        }
                        if ($row["btn_action2"] != "NONE" && $row["btn_action2"] != ""){
                            if ($row["btn_action1"] == "NONE" || $row["btn_action1"] == ""){$btn_width = "100%";} else {$btn_width = "49%";}
                            if ($row["invTOT"] <= 0 && $row["qty_max_by_inv"] == 1 && $row["btn_action2"] == "CART"){
                                if($USER_LANG == "FR"){
                                    echo "<button class='no-effect' disabled style='min-height:77px;margin:0px;float:left;border-radius:0px 5px 5px 8px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'>&#128219;<br>Rupture de stock</button>";
                                } else{
                                    echo "<button class='no-effect' disabled style='min-height:77px;margin:0px;float:left;border-radius:0px 5px 5px 8px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'>&#128219;<br>Out of stock</button>";
                                }
                            } else {
                                if($USER_LANG == "FR"){
                                    echo "<button class='no-effect' onclick=\"" . $ACTION . "\" style='min-height:77px;margin:0px;float:left;border-radius:0px 5px 5px 8px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn2_icon"] . "</span><br><span>" . $row["web_btn2_fr"] . "</span></button>";
                                } else {
                                    echo "<button class='no-effect' onclick=\"" . $ACTION . "\" style='min-height:77px;margin:0px;float:left;border-radius:0px 5px 5px 8px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn2_icon"] . "</span><br><span>" . $row["web_btn2_en"] . "</span></button>";
                                }
                            }
                        } 
                        //echo " </td><td style='min-width:20px;border:0px;text-align:right;'>"; 
                        switch ($row["btn_action1"]) {
                            case "WISH":
                                $ACTION = "dw3_wish_toogle(" . $row["id"]  . ",this);";
                                break; 
                            case "DOWNLOAD":
                                $ACTION = "dw3_download('" . $row["id"]  . "','" . $row["url_action1"]  . "',this);";
                                break;
                            case "INFO":
                                $ACTION = "getPRD('" . $row["id"]  . "');";
                                break;
                            case "SUBMIT":
                                $ACTION = "dw3_action_submit(" . $row["id"]  . ",this);";
                                break;
                            case "CART":
                                $ACTION = "dw3_cart_add(" . $row["id"]  . ",this);";
                                break;
                            case "LINK":
                                if (substr($row["url_action1"],0,1)=="/"){
                                    $ACTION = "dw3_page_open('" . $row["url_action1"]  . "','_self');";
                                } else {
                                    $ACTION = "dw3_page_open('" . $row["url_action1"]  . "','_blank');";
                                }
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
                        if ($row["btn_action1"] != "NONE" && $row["btn_action1"] != ""){
                            if ($row["btn_action2"] == "NONE" || $row["btn_action2"] == ""){$btn_width = "100%";} else {$btn_width = "49%";}
                            $is_service = true;
                            if ($row["billing"] == "FINAL" || $row["billing"] == "LOCATION"){
                                $is_service = false;
                            }
                            if ($row["invTOT"] <= 0 && $row["qty_max_by_inv"] == 1 && $row["btn_action1"] == "CART" && $is_service == false){
                                if($USER_LANG == "FR"){
                                    echo "<button class='no-effect' disabled style='min-height:77px;margin:0px;float:right;border-radius:5px 0px 8px 5px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span style='font-size:24px;vertical-align:middle;color:orange;'>&#9888;</span><br>Rupture de stock</button>";
                                } else{
                                    echo "<button class='no-effect' disabled style='min-height:77px;margin:0px;float:right;border-radius:5px 0px 8px 5px;box-shadow:none;width:".$btn1_width.";max-width:".$btn_width.";'><span style='font-size:24px;vertical-align:middle;color:orange;'>&#9888;</span><br>Out of stock</button>";
                                }
                            } else {
                                if ($row["btn_action1"]=="WISH"){
                                    $is_wished = false;
                                    foreach ($dw3_wish as $key=>$val){
                                        if (intval($dw3_wish[$key]) > 0 && substr($key,0,5)=="WISH_" && ltrim($key,"WISH_") == $row["id"]){
                                            $is_wished = true;
                                        }
                                    }
                                    if ($is_wished == true){
                                        if($USER_LANG == "FR"){ $button_trad = $row["web_btn_fr"];} else {$button_trad = $row["web_btn_en"];}
                                        echo "<button class='no-effect' onclick=\"" . $ACTION . "\" style='min-height:77px;margin:0px;float:right;border-radius:5px 0px 8px 5px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span id='dw3_wish3_".$row["id"]."' style='font-size:24px;'>&#9829;</span><br>".$button_trad."</button>";
                                    } else {
                                        echo "<button class='no-effect' onclick=\"" . $ACTION . "\" style='min-height:77px;margin:0px;float:right;border-radius:5px 0px 8px 5px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span id='dw3_wish3_".$row["id"]."' style='font-size:24px;'>&#9825;</span><br>".$button_trad."</button>";
                                    }
                                } else {
                                    if($USER_LANG == "FR"){
                                        echo "<button class='no-effect' onclick=\"" . $ACTION . "\" style='min-height:77px;margin:0px;float:right;border-radius:5px 0px 8px 5px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn_icon"] . "</span><br><span>" . $row["web_btn_fr"] . "</span></button>";
                                    } else {
                                        echo "<button class='no-effect' onclick=\"" . $ACTION . "\" style='min-height:77px;margin:0px;float:right;border-radius:5px 0px 8px 5px;box-shadow:none;width:".$btn_width.";max-width:".$btn_width.";'><span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn_icon"] . "</span><br><span>" . $row["web_btn_en"] . "</span></button>";
                                    }
                                }
                            }
                        }   
                        
                        echo "</td></tr></table></div>";
                }
                echo "<br><div class='divBOX' style='display:inline-block;margin:10px 0px 0px 0px;min-height:0px;width:auto;text-align:center;'>";
                //FIRST PAGE
                if ($OFFSET > 0){
                   echo "<button class='no-effect blue' style='font-size:20px;' onclick='getPRODUCTS(\"\",\"" . $LIMIT . "\");'><span class='dw3_font'>ļ</span></button>";
                } else {
                   echo "<button class='no-effect' style='font-size:20px;' disabled style='background:#777;color:#DDD;'><span class='dw3_font'>ļ</span></button>";
                }
                //PREVIOUS PAGE
                if ($OFFSET > 0){
                    $page = $OFFSET-$LIMIT;
                    if ($page<0){$page=0;}
                   echo "<button class='no-effect green' style='font-size:20px;' onclick='getPRODUCTS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='dw3_font'>ĸ</span></button>";
                } else {
                   echo "<button class='no-effect' style='font-size:20px;' disabled style='background:#777;color:#DDD;'><span class='dw3_font'>ĸ</span></button>";
                }
                //CURRENT PAGE
                if ($numrows <= $LIMIT){
                    $page_rows = $numrows;
                } else {
                    if ($OFFSET+$LIMIT < $numrows){
                        $page_rows = $OFFSET+$LIMIT;
                    } else {
                        $page_rows = $numrows;  
                    }
                }
               echo "<span style='font-size:18px;margin:10px;padding:15px 10px;border-radius:20px;background:rgba(255,255,255,0.8);color:black;'><b>" . $page_rows 
                . "</b>/<b>" . $numrows
                . "</b></span>";
/*                echo "<span style='font-size:10px;margin:7px;'><b style='font-size:14px;'>" . ceil(($OFFSET/$LIMIT)+1) 
                . "</b>/<b>" . ceil($numrows/$LIMIT)
                . "</b></span>"; */
                //NEXTPAGE
                if (($OFFSET+$LIMIT) < ($numrows)){
                    $page = $OFFSET+$LIMIT;
                   echo "<button class='no-effect green' style='font-size:20px;' onclick='getPRODUCTS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='dw3_font'>Ĺ</span></button>";
                } else {
                   echo "<button class='no-effect' style='font-size:20px;' disabled style='background:#777;color:#DDD;'><span class='dw3_font'>Ĺ</span></button>";
                }
                //LASTPAGE
                if (($OFFSET+$LIMIT) < ($numrows)){
                    $lastpage = $numrows-$LIMIT;
                   echo "<button class='no-effect blue' style='font-size:20px;' onclick='getPRODUCTS(\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='dw3_font'>Ľ</span></button>";
                } else {
                   echo "<button class='no-effect' style='font-size:20px;' disabled style='background:#777;color:#DDD;'><span class='dw3_font'>Ľ</span></button>";
                }
                echo "</div><br>";
                //echo $sql;
            //} else if ($SUBS_COUNT == "0"){
            } else if ($sub_cats_count==0){
/*                 if (trim(strtolower($cat_lst)) != "" && trim(strtolower($cat_lst)) != "promo" && trim(strtolower($cat_lst)) != "all"){
                    $sql = "SELECT * FROM product_category WHERE id IN ('" . $cat_lst. "');";
                        $result = mysqli_query($dw3_conn, $sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                if ($USER_LANG == "FR"){
                                    echo "<div class='dw3_page' style='line-height:1.2;text-align:left;padding-left:5px;border-left:4px solid #".$CIE_COLOR7.";'>";
                                    echo "<b>".$row["name_fr"]."</b><br>";
                                    echo "".$row["description_fr"]."";
                                    echo "</div><br>";
                                } else {
                                    echo "<div class='dw3_page' style='line-height:1.2;text-align:left;padding-left:5px;border-left:4px solid #".$CIE_COLOR7.";'>";
                                    echo "<b>".$row["name_en"]."</b><br>";
                                    echo "".$row["description_en"]."";
                                    echo "</div><br>";
                                }
                            }
                        }
                } */
/*                 if ($USER_LANG == "FR"){
                    echo "<div class='dw3_box' style='text-align:center;min-height:0px;'>Revenez souvent: site en évolution! De nouveaux produits seront ajoutés sous peu.</div>";
                } else {
                    echo "<div class='dw3_box' style='text-align:center;min-height:0px;'>Check back often new products being added very soon.</div>";
                } */
            }
            if ($USER_LANG == "FR"){
                echo "<div class='dw3_box' style='text-align:center;min-height:0px;'>Revenez souvent: site en évolution! De nouveaux produits seront ajoutés sous peu.</div>";
            } else {
                echo "<div class='dw3_box' style='text-align:center;min-height:0px;'>Check back often new products being added very soon.</div>";
            }
?>
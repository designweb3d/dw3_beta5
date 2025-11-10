<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';

if($USER_LANG == "FR"){
    $lbl1 = "Mes favoris";
    $lbl2 = "Ajouter au panier";
}else{
    $lbl1 = "My favorites";
    $lbl2 = "Add to cart";
}
$QTY_ROWS = 0;

//CART
$dw3_cart_string = "";
$dw3_cart=array();
foreach ($_COOKIE as $key=>$val)
{
    if (substr($key, 0, 5) == "WISH_" && $val != "0"){
    $dw3_cart[$key] = intval($dw3_cart[$key]??0) + intval($val);
    //echo "key: ". $key . "; dw3_cart[key]:".$dw3_cart[$key]. " ; value: ". $val. " calc=" . round($dw3_cart[$key] + $val);
    //$dw3_cart_string .= ltrim($key,"CART_") . ",";
    }
}

foreach ($dw3_cart as $key=>$val)
{
    if (intval($dw3_cart[$key]) > 0){
        $dw3_cart_string .= ltrim($key,"WISH_") . ",";
    }
}
$dw3_cart_string = rtrim($dw3_cart_string,",");

if ($dw3_cart_string != "") {  
    $sql = "SELECT  A.*, IFNULL(B.total,0) AS invTOT 
            FROM product A
            LEFT JOIN (SELECT product_id, SUM(round(quantity)) AS total FROM transfer GROUP BY product_id) B ON A.id = B.product_id
            WHERE stat = 0 AND web_dsp = 1 AND id IN (" . $dw3_cart_string . ") 
            ORDER BY price1 ASC, id DESC";
    //die($sql);
    $result = $dw3_conn->query($sql);
    $QTY_ROWS = $result->num_rows??0;
}
    echo "<div class='dw3_form_head' id='dw3_cart_HEAD'>
    <h2 style='vertical-align:middle;height:40px;font-size:1em;'><div style='display: grid;align-items: center;height:40px;'>".$lbl1."</div></h2>
    <button class='dw3_form_close no-effect white' onclick='dw3_cart_close();' style='padding:5px;'><span class='dw3_font' style='font-size:20px;'>ď</span></button>
    </div>
        <div class='dw3_form_data' style='background:#EEE;color:#333;'>";
        
        if ($QTY_ROWS > 0) {
            //echo $sql;
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

        echo "<div style='font-family:var(--dw3_form_font);display:inline-block;background:rgba(255,255,255,0.7);padding:10px;margin:12px;border-radius:7px;max-width:330px;box-shadow: inset 0px 0px 5px #777;'>
                <button class='red no-effect' style='float:left;margin:-15px;padding:4px 3px 3px 3px;border-radius:15px;' onclick=\"deleteOneWish('".$row["id"] ."')\"><span class='dw3_font' style='font-size:20px;'>ď</span></button>
                    <table style='width:330px;white-space:wrap;margin-right:auto;margin-left:auto;font-family:var(--dw3_table_font);margin-top:10px;'>
                        <tr onclick=\"getPRD('". $row["id"] . "');\">";
                        if($USER_LANG == "FR"){ 
                            echo "<td style='text-align:center;height:54px;vertical-align:middle;cursor:pointer;'><b>". strtoupper($row["name_fr"]) ."</b></td></tr>";
                        }else{
                            echo "<td style='text-align:center;height:54px;vertical-align:middle;cursor:pointer;'><b>". strtoupper($row["name_en"]) ."</b></td></tr>";
                        }                            
                        echo "<tr onclick=\"getPRD('". $row["id"] . "');\">"
                        . "<td style='text-align:center;height:110px;vertical-align:middle;cursor:pointer;'><img class='photo' style='height:200px;width:auto;max-width:100%;' src='" . $filename . "' onerror='this.onerror=null; this.src=\"./pub/img/nd.png\";'></td></tr>";
                        
                echo "</table>";
                //if ($INDEX_CART=="true"){
                   // echo "<button onclick='dw3_cart_add(".$row["id"].");'><span  style='font-size:20px;vertical-align:middle;'>add_shopping_cart</span> ".$lbl2."</button>";
                //}
                switch ($row["btn_action1"]) {
                    case "DOWNLOAD":
                        $ACTION = 'dw3_download("' . $row["id"]  . '","' . $row["url_action1"]  . '",this);';
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
                $is_service = true;
                if ($row["billing"] == "FINAL" || $row["billing"] == "LOCATION"){
                    $is_service = false;
                }
                if ($row["btn_action1"] != "NONE" && $row["btn_action1"] != ""){
                    if ($row["invTOT"] <= 0 && $row["qty_max_by_inv"] == 1 && $row["btn_action1"] == "CART" && $is_service == false){
                        if($USER_LANG == "FR"){
                            echo "<button class='no-effect' disabled style='border-bottom-left-radius:10px;'><span style='font-size:24px;vertical-align:middle;color:orange;'>&#10071;</span> Rupture de stock</button>";
                        } else{
                            echo  "<button class='no-effect' disabled style='border-bottom-left-radius:10px;'><span style='font-size:24px;vertical-align:middle;color:orange;'>&#10071;</span> Out of stock</button>";
                        }
                    } else if ($row["btn_action1"] == "CART"){
                        if($USER_LANG == "FR"){
                            echo  "<button class='no-effect' style='' onclick='" . $ACTION . "'>" . $row["web_btn_fr"] . " <span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn_icon"] . "</span></button>";
                        }else{
                            echo  "<button class='no-effect' style='' onclick='" . $ACTION . "'>" . $row["web_btn_en"] . " <span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn_icon"] . "</span></button>";
                        }
                    } else {
                        if ($row["btn_action2"] == "INFO"){
                            if($USER_LANG == "FR"){
                                echo  "<button class='no-effect' style='' onclick='getPRD(" . $row["id"]  . ");'>" . $row["web_btn2_fr"] . " <span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn2_icon"] . "</span></button>";
                            }else{
                                echo  "<button class='no-effect' style='' onclick='getPRD(" . $row["id"]  . ");'>" . $row["web_btn2_en"] . " <span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn2_icon"] . "</span></button>";
                            }
                        }
                    }
                } else {
                    if ($row["btn_action2"] == "INFO"){
                        if($USER_LANG == "FR"){
                            echo  "<button class='no-effect' style='' onclick='getPRD(" . $row["id"]  . ");'>" . $row["web_btn2_fr"] . " <span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn2_icon"] . "</span></button>";
                        }else{
                            echo  "<button class='no-effect' style='' onclick='getPRD(" . $row["id"]  . ");'>" . $row["web_btn2_en"] . " <span class='dw3_font' style='font-size:24px;vertical-align:middle;'>" . $row["web_btn2_icon"] . "</span></button>";
                        }
                    }
                }
                echo "</div>";
        }
        
    }


//ADS
$QTY_ROWS = 0;
$dw3_ad_string = "";
//$dw3_ad=array();
foreach ($_COOKIE as $key=>$val)
{
    if (substr($key, 0, 5) == "WISH2" && $val != "0"){
    //$dw3_ad[$key] = intval($dw3_ad[$key]??0) + intval($val);
    //echo $dw3_ad[$key];
    //echo "key: ". $key . "; dw3_ad[key]:".$dw3_ad[$key]. " ; value: ". $val. " calc=" . round($dw3_ad[$key] + $val);
    //$dw3_ad_string .= ltrim($key,"CART_") . ",";
    //$dw3_ad_string .= ltrim($key,"WISH2_") . ",";
    $dw3_ad_string .= substr($key,6,strlen($key)-6) . ",";
    }
}

/* foreach ($dw3_ad as $key=>$val)
{
    if (intval($dw3_ad[$key]) > 0){
        $dw3_ad_string .= ltrim($key,"WISH2_") . ",";
    }
} */
$dw3_ad_string = rtrim($dw3_ad_string,",");
//echo $dw3_ad_string;
if ($dw3_ad_string != "") {  
    $sql = "SELECT A.*, B.company FROM classified A
    LEFT JOIN (SELECT id as retailer_id, company FROM customer) B ON A.customer_id = B.retailer_id
    WHERE id IN (" . $dw3_ad_string . ") ORDER BY price ASC";
    //die($sql);
    $result = $dw3_conn->query($sql);
    $QTY_ROWS = $result->num_rows??0;
}
        
        if ($QTY_ROWS > 0) {
            //echo $sql;
        while($row = $result->fetch_assoc()) {
            $RNDSEQ=rand(100,100000);
            $filename= $row["img_link"];
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename)){
                $filename = "/pub/img/dw3/nd.png";
            } else {
                if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $row["customer_id"] . "/" . $filename)){
                    $filename = "/pub/img/dw3/nd.png";
                }else{
                    $filename = "/fs/customer/" . $row["customer_id"] . "/" . $filename;
                }
            }

        echo "<div style='font-family:var(--dw3_form_font);display:inline-block;background:rgba(255,255,255,0.7);padding:3px;margin:12px;border-radius:7px;max-width:340px;box-shadow: inset 0px 0px 5px #777;'>
                <button  class='white no-effect' style='float:left;margin:-15px;padding:3px;border-radius:15px;' onclick=\"deleteOneWish2('".$row["id"] ."')\"><span class='dw3_font' style='font-size:20px;'>ď</span></button>
                    <table style='width:340px;white-space:wrap;margin-right:auto;margin-left:auto;font-family:var(--dw3_table_font);'>
                        <tr onclick=\"getAD('". $row["id"] . "');\">";
                        if($USER_LANG == "FR"){ 
                            echo "<td style='text-align:center;height:54px;vertical-align:middle;cursor:pointer;'><b>". strtoupper($row["name_fr"]) ."</b></td></tr>";
                        }else{
                            echo "<td style='text-align:center;height:54px;vertical-align:middle;cursor:pointer;'><b>". strtoupper($row["name_en"]) ."</b></td></tr>";
                        }                            
                        echo "<tr onclick=\"getAD('". $row["id"] . "');\">"
                        . "<td style='text-align:center;height:110px;vertical-align:middle;cursor:pointer;'><img class='photo' style='height:200px;width:auto;max-width:100%;' src='" . $filename . "' onerror='this.onerror=null; this.src=\"./pub/img/nd.png\";'></td></tr>";
                        
                echo "</table>";
                if ($INDEX_CART=="true"){
                    echo "<button onclick='buyAD(".$row["id"].");'><span style='font-size:20px;vertical-align:middle;'>&#128722;</span> ".$lbl2."</button>";
                }
                echo "</div>";
        }
        
    }

    if ($dw3_cart_string == "" && $dw3_ad_string == "") {
        if($USER_LANG == "FR"){ 
            echo "<div class='dw3_box' style='text-align:center;'><img src='/pub/img/dw3/empty_wish.jpg' style='width:100%;height:auto;'></div>
            <hr><h2 style='text-align:left;padding-left:10px;'>Votre liste de favoris est vide</h2>";
            if ($CIE_DIST_AD == "" || $CIE_DIST_AD == "false"){
                echo "<div style='text-align:left;padding-left:10px;'>On dirait que vous n’avez pas encore trouvé ce que vous cherchiez. <a href='/pub/page/products/index.php?KEY=". $KEY."&P1=all'> <button>Explorer les produits et services</button></a></div>";
            } else {
                echo "<div style='text-align:left;padding-left:10px;'>On dirait que vous n’avez pas encore trouvé ce que vous cherchiez. <a href='/pub/page/classifieds/index.php?KEY=". $KEY."'> <button>Explorer le marché</button></a></div>";
            }
        } else { 
            echo "<div class='dw3_box' style='text-align:center;'><img src='/pub/img/dw3/empty_wish.jpg' style='width:100%;height:auto;'></div>
            <hr><h3 style='text-align:left;padding-left:10px;'>Your wishlist is empty</h3>";
            if ($CIE_DIST_AD == "" || $CIE_DIST_AD == "false"){
                echo "<div style='text-align:left;padding-left:10px;'>Looks like you haven't found what you're looking for yet. <a href='/pub/page/products/index.php?KEY=". $KEY."&P1=all'> <button>Explore products and services</button></a></div>";
            } else {
                echo "<div style='text-align:left;padding-left:10px;'>Looks like you haven't found what you're looking for yet. <a href='/pub/page/classifieds/index.php?KEY=". $KEY."'> <button>Explore the market</button></a></div>";
            }        }
    }

    echo "</div><div style='height:40px;'></div><div class='dw3_form_foot' style=''>";				

        if($USER_LANG == "FR"){
            echo "<button class='no-effect grey' style='margin:0px 5px 0px 5px;' onclick=\"dw3_cart_close();\"><span class='dw3_font' style='font-size:24px;'>ď</span> Fermer </button>"; 
        }else{
            echo "<button class='no-effect grey' style='margin:0px 5px 0px 5px;' onclick=\"dw3_cart_close();\"><span class='dw3_font' style='font-size:24px;'>ď</span> Close </button>"; 
        }
 
    echo "</div>";
$dw3_conn->close();
die();
?>
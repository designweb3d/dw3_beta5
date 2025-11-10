<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';

$FIND = strtolower($_GET['SS']??"");
$OFFSET  = $_GET['OFFSET']??"";
$LIMIT  = $_GET['LIMIT']??"";
if ($OFFSET == ""){
	$OFFSET = "0";	
}
if ($LIMIT == "" || $LIMIT == "0"){
	$LIMIT = "10";	
}

//ROW COUNT
$sql = "SELECT COUNT(*) as rowCount FROM classified A
WHERE A.active = 1 AND A.qty_available > 0 ";
if (trim($FIND) != ""){
    $sql .= " AND LOWER(CONCAT(name_fr,name_en,description_fr,model,brand,year_production)) LIKE '%".$FIND."%' ";
}
if ($cat_lst != "" && trim(strtolower($cat_lst)) != "all") {
    $sql .= " AND A.category_id IN (".$cat_lst.") ;";
}
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$numrows = $data['rowCount'];

//classifieds
    $sql = "SELECT A.* FROM classified A 
    WHERE A.active = 1 AND A.qty_available > 0 ";
    if (trim($FIND) != ""){
        $sql .= " AND LOWER(CONCAT(name_fr,name_en,description_fr,model,brand,year_production)) LIKE '%".$FIND."%' ";
    }
    if ($cat_lst != "" && trim(strtolower($cat_lst)) != "all") {
        if ($USER_LANG == "FR"){
            $sql .= " AND A.category_id IN (".$cat_lst.") ORDER BY A.name_fr ASC";
        } else {
            $sql .= " AND A.category_id IN (".$cat_lst.") ORDER BY A.name_en ASC";
        }
    } else {
        if ($USER_LANG == "FR"){
            $sql.=" ORDER BY A.name_fr ASC ";
        } else {
            $sql.=" ORDER BY A.name_en ASC ";
        }
    }
   $sql = $sql . " LIMIT " . $LIMIT . " OFFSET " . $OFFSET . ";";

   $cat_name = "";
   //echo $sql;
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            $row_num = 0;
/*             if ($numrows ==1) {
                echo "<div class='dw3_box' style='font-size:14px;min-height:0px;background:rgba(255,255,255,0.8);color:black;text-align:center;'>"; if ($USER_LANG == "FR"){ echo "Une annonce trouvée selon la recherche."; }else{echo "One add found with this research.";} echo "</div><br>";            
            }else {
                echo "<div class='dw3_box' style='font-size:14px;min-height:0px;background:rgba(255,255,255,0.8);color:black;text-align:center;'>"; if ($USER_LANG == "FR"){ echo $numrows." annonces trouvées selon la recherche."; }else{echo $numrows." adds found with this research.";} echo "</div><br>";            
            } */
            echo "<div style='max-width:950px;width:95%;display:inline-block;text-align:center;border-radius:15px;'>";
            while($row = $result->fetch_assoc()) {
                $row_num++;
                if ($row_num % 2 == 0) {
                    $row_bg = "#eee";
                } else {
                    $row_bg = "#ccc";
                }
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
                        //image                           
                        echo "<table class='tblAD hoverShadow' style='width:100%;color:#333;'><tr style=''>"
                        . "<td width='100px' onclick='getAD(". $row["id"] . ");' style='cursor:pointer;text-align:center;padding:5px;'><img class='dw3_product_photo' style='width:90px;height:auto;' src='" . $filename . "?t=" . $RNDSEQ . "' onerror='this.onerror=null; this.src=\"./img/dw3/nd.png\";' alt='Image du produit: ". $row["name_fr"] . "'></td>";
                        //nom
                            if($USER_LANG == "FR"){
                                echo "<td onclick='getAD(". $row["id"] . ");' style='text-align:left;padding:4px 0px 4px 0px;'>". $row["name_fr"] ."</strong>";
                            } else {
                                echo "<td onclick='getAD(". $row["id"] . ");' style='text-align:left;padding:4px 0px 4px 0px;'>". $row["name_en"] ."</strong>";
                            }
                        //prix
                            $plitted = explode(".",$row["price"]);
                            $whole = $plitted[0]??$row["price"];
                            $fraction = $plitted[1]??0; 
                            if ($fraction == 0){
                                $fraction = "00";
                            }else{
                                $fraction = str_pad(rtrim($fraction, "0"), 2 , "0");
                            }
                            echo "<br><strong>". number_format($whole) . ".<sup>" . $fraction . "</sup></strong></td>";
                        //actions
                            echo "<td style='text-align:right;'>";
                                if($USER_LANG == "FR"){
                                    echo "<button onclick=\"buyAD('" . $row["id"]  . "');\" style='min-height:50px;margin-left:0px;padding:7px;' class='green'><span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span><br><span>Ajouter au panier</span></button>";
                                } else {
                                    echo "<button onclick=\"buyAD('" . $row["id"]  . "');\" style='min-height:50px;margin-left:0px;padding:7px;' class='green'><span class='material-icons' style='font-size:24px;vertical-align:middle;'>shopping_cart_checkout</span><br><span>Add to cart</span></button>";
                                }                       
                        echo "</td></tr>";
                        //description
                        if($USER_LANG == "FR"){
                            echo "<tr><td colspan='3' style='text-align:left;' onclick='getAD(". $row["id"] . ");' width='*'>". $row["description_fr"] ."</td></tr>";
                        }else {
                            echo "<tr><td colspan='3' style='text-align:left;' onclick='getAD(". $row["id"] . ");' width='*'>". $row["description_en"] ."</td></tr>";
                        }
                        echo "</table>";
            }
            echo "</div>";
            echo "<br><div class='dw3_box' style='min-height:0px;width:auto;text-align:center;background:rgba(255,255,255,0.8);color:black;'>";
            //FIRST PAGE
            if ($OFFSET > 0){
               echo "<button class='no-effect' onclick='getADS(\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
            } else {
               echo "<button class='no-effect' disabled style='background:#777;color:#DDD;'><span class='material-icons'>first_page</span></button>";
            }
            //PREVIOUS PAGE
            if ($OFFSET > 0){
                $page = $OFFSET-$LIMIT;
                if ($page<0){$page=0;}
               echo "<button class='no-effect' onclick='getADS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
            } else {
               echo "<button class='no-effect' disabled style='background:#777;color:#DDD;'><span class='material-icons'>navigate_before</span></button>";
            }
            //CURRENT PAGE
           echo "<span style='font-size:13px;margin:7px;'><b style='font-size:12px;'>" . ceil(($OFFSET/$LIMIT)+1) 
            . "</b>/<b>" . ceil($numrows/$LIMIT)
            . "</b></span>";
            //NEXTPAGE
            if (($OFFSET+$LIMIT) < ($numrows)){
                $page = $OFFSET+$LIMIT;
               echo "<button class='no-effect' onclick='getADS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
            } else {
               echo "<button class='no-effect' disabled style='background:#777;color:#DDD;'><span class='material-icons'>navigate_next</span></button>";
            }
            //LASTPAGE
            if (($OFFSET+$LIMIT) < ($numrows)){
                $lastpage = $numrows-$LIMIT;
               echo "<button class='no-effect' onclick='getADS(\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
            } else {
               echo "<button class='no-effect' disabled style='background:#777;color:#DDD;'><span class='material-icons'>last_page</span></button>";
            }
            echo "</div>";
        } else {
            echo "<div class='dw3_box' style='font-size:14px;min-height:0px;background:rgba(255,255,255,0.8);color:black;text-align:center;'>"; 
            if ($USER_LANG == "FR"){ 
                if (trim($FIND) != ""){ 
                    echo "Aucunes annonces trouvées selon la recherche.";
                }else{
                    echo "Aucunes annonces trouvées pour le moment.";}
             }else{
                if (trim($FIND) != ""){
                    echo "No adds found with this research.";
                } else {
                    echo "No adds found for the moment.";
                }
            } 
            echo "</div><br>";            
            //echo "<h3 style='text-align:left;padding:10px;color:vertical-align:middle;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";cursor:pointer;' onclick='history.back()'> <- <u>"; if ($USER_LANG == "FR"){echo "Retour";} else {echo "Return";} echo "</u></h3>";
        }

    ?>
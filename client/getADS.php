<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$FIND = strtolower($_GET['SS']);
$OFFSET  = $_GET['OFFSET'];
$LIMIT  = $_GET['LIMIT'];
if ($OFFSET == ""){
	$OFFSET = "0";	
}
if ($LIMIT == "" || $LIMIT == "0"){
	$LIMIT = "5";	
}

//ROW COUNT
$sql = "SELECT COUNT(*) as rowCount FROM classified A LEFT JOIN (SELECT id,name_fr FROM product_category) B ON A.category_id = B.id WHERE customer_id ='" . $USER . "' ";
if (trim($FIND) != ""){
    $sql .= " AND LOWER(CONCAT(A.name_fr,B.name_fr,name_en,description_fr,model,brand,year_production)) LIKE '%".$FIND."%' ";
}
$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$numrows = $data['rowCount'];

//ROW DSP
$sql = "SELECT A.*, B.name_fr AS category_name FROM classified A LEFT JOIN (SELECT id,name_fr FROM product_category) B ON A.category_id = B.id  WHERE customer_id ='" . $USER . "' "; 
if (trim($FIND) != ""){
    $sql .= " AND LOWER(CONCAT(A.name_fr,B.name_fr,name_en,description_fr,model,brand,year_production)) LIKE '%".$FIND."%' ";
}
if ($USER_LANG == "FR"){
    $sql .= " ORDER BY name_fr ASC ";
} else {
    $sql .= " ORDER BY name_en ASC ";
}
$sql = $sql . " LIMIT " . $LIMIT . " OFFSET " . $OFFSET . ";";

$result = $dw3_conn->query($sql);
$QTY_ROWS = $result->num_rows??0;
if ($QTY_ROWS > 0) {
    if ($numrows ==1) {
        echo "<div class='divBOX' style='font-size:14px;min-height:0px;background:rgba(255,255,255,0.8);color:black;text-align:center;'>"; if ($USER_LANG == "FR"){ echo "Une annonce trouvée selon la recherche."; }else{echo "One ad found with this research.";} echo "</div><br>";            
    }else {
        echo "<div class='divBOX' style='font-size:14px;min-height:0px;background:rgba(255,255,255,0.8);color:black;text-align:center;'>"; if ($USER_LANG == "FR"){ echo $numrows." annonces trouvées selon la recherche."; }else{echo $numrows." ads found with this research.";} echo "</div><br>";            
    }
    while($row = $result->fetch_assoc()) {
        $RNDSEQ=rand(100,100000);
        $filename= $row["img_link"];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $USER . "/" . $filename)){
            $filename = "/pub/img/dw3/nd.png";
        } else {
            if (!is_file($_SERVER['DOCUMENT_ROOT'] ."/fs/customer/" . $USER . "/" . $filename)){
                $filename = "/pub/img/dw3/nd.png";
            } else {
                $filename = "/fs/customer/" . $USER . "/" . $filename;
            }
        }
        if ($row['active'] == "0" || floatval($row['qty_available']) <= 0){$row_color = "red";} else {$row_color = "green";}
        $desc_fr = $row['description_fr'];
        if (strlen($row['description_fr']) > 100){
            $desc_fr = substr($row['description_fr'],0,100)."..";   
        }
        $year_prod = $row['year_production'];
        if ($row['year_production'] == "0"){
            $year_prod = "";
        }
        echo "<div style='font-size:13px;text-align:center;cursor:pointer;font-family:var(--dw3_form_font);display:inline-block;width:100%;max-width:800px;background:rgba(255,255,255,0.95);margin:1px 0px;border-radius:7px;box-shadow: inset 0px 0px 5px ".$row_color.";'>
            <table style='margin: 0 auto;table-layout: fixed;width:100%;max-width:100%;margin-left:auto;margin-right:auto;'>
            <tr>
            <td onclick='openAD(".$row['id'].")' style='width:100px;vertical-align:top;'><img src='".$filename."?t=" . rand(100,100000)."' style='height:100px;width:100px;'></td>
            <td onclick='openAD(".$row['id'].")' width='*' style='white-space: wrap;text-align:left;padding:5px;vertical-align:top;'><b>".number_format($row['price'],2,"."," ")."$ </b><br><b>".$row['name_fr']."</b><br>".$row['brand']." <b>".$row['model']."</b> ".$year_prod."<br>".$desc_fr."</td>
            <td style='width:200px;'><b>".$row["category_name"]."</b><br><div style='font-size:11px;'>Quantité disponible</div>
            <button style='padding:5px 10px;' onclick=\"minusAdDispo('".$row["id"] ."')\">-1</button> <input oninput='setAdDispo(".$row["id"] .")' type='number' style='vertical-align:middle;width:50px;background:#ddd;padding:7px;' id='AdDispo_".$row["id"] ."' value='".round($row["qty_available"]) ."'> <button style='padding:5px 10px;' onclick=\"plusAdDispo('".$row["id"] ."')\">+1</button></td>
            </tr></table>
            </div><br>";
    } 
    echo "<div class='divBOX' style='min-height:0px;width:auto;text-align:center;background:rgba(255,255,255,0.8);color:black;'>";
    //FIRST PAGE
    if ($OFFSET > 0){
       echo "<button onclick='getADS(\"\",\"" . $LIMIT . "\");'><span class='material-icons'>first_page</span></button>";
    } else {
       echo "<button disabled style='background:#777;color:#DDD;'><span class='material-icons'>first_page</span></button>";
    }
    //PREVIOUS PAGE
    if ($OFFSET > 0){
        $page = $OFFSET-$LIMIT;
        if ($page<0){$page=0;}
       echo "<button onclick='getADS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_before</span></button>";
    } else {
       echo "<button disabled style='background:#777;color:#DDD;'><span class='material-icons'>navigate_before</span></button>";
    }
    //CURRENT PAGE
   echo "<span style='font-size:10px;'><b style='font-size:12px;'>" . ceil(($OFFSET/$LIMIT)+1) 
    . "</b>/<b>" . ceil($numrows/$LIMIT)
    . "</b></span>";
    //NEXTPAGE
    if (($OFFSET+$LIMIT) < ($numrows)){
        $page = $OFFSET+$LIMIT;
       echo "<button onclick='getADS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='material-icons'>navigate_next</span></button>";
    } else {
       echo "<button disabled style='background:#777;color:#DDD;'><span class='material-icons'>navigate_next</span></button>";
    }
    //LASTPAGE
    if (($OFFSET+$LIMIT) < ($numrows)){
        $lastpage = $numrows-$LIMIT;
       echo "<button onclick='getADS(\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='material-icons'>last_page</span></button>";
    } else {
       echo "<button disabled style='background:#777;color:#DDD;'><span class='material-icons'>last_page</span></button>";
    }
    echo "</div>";
}else{
    //echo $sql; 
    //echo "Aucune annonce trouvée selon la recherche.";
    echo "<div class='divBOX' style='font-size:14px;min-height:0px;background:rgba(255,255,255,0.8);color:black;text-align:center;'>"; if ($USER_LANG == "FR"){ echo "Aucune annonce trouvée selon la recherche."; }else{echo "No ad found with this research.";} echo "</div>";            

}
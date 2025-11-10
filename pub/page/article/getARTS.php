<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader_min.php';
$FIND = strtolower($_GET['SS']);
$CAT = strtolower($_GET['CAT']);
$OFFSET  = $_GET['OFFSET'];
$LIMIT  = $_GET['LIMIT'];
if ($OFFSET == ""){
	$OFFSET = "0";	
}
if ($LIMIT == "" || $LIMIT == "0"){
	$LIMIT = "10";	
}

//ROW COUNT
$sql = "SELECT COUNT(*) as rowCount FROM article WHERE is_active = '1'";
if (trim($FIND) != ""){ 
    if ($USER_LANG == "FR") {
        $sql .= " AND LCASE(CONCAT(title_fr,description_fr,author_name)) LIKE '%".$FIND."%' ";
    } else {
        $sql .= " AND LCASE(CONCAT(title_en,description_en,author_name)) LIKE '%".$FIND."%' ";
    }
}
if (trim($CAT) != ""){ 
    if ($USER_LANG == "FR") {
        $sql .= " AND LCASE(category_fr) = '".$CAT."' ";
    } else {
        $sql .= " AND LCASE(category_en) = '".$CAT."' ";
    }
}

$result = mysqli_query($dw3_conn, $sql);
$data = mysqli_fetch_assoc($result);
$numrows = $data['rowCount'];

//GET ARTS
$sql = "SELECT * FROM article WHERE is_active = '1'";
if (trim($FIND) != ""){ 
    if ($USER_LANG == "FR") {
        $sql .= " AND LCASE(CONCAT(title_fr,description_fr,author_name)) LIKE '%".$FIND."%' ";
    } else {
        $sql .= " AND LCASE(CONCAT(title_en,description_en,author_name)) LIKE '%".$FIND."%' ";
    }
}  
if (trim($CAT) != ""){ 
     if ($USER_LANG == "FR") {
        $sql .= " AND LCASE(category_fr) = '".$CAT."' ";
    } else {
        $sql .= " AND LCASE(category_en) = '".$CAT."' ";
    }
}
$sql .= " ORDER BY date_created DESC";
$sql = $sql . " LIMIT " . $LIMIT . " OFFSET " . $OFFSET . ";";
$result = $dw3_conn->query($sql);
if ($result->num_rows > 0) {
    echo "<div style='width:100%;text-align:center;'>";
    while($row = $result->fetch_assoc()) {
        if ($USER_LANG == "FR" || $USER_LANG == "fr") {
            echo "<div onclick='openART(".$row["id"].")' class='dw3_article'>
                    <div style=\"border-radius:10px 10px 0px 0px;width:335px;height:335px;overflow:hidden;\">
                        <div style=\"border-radius:10px 10px 0px 0px;width:335px;height:335px;background-image:url('/pub/upload/".$row["img_link"]."');background-size:cover;background-repeat:no-repeat;background-position:center center;\"> 
                        </div>
                    </div>
                    <section'>
                        <h3 style='padding:10px 10px 5px 10px;text-align:left;min-height:40px;'>".$row["title_fr"]."</h3>
                        <span style='width:95%;height:35px;overflow:hidden;text-align:left;'>".substr($row["description_fr"],0,100)."..</span><br>
                        <span style='float:left;color:white;background:#555;border-radius:10px;padding:5px 8px;margin:5px;font-size:14px;'>".$row["category_fr"]."</span>
                        <p style='padding:10px;float:right;color:#777;'>".substr($row["date_created"],0,10)."</p>
                    </section>
                </div>";
        }else{
            echo "<div onclick='openART(".$row["id"].")' class='dw3_article'>
                    <div style=\"border-radius:10px 10px 0px 0px;width:335px;height:335px;overflow:hidden;\">
                        <div style=\"border-radius:10px 10px 0px 0px;width:335px;height:335px;background-image:url('/pub/upload/".$row["img_link"]."');background-size:cover;background-repeat:no-repeat;background-position:center center;\">
                        </div>
                    </div>
                    <section>
                        <h3 style='padding:10px 10px 5px 10px;text-align:left;min-height:40px;'>".$row["title_en"]."</h3>
                        <span style='width:95%;height:35px;overflow:hidden;text-align:left;'>".substr($row["description_en"],0,100)."..</span><br>
                        <span style='float:left;color:white;background:#555;border-radius:10px;padding:5px 8px;margin:5px;font-size:14px;'>".$row["category_en"]."</span>
                        <p style='padding:10px;float:right;color:#777;'>".substr($row["date_created"],0,10)."</p>
                    </section>
                </div>";
        }
    }
    echo "</div>";
    echo "<div style='margin:10px 0px 0px 0px;min-height:0px;width:auto;text-align:center;background:rgba(255,255,255,0.8);color:black;'>";
    //FIRST PAGE
    if ($OFFSET > 0){
    echo "<button class='no-effect' style='font-size:20px;' onclick='getARTS(\"\",\"" . $LIMIT . "\");'><span class='dw3_font'>ļ</span></button>";
    } else {
    echo "<button class='no-effect' style='font-size:20px;' disabled style='background:#777;color:#DDD;'><span class='dw3_font'>ļ</span></button>";
    }
    //PREVIOUS PAGE
    if ($OFFSET > 0){
        $page = $OFFSET-$LIMIT;
        if ($page<0){$page=0;}
    echo "<button class='no-effect green' style='font-size:20px;' onclick='getARTS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='dw3_font'>ĸ</span></button>";
    } else {
    echo "<button class='no-effect' style='font-size:20px;' disabled style='background:#777;color:#DDD;'><span class='dw3_font'>ĸ</span></button>";
    }
    //CURRENT PAGE
    echo "<span style='font-size:10px;margin:7px;'><b style='font-size:14px;'>" . ceil(($OFFSET/$LIMIT)+1) 
    . "</b>/<b>" . ceil($numrows/$LIMIT)
    . "</b></span>";
    //NEXTPAGE
    if (($OFFSET+$LIMIT) < ($numrows)){
        $page = $OFFSET+$LIMIT;
    echo "<button class='no-effect green' style='font-size:20px;' onclick='getARTS(\"". $page ."\",\"" . $LIMIT . "\");'><span class='dw3_font'>Ĺ</span></button>";
    } else {
    echo "<button class='no-effect' style='font-size:20px;' disabled style='background:#777;color:#DDD;'><span class='dw3_font'>Ĺ</span></button>";
    }
    //LASTPAGE
    if (($OFFSET+$LIMIT) < ($numrows)){
        $lastpage = $numrows-$LIMIT;
    echo "<button class='no-effect' style='font-size:20px;' onclick='getARTS(\"". $lastpage ."\",\"" . $LIMIT . "\");'><span class='dw3_font'>Ľ</span></button>";
    } else {
    echo "<button class='no-effect' style='font-size:20px;' disabled style='background:#777;color:#DDD;'><span class='dw3_font'>Ľ</span></button>";
    }
    echo "</div>";
} else {
    if ($USER_LANG == "FR"){
        echo "<div class='dw3_box' style='text-align:center;min-height:0px;padding:30px 0px;margin:30px 0px 220px 0px;'>Aucun article trouvé selon la recherche.</div>";
    } else {
        echo "<div class='dw3_box' style='text-align:center;min-height:0px;padding:30px 0px;margin:30px 0px 220px 0px;'>No news found according to search.</div>";
    }
}
?>
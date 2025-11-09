<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/client/security_db.php'; 
$FIND = strtolower($_GET['SS']);

$sql = "SELECT A.*, B.name_fr AS category_name FROM classified A LEFT JOIN (SELECT id,name_fr FROM product_category) B ON A.category_id = B.id  WHERE customer_id ='" . $USER . "' "; 
if (trim($FIND) != ""){
    $sql .= " AND LOWER(CONCAT(A.name_fr,B.name_fr,name_en,description_fr,model,brand,year_production)) LIKE '%".$FIND."%' ";
}
if ($USER_LANG == "FR"){
    $sql .= " ORDER BY name_fr ASC;";
} else {
    $sql .= " ORDER BY name_en ASC;";
}

$result = $dw3_conn->query($sql);
$QTY_ROWS = $result->num_rows??0;
if ($QTY_ROWS > 0) {
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
        if ($row['active'] == "1"){$row_color = "green";} else {$row_color = "red";}
        $desc_fr = $row['description_fr'];
        if (strlen($row['description_fr']) > 100){
            $desc_fr = substr($row['description_fr'],0,100)."..";   
        }
        $year_prod = $row['year_production'];
        if ($row['year_production'] == "0"){
            $year_prod = "";
        }
        echo "<div onclick='openADD(".$row['id'].")' style='text-align:center;cursor:pointer;font-family:var(--dw3_form_font);display:inline-block;width:100%;max-width:800px;background:rgba(255,255,255,0.95);margin:7px 0px;border-radius:7px;box-shadow: inset 0px 0px 5px ".$row_color.";'>
            <table style='margin: 0 auto;table-layout: fixed;width:100%;max-width:100%;margin-left:auto;margin-right:auto;'><tr><td style='width:100px;vertical-align:top;'><img src='".$filename."' style='height:100px;width:100px;'><br><b>".number_format($row['price'],2,"."," ")."$ </b> </td><td width='*' style='white-space: wrap;text-align:left;padding:5px;vertical-align:top;'><b>".$row['name_fr']."</b><br>".$row['brand']." <b>".$row['model']."</b> ".$year_prod."<br>".$desc_fr."</td><td style='width:200px;'>".$row["category_name"]."</td></tr></table>
            </div><br>";
    } 
}else{
    //echo $sql; 
    echo "Aucune annonce trouvée selon la recherche.";
}
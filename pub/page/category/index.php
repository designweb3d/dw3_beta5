<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/sbin/loader.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/header_main.php';
require_once $_SERVER['DOCUMENT_ROOT'] . $PAGE_HEADER;
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/common_div.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/js/Multiavatar.php';

if ($PAGE_HEADER== '/pub/section/header0.php'){$INDEX_HEADER_HEIGHT = '0';}
else if ($PAGE_HEADER== '/pub/section/header1.php'){$INDEX_HEADER_HEIGHT = '50';}
else if ($PAGE_HEADER== '/pub/section/header2.php'){$INDEX_HEADER_HEIGHT = '20';}
else if ($PAGE_HEADER== '/pub/section/header3.php'){$INDEX_HEADER_HEIGHT = '30';}
else {$INDEX_HEADER_HEIGHT='50';}

if($USER_LANG == "FR"){
    echo ($PAGE_HTML_FR);
} else {
    echo ($PAGE_HTML_EN);
}

echo "<div style='min-height:70vh;'>";
//sous-categories
if (trim(strtolower($cat_lst)) != "promo" && trim(strtolower($cat_lst)) != "all"){
    $sql = "SELECT A.*, IFNULL(C.id,-1) as parent_id, IFNULL(C.name_fr,'Retour') as parent_name, IFNULL(C.name_en,'Return') as parent_name_en, IFNULL(B.name_fr,'') as child_name, IFNULL(B.name_en,'') as child_name_en FROM product_category A
    LEFT JOIN (SELECT id, name_fr,name_en,parent_name FROM product_category) B ON A.parent_name = B.name_fr
    LEFT JOIN (SELECT id, name_fr,name_en FROM product_category) C ON B.parent_name = C.name_fr
    WHERE web_dsp = 1 ";
    if ($cat_lst != "") {
        $sql .= " AND B.id IN (".$cat_lst.") ";
    } else {
        $sql .= " AND A.parent_name = '' "; 
    }
    $cat_name = "";
    $sql.="ORDER BY name_fr ASC ";

    $result = $dw3_conn->query($sql);
    if ($result->num_rows > 0) {
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
                    if ($row["parent_name"] != "" && $cat_name != $row["parent_name"]){
                        if ($row["parent_id"] == "-1"){
                            if ($row["child_name"] !=""){
                                echo "<h3 style='text-align:left;padding:10px;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";vertical-align:middle;'><span style='cursor:pointer;vertical-align:middle;' onclick='history.back()'><u style='vertical-align:middle;padding:0px 5px;'> <span class='material-icons'>skip_previous</span> </u></span><span style='vertical-align:middle;padding:0px 10px;'>".$trad_child ."</span></h3>";
                            }else{
                                echo "<h3 style='text-align:left;padding:10px;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";vertical-align:middle;'><span style='cursor:pointer;vertical-align:middle;' onclick='history.back()'><u style='vertical-align:middle;'> ".$trad_parent."</u></span></h3>";
                            }
                        } else {
                            echo "<h3 style='text-align:left;padding:10px;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";vertical-align:middle;cursor:pointer;' onclick='history.back()'><u style='vertical-align:middle;color:#".$CIE_COLOR7.";background-color:#".$CIE_COLOR6.";'>".$trad_parent."</u></h3>";
                        }
                    }
                    //echo "before row cn:".$row["name_fr"]."var cn:".$cat_name."<hr>";
                    $cat_name = $row["parent_name"];
                    //echo "before row cn:".$row["name_fr"]."var cn:".$cat_name."<hr>";

                     echo "<div style='background:#f0f0f0;color:#333;border:1px solid #444;margin:5px; max-width:170px;width:170px;display:inline-block;height:250;border-radius:12px;'>
                     <table class='hoverShadow' style='border-collapse: collapse;border:0px;width:100%;min-height:100%;margin-right:auto;margin-left:auto;display:inline-block;border-radius:10px;'>";
                 //image                           
                      echo "<tr style='padding:0px;border:0px;' onclick='getPRDS(". $row["id"] . ");'>"
                            . "<td colspan=2 style='border-top-right-radius:10px;border-top-left-radius:10px;cursor:pointer;text-align:center;padding:0px 0px 0px 0px;'><div style=\"border-top-right-radius:10px;border-top-left-radius:10px;width:170px;height:170px;background-image:url('".$filename."?t=" . $RNDSEQ . "');background-position: bottom center;background-repeat: no-repeat;background-size:cover;\"> </div></td></tr>";
                
                 //description    
                 if($USER_LANG == "FR"){         
                      echo "<tr style='padding:0px;border:0px;' onclick='getPRDS(". $row["id"] . ");'>"
                            . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;height:70px;width:170px;font-size:16px;'>". $row["name_fr"] . "</td></tr>";
                 }else {
                    echo "<tr style='padding:0px;border:0px;' onclick='getPRDS(". $row["id"] . ");'>"
                    . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;height:70px;width:170px;font-size:16px;'>". $row["name_en"] . "</td></tr>";
                }
                 
                 echo "</table></div>";
             }
         } else {
             //echo "Aucune catégorie trouvée pour le moment.";
             //echo $sql;
         }
}
echo "</div>";
?>
<script>
$(document).ready(function (){
    document.getElementById("dw3_body").innerHTML = "";
    bREADY = true;
});
</script>
<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . $INDEX_FOOTER;
    exit; 
?>
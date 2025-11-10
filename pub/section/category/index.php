<?php 
/* $SID = $_GET['SID']??'';
header("SECTION_ID:".$_SERVER['HTTP_SECTION_ID']);
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/loader.min.php';
$cat_lst = trim(mysqli_real_escape_string($dw3_conn,$_GET['P1'])); */
if 	($SECTION_IMG_DSP=="gradiant"){$bg_gradiant = "background-image:".$SECTION_IMG.";";} else {$bg_gradiant = "";}
if 	($SECTION_FONT!=""){$font_family = "font-family:".$SECTION_FONT.";";} else {$font_family = "";}
echo "<div style='background-color:".$SECTION_BG.";color:". $SECTION_FG.";width:100%;text-align:center;margin:". $SECTION_MARGIN.";display:inline-block;text-align:center;height:auto;border-radius:". $SECTION_RADIUS.";max-width:". $SECTION_MAXW.";box-shadow:". $SECTION_SHADOW.";".$bg_gradiant.$font_family."'>";
//img
   $sql = "SELECT * FROM product_category WHERE web_dsp = 1 ";
   if ($cat_lst != "") {
    $sql .= " AND parent_name = '".$cat_lst."' ";
   } else {
    $sql .= " AND parent_name = '' ";
   }
   if ($USER_LANG=="FR"){
    $sql.="ORDER BY name_fr ASC ";
   }else{
    $sql.="ORDER BY name_en ASC ";
   }

        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
            //title
            if ($SECTION_TITLE_DSP!="none" && $SECTION_TITLE_DSP!=""){
                if($USER_LANG == "FR"){
                    echo "<h2 style='text-align:".$SECTION_TITLE_DSP.";'>".$SECTION_TITLE."</h2>";
                } else {
                    echo "<h2 style='text-align:".$SECTION_TITLE_DSP.";'>".$SECTION_TITLE_EN."</h2>";
                }
            }
            while($row = $result->fetch_assoc()) {
                $RNDSEQ=rand(100,100000);
                    $filename= $row["img_url"];
                    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $filename)){
                        $filename = "/pub/img/dw3/nd.png";
                    } else {
                        if (!is_file($_SERVER['DOCUMENT_ROOT'] . $filename)){
                            $filename = "/pub/img/dw3/nd.png";
                        }
                    }
                    
                    echo "<div style='border:1px solid #444;margin:5px; max-width:170px;width:170px;display:inline-block;height:250;border-radius:12px;background:rgba(255,255,255,1);color:#222;'>
                            <table class='hoverShadow' style='line-height:1;border-collapse: collapse;border:0px;width:100%;min-height:100%;margin-right:auto;margin-left:auto;display:inline-block;border-radius:10px;'>";
                        //image                           
                             echo "<tr style='padding:0px;border:0px;' onclick='getPRDS(". $row["id"] . ");'>"
                                   . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;'><div style=\"border-top-right-radius:10px;border-top-left-radius:10px;width:170px;height:170px;background-image:url('".$filename."?t=" . $RNDSEQ . "');background-position: bottom center;background-repeat: no-repeat;background-size:cover;\"> </div></td></tr>";
                       
                        //description                           
                             echo "<tr style='padding:0px;border:0px;' onclick='getPRDS(". $row["id"] . ");'>";
                             if ($USER_LANG=="FR"){
                                echo "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;height:75px;width:170px;font-size:16px;'>". $row["name_fr"] . "</td></tr>";
                             } else {
                                echo "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;height:75px;width:170px;font-size:16px;'>". $row["name_en"] . "</td></tr>";
                             }
                       
                        
                        echo "</table></div>";
                }
            } else {
                //echo "Aucune catégorie trouvée pour le moment.";
            }
    if($USER_LANG == "FR"){
        echo ($SECTION_HTML_FR . "</div></div>");
    }else{
        echo ($SECTION_HTML_EN . "</div></div>");
    }
?>
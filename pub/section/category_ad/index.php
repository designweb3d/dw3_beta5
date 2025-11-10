<?php 
/* $SID = $_GET['SID']??'';
header("SECTION_ID:".$_SERVER['HTTP_SECTION_ID']);
require_once $_SERVER['DOCUMENT_ROOT'] . '/pub/section/loader.min.php';
$cat_lst = trim(mysqli_real_escape_string($dw3_conn,$_GET['P1'])); */

   $sql = "SELECT * FROM product_category WHERE web_dsp = 1 ";
   if ($cat_lst != "") {
    $sql .= " AND parent_name = '".$cat_lst."' ";
   } else {
    $sql .= " AND parent_name = '' ";
   }
   if ($USER_LANG=="FR"){
    $sql.="ORDER BY REPLACE(REPLACE(REPLACE(name_fr,'à','a'),'é','e'),'É','E') ASC ";
   }else{
    $sql.="ORDER BY name_en ASC ";
   }
   echo "<div style='max-width:600px;display:inline-block;'><input style='margin:15px 0px 10px 0px;' type='search' class='inputRECH' id='rechAD' oninput=\"findADS(0,20)\"></div><br>";
   echo "<div id='divCLASSIFIEDS'>";
   echo "</div>";
        $result = $dw3_conn->query($sql);
        if ($result->num_rows > 0) {
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
                    
                    echo "<div style='border:1px solid #444;margin:15px 5px; max-width:170px;width:170px;display:inline-block;height:250;border-radius:10px;background:rgba(255,255,255,0.9);color:#222;'>
                            <table class='hoverShadow' style='border-collapse: collapse;border:0px;width:100%;min-height:100%;margin-right:auto;margin-left:auto;display:inline-block;border-radius:10px;'>";
                        //image                           
                             echo "<tr style='padding:0px;border:0px;' onclick='getADS(". $row["id"] . ");'>"
                                   . "<td colspan=2 style='cursor:pointer;text-align:center;padding:0px 0px 0px 0px;'><div style=\"border-top-right-radius:10px;border-top-left-radius:10px;width:170px;height:170px;background-image:url('".$filename."?t=" . $RNDSEQ . "');background-position: bottom center;background-repeat: no-repeat;background-size:cover;\"> </div></td></tr>";
                       
                        //description                           
                             echo "<tr style='padding:0px;border:0px;' onclick='getADS(". $row["id"] . ");'>";
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
        //echo $sql;
    ?>
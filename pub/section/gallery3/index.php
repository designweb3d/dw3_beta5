<?php 
    if 	($SECTION_IMG_DSP=="gradiant"){$bg_gradiant = "background-image:".$SECTION_IMG.";";} else {$bg_gradiant = "";}
    if 	($SECTION_FONT!=""){$font_family = "font-family:".$SECTION_FONT.";";} else {$font_family = "";}
?>
    <?php 
    echo "<div style='background-color:".$SECTION_BG.";color:". $SECTION_FG.";width:100%;text-align:center;line-height:1;margin:". $SECTION_MARGIN.";display:inline-block;text-align:center;height:auto;border-radius:". $SECTION_RADIUS.";max-width:". $SECTION_MAXW.";box-shadow:". $SECTION_SHADOW.";".$bg_gradiant.$font_family."'>";
        if ($SECTION_TITLE_DSP!="none" && $SECTION_TITLE_DSP!=""){
            echo "<h2 style='text-align:".$SECTION_TITLE_DSP.";text-shadow:0px 0px 2px white;margin-top:-15px;'>".$SECTION_TITLE."</h2>";
            
        }
        if ($USER_LANG == "FR"){
          echo $SECTION_HTML_FR . "<br>" ;
        } else {
          echo $SECTION_HTML_EN . "<br>" ;
        } 
      $dw3_sql = "SELECT * FROM slideshow WHERE index_id='".$SECTION_ID."' ORDER BY sort_by ASC";
      $dw3_result = $dw3_conn->query($dw3_sql);
          if ($dw3_result->num_rows > 0) {
              while($row = $dw3_result->fetch_assoc()) {
                echo "<div style=\"border:1px solid #dddddd;width:300px;background:white;height:300px;overflow:hidden;display:inline-block;margin:5px;border-radius: 6px;background-size:cover;background-repeat: no-repeat;background-position: center center;background-image: url('".$row["media_link"]."');\">";
                  if (trim($row["media_url"]) !=""){
                    echo "<a href='".trim($row["media_url"])."' target='_blank'>";
                  }
                    if ($USER_LANG == "FR"){
                        if (trim($row["name_fr"]) != ""){
                            echo "<span style='z-index:+1;text-align:center;font-size:15px;border-top-right-radius: 5px;border-top-left-radius: 5px;padding:5px;position:absolute;min-height:25px;width:290px;color:#ddd;text-shadow:0px 0px 3px white;background:rgba(0,0,0);'>".$row["name_fr"]."</span>";
                        }
                      echo "<img class='gal2_img' id='gal2_img".$row["id"]."' src='".$row["media_link"]."' alt='".$row["name_fr"]."' onclick='dw3_gal2_show(this)'>;";
                    } else {
                        if (trim($row["name_en"]) != ""){
                            echo "<span style='z-index:+1;text-align:center;font-size:15px;border-top-right-radius: 5px;border-top-left-radius: 5px;padding:5px;position:absolute;min-height:25px;width:290px;left:0px;color:#ddd;text-shadow:0px 0px 3px white;background:rgba(0,0,0);'>".$row["name_en"]."</span>";
                        }
                      echo "<img class='gal2_img' id='gal2_img".$row["id"]."' src='".$row["media_link"]."' alt='".$row["name_en"]."' onclick='dw3_gal2_show(this)'>;";
                    }
                  if (trim($row["media_url"]) !=""){
                    echo "</a>";
                  }
                echo "</div>";
              }
          }
      ?> 
</div>
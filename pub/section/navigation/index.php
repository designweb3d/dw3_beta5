<?php 
    //img center
    if ($SECTION_IMG_DSP == "header"){
        echo "<img src='/pub/upload/".$SECTION_IMG."' style='border-top-right-radius:".$SECTION_RADIUS.";border-top-left-radius:".$SECTION_RADIUS.";width:100%;height:auto;'>";
        echo "<div style='margin-top:-1px;display:inline-block;text-align:center;width:100%;height:auto;max-width:100%;line-height:1.5em;border-bottom-left-radius:".$SECTION_RADIUS.";border-bottom-right-radius:".$SECTION_RADIUS.";'>";
    } else {
        echo "<div style='margin-top:-1px;display:inline-block;text-align:center;width:100%;height:auto;max-width:100%;line-height:1.5em;border-radius:". $SECTION_RADIUS .";'>";
    }

    //title
    if ($SECTION_TITLE_DSP!="none" && $SECTION_TITLE_DSP!=""){
        if($USER_LANG == "FR"){
            echo "<h2 style='text-align:".$SECTION_TITLE_DSP.";text-shadow:0px 0px 2px white;'>".$SECTION_TITLE."</h2>";
        } else {
            echo "<h2 style='text-align:".$SECTION_TITLE_DSP.";text-shadow:0px 0px 2px white;'>".$SECTION_TITLE_EN."</h2>";
        }
    }

    //html
    echo "<div style='display:block;width:100%;color:#888;'>";
    if($USER_LANG == "FR"){
        echo $SECTION_HTML_FR . "</div><br>";
    }else{
        echo $SECTION_HTML_EN . "</div><br>";
    }

    //img float
    if ($SECTION_IMG_DSP=="floatLeft"){
        echo "<div style='display:inline-block;float:left;width:50%;'><img src='/pub/upload/".$SECTION_IMG."' style='width:99%;border-radius:5px;'></div>";
    }
    if ($SECTION_IMG_DSP=="floatRight"){
        echo "<div style='display:inline-block;float:right;width:50%;'><img src='/pub/upload/".$SECTION_IMG."' style='width:99%;border-radius:5px;'></div>";
    }

    echo "<div style='background-color:".$SECTION_BG.";text-align:center;margin:". $SECTION_MARGIN.";display:inline-block;text-align:center;height:auto;border-radius:". $SECTION_RADIUS.";max-width:". $SECTION_MAXW.";box-shadow:". $SECTION_SHADOW.";'>";
    $dw3_sql = "SELECT * FROM index_head WHERE target='page' AND parent_id=0 ORDER BY parent_id ASC, menu_order ASC";
    $dw3_result = $dw3_conn->query($dw3_sql);
        if ($dw3_result->num_rows > 0) {
            while($row = $dw3_result->fetch_assoc()) {
                if ($row["is_in_menu"] == "true"){
                    if ($row["target"] == "page"){
                        if($USER_LANG == "FR"){
                            echo "<div style='display:inline-block;padding:10px 15px;font-size:2.5vw;'><a href='".$row["url"]."?PID=".$row["id"]."&P1=".$row["cat_list"]."' style='color:#".$CIE_COLOR7.";font-weight:bold; text-shadow: 1px 1px 2px #222;text-align:center;'>".$row["title"]."</a></div>";
                        }else{
                            echo "<div style='display:inline-block;padding:10px 15px;font-size:2.5vw;'><a href='".$row["url"]."?PID=".$row["id"]."&P1=".$row["cat_list"]."' style='color:#".$CIE_COLOR7.";font-weight:bold; text-shadow: 1px 1px 2px #222;text-align:center;'>".$row["title_en"]."</a></div>";
                        }
                    }
                }
            }
        }
        echo "</div></div>";
?>
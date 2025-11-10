<?php 
    if 	($SECTION_IMG_DSP=="gradiant"){$bg_gradiant = "background-image:".$SECTION_IMG.";";} else {$bg_gradiant = "";}
    if 	($SECTION_FONT!=""){$font_family = "font-family:".$SECTION_FONT.";";} else {$font_family = "";}
    echo "<div style='background-color:".$SECTION_BG.";color:". $SECTION_FG.";width:100%;text-align:center;margin:". $SECTION_MARGIN.";display:inline-block;text-align:center;height:auto;border-radius:". $SECTION_RADIUS.";max-width:". $SECTION_MAXW.";box-shadow:". $SECTION_SHADOW.";".$bg_gradiant.$font_family."'>";
    //img
    if ($SECTION_IMG_DSP == "header"){
        echo "<img src='/pub/upload/".$SECTION_IMG."' style='border-top-right-radius:".$SECTION_RADIUS.";border-top-left-radius:".$SECTION_RADIUS.";width:100%;height:auto;'>";
        echo "<div style='text-align:center;width:100%;height:auto;max-width:100%;line-height:1.5em;border-bottom-left-radius:".$SECTION_RADIUS.";border-bottom-right-radius:".$SECTION_RADIUS.";'>";
    } else {
        if ($SECTION_IMG_DSP=="floatLeft"){
            echo "<div class='dw3_wide_view_parent' style='text-align:center;width:100%;height:auto;max-width:100%;line-height:1.5em;border-radius:". $SECTION_RADIUS .";align-items: center;'>";
        } else if ($SECTION_IMG_DSP=="floatRight"){
            echo "<div class='dw3_wide_view_parent' style='text-align:center;width:100%;height:auto;max-width:100%;line-height:1.5em;border-radius:". $SECTION_RADIUS .";align-items: center;flex-direction: row-reverse;'>";
        } else {
            echo "<div style='text-align:center;width:100%;height:auto;max-width:100%;line-height:1.5em;border-radius:". $SECTION_RADIUS .";'>";
        }
    }

    //title
    if ($SECTION_TITLE_DSP!="none" && $SECTION_TITLE_DSP!=""){
        if($USER_LANG == "FR"){
            echo "<h2 style='text-align:".$SECTION_TITLE_DSP.";text-shadow:0px 0px 2px white;margin-top:5px;'>".$SECTION_TITLE."</h2>";
        } else {
            echo "<h2 style='text-align:".$SECTION_TITLE_DSP.";text-shadow:0px 0px 2px white;margin-top:5px;'>".$SECTION_TITLE_EN."</h2>";
        }
    }

    //user html
/*     if ($SECTION_IMG_DSP=="floatLeft" || $SECTION_IMG_DSP=="floatRight"){
        echo "<div class='dw3_wide_view_div' style='display:inline-block;vertical-align:middle;'><img src='/pub/upload/".$SECTION_IMG."' style='width:100%;border-radius:". $SECTION_RADIUS .";'></div>";
        if($USER_LANG == "FR"){
            echo "<div class='dw3_wide_view_div' style='display:inline-block;vertical-align:middle;'>" . $SECTION_HTML_FR . "</div>";
        }else{
            echo "<div class='dw3_wide_view_div' style='display:inline-block;vertical-align:middle;'>" . $SECTION_HTML_EN . "</div>";
        }
    } else {
        if($USER_LANG == "FR"){
            echo "<div style='display:block;'>" . $SECTION_HTML_FR . "</div>";
        }else{
            echo "<div style='display:block;'>" . $SECTION_HTML_EN . "</div>";
        }
    } */

    $sql = "SELECT * FROM index_line WHERE head_id = '".$SID."' ORDER BY sort_order ASC;";
    $result = $dw3_conn->query($sql);
    $html = "";
    $row_num = 0;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($USER_LANG == "FR"){
                echo "<div class='dw3_wide_view_div'>".$row["html_fr"]."</div>";
            } else {
                echo "<div class='dw3_wide_view_div'>".$row["html_en"]."</div>";
            }
        }
    }

    echo  "</div></div>";
?>